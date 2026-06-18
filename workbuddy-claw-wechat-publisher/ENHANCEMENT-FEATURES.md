# 内容数字员工增强功能文档

本文档介绍内容数字员工的四大增强功能及其使用方法。

---

## 功能概览

| 功能 | 描述 | 状态 |
|------|------|------|
| 内容裂变 | 长文拆解为短视频脚本、图文卡片、金句海报 | ✅ 已完成 |
| AI自动分析报告 | 每周/每月自动生成内容效果报告 | ✅ 已完成 |
| 优化建议闭环 | 反馈数据自动调优内容生成参数 | ✅ 已完成 |
| 社区运营机制 | 开发者提交插件、模板的流程 | ✅ 已完成 |

---

## 一、内容裂变功能

### 功能描述
将长文自动拆解为多种格式内容，实现内容裂变传播：
- **短视频脚本**：30s/60s/90s，包含分镜、旁白、画面描述
- **图文卡片**：小红书/朋友圈风格，支持emoji和话题标签
- **金句海报**：励志/知识/营销类型，带设计建议

### 使用方法

#### 基础用法
```javascript
const { contentFission, saveFissionResult } = require('./scripts/content-fission-engine');

const result = await contentFission({
    title: '文章标题',
    content: '文章内容...',
    summary: '文章摘要',
    outputs: ['video-script', 'image-cards', 'quote-poster'],
    videoOptions: { duration: '60s', style: 'documentary' },
    imageOptions: { style: 'xiaohongshu', cardCount: 6 },
    quoteOptions: { type: 'inspirational', quoteCount: 5 }
});

// 保存结果
saveFissionResult(result, './output/fission');
```

#### 批量处理
```javascript
const { batchContentFission } = require('./scripts/content-fission-engine');

const articles = [
    { title: '文章1', content: '内容1...', summary: '摘要1' },
    { title: '文章2', content: '内容2...', summary: '摘要2' }
];

const results = await batchContentFission(articles, {
    outputs: ['video-script', 'image-cards']
});
```

### 输出格式

#### 短视频脚本
```json
{
  "title": "脚本标题",
  "duration": "60s",
  "style": "documentary",
  "scenes": [
    {
      "index": 1,
      "time": "3s",
      "visual": "画面描述",
      "voiceover": "旁白文本",
      "subtitle": "字幕文本"
    }
  ]
}
```

#### 图文卡片
```json
{
  "style": "xiaohongshu",
  "totalCards": 6,
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
```

#### 金句海报
```json
{
  "type": "inspirational",
  "totalQuotes": 5,
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
```

---

## 二、AI自动分析报告

### 功能描述
自动生成每周/每月内容效果分析报告：
- **数据收集**：阅读时长、深度、点赞、分享等
- **AI分析**：热门内容分析、问题诊断、优化建议
- **定时生成**：每周一/每月1号自动生成

### 使用方法

#### 手动生成报告
```javascript
const { generateContentReport } = require('./scripts/ai-report-generator');

// 生成周报
const weeklyReport = await generateContentReport({
    reportType: 'weekly',
    startDate: '2026-06-10',
    endDate: '2026-06-16'
});

// 生成月报
const monthlyReport = await generateContentReport({
    reportType: 'monthly'
});
```

#### 启动定时任务
```javascript
const { scheduleReportGeneration } = require('./scripts/ai-report-generator');

// 启动定时任务（每周一早上9点生成周报，每月1号早上9点生成月报）
scheduleReportGeneration();
```

### 报告内容

#### 数据概览
- 总文章数
- 总阅读量
- 平均阅读时长
- 平均阅读深度
- 总点赞数
- 总分享数

#### AI分析
- 热门内容分析（TOP5共同特点）
- 问题诊断（表现不佳文章的共性问题）
- 优化建议（3-5条具体可执行建议）
- 下周/月计划（基于数据的行动建议）

---

## 三、优化建议闭环

### 功能描述
基于阅读反馈数据自动调优内容生成参数：
- **偏好学习**：分析用户偏好（风格、角度、长度、结构）
- **参数优化**：自动调整生成参数
- **A/B测试**：对比不同参数效果
- **持续优化**：不断学习和改进

### 使用方法

#### 基础用法
```javascript
const { optimizationLoop } = require('./scripts/optimization-loop-engine');

// 加载偏好数据
optimizationLoop.loadPreferences();

// 处理新的反馈数据
const feedbackData = [
    {
        aid: 1,
        title: '文章1',
        avg_depth: 0.85,
        avg_duration: 120,
        total_likes: 45,
        typeid: 1
    }
];

const optimalParams = await optimizationLoop.processFeedback(feedbackData);

// 获取当前最优参数
const currentParams = optimizationLoop.getOptimalParams();
```

#### A/B测试
```javascript
// 启动A/B测试
const experiment = optimizationLoop.startABTest(
    '测试故事型开头 vs 直接开头',
    { introStyle: 'direct' }
);

// 记录实验结果
optimizationLoop.parameterOptimizer.recordResult('A', {
    avg_depth: 0.75,
    avg_duration: 90,
    total_likes: 30
});

optimizationLoop.parameterOptimizer.recordResult('B', {
    avg_depth: 0.82,
    avg_duration: 105,
    total_likes: 38
});

// 完成实验
const result = optimizationLoop.completeABTest();
console.log('获胜组:', result.winner);
console.log('提升幅度:', result.improvement + '%');
```

#### 生成优化报告
```javascript
const report = optimizationLoop.generateOptimizationReport();
console.log('当前参数:', report.currentParams);
console.log('偏好数据:', report.preferences);
console.log('反馈统计:', report.feedbackStats);
```

### 优化参数

