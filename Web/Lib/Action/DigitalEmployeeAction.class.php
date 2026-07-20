<?php
/**
 * 数字员工工作台控制器
 * 统一架构：CMS(PHP:80) → workbuddy(Node:3456)
 */

class DigitalEmployeeAction extends Action {

    private $db;
    private $nodeServiceUrl = 'http://localhost:3456';

    public function __construct() {
        parent::__construct();
        $this->db = M('article');
    }

    public function index() {
        $this->display();
    }

    /**
     * 调用Node.js服务
     */
    private function callNode($endpoint, $data = [], $method = 'GET') {
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
        curl_close($ch);
        return json_decode($response, true);
    }

    /**
     * 获取CMS文章列表
     */
    public function cmsArticles() {
        $typeid = I('typeid', 0, 'intval');
        $page = I('page', 1, 'intval');
        $pageSize = I('pageSize', 20, 'intval');

        // 优先通过Node.js服务
        $query = "/api/cms/articles?page={$page}&pageSize={$pageSize}";
        if ($typeid > 0) { $query .= "&categoryId={$typeid}"; }
        $nodeResult = $this->callNode($query);
        if (isset($nodeResult['success']) && $nodeResult['success'] && isset($nodeResult['data'])) {
            $this->ajaxReturn([
                'code' => 1,
                'data' => $nodeResult['data'],
                'count' => $nodeResult['total'] ?? 0,
                'page' => $page,
                'pageSize' => $pageSize
            ]);
            return;
        }

        // 降级：直接查数据库
        $where = array('status' => 1);
        if ($typeid > 0) {
            $where['typeid'] = $typeid;
        }

        $articles = $this->db->where($where)
            ->field('aid as id, title, description, typeid, addtime, hits')
            ->order('addtime desc')
            ->page($page, $pageSize)
            ->select();

        $count = $this->db->where($where)->count();

        $this->ajaxReturn(array(
            'code' => 1,
            'data' => $articles,
            'count' => $count,
            'page' => $page,
            'pageSize' => $pageSize
        ));
    }

    /**
     * 获取CMS文章详情
     */
    public function getCmsArticle() {
        $id = I('id', 0, 'intval');

        if (!$id) {
            $this->ajaxReturn(array('code' => 0, 'msg' => '缺少文章ID'));
        }

        $article = $this->db->where(array('aid' => $id))->find();

        if (!$article) {
            $this->ajaxReturn(array('code' => 0, 'msg' => '文章不存在'));
        }

        $this->ajaxReturn(array(
            'code' => 1,
            'data' => array(
                'id' => $article['aid'],
                'title' => $article['title'],
                'content' => $article['content'],
                'description' => $article['description'],
                'keywords' => $article['keywords'],
                'typeid' => $article['typeid'],
                'author' => $article['author'],
                'addtime' => $article['addtime'],
                'hits' => $article['hits']
            )
        ));
    }

    /**
     * 执行CMS存量改写 - 通过Node.js服务
     */
    public function doCmsRewrite() {
        $articleId = I('articleId', 0, 'intval');
        $action = I('action', 'adapt');
        $platform = I('platform', 'wechat');

        if (!$articleId) {
            $this->ajaxReturn(array('code' => 0, 'msg' => '缺少文章ID'));
        }

        $article = $this->db->where(array('aid' => $articleId))->find();
        if (!$article) {
            $this->ajaxReturn(array('code' => 0, 'msg' => '文章不存在'));
        }

        $title = $article['title'];
        $content = strip_tags($article['content']);
        $content = mb_substr($content, 0, 2000, 'utf-8');

        // 通过Node.js服务生成
        $result = $this->callNode('/api/content/generate', [
            'topic' => $title,
            'context' => $content,
            'style' => $action === 'shorten' ? 'concise' : 'professional',
            'platform' => $platform,
            'wordCount' => 2000
        ], 'POST');

        if (isset($result['success']) && $result['success']) {
            $this->ajaxReturn(array(
                'code' => 1,
                'msg' => '改写完成(通过Node.js服务)',
                'content' => $result['data']['content'] ?? $content
            ));
            return;
        }

        // 降级：尝试去AI味接口
        $deaiResult = $this->callNode('/api/content/deaiify', [
            'content' => $content,
            'intensity' => 'medium'
        ], 'POST');

        if (isset($deaiResult['success']) && $deaiResult['success']) {
            $this->ajaxReturn(array(
                'code' => 1,
                'msg' => '改写完成(去AI味)',
                'content' => $deaiResult['data']['optimized'] ?? $content
            ));
            return;
        }

        $this->ajaxReturn(array('code' => 0, 'msg' => '改写服务暂时不可用'));
    }

