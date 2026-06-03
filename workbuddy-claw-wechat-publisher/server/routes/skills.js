/**
 * WorkBuddy Skills API Route
 * 统一技能调用入口：图片生成、PPT生成、小红书卡片、封面图
 * 
 * GET  /api/skills          - 列出可用技能
 * POST /api/skills/:name    - 调用技能
 */

const express = require('express');
const router = express.Router();
const path = require('path');
const fs = require('fs');

const SKILLS_DIR = path.join(__dirname, '..', '..', 'skills');

// ── 技能注册表 ──────────────────────────────────────
const SKILL_REGISTRY = {
  'image-gen': {
    name: '图片生成',
    description: 'AI图片生成，支持DashScope/火山方舟/OpenAI/Google',
    script: path.join(SKILLS_DIR, 'wb-image-gen', 'scripts', 'generate.js'),
    icon: '🎨',
  },
  'slide-deck': {
    name: 'PPT生成',
    description: '从Markdown生成专业PPT，17种风格预设',
    script: path.join(SKILLS_DIR, 'wb-slide-deck', 'scripts', 'generate.js'),
    icon: '📊',
  },
  'xhs-images': {
    name: '小红书卡片',
    description: '文章转小红书卡片图系列，12风格×8布局',
    script: path.join(SKILLS_DIR, 'wb-xhs-images', 'scripts', 'generate-cards.js'),
    icon: '🎴',
  },
  'cover-image': {
    name: '封面图生成',
    description: '5维参数系统生成专业封面图，77种组合',
    script: path.join(SKILLS_DIR, 'wb-cover-image', 'scripts', 'generate-cover.js'),
    icon: '🖼️',
  },
};

// ── GET /api/skills - 列出技能 ──────────────────────────────────────
router.get('/', (req, res) => {
  const skills = Object.entries(SKILL_REGISTRY).map(([id, skill]) => ({
    id,
    name: skill.name,
    description: skill.description,
    icon: skill.icon,
    available: fs.existsSync(skill.script),
  }));
  res.json({ skills });
});

// ── GET /api/skills/:name - 获取技能详情 ──────────────────────────────────────
router.get('/:name', (req, res) => {
  const skill = SKILL_REGISTRY[req.params.name];
  if (!skill) return res.status(404).json({ error: 'Skill not found' });

  res.json({
    id: req.params.name,
    ...skill,
    available: fs.existsSync(skill.script),
  });
});

// ── POST /api/skills/:name/execute - 执行技能 ──────────────────────────────────────
router.post('/:name/execute', async (req, res) => {
  const skill = SKILL_REGISTRY[req.params.name];
  if (!skill) return res.status(404).json({ error: 'Skill not found' });

  if (!fs.existsSync(skill.script)) {
    return res.status(503).json({ error: 'Skill script not available', path: skill.script });
  }

  const { params } = req.body;

  try {
    // 根据技能类型执行不同逻辑
    let result;

    switch (req.params.name) {
      case 'image-gen': {
        const { generateImage } = require(skill.script);
        result = await generateImage(params.prompt, {
          output: params.output || 'output.png',
          provider: params.provider,
          model: params.model,
          ar: params.ar || '1:1',
          size: params.size,
          quality: params.quality || '2k',
          style: params.style,
          ref: params.ref,
        });
        break;
      }

      case 'slide-deck': {
        const { generateOutline, buildSlidePrompt, mergeToPptx, STYLE_PRESETS } = require(skill.script);
        
        // Step 1: 生成大纲
        const outline = await generateOutline(params.content, {
          style: params.style || 'blueprint',
          audience: params.audience || 'general',
          slides: params.slides || 12,
          lang: params.lang || 'zh',
        });

        // Step 2: 生成图片（异步，返回任务ID）
        const outputDir = params.outputDir || path.join(process.cwd(), 'slide-output');
        if (!fs.existsSync(outputDir)) fs.mkdirSync(outputDir, { recursive: true });

        // 保存大纲
        fs.writeFileSync(path.join(outputDir, 'outline.json'), JSON.stringify(outline, null, 2));

        result = {
          status: 'outline_ready',
          outline,
          outputDir,
          message: '大纲已生成，请确认后生成图片',
          slidesCount: outline.slides?.length || 0,
        };
        break;
      }

      case 'xhs-images': {
        const { splitContent, buildCardPrompt, STYLE_PRESETS } = require(skill.script);
        const { cards } = await splitContent(params.content, {
          style: params.style || 'cute',
          layout: params.layout || 'balanced',
        });

        result = {
          status: 'cards_ready',
          cards,
          message: `已拆分为${cards.length}张卡片，请确认后生成图片`,
        };
        break;
      }

      case 'cover-image': {
        const { buildCoverPrompt, autoSelectDimensions, DIMENSIONS } = require(skill.script);
        const dims = params.dims || autoSelectDimensions(params.content || '');
        const title = params.title || 'Cover';
        const prompt = buildCoverPrompt(title, params.subtitle, dims);

        result = {
          status: 'prompt_ready',
          prompt,
          dims,
          message: '封面图Prompt已生成，请确认后生成图片',
        };
        break;
      }

      default:
        return res.status(400).json({ error: 'Unknown skill' });
    }

    res.json({ success: true, skill: req.params.name, result });
  } catch (err) {
    console.error(`Skill execution error [${req.params.name}]:`, err);
    res.status(500).json({ error: err.message, skill: req.params.name });
  }
});

// ── POST /api/skills/:name/generate - 实际生成图片 ──────────────────────────────────────
router.post('/:name/generate', async (req, res) => {
  const { prompts, style } = req.body;
  const skill = SKILL_REGISTRY[req.params.name];
  if (!skill) return res.status(404).json({ error: 'Skill not found' });

  try {
    const { generateImage } = require(path.join(SKILLS_DIR, 'wb-image-gen', 'scripts', 'generate.js'));
    
    const subDir = req.params.name === 'xhs-images' ? 'xhs-output' : req.params.name === 'slide-deck' ? 'slide-output' : 'cover-output';
    const outputDir = path.join(__dirname, '..', 'public', 'output', subDir);
    if (!fs.existsSync(outputDir)) fs.mkdirSync(outputDir, { recursive: true });

    const results = [];
    for (let i = 0; i < prompts.length; i++) {
      const { prompt, filename } = prompts[i];
      const outputPath = path.join(outputDir, filename || `output_${i + 1}.png`);
      
      try {
        const result = await generateImage(prompt, {
          output: outputPath,
          style,
          ar: req.params.name === 'xhs-images' ? '3:4' : '16:9',
          quality: '2k',
        });
        results.push({ index: i, success: true, url: `/output/${subDir}/${filename || 'output_' + (i + 1) + '.png'}` });
      } catch (err) {
        results.push({ index: i, success: false, error: err.message });
      }
    }

    res.json({ success: true, results });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
