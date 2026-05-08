<?php
/**
 * OpenClaw AI Controller
 * @version 1.3.0
 */

require_once dirname(__FILE__) . '/../../../Core/Extend/OpenClawBridge.class.php';

class AiAction extends BaseAction {
    
    private $bridge;
    private $content_bridge;
    
    public function _initialize() {
        parent::_initialize();
        
        $gateway = C('OPENCLAW_GATEWAY_URL') ?: 'http://127.0.0.1:5001';
        $content_url = C('OPENCLAW_CONTENT_GATEWAY_URL') ?: 'http://127.0.0.1:5002';
        $api_key = C('OPENCLAW_API_KEY') ?: 'default_key';
        $secret = C('OPENCLAW_SECRET') ?: '';
        
        $this->bridge = new OpenClawBridge($gateway, $api_key, $secret);
        $this->content_bridge = new OpenClawBridge($content_url, $api_key, $secret);
    }
    
    // ==================== Chat ====================
    
    public function chat() {
        // ThinkPHP I() defaults to GET+POST, use directly
        $message = isset($_POST['message']) ? $_POST['message'] : (isset($_GET['message']) ? $_GET['message'] : '');
        $session_id = isset($_POST['session_id']) ? $_POST['session_id'] : (isset($_GET['session_id']) ? $_GET['session_id'] : '');
        
        if (empty($message)) {
            $this->ajaxReturn(['success' => false, 'error' => 'EMPTY_MESSAGE', 'message' => 'Message is empty']);
            return;
        }
        
        $context = [
            'user_ip'    => get_client_ip(),
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
        ];
        
        // Page context from frontend
        if (!empty($_POST['context']) || !empty($_GET['context'])) {
            $ctx = isset($_POST['context']) ? $_POST['context'] : json_decode($_GET['context'], true);
            if (is_array($ctx)) {
                $context['page_title'] = !empty($ctx['page_title']) ? $ctx['page_title'] : '';
                $context['page_keywords'] = !empty($ctx['page_keywords']) ? $ctx['page_keywords'] : '';
                $context['page_summary'] = !empty($ctx['page_summary']) ? $ctx['page_summary'] : '';
                $context['page_url'] = !empty($ctx['page_url']) ? $ctx['page_url'] : '';
            }
        }
        
        if (!empty($_SESSION['cms_userid'])) {
            $context['user_id'] = $_SESSION['cms_userid'];
        }
        
        $result = $this->bridge->chat($message, $session_id, $context);
        $this->ajaxReturn($result);
    }
    
    // ==================== Content APIs ====================
    
    public function auto_summary() {
        $content = isset($_POST['content']) ? $_POST['content'] : (isset($_GET['content']) ? $_GET['content'] : '');
        $max_length = isset($_POST['max_length']) ? intval($_POST['max_length']) : 200;
        
        if (empty($content)) {
            $this->ajaxReturn(['success' => false, 'error' => 'EMPTY_CONTENT']);
            return;
        }
        
        $result = $this->content_bridge->generateSummary($content, $max_length);
        $this->ajaxReturn($result);
    }
    
    public function auto_keywords() {
        $title = isset($_POST['title']) ? $_POST['title'] : (isset($_GET['title']) ? $_GET['title'] : '');
        $content = isset($_POST['content']) ? $_POST['content'] : (isset($_GET['content']) ? $_GET['content'] : '');
        $count = isset($_POST['count']) ? intval($_POST['count']) : 5;
        
        if (empty($title) && empty($content)) {
            $this->ajaxReturn(['success' => false, 'error' => 'EMPTY_CONTENT']);
            return;
        }
        
        $result = $this->content_bridge->extractKeywords($title, $content, $count);
        $this->ajaxReturn($result);
    }
    
