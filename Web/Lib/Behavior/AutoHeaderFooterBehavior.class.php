<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

defined('THINK_PATH') or exit();

/**
 * 系统行为扩展：自动添加header和footer
 */
class AutoHeaderFooterBehavior extends Behavior 
{
    public function run(&$content)
    {
        // 检查内容是否已经有完整的 HTML 结构
        if (stripos($content, '<!DOCTYPE html>') !== false || stripos($content, '<html') !== false) {
            return; // 已经有完整结构，不处理
        }
        
        // 获取 header 和 footer
        $header = A('Public://head')->fetch('./template_head.html');
        $footer = A('Public://footer')->fetch('./template_footer.html');
        
        // 查找 body 标签位置
        $body_pos = stripos($content, '<body');
        if ($body_pos !== false) {
            // 找到 body 结束标签
            $body_end = stripos($content, '</body>');
            if ($body_end !== false) {
                // 在 body 内容前后添加 header 和 footer
                $body_start = stripos($content, '>') + 1;
                $before = substr($content, 0, $body_start);
                $body_content = substr($content, $body_start, $body_end - $body_start);
                $after = substr($content, $body_end);
                
                $content = $before . $body_content . $after;
            }
        }
        
        // 直接在内容开头添加 header
        $content = $header . $content;
        
        // 在内容结尾添加 footer
        $content = $content . $footer;
    }
}
