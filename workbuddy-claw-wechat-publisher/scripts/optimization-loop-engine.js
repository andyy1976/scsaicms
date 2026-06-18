/**
 * 内容生成优化循环引擎
 * 基于阅读反馈数据自动调优内容生成参数
 * 
 * 功能：
 * - 分析用户偏好（风格、角度、长度、结构）
 * - 自动调整生成参数
 * - A/B测试和效果对比
 * - 持续学习和优化
 */

const path = require('path');
const fs = require('fs');
const axios = require('axios');

/**
 * 默认生成参数
 */
const DEFAULT_PARAMS = {
    // 内容风格
    style: 'professional',
    tone: 'neutral',
    
    // 内容结构
    introStyle: 'story', // story | direct | question
    paragraphLength: 'medium', // short | medium | long
    useBulletPoints: true,
    useExamples: true,
    
    // 内容长度
    targetLength: 1500, // 字数
    
    // 互动元素
    callToAction: true,
    askQuestion: true,
    
    // AI模型参数
    temperature: 0.7,
    maxTokens: 2000,
    
    // 平台适配
    platform: 'wechat', // wechat | xiaohongshu | zhihu | website
};

/**
 * 用户偏好分析器
 */
class PreferenceAnalyzer {
    constructor() {
        this.preferences = {
            // 风格偏好
            styleWeights: {
                professional: 0.25,
                casual: 0.25,
                humorous: 0.25,
                academic: 0.25
            },
            
            // 结构偏好
            structureWeights: {
                storyIntro: 0.33,
                directIntro: 0.33,
                questionIntro: 0.34
            },
            
            // 长度偏好
            optimalLength: 1500,
            lengthVariance: 500,
            
            // 互动元素偏好
            callToActionRate: 0.8,
            askQuestionRate: 0.6,
            
            // 主题偏好
            topicWeights: {},
            
            // 最后更新时间
            lastUpdated: null
        };
    }
    
    /**
     * 从反馈数据中学习偏好
     */
    async learnFromFeedback(feedbackData) {
        console.log('🧠 从反馈数据中学习偏好...');
        
        const highPerforming = feedbackData.filter(item => 
            item.avg_depth > 0.7 && item.avg_duration > 60
        );
        
        const lowPerforming = feedbackData.filter(item => 
            item.avg_depth < 0.5 || item.avg_duration < 30
        );
        
        // 分析风格偏好（基于文章类型）
        this.analyzeStylePreference(highPerforming, lowPerforming);
        
        // 分析结构偏好
        this.analyzeStructurePreference(highPerforming, lowPerforming);
        
        // 分析长度偏好
        this.analyzeLengthPreference(highPerforming);
        
        // 分析主题偏好
        this.analyzeTopicPreference(highPerforming);
        
        this.preferences.lastUpdated = new Date().toISOString();
        
        console.log('✅ 偏好学习完成');
        return this.preferences;
    }
    
    /**
     * 分析风格偏好
     */
    analyzeStylePreference(highPerforming, lowPerforming) {
        // 这里可以根据文章类型、关键词等推断风格
        // 简化版：假设高表现文章的风格权重增加
        const increment = 0.05;
        const decrement = 0.03;
        
        // 模拟：高表现文章偏好的风格权重增加
        this.preferences.styleWeights.professional += increment;
        this.preferences.styleWeights.casual += increment;
        
        // 归一化
        const total = Object.values(this.preferences.styleWeights).reduce((a, b) => a + b, 0);
        for (const key in this.preferences.styleWeights) {
            this.preferences.styleWeights[key] /= total;
        }
    }
    
    /**
     * 分析结构偏好
     */
    analyzeStructurePreference(highPerforming, lowPerforming) {
        // 假设高表现文章使用故事型开头较多
        this.preferences.structureWeights.storyIntro += 0.1;
        
        // 归一化
        const total = Object.values(this.preferences.structureWeights).reduce((a, b) => a + b, 0);
        for (const key in this.preferences.structureWeights) {
            this.preferences.structureWeights[key] /= total;
        }
    }
    
