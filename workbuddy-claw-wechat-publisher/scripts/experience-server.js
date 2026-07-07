#!/usr/bin/env node
/**
 * 体验API独立服务器
 * 轻量版，不依赖第三方npm包，仅用Node内置模块
 */
'use strict';

const http = require('http');
const path = require('path');

const BASE = __dirname;

// 加载各模块（全部为纯Node.js模块，无第三方依赖）
let expEngine, shareEngine, sediment, conversion, industry;

function loadModules() {
    try { expEngine = require(path.join(BASE, 'experience-engine.js')); } catch(e) { console.error('[LOAD] experience-engine:', e.message); }
    try { shareEngine = require(path.join(BASE, 'share-engine.js')); } catch(e) { console.error('[LOAD] share-engine:', e.message); }
    try { sediment = require(path.join(BASE, 'data-sedimentation.js')); } catch(e) { console.log('[LOAD] data-sedimentation:', e.message); }
    try { conversion = require(path.join(BASE, 'conversion-funnel.js')); } catch(e) { console.log('[LOAD] conversion-funnel:', e.message); }
    try { industry = require(path.join(BASE, 'industry-report.js')); } catch(e) { console.log('[LOAD] industry-report:', e.message); }
    console.log('[LOAD] Modules loaded:', 
        (expEngine ? 'experience ' : '') +
        (shareEngine ? 'share ' : '') +
        (sediment ? 'sediment ' : '') +
        (conversion ? 'conversion ' : '') +
        (industry ? 'industry ' : '')
    );
}

function apiJson(res, data, status) {
    status = status || 200;
    res.writeHead(status, {
        'Content-Type': 'application/json; charset=UTF-8',
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Methods': 'GET,POST,OPTIONS',
        'Access-Control-Allow-Headers': 'Content-Type'
    });
    res.end(JSON.stringify(data));
}

function collectBody(req) {
    return new Promise((resolve) => {
        const chunks = [];
        req.on('data', c => chunks.push(c));
        req.on('end', () => resolve(Buffer.concat(chunks).toString()));
    });
}