    /**
     * 调用AI改写服务
     */
    private function callAIRewrite($content, $action, $platform) {
        // 获取AI配置
        $aiConfig = $this->getAIConfig();

        $prompt = "请将以下内容进行AI风格改写，使其更加流畅自然，符合真人写作风格。\n\n原始内容：\n" . $content;

        if ($platform === 'xiaohongshu') {
            $prompt = "请将以下内容改写为小红书风格，使用emoji、段落符号等，增加互动性。\n\n原始内容：\n" . $content;
        } elseif ($platform === 'wechat') {
            $prompt = "请将以下内容改写为微信公众号风格，语言正式但不生硬，适合朋友圈传播。\n\n原始内容：\n" . $content;
        }

        $data = array(
            'model' => $aiConfig['model'],
            'messages' => array(
                array('role' => 'user', 'content' => $prompt)
            ),
            'temperature' => 0.7
        );

        try {
            $response = $this->httpPost($aiConfig['api_url'], $data, array(
                'Authorization: Bearer ' . $aiConfig['api_key'],
                'Content-Type: application/json'
            ));

            $result = json_decode($response, true);
            return $result['choices'][0]['message']['content'] ?? $content;
        } catch (Exception $e) {
            return $content; // 失败时返回原始内容
        }
    }

    /**
     * 获取AI配置
     */
    private function getAIConfig() {
        // 默认配置
        $config = array(
            'api_url' => 'https://api.astron.site/v1/chat/completions',
            'api_key' => C('AI_API_KEY') ?: 'sk-default',
            'model' => 'astron-code-latest'
        );

        // 从配置文件读取
        $configFile = CONF_PATH . 'ai-providers.json';
        if (file_exists($configFile)) {
            $providers = json_decode(file_get_contents($configFile), true);
            if (isset($providers[0])) {
                $config['api_url'] = $providers[0]['api_url'] ?? $config['api_url'];
                $config['api_key'] = $providers[0]['api_key'] ?? $config['api_key'];
                $config['model'] = $providers[0]['model'] ?? $config['model'];
            }
        }

        return $config;
    }

    /**
     * 发布改写后的内容到CMS
     */
    public function publishToCms() {
        $content = I('content', '', 'htmlspecialchars');
        $title = I('title', 'AI改写-' . date('Y-m-d H:i:s'));
        $typeid = I('typeid', 0, 'intval');
        $originalId = I('originalId', 0, 'intval');

        if (empty($content)) {
            $this->ajaxReturn(array('code' => 0, 'msg' => '内容不能为空'));
        }

        $data = array(
            'title' => $title,
            'content' => $content,
            'typeid' => $typeid ?: 21215, // 默认技术观察
            'status' => 1,
            'addtime' => time(),
            'is_ai_generated' => 1
        );

        if ($originalId > 0) {
            // 更新原文章
            $result = $this->db->where(array('aid' => $originalId))->save($data);
        } else {
            // 创建新文章
            $result = $this->db->add($data);
        }

        if ($result !== false) {
            $this->ajaxReturn(array('code' => 1, 'msg' => '发布成功', 'id' => $result));
        } else {
            $this->ajaxReturn(array('code' => 0, 'msg' => '发布失败'));
        }
    }

    /**
     * 获取CMS栏目列表
     */
    public function getCategories() {
        $Category = M('type');
        $categories = $Category->where(array('ismenu' => 1))
            ->field('typeid as id, typename as name, fid')
            ->order('typeid asc')
            ->select();

        $this->ajaxReturn(array(
            'code' => 1,
            'data' => $categories
        ));
    }

