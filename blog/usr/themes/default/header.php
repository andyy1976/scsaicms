<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
<link href="http://localhost/web/tpl/new/css/public_head.css" rel="stylesheet" type="text/css"/>	
<link href="http://localhost/web/tpl/new/css/nav.css" rel="stylesheet" type="text/css"/>
<link href="http://localhost/web/tpl/new/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="http://localhost/web/tpl/new/css/footer.css" rel="stylesheet" type="text/css"/>
<link href="http://localhost/web/tpl/new/css/ionicons.css" rel="stylesheet" type="text/css"/>

<link href="http://localhost/web/tpl/new/css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="http://localhost/web/tpl/new/common_home.css" rel="stylesheet" type="text/css"/>
   <link rel="stylesheet" href="<?php $this->options->themeUrl('grid.css'); ?>">
   <link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>">

<script type="text/javascript" src="http://localhost/web/tpl/new/js/nav.js"></script>

<?php 
//登陆信息js
    function login_js()
    {
		$ret = '';
		if(isset($_SESSION['cms_username'])&&$_SESSION['cms_username'] !='')
		{
			$ret .='<li><a href="index.php?s=wenda/tiwen">我要提问</a></li>';
			$ret .= '<li>欢迎您，'.$_SESSION['cms_username'].',&nbsp;';
			if(isset($_SESSION['cms_usericon'])&&$_SESSION['cms_usericon'] != '')
			{
				$ret .= '<img src="'.$_SESSION['cms_usericon'].'" border="0" width="16" height="16">';	
			} 
			$ret .= '<a href="/index.php?s=/member/main.html">会员中心</a>&nbsp;&nbsp;<a href="/index.php?s=/member/dologout.html">退出</a></li>';
		}
		else
		{
	
			$ret .= '<li><a href="/index.php?s=/member/login.html">登陆</a> | <a href="/index.php?s=/member/register.html">注册</a></li>';
		}
		echo $ret;
    }
?>

</head>
<body>
	<div class="t">
    <div class="t_n">
        <div class="t_nl">
        	
         <p class="mail">欢迎访问律伯网 </p>
         <p class="mail">邮箱：service@lvbo.com </p>
         <p class="tel">咨询热线：+86-400-100-8000</p>
  
        </div>
			  <div class="r_nr">	 
			  	<p>
			  		<?php  login_js();?>
			  		|<a href="{:U('Wenda/index')}">我要提问</a>
			  		|<a href="{:U('Guestbook/index')}">我要留言</a>
			  		|<a href="{:U('Guestbook/index')}">收藏本站</a>
			  	</p>
				</div>
    </div>
	</div>

	<div class="header_bg">
	    <div class="header_box">
		    <div class="w1200">
						   		 	<div class="header_logo">
						   			<a href="/"><img src="/public/Uploads/logo/logo_20190705082119.jpg" alt="律伯网"></a>
						   		 	</div>

						        <div class="header_name">专业人力资源法律服务提供商</div>
		    </div>
    	</div>
	</div>
	<div class="clear"></div>
	
	<div class="nav">
					<div class="navigation1">
			        <ul>
								<li class="nav_h1"><a  href='/'>首页</a></li>
						    <li class="nav_h1"><a href="/index.php?s=/lists/2.html"  target="_self">法规解读</a></li>
								<li class="nav_h1"><a href="/index.php?s=/lists/3.html"  target="_self">典型案例</a></li>
								<li class="nav_h1"><a href="/index.php?s=/lists/4.html"  target="_self">务实课堂</a></li>
								<li class="nav_h1"><a href="/index.php?s=/lists/5.html"  target="_self">业务指引</a></li>
								<li class="nav_h1"><a href="/index.php?s=wenda"  target="_self">专家问答</a></li>
								<li class="nav_h1"><a class="nav_h1" href="/blog"  target="_self">专家页面</a></li>
								<li class="nav_h1"><a href="/index.php?s=/lists/8.html"  target="_self">业务咨询</a></li>
							</ul>
					</div>

			
			
	<div id="wrapper">

		<div id="body">
					<div class="HeightTab2 clearfix"></div>
				
						<div class='productIndexTuijian'>



						    <div class="header">

			 						<div class="header_zlsearch">
									  <form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
			                    					<label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
			                    					<input type="text" id="s" name="s" class="text" placeholder="<?php _e('输入关键字搜索'); ?>" />
			                    					<button type="submit" class="submit"><?php _e('搜索'); ?></button>
			        					 </form>			
												
									</div>

						    </div>

				    </div>
    <div class="container">
        <div class="row">

    
    
