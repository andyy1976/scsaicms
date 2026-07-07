/**
 * 公开体验 API 路由
 * 挂载到 /api/experience/*，无需认证
 */
const P = require('path');
const EXP_ENGINE = P.join(__dirname, '..', 'cms', 'workbuddy-claw-wechat-publisher', 'scripts', 'experience-engine.js');
const SHARE_ENGINE = P.join(__dirname, '..', 'cms', 'workbuddy-claw-wechat-publisher', 'scripts', 'share-engine.js');
const SEDIMENT = P.join(__dirname, '..', 'cms', 'workbuddy-claw-wechat-publisher', 'scripts', 'data-sedimentation.js');
const CONVERSION = P.join(__dirname, '..', 'cms', 'workbuddy-claw-wechat-publisher', 'scripts', 'conversion-funnel.js');
const INDUSTRY = P.join(__dirname, '..', 'cms', 'workbuddy-claw-wechat-publisher', 'scripts', 'industry-report.js');
let expEngine, shareEngine, sediment, conversion, industry;

function lazyLoad() {
    if (!expEngine) { try { expEngine = require(EXP_ENGINE); } catch(e) {} }
    if (!shareEngine) { try { shareEngine = require(SHARE_ENGINE); } catch(e) {} }
    if (!sediment) { try { sediment = require(SEDIMENT); } catch(e) {} }
    if (!conversion) { try { conversion = require(CONVERSION); } catch(e) {} }
    if (!industry) { try { industry = require(INDUSTRY); } catch(e) {} }
}

