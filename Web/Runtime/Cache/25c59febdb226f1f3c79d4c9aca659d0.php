<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="referrer" content="no-referrer" />
<meta name="keywords" content="<?php echo ($keywords); ?>"/>
<meta name="description" content="<?php echo ($description); ?>"/>
<title>
<?php if(($title) != ""): echo ($title); ?>-<?php endif; echo ($config["sitetitle"]); ?>-<?php echo ($config["sitetitle2"]); ?>
</title>
<link href="__TMPL__/css/bootstrap.min-v3.3.5.css" rel="stylesheet" type="text/css"/>
<link href="__TMPL__/css/base-v1.4.css" rel="stylesheet" type="text/css"/>
<link href="__TMPL__/css/slick.css" rel="stylesheet" type="text/css"/>
<link href="__TMPL__/css/slick-theme.css" rel="stylesheet" type="text/css"/>
<link href="__TMPL__/css/jquery.mCustomScrollbar.min.css" rel="stylesheet" type="text/css"/>
<link href="__TMPL__/css/animate.min.css" rel="stylesheet" type="text/css"/>
<link href="__TMPL__/css/main.css" rel="stylesheet" type="text/css"/>
<link href="__TMPL__/css/media.css" rel="stylesheet" type="text/css"/>
<link href="__TMPL__/css/style.css" rel="stylesheet" type="text/css"/>
<link href="__TMPL__/css/iconfont.css" rel="stylesheet" type="text/css"/>

<script src="__TMPL__/js/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="__TMPL__/js/bootstrap.min.js" type="text/javascript"></script>
<script src="__TMPL__/js/main.js" type="text/javascript"></script>
<script src="__TMPL__/js/jquery.jslides.js" type="text/javascript" ></script>
<script type="text/javascript"> 
			
function GetQueryString(name) 
{
		    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
		    var r = window.location.search.substr(1).match(reg);
		    if (r != null) return decodeURI(r[2]);
		    return null;
}


 
function Active_menu(i)
{
		//$('.header-left .active').removeClass('active');
		//alert(i);
			$("#menu_"+i).addClass('active');
			//$('#menu_1').addClass('nav_h1');
}
	

$(document).ready(function()
{ 
		//$('#shouye').addClass("nav_h11"); 
	
//alert("aa");
  //  		alert("a");
	var id=6;

		var s=GetQueryString("s");
	//alert(s);
	
		if(s==null)
		{
			//alert("1");
		 id=1;
		}
		
		else if(s.indexOf("memberlist")!=-1)
		{
			id=7;
		}
		else if(s.indexOf('wenda')!=-1)
		{
		 id=6;
		}
		/*
		else if(s.indexOf('search')!=-1)
		{
		 //alert("search");
		 id=GetQueryString("typeid");
		 alert(id);
		}
		*/
		else
		{
				 id=s.split('/')[2][0];
		}
	//	alert(id);
		Active_menu(id);




});  
</script> 
</head>
<body>
<div class="head-top">
	<div class="width-block">
		<ul>
			<li><a href="index.php?s=articles/1685.html">关于我们</a></li>
		  <li><a href="index.php?s=articles/1690.html">联系我们</a></li>
			<script src="<?php echo U('Api/login_js');?>"></script>
			
		</ul>
	</div>
