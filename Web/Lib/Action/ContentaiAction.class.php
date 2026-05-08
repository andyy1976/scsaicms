<?php
/**
 * 内容管家后台控制器
 * 提供内容质量分析、批量处理等功能
 */

class ContentaiAction extends Action {
    
    private $content_gateway = 'http://localhost:5002';
    
    function _initialize() {
        parent::_initialize();
        $this->content_gateway = C('OPENCLAW_CONTENT_GATEWAY_URL') ?: 'http://localhost:5002';
        
        // 检查管理员权限
        if (!isset($_SESSION['admin_id'])) {
            $this->error('请先登录', U('Public/login'));
        }
    }
    
    /**
     * 内容质量仪表板
     */
    public function index() {
        // 获取统计数据
        $total_articles = M('article')->count();
        $no_keywords = M('article')->where("keywords = '' OR keywords IS NULL")->count();
        $no_description = M('article')->where("description = '' OR description IS NULL")->count();
        $no_content = M('article')->where("content = '' OR content IS NULL")->count();
        
        $this->assign('stats', [
            'total' => $total_articles,
            'no_keywords' => $no_keywords,
            'no_description' => $no_description,
            'no_content' => $no_content,
            'quality_rate' => round(($total_articles - $no_keywords - $no_description) / max(1, $total_articles) * 100, 1)
        ]);
        
        // 获取待优化文章
        $pending = M('article')
            ->where("(keywords = '' OR keywords IS NULL OR description = '' OR description IS NULL) AND status = 1")
            ->order('addtime desc')
            ->limit(20)
            ->select();
        
        $this->assign('pending', $pending);
        
        $this->display();
    }
    
    /**
     * 文章质量评分
     */
    public function score() {
        $aid = intval(I('aid'));
        
        if (!$aid) {
            $this->ajaxReturn(['success' => false, 'error' => 'MISSING_AID']);
            return;
        }
        
        $article = M('article')->where(['aid' => $aid])->find();
        if (!$article) {
            $this->ajaxReturn(['success' => false, 'error' => 'ARTICLE_NOT_FOUND']);
            return;
        }
        
        // 调用龙虾评分
        $result = $this->callLobster('/api/v1/lobster/content_steward/score', [
            'title' => $article['title'],
            'content' => $article['content'],
            'keywords' => $article['keywords'],
            'description' => $article['description']
        ]);
        
        $this->ajaxReturn($result);
    }
    
    /**
     * 生成摘要
     */
    public function generate_summary() {
        $aid = intval(I('aid'));
        
        if (!$aid) {
            $this->ajaxReturn(['success' => false, 'error' => 'MISSING_AID']);
            return;
        }
        
        $article = M('article')->where(['aid' => $aid])->find();
        if (!$article) {
            $this->ajaxReturn(['success' => false, 'error' => 'ARTICLE_NOT_FOUND']);
            return;
        }
        
        $result = $this->callLobster('/api/v1/lobster/content_steward/summary', [
            'content' => $article['content'],
            'max_length' => 200
        ]);
        
        if ($result['success']) {
            // 自动更新
            M('article')->where(['aid' => $aid])->save([
                'description' => $result['summary']
            ]);
        }
        
        $this->ajaxReturn($result);
    }
    
    /**
     * 生成关键词
     */
    public function generate_keywords() {
        $aid = intval(I('aid'));
        
        if (!$aid) {
            $this->ajaxReturn(['success' => false, 'error' => 'MISSING_AID']);
            return;
        }
        
        $article = M('article')->where(['aid' => $aid])->find();
        if (!$article) {
            $this->ajaxReturn(['success' => false, 'error' => 'ARTICLE_NOT_FOUND']);
            return;
        }
        
        $result = $this->callLobster('/api/v1/lobster/content_steward/keywords', [
            'title' => $article['title'],
            'content' => $article['content'],
            'count' => 5
        ]);
        
        if ($result['success']) {
            // 自动更新
            M('article')->where(['aid' => $aid])->save([
                'keywords' => implode(',', $result['keywords'])
            ]);
        }
        
        $this->ajaxReturn($result);
    }
    
    /**
     * 完整分析
     */
    public function analyze() {
        $aid = intval(I('aid'));
        
        if (!$aid) {
            $this->ajaxReturn(['success' => false, 'error' => 'MISSING_AID']);
            return;
        }
        
        $article = M('article')->where(['aid' => $aid])->find();
        if (!$article) {
            $this->ajaxReturn(['success' => false, 'error' => 'ARTICLE_NOT_FOUND']);
            return;
        }
        
        $result = $this->callLobster('/api/v1/lobster/content_steward/analyze', [
            'aid' => $article['aid'],
            'title' => $article['title'],
            'content' => $article['content'],
            'keywords' => $article['keywords'],
            'description' => $article['description']
        ]);
        
        $this->ajaxReturn($result);
    }
    
    /**
     * SEO优化建议
     */
    public function seo() {
        $aid = intval(I('aid'));
        
        if (!$aid) {
            $this->ajaxReturn(['success' => false, 'error' => 'MISSING_AID']);
            return;
        }
        
        $article = M('article')->where(['aid' => $aid])->find();
        if (!$article) {
            $this->ajaxReturn(['success' => false, 'error' => 'ARTICLE_NOT_FOUND']);
            return;
        }
        
        $result = $this->callLobster('/api/v1/lobster/content_steward/seo', $article);
        
        $this->ajaxReturn($result);
    }
    
    /**
     * 批量优化
     */
    public function batch_optimize() {
        set_time_limit(300);
        
        $type = I('type', 'all'); // all, keywords, description
        
        // 获取待处理文章
        $where = ['status' => 1];
        
        if ($type == 'keywords') {
            $where['keywords'] = ['exp', "IS NULL OR = ''"];
        } elseif ($type == 'description') {
            $where['description'] = ['exp', "IS NULL OR = ''"];
        } else {
            $where['_string'] = "(keywords IS NULL OR keywords = '') OR (description IS NULL OR description = '')";
        }
        
        $articles = M('article')->where($where)->limit(50)->select();
        
        if (empty($articles)) {
            $this->ajaxReturn(['success' => true, 'message' => '没有待处理的文章', 'processed' => 0]);
            return;
        }
        
        // 批量处理
        $result = $this->callLobster('/api/v1/lobster/content_steward/batch', [
            'articles' => $articles
        ]);
        
        // 更新数据库
        if ($result['success']) {
            foreach ($result['results'] as $item) {
                if ($item['success']) {
                    $update = [];
                    if (!empty($item['generated_description'])) {
                        $update['description'] = $item['generated_description'];
                    }
                    if (!empty($item['generated_keywords'])) {
                        $update['keywords'] = $item['generated_keywords'];
                    }
                    if (!empty($update)) {
                        M('article')->where(['aid' => $item['aid']])->save($update);
                    }
                }
            }
        }
        
        $this->ajaxReturn([
            'success' => true,
            'processed' => count($articles),
            'details' => $result
        ]);
    }
    
    /**
     * 调用龙虾服务
     */
    private function callLobster($endpoint, $data) {
        $url = $this->content_gateway . $endpoint;
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code != 200) {
            return ['success' => false, 'error' => 'LOBSTER_ERROR', 'http_code' => $http_code];
        }
        
        return json_decode($response, true);
    }
}
