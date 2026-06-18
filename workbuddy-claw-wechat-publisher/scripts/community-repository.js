/**
 * 社区插件/模板管理系统
 * 支持开发者提交插件、模板，审核流程，市场展示
 * 
 * 功能：
 * - 插件/模板提交
 * - 自动代码检查
 * - 审核流程
 * - 市场展示
 * - 评分和评论
 * - 贡献统计
 */

const path = require('path');
const fs = require('fs');
const crypto = require('crypto');

/**
 * 社区插件/模板仓库
 */
class CommunityRepository {
    constructor() {
        this.repositoryPath = path.join(__dirname, '../../data/community-repository');
        this.pluginsPath = path.join(this.repositoryPath, 'plugins');
        this.templatesPath = path.join(this.repositoryPath, 'templates');
        this.submissionsPath = path.join(this.repositoryPath, 'submissions');
        this.reviewsPath = path.join(this.repositoryPath, 'reviews');
        this.statsPath = path.join(this.repositoryPath, 'stats');
        
        this.initializeDirectories();
    }
    
    /**
     * 初始化目录结构
     */
    initializeDirectories() {
        [this.repositoryPath, this.pluginsPath, this.templatesPath, 
         this.submissionsPath, this.reviewsPath, this.statsPath].forEach(dir => {
            if (!fs.existsSync(dir)) {
                fs.mkdirSync(dir, { recursive: true });
            }
        });
    }
    
    /**
     * 提交插件/模板
     */
    async submitPlugin(submission) {
        console.log(`📦 提交插件: ${submission.name}`);
        
        // 验证提交数据
        const validation = this.validateSubmission(submission);
        if (!validation.valid) {
            throw new Error(validation.message);
        }
        
        // 生成提交ID
        const submissionId = crypto.randomUUID();
        const timestamp = new Date().toISOString();
        
        // 创建提交记录
        const submissionRecord = {
            id: submissionId,
            type: 'plugin',
            name: submission.name,
            description: submission.description,
            author: submission.author,
            email: submission.email,
            version: submission.version,
            category: submission.category,
            code: submission.code,
            config: submission.config || {},
            documentation: submission.documentation || '',
            screenshots: submission.screenshots || [],
            status: 'pending', // pending | reviewing | approved | rejected
            createdAt: timestamp,
            updatedAt: timestamp,
            reviews: [],
            rating: 0,
            downloads: 0
        };
        
        // 保存提交记录
        const submissionPath = path.join(this.submissionsPath, `${submissionId}.json`);
        fs.writeFileSync(submissionPath, JSON.stringify(submissionRecord, null, 2));
        
        // 自动代码检查
        const codeCheck = await this.performCodeCheck(submission.code);
        submissionRecord.codeCheck = codeCheck;
        
        // 如果代码检查通过，自动进入审核队列
        if (codeCheck.passed) {
            submissionRecord.status = 'reviewing';
            fs.writeFileSync(submissionPath, JSON.stringify(submissionRecord, null, 2));
        }
        
        console.log(`✅ 插件提交成功: ${submissionId}`);
        return submissionRecord;
    }
    
    /**
     * 提交模板
     */
    async submitTemplate(submission) {
        console.log(`📄 提交模板: ${submission.name}`);
        
        // 验证提交数据
        const validation = this.validateSubmission(submission);
        if (!validation.valid) {
            throw new Error(validation.message);
        }
        
        // 生成提交ID
        const submissionId = crypto.randomUUID();
        const timestamp = new Date().toISOString();
        
        // 创建提交记录
        const submissionRecord = {
            id: submissionId,
            type: 'template',
            name: submission.name,
            description: submission.description,
            author: submission.author,
            email: submission.email,
            version: submission.version,
            category: submission.category,
            template: submission.template,
            variables: submission.variables || [],
            preview: submission.preview || '',
            screenshots: submission.screenshots || [],
            status: 'pending',
            createdAt: timestamp,
            updatedAt: timestamp,
            reviews: [],
            rating: 0,
            downloads: 0
        };
        
        // 保存提交记录
        const submissionPath = path.join(this.submissionsPath, `${submissionId}.json`);
        fs.writeFileSync(submissionPath, JSON.stringify(submissionRecord, null, 2));
        
        // 自动检查
        const templateCheck = await this.performTemplateCheck(submission.template);
        submissionRecord.templateCheck = templateCheck;
        
        if (templateCheck.passed) {
            submissionRecord.status = 'reviewing';
            fs.writeFileSync(submissionPath, JSON.stringify(submissionRecord, null, 2));
        }
        
        console.log(`✅ 模板提交成功: ${submissionId}`);
        return submissionRecord;
    }
    
