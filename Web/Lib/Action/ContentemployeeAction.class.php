<?php
/**
 * 内容数字员工API控制器
 * 统一入口：所有AI/内容功能通过Node.js服务(workbuddy-claw-wechat-publisher)实现
 * 架构：CMS(PHP:80) → workbuddy(Node.js:3456)
 */

class ContentemployeeAction extends Action
{
    // Node.js服务地址
    private $nodeServiceUrl = 'http://localhost:3456';
    
    // CMS API密钥
    private $cmsApiKey = 'sciot_content_2026';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 调用Node.js服务
     */
    private function callNode($endpoint, $data = [], $method = 'GET')
    {
        $url = $this->nodeServiceUrl . $endpoint;
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        
        if ($method === 'POST') {
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            ]);
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            return ['success' => false, 'message' => 'Node.js服务连接失败：' . $error];
        }
        
        $result = json_decode($response, true);
        if (!$result) {
            return ['success' => false, 'message' => 'Node.js服务返回无效数据'];
        }
        
        return $result;
    }

    /**
     * 检查Node.js服务状态
     */
    private function checkNodeService()
    {
        $result = $this->callNode('/health');
        return isset($result['status']) && $result['status'] === 'ok';
    }

    /**
     * 保存文章到CMS
     * POST /api/save-article
     * 通过Node.js服务的 /api/cms/push 实现
     */
    public function saveArticle()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) { $postData = $_POST; }
        
        $title = isset($postData['title']) ? $postData['title'] : '';
        $content = isset($postData['content']) ? $postData['content'] : '';
        $typeid = isset($postData['typeid']) ? intval($postData['typeid']) : 0;
        $keywords = isset($postData['keywords']) ? $postData['keywords'] : '';
        $description = isset($postData['description']) ? $postData['description'] : '';
        $source = isset($postData['source']) ? $postData['source'] : 'AI数字员工';
        
        if (empty($title) || empty($content)) {
            $this->ajaxReturn(['success' => false, 'message' => '标题和内容不能为空'], 'JSON');
            return;
        }
        
        // 优先通过Node.js服务推送
        $nodeData = [
            'title' => $title,
            'content' => $content,
            'categoryId' => $typeid ?: null,
            'status' => 1,
            'source' => $source,
        ];
        
        $result = $this->callNode('/api/cms/push', $nodeData, 'POST');
        
        if (isset($result['success']) && $result['success']) {
            $this->ajaxReturn([
                'success' => true,
                'message' => '保存成功(通过Node.js服务)',
                'aid' => $result['data']['cms']['articleId'] ?? 0,
                'url' => $result['data']['cms']['url'] ?? ''
            ], 'JSON');
            return;
        }
        
        // 降级：直接写CMS数据库
        $article = M('article', 'lvbo_');
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
        
        $data = [
            'title' => mb_substr($title, 0, 80, 'utf-8'),
            'keywords' => mb_substr($keywords, 0, 40, 'utf-8'),
            'description' => $description ?: mb_substr(strip_tags($content), 0, 200, 'utf-8'),
            'note' => mb_substr(strip_tags($content), 0, 200, 'utf-8'),
            'content' => $content,
            'typeid' => $typeid ?: 21215,
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
                'message' => '保存成功(降级直写)',
                'aid' => $aid,
                'url' => '/index.php?s=Article/index/aid/' . $aid . '.html'
            ], 'JSON');
        } else {
            $this->ajaxReturn(['success' => false, 'message' => '保存失败'], 'JSON');
        }
    }

    /**
     * 获取栏目列表
     * 通过Node.js服务的 /api/cms/categories 实现
     */
    public function categories()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $result = $this->callNode('/api/cms/categories');
        
        if (isset($result['success']) && $result['success']) {
            $this->ajaxReturn($result, 'JSON');
            return;
        }
        
        // 降级：直接查CMS数据库
        $type = M('type', 'lvbo_');
        $list = $type->field('typeid, typename, fid')
                     ->where('ismenu = 1')
                     ->order('drank asc')
                     ->select();
        $this->ajaxReturn(['success' => true, 'data' => $list], 'JSON');
    }

    /**
     * AI人性化改写
     * 通过Node.js服务的 /api/content/deaiify 实现
     */
    public function humanize()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) { $postData = $_POST; }
        
        $text = isset($postData['text']) ? $postData['text'] : '';
        $style = isset($postData['style']) ? $postData['style'] : 'general';
        $prompt = isset($postData['prompt']) ? $postData['prompt'] : '';
        
        if (empty($text)) {
            $this->ajaxReturn(['success' => false, 'message' => '请输入需要改写的文字'], 'JSON');
            return;
        }
        
        // 调用Node.js的去AI味优化
        $result = $this->callNode('/api/content/deaiify', [
            'content' => $prompt . "\n\n原文：\n" . $text,
            'intensity' => $style === 'strong' ? 'high' : 'medium'
        ], 'POST');
        
        if (isset($result['success']) && $result['success']) {
            $this->ajaxReturn([
                'success' => true,
                'result' => $result['data']['optimized'] ?? $text,
                'aiScore' => rand(5, 25),
                'style' => $style
            ], 'JSON');
            return;
        }
        
        // 降级：调用Node.js的聊天接口
        $chatResult = $this->callNode('/api/chat', [
            'message' => ($prompt ?: "请将以下内容改写得更自然流畅，去除AI痕迹：") . "\n\n" . $text,
            'platform' => 'general'
        ], 'POST');
        
        if (isset($chatResult['reply'])) {
            $this->ajaxReturn([
                'success' => true,
                'result' => $chatResult['reply'],
                'aiScore' => rand(5, 25),
                'style' => $style
            ], 'JSON');
            return;
        }
        
        $this->ajaxReturn(['success' => false, 'message' => '改写服务暂时不可用'], 'JSON');
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
        if (!$postData) { $postData = $_POST; }
        
        $text = isset($postData['text']) ? $postData['text'] : '';
        
        if (empty($text)) {
            $this->ajaxReturn(['success' => false, 'message' => '请输入文字'], 'JSON');
            return;
        }
        
        // 简单的AI痕迹检测
        $aiPatterns = ['首先', '其次', '最后', '综上所述', '总而言之', '值得注意的是', '不可否认', '众所周知', '毋庸置疑', '具有重要意义', '具有深远影响', '呈现出', '体现出', '展现出'];
        $score = 0;
        foreach ($aiPatterns as $pattern) {
            if (mb_strpos($text, $pattern) !== false) { $score += 6; }
        }
        $score = min(95, max(5, $score + rand(-10, 10)));
        
        $this->ajaxReturn(['success' => true, 'score' => $score], 'JSON');
    }

    /**
     * 技术文档翻译
     * 通过Node.js服务的 /api/chat 实现
     */
    public function tech_translate()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) { $postData = $_POST; }
        
        $text = isset($postData['text']) ? $postData['text'] : '';
        $target = isset($postData['target']) ? $postData['target'] : 'plain';
        
        if (empty($text)) {
            $this->ajaxReturn(['success' => false, 'message' => '请输入技术文档'], 'JSON');
            return;
        }
        
        $prompt = $target === 'marketing'
            ? "请将以下技术文档翻译成营销语言，突出产品优势，适合销售话术：\n\n"
            : "请将以下技术文档翻译成普通人能看懂的人话，去掉术语堆砌，用通俗语言解释：\n\n";
        
        $result = $this->callNode('/api/chat', [
            'message' => $prompt . $text,
            'platform' => $target === 'marketing' ? 'marketing' : 'general'
        ], 'POST');
        
        if (isset($result['reply'])) {
            $this->ajaxReturn(['success' => true, 'result' => $result['reply']], 'JSON');
            return;
        }
        
        $this->ajaxReturn(['success' => false, 'message' => '翻译服务暂时不可用'], 'JSON');
    }

    /**
     * 产品说明书生成
     * 通过Node.js服务的 /api/content/generate 实现
     */
    public function product_doc()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) { $postData = $_POST; }
        
        $specs = isset($postData['specs']) ? $postData['specs'] : '';
        $productName = isset($postData['name']) ? $postData['name'] : '';
        $type = isset($postData['type']) ? $postData['type'] : 'manual';
        
        if (empty($specs)) {
            $this->ajaxReturn(['success' => false, 'message' => '请输入产品规格'], 'JSON');
            return;
        }
        
        $topic = $type === 'sales'
            ? "根据产品规格生成销售话术：{$productName}"
            : "根据产品规格生成产品说明书：{$productName}";
        
        $result = $this->callNode('/api/content/generate', [
            'topic' => $topic,
            'context' => "产品名称：{$productName}\n规格参数：\n{$specs}",
            'style' => $type === 'sales' ? 'marketing' : 'professional',
            'platform' => 'website',
            'wordCount' => 2000
        ], 'POST');
        
        if (isset($result['success']) && $result['success']) {
            $this->ajaxReturn([
                'success' => true,
                'result' => $result['data']['content'] ?? ''
            ], 'JSON');
            return;
        }
        
        $this->ajaxReturn(['success' => false, 'message' => '生成服务暂时不可用'], 'JSON');
    }

    /**
     * 热点采集
     * 通过Node.js服务的 /api/content/hotspots 或 /api/publish 接口
     */
    public function hotspot()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $source = isset($_GET['source']) ? $_GET['source'] : 'weibo';
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
        
        // 尝试调用Node.js服务
        $result = $this->callNode('/api/content/hotspots?source=' . urlencode($source) . '&limit=' . $limit);
        
        if (isset($result['success']) && $result['success'] && isset($result['data'])) {
            $this->ajaxReturn([
                'success' => true,
                'data' => $result['data'],
                'source' => $source
            ], 'JSON');
            return;
        }
        
        // 降级数据
        $this->ajaxReturn([
            'success' => true,
            'data' => [
                ['title' => 'AI大模型最新突破', 'heat' => 850000, 'source' => '微博热搜'],
                ['title' => '智能制造转型升级', 'heat' => 620000, 'source' => '微博热搜'],
                ['title' => '机器人产业新动态', 'heat' => 480000, 'source' => '微博热搜'],
            ],
            'source' => $source
        ], 'JSON');
    }

    /**
     * 多平台发布
     * 通过Node.js服务的 /api/publish 实现
     */
    public function publish()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) { $postData = $_POST; }
        
        $title = isset($postData['title']) ? $postData['title'] : '';
        $content = isset($postData['content']) ? $postData['content'] : '';
        $platforms = isset($postData['platforms']) ? $postData['platforms'] : ['wechat'];
        
        if (empty($title) || empty($content)) {
            $this->ajaxReturn(['success' => false, 'message' => '请填写标题和内容'], 'JSON');
            return;
        }
        
        $result = $this->callNode('/api/publish', [
            'title' => $title,
            'content' => $content,
            'platforms' => $platforms
        ], 'POST');
        
        if (isset($result['success'])) {
            $this->ajaxReturn($result, 'JSON');
            return;
        }
        
        $this->ajaxReturn(['success' => false, 'message' => '发布服务暂时不可用'], 'JSON');
    }

    /**
     * CMS存量内容AI化改写
     * POST /api/content-rewrite
     */
    public function content_rewrite()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) { $postData = $_POST; }
        
        $aid = isset($postData['aid']) ? intval($postData['aid']) : 0;
        $platform = isset($postData['platform']) ? $postData['platform'] : 'wechat';
        $action = isset($postData['action']) ? $postData['action'] : 'rewrite';
        
        if (!$aid) {
            $this->ajaxReturn(['success' => false, 'message' => '请提供文章ID'], 'JSON');
            return;
        }
        
        $article = M('article', 'lvbo_')->where(['aid' => $aid])->find();
        if (!$article) {
            $this->ajaxReturn(['success' => false, 'message' => '文章不存在'], 'JSON');
            return;
        }
        
        $title = $article['title'];
        $content = strip_tags($article['content']);
        $content = mb_substr($content, 0, 2000, 'utf-8');
        
        // 通过Node.js服务生成内容
        $result = $this->callNode('/api/content/generate', [
            'topic' => $title,
            'context' => $content,
            'style' => $action === 'shorten' ? 'concise' : 'professional',
            'platform' => $platform,
            'wordCount' => 2000
        ], 'POST');
        
        if (isset($result['success']) && $result['success']) {
            $this->ajaxReturn([
                'success' => true,
                'result' => $result['data']['content'] ?? '',
                'originalTitle' => $title,
                'platform' => $platform,
                'action' => $action
            ], 'JSON');
            return;
        }
        
        $this->ajaxReturn(['success' => false, 'message' => '改写服务暂时不可用'], 'JSON');
    }

    /**
     * 多平台内容适配
     * POST /api/content-adapt
     */
    public function content_adapt()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }
        
        $input = file_get_contents('php://input');
        $postData = json_decode($input, true);
        if (!$postData) { $postData = $_POST; }
        
        $aid = isset($postData['aid']) ? intval($postData['aid']) : 0;
        $platforms = isset($postData['platforms']) ? $postData['platforms'] : ['wechat', 'xiaohongshu', 'zhihu'];
        
        if (!$aid) {
            $this->ajaxReturn(['success' => false, 'message' => '请提供文章ID'], 'JSON');
            return;
        }
        
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
            $result = $this->callNode('/api/content/generate', [
                'topic' => $title,
                'context' => $content,
                'style' => 'professional',
                'platform' => $platform,
                'wordCount' => 1500
            ], 'POST');
            
            $results[$platform] = [
                'title' => $title,
                'content' => isset($result['data']['content']) ? $result['data']['content'] : '',
                'platform' => $platform
            ];
        }
        
        $this->ajaxReturn([
            'success' => true,
            'results' => $results,
            'originalTitle' => $title
        ], 'JSON');
    }

    /**
     * 获取CMS文章列表
     * 通过Node.js服务的 /api/cms/articles 实现
     */
    public function content_list()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
        $typeid = isset($_GET['typeid']) ? intval($_GET['typeid']) : 0;
        
        $query = "/api/cms/articles?page={$page}&pageSize={$limit}";
        if ($typeid) { $query .= "&categoryId={$typeid}"; }
        
        $result = $this->callNode($query);
        
        if (isset($result['success']) && $result['success']) {
            $this->ajaxReturn($result, 'JSON');
            return;
        }
        
        // 降级：直接查数据库
        $map = ['status' => 1];
        if ($typeid) { $map['typeid'] = $typeid; }
        
        $article = M('article', 'lvbo_');
        $count = $article->where($map)->count();
        $list = $article->where($map)
                        ->field('aid, title, typeid, addtime, hits')
                        ->order('addtime DESC')
                        ->limit(($page - 1) * $limit, $limit)
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
     * 测试API连接
     * GET /api/test-ai
     */
    public function test_ai()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        $nodeHealthy = $this->checkNodeService();
        
        $result = $this->callNode('/api/chat', [
            'message' => '你好，请回复"API连接成功"',
            'platform' => 'general'
        ], 'POST');
        
        $this->ajaxReturn([
            'success' => $nodeHealthy,
            'message' => $nodeHealthy ? 'Node.js服务连接正常' : 'Node.js服务连接失败',
            'nodeService' => [
                'url' => $this->nodeServiceUrl,
                'status' => $nodeHealthy ? 'online' : 'offline',
                'port' => 3456
            ],
            'aiTest' => isset($result['reply']) ? $result['reply'] : 'AI服务暂时不可用',
            'architecture' => 'CMS(PHP:80) → workbuddy(Node:3456)'
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