    /**
     * 获取阅读反馈数据
     */
    public function getReadFeedback() {
        $articleId = I('articleId', 0, 'intval');
        $ReadFeedback = M('read_feedback');

        $where = array();
        if ($articleId > 0) {
            $where['article_id'] = $articleId;
        }

        $feedback = $ReadFeedback->where($where)
            ->order('addtime desc')
            ->limit(100)
            ->select();

        $this->ajaxReturn(array(
            'code' => 1,
            'data' => $feedback
        ));
    }

    /**
     * 保存阅读反馈
     */
    public function saveReadFeedback() {
        $data = array(
            'article_id' => I('articleId', 0, 'intval'),
            'user_id' => cookie('user_id') ?: 0,
            'depth' => I('depth', 0, 'floatval'),
            'duration' => I('duration', 0, 'intval'),
            'likes' => I('likes', 0, 'intval'),
            'shares' => I('shares', 0, 'intval'),
            'addtime' => time()
        );

        $ReadFeedback = M('read_feedback');
        $result = $ReadFeedback->add($data);

        if ($result) {
            $this->ajaxReturn(array('code' => 1, 'msg' => '反馈已记录'));
        } else {
            $this->ajaxReturn(array('code' => 0, 'msg' => '保存失败'));
        }
    }

    /**
     * HTTP POST请求
     */
    private function httpPost($url, $data, $headers = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * 数据共享接口 - 供独立工具版调用
     * 获取指定条件的内容数据
     */
    public function getContentForWorker() {
        $type = I('type', 'articles');
        $limit = I('limit', 10, 'intval');
        $categoryId = I('categoryId', 0, 'intval');

        $result = array();

        if ($type === 'articles') {
            $where = array('status' => 1);
            if ($categoryId > 0) {
                $where['typeid'] = $categoryId;
            }

            $result = $this->db->where($where)
                ->field('aid as id, title, description, content, typeid, addtime')
                ->order('addtime desc')
                ->limit($limit)
                ->select();
        }

        $this->ajaxReturn(array(
            'code' => 1,
            'data' => $result,
            'type' => $type
        ));
    }

    /**
     * 数据共享接口 - 接收独立工具版处理的内容
     */
    public function receiveFromWorker() {
        $content = I('content', '', 'htmlspecialchars_decode');
        $title = I('title', '');
        $source = I('source', 'content-worker');
        $originalId = I('originalId', 0, 'intval');
        $typeid = I('typeid', 0, 'intval');
        $action = I('action', 'new'); // new: 新建, update: 更新, rewrite: 改写

        if (empty($content)) {
            $this->ajaxReturn(array('code' => 0, 'msg' => '内容不能为空'));
        }

        $data = array(
            'title' => $title ?: 'AI处理-' . date('Y-m-d H:i:s'),
            'content' => $content,
            'typeid' => $typeid ?: 21215,
            'status' => 1,
            'addtime' => time(),
            'is_ai_generated' => 1,
            'source' => $source
        );

        // 如果是改写原文章
        if ($action === 'update' && $originalId > 0) {
            $result = $this->db->where(array('aid' => $originalId))->save($data);
            $id = $originalId;
        } else {
            $id = $this->db->add($data);
            $result = $id > 0;
        }

        if ($result !== false) {
            $this->ajaxReturn(array(
                'code' => 1,
                'msg' => '接收成功',
                'id' => $id,
                'action' => $action
            ));
        } else {
            $this->ajaxReturn(array('code' => 0, 'msg' => '保存失败'));
        }
    }

    /**
     * 获取统计数据
     */
    public function getStats() {
        // 文章总数
        $totalArticles = $this->db->where(array('status' => 1))->count();

        // AI生成的文章数
        $aiArticles = $this->db->where(array('status' => 1, 'is_ai_generated' => 1))->count();

        // 阅读反馈数
        $ReadFeedback = M('read_feedback');
        $totalFeedback = $ReadFeedback->count();

        $this->ajaxReturn(array(
            'code' => 1,
            'data' => array(
                'totalArticles' => $totalArticles,
                'aiArticles' => $aiArticles,
                'totalFeedback' => $totalFeedback,
                'date' => date('Y-m-d')
            )
        ));
    }
}
