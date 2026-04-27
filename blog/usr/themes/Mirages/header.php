<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>
    <?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?>律伯网-专家页面
    </title>
<link href="/web/tpl/lvbo/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="/web/tpl/lvbo/css/main.css" rel="stylesheet" type="text/css"/>
<script src="/web/tpl/lvbo/js/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="/web/tpl/lvbo/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/web/tpl/lvbo/js/main.js" type="text/javascript"></script>
<script src="/web/tpl/lvbo/js/jquery.jslides.js" type="text/javascript" ></script>
<?php

$stat = Typecho_Widget::widget('Widget_Stat');

			//登陆信息js
	    function login_js()
	    {
				$ret = '';
				if(isset($_SESSION['cms_username'])&&$_SESSION['cms_username'] !='')
				{
					$ret .='<li><a href="/index.php?s=wenda/tiwen">我要提问</a></li>';
					$ret .= '<li>欢迎您，'.$_SESSION['cms_username'].',&nbsp;';
					if(isset($_SESSION['cms_usericon'])&&$_SESSION['cms_usericon'] != '')
					{
						$ret .= '<img src="'.$_SESSION['cms_usericon'].'" border="0" width="16" height="16">';	
					} 
					$ret .= '<a href="/index.php?s=/member/main.html">会员中心</a>&nbsp;&nbsp;<a href="/index.php?s=/member/dologout.html">退出</a></li>';
				}
				else
				{
			
					$ret .= '<li><a href="javascript:" class="dl-tc">登陆</a> | <a href="javascript:" class="zc-tc">注册</a></li>';
				}
				echo $ret;
	    }

	
		?>
</head>
<body>
<div class="head-top">
	<div class="width-block">
		<ul>
			<li><a href="/index.php?s=/lists/91.html">关于我们</a></li>
		
			<?php  login_js();?> 
		</ul>
	</div>
</div>
<div class="head">
	<div class="width-block">
		<div class="logo"> 	<a href="/"><img src="/public/Uploads/logo/logo_20190705082119.jpg" alt="律伯网"></a></div>
		<div class="search">
			<div class="search-info">
			   <form class="form" id="search-form">
				<div class="search-left">
					<div class="language">
						<div class="select">
							<span>专家页面</span>
							<i></i>
						</div>
						<div class="list">
					
						
					

																				
						</div>
					</div>
					<div class="search-input"><input  id="search" name="s" type="text" placeholder="请输入搜索内容"></div>
				</div>
				<div class="search-btn"><button id="search_btn" type="submit"><i class="fa fa-search"></i>搜 索</button></div>
				 </form>
			</div>
			<div class="census">			<?php _e('已发布 <em>%s</em> 篇文章, 今天新增 <em>%s</em> 篇',
																		    $stat->publishedPostsNum, $stat->publishedPostsNumtoday); ?></div>

		</div>
	</div>
</div>
<div class="nav">
	<div class="nav-t">
			        <ul>
				    <li id="menu_1"><a href="/">首页</a></li>
				    <li><a href="/index.php?s=wenda"  target="_self">问答</a></li>
				    <li><a href="/index.php?s=/lists/5.html"  target="_self">指引</a></li>
	 			    <li><a href="/index.php?s=/lists/4.html"  target="_self">课堂</a></li>
				    <li><a href="/index.php?s=/lists/2.html"  target="_self">解读</a></li>
 				    <li><a href="/index.php?s=/lists/3.html"  target="_self">案例</a></li>
				    <li class="active"><a href="/blog"  target="_self">专家</a></li>
				    <li><a href="/index.php?s=/lists/8.html"  target="_self">工具</a></li>
				</ul>
	</div>
	<div class="nav-b"></div>
</div>
		

