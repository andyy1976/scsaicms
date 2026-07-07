/**
 * 数据沉淀管线 v1.0
 * 体验数据脱敏 -> 模式提取 -> 知识库积累
 */
'use strict';
const FS = require('fs');
const P = require('path');
const DATA_DIR = P.join(__dirname, '..', 'data', 'sedimentation');
const PATTERNS_DIR = P.join(DATA_DIR, 'patterns');
const RECORDS_DIR = P.join(DATA_DIR, 'records');
const INSIGHTS_DIR = P.join(DATA_DIR, 'insights');

function ensureDirs() {
    [DATA_DIR, PATTERNS_DIR, RECORDS_DIR, INSIGHTS_DIR].forEach(d => {
        if (!FS.existsSync(d)) FS.mkdirSync(d, { recursive: true });
    });
}

// 记录一次体验（脱敏）
async function recordExperience(input) {
    ensureDirs();
    const { skillId, inputText, result, durationMs } = input;
    if (!skillId || !result) return null;
    const record = {
        skillId, timestamp: Date.now(), date: new Date().toISOString().split('T')[0],
        inputLength: (inputText || '').length, inputHash: simpleHash(inputText || ''),
        inputType: classifyInputType(inputText), success: result.success || false,
        issueCount: result.stats?.issueCount || result.issues?.length || 0,
        healthScore: result.stats?.healthScore || 0,
        optimizationCount: result.optimizations?.length || 0,
        wordCount: result.content?.length || 0,
        hasHighSeverity: result.issues?.some(i => i.severity === 'high') || false
    };
    const file = P.join(RECORDS_DIR, skillId + '.jsonl');
    FS.appendFileSync(file, JSON.stringify(record) + '\n', 'utf8');
    extractPattern(skillId, result).catch(() => {});
    return record;
}

function simpleHash(str) {
    if (!str) return '';
    let h = 0;
    for (let i = 0; i < Math.min(str.length, 100); i++) { h = ((h << 5) - h) + str.charCodeAt(i); h |= 0; }
    return Math.abs(h).toString(16);
}

function classifyInputType(text) {
    if (!text || text.length < 10) return 'empty';
    if (text.includes('物料编码') || text.includes('BOM') || text.includes('物料')) return 'bom_data';
    if (text.includes('电流') || text.includes('工艺') || text.includes('焊接') || text.includes('参数')) return 'process_data';
    if (text.includes('如何') || text.includes('怎么')) return 'question';
    return 'general';
}

async function extractPattern(skillId, result) {
    ensureDirs();
    const date = new Date().toISOString().split('T')[0];
    const patternFile = P.join(PATTERNS_DIR, skillId + '.json');
    let patterns = { bom_compare: [], process_optimize: [], content_generate: [] };
    if (FS.existsSync(patternFile)) {
        try { patterns = JSON.parse(FS.readFileSync(patternFile, 'utf8')); } catch (e) {}
    }
    if (skillId === 'bom_compare' && result.issues) {
        result.issues.forEach(issue => {
            const key = issue.type + '|' + issue.detail.substring(0, 20);
            const existing = patterns.bom_compare.find(p => p.key === key);
            if (existing) { existing.count++; existing.lastSeen = date; if (issue.severity === 'high') existing.highCount = (existing.highCount || 0) + 1; }
            else { patterns.bom_compare.push({ key, type: issue.type, severity: issue.severity, summary: issue.detail.substring(0, 80), count: 1, highCount: issue.severity === 'high' ? 1 : 0, firstSeen: date, lastSeen: date }); }
        });
    }
    if (skillId === 'process_optimize' && result.optimizations) {
        result.optimizations.forEach(opt => {
            const key = opt.parameter + '|' + (opt.suggestedValue || '');
            const existing = patterns.process_optimize.find(p => p.key === key);
            if (existing) { existing.count++; existing.lastSeen = date; }
            else { patterns.process_optimize.push({ key, parameter: opt.parameter, currentValue: opt.currentValue, suggestedValue: opt.suggestedValue, expectedImprovement: opt.expectedImprovement, count: 1, firstSeen: date, lastSeen: date }); }
        });
    }
    if (skillId === 'content_generate' && result.keywords) {
        result.keywords.forEach(kw => {
            const existing = patterns.content_generate.find(p => p.keyword === kw);
            if (existing) { existing.count++; existing.lastSeen = date; }
            else { patterns.content_generate.push({ keyword: kw, count: 1, firstSeen: date, lastSeen: date }); }
        });
    }
    FS.writeFileSync(patternFile, JSON.stringify(patterns, null, 2), 'utf8');
}

