/**
 * 任务管理路由
 * GET  /api/tasks - 获取所有任务
 * POST /api/tasks - 添加任务
 * PUT  /api/tasks/:id - 更新任务
 * DELETE /api/tasks/:id - 删除任务
 * POST /api/tasks/:id/run - 立即执行任务
 */

const express = require('express');
const router = express.Router();

// 延迟加载 scheduler，避免启动时报错
let scheduler = null;
try {
    scheduler = require('../services/scheduler');
} catch (e) {
    console.error('[Tasks] 加载 scheduler 失败:', e.message);
}

/**
 * 获取所有任务
 */
router.get('/', async (req, res) => {
    try {
        if (!scheduler) return res.status(500).json({ success: false, message: '调度器未初始化' });
        const tasks = await scheduler.getTasks();
        res.json({ success: true, data: tasks });
    } catch (e) {
        res.status(500).json({ success: false, message: e.message });
    }
});

/**
 * 添加任务
 */
router.post('/', async (req, res) => {
    try {
        if (!scheduler) return res.status(500).json({ success: false, message: '调度器未初始化' });
        
        const { name, keywords, schedule, platforms, enabled } = req.body;
        
        if (!name || !keywords || !schedule || !platforms) {
            return res.status(400).json({ success: false, message: '缺少必要参数' });
        }
        
        const task = await scheduler.addTask({
            name,
            keywords: Array.isArray(keywords) ? keywords : keywords.split(',').map(k => k.trim()),
            schedule,
            platforms: Array.isArray(platforms) ? platforms : platforms.split(',').map(p => p.trim()),
            enabled: enabled !== false
        });
        
        res.json({ success: true, data: task });
    } catch (e) {
        res.status(500).json({ success: false, message: e.message });
    }
});

/**
 * 更新任务
 */
router.put('/:id', async (req, res) => {
    try {
        if (!scheduler) return res.status(500).json({ success: false, message: '调度器未初始化' });
        
        const { id } = req.params;
        const updates = req.body;
        
        const task = await scheduler.updateTask(id, updates);
        
        if (task) {
            res.json({ success: true, data: task });
        } else {
            res.status(404).json({ success: false, message: '任务不存在' });
        }
    } catch (e) {
        res.status(500).json({ success: false, message: e.message });
    }
});

/**
 * 删除任务
 */
router.delete('/:id', async (req, res) => {
    try {
        if (!scheduler) return res.status(500).json({ success: false, message: '调度器未初始化' });
        
        const { id } = req.params;
        await scheduler.deleteTask(id);
        res.json({ success: true, message: '任务已删除' });
    } catch (e) {
        res.status(500).json({ success: false, message: e.message });
    }
});

/**
 * 立即执行任务
 */
router.post('/:id/run', async (req, res) => {
    try {
        if (!scheduler) return res.status(500).json({ success: false, message: '调度器未初始化' });
        
        const { id } = req.params;
        const tasks = await scheduler.getTasks();
        const task = tasks.find(t => t.id === id);
        
        if (!task) {
            return res.status(404).json({ success: false, message: '任务不存在' });
        }
        
        // 异步执行，立即返回
        scheduler.executeTask(task).then(result => {
            console.log(`[Scheduler] 手动执行任务完成: ${task.name}`, result);
        });
        
        res.json({ success: true, message: '任务已开始执行' });
    } catch (e) {
        res.status(500).json({ success: false, message: e.message });
    }
});

module.exports = router;
