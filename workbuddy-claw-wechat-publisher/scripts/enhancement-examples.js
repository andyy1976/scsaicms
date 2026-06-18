/**
 * 内容数字员工增强功能使用示例
 * 演示如何使用内容裂变、AI报告、优化循环、社区运营等功能
 */

const { contentFission, batchContentFission, saveFissionResult } = require('./content-fission-engine');
const { generateContentReport, scheduleReportGeneration } = require('./ai-report-generator');
const { optimizationLoop } = require('./optimization-loop-engine');
const { communityRepository } = require('./community-repository');

/**
 * 示例1：内容裂变
 */
async function exampleContentFission() {
    console.log('\n=== 示例1：内容裂变 ===\n');
    
    const article = {
        title: 'AI重构工业逻辑：数字员工如何撕开数字化转型的裂缝',
        content: `
在制造业数字化转型的浪潮中，企业面临着前所未有的挑战。传统的生产模式已经无法满足现代市场的需求，而AI技术的出现为这一困境带来了新的解决方案。

数字员工作为AI技术的重要应用，正在重新定义企业的生产方式。它不仅能够执行重复性任务，还能通过学习和优化，不断提升生产效率和质量。

本文将深入探讨数字员工在制造业中的应用场景，以及如何通过AI技术实现生产流程的智能化升级。
        `,
        summary: '探讨数字员工在制造业数字化转型中的应用'
    };
    
    // 执行内容裂变
    const result = await contentFission({
        ...article,
        outputs: ['video-script', 'image-cards', 'quote-poster'],
        videoOptions: { duration: '60s', style: 'documentary' },
        imageOptions: { style: 'xiaohongshu', cardCount: 6 },
        quoteOptions: { type: 'inspirational', quoteCount: 5 }
    });
    
    // 保存结果
    saveFissionResult(result, './output/fission');
    
    console.log('\n✅ 内容裂变完成！');
}

/**
 * 示例2：批量内容裂变
 */
async function exampleBatchFission() {
    console.log('\n=== 示例2：批量内容裂变 ===\n');
    
    const articles = [
        {
            title: '制造业内容自动化实践报告',
            content: '内容1的内容...',
            summary: '制造业内容自动化实践'
        },
        {
            title: '企业内容自动化能力自测指南',
            content: '内容2的内容...',
            summary: '企业内容自动化能力自测'
        }
    ];
    
    // 批量裂变
    const results = await batchContentFission(articles, {
        outputs: ['video-script', 'image-cards']
    });
    
    console.log(`\n✅ 批量裂变完成！成功: ${results.filter(r => !r.error).length}/${results.length}`);
}

/**
 * 示例3：生成AI分析报告
 */
async function exampleAIReport() {
    console.log('\n=== 示例3：生成AI分析报告 ===\n');
    
    try {
        // 生成周报
        const weeklyReport = await generateContentReport({
            reportType: 'weekly',
            startDate: '2026-06-10',
            endDate: '2026-06-16'
        });
        
        console.log('\n✅ 周报生成成功！');
        console.log('📄 报告路径:', weeklyReport);
    } catch (error) {
        console.error('❌ 报告生成失败:', error.message);
    }
}

/**
 * 示例4：优化循环
 */
async function exampleOptimizationLoop() {
    console.log('\n=== 示例4：优化循环 ===\n');
    
    // 加载偏好数据
    optimizationLoop.loadPreferences();
    
    // 模拟反馈数据
    const feedbackData = [
        {
            aid: 1,
            title: '文章1',
            avg_depth: 0.85,
            avg_duration: 120,
            total_likes: 45,
            typeid: 1
        },
        {
            aid: 2,
            title: '文章2',
            avg_depth: 0.65,
            avg_duration: 45,
            total_likes: 12,
            typeid: 2
        }
    ];
    
    // 处理反馈数据
    const optimalParams = await optimizationLoop.processFeedback(feedbackData);
    
    console.log('\n✅ 优化完成！');
    console.log('📊 最优参数:', JSON.stringify(optimalParams, null, 2));
    
    // 获取优化报告
    const report = optimizationLoop.generateOptimizationReport();
    console.log('\n📈 优化报告:', JSON.stringify(report, null, 2));
}

/**
 * 示例5：A/B测试
 */
