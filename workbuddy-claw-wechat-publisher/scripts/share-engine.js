/**
 * 分享引擎 v1.0
 * 体验结果分享卡片生成 + 溯源追踪
 */
'use strict';
const P = require('path');
const F = require('fs');
const CRYPTO = require('crypto');

// 分享数据存储（JSON文件）
const DATA_DIR = P.join(__dirname, '..', 'data', 'shares');
function ensureDir() { if (!F.existsSync(DATA_DIR)) F.mkdirSync(DATA_DIR, { recursive: true }); }

// 生成分享Token + 存储
async function createShareToken(skillId, resultData) {
    ensureDir();
    const token = CRYPTO.randomBytes(16).toString('hex');
    const record = {
        token,
        skillId,
        resultData: {
            title: resultData.title || '',
            highlight: resultData.highlight || '',
            stats: resultData.stats || {}
        },
        createdAt: Date.now(),
        views: 0,
        conversions: 0
    };
    F.writeFileSync(P.join(DATA_DIR, token + '.json'), JSON.stringify(record, null, 2), 'utf8');
    return token;
}

// 追踪分享查看
async function trackShareView(token) {
    const file = P.join(DATA_DIR, token + '.json');
    if (!F.existsSync(file)) return null;
    try {
        const record = JSON.parse(F.readFileSync(file, 'utf8'));
        record.views++;
        record.lastViewAt = Date.now();
        F.writeFileSync(file, JSON.stringify(record, null, 2), 'utf8');
        return record;
    } catch (e) { return null; }
}

// 追踪转化（查看→体验）
async function trackShareConversion(token) {
    const file = P.join(DATA_DIR, token + '.json');
    if (!F.existsSync(file)) return null;
    try {
        const record = JSON.parse(F.readFileSync(file, 'utf8'));
        record.conversions++;
        F.writeFileSync(file, JSON.stringify(record, null, 2), 'utf8');
        return record;
    } catch (e) { return null; }
}

// 获取分享统计
async function getShareStats(skillId) {
    ensureDir();
    const files = F.readdirSync(DATA_DIR).filter(f => f.endsWith('.json'));
    let total = 0, totalViews = 0, totalConversions = 0;
    for (const f of files) {
        try {
            const r = JSON.parse(F.readFileSync(P.join(DATA_DIR, f), 'utf8'));
            if (!skillId || r.skillId === skillId) {
                total++;
                totalViews += r.views || 0;
                totalConversions += r.conversions || 0;
            }
        } catch (e) {}
    }
    return { totalShares: total, totalViews, totalConversions, conversionRate: total > 0 ? (totalConversions / total * 100).toFixed(1) + '%' : '0%' };
}

// 生成分享卡片文案
function generateShareText(shareData) {
    const { title, highlight, stats, skillId } = shareData;
    const templates = {
        bom_compare: `我用左帮右臂检查了BOM结构，发现${stats?.issues||0}个问题，健康评分${stats?.score||0}分！你也来试试→`,
        process_optimize: `我用左帮右臂优化了工艺参数，预估效率提升${stats?.efficiency||'N/A'}！你也来试试→`,
        content_generate: `我用左帮右臂生成了「${title||'技术文章'}」，AI辅助写作太方便了！你也来试试→`
    };
    return {
        text: templates[skillId] || `我用左帮右臂完成了「${title}」！你也来试试→`,
        url: `https://bossagents.cn/s/${shareData._token||''}`,
        hashtags: '#左帮右臂 #工业智能体 #AI'
    };
}

module.exports = { createShareToken, trackShareView, trackShareConversion, getShareStats, generateShareText };
