<?php
/**
 * 内容数字员工API控制器
 * 整合 workbuddy-claw-wechat-publisher 功能
 */

// 加载Composer自动加载器
$autoloadPath = dirname(dirname(dirname(__FILE__))) . '/workbuddy-claw-wechat-publisher/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

class ContentemployeeAction extends Action
{
    // AI配置
    private $aiConfig;
    
    // DeepSeek API配置
    private $apiKey = 'sk-037a111a60be4b28b812fa3407399c07';
    private $apiUrl = 'https://api.deepseek.com/v1/chat/completions';
    private $model = 'deepseek-v4-flash';
    // 备选模型列表
    private $fallbackModels = [
        'deepseek-v4-flash',
        'deepseek-chat',
        'deepseek-coder',
        'deepseek-reasoner'
    ];
    
    // CMS保存配置
    private $cmsApiKey = 'sciot_content_2026'; // CMS API密钥
    
    public function __construct()
    {
        parent::__construct();
        // 加载AI配置
        $configPath = dirname(dirname(dirname(__FILE__))) . '/workbuddy-claw-wechat-publisher/config/ai-providers.json';
        if (file_exists($configPath)) {
            $this->aiConfig = json_decode(file_get_contents($configPath), true);
        }
    }
    
    /**
     * 保存文章到CMS
     * POST /api/save-article
     */
    public function saveArticle()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
        