async function exampleABTest() {
    console.log('\n=== 示例5：A/B测试 ===\n');
    
    // 启动A/B测试
    const experiment = optimizationLoop.startABTest(
        '测试故事型开头 vs 直接开头',
        { introStyle: 'direct' }
    );
    
    console.log('🧪 实验ID:', experiment.id);
    
    // 模拟记录实验结果
    optimizationLoop.parameterOptimizer.recordResult('A', {
        avg_depth: 0.75,
        avg_duration: 90,
        total_likes: 30
    });
    
    optimizationLoop.parameterOptimizer.recordResult('B', {
        avg_depth: 0.82,
        avg_duration: 105,
        total_likes: 38
    });
    
    // 完成实验
    const result = optimizationLoop.completeABTest();
    
    console.log('\n✅ 实验完成！');
    console.log('🏆 获胜组:', result.winner);
    console.log('📈 提升幅度:', result.improvement.toFixed(1) + '%');
}

/**
 * 示例6：提交插件
 */
async function exampleSubmitPlugin() {
    console.log('\n=== 示例6：提交插件 ===\n');
    
    const pluginSubmission = {
        name: '小红书风格增强器',
        description: '自动为内容添加小红书风格的emoji和话题标签',
        author: '开发者姓名',
        email: 'developer@example.com',
        version: '1.0.0',
        category: 'style',
        code: `
/**
 * 小红书风格增强器
 */
function enhanceXiaohongshuStyle(content) {
    // 添加emoji
    const emojis = ['✨', '🔥', '💡', '🎯', '🚀'];
    const randomEmoji = emojis[Math.floor(Math.random() * emojis.length)];
    
    // 添加话题标签
    const hashtags = ['#干货分享', '#学习笔记', '#职场技巧'];
    
    return \`\${randomEmoji} \${content}\\n\\n\${hashtags.join(' ')}\`;
}
        `,
        documentation: '使用方法：调用enhanceXiaohongshuStyle(content)函数',
        screenshots: []
    };
    
    try {
        const result = await communityRepository.submitPlugin(pluginSubmission);
        console.log('\n✅ 插件提交成功！');
        console.log('📦 提交ID:', result.id);
        console.log('📋 状态:', result.status);
    } catch (error) {
        console.error('❌ 提交失败:', error.message);
    }
}

/**
 * 示例7：提交模板
 */
async function exampleSubmitTemplate() {
    console.log('\n=== 示例7：提交模板 ===\n');
    
    const templateSubmission = {
        name: '技术文章模板',
        description: '适用于技术类文章的写作模板',
        author: '开发者姓名',
        email: 'developer@example.com',
        version: '1.0.0',
        category: 'article',
        template: `
# {{title}}

## 简介
{{introduction}}

## 核心观点
{{mainPoints}}

## 实践案例
{{caseStudy}}

## 总结
{{conclusion}}
        `,
        variables: [
            { name: 'title', description: '文章标题', required: true },
            { name: 'introduction', description: '文章简介', required: true },
            { name: 'mainPoints', description: '核心观点', required: true },
            { name: 'caseStudy', description: '实践案例', required: false },
            { name: 'conclusion', description: '总结', required: true }
        ],
        preview: '这是一个技术文章模板的预览...',
        screenshots: []
    };
    
    try {
        const result = await communityRepository.submitTemplate(templateSubmission);
        console.log('\n✅ 模板提交成功！');
        console.log('📦 提交ID:', result.id);
        console.log('📋 状态:', result.status);
    } catch (error) {
        console.error('❌ 提交失败:', error.message);
    }
}

/**
 * 示例8：获取市场列表
 */
async function exampleGetMarketplace() {
    console.log('\n=== 示例8：获取市场列表 ===\n');
    
    // 获取所有项目
    const allItems = communityRepository.getMarketplace();
    console.log(`\n🏪 市场项目总数: ${allItems.length}`);
    
    // 按类型过滤
    const plugins = communityRepository.getMarketplace({ type: 'plugin' });
    console.log(`\n🔌 插件数量: ${plugins.length}`);
    
    // 按分类过滤
    const stylePlugins = communityRepository.getMarketplace({ 
        type: 'plugin', 
        category: 'style' 
    });
    console.log(`\n🎨 风格插件数量: ${stylePlugins.length}`);
    
    // 搜索
    const searchResults = communityRepository.getMarketplace({ 
        search: '小红书' 
    });
    console.log(`\n🔍 搜索结果: ${searchResults.length}`);
}

/**
 * 示例9：下载项目
 */
