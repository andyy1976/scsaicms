<?php
/**
 * SCSAI ContentOS - 内容API接口
 * 
 * 接收 Node.js 内容管线推送的文章数据，写入 CMS 数据库
 * 
 * 接口：
 * POST /index.php?s=Contentapi/push     — 推送文章
 * GET  /index.php?s=Contentapi/categories — 获取栏目列表
 * GET  /index.php?s=Contentapi/health    — 健康检查
 * POST /index.php?s=Contentapi/batch     — 批量推送
 */

class ContentapiAction extends BaseAction {
    
    // API Key 验证
    private $apiKey = 'sciot_content_2026';
    
    // 栏目自动分类映射
    private $categoryMapping = array(
        'AI' => 21216,
        '人工智能' => 12,
        '大模型' => 121,
        'LLM' => 121,
        '智能体' => 122,
        'Agent' => 122,
        '多模态' => 124,
        '智能制造' => 13,
        '工业软件' => 134,
        'PLM' => 131,
        'MES' => 132,
        'QMS' => 133,
        '机器人' => 14,
        '具身智能' => 141,
        '人形机器人' => 142,
        '数字员工' => 11,
        '内容数字员工' => 111,
        '营销' => 112,
        '技术观察' => 21215,
        '硬核' => 21217,
        '开源' => 21225,
        '通用' => 21215
    );
    
