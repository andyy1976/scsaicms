<?php if (!defined('THINK_PATH')) exit();?>﻿<dl id="menu-article">
	<dt><i class="Hui-iconfont item-title item-icon-index">&#xe616;</i> 系统核心<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>


		 <div class='ss-navigation'>
	   
	   <a class='item-title item-icon-index' data-href="__APP__/Index/main" data-title="我的桌面">我的桌面 </a>
	   <a class='item-title item-icon-index' data-href="__APP__/Fields/index" data-title="扩展字段">扩展字段</a>
		 <a class='item-title item-icon-index' data-href="__APP__/Type/index" data-title="栏目管理">栏目管理</a> 
		 <a class='item-title item-icon-index' data-href="__APP__/Article/index" data-title="内容管理">内容管理</a> 
		 <a class='item-title item-icon-index' data-href="__APP__/Clear/clearcache" data-title="清理缓存">清理缓存</a>
        <?php $m=new Model("lvbo_extend_menu",NULL);$ret=$m->Distinct()->field("")->where("enable=1")->group("")->order("")->limit("")->select();if(is_array($ret)):$i = 0;foreach($ret as $key=>$vo):++$i; if(($vo["typeid"]) > "0"): ?><a class='item-title item-icon-index' data-href="__APP__/Article/index/typeid/<?php echo ($vo["typeid"]); ?>" data-title="<?php echo ($vo["menu_name"]); ?>"><?php echo ($vo["menu_name"]); ?></a> 
        <?php else: ?>
       <a class='item-title item-icon-index' data-href="__APP__/<?php echo ($vo["action_name"]); ?>/index" data-title="<?php echo ($vo["menu_name"]); ?>"><?php echo ($vo["menu_name"]); ?></a><?php endif; endforeach;endif; ?>
	
	  </div>


</dl>