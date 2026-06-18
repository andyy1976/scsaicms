/**
 * AI风格分析器
 * 支持通过自然语言提示词解析并匹配风格模板
 */

const { PresetStyles } = require('./style-manager');

/**
 * 风格关键词映射表
 */
const StyleKeywords = {
    tech: [
        '科技', '技术', '人工智能', 'AI', '数字化', '互联网', '创新',
        '前沿', '未来', '高科技', '数码', '编程', '软件', '数据', '云计算'
    ],
    business: [
        '商务', '企业', '商业', '金融', '投资', '管理', '财经', '职场',
        '专业', '严谨', '报告', '分析', '行业', '市场', '战略', '高管'
    ],
    fresh: [
        '清新', '自然', '生活', '健康', '环保', '绿色', '有机', '田园',
        '简约', '舒适', '轻松', '活力', '青春', '阳光', '美食', '旅行'
    ],
    vintage: [
        '复古', '经典', '怀旧', '文化', '历史', '传统', '文艺', '艺术',
        '典雅', '古朴', '怀旧', '人文', '诗词', '书法', '绘画', '古典'
    ],
    minimal: [
        '极简', '简约', '现代', '设计', '美学', '纯粹', '干净', '留白',
        '时尚', '优雅', '精致', '高端', '极简主义', '无印良品', '北欧'
    ],
    energetic: [
        '活力', '热情', '年轻', '潮流', '娱乐', '运动', '动感', '橙色',
        '活泼', '欢快', '热闹', '时尚', '酷炫', '个性', '张扬'
    ],
    warm: [
        '温馨', '浪漫', '情感', '爱情', '家庭', '亲情', '友情', '粉色',
        '温柔', '甜美', '治愈', '感动', '暖心', '幸福', '美好'
    ],
    dark: [
        '深色', '暗色', '夜间', '护眼', '暗黑', '神秘', '炫酷', '黑色',
        '低调', '沉稳', '夜间模式', '护眼模式', '深色主题'
    ]
};

/**
 * 风格分析器
 */
class StyleAnalyzer {
    constructor() {
        this.styles = PresetStyles;
        this.keywords = StyleKeywords;
    }
    
    /**
     * 分析提示词，匹配最佳风格
     * @param {string} prompt - 用户输入的风格提示词
     * @returns {object} - 匹配结果
     */
    analyze(prompt) {
        if (!prompt || typeof prompt !== 'string') {
            return {
                success: false,
                message: '提示词不能为空',
                style: null,
                confidence: 0
            };
        }
        
        const normalizedPrompt = prompt.trim().toLowerCase();
        
        // 1. 精确匹配风格名称
        for (const [key, style] of Object.entries(this.styles)) {
            if (normalizedPrompt.includes(key.toLowerCase())) {
                return {
                    success: true,
                    message: `精确匹配到风格: ${style.name}`,
                    style: key,
                    confidence: 1.0,
                    styleData: style
                };
            }
            if (normalizedPrompt.includes(style.name)) {
                return {
                    success: true,
                    message: `精确匹配到风格: ${style.name}`,
                    style: key,
                    confidence: 0.95,
                    styleData: style
                };
            }
        }
        
        // 2. 关键词匹配
        const scores = {};
        for (const [styleKey, keywords] of Object.entries(this.keywords)) {
            let score = 0;
            for (const keyword of keywords) {
                if (normalizedPrompt.includes(keyword)) {
                    score += 1;
                }
            }
            scores[styleKey] = score;
        }
        
        // 找到最高分
        let maxScore = 0;
        let bestStyle = null;
        for (const [styleKey, score] of Object.entries(scores)) {
            if (score > maxScore) {
                maxScore = score;
                bestStyle = styleKey;
            }
        }
        
        if (bestStyle && maxScore > 0) {
            const confidence = Math.min(1.0, maxScore / 5);
            return {
                success: true,
                message: `通过关键词匹配到风格: ${this.styles[bestStyle].name}`,
                style: bestStyle,
                confidence: confidence,
                styleData: this.styles[bestStyle],
                matchedKeywords: this.keywords[bestStyle].filter(k => 
                    normalizedPrompt.includes(k)
                )
            };
        }
        
        // 3. AI辅助分析（如果有AI可用）
        const aiAnalysis = this.aiAnalyze(prompt);
        if (aiAnalysis) {
            return aiAnalysis;
        }
        
        // 4. 默认返回科技风格
        return {
            success: true,
            message: '未找到匹配风格，使用默认科技风格',
            style: 'tech',
            confidence: 0.5,
            styleData: this.styles.tech
        };
    }
    
