/**
 * 标准风格变量系统
 * 定义主题色彩、字体、间距等核心样式变量
 */

const StyleVariables = {
    // 主题色彩
    primary: '#097cf2',
    primaryDark: '#075bb5',
    primaryLight: '#3a98f5',
    
    // 辅助色彩
    secondary: '#6c757d',
    success: '#00b894',
    warning: '#fdcb6e',
    danger: '#ef4444',
    info: '#74b9ff',
    
    // 中性色彩
    white: '#ffffff',
    gray50: '#f8fafc',
    gray100: '#f1f5f9',
    gray200: '#e2e8f0',
    gray300: '#cbd5e1',
    gray400: '#94a3b8',
    gray500: '#64748b',
    gray600: '#475569',
    gray700: '#334155',
    gray800: '#1e293b',
    gray900: '#0f172a',
    
    // 字体
    fontFamily: '"Microsoft Yahei", "PingFangSC-Light", "Helvetica Neue", Helvetica, Arial, sans-serif',
    fontFamilyHeading: '"Microsoft Yahei", "PingFangSC-Semibold", "Helvetica Neue", Helvetica, Arial, sans-serif',
    
    // 字体大小
    fontSizeXS: '12px',
    fontSizeSM: '14px',
    fontSizeBase: '16px',
    fontSizeLG: '18px',
    fontSizeXL: '24px',
    fontSizeXXL: '32px',
    fontSizeXXXL: '40px',
    
    // 间距
    spacingXS: '4px',
    spacingSM: '8px',
    spacingMD: '16px',
    spacingLG: '24px',
    spacingXL: '32px',
    spacingXXL: '48px',
    
    // 圆角
    borderRadiusSM: '4px',
    borderRadiusMD: '8px',
    borderRadiusLG: '12px',
    borderRadiusXL: '16px',
    borderRadiusFull: '9999px',
    
    // 阴影
    shadowSM: '0 2px 4px rgba(0,0,0,0.05)',
    shadowMD: '0 4px 12px rgba(0,0,0,0.08)',
    shadowLG: '0 8px 24px rgba(0,0,0,0.12)',
    shadowXL: '0 16px 48px rgba(0,0,0,0.16)',
    
    // 过渡
    transitionFast: '0.15s ease',
    transitionNormal: '0.3s ease',
    transitionSlow: '0.5s ease',
    
    // 布局
    containerMaxWidth: '1200px',
    contentWidth: '800px',
    sidebarWidth: '300px',
    
    // 文章样式
    articleLineHeight: '1.8',
    articleParagraphSpacing: '16px',
    articleTitleSize: '32px',
    articleHeadingSize: '20px',
    articleTextColor: '#333333',
    articleMetaColor: '#999999'
};

/**
 * 预设风格配置
 */
