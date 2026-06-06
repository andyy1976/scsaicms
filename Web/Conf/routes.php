<?php
	return array(
	// 内容数字员工API路由
	'api/humanize' => 'Contentemployee/humanize',
	'api/detect-ai' => 'Contentemployee/detect_ai',
	'api/tech-translate' => 'Contentemployee/tech_translate',
	'api/product-doc' => 'Contentemployee/product_doc',
	'api/hotspot' => 'Contentemployee/hotspot',
	'api/publish' => 'Contentemployee/publish',
	
	// 工具页面路由
	'tools' => 'Contentemployee/index',
	'humanize' => 'Contentemployee/index',
	
	// 原有路由
	'articles/:aid' => 'Article/index',
	'lists/:typeid' => 'List/index',
	'photos' => 'List/photo',
	'votes/:id' => 'Vote/index',
	's'=> 'Index/search',
	//演示url的SEO 后台栏目管理URL外部连接设置为/about.html不启用即可
	'about' => 'List/index?typeid=15',
	'news' => 'List/index?typeid=18',
	'product' => 'List/index?typeid=22',
	'project' => 'List/index?typeid=27',
	'zhaopin' => 'List/index?typeid=25',
	'source-market' => 'List/index?typeid=5',
	'systems' => 'List/index?typeid=2',
	'digital-employee' => 'List/index?typeid=4',
	'enablement' => 'List/index?typeid=7',
	
	// 原首页保留为内容页
	'content' => 'Index/index',
	'home' => 'Index/index',
	);
?>