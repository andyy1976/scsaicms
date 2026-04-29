<?php
/**
 * OpenClaw Chat Widget Behavior
 * 自动在所有页面底部注入智能客服按钮
 *
 * 安装方式：在 Web/Conf/config.php 中添加：
 *   'tags' => array('view_filter' => array('ChatWidgetBehavior'))
 */

class ChatWidgetBehavior {

    /**
     * 客服组件 HTML/CSS
     */
    private static function getWidgetHtml() {
        $chatUrl = '/Public/chat/index.html';
        return <<<HTML

    <style>
    #ocw-btn{position:fixed;bottom:80px;right:20px;width:56px;height:56px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:50%;box-shadow:0 4px 16px rgba(102,126,234,.5);cursor:pointer;z-index:9999;display:flex;align-items:center;justify-content:center;font-size:26px;text-decoration:none;transition:transform .2s}
    #ocw-btn:hover{transform:scale(1.1)}
    #ocw-win{display:none;position:fixed;bottom:150px;right:20px;width:380px;height:520px;max-width:calc(100vw - 40px);max-height:calc(100vh - 200px);background:#fff;border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,.15);z-index:9998;overflow:hidden}
    #ocw-win.open{display:flex;flex-direction:column}
    </style>
    <a id="ocw-btn" href="javascript:void(0)" onclick="var w=document.getElementById('ocw-win');var b=document.getElementById('ocw-btn');if(w.classList.contains('open')){w.classList.remove('open');b.innerHTML='&#127911;'}else{w.classList.add('open');b.innerHTML='&#10005;}">&#127911;</a>
    <div id="ocw-win">
        <iframe src="{$chatUrl}" style="width:100%;height:100%;border:none;border-radius:16px;display:block"></iframe>
    </div>
HTML;
    }

    /**
     * 钩子入口 - 在模板渲染后、输出前注入
     */
    public function run(&$params) {
        // 检查是否启用
        if (!C('OPENCLAW_ENABLED')) {
            return;
        }

        // 只处理 HTML 响应
        if (C('OUTPUT_FILTER_HTML_ONLY')) {
            $content = ob_get_contents();
            if (stripos($content, '<html') === false) {
                return;
            }
        }

        // 在 </body> 前注入
        $widget = self::getWidgetHtml();
        $content = ob_get_contents();

        if (strripos($content, '</body>') !== false) {
            $content = str_ireplace('</body>', $widget . "\n</body>", $content);
            ob_clean();
            echo $content;
        }
    }
}
