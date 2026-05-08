<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html lang="zh-CN">



<head>
 <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="author" content="超云智能（SCIOT)" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <meta name="format-detection" content="telephone=no, email=no" />

    <meta name="renderer" content="webkit">
		<title><?php if(($title) != ""): echo ($title); ?>-<?php endif; echo ($config["sitetitle"]); ?>-<?php echo ($config["sitetitle2"]); ?></title>
		<meta name="keywords" content="<?php echo ($keywords); ?>"/>
		<meta name="description" content="<?php echo ($description); ?>"/>

    

    <link href="__TMPL__/css/bootstrap.min-v3.3.5.css" type="text/css" rel="stylesheet" />

    <link href="__TMPL__/css/base-v1.4.css" type="text/css" rel="stylesheet" />

    <link href="__TMPL__/css/slick.css" type="text/css" rel="stylesheet" />

    <link href="__TMPL__/css/slick-theme.css" type="text/css" rel="stylesheet" />

    <link href="__TMPL__/css/jquery.mCustomScrollbar.min.css" rel="stylesheet" />

    <link href="__TMPL__/css/animate.min.css" type="text/css" rel="stylesheet" />
    <link href="__TMPL__/css/main.css" type="text/css" rel="stylesheet" />
    <link href="__TMPL__/css/media.css" type="text/css" rel="stylesheet" />
    <link href="__TMPL__/css/style.css" type="text/css" rel="stylesheet" />

    <link href="__TMPL__/css/ifplayer.css" type="text/css" rel="stylesheet" />
 

    <link href="__TMPL__/css/style1.css" type="text/css" rel="stylesheet" />

    <link href="__TMPL__/css/iconfont.css" type="text/css" rel="stylesheet">

    <link href="__TMPL__/css/iframe.css" type="text/css" rel="stylesheet" />

</head>