    /**
     * 验证提交数据
     */
    validateSubmission(submission) {
        const required = ['name', 'description', 'author', 'email', 'version', 'category'];
        const missing = required.filter(field => !submission[field]);
        
        if (missing.length > 0) {
            return { valid: false, message: `缺少必填字段: ${missing.join(', ')}` };
        }
        
        // 验证邮箱格式
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(submission.email)) {
            return { valid: false, message: '邮箱格式不正确' };
        }
        
        // 验证版本号格式
        const versionRegex = /^\d+\.\d+\.\d+$/;
        if (!versionRegex.test(submission.version)) {
            return { valid: false, message: '版本号格式不正确，应为 x.y.z' };
        }
        
        return { valid: true };
    }
    
    /**
     * 自动代码检查
     */
    async performCodeCheck(code) {
        console.log('🔍 执行代码检查...');
        
        const checks = {
            syntax: true,
            security: true,
            performance: true,
            documentation: true,
            errors: [],
            warnings: []
        };
        
        try {
            // 语法检查
            try {
                // 简单的语法检查
                if (code.includes('eval(') || code.includes('Function(')) {
                    checks.security = false;
                    checks.errors.push('检测到不安全的代码执行');
                }
                
                if (code.includes('require(') && !code.includes('require(\'fs\')')) {
                    checks.warnings.push('检测到外部模块引用，请确保安全');
                }
                
                // 文档检查
                if (!code.includes('/**') && !code.includes('//')) {
                    checks.documentation = false;
                    checks.warnings.push('缺少代码注释');
                }
                
                // 性能检查
                if (code.includes('while (true)') || code.includes('for (;;')) {
                    checks.performance = false;
                    checks.errors.push('检测到可能的无限循环');
                }
                
            } catch (e) {
                checks.syntax = false;
                checks.errors.push(`语法错误: ${e.message}`);
            }
            
        } catch (error) {
            checks.errors.push(`检查失败: ${error.message}`);
        }
        
        checks.passed = checks.syntax && checks.security && checks.performance;
        
        console.log(`✅ 代码检查完成: ${checks.passed ? '通过' : '失败'}`);
        return checks;
    }
    
    /**
     * 自动模板检查
     */
    async performTemplateCheck(template) {
        console.log('🔍 执行模板检查...');
        
        const checks = {
            syntax: true,
            structure: true,
            variables: true,
            errors: [],
            warnings: []
        };
        
        try {
            // 检查模板语法
            if (template.includes('{{') && !template.includes('}}')) {
                checks.syntax = false;
                checks.errors.push('模板语法不完整');
            }
            
            // 检查变量定义
            const variableMatches = template.match(/\{\{(\w+)\}\}/g);
            if (variableMatches && variableMatches.length > 0) {
                checks.warnings.push(`检测到 ${variableMatches.length} 个变量，请确保在variables中定义`);
            }
            
        } catch (error) {
            checks.errors.push(`检查失败: ${error.message}`);
        }
        
        checks.passed = checks.syntax && checks.structure;
        
        console.log(`✅ 模板检查完成: ${checks.passed ? '通过' : '失败'}`);
        return checks;
    }
    
    /**
     * 审核提交
     */
    reviewSubmission(submissionId, reviewResult) {
        console.log(`📋 审核提交: ${submissionId}`);
        
        const submissionPath = path.join(this.submissionsPath, `${submissionId}.json`);
        if (!fs.existsSync(submissionPath)) {
            throw new Error('提交记录不存在');
        }
        
        const submission = JSON.parse(fs.readFileSync(submissionPath, 'utf-8'));
        
        submission.status = reviewResult.approved ? 'approved' : 'rejected';
        submission.reviewComment = reviewResult.comment;
        submission.reviewedBy = reviewResult.reviewer;
        submission.reviewedAt = new Date().toISOString();
        submission.updatedAt = new Date().toISOString();
        
        // 如果审核通过，移动到对应目录
        if (reviewResult.approved) {
            const targetDir = submission.type === 'plugin' ? this.pluginsPath : this.templatesPath;
            const targetPath = path.join(targetDir, `${submissionId}.json`);
            fs.writeFileSync(targetPath, JSON.stringify(submission, null, 2));
            
            // 删除原提交记录
            fs.unlinkSync(submissionPath);
        } else {
            // 更新提交记录
            fs.writeFileSync(submissionPath, JSON.stringify(submission, null, 2));
        }
        
        console.log(`✅ 审核完成: ${submission.status}`);
        return submission;
    }
    
    /**
     * 获取市场列表
     */
    getMarketplace(filters = {}) {
        console.log('🏪 获取市场列表...');
        
        const items = [];
        
        // 获取已审核的插件
        const pluginFiles = fs.readdirSync(this.pluginsPath).filter(f => f.endsWith('.json'));
        pluginFiles.forEach(file => {
            const plugin = JSON.parse(fs.readFileSync(path.join(this.pluginsPath, file), 'utf-8'));
            if (this.matchesFilters(plugin, filters)) {
                items.push(plugin);
            }
        });
        
        // 获取已审核的模板
        const templateFiles = fs.readdirSync(this.templatesPath).filter(f => f.endsWith('.json'));
        templateFiles.forEach(file => {
            const template = JSON.parse(fs.readFileSync(path.join(this.templatesPath, file), 'utf-8'));
            if (this.matchesFilters(template, filters)) {
                items.push(template);
            }
        });
        
        // 排序
        items.sort((a, b) => {
            if (filters.sortBy === 'rating') return b.rating - a.rating;
            if (filters.sortBy === 'downloads') return b.downloads - a.downloads;
            if (filters.sortBy === 'newest') return new Date(b.createdAt) - new Date(a.createdAt);
            return b.downloads - a.downloads; // 默认按下载量排序
        });
        
        console.log(`✅ 找到 ${items.length} 个项目`);
        return items;
    }
    
    /**
     * 匹配过滤条件
     */
    matchesFilters(item, filters) {
        if (filters.type && item.type !== filters.type) return false;
        if (filters.category && item.category !== filters.category) return false;
        if (filters.search && !item.name.toLowerCase().includes(filters.search.toLowerCase()) && 
            !item.description.toLowerCase().includes(filters.search.toLowerCase())) {
            return false;
        }
        return true;
    }
    
    /**
     * 下载插件/模板
     */
    downloadItem(itemId) {
        console.log(`📥 下载项目: ${itemId}`);
        
        // 查找项目
        let itemPath = path.join(this.pluginsPath, `${itemId}.json`);
        if (!fs.existsSync(itemPath)) {
            itemPath = path.join(this.templatesPath, `${itemId}.json`);
        }
        
        if (!fs.existsSync(itemPath)) {
            throw new Error('项目不存在');
        }
        
        const item = JSON.parse(fs.readFileSync(itemPath, 'utf-8'));
        
        // 增加下载计数
        item.downloads++;
        fs.writeFileSync(itemPath, JSON.stringify(item, null, 2));
        
        // 更新统计
        this.updateDownloadStats(item);
        
        console.log(`✅ 下载成功: ${item.downloads} 次下载`);
        return item;
    }
    
    /**
     * 添加评分和评论
     */
    addReview(itemId, review) {
        console.log(`⭐ 添加评论: ${itemId}`);
        
        // 查找项目
        let itemPath = path.join(this.pluginsPath, `${itemId}.json`);
        if (!fs.existsSync(itemPath)) {
            itemPath = path.join(this.templatesPath, `${itemId}.json`);
        }
        
        if (!fs.existsSync(itemPath)) {
            throw new Error('项目不存在');
        }
        
        const item = JSON.parse(fs.readFileSync(itemPath, 'utf-8'));
        
        // 创建评论记录
        const reviewRecord = {
            id: crypto.randomUUID(),
            itemId,
            author: review.author,
            rating: review.rating,
            comment: review.comment,
            createdAt: new Date().toISOString()
        };
        
        // 保存评论
        const reviewPath = path.join(this.reviewsPath, `${reviewRecord.id}.json`);
        fs.writeFileSync(reviewPath, JSON.stringify(reviewRecord, null, 2));
        
        // 更新项目评论列表
        item.reviews.push(reviewRecord.id);
        
        // 重新计算平均评分
        const reviews = this.getItemReviews(itemId);
        const avgRating = reviews.reduce((sum, r) => sum + r.rating, 0) / reviews.length;
        item.rating = Math.round(avgRating * 10) / 10;
        
        // 保存项目
        fs.writeFileSync(itemPath, JSON.stringify(item, null, 2));
        
        console.log(`✅ 评论添加成功，当前评分: ${item.rating}`);
        return reviewRecord;
    }
    
    /**
     * 获取项目评论
     */
    getItemReviews(itemId) {
        const reviews = [];
        const reviewFiles = fs.readdirSync(this.reviewsPath).filter(f => f.endsWith('.json'));
        
        reviewFiles.forEach(file => {
            const review = JSON.parse(fs.readFileSync(path.join(this.reviewsPath, file), 'utf-8'));
            if (review.itemId === itemId) {
                reviews.push(review);
            }
        });
        
        return reviews.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
    }
    
    /**
     * 获取开发者统计
     */
    getDeveloperStats(authorEmail) {
        console.log(`📊 获取开发者统计: ${authorEmail}`);
        
        const stats = {
            authorEmail,
            totalSubmissions: 0,
            approvedSubmissions: 0,
            totalDownloads: 0,
            avgRating: 0,
            items: []
        };
        
        // 统计插件
        const pluginFiles = fs.readdirSync(this.pluginsPath).filter(f => f.endsWith('.json'));
        pluginFiles.forEach(file => {
            const plugin = JSON.parse(fs.readFileSync(path.join(this.pluginsPath, file), 'utf-8'));
            if (plugin.email === authorEmail) {
                stats.totalSubmissions++;
                stats.approvedSubmissions++;
                stats.totalDownloads += plugin.downloads;
                stats.items.push(plugin);
            }
        });
        
        // 统计模板
        const templateFiles = fs.readdirSync(this.templatesPath).filter(f => f.endsWith('.json'));
        templateFiles.forEach(file => {
            const template = JSON.parse(fs.readFileSync(path.join(this.templatesPath, file), 'utf-8'));
            if (template.email === authorEmail) {
                stats.totalSubmissions++;
                stats.approvedSubmissions++;
                stats.totalDownloads += template.downloads;
                stats.items.push(template);
            }
        });
        
        // 计算平均评分
        if (stats.items.length > 0) {
            const totalRating = stats.items.reduce((sum, item) => sum + item.rating, 0);
            stats.avgRating = Math.round(totalRating / stats.items.length * 10) / 10;
        }
        
        return stats;
    }
    
    /**
     * 更新下载统计
     */
    updateDownloadStats(item) {
        const statsPath = path.join(this.statsPath, 'downloads.json');
        let stats = {};
        
        if (fs.existsSync(statsPath)) {
            stats = JSON.parse(fs.readFileSync(statsPath, 'utf-8'));
        }
        
        const today = new Date().toISOString().split('T')[0];
        if (!stats[today]) {
            stats[today] = {};
        }
        
        if (!stats[today][item.id]) {
            stats[today][item.id] = 0;
        }
        
        stats[today][item.id]++;
        fs.writeFileSync(statsPath, JSON.stringify(stats, null, 2));
    }
    
    /**
     * 获取待审核列表
     */
    getPendingSubmissions() {
        const submissions = [];
        const files = fs.readdirSync(this.submissionsPath).filter(f => f.endsWith('.json'));
        
        files.forEach(file => {
            const submission = JSON.parse(fs.readFileSync(path.join(this.submissionsPath, file), 'utf-8'));
            if (submission.status === 'pending' || submission.status === 'reviewing') {
                submissions.push(submission);
            }
        });
        
        return submissions.sort((a, b) => new Date(a.createdAt) - new Date(b.createdAt));
    }
}

// 创建全局实例
const communityRepository = new CommunityRepository();

module.exports = {
    CommunityRepository,
    communityRepository
};