async function generateInsights(skillId) {
    ensureDirs();
    const patternFile = P.join(PATTERNS_DIR, (skillId || '') + '.json');
    if (!FS.existsSync(patternFile)) return null;
    const patterns = JSON.parse(FS.readFileSync(patternFile, 'utf8'));
    const result = { generatedAt: new Date().toISOString().split('T')[0], skills: {} };
    if (patterns.bom_compare && patterns.bom_compare.length > 0) {
        const sorted = patterns.bom_compare.sort((a, b) => b.count - a.count);
        result.skills.bom_compare = { totalPatterns: patterns.bom_compare.length, topIssues: sorted.slice(0, 10).map(p => ({ type: p.type, count: p.count, sample: p.summary })), highSeverityCount: patterns.bom_compare.reduce((s, p) => s + (p.highCount || 0), 0) };
    }
    if (patterns.process_optimize && patterns.process_optimize.length > 0) {
        const sorted = patterns.process_optimize.sort((a, b) => b.count - a.count);
        result.skills.process_optimize = { totalPatterns: patterns.process_optimize.length, topOptimizations: sorted.slice(0, 10).map(p => ({ parameter: p.parameter, suggestion: p.suggestedValue, count: p.count })) };
    }
    if (patterns.content_generate && patterns.content_generate.length > 0) {
        const sorted = patterns.content_generate.sort((a, b) => b.count - a.count);
        result.skills.content_generate = { totalPatterns: patterns.content_generate.length, hotKeywords: sorted.slice(0, 20).map(p => ({ keyword: p.keyword, count: p.count })) };
    }
    const file = P.join(INSIGHTS_DIR, (skillId || 'all') + '-' + result.generatedAt + '.json');
    FS.writeFileSync(file, JSON.stringify(result, null, 2), 'utf8');
    return result;
}

async function getStats() {
    ensureDirs();
    const result = { totalRecords: 0, bySkill: {}, dailyStats: {}, topPatterns: [] };
    if (FS.existsSync(RECORDS_DIR)) {
        FS.readdirSync(RECORDS_DIR).forEach(file => {
            if (!file.endsWith('.jsonl')) return;
            const skillId = file.replace('.jsonl', '');
            const lines = FS.readFileSync(P.join(RECORDS_DIR, file), 'utf8').trim().split('\n').filter(Boolean);
            result.totalRecords += lines.length;
            result.bySkill[skillId] = lines.length;
            lines.forEach(line => { try { const r = JSON.parse(line); result.dailyStats[r.date] = (result.dailyStats[r.date] || 0) + 1; } catch (e) {} });
        });
    }
    if (FS.existsSync(PATTERNS_DIR)) {
        FS.readdirSync(PATTERNS_DIR).forEach(file => {
            if (!file.endsWith('.json')) return;
            try { const p = JSON.parse(FS.readFileSync(P.join(PATTERNS_DIR, file), 'utf8')); Object.entries(p).forEach(([sk, items]) => { if (Array.isArray(items)) items.forEach(item => { result.topPatterns.push({ skill: sk, keyword: item.keyword || item.type || item.parameter, count: item.count || 0 }); }); }); } catch (e) {}
        });
        result.topPatterns.sort((a, b) => b.count - a.count);
    }
    return result;
}

module.exports = { recordExperience, generateInsights, getStats, extractPattern };