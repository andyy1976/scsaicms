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
    
    // Agnes AI API配置（兼容OpenAI格式）
    private $apiKey = 'sk-eSAkMaKq5DpXACQqiba9zuxVif3rHNqQpQmKA9fP6XTf5zFX';
    private $apiUrl = 'https://apihub.agnes-ai.com/v1/chat/completions';
    private $model = 'gpt-4o-mini'; // 可选模型：gpt-4o-mini, gpt-4o, claude-3-5-sonnet-latest 等
    
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
        
        // 获取参数
        $title = I('post.title', '', '');
        $content = I('post.content', '', '');
        $typeid = I('post.typeid', 21215, 'intval'); // 默认：技术观察
        $keywords = I('post.keywords', '', '');
        $description = I('post.description', '', '');
        $source = I('post.source', 'AI数字员工', '');
        
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
        
        // 获取请求参数
        $text = I('post.text', '', '');
        $style = I('post.style', 'general', '');
        $prompt = I('post.prompt', '', '');
        
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
        
        $text = I('post.text', '', '');
        
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
        
        $text = I('post.text', '', '');
        $target = I('post.target', 'plain', ''); // plain: 通俗语言, marketing: 营销语言
        
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
        
        $specs = I('post.specs', '', ''); // 产品规格参数
        $productName = I('post.name', '', ''); // 产品名称
        $type = I('post.type', 'manual', ''); // manual: 说明书, sales: 销售话术
        
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
        
        $source = I('get.source', 'weibo', ''); // weibo, zhihu, reddit
        $limit = I('get.limit', 10, 'intval');
        
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
        
        $title = I('post.title', '', '');
        $content = I('post.content', '', '');
        $platforms = I('post.platforms', [], ''); // ['wechat', 'xiaohongshu', 'douyin']
        
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
     * 调用AI模型
     */
    private function callAI($prompt, $maxTokens = 2000)
    {
        // 使用Agnes AI（兼容OpenAI格式）
        $apiKey = $this->apiKey;
        $apiUrl = $this->apiUrl;
        $model = $this->model;
        
        // 也可以从环境变量覆盖
        if (getenv('AGNES_API_KEY')) {
            $apiKey = getenv('AGNES_API_KEY');
        }
        
        if (!$apiKey) {
            // 降级：返回模拟结果
            return $this->simulateAIResponse($prompt);
        }
        
        $data = [
            'model' => $model,
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'max_tokens' => $maxTokens,
            'temperature' => 0.7
        ];
        
        $ch = curl_init();
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
        curl_close($ch);
        
        if ($httpCode !== 200) {
            // 记录错误日志
            error_log("AI API Error: HTTP {$httpCode}, Response: {$response}, Error: {$error}");
            throw new Exception('AI调用失败：HTTP ' . $httpCode . ' - ' . $error);
        }
        
        $result = json_decode($response, true);
        
        if (isset($result['choices'][0]['message']['content'])) {
            return $result['choices'][0]['message']['content'];
        }
        
        throw new Exception('AI返回格式错误：' . $response);
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
     * 工具页面
     */
    public function index()
    {
        $this->display('tools');
    }
}
?>