</div>
<div class="head">
	<div class="width-block">
		<div class="logo"> 	<a href="/"><img src="__PUBLIC__/Uploads/logo/<?php echo ($config["sitelogo"]); ?>" alt="<?php echo ($config["sitetitle"]); ?>"></a></div>
		<div class="search">
			<div class="search-info">
		   <form class="form" id="search" method="post" action="<?php echo U('Search/Index');;?>" role="search">
				<div class="search-left">
					<div class="language">
										
									
											<select  class="select" style="height:40px;border:0px;" name="typeid" id="typeid">
											<option  class="list1" value="-1" ><span>全部文章</span><i></i></option>
												<?php if(is_array($menu)): $k = 0; $__LIST__ = array_slice($menu,0,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option class="list1" value="<?php echo ($vo["typeid"]); ?>"  <?php if(($typeid) == $vo[typeid]): ?>selected='selected'<?php endif; ?>><p><?php echo ($vo["typename"]); ?></p> </option><?php endforeach; endif; else: echo "" ;endif; ?>
											</select>
																								
								
					</div>
					<div class="search-input">
					<input type="text" id="search"  name="k"  placeholder="请输入搜索关键字" onBlur="if(this.value=='') this.value='';" value="<?php echo ($keyword); ?>"/>
					
					</div>
				</div>
				<div class="search-btn"><button id="search_btn" type="submit"><i class="fa fa-search"></i>搜 索</button></div>
				 </form>
			</div>
			<div class="census">已收录文章（案例） <?php echo ($counttotal); ?> 篇，今天新增 <?php echo ($counttoday); ?> 篇</div>
		</div>
	</div>
</div>
<div class="nav">
	<div class="nav-t">
		<ul>
			<li id="menu_-1"><a href="/">首页</a></li>

	        <?php if(is_array($menu)): $k = 0; $__LIST__ = array_slice($menu,0,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li id="menu_<?php echo ($vo["typeid"]); ?>"><a href="<?php if(($vo["url"]) == ""): echo (url(lists,$vo["typeid"])); else: ?>__ROOT__<?php echo ($vo["url"]); endif; ?>"  target="<?php if(($vo["target"]) == "1"): ?>_self<?php else: ?>_blank<?php endif; ?>"><?php echo ($vo["typename"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			
		</ul>
	</div>
	<div class="nav-b"></div>
</div>
<div id="slide">
	<div class="width-block">
		<div id="full-screen-slider">
			<ul id="slides">
				<?php $m=new Model("lvbo_flash",NULL);$ret=$m->Distinct()->field("")->where("status=1")->group("")->order("rank asc")->limit("")->select();if(is_array($ret)):$i = 0;foreach($ret as $key=>$vo):++$i;?><li style="background:url('__PUBLIC__/Uploads/hd/<?php echo ($vo["pic"]); ?>') no-repeat center top"><!--<a href="<?php echo ($vo["url"]); ?>" target="_blank">1</a>--></li><?php endforeach;endif; ?>
	        

			</ul>
		</div>	
	</div>
</div>



	



<div class="mainer">
	<div class="mainer-list-side">
			
				<div class="mainer-side">
								<div class="public-side-name">
											
								
											<!--当前级的上一级菜单，本级循环二级-->
												
													<?php  $fid=get_field('type','typeid='.$type[typeid],'fid'); if($fid==0) { $pid=$type[typeid]; $pname=$type[typename]; } else { $pid=$fid; $pname=get_field('type','typeid='.$pid,'typename'); } ?>
												  
												  	
											<h1><?php echo ($pname); ?></h1>
												<ul>	
													<?php $result=M('type')->where("fid=$pid and 1=1")->order("drank asc")->select();if(is_array($result)): $i = 0;foreach($result as $key=>$vo):++$i;?><li class="<?php if($type['typeid'] == $vo['typeid']){ ?>  onm <?php } ?> "><a href='<?php echo (url(lists,$vo["typeid"])); ?>'><?php echo ($vo["typename"]); ?></a>
																<?php $cid = get_children($vo['typeid']); if($vo['typeid'] != $cid) { ?>
																	<ul>
																		<?php $result=M('type')->where("fid=$vo[typeid] and 1=1")->order("drank asc")->select();if(is_array($result)): $i = 0;foreach($result as $key=>$voo):++$i;?><li><span class="file <?php if($type['typeid'] == $voo['typeid']){ ?>  active <?php } ?>"><a href='<?php echo (url(lists,$voo["typeid"])); ?>' ><?php echo ($voo["typename"]); ?></a></span></li><?php endforeach;endif;?>
																	</ul>
																<?php } ?>
															</li><?php endforeach;endif;?>
												</ul>
																	
					
								</div>
				</div>

				<div class="mainer-square">
					<div class="mainer-path">
						<span class='guide_menu'>你的位置：<?php echo ($nav); ?></span>
					</div>
					
								<div class="mainer-page-list">
										<div class='caption'>
											<h1><?php if(!empty($article["titlecolor"])): ?><font color="<?php echo ($article["titlecolor"]); ?>"><?php endif; echo ($article["title"]); if(isset($nowpage)): ?>(<?php echo ($nowpage); ?>)<?php endif; if(!empty($article["titlecolor"])): ?></font><?php endif; ?> <?php if(isset($nowpage)): ?>(<?php echo ($nowpage); ?>)<?php endif; ?></h1>
											
													<div class='share-list-type'>
														<div class='share-list'><b>[ 信息发布：本站 |&nbsp; 浏览：<?php echo ($article["hits"]); ?> ]</b>
																
											       </div>
											     </div>
					     		  </div>
								
								
								
										</div>
				
										<div class="width-block">
											
									
											
											<div class="text-conent">
												
												<div class="text-info">
											
																	
													
																<?php echo ($article["content"]); ?>
													<div id='home-page' style="text-align:center;">
							
																<!--详细页的分页自己美化-->
																<div class="clearfix"><?php echo ($page); ?></div>
																
														
																<div class="prenext"><?php echo ($updown); ?></div>
													</div>
			
														
												</div>
											</div>
											
										</div>
				
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

</body>

</html>