async function exampleDownloadItem() {
    console.log('\n=== 示例9：下载项目 ===\n');
    
    // 获取市场列表
    const items = communityRepository.getMarketplace({ type: 'plugin' });
    
    if (items.length > 0) {
        const item = items[0];
        console.log(`\n📥 下载项目: ${item.name}`);
        
        const downloaded = communityRepository.downloadItem(item.id);
        console.log('\n✅ 下载成功！');
        console.log('📊 下载次数:', downloaded.downloads);
    }
}

/**
 * 示例10：添加评论
 */
async function exampleAddReview() {
    console.log('\n=== 示例10：添加评论 ===\n');
    
    // 获取市场列表
    const items = communityRepository.getMarketplace({ type: 'plugin' });
    
    if (items.length > 0) {
        const item = items[0];
        console.log(`\n⭐ 为项目添加评论: ${item.name}`);
        
        const review = {
            author: '用户A',
            rating: 5,
            comment: '非常好用的插件，强烈推荐！'
        };
        
        const result = communityRepository.addReview(item.id, review);
        console.log('\n✅ 评论添加成功！');
        console.log('📝 评论ID:', result.id);
    }
}

/**
 * 示例11：获取开发者统计
 */
async function exampleDeveloperStats() {
    console.log('\n=== 示例11：获取开发者统计 ===\n');
    
    const stats = communityRepository.getDeveloperStats('developer@example.com');
    
    console.log('\n📊 开发者统计:');
    console.log('  总提交数:', stats.totalSubmissions);
    console.log('  已审核数:', stats.approvedSubmissions);
    console.log('  总下载量:', stats.totalDownloads);
    console.log('  平均评分:', stats.avgRating);
    console.log('  项目列表:', stats.items.map(i => i.name).join(', '));
}

/**
 * 示例12：获取待审核列表
 */
async function examplePendingSubmissions() {
    console.log('\n=== 示例12：获取待审核列表 ===\n');
    
    const pending = communityRepository.getPendingSubmissions();
    
    console.log(`\n📋 待审核项目数: ${pending.length}`);
    
    pending.forEach(item => {
        console.log(`\n  - ${item.name} (${item.type})`);
        console.log(`    提交时间: ${item.createdAt}`);
        console.log(`    状态: ${item.status}`);
    });
}

/**
 * 示例13：审核项目
 */
async function exampleReviewSubmission() {
    console.log('\n=== 示例13：审核项目 ===\n');
    
    // 获取待审核列表
    const pending = communityRepository.getPendingSubmissions();
    
    if (pending.length > 0) {
        const item = pending[0];
        console.log(`\n📋 审核项目: ${item.name}`);
        
        const reviewResult = {
            approved: true,
            comment: '插件代码质量良好，功能完整，审核通过',
            reviewer: '审核员A'
        };
        
        const result = communityRepository.reviewSubmission(item.id, reviewResult);
        console.log('\n✅ 审核完成！');
        console.log('📋 最终状态:', result.status);
    }
}

/**
 * 主函数：运行所有示例
 */
async function runAllExamples() {
    console.log('🚀 开始运行所有示例...\n');
    
    try {
        // 内容裂变示例
        await exampleContentFission();
        await exampleBatchFission();
        
        // AI报告示例
        await exampleAIReport();
        
        // 优化循环示例
        await exampleOptimizationLoop();
        await exampleABTest();
        
        // 社区运营示例
        await exampleSubmitPlugin();
        await exampleSubmitTemplate();
        await exampleGetMarketplace();
        await exampleDownloadItem();
        await exampleAddReview();
        await exampleDeveloperStats();
        await examplePendingSubmissions();
        await exampleReviewSubmission();
        
        console.log('\n🎉 所有示例运行完成！');
    } catch (error) {
        console.error('\n❌ 示例运行失败:', error.message);
    }
}

// 如果直接运行此文件，执行所有示例
if (require.main === module) {
    runAllExamples();
}

// 导出各个示例函数
module.exports = {
    exampleContentFission,
    exampleBatchFission,
    exampleAIReport,
    exampleOptimizationLoop,
    exampleABTest,
    exampleSubmitPlugin,
    exampleSubmitTemplate,
    exampleGetMarketplace,
    exampleDownloadItem,
    exampleAddReview,
    exampleDeveloperStats,
    examplePendingSubmissions,
    exampleReviewSubmission,
    runAllExamples
};