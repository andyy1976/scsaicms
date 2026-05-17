<?php
/**
 * AI智能客服API v2 - 接入OpenClaw本地大模型
 * 
 * 架构：
 *   前端JS → 此PHP API → OpenClaw Gateway (127.0.0.1:28789) → LLM
 * 
 * 双模式：
 *   - customer: AI智能客服（产品咨询、技术支持）
 *   - marketing: AI营销助手（内容创作、营销策略）
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); echo json_encode(['error' => 'Method not allowed']); exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$message = trim($input['message'] ?? '');
$history = $input['history'] ?? [];
$mode = $input['mode'] ?? 'customer';

if (empty($message)) { echo json_encode(['error' => '消息不能为空']); exit; }

// ========== Gateway配置 ==========
// 从环境变量或直接读取openclaw.json获取token
$gatewayToken = '';
$configFile = getenv('USERPROFILE') . '\.qclaw\openclaw.json';
if (file_exists($configFile)) {
    $cfg = json_decode(file_get_contents($configFile), true);
    $gatewayToken = $cfg['gateway']['auth']['token'] ?? '';
}

$gatewayUrl = 'http://127.0.0.1:28789/v1/chat/completions';
$gatewayModel = 'qclaw/modelroute';

// ========== 系统提示词 ==========
$systemPrompts = [
    'customer' => <<<PROMPT
你是SCSAI ContentOS（东方艾艾/超云智能）的AI智能客服助手。

## 公司信息
- 全称：东方艾艾（北京）科技有限公司 / 北京晨晖瑞汉科技有限公司（超云智能）
- 核心产品：AI数字员工平台（营销数字员工、客服数字员工、内容数字员工）
- 工业软件：PLM产品生命周期管理、MES制造执行系统、ERP企业资源计划、QMS质量管理
- 联系方式：电话 186-0192-1816，邮箱 tuan_zhang@sina.com，QQ 1275697128
- 地址：北京昌平区建材城西路9号金燕龙写字楼16层

## 产品详情

### 营销数字员工
- 自动采集5+信源平台热点内容
- AI五维评分筛选高价值内容
- 一键生成多平台格式文案（公众号/小红书/抖音）
- 多平台自动发布与精准获客
- 适合B2B企业市场部高频内容需求

### 客服数字员工
- 7x24小时智能问答
- 基于企业知识库准确回答
- 意图识别 + 工单流转
- 多入口接入（网站/微信/APP）
- 成功案例：某工业软件公司部署后响应速度提升90%，满意度从72%→91%

### 价格套餐
- 免费版：0元/月，每月50条内容生成
- 专业版：99元/月，每月500条+AI评分+多平台发布
- 企业版：定制方案，不限量+PLM/MES集成+专属服务

## 回答要求
1. 友好、专业、简洁，适当使用emoji增加亲和力
2. 涉及价格时建议预约演示获取详细报价
3. 不知道答案时建议联系人工客服
4. 回复使用中文，控制在200字以内（除非用户要求详细说明）
5. 可以主动引导用户体验产品或留下联系方式
PROMPT,

    'marketing' => <<<PROMPT
你是SCSAI ContentOS的AI营销助手，擅长B2B工业领域的内容创作和营销策略。

## 你的能力
1. 营销文案生成：公众号文章、小红书笔记、朋友圈文案、产品介绍
2. 内容优化：标题优化、SEO关键词建议、阅读体验提升
3. 营销策略：内容日历规划、多平台分发策略、获客路径设计
4. 行业洞察：智能制造、工业软件、数字化转型相关趋势分析

## 写作风格
- B2B专业风格但不枯燥
- 数据驱动，善用案例和数字
- 标题吸引眼球，结构清晰易读
- 适合制造业/工业软件目标受众

## 回答要求
1. 专业、有创意、有见地
2. 提供具体可执行的建议和示例
3. 使用中文，适当使用emoji
4. 输出内容可直接用于实际营销场景
PROMPT
];

$systemPrompt = $systemPrompts[$mode] ?? $systemPrompts['customer'];

// ========== 调用Gateway ==========

try {
    $messages = [['role' => 'system', 'content' => $systemPrompt]];
    
    // 历史对话（最近10轮）
    foreach (array_slice($history, -10) as $msg) {
        $messages[] = $msg;
    }
    $messages[] = ['role' => 'user', 'content' => $message];
    
    $response = callGateway($gatewayUrl, $gatewayModel, $gatewayToken, $messages);
    
    if ($response !== null) {
        echo json_encode([
            'reply' => $response,
            'source' => 'openclaw',
            'model' => $gatewayModel
        ]);
    } else {
        echo json_encode([
            'reply' => getFallbackReply($message, $mode),
            'source' => 'fallback'
        ]);
    }
} catch (Exception $e) {
    error_log("AI Chat Error: " . $e->getMessage());
    echo json_encode([
        'reply' => getFallbackReply($message, $mode),
        'source' => 'fallback',
        'error' => $e->getMessage()
    ]);
}

// ========== Gateway调用函数 ==========
function callGateway($url, $model, $token, $messages) {
    $ch = curl_init($url);
    
    $payload = [
        'model' => $model,
        'messages' => $messages,
        'max_tokens' => 1000,
        'temperature' => 0.7,
        'stream' => false
    ];
    
    $headers = ['Content-Type: application/json'];
    if (!empty($token)) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }
    
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        error_log("Gateway Connection Error: " . $error);
        return null;
    }
    
    if ($httpCode !== 200) {
        error_log("Gateway HTTP Error: $httpCode - $response");
        return null;
    }
    
    $data = json_decode($response, true);
    return $data['choices'][0]['message']['content'] ?? null;
}

// ========== 备用回复 ==========
function getFallbackReply($message, $mode = 'customer') {
    $msg = mb_strtolower($message);
    
    // 关键词匹配备用回复
    $patterns = [
        'customer' => [
            ['k' => ['价格', '多少钱', '收费', '费用'], 
             'v' => "💰 我们提供灵活的套餐方案：\n\n• **免费版** — 0元/月，50条内容/月\n• **专业版** — 99元/月，500条+AI评分+多平台发布\n• **企业版** — 定制方案，不限量+深度集成\n\n📞 预约演示获取详细报价：**186-0192-1816**"],
            ['k' => ['免费', '体验', '试用', '演示'], 
             'v' => "🎯 欢迎体验！您可以通过以下方式开始：\n\n1️⃣ 在线留言（点击底部\"在线留言\"）\n2️⃣ 电话咨询：**186-0192-1816**\n3️⃣ 邮箱：tuan_zhang@sina.com\n\n我们的产品经理会尽快安排演示！"],
            ['k' => ['营销数字员工', '营销员工'], 
             'v' => "🤖 **营销数字员工** 是专为B2B市场团队打造的AI助手：\n\n• 📡 自动采集热点内容（5+信源平台）\n• 🎯 AI五维评分筛选高价值信息\n• ✍️ 一键生成多平台格式文案\n• 🚀 多平台发布 + 精准获客\n\n非常适合需要高频输出内容的B2B企业！"],
            ['k' => ['客服数字员工', '客服员工'], 
             'v' => "🤖 **客服数字员工** 提供7x24小时智能服务：\n\n• 💬 基于知识库的精准问答\n• 🎯 智能意图识别\n• 📝 复杂问题自动转人工\n• 📊 对话数据分析优化\n\n成功案例：某工业软件公司部署后，响应速度↑90%，满意度72%→91%！"],
            ['k' => ['plm', 'mes', 'erp', 'qms', '工业软件'], 
             'v' => "🏭 我们提供完整的工业软件解决方案：\n\n• **PLM** — 产品生命周期管理\n• **MES** — 制造执行系统\n• **ERP** — 企业资源计划\n• **QMS** — 质量管理系统\n\n可与AI数字员工深度集成，实现数据互通和智能化升级。\n\n📞 咨询热线：**186-0192-1816**"],
            ['k' => ['联系', '电话', '人工', '客服', '销售'], 
             'v' => "📞 联系我们的人工团队：\n\n• **电话**：186-0192-1816\n• **邮箱**：tuan_zhang@sina.com\n• **QQ**：1275697128\n• **地址**：北京昌平区建材城西路9号金燕龙写字楼16层\n\n工作时间：周一至周五 9:00-18:00"],
            ['k' => ['数字员工', '产品', '功能', '介绍'], 
             'v' => "🚀 SCSAI数字员工平台核心能力：\n\n**营销数字员工** → 内容采集·AI评分·智能生成·多平台发布·精准获客\n**客服数字员工** → 7×24问答·意图识别·工单流转·数据分析\n**内容数字员工** → AI写作·图文排版·多格式转换·一键分发\n\n三大数字员工协同工作，覆盖从获客到服务的完整链路！"],
        ],
        'marketing' => [
            ['k' => ['文章', '写一篇', '帮我写', '生成'], 
             'v' => "✍️ 我可以帮您撰写各类营销内容！请告诉我：\n\n1. **主题/行业**（如：智能制造、PLM、数字化转型）\n2. **目标受众**（如：CTO、采购经理、工厂厂长）\n3. **发布平台**（公众号/小红书/官网/白皮书）\n4. **字数要求**（如：800字/1500字/3000字）\n\n提供这些信息，我立即为您生成！"],
            ['k' => ['小红书', '红书', '笔记'], 
             'v' => "📕 小红书文案我来帮您！请提供：\n\n1. 推广的产品/服务\n2. 目标人群画像\n3. 想突出的卖点（1-3个）\n4. 是否需要emoji和话题标签\n\n我会按小红书爆款风格来写：吸睛标题+种草正文+热门标签！"],
            ['k' => ['策略', '规划', '方案', '怎么推广'], 
             'v' => "📊 营销策略规划，我可以从以下维度帮您：\n\n• **内容矩阵** — 不同平台的内容差异化策略\n• **发布节奏** — 最佳发布时间和频率\n• **获客路径** — 从曝光到转化的完整漏斗\n• **竞品分析** — 同行内容策略对标\n\n请告诉我您的行业和当前痛点，我给出针对性建议。"],
        ]
    ];
    
    $list = $patterns[$mode] ?? $patterns['customer'];
    foreach ($list as $item) {
        foreach ($item['k'] as $kw) {
            if (strpos($msg, $kw) !== false) return $item['v'];
        }
    }
    
    // 默认回复
    if ($mode === 'marketing') {
        return "您好！我是AI营销助手 🎨\n\n我可以帮您：\n• ✍️ 生成营销文案和文章\n• 📕 写小红书爆款笔记\n• 📊 制定内容策略\n• 🔧 优化现有文案\n\n请告诉我您的具体需求~";
    }
    
    return "感谢您的咨询！😊\n\n我可以帮您了解：\n• 🤖 数字员工产品功能\n• 💰 价格和套餐方案\n• 🎯 免费体验预约\n• 🏭 工业软件解决方案\n• 📞 人工客服对接\n\n也可以直接提问，我会尽力解答！";
}
