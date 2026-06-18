/**
 * 金句海报生成器
 * 从文章中提取金句，生成海报文案
 */

const path = require('path');
const fs = require('fs');

/**
 * 加载AI配置
 */
function loadAIProviders() {
    const configPath = path.join(__dirname, '../../config/ai-providers.json');
    if (fs.existsSync(configPath)) {
        const config = JSON.parse(fs.readFileSync(configPath, 'utf-8'));
        return config.providers || [];
    }
    return [];
}

/**
 * 调用AI接口
 */
async function callAI(prompt, provider) {
    const axios = require('axios');
    
    const response = await axios.post(
        provider.baseUrl,
        {
            model: provider.models[0],
            messages: [
                { role: 'system', content: '你是一个专业的文案创作助手，擅长从文章中提炼金句和核心观点。' },
                { role: 'user', content: prompt }
            ],
            temperature: 0.8,
            max_tokens: 1500
        },
        {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': provider.headers?.Authorization || `Bearer ${provider.apiKey}`
            }
        }
    );
    
    return response.data.choices[0].message.content;
}

/**
 * 构建金句海报生成提示词
 */
function buildQuotePosterPrompt(options) {
    const { title, content, summary, type = 'inspirational', quoteCount = 5 } = options;
    
    const typeGuide = {
        inspirational: '励志金句：积极向上、激励人心、适合朋友圈分享',
        knowledge: '知识金句：专业见解、行业洞察、适合知识分享',
        marketing: '营销金句：产品价值、用户痛点、适合广告宣传'
    };
    
    return `
请从以下文章中提取 ${quoteCount} 条金句，类型：${typeGuide[type]}

文章标题：${title}
文章摘要：${summary}
文章内容：
${content.slice(0, 3000)}

要求：
1. 每条金句不超过30字，简洁有力
2. 体现文章核心观点或价值
3. 适合作为海报文案
4. 每条金句配一个简短的解释（不超过50字）
5. 提供海报设计建议（配色、风格、排版）

请以JSON格式返回，格式如下：
{
  "type": "${type}",
  "totalQuotes": ${quoteCount},
  "quotes": [
    {
      "index": 1,
      "quote": "金句内容",
      "explanation": "金句解释",
      "designSuggestion": {
        "color": "配色建议",
        "style": "风格建议",
        "layout": "排版建议"
      }
    }
  ]
}
`;
}

/**
 * 生成金句海报
 */
async function generateQuotePoster(options) {
    console.log('✨ 生成金句海报...');
    
    const aiProviders = loadAIProviders();
    const prompt = buildQuotePosterPrompt(options);
    
    let result = null;
    for (const provider of aiProviders) {
        try {
            console.log(`🤖 尝试 ${provider.name}...`);
            const response = await callAI(prompt, provider);
            
            // 解析JSON响应
            const jsonMatch = response.match(/\{[\s\S]*\}/);
            if (jsonMatch) {
                result = JSON.parse(jsonMatch[0]);
                console.log(`✅ ${provider.name} 成功`);
                break;
            }
        } catch (e) {
            console.log(`❌ ${provider.name} 失败: ${e.message}`);
        }
    }
    
    if (!result) {
        throw new Error('所有 AI 模型调用失败');
    }
    
    return result;
}

/**
 * 生成金句海报HTML预览
 */
function generateQuotePosterHTML(quotes, outputPath) {
    const colorSchemes = {
        inspirational: { bg: 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)', text: '#fff' },
        knowledge: { bg: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)', text: '#fff' },
        marketing: { bg: 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)', text: '#fff' }
    };
    
    const scheme = colorSchemes[quotes.type] || colorSchemes.inspirational;
    
    const html = `
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>金句海报预览</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f5f5; padding: 20px; }
        .poster-container { max-width: 800px; margin: 0 auto; }
        .poster { background: ${scheme.bg}; border-radius: 20px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .poster-content { padding: 40px; text-align: center; color: ${scheme.text}; }
        .poster-quote { font-size: 32px; font-weight: 700; margin-bottom: 20px; line-height: 1.4; }
        .poster-explanation { font-size: 16px; opacity: 0.9; margin-bottom: 30px; }
        .poster-design { background: rgba(255,255,255,0.2); padding: 15px; border-radius: 10px; font-size: 14px; }
        .poster-design-item { margin-bottom: 5px; }
        .poster-design-label { font-weight: 600; opacity: 0.8; }
    </style>
</head>
<body>
    <div class="poster-container">
        ${quotes.quotes.map(quote => `
            <div class="poster">
                <div class="poster-content">
                    <div class="poster-quote">"${quote.quote}"</div>
                    <div class="poster-explanation">${quote.explanation}</div>
                    <div class="poster-design">
                        <div class="poster-design-item"><span class="poster-design-label">配色：</span>${quote.designSuggestion.color}</div>
                        <div class="poster-design-item"><span class="poster-design-label">风格：</span>${quote.designSuggestion.style}</div>
                        <div class="poster-design-item"><span class="poster-design-label">排版：</span>${quote.designSuggestion.layout}</div>
                    </div>
                </div>
            </div>
        `).join('')}
    </div>
</body>
</html>
`;
    
    fs.writeFileSync(outputPath, html);
    console.log(`📄 HTML预览已保存: ${outputPath}`);
}

module.exports = {
    generateQuotePoster,
    generateQuotePosterHTML
};