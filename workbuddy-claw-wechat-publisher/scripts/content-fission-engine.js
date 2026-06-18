/**
 * 内容裂变引擎
 * 将长文拆解为多种格式内容：短视频脚本、图文卡片、金句海报
 * 
 * 功能：
 * - 短视频脚本生成（30s/60s/90s）
 * - 图文卡片生成（小红书风格/朋友圈风格）
 * - 金句海报生成（励志/知识/营销）
 */

const path = require('path');
const fs = require('fs');
const { generateVideoScript } = require('./video-platforms/video-script-generator');
const { generateImageCards } = require('./content-fission/image-cards-generator');
const { generateQuotePoster } = require('./content-fission/quote-poster-generator');

/**
 * 内容裂变主函数
 * @param {Object} options
 * @param {string} options.title - 原文标题
 * @param {string} options.content - 原文内容
 * @param {string} options.summary - 原文摘要
 * @param {Array} options.outputs - 输出格式 ['video-script', 'image-cards', 'quote-poster']
 * @param {Object} options.videoOptions - 视频脚本选项
 * @param {Object} options.imageOptions - 图文卡片选项
 * @param {Object} options.quoteOptions - 金句海报选项
 */
async function contentFission(options) {
    console.log('🔄 开始内容裂变...');
    
    const {
        title,
        content,
        summary = '',
        outputs = ['video-script', 'image-cards', 'quote-poster'],
        videoOptions = {},
        imageOptions = {},
        quoteOptions = {}
    } = options;
    
    const results = {
        original: { title, content, summary },
        generated: {},
        timestamp: new Date().toISOString()
    };
    
    // 生成短视频脚本
    if (outputs.includes('video-script')) {
        console.log('🎬 生成短视频脚本...');
        try {
            const videoScript = await generateVideoScript({
                title,
                content,
                summary,
                ...videoOptions
            });
            results.generated.videoScript = videoScript;
            console.log('✅ 短视频脚本生成成功');
        } catch (error) {
            console.error('❌ 短视频脚本生成失败:', error.message);
            results.generated.videoScript = { error: error.message };
        }
    }
    
    // 生成图文卡片
    if (outputs.includes('image-cards')) {
        console.log('🖼️ 生成图文卡片...');
        try {
            const imageCards = await generateImageCards({
                title,
                content,
                summary,
                ...imageOptions
            });
            results.generated.imageCards = imageCards;
            console.log('✅ 图文卡片生成成功');
        } catch (error) {
            console.error('❌ 图文卡片生成失败:', error.message);
            results.generated.imageCards = { error: error.message };
        }
    }
    
    // 生成金句海报
    if (outputs.includes('quote-poster')) {
        console.log('✨ 生成金句海报...');
        try {
            const quotePoster = await generateQuotePoster({
                title,
                content,
                summary,
                ...quoteOptions
            });
            results.generated.quotePoster = quotePoster;
            console.log('✅ 金句海报生成成功');
        } catch (error) {
            console.error('❌ 金句海报生成失败:', error.message);
            results.generated.quotePoster = { error: error.message };
        }
    }
    
    console.log('🎉 内容裂变完成！');
    return results;
}

/**
 * 批量内容裂变
 * @param {Array} articles - 文章数组
 * @param {Object} options - 裂变选项
 */
async function batchContentFission(articles, options = {}) {
    console.log(`🔄 批量内容裂变，共 ${articles.length} 篇文章...`);
    
    const results = [];
    
    for (let i = 0; i < articles.length; i++) {
        console.log(`\n[${i + 1}/${articles.length}] 处理: ${articles[i].title}`);
        try {
            const result = await contentFission({
                ...articles[i],
                ...options
            });
            results.push(result);
        } catch (error) {
            console.error(`❌ 处理失败: ${error.message}`);
            results.push({
                original: articles[i],
                error: error.message,
                timestamp: new Date().toISOString()
            });
        }
    }
    
    console.log(`\n🎉 批量内容裂变完成！成功: ${results.filter(r => !r.error).length}/${results.length}`);
    return results;
}

/**
 * 保存裂变结果到文件
 * @param {Object} result - 裂变结果
 * @param {string} outputDir - 输出目录
 */
function saveFissionResult(result, outputDir) {
    const timestamp = new Date().toISOString().replace(/[:.]/g, '-').slice(0, -5);
    const safeTitle = result.original.title.replace(/[^\w\u4e00-\u9fa5]/g, '_').slice(0, 50);
    const dir = path.join(outputDir, `fission_${timestamp}_${safeTitle}`);
    
    fs.mkdirSync(dir, { recursive: true });
    
    // 保存原始内容
    fs.writeFileSync(
        path.join(dir, 'original.md'),
        `# ${result.original.title}\n\n${result.original.content}`
    );
    
    // 保存短视频脚本
    if (result.generated.videoScript && !result.generated.videoScript.error) {
        fs.writeFileSync(
            path.join(dir, 'video-script.json'),
            JSON.stringify(result.generated.videoScript, null, 2)
        );
        fs.writeFileSync(
            path.join(dir, 'video-script.md'),
            formatVideoScriptAsMarkdown(result.generated.videoScript)
        );
    }
    
    // 保存图文卡片
    if (result.generated.imageCards && !result.generated.imageCards.error) {
        fs.writeFileSync(
            path.join(dir, 'image-cards.json'),
            JSON.stringify(result.generated.imageCards, null, 2)
        );
    }
    
    // 保存金句海报
    if (result.generated.quotePoster && !result.generated.quotePoster.error) {
        fs.writeFileSync(
            path.join(dir, 'quote-poster.json'),
            JSON.stringify(result.generated.quotePoster, null, 2)
        );
    }
    
    // 保存完整结果
    fs.writeFileSync(
        path.join(dir, 'result.json'),
        JSON.stringify(result, null, 2)
    );
    
    console.log(`💾 结果已保存到: ${dir}`);
    return dir;
}

/**
 * 格式化视频脚本为Markdown
 */
function formatVideoScriptAsMarkdown(script) {
    let md = `# ${script.title || '短视频脚本'}\n\n`;
    md += `**时长**: ${script.duration || '60s'}\n`;
    md += `**风格**: ${script.style || 'documentary'}\n\n`;
    
    if (script.scenes && script.scenes.length > 0) {
        md += `## 分镜列表\n\n`;
        script.scenes.forEach((scene, index) => {
            md += `### 场景 ${index + 1}\n`;
            md += `- **时间**: ${scene.time || '3s'}\n`;
            md += `- **画面**: ${scene.visual || ''}\n`;
            md += `- **旁白**: ${scene.voiceover || ''}\n`;
            md += `- **字幕**: ${scene.subtitle || ''}\n\n`;
        });
    }
    
    if (script.music) {
        md += `## 音乐建议\n\n${script.music}\n`;
    }
    
    return md;
}

module.exports = {
    contentFission,
    batchContentFission,
    saveFissionResult
};