| 参数 | 说明 | 可选值 |
|------|------|--------|
| style | 内容风格 | professional, casual, humorous, academic |
| tone | 语气 | neutral, friendly, formal |
| introStyle | 开头风格 | story, direct, question |
| paragraphLength | 段落长度 | short, medium, long |
| targetLength | 目标字数 | 数字 |
| temperature | AI温度 | 0-1 |
| platform | 平台 | wechat, xiaohongshu, zhihu, website |

---

## 四、社区运营机制

### 功能描述
支持开发者提交插件、模板，构建社区生态：
- **插件/模板提交**：开发者可提交自定义插件和模板
- **自动代码检查**：安全性和质量检查
- **审核流程**：人工审核机制
- **市场展示**：已审核项目展示
- **评分评论**：用户评分和评论
- **贡献统计**：开发者贡献统计

### 使用方法

#### 提交插件
```javascript
const { communityRepository } = require('./scripts/community-repository');

const pluginSubmission = {
    name: '插件名称',
    description: '插件描述',
    author: '开发者姓名',
    email: 'developer@example.com',
    version: '1.0.0',
    category: 'style',
    code: '插件代码...',
    documentation: '使用文档...',
    screenshots: []
};

const result = await communityRepository.submitPlugin(pluginSubmission);
console.log('提交ID:', result.id);
console.log('状态:', result.status);
```

#### 提交模板
```javascript
const templateSubmission = {
    name: '模板名称',
    description: '模板描述',
    author: '开发者姓名',
    email: 'developer@example.com',
    version: '1.0.0',
    category: 'article',
    template: '模板内容...',
    variables: [
        { name: 'title', description: '标题', required: true }
    ],
    preview: '预览内容...',
    screenshots: []
};

const result = await communityRepository.submitTemplate(templateSubmission);
```

#### 获取市场列表
```javascript
// 获取所有项目
const allItems = communityRepository.getMarketplace();

// 按类型过滤
const plugins = communityRepository.getMarketplace({ type: 'plugin' });

// 按分类过滤
const stylePlugins = communityRepository.getMarketplace({ 
    type: 'plugin', 
    category: 'style' 
});

// 搜索
const searchResults = communityRepository.getMarketplace({ 
    search: '小红书' 
});

// 排序
const topRated = communityRepository.getMarketplace({ 
    sortBy: 'rating' 
});
```

#### 下载项目
```javascript
const item = communityRepository.downloadItem(itemId);
console.log('下载次数:', item.downloads);
```

#### 添加评论
```javascript
const review = {
    author: '用户A',
    rating: 5,
    comment: '非常好用的插件！'
};

const result = communityRepository.addReview(itemId, review);
console.log('评论ID:', result.id);
```

#### 获取开发者统计
```javascript
const stats = communityRepository.getDeveloperStats('developer@example.com');
console.log('总提交数:', stats.totalSubmissions);
console.log('总下载量:', stats.totalDownloads);
console.log('平均评分:', stats.avgRating);
```

#### 审核项目
```javascript
const reviewResult = {
    approved: true,
    comment: '审核通过',
    reviewer: '审核员A'
};

const result = communityRepository.reviewSubmission(submissionId, reviewResult);
console.log('最终状态:', result.status);
```

### 提交规范

#### 必填字段
- `name`: 名称
- `description`: 描述
- `author`: 作者姓名
- `email`: 作者邮箱
- `version`: 版本号（格式：x.y.z）
- `category`: 分类

#### 插件分类
- `style`: 风格增强
- `content`: 内容生成
- `platform`: 平台适配
- `analysis`: 数据分析

#### 模板分类
- `article`: 文章模板
- `product`: 产品介绍
- `case`: 案例研究
- `marketing`: 营销文案

---

## 运行示例

所有功能都有完整的使用示例：

```bash
# 运行所有示例
node scripts/enhancement-examples.js

# 运行特定示例
node -e "require('./scripts/enhancement-examples').exampleContentFission()"
```

---

## 文件结构

```
workbuddy-claw-wechat-publisher/
├── scripts/
│   ├── content-fission-engine.js          # 内容裂变引擎
│   ├── content-fission/
│   │   ├── image-cards-generator.js      # 图文卡片生成器
│   │   └── quote-poster-generator.js     # 金句海报生成器
│   ├── ai-report-generator.js            # AI报告生成器
│   ├── optimization-loop-engine.js       # 优化循环引擎
│   ├── community-repository.js           # 社区仓库管理
│   └── enhancement-examples.js           # 使用示例
├── data/
│   └── community-repository/             # 社区数据目录
│       ├── plugins/                      # 已审核插件
│       ├── templates/                    # 已审核模板
│       ├── submissions/                  # 待审核提交
│       ├── reviews/                      # 评论数据
│       └── stats/                        # 统计数据
└── config/
    ├── optimization-preferences.json     # 优化偏好数据
    └── ai-providers.json                 # AI配置
```

---

## API集成

### CMS集成

在CMS中使用这些功能：

```php
// 内容裂变
$result = file_get_contents('http://localhost:3456/api/content-fission', false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode([
            'title' => $article['title'],
            'content' => $article['content'],
            'outputs' => ['video-script', 'image-cards']
        ])
    ]
]));

// 生成报告
$report = file_get_contents('http://localhost:3456/api/generate-report?reportType=weekly');

// 获取优化参数
$params = file_get_contents('http://localhost:3456/api/optimal-params');
```

---

## 注意事项

1. **AI配置**：确保 `config/ai-providers.json` 配置正确
2. **数据库连接**：AI报告功能需要连接CMS数据库
3. **权限管理**：社区功能需要实现用户认证和权限控制
4. **定时任务**：建议使用PM2或systemd管理定时任务

---

## 技术支持

如有问题，请提交Issue或联系开发团队。

---

*最后更新：2026-06-17*