    /**
     * 分析长度偏好
     */
    analyzeLengthPreference(highPerforming) {
        if (highPerforming.length > 0) {
            const avgLength = highPerforming.reduce((sum, item) => {
                // 估算文章长度（这里简化处理）
                return sum + (item.description?.length || 500);
            }, 0) / highPerforming.length;
            
            this.preferences.optimalLength = Math.round(avgLength);
        }
    }
    
    /**
     * 分析主题偏好
     */
    analyzeTopicPreference(highPerforming) {
        // 基于文章分类分析主题偏好
        highPerforming.forEach(item => {
            const topic = item.typeid || 'other';
            this.preferences.topicWeights[topic] = (this.preferences.topicWeights[topic] || 0) + 1;
        });
    }
    
    /**
     * 获取推荐生成参数
     */
    getRecommendedParams() {
        // 选择权重最高的风格
        const topStyle = Object.entries(this.preferences.styleWeights)
            .sort((a, b) => b[1] - a[1])[0][0];
        
        // 选择权重最高的开头风格
        const topIntro = Object.entries(this.preferences.structureWeights)
            .sort((a, b) => b[1] - a[1])[0][0];
        
        return {
            ...DEFAULT_PARAMS,
            style: topStyle,
            introStyle: topIntro,
            targetLength: this.preferences.optimalLength,
            callToAction: Math.random() < this.preferences.callToActionRate,
            askQuestion: Math.random() < this.preferences.askQuestionRate
        };
    }
}

/**
 * 参数优化器
 */
class ParameterOptimizer {
    constructor() {
        this.experiments = [];
        this.currentExperiment = null;
    }
    
    /**
     * 创建A/B测试实验
     */
    createExperiment(paramsA, paramsB, description) {
        const experiment = {
            id: Date.now(),
            description,
            paramsA,
            paramsB,
            createdAt: new Date().toISOString(),
            results: {
                groupA: [],
                groupB: []
            },
            status: 'running'
        };
        
        this.currentExperiment = experiment;
        this.experiments.push(experiment);
        
        console.log(`🧪 创建实验: ${description}`);
        return experiment;
    }
    
    /**
     * 记录实验结果
     */
    recordResult(groupId, feedbackData) {
        if (!this.currentExperiment) return;
        
        const group = groupId === 'A' ? 'groupA' : 'groupB';
        this.currentExperiment.results[group].push(feedbackData);
        
        console.log(`📊 记录实验结果 ${groupId}: ${feedbackData.avg_depth?.toFixed(2)} 深度`);
    }
    
    /**
     * 分析实验结果
     */
    analyzeExperiment() {
        if (!this.currentExperiment) return null;
        
        const resultsA = this.currentExperiment.results.groupA;
        const resultsB = this.currentExperiment.results.groupB;
        
        if (resultsA.length === 0 || resultsB.length === 0) {
            console.log('⚠️  实验数据不足');
            return null;
        }
        
        // 计算平均表现
        const avgA = {
            depth: resultsA.reduce((sum, r) => sum + (r.avg_depth || 0), 0) / resultsA.length,
            duration: resultsA.reduce((sum, r) => sum + (r.avg_duration || 0), 0) / resultsA.length,
            likes: resultsA.reduce((sum, r) => sum + (r.total_likes || 0), 0)
        };
        
        const avgB = {
            depth: resultsB.reduce((sum, r) => sum + (r.avg_depth || 0), 0) / resultsB.length,
            duration: resultsB.reduce((sum, r) => sum + (r.avg_duration || 0), 0) / resultsB.length,
            likes: resultsB.reduce((sum, r) => sum + (r.total_likes || 0), 0)
        };
        
        // 计算综合得分
        const scoreA = avgA.depth * 0.5 + (avgA.duration / 120) * 0.3 + (avgA.likes / resultsA.length) * 0.2;
        const scoreB = avgB.depth * 0.5 + (avgB.duration / 120) * 0.3 + (avgB.likes / resultsB.length) * 0.2;
        
        const winner = scoreA > scoreB ? 'A' : 'B';
        const improvement = Math.abs(scoreA - scoreB) / Math.min(scoreA, scoreB) * 100;
        
        this.currentExperiment.status = 'completed';
        this.currentExperiment.winner = winner;
        this.currentExperiment.improvement = improvement;
        this.currentExperiment.analyzedAt = new Date().toISOString();
        
        console.log(`📊 实验完成: ${winner} 组胜出，提升 ${improvement.toFixed(1)}%`);
        
        return {
            winner,
            improvement,
            recommendedParams: winner === 'A' ? this.currentExperiment.paramsA : this.currentExperiment.paramsB
        };
    }
}

