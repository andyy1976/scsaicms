/**
 * 内容数字员工增强功能基础测试
 * 测试不需要真实AI调用的功能模块
 */

const { CommunityRepository } = require('./community-repository');
const { OptimizationLoop } = require('./optimization-loop-engine');

/**
 * 测试1：社区仓库功能
 */
async function testCommunityRepository() {
    console.log('\n=== 测试1：社区仓库功能 ===\n');
    
    try {
        // 初始化仓库
        const repo = new CommunityRepository();
        
        // 添加模板
        const templateData = {
            id: 'test-template-001',
            name: '企业数字化转型案例模板',
            description: '用于生成企业数字化转型案例文章的模板',
            type: 'template',
            category: 'article',
            author: '测试用户',
            email: 'test@example.com',
            version: '1.0.0',
            content: {
                title: '{{company}}的数字化转型之路',
                sections: ['背景介绍', '转型策略', '实施效果', '经验总结']
            },
            metadata: {
                tags: ['数字化', '转型', '案例'],
                compatibleWith: ['wechat', 'website']
            }
        };
        
        await repo.submitTemplate(templateData);
        console.log('✅ 模板提交成功');
        
        console.log('\n✅ 社区仓库功能测试完成！');
    } catch (error) {
        console.error('❌ 社区仓库测试失败:', error.message);
    }
}

/**
 * 测试2：优化循环功能
 */
async function testOptimizationLoop() {
    console.log('\n=== 测试2：优化循环功能 ===\n');
    
    try {
        // 创建优化循环实例
        const loop = new OptimizationLoop();
        
        // 模拟反馈数据
        const feedbackData = [
            {
                contentId: 'article-001',
                userId: 'user-001',
                avgDepth: 0.85,
                avgDuration: 180,
                totalLikes: 15,
                style: 'professional',
                introStyle: 'story',
                topics: ['AI', '数字化']
            },
            {
                contentId: 'article-002',
                userId: 'user-002',
                avgDepth: 0.72,
                avgDuration: 120,
                totalLikes: 8,
                style: 'casual',
                introStyle: 'question',
                topics: ['自动化', '效率']
            },
            {
                contentId: 'article-003',
                userId: 'user-003',
                avgDepth: 0.91,
                avgDuration: 240,
                totalLikes: 22,
                style: 'professional',
                introStyle: 'story',
                topics: ['AI', '智能制造']
            }
        ];
        
        // 处理反馈
        await loop.processFeedback(feedbackData);
        console.log('✅ 反馈处理完成');
        
        // 获取推荐参数（通过currentParams）
        console.log('📊 当前参数:', loop.currentParams);
        
        // 保存偏好
        loop.savePreferences();
        console.log('✅ 偏好数据已保存');
        
        console.log('\n✅ 优化循环功能测试完成！');
    } catch (error) {
        console.error('❌ 优化循环测试失败:', error.message);
    }
}

/**
 * 测试3：社区仓库更多功能
 */
async function testCommunityMore() {
    console.log('\n=== 测试3：社区仓库更多功能 ===\n');
    
    try {
        const repo = new CommunityRepository();
        
        // 添加插件
        const pluginData = {
            id: 'test-plugin-001',
            name: 'SEO优化插件',
            description: '自动优化文章SEO标题和关键词',
            type: 'plugin',
            category: 'optimization',
            author: '测试开发者',
            email: 'dev@example.com',
            version: '1.0.0',
            code: 'function optimizeSEO(content) { return content; }',
            metadata: {
                tags: ['SEO', '优化'],
                compatibleWith: ['wechat']
            }
        };
        
        await repo.submitPlugin(pluginData);
        console.log('✅ 插件提交成功');
        
        console.log('\n✅ 社区仓库更多功能测试完成！');
    } catch (error) {
        console.error('❌ 社区仓库更多功能测试失败:', error.message);
    }
}

/**
 * 运行所有测试
 */
async function runAllTests() {
    console.log('🚀 开始运行基础功能测试...');
    
    await testCommunityRepository();
    await testOptimizationLoop();
    await testCommunityMore();
    
    console.log('\n🎉 所有基础测试完成！');
}

runAllTests().catch(console.error);