    public function content_score() {
        $aid = isset($_POST['aid']) ? intval($_POST['aid']) : (isset($_GET['aid']) ? intval($_GET['aid']) : 0);
        
        if ($aid > 0) {
            $article = M('article')->where(['aid' => $aid])->find();
            if (!$article) {
                $this->ajaxReturn(['success' => false, 'error' => 'ARTICLE_NOT_FOUND']);
                return;
            }
            $data = [
                'title'       => $article['title'],
                'content'     => $article['content'],
                'keywords'    => $article['keywords'],
                'description' => $article['description'],
            ];
        } else {
            $data = [
                'title'       => isset($_POST['title']) ? $_POST['title'] : '',
                'content'     => isset($_POST['content']) ? $_POST['content'] : '',
                'keywords'    => isset($_POST['keywords']) ? $_POST['keywords'] : '',
                'description' => isset($_POST['description']) ? $_POST['description'] : '',
            ];
        }
        
        $result = $this->content_bridge->scoreContent($data);
        $this->ajaxReturn($result);
    }
    
    public function seo_optimize() {
        $aid = isset($_POST['aid']) ? intval($_POST['aid']) : (isset($_GET['aid']) ? intval($_GET['aid']) : 0);
        
        if (empty($aid)) {
            $this->ajaxReturn(['success' => false, 'error' => 'MISSING_AID']);
            return;
        }
        
        $article = M('article')->where(['aid' => $aid])->find();
        if (!$article) {
            $this->ajaxReturn(['success' => false, 'error' => 'ARTICLE_NOT_FOUND']);
            return;
        }
        
        $result = $this->content_bridge->seoOptimize($article);
        $this->ajaxReturn($result);
    }
    
    // ==================== Ticket ====================
    
    public function create_ticket() {
        $data = [
            'user_id'   => !empty($_SESSION['cms_userid']) ? $_SESSION['cms_userid'] : 0,
            'user_name' => !empty($_SESSION['cms_username']) ? $_SESSION['cms_username'] : '',
            'user_tel'  => isset($_POST['tel']) ? $_POST['tel'] : '',
            'subject'   => isset($_POST['subject']) ? $_POST['subject'] : '',
            'content'   => isset($_POST['content']) ? $_POST['content'] : '',
            'source'    => 'web',
        ];
        
        if (empty($data['subject']) || empty($data['content'])) {
            $this->ajaxReturn(['success' => false, 'error' => 'MISSING_REQUIRED']);
            return;
        }
        
        $result = $this->bridge->createTicket($data);
        $this->ajaxReturn($result);
    }
    
    // ==================== FAQ ====================
    
    public function faq() {
        $question = isset($_POST['question']) ? $_POST['question'] : (isset($_GET['question']) ? $_GET['question'] : '');
        
        if (empty($question)) {
            $this->ajaxReturn(['success' => false, 'error' => 'EMPTY_QUESTION']);
            return;
        }
        
        $result = $this->bridge->getFaqAnswer($question);
        $this->ajaxReturn($result);
    }
    
    // ==================== Transfer ====================
    
    public function transfer_human() {
        $session_id = isset($_POST['session_id']) ? $_POST['session_id'] : (isset($_GET['session_id']) ? $_GET['session_id'] : '');
        $reason = isset($_POST['reason']) ? $_POST['reason'] : 'User requested human';
        
        $result = $this->bridge->transferToHuman($session_id, $reason);
        $this->ajaxReturn($result);
    }
    
    // ==================== Query Order ====================
    
    public function query_order() {
        $order_no = isset($_POST['order_no']) ? $_POST['order_no'] : (isset($_GET['order_no']) ? $_GET['order_no'] : '');
        
        if (empty($order_no)) {
            $this->ajaxReturn(['success' => false, 'error' => 'EMPTY_ORDER_NO']);
            return;
        }
        
        // Try local first
        $local = M('member_trade')->where(['out_trade_no' => $order_no])->find();
        if ($local) {
            $status_map = [0 => 'Pending', 1 => 'Paid', 2 => 'Shipped', 3 => 'Done', 4 => 'Cancelled', 5 => 'Refunded'];
            $this->ajaxReturn([
                'success' => true,
                'source' => 'local',
                'order' => [
                    'order_no'    => $local['out_trade_no'],
                    'status'      => isset($status_map[$local['status']]) ? $status_map[$local['status']] : 'Unknown',
                    'amount'       => $local['price'],
                    'create_time' => date('Y-m-d H:i', $local['addtime']),
                ]
            ]);
            return;
        }
        
        $result = $this->bridge->queryOrder($order_no);
        $this->ajaxReturn($result);
    }
}
