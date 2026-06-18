# Content Digital Employee (内容数字员工)

<div align="center">

![Version](https://img.shields.io/badge/version-4.0.0-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)
![Language](https://img.shields.io/badge/language-Python-orange.svg)

**AI驱动的企业内容智能生成平台**

[快速开始](#快速开始) • [功能特性](#功能特性) • [文档](#文档) • [贡献指南](#贡献指南) • [社区](#社区)

</div>

---

## 📖 项目简介

Content Digital Employee 是一个开源的企业内容智能生成平台，帮助企业实现内容生产的自动化、智能化。通过AI技术，将产品信息、技术文档、行业知识转化为高质量的市场内容。

### 🎯 核心价值

- **效率提升**：内容生成时间从4小时缩短到10分钟，提升90%效率
- **质量保证**：多轮优化机制，确保内容专业性与可读性
- **多平台适配**：一键生成适配不同平台风格的内容
- **持续迭代**：基于用户反馈持续优化生成策略

### 🌟 适用场景

- 制造业：产品说明书、技术文档、销售话术
- B2B服务：行业报告、解决方案、客户案例
- 电商：产品描述、营销文案、SEO文章
- 专业服务：知识分享、行业洞察、白皮书

---

## ✨ 功能特性

### 核心功能

| 功能 | 描述 | 状态 |
|------|------|------|
| **技术翻译官** | 将技术参数转化为客户能理解的语言 | ✅ 已完成 |
| **去AI味优化** | 让AI生成的内容更自然、更像人工写作 | ✅ 已完成 |
| **产品文档生成** | 基于产品信息自动生成说明书、技术文档 | ✅ 已完成 |
| **热点话题挖掘** | 自动挖掘行业热点，生成选题建议 | ✅ 已完成 |
| **多风格适配** | 支持小红书、知乎、公众号等不同平台风格 | ✅ 已完成 |
| **跨平台发布** | 一键发布到微信、小红书、抖音等平台 | ✅ 已完成 |
| **产品数据采集** | 从产品平台采集数据，生成结构化BOM清单 | ✅ 已完成 |
| **内容效果分析** | 基于阅读反馈优化内容生成策略 | 🚧 开发中 |
| **CMS深度集成** | 与CMS系统深度集成，自动栏目生成 | 🚧 开发中 |

### 企业版独有功能

> 以下功能在开源版中受限，完整功能请使用[企业版](https://scsaiclaw.com)

- CMS深度集成
- 企业知识库
- 多用户权限管理
- 内容阅读反馈分析
- 需求征集与管理

---

## 🚀 快速开始

### 环境要求

- Node.js 14+
- Python 3.8+
- Redis 6.0+（可选）
- MySQL 8.0+（可选）

### 安装步骤

```bash
# 1. 克隆仓库
git clone https://github.com/scsaiclaw/content-digital-employee.git
cd content-digital-employee

# 2. 安装依赖
npm install
pip install -r requirements.txt

# 3. 配置环境变量
cp config/user-config.json.example config/user-config.json
# 编辑 user-config.json 文件，填入你的API密钥

# 4. 验证安装
node index.js --help

# 5. 查看今日热点
node index.js --hotspot
```

### Docker 部署

```bash
# 一键启动
docker-compose up -d

# 查看日志
docker-compose logs -f

# 停止服务
docker-compose down
```

---

## 📚 使用示例

### 1. 技术翻译官

```bash
# 使用命令行工具
node scripts/tech-translate.js --product "智能焊接机器人X200" --params "焊接速度:0.5-2.0m/min,精度:±0.05mm,材料:碳钢/不锈钢/铝合金"
```

### 2. 去AI味优化

```bash
# 优化AI生成的内容
node scripts/humanize.js --content "本产品采用先进的人工智能技术，具有卓越的性能表现"
```

### 3. 产品文档生成

```bash
# 基于产品信息生成文档
node scripts/product-doc.js --product "工业物联网网关IG-500" --features "支持MQTT/Modbus/OPC UA协议,边缘计算能力,工业级防护IP65"
```

### 4. 多平台内容生成

```bash
# 生成适配不同平台的内容
node commands/content-create.md --platforms wechat,xiaohongshu,douyin
```

### 5. 产品数据采集

```bash
# 采集产品平台数据
node scripts/collect-product-data.js [productId]

# 生成BOM清单
node scripts/generate-bom.js [productId] [format]
```

---

## 🏗️ 项目架构

```
content-digital-employee/
├── commands/              # 命令脚本
│   ├── content-create.md  # 内容创作命令
│   ├── multi-publish.md   # 多平台发布命令
│   └── product-data-collect.md  # 产品数据采集
├── scripts/               # 功能脚本
│   ├── collect-product-data.js  # 产品数据采集
│   ├── generate-bom.js    # BOM生成
│   ├── cms-bridge.cjs     # CMS桥接
│   └── video-platforms/   # 视频平台发布
├── server/                # Web服务器
│   ├── routes/            # API路由
│   ├── services/          # 服务层
│   └── public/            # 静态资源
├── skills/                # 技能模块
│   ├── wb-cover-image/    # 封面生成
│   ├── wb-image-gen/      # 图片生成
│   └── wechat-publisher/  # 微信发布
├── config/                # 配置文件
├── data/                  # 数据文件
├── docs/                  # 文档
└── README.md
```

---

## 🔧 配置说明

### 环境变量

```json
{
  "wechat": {
    "appId": "your_app_id",
    "appSecret": "your_app_secret",
    "thumbMediaID": "default_cover_media_id"
  },
  "ai": {
    "provider": "deepseek",
    "model": "deepseek-coder",
    "apiKey": "your_api_key"
  },
  "publish": {
    "targetTime": "07:00",
    "minHeat": 50000
  },
  "keywords": {
    "primary": ["人工智能", "机器人", "大模型"],
    "secondary": ["互联网", "通信", "5G"],
    "exclude": ["明星", "娱乐", "八卦"]
  }
}
```

---

## 🤝 贡献指南

我们欢迎所有形式的贡献！

### 如何贡献

1. Fork 本仓库
2. 创建特性分支 (`git checkout -b feature/AmazingFeature`)
3. 提交更改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 提交 Pull Request

### 代码规范

- 遵循 ESLint 规范
- 提交前运行测试：`npm test`
- 提交前运行代码检查：`npm run lint`

### 开发路线图

- [ ] 内容效果分析与优化
- [ ] CMS深度集成
- [ ] 企业知识库管理
- [ ] 多语言支持
- [ ] 语音内容生成
- [ ] 视频脚本生成

---

## 📈 路线图

### v4.1 (计划中)
- 内容效果分析
- 需求征集模块
- CMS深度集成

### v4.2 (计划中)
- 企业知识库
- 多用户权限管理
- 内容阅读反馈

### v5.0 (远期规划)
- 多语言支持
- 语音内容生成
- 视频脚本生成

---

## 📄 开源协议

本项目采用 [MIT License](LICENSE) 开源协议。

### 商业使用

开源版本可用于个人学习和非商业用途。如需用于企业生产环境，请考虑使用[企业版](https://scsaiclaw.com)或购买商业授权。

---

## 🌐 社区与支持

### 官方资源

- 🏠 官网：https://scsaiclaw.com
- 📖 文档：https://docs.scsaiclaw.com
- 💬 微信群：扫描下方二维码加入

### 联系我们

- 📧 邮箱：contact@scsaiclaw.com
- 📱 电话：186-0192-1816
- 💬 微信：AI_Content_Expert

### 问题反馈

如果你发现了Bug或有功能建议，请：

1. 在 [Issues](https://github.com/scsaiclaw/content-digital-employee/issues) 中搜索是否已有相同问题
2. 如果没有，创建新的Issue，详细描述问题或建议
3. 我们会在24小时内响应

---

## 🙏 致谢

感谢所有为本项目做出贡献的开发者！

特别感谢：
- OpenAI 提供的强大AI模型
- 开源社区的各种优秀工具和库
- WorkBuddy 平台的支持

---

## 📊 项目统计

![GitHub stars](https://img.shields.io/github/stars/scsaiclaw/content-digital-employee?style=social)
![GitHub forks](https://img.shields.io/github/forks/scsaiclaw/content-digital-employee?style=social)
![GitHub issues](https://img.shields.io/github/issues/scsaiclaw/content-digital-employee)

---

<div align="center">

**如果这个项目对你有帮助，请给我们一个 ⭐️ Star**

Made with ❤️ by [SCSAI](https://scsaiclaw.com)

</div>