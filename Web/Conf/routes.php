<?php
	return array(
	// 内容数字员工API路由
	'api/humanize' => 'Contentemployee/humanize',
	'api/detect-ai' => 'Contentemployee/detect_ai',
	'api/tech-translate' => 'Contentemployee/tech_translate',
	'api/product-doc' => 'Contentemployee/product_doc',
	'api/hotspot' => 'Contentemployee/hotspot',
	'api/publish' => 'Contentemployee/publish',
	'api/save-article' => 'Contentemployee/saveArticle',
	'api/categories' => 'Contentemployee/categories',
	'api/test-ai' => 'Contentemployee/test_ai',
	
	// 诊断报告路由
	'diagnosis' => 'Diagnosis/index',
	'api/diagnosis/save' => 'Diagnosis/save',
	'api/diagnosis/list' => 'Diagnosis/list',
	'api/diagnosis/detail' => 'Diagnosis/detail',
	'api/diagnosis/delete' => 'Diagnosis/delete',
	
	
	// 自测问卷路由
	'survey' => 'Survey/index',
	'api/survey/save' => 'Survey/save',
	'api/survey/list' => 'Survey/list',
	'api/survey/delete' => 'Survey/delete',
	
	// 公众号文章路由
	'article' => 'Article/index',
	
	// 需求征集路由
	'feedback' => 'Feedback/index',
	'api/feedback/save' => 'Feedback/save',
	'api/feedback/list' => 'Feedback/list',
	'api/feedback/vote' => 'Feedback/vote',
	'api/feedback/update-status' => 'Feedback/updateStatus',
	'api/feedback/delete' => 'Feedback/delete',
	
	// 内容数字员工工作台路由
	'digital-employee' => 'DigitalEmployee/index',
	'digitalemployee/:action' => 'DigitalEmployee/$1',
	
	// CMS内容AI化路由
	'rewrite' => 'Rewrite/index',
	'api/content-rewrite' => 'Contentemployee/content_rewrite',
	'api/content-adapt' => 'Contentemployee/content_adapt',
	'api/content-list' => 'Contentemployee/content_list',
	
	// 阅读反馈路由
	'read-feedback' => 'ReadFeedback/index',
	'api/read-feedback/track' => 'ReadFeedback/track',
	'api/read-feedback/stats-report' => 'ReadFeedback/statsReport',
	'api/read-feedback/article-stats' => 'ReadFeedback/articleStats',
	'api/read-feedback/like' => 'ReadFeedback/like',
	'api/read-feedback/share' => 'ReadFeedback/share',
	
	// CMS智能栏目路由
	'smart-column' => 'SmartColumn/index',
	'api/smart-column/generate' => 'SmartColumn/generate',
	'api/smart-column/analyze' => 'SmartColumn/analyze',
	'api/smart-column/optimize' => 'SmartColumn/optimize',
	
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
	'enablement' => 'List/index?typeid=7',
	
	// 原首页保留为内容页
	'content' => 'Index/index',
	'home' => 'Index/index',
	);
?>