async function handleExperienceRoute(req, res, pathname, query, body) {
    lazyLoad();
    const parts = pathname.replace('/api/experience/', '').split('?')[0];
    const apiJson = (data, status = 200) => {
        res.writeHead(status, { 'Content-Type': 'application/json; charset=UTF-8', 'Access-Control-Allow-Origin': '*', 'Access-Control-Allow-Methods': 'GET,POST,OPTIONS', 'Access-Control-Allow-Headers': 'Content-Type' });
        res.end(JSON.stringify(data));
    };

    try {
        // GET /api/experience/skills - 获取Skill列表
        if (parts === 'skills' && req.method === 'GET') {
            const skills = expEngine.getSkillList();
            const stats = await shareEngine.getShareStats();
            return apiJson({ success: true, data: { skills, stats } });
        }

        // GET /api/experience/stats - 获取分享统计
        if (parts === 'stats' && req.method === 'GET') {
            const skillId = query.skillId || '';
            const stats = await shareEngine.getShareStats(skillId);
            return apiJson({ success: true, data: stats });
        }

        // GET /api/experience/share/:token - 溯源跳转
        if (parts.startsWith('share/') && req.method === 'GET') {
            const token = parts.replace('share/', '');
            const record = await shareEngine.trackShareView(token);
            if (!record) return apiJson({ success: false, error: '分享链接无效' }, 404);
            return apiJson({ success: true, data: { skillId: record.skillId, result: record.resultData } });
        }

        // POST /api/experience/share/conversion - 追踪转化
        if (parts === 'share/conversion' && req.method === 'POST') {
            const b = body ? JSON.parse(body) : {};
            if (!b.token) return apiJson({ success: false, error: '缺少token' });
            await shareEngine.trackShareConversion(b.token);
            return apiJson({ success: true });
        }

        // POST /api/experience/run/:skillId - 运行Skill
        if (parts.startsWith('run/') && req.method === 'POST') {
            const skillId = parts.replace('run/', '');
            const b = body ? JSON.parse(body) : {};
            const startMs = Date.now();
            const result = await expEngine.runSkill(skillId, b);

            // 数据沉淀（脱敏记录，不阻塞响应）
            if (sediment && result.success) {
                sediment.recordExperience({
                    skillId,
                    inputText: b.text || '',
                    result: result.result,
                    durationMs: Date.now() - startMs
                }).catch(() => {});
            }

            // 生成分享Token
            if (result.success && result.shareData) {
                result.shareData._token = await shareEngine.createShareToken(skillId, result.shareData);
            }

            return apiJson(result);
        }

        // GET /api/experience/sample/:skillId - 获取示例数据
        if (parts.startsWith('sample/') && req.method === 'GET') {
            const skillId = parts.replace('sample/', '');
            const samples = {
                bom_compare: '物料编码: BOM-001, 名称: 底座, 数量: 2, 层级: 1\n物料编码: BOM-002, 名称: 螺丝M8, 数量: 12, 层级: 2\n物料编码: BOM-003, 名称: 弹簧垫圈, 数量: 12, 层级: 3',
                process_optimize: '焊接工艺参数：电流200A，电压24V，焊接速度30cm/min，保护气体Ar 15L/min，层间温度150°C',
                content_generate: '如何用AI降低制造业BOM错误率'
            };
            return apiJson({ success: true, data: { sample: samples[skillId] || '暂无示例数据' } });
        }

        // GET /api/experience/sediment/stats - 数据沉淀统计
        if (parts === 'sediment/stats' && req.method === 'GET') {
            if (!sediment) return apiJson({ success: false, error: '数据沉淀模块未加载' });
            const stats = await sediment.getStats();
            return apiJson({ success: true, data: stats });
        }

        // GET /api/experience/sediment/insights/:skillId - 生成洞察
        if (parts.startsWith('sediment/insights/') && req.method === 'GET') {
            if (!sediment) return apiJson({ success: false, error: '数据沉淀模块未加载' });
            const skillId = parts.replace('sediment/insights/', '');
            const insights = await sediment.generateInsights(skillId);
            return apiJson({ success: true, data: insights || { message: '暂无数据' } });
        }

        // GET /api/experience/sediment/insights - 全量洞察
        if (parts === 'sediment/insights' && req.method === 'GET') {
            if (!sediment) return apiJson({ success: false, error: '数据沉淀模块未加载' });
            const insights = await sediment.generateInsights('');
            return apiJson({ success: true, data: insights || { message: '暂无数据' } });
        }

        // POST /api/experience/conversion/register - 注册试用
        if (parts === 'conversion/register' && req.method === 'POST') {
            if (!conversion) return apiJson({ success: false, error: '转化模块未加载' });
            const b = body ? JSON.parse(body) : {};
            if (!b.email) return apiJson({ success: false, error: '缺少邮箱' });
            const trial = await conversion.createTrial(b.email, b.displayName || '');
            return apiJson({ success: true, data: { trial, shareToUnlock: 3 } });
        }

        // POST /api/experience/conversion/activity - 记录活动
        if (parts === 'conversion/activity' && req.method === 'POST') {
            if (!conversion) return apiJson({ success: false, error: '转化模块未加载' });
            const b = body ? JSON.parse(body) : {};
            if (!b.email) return apiJson({ success: false, error: '缺少邮箱' });
            if (b.type === 'share') await conversion.recordShare(b.email);
            else await conversion.recordActivity(b.email);
            return apiJson({ success: true });
        }

        // GET /api/experience/conversion/status - 检查试用状态
        if (parts === 'conversion/status' && req.method === 'GET') {
            if (!conversion) return apiJson({ success: false, error: '转化模块未加载' });
            if (!query.email) return apiJson({ success: false, error: '缺少邮箱' });
            const status = await conversion.checkTrial(query.email);
            return apiJson({ success: true, data: status || { status: 'new' } });
        }

        // GET /api/experience/conversion/stats - 转化统计
        if (parts === 'conversion/stats' && req.method === 'GET') {
            if (!conversion) return apiJson({ success: false, error: '转化模块未加载' });
            const stats = await conversion.getConversionStats();
            return apiJson({ success: true, data: stats });
        }

        // GET /api/experience/report/:type - 生成行业报告
        if (parts.startsWith('report/') && req.method === 'GET') {
            if (!industry) return apiJson({ success: false, error: '行业报告模块未加载' });
            const reportType = parts.replace('report/', '');
            const report = await industry.generateReport(reportType);
            const md = industry.reportToMarkdown(report);
            return apiJson({ success: true, data: { report, markdown: md } });
        }

        // POST /api/experience/report/:type/publish - 生成并发布行业报告
        if (parts.match(/^report\/.+\/publish$/) && req.method === 'POST') {
            if (!industry) return apiJson({ success: false, error: '行业报告模块未加载' });
            const reportType = parts.replace('report/', '').replace('/publish', '');
            const report = await industry.generateReport(reportType);
            const result = await industry.publishToCMS(report);
            return apiJson({ success: result.success, data: { report, publish: result } });
        }

        return apiJson({ success: false, error: '未知接口: ' + parts }, 404);

    } catch (e) {
        return apiJson({ success: false, error: e.message }, 500);
    }
}

module.exports = { handleExperienceRoute };
