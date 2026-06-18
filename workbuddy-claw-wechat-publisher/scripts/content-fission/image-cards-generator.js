/**
 * 图文卡片生成器
 * 将文章内容转换为小红书/朋友圈风格的图文卡片
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
                { role: 'system', content: '你是一个专业的内容创作助手，擅长将长文转化为适合社交媒体传播的图文卡片内容。' },
                { role: 'user', content: prompt }
            ],
            temperature: 0.7,
            max_tokens: 2000
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
 * 构建图文卡片生成提示词
 */
function buildImageCardsPrompt(options) {
    const { title, content, summary, style = 'xiaohongshu', cardCount = 6 } = options;
    
    const styleGuide = {
        xiaohongshu: '小红书风格：口语化、emoji丰富、分段清晰、带话题标签',
        wechat: '朋友圈风格：简洁有力、适合快速阅读、带个人观点',
        douyin: '抖音风格：节奏快、有钩子、带行动号召'
    };
    
    return `
请将以下文章内容拆解为 ${cardCount} 张图文卡片，风格：${styleGuide[style]}

文章标题：${title}
文章摘要：${summary}
文章内容：
${content.slice(0, 3000)}

要求：
1. 每张卡片包含：标题、正文内容、配图建议
2. 标题要吸引人，不超过20字
3. 正文内容简洁，每张不超过100字
4. 配图建议要具体，描述画面风格和元素
5. 小红书风格要加emoji和话题标签
6. 最后一张卡片要有行动号召

请以JSON格式返回，格式如下：
{
  "style": "${style}",
  "totalCards": ${cardCount},
  "cards": [
    {
      "index": 1,
      "title": "卡片标题",
      "content": "卡片内容",
      "imageSuggestion": "配图建议",
      "hashtags": ["#标签1", "#标签2"]
    }
  ]
}
`;
}

/**
 * 生成图文卡片
 */
async function generateImageCards(options) {
    console.log('🖼️ 生成图文卡片...');
    
    const aiProviders = loadAIProviders();
    const prompt = buildImageCardsPrompt(options);
    
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
 * 生成图文卡片HTML预览
 */
function generateImageCardsHTML(cards, outputPath) {
    const html = `
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>图文卡片预览</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f5f5; padding: 20px; }
        .card-container { max-width: 800px; margin: 0 auto; }
        .card { background: white; border-radius: 16px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .card-image { height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; padding: 20px; text-align: center; }
        .card-content { padding: 20px; }
        .card-title { font-size: 18px; font-weight: 700; margin-bottom: 12px; color: #333; }
        .card-text { font-size: 15px; line-height: 1.6; color: #666; margin-bottom: 12px; }
        .card-tags { display: flex; flex-wrap: wrap; gap: 8px; }
        .tag { background: #f0f0f0; padding: 4px 12px; border-radius: 12px; font-size: 13px; color: #666; }
    </style>
</head>
<body>
    <div class="card-container">
        ${cards.cards.map(card => `
            <div class="card">
                <div class="card-image">${card.imageSuggestion}</div>
                <div class="card-content">
                    <div class="card-title">${card.title}</div>
                    <div class="card-text">${card.content}</div>
                    <div class="card-tags">
                        ${card.hashtags.map(tag => `<span class="tag">${tag}</span>`).join('')}
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
    generateImageCards,
    generateImageCardsHTML
};