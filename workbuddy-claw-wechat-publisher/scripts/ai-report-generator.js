/**
 * AI内容效果分析报告生成器
 * 自动生成每周/每月内容效果分析报告
 * 
 * 功能：
 * - 收集阅读反馈数据（时长、深度、点赞、分享）
 * - 分析热门内容、用户偏好、趋势变化
 * - 生成优化建议
 * - 支持周报、月报两种模式
 */

const path = require('path');
const fs = require('fs');
const axios = require('axios');

/**
 * CMS数据库连接
 */
function connectToCMS() {
    const mysql = require('mysql2/promise');
    const configPath = path.join(__dirname, '../../config/user-config.json');
    
    if (fs.existsSync(configPath)) {
        const config = JSON.parse(fs.readFileSync(configPath, 'utf-8'));
        return mysql.createConnection({
            host: config.cms?.host || 'localhost',
            user: config.cms?.user || 'root',
            password: config.cms?.password || '',
            database: config.cms?.database || 'lvbo_cms',
            port: config.cms?.port || 3306
        });
    }
    
    return null;
}

/**
 * 收集阅读反馈数据
 */
async function collectFeedbackData(connection, startDate, endDate) {
    console.log(`📊 收集数据: ${startDate} ~ ${endDate}`);
    
    const [rows] = await connection.execute(`
        SELECT 
            rf.aid,
            a.title,
            a.description,
            a.typeid,
            COUNT(*) as total_reads,
            AVG(rf.duration) as avg_duration,
            AVG(rf.scroll_depth) as avg_depth,
            SUM(CASE WHEN rf.action = 'like' THEN 1 ELSE 0 END) as total_likes,
            SUM(CASE WHEN rf.action = 'share' THEN 1 ELSE 0 END) as total_shares,
            MIN(rf.created_at) as first_read,
            MAX(rf.created_at) as last_read
        FROM lvbo_read_feedback rf
        LEFT JOIN lvbo_article a ON rf.aid = a.aid
        WHERE rf.created_at BETWEEN ? AND ?
        GROUP BY rf.aid, a.title, a.description, a.typeid
        ORDER BY total_reads DESC
    `, [startDate, endDate]);
    
    return rows;
}

/**
 * 分析内容表现
 */
function analyzeContentPerformance(data) {
    console.log('🔍 分析内容表现...');
    
    const analysis = {
        totalArticles: data.length,
        totalReads: data.reduce((sum, item) => sum + item.total_reads, 0),
        avgDuration: data.reduce((sum, item) => sum + (item.avg_duration || 0), 0) / data.length,
        avgDepth: data.reduce((sum, item) => sum + (item.avg_depth || 0), 0) / data.length,
        totalLikes: data.reduce((sum, item) => sum + (item.total_likes || 0), 0),
        totalShares: data.reduce((sum, item) => sum + (item.total_shares || 0), 0),
        topArticles: data.slice(0, 10),
        lowPerformingArticles: data.slice(-5).reverse(),
        insights: []
    };
    
    // 生成洞察
    if (analysis.avgDuration > 60) {
        analysis.insights.push('用户平均阅读时长超过60秒，内容质量较高');
    } else {
        analysis.insights.push('用户平均阅读时长较短，建议优化内容开头和结构');
    }
    
    if (analysis.avgDepth > 0.7) {
        analysis.insights.push('用户阅读深度超过70%，完读率良好');
    } else {
        analysis.insights.push('用户阅读深度较低，建议增加互动元素和分段');
    }
    
    const likeRate = analysis.totalLikes / analysis.totalReads;
    if (likeRate > 0.1) {
        analysis.insights.push('点赞率超过10%，用户对内容认可度高');
    } else {
        analysis.insights.push('点赞率较低，建议增加情感共鸣和行动号召');
    }
    
    return analysis;
}

/**
 * 加载AI配置
 */
function loadAIProviders() {
    const configPath = path.join(__dirname, '../../config/ai-providers.json');
    if (fs.existsSync(configPath)) {
        return JSON.parse(fs.readFileSync(configPath, 'utf-8'));
    }
    return [];
}

/**
 * 调用AI生成报告
 */
