<?php
/**
 * OpenClaw AI Bridge SDK
 * 用于连接企业系统与龙虾智能体集群
 * 
 * @version 1.0.0
 * @author OpenClaw Team
 */

class OpenClawBridge {
    
    private $gateway_url;
    private $api_key;
    private $secret;
    private $timeout = 30;
    
    // 龙虾服务端点
    const LOBSTER_CUSTOMER_SERVICE = 'customer_service';
    const LOBSTER_CONTENT_STEWARD = 'content_steward';
    const LOBSTER_DATA_ANALYST = 'data_analyst';
    const LOBSTER_SEO_OPTIMIZER = 'seo_optimizer';
    const LOBSTER_OPERATIONS = 'operations';
    
    public function __construct($gateway_url, $api_key, $secret = null) {
        $this->gateway_url = rtrim($gateway_url, '/');
        $this->api_key = $api_key;
        $this->secret = $secret;
    }
    
    /**
     * 调用智能客服龙虾
     * 
     * @param string $message 用户消息
     * @param string $session_id 会话ID
     * @param array $context 上下文信息
     * @return array
     */
    public function chat($message, $session_id = null, $context = []) {
        $payload = [
            'message' => $message,
            'session_id' => $session_id ?: $this->generateSessionId(),
            'context' => array_merge($context, [
                'user_id' => $this->getCurrentUserId(),
                'user_name' => $this->getCurrentUserName(),
                'source' => 'web',
                'timestamp' => time()
            ])
        ];
        
        return $this->callLobster(self::LOBSTER_CUSTOMER_SERVICE, 'chat', $payload);
    }
    
    /**
     * 微信消息处理入口
     * 
     * @param array $wechat_msg 微信原始消息
     * @return array
     */
    public function handleWechatMessage($wechat_msg) {
        $msg_type = $wechat_msg['MsgType'];
        $from_user = $wechat_msg['FromUserName'];
        
        $payload = [
            'source' => 'wechat',
            'msg_type' => $msg_type,
            'from_user' => $from_user,
            'to_user' => $wechat_msg['ToUserName'],
            'timestamp' => $wechat_msg['CreateTime']
        ];
        
        switch ($msg_type) {
            case 'text':
                $payload['message'] = $wechat_msg['Content'];
                break;
            case 'voice':
                $payload['message'] = $wechat_msg['Recognition'] ?? '';
                $payload['media_id'] = $wechat_msg['MediaId'] ?? '';
                break;
            case 'image':
                $payload['image_url'] = $wechat_msg['PicUrl'] ?? '';
                $payload['media_id'] = $wechat_msg['MediaId'] ?? '';
                break;
            case 'event':
                $payload['event'] = $wechat_msg['Event'] ?? '';
                $payload['event_key'] = $wechat_msg['EventKey'] ?? '';
                break;
        }
        
        return $this->callLobster(self::LOBSTER_CUSTOMER_SERVICE, 'wechat_handle', $payload);
    }
    
    /**
     * 查询订单状态
     * 
     * @param string $order_no 订单号
     * @return array
     */
    public function queryOrder($order_no) {
        return $this->callLobster(self::LOBSTER_CUSTOMER_SERVICE, 'query_order', [
            'order_no' => $order_no
        ]);
    }
    
    /**
     * 产品咨询
     * 
     * @param string $product_id 产品ID
     * @param string $question 问题
     * @return array
     */
    public function productInquiry($product_id, $question) {
        return $this->callLobster(self::LOBSTER_CUSTOMER_SERVICE, 'product_inquiry', [
            'product_id' => $product_id,
            'question' => $question
        ]);
    }
    
    /**
     * 创建工单
     * 
     * @param array $ticket_data 工单数据
     * @return array
     */
    public function createTicket($ticket_data) {
        return $this->callLobster(self::LOBSTER_CUSTOMER_SERVICE, 'create_ticket', $ticket_data);
    }
    
