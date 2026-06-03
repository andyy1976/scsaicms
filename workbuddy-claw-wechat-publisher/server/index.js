const express = require('express');
const cors = require('cors');
const path = require('path');

// 环境变量
require('dotenv').config({ path: path.join(__dirname, '..', '.env') });

const app = express();
const PORT = process.env.PLUGIN_PORT || 3457;

// ── 中间件 ──────────────────────────────────────
app.use(cors());
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true, limit: '10mb' }));
app.use(express.static(path.join(__dirname, 'public')));

// ── 路由 ──────────────────────────────────────
const publishRoutes = require('./routes/publish');
const skillsRoutes = require('./routes/skills');
const modelsRoutes = require('./routes/models');
const chatRoutes = require('./routes/chat');
const cmsRoutes = require('./routes/cms');
const tasksRoutes = require('./routes/tasks');
const contentRoutes = require('./routes/content');
const styleRoutes = require('./routes/style');
const productRoutes = require('./routes/product');
const scheduler = require('./services/scheduler');

app.use('/api/publish', publishRoutes);
app.use('/api/skills', skillsRoutes);
app.use('/api/models', modelsRoutes);
app.use('/api/chat', chatRoutes);
app.use('/api/cms', cmsRoutes);
app.use('/api/tasks', tasksRoutes);
app.use('/api/content', contentRoutes);
app.use('/api/style', styleRoutes);
app.use('/api/product', productRoutes);

// ── 健康检查 ──────────────────────────────────────
app.get('/health', (req, res) => {
  res.json({ status: 'ok', service: 'wechat-publisher-plugin', port: PORT });
});
app.get('/api/health', (req, res) => {
  res.json({ status: 'ok', service: 'wechat-publisher-plugin', port: PORT });
});

// ── 启动 ──────────────────────────────────────────
app.listen(PORT, '0.0.0.0', () => {
  console.log(`[WeChat Publisher Plugin] 服务已启动，端口: ${PORT}`);
  console.log(`  健康检查: http://localhost:${PORT}/health`);
  console.log(`  API: http://localhost:${PORT}/api/publish`);

  // 启动定时任务调度器
  scheduler.startScheduler().then(() => {
    console.log('[Scheduler] 定时任务调度器已启动');
  }).catch(e => {
    console.error('[Scheduler] 启动失败:', e.message);
  });
});
