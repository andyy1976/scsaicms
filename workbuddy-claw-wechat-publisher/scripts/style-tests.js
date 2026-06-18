/**
 * 风格分析器测试脚本
 */

const { StyleAnalyzer } = require('./style-analyzer');

const analyzer = new StyleAnalyzer();

console.log('🚀 开始测试风格分析器\n');

// 测试用例
const testCases = [
    '科技感十足的AI文章',
    '商务金融分析报告',
    '清新自然的生活随笔',
    '复古文艺风格',
    '极简设计美学',
    '活力四射的运动文章',
    '温馨浪漫的爱情故事',
    '深色护眼模式',
    '人工智能数字化转型',
    '专业严谨的企业报告',
    '田园生活绿色环保',
    '古典文化历史传承',
    '北欧简约现代设计',
    '青春洋溢时尚潮流',
    '家庭亲情温暖人心',
    '夜间阅读保护视力'
];

console.log('=== 测试1：提示词匹配 ===\n');

testCases.forEach((prompt, index) => {
    const result = analyzer.analyze(prompt);
    const status = result.success ? '✅' : '❌';
    const conf = (result.confidence * 100).toFixed(0);
    
    console.log(`${status} [${index + 1}] "${prompt}"`);
    console.log(`     → ${result.message}`);
    console.log(`     → 风格: ${result.styleData?.name || '未知'}, 置信度: ${conf}%`);
    
    if (result.matchedKeywords && result.matchedKeywords.length > 0) {
        console.log(`     → 匹配关键词: ${result.matchedKeywords.join(', ')}`);
    }
    console.log();
});

console.log('=== 测试2：获取风格建议 ===\n');

const suggestions = analyzer.getSuggestions('科技感AI文章');
console.log('输入: "科技感AI文章"');
console.log('推荐风格:');
suggestions.forEach((suggestion, index) => {
    console.log(`  ${index + 1}. ${suggestion.name} - ${suggestion.description}`);
    console.log(`     匹配度: ${(suggestion.confidence * 100).toFixed(0)}%`);
});

console.log('\n=== 测试3：获取所有风格列表 ===\n');
const styleList = analyzer.getStyleList();
styleList.forEach(style => {
    console.log(`🎨 ${style.name}`);
    console.log(`   描述: ${style.description}`);
    console.log(`   主色调: ${style.primaryColor}`);
    console.log(`   关键词: ${style.keywords.slice(0, 3).join(', ')}...`);
    console.log();
});

console.log('=== 测试4：生成CSS变量 ===\n');
const css = analyzer.generateCSS('tech');
console.log('科技风格CSS变量:');
console.log(css);

console.log('\n🎉 所有测试完成！');