async function handleRequest(req, res) {
    const url = new URL(req.url, 'http://localhost');
    const pathname = url.pathname;
    const query = Object.fromEntries(url.searchParams);

    // OPTIONS preflight
    if (req.method === 'OPTIONS') {
        res.writeHead(204, {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'GET,POST,OPTIONS',
            'Access-Control-Allow-Headers': 'Content-Type'
        });
        return res.end();
    }

    // Health check
    if (pathname === '/api/health') {
        return apiJson(res, { success: true, data: { ok: true, message: 'Experience API Server Running' } });
    }

    // Skills list
    if (pathname === '/api/experience/skills' && req.method === 'GET') {
        if (!expEngine) return apiJson(res, { success: false, error: '体验引擎未加载' }, 500);
        const skills = expEngine.getSkillList();
        const stats = shareEngine ? await shareEngine.getShareStats() : {};
        return apiJson(res, { success: true, data: { skills, stats } });
    }

    // Run skill
    if (pathname.startsWith('/api/experience/run/') && req.method === 'POST') {
        if (!expEngine) return apiJson(res, { success: false, error: '体验引擎未加载' }, 500);
        const skillId = pathname.replace('/api/experience/run/', '');
        const body = JSON.parse(await collectBody(req));
        const startMs = Date.now();
        const result = await expEngine.runSkill(skillId, body);
        // 数据沉淀
        if (sediment && result.success) {
            sediment.recordExperience({ skillId, inputText: body.text || '', result: result.result, durationMs: Date.now() - startMs }).catch(() => {});
        }
        // 分享Token
        if (shareEngine && result.success && result.shareData) {
            result.shareData._token = await shareEngine.createShareToken(skillId, result.shareData);
        }
        return apiJson(res, result);
    }

    // Sample data
    if (pathname.startsWith('/api/experience/sample/') && req.method === 'GET') {
        const skillId = pathname.replace('/api/experience/sample/', '');
        const samples = {
            bom_compare: '物料编码: BOM-001, 名称: 底座, 数量: 2, 层级: 1\n物料编码: BOM-002, 名称: 螺丝M8, 数量: 12, 层级: 2\n物料编码: BOM-003, 名称: 弹簧垫圈, 数量: 12, 层级: 3',
            process_optimize: '焊接工艺参数：电流200A，电压24V，焊接速度30cm/min，保护气体Ar 15L/min，层间温度150°C',
            content_generate: '如何用AI降低制造业BOM错误率'
        };
        return apiJson(res, { success: true, data: { sample: samples[skillId] || '暂无示例数据' } });
    }

    // Share tracking
    if (pathname.startsWith('/api/experience/share/') && req.method === 'GET') {
        if (!shareEngine) return apiJson(res, { success: false, error: '分享引擎未加载' }, 500);
        const token = pathname.replace('/api/experience/share/', '');
        const record = await shareEngine.trackShareView(token);
        if (!record) return apiJson(res, { success: false, error: '分享链接无效' }, 404);
        return apiJson(res, { success: true, data: { skillId: record.skillId, result: record.resultData } });
    }

    // Share conversion
    if (pathname === '/api/experience/share/conversion' && req.method === 'POST') {
        if (!shareEngine) return apiJson(res, { success: false, error: '分享引擎未加载' }, 500);
        const body = JSON.parse(await collectBody(req));
        if (!body.token) return apiJson(res, { success: false, error: '缺少token' });
        await shareEngine.trackShareConversion(body.token);
        return apiJson(res, { success: true });
    }

    // Stats
    if (pathname === '/api/experience/stats' && req.method === 'GET') {
        if (!shareEngine) return apiJson(res, { success: false, error: '分享引擎未加载' }, 500);
        const stats = await shareEngine.getShareStats(query.skillId || '');
        return apiJson(res, { success: true, data: stats });
    }

    // Sediment stats
    if (pathname === '/api/experience/sediment/stats' && req.method === 'GET') {
        if (!sediment) return apiJson(res, { success: false, error: '数据沉淀模块未加载' }, 500);
        const stats = await sediment.getStats();
        return apiJson(res, { success: true, data: stats });
    }

    // Conversion register
    if (pathname === '/api/experience/conversion/register' && req.method === 'POST') {
        if (!conversion) return apiJson(res, { success: false, error: '转化模块未加载' }, 500);
        const body = JSON.parse(await collectBody(req));
        if (!body.email) return apiJson(res, { success: false, error: '缺少邮箱' });
        const trial = await conversion.createTrial(body.email, body.displayName || '');
        return apiJson(res, { success: true, data: { trial, shareToUnlock: 3 } });
    }

    // Conversion stats
    if (pathname === '/api/experience/conversion/stats' && req.method === 'GET') {
        if (!conversion) return apiJson(res, { success: false, error: '转化模块未加载' }, 500);
        const stats = await conversion.getConversionStats();
        return apiJson(res, { success: true, data: stats });
    }

    // Industry report
    if (pathname.startsWith('/api/experience/report/') && req.method === 'GET') {
        if (!industry) return apiJson(res, { success: false, error: '行业报告模块未加载' }, 500);
        const reportType = pathname.replace('/api/experience/report/', '').replace('/publish', '');
        const report = await industry.generateReport(reportType);
        return apiJson(res, { success: true, data: { report, markdown: industry.reportToMarkdown(report) } });
    }

    // Fallback
    return apiJson(res, { success: false, error: '未知接口: ' + pathname }, 404);
}

// 启动服务器
const PORT = parseInt(process.argv[2]) || 3007;
loadModules();

const server = http.createServer(handleRequest);
server.listen(PORT, '0.0.0.0', () => {
    console.log('🤖 左帮右臂体验API服务器');
    console.log(`   地址: http://0.0.0.0:${PORT}`);
    console.log(`   健康检查: http://localhost:${PORT}/api/health`);
    console.log(`   接口: /api/experience/*`);
    console.log(`   时间: ${new Date().toISOString()}`);
});