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
 * 系统行为扩展：客服聊天窗口注入
 * @category   Think
 * @package  Think
 * @subpackage  Behavior
 */
class ChatWidgetHookBehavior extends Behavior 
{
    // 行为参数定义
    protected $options   =  array(
    );

    // 行为扩展的执行入口必须是run
    public function run(&$content){
        // 在</body>标签前注入聊天窗口HTML
        $chatWidget = $this->getChatWidgetHtml();
        $content = preg_replace('/<\/body>/i', $chatWidget . '</body>', $content);
    }

    /**
     * 获取聊天窗口HTML
     * @access protected
     * @return string
     */
    protected function getChatWidgetHtml() {
        $html = <<<HTML
<div class="ocw-btn" onclick="document.querySelector('.ocw-win').classList.toggle('ocw-active')">
    <div class="ocw-btn__inner">
        <span class="ocw-btn__icon">🦞</span>
        <span class="ocw-btn__text">在线客服</span>
    </div>
</div>

<div class="ocw-win">
    <div class="ocw-win__header">
        <h3 class="ocw-win__title">在线客服</h3>
        <button class="ocw-win__close" onclick="document.querySelector('.ocw-win').classList.remove('ocw-active')">✕</button>
    </div>
    <div class="ocw-win__body">
        <iframe src="/Public/chat/index.html" width="100%" height="100%" frameborder="0"></iframe>
    </div>
</div>

<style>
    .ocw-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        cursor: pointer;
    }
    
    .ocw-btn__inner {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        background: #9c27b0;
        color: white;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    
    .ocw-btn__inner:hover {
        background: #7b1fa2;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }
    
    .ocw-btn__icon {
        font-size: 24px;
    }
    
    .ocw-btn__text {
        font-size: 16px;
        font-weight: 500;
    }
    
    .ocw-win {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 360px;
        height: 480px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        z-index: 9998;
        display: none;
        flex-direction: column;
    }
    
    .ocw-win.ocw-active {
        display: flex;
    }
    
    .ocw-win__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        border-radius: 12px 12px 0 0;
    }
    
    .ocw-win__title {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }
    
    .ocw-win__close {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #666;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .ocw-win__close:hover {
        background: #e9ecef;
        color: #333;
    }
    
    .ocw-win__body {
        flex: 1;
        overflow: hidden;
    }
    
    .ocw-win__body iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
    
    @media (max-width: 768px) {
        .ocw-btn {
            bottom: 20px;
            right: 20px;
        }
        
        .ocw-btn__inner {
            padding: 10px 16px;
        }
        
        .ocw-btn__icon {
            font-size: 20px;
        }
        
        .ocw-btn__text {
            font-size: 14px;
        }
        
        .ocw-win {
            bottom: 80px;
            right: 20px;
            width: calc(100vw - 40px);
            height: 400px;
        }
    }
</style>
HTML;
        return $html;
    }

}