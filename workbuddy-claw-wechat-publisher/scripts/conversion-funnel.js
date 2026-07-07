/**
 * 注册转化漏斗 v1.0
 * 体验 -> 注册(7天试用) -> 分享解锁更多Skill
 */
'use strict';
const FS = require('fs');
const P = require('path');

const DATA_DIR = P.join(__dirname, '..', 'data', 'conversions');
const TRIAL_DAYS = 7;

function ensureDir() { if (!FS.existsSync(DATA_DIR)) FS.mkdirSync(DATA_DIR, { recursive: true }); }

// 生成试用Token
function generateTrialToken() {
    const crypto = require('crypto');
    return 'trial_' + Date.now().toString(36) + '_' + crypto.randomBytes(8).toString('hex');
}

// 注册后创建试用记录
async function createTrial(email, displayName) {
    ensureDir();
    const token = generateTrialToken();
    const record = {
        email, displayName: displayName || email.split('@')[0],
        token, createdAt: Date.now(),
        expiresAt: Date.now() + TRIAL_DAYS * 24 * 60 * 60 * 1000,
        skillsUnlocked: ['bom_compare', 'process_optimize', 'content_generate'],
        experienceCount: 0, shareCount: 0, lastActive: Date.now(),
        status: 'active'
    };
    FS.writeFileSync(P.join(DATA_DIR, email.replace(/[@.]/g, '_') + '.json'), JSON.stringify(record, null, 2), 'utf8');
    return record;
}

// 记录体验次数
async function recordActivity(email) {
    const file = P.join(DATA_DIR, email.replace(/[@.]/g, '_') + '.json');
    if (!FS.existsSync(file)) return null;
    try {
        const r = JSON.parse(FS.readFileSync(file, 'utf8'));
        r.experienceCount++;
        r.lastActive = Date.now();
        // 分享3次解锁更多Skill
        if (r.shareCount >= 3 && r.skillsUnlocked.length < 6) {
            const extra = ['diagnosis', 'survey', 'feedback'];
            r.skillsUnlocked = [...new Set([...r.skillsUnlocked, ...extra])];
        }
        FS.writeFileSync(file, JSON.stringify(r, null, 2), 'utf8');
        return r;
    } catch (e) { return null; }
}

// 记录分享
async function recordShare(email) {
    const file = P.join(DATA_DIR, email.replace(/[@.]/g, '_') + '.json');
    if (!FS.existsSync(file)) return null;
    try {
        const r = JSON.parse(FS.readFileSync(file, 'utf8'));
        r.shareCount++;
        r.lastActive = Date.now();
        if (r.shareCount >= 3 && r.skillsUnlocked.length < 6) {
            const extra = ['diagnosis', 'survey', 'feedback'];
            r.skillsUnlocked = [...new Set([...r.skillsUnlocked, ...extra])];
        }
        FS.writeFileSync(file, JSON.stringify(r, null, 2), 'utf8');
        return r;
    } catch (e) { return null; }
}

// 检查试用状态
async function checkTrial(email) {
    const file = P.join(DATA_DIR, email.replace(/[@.]/g, '_') + '.json');
    if (!FS.existsSync(file)) return null;
    try {
        const r = JSON.parse(FS.readFileSync(file, 'utf8'));
        if (r.expiresAt < Date.now()) { r.status = 'expired'; FS.writeFileSync(file, JSON.stringify(r, null, 2), 'utf8'); }
        return r;
    } catch (e) { return null; }
}

// 统计转化数据
async function getConversionStats() {
    ensureDir();
    const files = FS.readdirSync(DATA_DIR).filter(f => f.endsWith('.json'));
    const stats = {
        totalRegistrations: files.length,
        activeTrials: 0, expiredTrials: 0,
        totalExperiences: 0, totalShares: 0,
        avgExperiencePerUser: 0, avgSharePerUser: 0,
        unlockedRate: 0
    };
    let unlockedCount = 0;
    for (const f of files) {
        try {
            const r = JSON.parse(FS.readFileSync(P.join(DATA_DIR, f), 'utf8'));
            if (r.status === 'active') stats.activeTrials++;
            else stats.expiredTrials++;
            stats.totalExperiences += r.experienceCount || 0;
            stats.totalShares += r.shareCount || 0;
            if (r.skillsUnlocked && r.skillsUnlocked.length > 3) unlockedCount++;
        } catch (e) {}
    }
    if (files.length > 0) {
        stats.avgExperiencePerUser = (stats.totalExperiences / files.length).toFixed(1);
        stats.avgSharePerUser = (stats.totalShares / files.length).toFixed(1);
        stats.unlockedRate = (unlockedCount / files.length * 100).toFixed(1) + '%';
    }
    return stats;
}

// 生成转化报告（给内容数字员工用）
async function generateConversionReport() {
    const stats = await getConversionStats();
    return {
        date: new Date().toISOString().split('T')[0],
        stats,
        insights: [
            stats.totalRegistrations > 0 ? `已有 ${stats.totalRegistrations} 位用户注册试用` : '暂无注册用户',
            stats.activeTrials > 0 ? `${stats.activeTrials} 位用户正在试用中` : '',
            stats.avgExperiencePerUser > 0 ? `平均每位用户体验 ${stats.avgExperiencePerUser} 次` : '',
            stats.avgSharePerUser > 0 ? `平均每位用户分享 ${stats.avgSharePerUser} 次` : '',
            stats.unlockedRate !== '0%' ? `${stats.unlockedRate} 的用户解锁了更多Skill` : ''
        ].filter(Boolean).join('，')
    };
}

module.exports = { createTrial, recordActivity, recordShare, checkTrial, getConversionStats, generateConversionReport };