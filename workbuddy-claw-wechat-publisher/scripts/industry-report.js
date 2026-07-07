/**
 * 行业报告生成器 v1.0
 * 基于用户匿名体验数据，自动生成行业趋势报告
 * 报告可推送到CMS作为公开文章
 */
'use strict';
const FS = require('fs');
const P = require('path');
const BASE = P.join(__dirname, '..');

// 延迟加载
let sediment, cmsStorage;
function lazyLoad() {
    if (!sediment) { try { sediment = require('./data-sedimentation'); } catch(e) {} }
    if (!cmsStorage) { try { cmsStorage = require('./cms-database'); } catch(e) {} }
}

// ── 报告类型 ──────────────────────────────────────────────
const REPORT_TYPES = {
    weekly: { name: '周报', days: 7, title: '制造业BOM与工艺趋势周报' },
    monthly: { name: '月报', days: 30, title: '制造业数字化转型月报' },
    quarterly: { name: '季报', days: 90, title: '工业智能体应用季报' }
};

// ── 生成报告 ──────────────────────────────────────────────
async function generateReport(type) {
    lazyLoad();
    const cfg = REPORT_TYPES[type] || REPORT_TYPES.weekly;
    const date = new Date().toISOString().split('T')[0];
    const sections = [];

    // 1. 沉淀数据统计
    let sedimentStats = { totalRecords: 0, bySkill: {}, dailyStats: {}, topPatterns: [] };
    if (sediment) {
        try { sedimentStats = await sediment.getStats(); } catch(e) {}
    }

    // 2. 按Skill生成各个章节
    if (sedimentStats.topPatterns.length > 0) {
        const bomPatterns = sedimentStats.topPatterns.filter(p => p.skill === 'bom_compare').slice(0, 5);
        const processPatterns = sedimentStats.topPatterns.filter(p => p.skill === 'process_optimize').slice(0, 5);
        const contentPatterns = sedimentStats.topPatterns.filter(p => p.skill === 'content_generate').slice(0, 5);

        if (bomPatterns.length > 0) {
            sections.push({
                title: 'BOM常见问题排行',
                content: '根据左帮右臂平台用户匿名体验数据，过去' + cfg.days + '天最常出现的BOM问题包括：\n' +
                    bomPatterns.map((p, i) => (i+1) + '. ' + p.keyword + '（出现' + p.count + '次）').join('\n') +
                    '\n\n建议：定期进行BOM结构健康检查，重点关注高风险项。'
            });
        }

        if (processPatterns.length > 0) {
            sections.push({
                title: '工艺优化热点',
                content: '用户关注的工艺优化方向主要集中在：\n' +
                    processPatterns.map((p, i) => (i+1) + '. ' + p.keyword + '（提及' + p.count + '次）').join('\n')
            });
        }

        if (contentPatterns.length > 0) {
            sections.push({
                title: '行业关注热点',
                content: '制造业从业者最关注的话题：\n' +
                    contentPatterns.map((p, i) => (i+1) + '. ' + p.keyword + '（' + p.count + '次搜索）').join('\n')
            });
        }
    }

    // 3. 统计摘要
    const totalUsers = sedimentStats.bySkill ? Object.values(sedimentStats.bySkill).reduce((a, b) => a + b, 0) : 0;
    sections.unshift({
        title: '数据概览',
        content: '本期报告基于' + (totalUsers || '待积累') + '次用户匿名体验数据生成。\n' +
            '覆盖BOM结构比对、工艺参数优化、智能内容生成三大领域。\n' +
            '数据来源：左帮右臂工业智能体平台。'
    });

    // 4. 组装报告
    const report = {
        title: cfg.title + ' - ' + date,
        type: type,
        date: date,
        period: '过去' + cfg.days + '天',
        generatedAt: new Date().toISOString(),
        sections: sections,
        stats: {
            totalRecords: totalUsers,
            topPatternsCount: sedimentStats.topPatterns.length,
            skillsCovered: Object.keys(sedimentStats.bySkill || {}).length
        },
        footer: '本报告由左帮右臂内容数字员工自动生成 | ' + date
    };

    // 5. 保存报告
    const reportDir = P.join(BASE, 'data', 'reports');
    if (!FS.existsSync(reportDir)) FS.mkdirSync(reportDir, { recursive: true });
    const reportFile = P.join(reportDir, 'industry-' + type + '-' + date + '.json');
    FS.writeFileSync(reportFile, JSON.stringify(report, null, 2), 'utf8');

    return report;
}

// ── 生成Markdown版 ────────────────────────────────────────
function reportToMarkdown(report) {
    let md = '# ' + report.title + '\n\n';
    md += '> 数据周期：' + report.period + ' | 生成时间：' + report.date + '\n\n';
    md += '---\n\n';

    for (const section of report.sections) {
        md += '## ' + section.title + '\n\n';
        md += section.content + '\n\n';
    }

    md += '---\n\n';
    md += '_' + report.footer + '_';
    return md;
}

// ── 推送到CMS ─────────────────────────────────────────────
async function publishToCMS(report) {
    lazyLoad();
    if (!cmsStorage) return { success: false, error: 'CMS存储模块未加载' };

    const mdContent = reportToMarkdown(report);
    const article = {
        title: report.title,
        content: mdContent,
        keywords: ['行业报告', report.type, '制造业', 'BOM', '数字化转型'],
        description: report.sections[0]?.content?.substring(0, 150) || '行业趋势报告',
        author: '左帮右臂内容数字员工'
    };

    try {
        const result = await cmsStorage.saveArticle(article);
        return result;
    } catch (e) {
        return { success: false, error: e.message };
    }
}

// ── CLI ───────────────────────────────────────────────────
if (require.main === module) {
    const args = process.argv.slice(2);
    const type = args[0] || 'weekly';
    const shouldPublish = args.includes('--publish');

    generateReport(type).then(async (report) => {
        console.log('\n📊 行业报告生成完成');
        console.log('   标题:', report.title);
        console.log('   章节:', report.sections.length);
        console.log('   数据:', report.stats.totalRecords || 0, '条记录');

        if (shouldPublish) {
            console.log('\n📤 推送到CMS...');
            const result = await publishToCMS(report);
            if (result.success) {
                console.log('   ✅ 已发布，文章ID:', result.aid);
            } else {
                console.log('   ❌ 发布失败:', result.error);
            }
        }

        console.log('\n--- Markdown预览 ---\n');
        console.log(reportToMarkdown(report));
    }).catch(e => {
        console.error('❌ 生成失败:', e.message);
    });
}

module.exports = { generateReport, reportToMarkdown, publishToCMS, REPORT_TYPES };