    /**
     * AI辅助分析（简化版，基于规则）
     */
    aiAnalyze(prompt) {
        const normalized = prompt.toLowerCase();
        
        // 情感分析
        const positiveWords = ['温馨', '美好', '幸福', '治愈', '温暖', '浪漫'];
        const negativeWords = ['神秘', '深沉', '暗黑', '酷炫'];
        const professionalWords = ['专业', '严谨', '分析', '报告'];
        const creativeWords = ['创意', '设计', '艺术', '美学'];
        
        let score = 0;
        let style = null;
        
        // 根据情感判断
        for (const word of positiveWords) {
            if (normalized.includes(word)) {
                style = 'warm';
                score += 2;
            }
        }
        
        for (const word of negativeWords) {
            if (normalized.includes(word)) {
                style = 'dark';
                score += 2;
            }
        }
        
        for (const word of professionalWords) {
            if (normalized.includes(word)) {
                style = 'business';
                score += 2;
            }
        }
        
        for (const word of creativeWords) {
            if (normalized.includes(word)) {
                style = 'minimal';
                score += 2;
            }
        }
        
        if (style && score > 0) {
            return {
                success: true,
                message: `AI分析匹配到风格: ${this.styles[style].name}`,
                style: style,
                confidence: Math.min(0.8, score / 5),
                styleData: this.styles[style]
            };
        }
        
        return null;
    }
    
    /**
     * 获取风格建议
     * @param {string} prompt - 用户输入的提示词
     * @returns {array} - 风格建议列表
     */
    getSuggestions(prompt) {
        if (!prompt) {
            return Object.values(this.styles).map((style, index) => ({
                ...style,
                key: Object.keys(this.styles)[index],
                recommended: index === 0
            }));
        }
        
        const normalizedPrompt = prompt.toLowerCase();
        const suggestions = [];
        
        for (const [key, style] of Object.entries(this.styles)) {
            let matchCount = 0;
            
            // 检查风格名称
            if (normalizedPrompt.includes(key) || 
                normalizedPrompt.includes(style.name)) {
                matchCount += 3;
            }
            
            // 检查关键词
            const keywords = this.keywords[key] || [];
            for (const keyword of keywords) {
                if (normalizedPrompt.includes(keyword)) {
                    matchCount += 1;
                }
            }
            
            if (matchCount > 0) {
                suggestions.push({
                    ...style,
                    key,
                    matchCount,
                    confidence: Math.min(1.0, matchCount / 8)
                });
            }
        }
        
        // 按匹配度排序
        suggestions.sort((a, b) => b.matchCount - a.matchCount);
        
        return suggestions;
    }
    
    /**
     * 生成风格配置代码
     * @param {string} styleKey - 风格键名
     * @returns {string} - CSS变量代码
     */
    generateCSS(styleKey) {
        const style = this.styles[styleKey];
        if (!style) {
            return '';
        }
        
        let css = ':root {\n';
        Object.entries(style.variables).forEach(([key, value]) => {
            css += `  --${key}: ${value};\n`;
        });
        css += '}';
        
        return css;
    }
    
    /**
     * 获取所有可用风格列表
     */
    getStyleList() {
        return Object.entries(this.styles).map(([key, style]) => ({
            key,
            name: style.name,
            description: style.description,
            primaryColor: style.variables.primary,
            keywords: this.keywords[key] || []
        }));
    }
}

module.exports = { StyleAnalyzer, StyleKeywords };