async function generateAIReport(analysis, reportType) {
    console.log('🤖 AI生成报告...');
    
    const aiProviders = loadAIProviders();
    const prompt = buildReportPrompt(analysis, reportType);
    
    for (const provider of aiProviders) {
        try {
            console.log(`🤖 尝试 ${provider.name}...`);
            const response = await axios.post(
                provider.endpoint,
                {
                    model: provider.model,
                    messages: [
                        { role: 'system', content: '你是一个专业的内容分析顾问，擅长从数据中发现洞察并提供可执行的建议。' },
                        { role: 'user', content: prompt }
                    ],
                    temperature: 0.7,
                    max_tokens: 3000
                },
                {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${provider.apiKey}`
                    }
                }
            );
            
            console.log(`✅ ${provider.name} 成功`);
            return response.data.choices[0].message.content;
        } catch (e) {
            console.log(`❌ ${provider.name} 失败: ${e.message}`);
        }
    }
    
    throw new Error('所有 AI 模型调用失败');
}

/**
 * 构建报告提示词
 */
function buildReportPrompt(analysis, reportType) {
    const reportTitle = reportType === 'weekly' ? '周报' : '月报';
    
    return `
请基于以下内容效果数据，生成一份${reportTitle}分析报告。

## 数据概览
- 总文章数: ${analysis.totalArticles}
- 总阅读量: ${analysis.totalReads}
- 平均阅读时长: ${Math.round(analysis.avgDuration)}秒
- 平均阅读深度: ${Math.round(analysis.avgDepth * 100)}%
- 总点赞数: ${analysis.totalLikes}
- 总分享数: ${analysis.totalShares}

## 热门文章TOP5
${analysis.topArticles.slice(0, 5).map((item, index) => `
${index + 1}. ${item.title}
   - 阅读量: ${item.total_reads}
   - 平均时长: ${Math.round(item.avg_duration)}秒
   - 阅读深度: ${Math.round(item.avg_depth * 100)}%
   - 点赞: ${item.total_likes}
   - 分享: ${item.total_shares}
`).join('\n')}

## 表现不佳文章
${analysis.lowPerformingArticles.map((item, index) => `
${index + 1}. ${item.title}
   - 阅读量: ${item.total_reads}
   - 平均时长: ${Math.round(item.avg_duration)}秒
   - 阅读深度: ${Math.round(item.avg_depth * 100)}%
`).join('\n')}

## 基础洞察
${analysis.insights.map(insight => `- ${insight}`).join('\n')}

请生成一份结构化的${reportTitle}，包括：
1. **数据概览**：关键指标总结
2. **热门内容分析**：TOP5文章的共同特点
3. **问题诊断**：表现不佳文章的共性问题
4. **优化建议**：3-5条具体可执行的建议
5. **下周/月计划**：基于数据的行动建议

请用Markdown格式输出，语言简洁专业。
`;
}

/**
 * 生成完整报告
 */
async function generateContentReport(options = {}) {
    const {
        reportType = 'weekly', // weekly | monthly
        startDate,
        endDate,
        outputDir = path.join(__dirname, '../../output/reports')
    } = options;
    
    console.log(`📊 开始生成${reportType === 'weekly' ? '周报' : '月报'}...`);
    
    // 计算日期范围
    if (!startDate || !endDate) {
        const now = new Date();
        const days = reportType === 'weekly' ? 7 : 30;
        endDate = now.toISOString().split('T')[0];
        startDate = new Date(now - days * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
    }
    
    // 连接CMS数据库
    const connection = await connectToCMS();
    if (!connection) {
        throw new Error('无法连接CMS数据库');
    }
    
    try {
        // 收集数据
        const data = await collectFeedbackData(connection, startDate, endDate);
        
        if (data.length === 0) {
            console.log('⚠️  该时间段内无数据');
            return null;
        }
        
        // 分析数据
        const analysis = analyzeContentPerformance(data);
        
        // AI生成报告
        const aiReport = await generateAIReport(analysis, reportType);
        
        // 组装完整报告
        const report = {
            reportType,
            startDate,
            endDate,
            generatedAt: new Date().toISOString(),
            data: analysis,
            aiAnalysis: aiReport
        };
        
        // 保存报告
        fs.mkdirSync(outputDir, { recursive: true });
        const timestamp = new Date().toISOString().replace(/[:.]/g, '-').slice(0, -5);
        const reportPath = path.join(outputDir, `content-report-${reportType}-${timestamp}.json`);
        const markdownPath = path.join(outputDir, `content-report-${reportType}-${timestamp}.md`);
        
        fs.writeFileSync(reportPath, JSON.stringify(report, null, 2));
        fs.writeFileSync(markdownPath, generateMarkdownReport(report));
        
        console.log(`✅ 报告生成成功！`);
        console.log(`📄 JSON: ${reportPath}`);
        console.log(`📄 Markdown: ${markdownPath}`);
        
        return report;
    } finally {
        await connection.end();
    }
}

/**
 * 生成Markdown格式报告
 */
function generateMarkdownReport(report) {
    const typeLabel = report.reportType === 'weekly' ? '周报' : '月报';
    
    return `# 内容效果分析${typeLabel}

**报告周期**: ${report.startDate} ~ ${report.endDate}  
**生成时间**: ${report.generatedAt}

---

## 数据概览

| 指标 | 数值 |
|------|------|
| 总文章数 | ${report.data.totalArticles} |
| 总阅读量 | ${report.data.totalReads} |
| 平均阅读时长 | ${Math.round(report.data.avgDuration)}秒 |
| 平均阅读深度 | ${Math.round(report.data.avgDepth * 100)}% |
| 总点赞数 | ${report.data.totalLikes} |
| 总分享数 | ${report.data.totalShares} |

---

${report.aiAnalysis}

---

*本报告由AI自动生成，仅供参考*
`;
}

/**
 * 定时生成报告任务
 */
async function scheduleReportGeneration() {
    console.log('⏰ 启动报告生成定时任务...');
    
    // 每周一早上9点生成周报
    setInterval(async () => {
        const now = new Date();
        if (now.getDay() === 1 && now.getHours() === 9) {
            console.log('📊 开始生成周报...');
            await generateContentReport({ reportType: 'weekly' });
        }
    }, 60 * 60 * 1000); // 每小时检查一次
    
    // 每月1号早上9点生成月报
    setInterval(async () => {
        const now = new Date();
        if (now.getDate() === 1 && now.getHours() === 9) {
            console.log('📊 开始生成月报...');
            await generateContentReport({ reportType: 'monthly' });
        }
    }, 60 * 60 * 1000);
}

module.exports = {
    generateContentReport,
    scheduleReportGeneration,
    collectFeedbackData,
    analyzeContentPerformance
};