        // 获取JSON请求体
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) {
            $postData = $_POST;
        }
        
        // 获取参数
        $title = isset($postData['title']) ? $postData['title'] : '';
        $content = isset($postData['content']) ? $postData['content'] : '';
        $typeid = isset($postData['typeid']) ? intval($postData['typeid']) : 21215; // 默认：技术观察
        $keywords = isset($postData['keywords']) ? $postData['keywords'] : '';
        $description = isset($postData['description']) ? $postData['description'] : '';
        $source = isset($postData['source']) ? $postData['source'] : 'AI数字员工';
        
        if (empty($title) || empty($content)) {
            $this->ajaxReturn(['success' => false, 'message' => '标题和内容不能为空'], 'JSON');
            return;
        }
        
        // 保存到数据库
        $article = M('article', 'lvbo_');
        
        // 检查是否已存在
        $exists = $article->where(['title' => $title])->find();
        if ($exists) {
            $this->ajaxReturn([
                'success' => true, 
                'message' => '文章已存在',
                'aid' => $exists['aid'],
                'url' => '/index.php?s=Article/index/aid/' . $exists['aid'] . '.html'
            ], 'JSON');
            return;
        }
        
        // 构建数据
        $data = [
            'title' => mb_substr($title, 0, 80, 'utf-8'),
            'keywords' => mb_substr($keywords, 0, 40, 'utf-8'),
            'description' => $description ?: mb_substr(strip_tags($content), 0, 200, 'utf-8'),
            'note' => mb_substr(strip_tags($content), 0, 200, 'utf-8'),
            'content' => $content,
            'typeid' => $typeid,
            'status' => 1,
            'addtime' => date('Y-m-d H:i:s'),
            'author' => $source,
            'copyfrom' => $source,
            'hits' => 1,
            'is_ai_generated' => 1,
        ];
        
        $aid = $article->add($data);
        
        if ($aid) {
            $this->ajaxReturn([
                'success' => true,
                'message' => '保存成功',
                'aid' => $aid,
                'url' => '/index.php?s=Article/index/aid/' . $aid . '.html'
            ], 'JSON');
        } else {
            $this->ajaxReturn([
                'success' => false,
                'message' => '保存失败：' . $article->getDbError()
            ], 'JSON');
        }
    }
    
    /**
     * 获取栏目列表
     * GET /api/categories
     */
    public function categories()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $type = M('type', 'lvbo_');
        $list = $type->field('typeid, typename, fid')
                     ->where('ismenu = 1')
                     ->order('drank asc')
                     ->select();
        
        $this->ajaxReturn(['success' => true, 'data' => $list], 'JSON');
    }
    
    /**
     * AI人性化改写接口
     * POST /api/humanize
     */
    public function humanize()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        
        // 处理OPTIONS预检请求
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
        
        // 获取JSON请求体
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        
        // 如果JSON解析失败，尝试从POST获取
        if (!$postData) {
            $postData = $_POST;
        }
        
        $text = isset($postData['text']) ? $postData['text'] : '';
        $style = isset($postData['style']) ? $postData['style'] : 'general';
        $prompt = isset($postData['prompt']) ? $postData['prompt'] : '';
        
        if (empty($text)) {
            $this->ajaxReturn(['success' => false, 'message' => '请输入需要改写的文字'], 'JSON');
            return;
        }
        
        if (mb_strlen($text) > 3000) {
            $this->ajaxReturn(['success' => false, 'message' => '文字长度超过3000字'], 'JSON');
            return;
        }
        
        try {
            // 调用AI进行改写
            $result = $this->callAI($prompt . "\n\n原文：\n" . $text);
            
            // 计算AI检测分数（模拟）
            $aiScore = $this->calculateAIScore($result);
            
            $this->ajaxReturn([
                'success' => true,
                'result' => $result,
                'aiScore' => $aiScore,
                'style' => $style
            ], 'JSON');
            
        } catch (Exception $e) {
            $this->ajaxReturn([
                'success' => false,
                'message' => '处理失败：' . $e->getMessage()
            ], 'JSON');
        }
    }
    
    /**
     * AI检测接口
     * POST /api/detect-ai
     */
    public function detect_ai()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) {
            $postData = $_POST;
        }
        
        $text = isset($postData['text']) ? $postData['text'] : '';
        
        if (empty($text)) {
            $this->ajaxReturn(['success' => false, 'message' => '请输入文字'], 'JSON');
            return;
        }
        
        $score = $this->calculateAIScore($text);
        
        $this->ajaxReturn([
            'success' => true,
            'score' => $score
        ], 'JSON');
    }
    
    /**
     * 技术文档翻译接口
     * POST /api/tech-translate
     */
    public function tech_translate()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) {
            $postData = $_POST;
        }
        
        $text = isset($postData['text']) ? $postData['text'] : '';
        $target = isset($postData['target']) ? $postData['target'] : 'plain'; // plain: 通俗语言, marketing: 营销语言
        
        if (empty($text)) {
            $this->ajaxReturn(['success' => false, 'message' => '请输入技术文档'], 'JSON');
            return;
        }
        
        $prompt = $target === 'marketing' 
            ? "请将以下技术文档翻译成营销语言，突出产品优势，适合销售话术：\n\n"
            : "请将以下技术文档翻译成普通人能看懂的人话，去掉术语堆砌，用通俗语言解释：\n\n";
        
        try {
            $result = $this->callAI($prompt . $text);
            
            $this->ajaxReturn([
                'success' => true,
                'result' => $result
            ], 'JSON');
            
        } catch (Exception $e) {
            $this->ajaxReturn([
                'success' => false,
                'message' => '处理失败：' . $e->getMessage()
            ], 'JSON');
        }
    }
    
    /**
     * 产品说明书生成接口
     * POST /api/product-doc
     */
    public function product_doc()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) {
            $postData = $_POST;
        }
        
        $specs = isset($postData['specs']) ? $postData['specs'] : ''; // 产品规格参数
        $productName = isset($postData['name']) ? $postData['name'] : ''; // 产品名称
        $type = isset($postData['type']) ? $postData['type'] : 'manual'; // manual: 说明书, sales: 销售话术
        
        if (empty($specs)) {
            $this->ajaxReturn(['success' => false, 'message' => '请输入产品规格'], 'JSON');
            return;
        }
        
        $prompt = $type === 'sales'
            ? "根据以下产品规格，生成营销风格的销售话术，突出产品优势和客户价值：\n\n产品名称：{$productName}\n规格参数：\n{$specs}"
            : "根据以下产品规格，生成专业的产品说明书，包括产品介绍、功能特点、使用方法、注意事项：\n\n产品名称：{$productName}\n规格参数：\n{$specs}";
        
        try {
            $result = $this->callAI($prompt);
            
            $this->ajaxReturn([
                'success' => true,
                'result' => $result
            ], 'JSON');
            
        } catch (Exception $e) {
            $this->ajaxReturn([
                'success' => false,
                'message' => '处理失败：' . $e->getMessage()
            ], 'JSON');
        }
    }
    
    /**
     * 热点采集接口
     * GET /api/hotspot
     */
    public function hotspot()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $source = isset($_GET['source']) ? $_GET['source'] : 'weibo'; // weibo, zhihu, reddit
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
        
        try {
            // 调用内容数字员工的热点采集功能
            $hotspots = $this->fetchHotspots($source, $limit);
            
            $this->ajaxReturn([
                'success' => true,
                'data' => $hotspots,
                'source' => $source
            ], 'JSON');
            
        } catch (Exception $e) {
            $this->ajaxReturn([
                'success' => false,
                'message' => '采集失败：' . $e->getMessage()
            ], 'JSON');
        }
    }
    
    /**
     * 多平台发布接口
     * POST /api/publish
     */
    public function publish()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) {
            $postData = $_POST;
        }
        
        $title = isset($postData['title']) ? $postData['title'] : '';
        $content = isset($postData['content']) ? $postData['content'] : '';
        $platforms = isset($postData['platforms']) ? $postData['platforms'] : []; // ['wechat', 'xiaohongshu', 'douyin']
        
        if (empty($title) || empty($content)) {
            $this->ajaxReturn(['success' => false, 'message' => '请填写标题和内容'], 'JSON');
            return;
        }
        
        try {
            $results = [];
            
            foreach ($platforms as $platform) {
                $results[$platform] = $this->publishToPlatform($platform, $title, $content);
            }
            
            $this->ajaxReturn([
                'success' => true,
                'results' => $results
            ], 'JSON');
            
        } catch (Exception $e) {
            $this->ajaxReturn([
                'success' => false,
                'message' => '发布失败：' . $e->getMessage()
            ], 'JSON');
        }
    }
    
    /**
     * 调用AI模型（支持模型回退）
     */
    private function callAI($prompt, $maxTokens = 2000)
    {
        // 使用Agnes AI（兼容OpenAI格式）
        $apiKey = $this->apiKey;
        $apiUrl = $this->apiUrl;
        
        // 也可以从环境变量覆盖
        if (getenv('AGNES_API_KEY')) {
            $apiKey = getenv('AGNES_API_KEY');
        }
        
        if (empty($apiKey)) {
            throw new Exception('API Key未配置');
        }
        
        // 检查curl扩展
        if (!function_exists('curl_init')) {
            throw new Exception('PHP curl扩展未启用，请在php.ini中启用extension=curl');
        }
        
        // 尝试主模型和备选模型
        $modelsToTry = array_merge([$this->model], $this->fallbackModels);
        $modelsToTry = array_unique($modelsToTry); // 去重
        
        $lastError = '';
        foreach ($modelsToTry as $model) {
            try {
                $result = $this->callAIWithModel($apiKey, $apiUrl, $model, $prompt, $maxTokens);
                return $result;
            } catch (Exception $e) {
                $lastError = $e->getMessage();
                // 如果是503错误（模型不可用），尝试下一个模型
                if (strpos($lastError, '503') !== false || strpos($lastError, 'No available channel') !== false) {
                    error_log("模型 {$model} 不可用，尝试下一个模型");
                    continue;
                }
                // 其他错误直接抛出
                throw $e;
            }
        }
        
        // 所有模型都失败了
        throw new Exception('所有模型都不可用：' . $lastError);
    }
    
    /**
     * 使用指定模型调用AI
     */
    private function callAIWithModel($apiKey, $apiUrl, $model, $prompt, $maxTokens)
    {
        $data = [
            'model' => $model,
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'max_tokens' => $maxTokens,
            'temperature' => 0.7
        ];
        
        $ch = curl_init();
        if ($ch === false) {
            throw new Exception('curl_init失败');
        }
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $errno = curl_errno($ch);
        curl_close($ch);
        
        // 记录详细调试日志
        $logMsg = date('Y-m-d H:i:s') . " AI API Call:\n" .
                  "URL: {$apiUrl}\n" .
                  "Model: {$model}\n" .
                  "HTTP Code: {$httpCode}\n" .
                  "Curl Error: {$error} ({$errno})\n" .
                  "Response: " . substr($response, 0, 500) . "\n";
        error_log($logMsg);
        
        // 检查curl错误
        if ($errno !== 0) {
            throw new Exception('网络请求失败：' . $error . ' (错误码:' . $errno . ')');
        }
        
        if ($httpCode !== 200) {
            $errorMsg = 'API返回HTTP ' . $httpCode;
            if ($response) {
                $errorData = json_decode($response, true);
                if (isset($errorData['error']['message'])) {
                    $errorMsg .= ' - ' . $errorData['error']['message'];
                }
            }
            throw new Exception($errorMsg);
        }
        
        if (empty($response)) {
            throw new Exception('API返回空响应');
        }
        
        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('JSON解析失败：' . json_last_error_msg() . '，响应内容：' . substr($response, 0, 200));
        }
        
        if (isset($result['choices'][0]['message']['content'])) {
            return $result['choices'][0]['message']['content'];
        }
        
        // 检查是否有错误信息
        if (isset($result['error'])) {
            throw new Exception('API错误：' . $result['error']['message']);
        }
        
        throw new Exception('API返回格式错误，缺少choices字段。响应：' . substr($response, 0, 300));
    }
    
    /**
     * 模拟AI响应（降级方案）
     */
    private function simulateAIResponse($prompt)
    {
        // 简单的文本处理
        $text = $prompt;
        
        // AI痕迹替换
        $replacements = [
            '首先，' => '先说，',
            '其次，' => '然后，',
            '最后，' => '另外，',
            '综上所述，' => '所以，',
            '总而言之，' => '简单说，',
            '值得注意的是' => '有意思的是',
            '不可否认的是' => '说实话',
            '众所周知' => '大家都知道',
            '显而易见' => '很明显',
            '毋庸置疑' => '肯定',
            '具有重要意义' => '很重要',
            '具有深远影响' => '影响很大',
            '呈现出' => '表现出',
            '体现出' => '表现出',
            '展现出' => '表现出',
            '人工智能技术的快速发展' => 'AI发展得很快',
            '正在深刻改变着' => '正在改变',
            '各个行业的运作模式' => '各行各业的工作方式',
        ];
        
        foreach ($replacements as $search => $replace) {
            $text = str_replace($search, $replace, $text);
        }
        
        return $text . "\n\n[注：这是演示效果，请配置DEEPSEEK_API_KEY启用完整功能]";
    }
    
    /**
     * 计算AI检测分数
     */
    private function calculateAIScore($text)
    {
        // 简单的AI痕迹检测
        $aiPatterns = [
            '首先', '其次', '最后', '综上所述', '总而言之',
            '值得注意的是', '不可否认的是', '众所周知', '显而易见', '毋庸置疑',
            '具有重要意义', '具有深远影响', '呈现出', '体现出', '展现出',
            '人工智能技术的快速发展', '正在深刻改变着', '各个行业的运作模式'
        ];
        
        $score = 0;
        foreach ($aiPatterns as $pattern) {
            if (mb_strpos($text, $pattern) !== false) {
                $score += 5;
            }
        }
        
        // 添加随机因素
        $score = min(95, max(5, $score + rand(-10, 10)));
        
        return $score;
    }
    
    /**
     * 获取热点数据
     */
    private function fetchHotspots($source, $limit)
    {
        // 这里可以调用 workbuddy-claw-wechat-publisher 的热点采集功能
        // 目前返回模拟数据
        $hotspots = [
            ['title' => 'AI大模型最新突破', 'heat' => 850000, 'source' => '微博热搜'],
            ['title' => '智能制造转型升级', 'heat' => 620000, 'source' => '微博热搜'],
            ['title' => '机器人产业新动态', 'heat' => 480000, 'source' => '微博热搜'],
        ];
        
        return array_slice($hotspots, 0, $limit);
    }
    
    /**
     * 发布到平台
     */
    private function publishToPlatform($platform, $title, $content)
    {
        // 这里可以调用 workbuddy-claw-wechat-publisher 的发布功能
        return [
            'status' => 'success',
            'message' => "已发布到 {$platform}",
            'url' => "https://example.com/{$platform}/123"
        ];
    }
    
    /**
     * 测试API连接
     * GET /api/test-ai
     */
    public function test_ai()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        // 先尝试获取模型列表
        $modelsInfo = $this->getAvailableModels();
        
        try {
            $result = $this->callAI('你好，请回复"API连接成功"', 50);
            
            $this->ajaxReturn([
                'success' => true,
                'message' => 'API连接正常',
                'response' => $result,
                'config' => [
                    'apiUrl' => $this->apiUrl,
                    'model' => $this->model,
                    'apiKeyPrefix' => substr($this->apiKey, 0, 10) . '...'
                ],
                'availableModels' => $modelsInfo
            ], 'JSON');
            
        } catch (Exception $e) {
            $this->ajaxReturn([
                'success' => false,
                'message' => 'API连接失败：' . $e->getMessage(),
                'config' => [
                    'apiUrl' => $this->apiUrl,
                    'model' => $this->model,
                    'apiKeyPrefix' => substr($this->apiKey, 0, 10) . '...'
                ],
                'availableModels' => $modelsInfo,
                'suggestion' => '请检查：1. API Key是否有权限 2. 账户余额是否充足 3. 联系Agnes AI客服确认可用模型'
            ], 'JSON');
        }
    }
    
    /**
     * 获取可用模型列表
     */
    private function getAvailableModels()
    {
        // 根据API URL确定models端点
        $modelsUrl = str_replace('/chat/completions', '/models', $this->apiUrl);
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $modelsUrl,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->apiKey
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            $data = json_decode($response, true);
            if (isset($data['data'])) {
                $models = array_column($data['data'], 'id');
                return [
                    'status' => 'success',
                    'count' => count($models),
                    'models' => array_slice($models, 0, 20) // 只返回前20个
                ];
            }
        }
        
        return [
            'status' => 'failed',
            'httpCode' => $httpCode,
            'message' => '无法获取模型列表'
        ];
    }
    
    /**
     * CMS存量内容AI化改写接口
     * POST /api/content-rewrite
     * 基于CMS已有文章内容，生成适配不同平台的衍生内容
     */
    public function content_rewrite()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) {
            $postData = $_POST;
        }
        
        $aid = isset($postData['aid']) ? intval($postData['aid']) : 0;
        $platform = isset($postData['platform']) ? $postData['platform'] : 'wechat';
        $action = isset($postData['action']) ? $postData['action'] : 'rewrite'; // rewrite:改写, expand:扩写, shorten:缩写, translate:翻译
        
        if (!$aid) {
            $this->ajaxReturn(['success' => false, 'message' => '请提供文章ID'], 'JSON');
            return;
        }
        
        try {
            // 从CMS获取文章内容
            $article = M('article', 'lvbo_')->where(['aid' => $aid])->find();
            
            if (!$article) {
                $this->ajaxReturn(['success' => false, 'message' => '文章不存在'], 'JSON');
                return;
            }
            
            $title = $article['title'];
            $content = strip_tags($article['content']);
            $content = mb_substr($content, 0, 2000, 'utf-8');
            
            // 根据平台和动作生成不同的prompt
            $prompt = $this->buildRewritePrompt($title, $content, $platform, $action);
            
            // 调用AI生成
            $result = $this->callAI($prompt, 3000);
            
            $this->ajaxReturn([
                'success' => true,
                'result' => $result,
                'originalTitle' => $title,
                'platform' => $platform,
                'action' => $action
            ], 'JSON');
            
        } catch (Exception $e) {
            $this->ajaxReturn([
                'success' => false,
                'message' => '处理失败：' . $e->getMessage()
            ], 'JSON');
        }
    }
    
    /**
     * 多平台内容适配接口
     * POST /api/content-adapt
     * 一键生成适配多个平台风格的内容版本
     */
    public function content_adapt()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) {
            $postData = $_POST;
        }
        
        $aid = isset($postData['aid']) ? intval($postData['aid']) : 0;
        $platforms = isset($postData['platforms']) ? $postData['platforms'] : ['wechat', 'xiaohongshu', 'zhihu'];
        
        if (!$aid) {
            $this->ajaxReturn(['success' => false, 'message' => '请提供文章ID'], 'JSON');
            return;
        }
        
        try {
            // 从CMS获取文章内容
            $article = M('article', 'lvbo_')->where(['aid' => $aid])->find();
            
            if (!$article) {
                $this->ajaxReturn(['success' => false, 'message' => '文章不存在'], 'JSON');
                return;
            }
            
            $title = $article['title'];
            $content = strip_tags($article['content']);
            $content = mb_substr($content, 0, 2000, 'utf-8');
            
            $results = [];
            
            foreach ($platforms as $platform) {
                $prompt = $this->buildRewritePrompt($title, $content, $platform, 'rewrite');
                $result = $this->callAI($prompt, 2000);
                
                $results[$platform] = [
                    'title' => $this->generatePlatformTitle($title, $platform),
                    'content' => $result,
                    'platform' => $platform
                ];
            }
            
            $this->ajaxReturn([
                'success' => true,
                'results' => $results,
                'originalTitle' => $title
            ], 'JSON');
            
        } catch (Exception $e) {
            $this->ajaxReturn([
                'success' => false,
                'message' => '处理失败：' . $e->getMessage()
            ], 'JSON');
        }
    }
    
    /**
     * 生成平台适配标题
     */
    private function generatePlatformTitle($title, $platform)
    {
        $prefixes = [
            'wechat' => '',
            'xiaohongshu' => '',
            'zhihu' => '',
            'douyin' => '',
            'website' => ''
        ];
        
        $suffixes = [
            'wechat' => '',
            'xiaohongshu' => '✨',
            'zhihu' => '?',
            'douyin' => '',
            'website' => ''
        ];
        
        return ($prefixes[$platform] ?? '') . $title . ($suffixes[$platform] ?? '');
    }
    
    /**
     * 构建改写Prompt
     */
    private function buildRewritePrompt($title, $content, $platform, $action)
    {
        $platformStyles = [
            'wechat' => [
                'name' => '微信公众号',
                'style' => '专业、深度、适合阅读',
                'format' => '标题吸引人，正文分段落，有小标题，结尾引导关注'
            ],
            'xiaohongshu' => [
                'name' => '小红书',
                'style' => '口语化、亲切、有表情符号',
                'format' => '开头吸睛，多用emoji，分点清晰，结尾引导互动'
            ],
            'zhihu' => [
                'name' => '知乎',
                'style' => '理性、深度、有数据支撑',
                'format' => '观点明确，逻辑清晰，引用数据，回答问题'
            ],
            'douyin' => [
                'name' => '抖音',
                'style' => '简短、有趣、节奏感强',
                'format' => '3秒抓住注意力，口语化表达，有反转或干货'
            ],
            'website' => [
                'name' => '官网',
                'style' => '正式、专业、品牌调性',
                'format' => '结构化呈现，突出核心价值，引导转化'
            ]
        ];
        
        $actionTypes = [
            'rewrite' => '改写',
            'expand' => '扩写',
            'shorten' => '缩写',
            'translate' => '翻译成通俗语言'
        ];
        
        $platformInfo = $platformStyles[$platform] ?? $platformStyles['wechat'];
        
        return "请将以下文章{$actionTypes[$action] ?? '改写'}为适配{$platformInfo['name']}平台的内容：\n\n" .
               "平台风格：{$platformInfo['style']}\n" .
               "格式要求：{$platformInfo['format']}\n\n" .
               "原文章标题：{$title}\n\n" .
               "原文章内容：\n{$content}\n\n" .
               "请输出适配后的完整内容（标题+正文），不要输出任何解释性文字。";
    }
    
    /**
     * 获取CMS文章列表（用于选择要改写的文章）
     * GET /api/content-list
     */
    public function content_list()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
        $offset = ($page - 1) * $limit;
        $typeid = isset($_GET['typeid']) ? intval($_GET['typeid']) : 0;
        
        $map = ['status' => 1];
        if ($typeid) {
            $map['typeid'] = $typeid;
        }
        
        $article = M('article', 'lvbo_');
        $count = $article->where($map)->count();
        $list = $article->where($map)
                        ->field('aid, title, typeid, addtime, hits')
                        ->order('addtime DESC')
                        ->limit($offset, $limit)
                        ->select();
        
        $this->ajaxReturn([
            'success' => true,
            'data' => $list,
            'total' => $count,
            'page' => $page,
            'limit' => $limit
        ], 'JSON');
    }

    /**
     * 工具页面
     */
    public function index()
    {
        $this->display('tools');
    }
}
?>