<body>

    <div class="he_b2tr">

    
         <!-- pc head -->
        <header class="g_syhead">
            <div class="he_syhead clearfix">
                <div class="he_sylogo fl">
         				   <a href="/">
                        <img src="__PUBLIC__/Uploads/logo/<?php echo ($config["sitelogo"]); ?>" alt="超云智能智能智造软件研发商" class="he_img">
                        <img src="__PUBLIC__/Uploads/logo/<?php echo ($config["sitelogo"]); ?>" alt="超云智能智能智造软件研发商" class="he_img1">
                    </a>
                </div>
                <div class="he_synav fr clearfix">
           
     
      
               <div class="he_synavul fl">
                	
                      <div class="he_synavli fl  one">
	                      
	                                <a class=" g_phnav1" href="/" target="_self">首页</a>
	                                                       
	                  </div>
	                  
	               			<?php if(is_array($menu)): $k = 0; $__LIST__ = array_slice($menu,0,7,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><div class="he_synavli fl ">
															<a  data-n="<?php echo ($vo["drank"]); ?>"  href="<?php if(($vo["url"]) == ""): echo (url(lists,$vo["typeid"])); else: ?>__ROOT__<?php echo ($vo["url"]); endif; ?>" target="<?php if(($vo["target"]) == "1"): ?>_self<?php else: ?>_blank<?php endif; ?>"><?php echo ($vo["typename"]); ?></a> 
														   
														    
																<?php if($vo[submenu]){ ?>
			                           <div class="he_sypcuna he_xzdwm">
                                        <div class="he_comto">
                                            <div class="he_sypcuul clearfix">
                                                <div class="he_sypcuule fl clearfix">

																			<?php if(is_array($vo[submenu])): $m = 0; $__LIST__ = $vo[submenu];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($m % 2 );++$m;?><div class="he_sypculi fl  ">
                                                            <div class="he_sypcuto">
			                                            <a class=" he_sypcp" href="<?php echo (url(lists,$sub["typeid"])); ?>" target="_self"><?php echo ($sub["typename"]); ?></a>
		                                            </div>
                                                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
																			 </div>
                                            </div>
                                        </div>
                                        <div class="he_sypubt">
                                            <img src="__TMPL__/images/h1pdxa.jpg">
                                        </div>
                                    </div>
												
																			
																<?php } ?>
										
                      
	                        </div><?php endforeach; endif; else: echo "" ;endif; ?>		
        	 	
        	 	
       				  </div>
                    <div class="he_ipho clearfix fl">
                        <div class="he_iphoim fl">
                            <img src="__TMPL__/images/heaph1.png" class="he_img">
                            <img src="__TMPL__/images/heaph.png" class="he_img1">
                        </div>
                        <div class="he_iphote fl">
                            <p>136-6106-8044</p>
                        </div>
                    </div>
                    <div class="he_sear fl">
                        <div class="he_searig">
                            <img src="__TMPL__/images/heaser.png" class="he_img">
                            <img src="__TMPL__/images/heaser1.png" class="he_img1">
                        </div>
                        <div class="mc_search_xl">
                            <div class="mc_scm_container mc_pos_center">
                                 <form class="form" id="search" method="post" action="<?php echo U('Search/Index');;?>" role="search">
                                    <div class="mc_msc_box">
                                    		<input type="text" id="search"  name="k"  placeholder="请输入搜索关键字" onBlur="if(this.value=='') this.value='';" value="<?php echo ($keyword); ?>" class="mc_msc_input"
                                            autocomplete="off"/>
					
                                    
                                        <div class="mc_msc_submit" >
                                        	<button id="search_btn" type="submit"> <img src="__TMPL__/images/heaser1.png"></button>
                                           
                                        </div>
                                    </div>
                                  </form>
                                
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
        </header>




<div class="container mt-80">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center mb-40">5G解决方案</h1>
            <div class="row">
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-md-4 mb-30">
                        <div class="article-card">
                            <h3><a href="<?php echo url('content/index',array('id'=>$vo['id']));?>"><?php echo ($vo["title"]); ?></a></h3>
                            <p><?php echo ($vo["description"]); ?></p>
                            <span class="article-date"><?php echo ($vo["addtime"]); ?></span>
                        </div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="text-center mt-40">
                <?php echo ($page); ?>
            </div>
        </div>
    </div>
</div>

﻿﻿
		</div>
	</div>

		<footer class="footer pt-80 pt-xs-60"> 
				<div class="container"> 
					<div class="row footer-info mb-60"> 
								<div class="col-md-3 col-sm-4 col-xs-12 mb-sm-30"> 
									<h4 class="mb-30">联系方式</h4> 
									<ul class="link-small"> 
										<li><a><i class="ion-ios-location fa-icons"></i> 北京&middot;朝阳&middot;京师大厦</a></li> 
										<li><a href="mailto:service@sanyaosan.com"><i class="ion-ios-email fa-icons"></i>hahag@lvbo.com</a></li> 
										<li><a><i class="ion-ios-telephone fa-icons"></i>+86.12345678901</a></li>
									</ul> 
										 <div class="icons-hover-black"> 
										 	<a class="social weixin" href="javascript:"><img class="qrcode" src="__TMPL__/images/we_chat.jpg" alt="微信二维码"> <i class="fa fa-weixin" aria-hidden="true"></i></a> 

										 	<a href="http://wpa.qq.com/msgrd?v=3&uin=1557288226&site=qq&menu=yes" target="_blank"><i class="fa fa-qq" aria-hidden="true"></i></a> 
										 	<a href="https://weibo.com/lvbo" target="_blank"><i class="fa fa-weibo" aria-hidden="true"></i></a> 
										 	
										 	
										 	</div> 
								</div> 
								<div class="col-md-2 col-sm-3 col-xs-12 mb-sm-30"> 
									<h4 class="mb-30">网站地图</h4> 
									<ul class="link blog-link"> 
										<li><a href="./"><i class="fa fa-angle-double-right"></i> 首 页</a></li> 
										<li><a href="<?php echo url('lists',17);?>"><i class="fa fa-angle-double-right"></i> 品牌故事</a></li> 
										<li><a href="<?php echo url('lists',22);?>"><i class="fa fa-angle-double-right"></i> 产品列表</a></li> 
										<li><a href="<?php echo url('lists',18);?>"><i class="fa fa-angle-double-right"></i> 新闻动态</a></li> 
										<li><a href="<?php echo url('lists',27);?>"><i class="fa fa-angle-double-right"></i> 技术服务</a></li> 
										</ul> 
								</div> 
								<div class="col-md-3 col-sm-5 col-xs-12 mb-sm-30"> <h4 class="mb-30">最新动态</h4> 
									<div class="widget-details link"> <div class="post-type-post media"> 
										<div class="entry-thumbnail media-left"></div> 
										<div class="post-content media-body"> 
											<p class="entry-title"><a href="http://www.eastaiai.com/index.php?s=/articles/132.html">律伯网新版上线了</a></p> 
											<p class="entry-title"><a href="http://www.eastaiai.com/index.php?s=/articles/132.html">律伯网新版上线了</a></p> 
											<p class="entry-title"><a href="http://www.eastaiai.com/index.php?s=/articles/131.html">律伯网系统全新发布</a></p> 
											<p class="entry-title"><a href="http://www.eastaiai.com/index.php?s=/articles/131.html">律伯网系统全新发布</a></p> 
										</div> 
									</div> 
									<div class="post-type-post media"> 
												<div class="entry-thumbnail media-left"></div> 
												<div class="post-content media-body"> 
													<p class="entry-title"><a href="http://www.eastaiai.com/index.php?s=/articles/131.html">律伯网系统全新发布</a></p> 
													<p class="entry-title"><a href="http://www.eastaiai.com/index.php?s=/articles/131.html">律伯网系统全新发布</a></p> 
												</div> 
									</div> 
								  </div> 
								</div> 
								<div class="col-md-4 col-sm-12 col-xs-12 mt-sm-30 mt-xs-30">
														 <div class="newsletter"> 
														 	<h4 class="mb-30">订阅律伯网</h4> 
														 		<p>我们提供各种各样的 <a href="http://www.eastaiai.com/index.php?s=/lists/100.html"><span sytle="color:white;">联系方式</span></a></p> 
														 		<p> <br /></p>
														 	 <p>您还可以通过邮件订阅我们，</p> 
														 	 <p>掌握律伯网最新产品资讯、新闻动态和培训信息：</p> 
														 	 <form>
														 	 	 <input type="email" class="newsletter-input input-md newsletter-input mb-0" placeholder="输入 Email 订阅..."> 
														 	 	<button class="newsletter-btn btn btn-xs btn-color" type="submit" value=""><!--<i class="ion-ios-paperplane mr-0"></i>--></button> 
														 	 	</form>
												 	 	 </div>
					 	 	  </div> 
				  </div> 
				</div> 

				<div class="copyright"> 
																		<div class="container">
														 	 	  		<p>Copyright <i class="fa fa-copyright"></i> 律伯网（2013~2018）版权所有! 律伯网 ( 京ICP备18052489号 ) 法律顾问：北京哈文律师事务所.</a></p> 
														 	 	  	</div> 
				</div> 
		</footer> 
	
</body>
</html>