    /**
     * 获取FAQ回复
     * 
     * @param string $question 问题
     * @return array
     */
    public function getFaqAnswer($question) {
        return $this->callLobster(self::LOBSTER_CUSTOMER_SERVICE, 'faq', [
            'question' => $question
        ]);
    }
    
    /**
     * 转人工客服
     * 
     * @param string $session_id 会话ID
     * @param string $reason 转接原因
     * @return array
     */
    public function transferToHuman($session_id, $reason = '') {
        return $this->callLobster(self::LOBSTER_CUSTOMER_SERVICE, 'transfer_human', [
            'session_id' => $session_id,
            'reason' => $reason
        ]);
    }
    
    // ==================== 内容管家龙虾 ====================
    
    /**
     * 生成文章摘要
     */
    public function generateSummary($content, $max_length = 200) {
        return $this->callLobster(self::LOBSTER_CONTENT_STEWARD, 'summary', [
            'content' => $content,
            'max_length' => $max_length
        ]);
    }
    
    /**
     * 提取关键词
     */
    public function extractKeywords($title, $content, $count = 5) {
        return $this->callLobster(self::LOBSTER_CONTENT_STEWARD, 'keywords', [
            'title' => $title,
            'content' => $content,
            'count' => $count
        ]);
    }
    
    /**
     * 内容质量评分
     */
    public function scoreContent($article_data) {
        return $this->callLobster(self::LOBSTER_CONTENT_STEWARD, 'score', $article_data);
    }
    
    /**
     * SEO优化建议
     */
    public function seoOptimize($article_data) {
        return $this->callLobster(self::LOBSTER_SEO_OPTIMIZER, 'optimize', $article_data);
    }
    
    // ==================== 数据分析师龙虾 ====================
    
    /**
     * 生成日报
     */
    public function generateDailyReport($date = null) {
        return $this->callLobster(self::LOBSTER_DATA_ANALYST, 'daily_report', [
            'date' => $date ?: date('Y-m-d')
        ]);
    }
    
    /**
     * 异常检测
     */
    public function detectAnomaly($metric, $value, $context = []) {
        return $this->callLobster(self::LOBSTER_DATA_ANALYST, 'anomaly', [
            'metric' => $metric,
            'value' => $value,
            'context' => $context
        ]);
    }
    
    // ==================== 核心调用方法 ====================
    
    /**
     * 调用龙虾服务
     * 
     * @param string $lobster 龙虾名称
     * @param string $action 动作
     * @param array $payload 数据
     * @return array
     */
    private function callLobster($lobster, $action, $payload) {
        $url = "{$this->gateway_url}/api/v1/lobster/{$lobster}/{$action}";
        
        $headers = [
            'Content-Type: application/json',
            "X-API-Key: {$this->api_key}",
            "X-Timestamp: " . time(),
        ];
        
        if ($this->secret) {
            $sign = $this->generateSignature($payload);
            $headers[] = "X-Signature: {$sign}";
        }
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            return [
                'success' => false,
                'error' => 'CURL_ERROR',
                'message' => $error
            ];
        }
        
        $result = json_decode($response, true);
        
        if ($http_code >= 400) {
            return [
                'success' => false,
                'error' => 'API_ERROR',
                'http_code' => $http_code,
                'message' => $result['message'] ?? 'Unknown error'
            ];
        }
        
        return $result;
    }
    
    /**
     * 生成签名
     */
    private function generateSignature($payload) {
        ksort($payload);
        $string = json_encode($payload) . $this->secret . time();
        return hash_hmac('sha256', $string, $this->secret);
    }
    
    /**
     * 生成会话ID
     */
    private function generateSessionId() {
        return 'chat_' . uniqid() . '_' . time();
    }
    
    /**
     * 获取当前用户ID
     */
    private function getCurrentUserId() {
        return $_SESSION['userid'] ?? $_SESSION['cms_userid'] ?? 0;
    }
    
    /**
     * 获取当前用户名
     */
    private function getCurrentUserName() {
        return $_SESSION['cms_username'] ?? $_SESSION['username'] ?? '';
    }
}
