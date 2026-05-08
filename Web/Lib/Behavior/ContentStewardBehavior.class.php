<?php
/**
 * 内容管家钩子
 * 在文章保存时自动调用AI处理
 * 
 * 安装: 将此文件放到 C:\wwwroot\Web\Lib\Behavior\
 * 配置: 在 tags.php 中添加 behavior 配置
 */

class ContentStewardBehavior {
    
    /**
     * 文章保存后自动处理
     */
    public function run(&$params) {
        if (!C('OPENCLAW_ENABLED')) {
            return;
        }
        
        $aid = $params['aid'] ?? 0;
        if (!$aid) return;
        
        // 获取文章数据
        $article = M('article')->where(['aid' => $aid])->find();
        if (!$article) return;
        
        // 检查是否需要处理
        $needs_process = false;
        $update_data = [];
        
        // 缺少摘要
        if (empty($article['description']) && !empty($article['content'])) {
            $needs_process = true;
        }
        
        // 缺少关键词
        if (empty($article['keywords'])) {
            $needs_process = true;
        }
        
        if (!$needs_process) return;
        
        // 调用内容管家龙虾
        $gateway_url = C('OPENCLAW_CONTENT_GATEWAY_URL') ?: 'http://localhost:5002';
        
        $post_data = [
            'title' => $article['title'],
            'content' => $article['content'],
            'keywords' => $article['keywords'] ?? '',
            'description' => $article['description'] ?? ''
        ];
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $gateway_url . '/api/v1/lobster/content_steward/analyze',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($post_data),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            $result = json_decode($response, true);
            
            if ($result['success']) {
                $analysis = $result['analysis'];
                
                // 更新摘要
                if (empty($article['description']) && !empty($analysis['summary'])) {
                    $update_data['description'] = $analysis['summary'];
                }
                
                // 更新关键词
                if (empty($article['keywords']) && !empty($analysis['keywords'])) {
                    $update_data['keywords'] = implode(',', $analysis['keywords']);
                }
                
                // 保存
                if (!empty($update_data)) {
                    M('article')->where(['aid' => $aid])->save($update_data);
                    
                    // 记录日志
                    $log_data = [
                        'aid' => $aid,
                        'task_type' => 'auto_process',
                        'status' => 2,
                        'result' => json_encode($update_data, JSON_UNESCAPED_UNICODE),
                        'created_at' => date('Y-m-d H:i:s'),
                        'processed_at' => date('Y-m-d H:i:s')
                    ];
                    
                    try {
                        M('ai_content_tasks')->add($log_data);
                    } catch (Exception $e) {
                        // 忽略日志错误
                    }
                }
            }
        }
    }
}
