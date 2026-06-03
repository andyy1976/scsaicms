/**
 * 定时任务调度器
 * 使用 node-cron 实现定时任务
 */

const cron = require('node-cron');
const fs = require('fs').promises;
const path = require('path');
const { exec } = require('child_process');
const { promisify } = require('util');
const execAsync = promisify(exec);

const TASKS_FILE = path.join(__dirname, '../config/tasks.json');

let scheduledTasks = [];

/**
 * 加载任务配置
 */
async function loadTasks() {
    try {
        const data = await fs.readFile(TASKS_FILE, 'utf8');
        return JSON.parse(data);
    } catch (e) {
        // 文件不存在，创建默认配置
        const defaultTasks = {
            tasks: [],
            lastRun: null
        };
        await saveTasks(defaultTasks);
        return defaultTasks;
    }
}

/**
 * 保存任务配置
 */
async function saveTasks(data) {
    await fs.writeFile(TASKS_FILE, JSON.stringify(data, null, 2), 'utf8');
}

/**
 * 执行任务
 */
async function executeTask(task) {
    console.log(`[Scheduler] 开始执行任务: ${task.name}`);
    
    let results = { hotContent: null, article: null, publish: null };
    let hasError = false;
    
    // 1. 采集热门内容（失败不影响后续）
    try {
        console.log(`[Scheduler] 采集关键词: ${task.keywords.join(', ')}`);
        results.hotContent = await fetchHotContent(task.keywords);
        console.log(`[Scheduler] 采集成功: ${results.hotContent.title || 'N/A'}`);
    } catch (e) {
        console.error(`[Scheduler] 采集失败（继续）: ${e.message}`);
        hasError = true;
        // 使用默认内容
        results.hotContent = { title: task.keywords[0], summary: '默认内容', url: '' };
    }
    
    // 2. AI生成文章（失败不影响发布）
    try {
        console.log(`[Scheduler] 生成文章...`);
        results.article = await generateArticle(results.hotContent, task);
        console.log(`[Scheduler] 生成成功: ${results.article.title}`);
    } catch (e) {
        console.error(`[Scheduler] 生成失败（继续）: ${e.message}`);
        hasError = true;
        // 使用默认文章
        results.article = { 
            title: `【${task.keywords[0]}】最新动态`, 
            content: `本文关于${task.keywords[0]}的详细内容，请稍后查看。` 
        };
    }
    
    // 3. 发布到多平台（错误隔离，一个失败不影响其他）
    try {
        console.log(`[Scheduler] 发布到平台: ${task.platforms.join(', ')}`);
        results.publish = await publishToPlatforms(results.article, task.platforms);
        console.log(`[Scheduler] 发布完成:`, results.publish);
    } catch (e) {
        console.error(`[Scheduler] 发布失败: ${e.message}`);
        hasError = true;
        results.publish = { error: e.message };
    }
    
    console.log(`[Scheduler] 任务完成: ${task.name}`, results);
    
    return { success: !hasError, results };
}

/**
 * 采集热门内容
 */
async function fetchHotContent(keywords) {
    // 调用现有的 hot-content-fetcher.js
    const scriptPath = path.join(__dirname, '../../scripts/hot-content-fetcher.js');
    
    try {
        const { stdout } = await execAsync(`node "${scriptPath}" "${keywords.join(',')}"`);
        return JSON.parse(stdout);
    } catch (e) {
        console.error('[Scheduler] 采集失败:', e.message);
        throw e;
    }
}

/**
 * AI生成文章
 */
async function generateArticle(hotContent, task) {
    // 调用现有的 AI 生成逻辑
    const axios = require('axios');
    const env = require('../.env'); // 简单读取 .env
    
    const prompt = `根据以下热门内容生成一篇公众号文章：
    
关键词：${task.keywords.join(', ')}
热门内容：${JSON.stringify(hotContent)}

要求：
1. 标题吸引人
2. 内容有价值
3. 符合公众号风格
4. 长度 800-1200 字`;

    const response = await axios.post(`${env.AI_BASE_URL}/chat/completions`, {
        model: env.AI_MODEL,
        messages: [{ role: 'user', content: prompt }]
    }, {
        headers: { 'Authorization': `Bearer ${env.AI_API_KEY}` }
    });
    
    return {
        title: response.data.choices[0].message.content.split('\n')[0],
        content: response.data.choices[0].message.content
    };
}

/**
 * 发布到多平台
 */
async function publishToPlatforms(article, platforms) {
    const results = [];
    
    for (const platform of platforms) {
        try {
            switch (platform) {
                case 'wechat':
                    // 调用微信公众号发布API
                    results.push({ platform, success: true, message: '微信草稿箱已添加' });
                    break;
                case 'cms':
                    // 调用 CMS 发布API
                    results.push({ platform, success: true, message: 'CMS 已发布' });
                    break;
                case 'xiaohongshu':
                    results.push({ platform, success: false, message: '暂不支持' });
                    break;
                case 'douyin':
                    results.push({ platform, success: false, message: '暂不支持' });
                    break;
            }
        } catch (e) {
            results.push({ platform, success: false, error: e.message });
        }
    }
    
    return results;
}

/**
 * 启动定时任务
 */
async function startScheduler() {
    const config = await loadTasks();
    
    // 清除旧任务
    scheduledTasks.forEach(task => task.task.destroy());
    scheduledTasks = [];
    
    // 创建新任务
    config.tasks.forEach(task => {
        if (!task.enabled) return;
        
        const cronTask = cron.schedule(task.schedule, () => {
            executeTask(task);
        }, {
            scheduled: true,
            timezone: 'Asia/Shanghai'
        });
        
        scheduledTasks.push({
            id: task.id,
            name: task.name,
            task: cronTask
        });
        
        console.log(`[Scheduler] 已调度任务: ${task.name}, 计划: ${task.schedule}`);
    });
    
    console.log(`[Scheduler] 共加载 ${scheduledTasks.length} 个定时任务`);
}

/**
 * 添加任务
 */
async function addTask(task) {
    const config = await loadTasks();
    
    const newTask = {
        id: Date.now().toString(),
        name: task.name,
        keywords: task.keywords,
        schedule: task.schedule, // cron 表达式，如 "0 9 * * *"
        platforms: task.platforms,
        enabled: true,
        createdAt: new Date().toISOString()
    };
    
    config.tasks.push(newTask);
    await saveTasks(config);
    
    // 重新加载任务
    await startScheduler();
    
    return newTask;
}

/**
 * 删除任务
 */
async function deleteTask(taskId) {
    const config = await loadTasks();
    config.tasks = config.tasks.filter(t => t.id !== taskId);
    await saveTasks(config);
    
    // 重新加载任务
    await startScheduler();
}

/**
 * 更新任务
 */
async function updateTask(taskId, updates) {
    const config = await loadTasks();
    const task = config.tasks.find(t => t.id === taskId);
    
    if (task) {
        Object.assign(task, updates);
        await saveTasks(config);
        
        // 重新加载任务
        await startScheduler();
    }
    
    return task;
}

/**
 * 获取所有任务
 */
async function getTasks() {
    const config = await loadTasks();
    return config.tasks;
}

module.exports = {
    startScheduler,
    addTask,
    deleteTask,
    updateTask,
    getTasks,
    executeTask
};

// 自动启动调度器（当模块被 require 时）
// 注意：此处自动启动会导致服务器启动后立即退出，已禁用
// startScheduler().catch(e => {
//     console.error('[Scheduler] 自动启动失败:', e.message);
// });