    /**
     * 初始化 - 允许跨域
     */
    private function initApi() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, X-API-Key');
        
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }
    }
    
    /**
     * 验证 API Key
     */
    private function authenticate() {
        $key = '';
        if (isset($_SERVER['HTTP_X_API_KEY'])) {
            $key = $_SERVER['HTTP_X_API_KEY'];
        } elseif (isset($_REQUEST['api_key'])) {
            $key = $_REQUEST['api_key'];
        }
        
        if ($key !== $this->apiKey) {
            $this->jsonError('Invalid API Key', 401);
        }
    }
    
    /**
     * 推送单篇文章
     * POST /index.php?s=Contentapi/push
     * 
     * Body: {
     *   "title": "文章标题",
     *   "content": "HTML内容",
     *   "typeid": 121,          // 可选，不传则自动分类
     *   "keywords": "AI,大模型",
     *   "description": "摘要",
     *   "imgurl": "/path/to/image.jpg",
     *   "copyfrom": "微博",
     *   "source_url": "https://...",
     *   "ai_score": 85.5,
     *   "ai_scores": {"novelty":90,"importance":85}
     * }
     */
    public function push() {
        $this->initApi();
        $this->authenticate();
        
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data || empty($data['title'])) {
            $this->jsonError('Missing required field: title');
        }
        
        $article = M('article', 'lvbo_');
        
        // 去重：按标题
        $exists = $article->where(array('title' => $data['title']))->find();
        if ($exists) {
            $this->jsonSuccess('Article already exists', array('aid' => $exists['aid'], 'duplicate' => true));
        }
        
        // 自动分类
        $typeid = isset($data['typeid']) ? intval($data['typeid']) : $this->autoClassify($data['title'], isset($data['description']) ? $data['description'] : '');
        if ($typeid <= 0) $typeid = 21215; // 默认：技术观察
        
        // 构建数据
        $insertData = array(
            'title'     => $this->safeStr($data['title'], 80),
            'keywords'  => $this->safeStr(isset($data['keywords']) ? $data['keywords'] : '', 40),
            'description' => isset($data['description']) ? $data['description'] : '',
            'note'      => isset($data['note']) ? $data['note'] : (isset($data['description']) ? mb_substr($data['description'], 0, 200, 'utf-8') : ''),
            'content'   => isset($data['content']) ? $data['content'] : $this->generateContent($data),
            'typeid'    => $typeid,
            'status'    => isset($data['status']) ? intval($data['status']) : 1,
            'addtime'   => isset($data['addtime']) ? $data['addtime'] : date('Y-m-d H:i:s'),
            'author'    => $this->safeStr(isset($data['author']) ? $data['author'] : 'AI数字员工', 20),
            'copyfrom'  => $this->safeStr(isset($data['copyfrom']) ? $data['copyfrom'] : '', 100),
            'imgurl'    => isset($data['imgurl']) ? $data['imgurl'] : '',
            'istop'     => isset($data['istop']) ? intval($data['istop']) : 0,
            'ishot'     => isset($data['ishot']) ? intval($data['ishot']) : 0,
            'isflash'   => isset($data['isflash']) ? intval($data['isflash']) : 0,
            'hits'      => 1,
            'source_url' => isset($data['source_url']) ? $data['source_url'] : '',
            'ai_score'  => isset($data['ai_score']) ? floatval($data['ai_score']) : 0,
            'ai_scores' => isset($data['ai_scores']) ? json_encode($data['ai_scores']) : '',
            'is_ai_generated' => isset($data['is_ai_generated']) ? intval($data['is_ai_generated']) : 1,
        );
        
        // 高分文章自动推荐
        if (!empty($insertData['ai_score']) && $insertData['ai_score'] >= 80) {
            $insertData['istop'] = 1;
            $insertData['ishot'] = 1;
        }
        
        $aid = $article->add($insertData);
        
        if ($aid) {
            $this->jsonSuccess('Article created', array('aid' => $aid, 'typeid' => $typeid));
        } else {
            $this->jsonError('Failed to create article: ' . $article->getDbError());
        }
    }
    
    /**
     * 批量推送
     * POST /index.php?s=Contentapi/batch
     */
    public function batch() {
        $this->initApi();
        $this->authenticate();
        
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data || !isset($data['items']) || !is_array($data['items'])) {
            $this->jsonError('Missing required field: items (array)');
        }
        
        $results = array();
        $article = M('article', 'lvbo_');
        
        foreach ($data['items'] as $item) {
            if (empty($item['title'])) continue;
            
            // 去重
            $exists = $article->where(array('title' => $item['title']))->find();
            if ($exists) {
                $results[] = array('title' => $item['title'], 'aid' => $exists['aid'], 'duplicate' => true);
                continue;
            }
            
            $typeid = isset($item['typeid']) ? intval($item['typeid']) : $this->autoClassify($item['title'], isset($item['description']) ? $item['description'] : '');
            if ($typeid <= 0) $typeid = 21215;
            
            $insertData = array(
                'title'     => $this->safeStr($item['title'], 80),
                'keywords'  => $this->safeStr(isset($item['keywords']) ? $item['keywords'] : '', 40),
                'description' => isset($item['description']) ? $item['description'] : '',
                'note'      => isset($item['note']) ? $item['note'] : (isset($item['description']) ? mb_substr($item['description'], 0, 200, 'utf-8') : ''),
                'content'   => isset($item['content']) ? $item['content'] : $this->generateContent($item),
                'typeid'    => $typeid,
                'status'    => 1,
                'addtime'   => date('Y-m-d H:i:s'),
                'author'    => 'AI数字员工',
                'copyfrom'  => $this->safeStr(isset($item['copyfrom']) ? $item['copyfrom'] : '', 100),
                'imgurl'    => isset($item['imgurl']) ? $item['imgurl'] : '',
                'hits'      => 1,
                'source_url' => isset($item['source_url']) ? $item['source_url'] : '',
                'ai_score'  => isset($item['ai_score']) ? floatval($item['ai_score']) : 0,
                'ai_scores' => isset($item['ai_scores']) ? json_encode($item['ai_scores']) : '',
                'is_ai_generated' => 1,
            );
            
            if (!empty($insertData['ai_score']) && $insertData['ai_score'] >= 80) {
                $insertData['istop'] = 1;
                $insertData['ishot'] = 1;
            }
            
            $aid = $article->add($insertData);
            $results[] = array(
                'title' => $item['title'], 
                'aid' => $aid, 
                'typeid' => $typeid,
                'success' => $aid > 0
            );
        }
        
        $successCount = count(array_filter($results, function($r) { return !empty($r['success']); }));
        $this->jsonSuccess("Batch processed: {$successCount}/" . count($data['items']), $results);
    }
    
    /**
     * 获取栏目列表
     * GET /index.php?s=Contentapi/categories
     */
    public function categories() {
        $this->initApi();
        $this->authenticate();
        
        $type = M('type', 'lvbo_');
        $list = $type->field('typeid, typename, typename_en, fid, path, keywords, description')
                     ->where('ismenu = 1')
                     ->order('drank asc')
                     ->select();
        
        // 构建树
        $tree = array();
        foreach ($list as $item) {
            if ($item['fid'] == 0) {
                $item['children'] = array();
                foreach ($list as $child) {
                    if ($child['fid'] == $item['typeid']) {
                        $item['children'][] = $child;
                    }
                }
                $tree[] = $item;
            }
        }
        
        $this->jsonSuccess('Categories loaded', $tree);
    }
    
    /**
     * 健康检查
     * GET /index.php?s=Contentapi/health
     */
    public function health() {
        $this->initApi();
        
        $article = M('article', 'lvbo_');
        $type = M('type', 'lvbo_');
        
        $articleCount = $article->count();
        $typeCount = $type->where('ismenu = 1')->count();
        $todayCount = $article->where("addtime >= '" . date('Y-m-d') . "'")->count();
        
        $this->jsonSuccess('SCSAI ContentOS is running', array(
            'version' => '2.0.0',
            'articles_total' => intval($articleCount),
            'categories_total' => intval($typeCount),
            'articles_today' => intval($todayCount),
            'timestamp' => date('Y-m-d H:i:s')
        ));
    }
    
    /**
     * 自动分类
     */
    private function autoClassify($title, $summary) {
        $text = $title . ' ' . $summary;
        $scores = array();
        
        foreach ($this->categoryMapping as $keyword => $typeid) {
            if (mb_stripos($text, $keyword) !== false) {
                if (!isset($scores[$typeid])) $scores[$typeid] = 0;
                $scores[$typeid] += mb_strlen($keyword);
            }
        }
        
        if (empty($scores)) return 21215; // 默认：技术观察
        
        arsort($scores);
        return key($scores);
    }
    
    /**
     * 生成默认内容（当没有提供 content 时）
     */
    private function generateContent($data) {
        $title = isset($data['title']) ? $data['title'] : '';
        $desc = isset($data['description']) ? $data['description'] : '';
        $source = isset($data['copyfrom']) ? $data['copyfrom'] : '';
        $sourceUrl = isset($data['source_url']) ? $data['source_url'] : '';
        $aiScore = isset($data['ai_score']) ? $data['ai_score'] : 0;
        $scores = isset($data['ai_scores']) ? $data['ai_scores'] : array();
        
        $html = '<h2>' . htmlspecialchars($title) . '</h2>';
        
        if ($desc) {
            $html .= '<p>' . htmlspecialchars($desc) . '</p>';
        }
        
        // AI 评分展示
        if ($aiScore > 0) {
            $html .= '<div class="ai-score-badge" style="background:#f0f7ff;padding:15px;border-radius:8px;margin:15px 0;">';
            $html .= '<p><strong>AI 评分：' . number_format($aiScore, 1) . ' / 100</strong></p>';
            if (!empty($scores)) {
                $html .= '<p>';
                foreach ($scores as $dim => $score) {
                    $labels = array('novelty'=>'新颖性','importance'=>'重要性','relevance'=>'相关性','readability'=>'可读性','viral'=>'传播性');
                    $label = isset($labels[$dim]) ? $labels[$dim] : $dim;
                    $html .= $label . ':' . $score . ' ';
                }
                $html .= '</p>';
            }
            $html .= '</div>';
        }
        
        if ($sourceUrl) {
            $html .= '<p>来源：<a href="' . htmlspecialchars($sourceUrl) . '" target="_blank">' . htmlspecialchars($source ?: $sourceUrl) . '</a></p>';
        }
        
        return $html;
    }
    
    /**
     * 安全字符串处理
     */
    private function safeStr($str, $maxLen = 0) {
        $str = trim($str);
        $str = remove_xss($str);
        if ($maxLen > 0 && mb_strlen($str, 'utf-8') > $maxLen) {
            $str = mb_substr($str, 0, $maxLen, 'utf-8');
        }
        return $str;
    }
    
    /**
     * JSON 成功响应
     */
    private function jsonSuccess($msg, $data = null) {
        $result = array('code' => 0, 'msg' => $msg);
        if ($data !== null) $result['data'] = $data;
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * JSON 错误响应
     */
    private function jsonError($msg, $code = 400) {
        http_response_code($code);
        echo json_encode(array('code' => $code, 'msg' => $msg), JSON_UNESCAPED_UNICODE);
        exit;
    }
}