/**
 * 优化循环主引擎
 */
class OptimizationLoop {
    constructor() {
        this.preferenceAnalyzer = new PreferenceAnalyzer();
        this.parameterOptimizer = new ParameterOptimizer();
        this.currentParams = { ...DEFAULT_PARAMS };
        this.feedbackHistory = [];
    }
    
    /**
     * 加载偏好数据
     */
    loadPreferences() {
        const configPath = path.join(__dirname, '../config/optimization-preferences.json');
        if (fs.existsSync(configPath)) {
            const data = JSON.parse(fs.readFileSync(configPath, 'utf-8'));
            this.preferenceAnalyzer.preferences = data.preferences;
            this.currentParams = data.currentParams;
            this.feedbackHistory = data.feedbackHistory || [];
            console.log('✅ 偏好数据已加载');
        }
    }
    
    /**
     * 保存偏好数据
     */
    savePreferences() {
        const configPath = path.join(__dirname, '../config/optimization-preferences.json');
        const data = {
            preferences: this.preferenceAnalyzer.preferences,
            currentParams: this.currentParams,
            feedbackHistory: this.feedbackHistory.slice(-100),
            lastUpdated: new Date().toISOString()
        };
        
        fs.writeFileSync(configPath, JSON.stringify(data, null, 2));
        console.log('💾 偏好数据已保存');
    }
    
    /**
     * 处理新的反馈数据
     */
    async processFeedback(feedbackData) {
        console.log('🔄 处理新的反馈数据...');
        
        // 添加到历史记录
        this.feedbackHistory.push(...feedbackData);
        
        // 学习偏好
        await this.preferenceAnalyzer.learnFromFeedback(feedbackData);
        
        // 更新当前参数
        this.currentParams = this.preferenceAnalyzer.getRecommendedParams();
        
        // 保存
        this.savePreferences();
        
        console.log('✅ 反馈处理完成');
        return this.currentParams;
    }
    
    /**
     * 获取当前最优参数
     */
    getOptimalParams() {
        return this.currentParams;
    }
    
    /**
     * 启动A/B测试
     */
    startABTest(description, paramVariations) {
        return this.parameterOptimizer.createExperiment(
            this.currentParams,
            { ...this.currentParams, ...paramVariations },
            description
        );
    }
    
    /**
     * 完成A/B测试
     */
    completeABTest() {
        const result = this.parameterOptimizer.analyzeExperiment();
        if (result && result.winner === 'B') {
            this.currentParams = result.recommendedParams;
            this.savePreferences();
        }
        return result;
    }
    
    /**
     * 生成优化报告
     */
    generateOptimizationReport() {
        return {
            currentParams: this.currentParams,
            preferences: this.preferenceAnalyzer.preferences,
            recentExperiments: this.parameterOptimizer.experiments.slice(-5),
            feedbackStats: {
                totalFeedbacks: this.feedbackHistory.length,
                avgDepth: this.feedbackHistory.reduce((sum, f) => sum + (f.avg_depth || 0), 0) / this.feedbackHistory.length,
                avgDuration: this.feedbackHistory.reduce((sum, f) => sum + (f.avg_duration || 0), 0) / this.feedbackHistory.length
            }
        };
    }
}

// 创建全局实例
const optimizationLoop = new OptimizationLoop();

module.exports = {
    OptimizationLoop,
    PreferenceAnalyzer,
    ParameterOptimizer,
    optimizationLoop
};