const PresetStyles = {
    // 科技风格 - 蓝色系，现代感
    tech: {
        name: '科技风格',
        description: '现代科技感，蓝色主调，适合科技类文章',
        variables: {
            primary: '#0077ff',
            primaryDark: '#0055cc',
            primaryLight: '#3399ff',
            accent: '#00d4ff',
            backgroundColor: '#f0f5ff',
            cardBackground: '#ffffff',
            textColor: '#1a1a2e',
            textSecondary: '#4a5568',
            borderColor: '#e6f0ff',
            shadow: '0 4px 16px rgba(0, 119, 255, 0.1)',
            articleLineHeight: '1.8',
            articleTextColor: '#2d3748'
        }
    },
    
    // 商务风格 - 灰色系，专业感
    business: {
        name: '商务风格',
        description: '专业商务风格，灰色主调，适合企业资讯',
        variables: {
            primary: '#2c3e50',
            primaryDark: '#1a252f',
            primaryLight: '#4a6077',
            accent: '#3498db',
            backgroundColor: '#f8f9fa',
            cardBackground: '#ffffff',
            textColor: '#2c3e50',
            textSecondary: '#7f8c8d',
            borderColor: '#ecf0f1',
            shadow: '0 2px 8px rgba(44, 62, 80, 0.08)',
            articleLineHeight: '1.7',
            articleTextColor: '#34495e'
        }
    },
    
    // 清新风格 - 绿色系，自然感
    fresh: {
        name: '清新风格',
        description: '清新自然风格，绿色主调，适合生活类文章',
        variables: {
            primary: '#27ae60',
            primaryDark: '#1e8449',
            primaryLight: '#58d68d',
            accent: '#f39c12',
            backgroundColor: '#f0fff4',
            cardBackground: '#ffffff',
            textColor: '#27ae60',
            textSecondary: '#7f8c8d',
            borderColor: '#d5f5e3',
            shadow: '0 4px 12px rgba(39, 174, 96, 0.08)',
            articleLineHeight: '1.9',
            articleTextColor: '#2c3e50'
        }
    },
    
    // 复古风格 - 棕色系，经典感
    vintage: {
        name: '复古风格',
        description: '经典复古风格，棕色主调，适合文化类文章',
        variables: {
            primary: '#8b4513',
            primaryDark: '#5d2f0c',
            primaryLight: '#a0522d',
            accent: '#cd853f',
            backgroundColor: '#fdfbf7',
            cardBackground: '#faf7f2',
            textColor: '#5d4e37',
            textSecondary: '#8b7355',
            borderColor: '#e8e0d5',
            shadow: '0 4px 16px rgba(139, 69, 19, 0.1)',
            articleLineHeight: '2.0',
            articleTextColor: '#4a3728',
            fontFamily: '"SimSun", "Songti SC", "STSong", serif'
        }
    },
    
    // 极简风格 - 黑白灰，简洁感
    minimal: {
        name: '极简风格',
        description: '极简主义风格，黑白灰主调，适合设计类文章',
        variables: {
            primary: '#000000',
            primaryDark: '#333333',
            primaryLight: '#666666',
            accent: '#000000',
            backgroundColor: '#ffffff',
            cardBackground: '#ffffff',
            textColor: '#1a1a1a',
            textSecondary: '#666666',
            borderColor: '#eeeeee',
            shadow: 'none',
            articleLineHeight: '1.8',
            articleTextColor: '#1a1a1a'
        }
    },
    
    // 活力风格 - 橙色系，年轻感
    energetic: {
        name: '活力风格',
        description: '年轻活力风格，橙色主调，适合娱乐类文章',
        variables: {
            primary: '#e67e22',
            primaryDark: '#d35400',
            primaryLight: '#f39c12',
            accent: '#e74c3c',
            backgroundColor: '#fff8f0',
            cardBackground: '#ffffff',
            textColor: '#d35400',
            textSecondary: '#7f8c8d',
            borderColor: '#ffe8cc',
            shadow: '0 4px 16px rgba(230, 126, 34, 0.12)',
            articleLineHeight: '1.8',
            articleTextColor: '#2c3e50'
        }
    },
    
    // 温馨风格 - 粉色系，温暖感
    warm: {
        name: '温馨风格',
        description: '温馨浪漫风格，粉色主调，适合情感类文章',
        variables: {
            primary: '#e91e8c',
            primaryDark: '#c2185b',
            primaryLight: '#f06292',
            accent: '#ff80ab',
            backgroundColor: '#fdf2f8',
            cardBackground: '#ffffff',
            textColor: '#c2185b',
            textSecondary: '#7f8c8d',
            borderColor: '#fce4ec',
            shadow: '0 4px 16px rgba(233, 30, 140, 0.08)',
            articleLineHeight: '1.9',
            articleTextColor: '#4a4a4a'
        }
    },
    
    // 深色模式 - 暗色主题
    dark: {
        name: '深色模式',
        description: '暗色主题，护眼舒适，适合夜间阅读',
        variables: {
            primary: '#60a5fa',
            primaryDark: '#3b82f6',
            primaryLight: '#93c5fd',
            accent: '#a78bfa',
            backgroundColor: '#0f172a',
            cardBackground: '#1e293b',
            textColor: '#f1f5f9',
            textSecondary: '#94a3b8',
            borderColor: '#334155',
            shadow: '0 4px 16px rgba(0, 0, 0, 0.3)',
            articleLineHeight: '1.8',
            articleTextColor: '#e2e8f0'
        }
    }
};

/**
 * 风格配置管理器
 */
class StyleManager {
    constructor() {
        this.currentStyle = 'tech';
        this.styles = PresetStyles;
        this.variables = { ...StyleVariables, ...PresetStyles.tech.variables };
        
        this.init();
    }
    
    init() {
        const saved = localStorage.getItem('article-style');
        if (saved && this.styles[saved]) {
            this.currentStyle = saved;
            this.applyStyle(saved);
        } else {
            this.applyStyle('tech');
        }
    }
    
    applyStyle(styleName) {
        if (!this.styles[styleName]) {
            console.error(`风格 ${styleName} 不存在`);
            return;
        }
        
        this.currentStyle = styleName;
        const style = this.styles[styleName];
        this.variables = { ...StyleVariables, ...style.variables };
        
        localStorage.setItem('article-style', styleName);
        this.updateCSSVariables();
    }
    
    updateCSSVariables() {
        const root = document.documentElement;
        Object.entries(this.variables).forEach(([key, value]) => {
            root.style.setProperty(`--${key}`, value);
        });
    }
    
    getCurrentStyle() {
        return this.styles[this.currentStyle];
    }
    
    getAllStyles() {
        return Object.entries(this.styles).map(([key, value]) => ({
            key,
            ...value
        }));
    }
    
    getVariables() {
        return this.variables;
    }
}

module.exports = { StyleVariables, PresetStyles, StyleManager };
