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




 <!-- banner -->

   <div class="he_banner he_banner1">

    <div class="he_bannigul">

        <div class="he_bannigli">

            <div class="he_banig">

                <img src="/Public/Uploads/uploadfile/images/H1guanyuwomen.jpg" alt="hangyesolution1.webp" class="he_banpc">

                <img src="/Public/Uploads/uploadfile/images/H1guanyuwomenph.jpg" alt="c2-373.jpg" class="he_banph">

            </div>

            <div class="he_bante he_common">

                <div class="he_bantepy">

                    <div class="he_bantep2t">
											<h1>

                        <p>SCIOT智能制造+工业互联网平台</p>
						
											</h1>

                    </div>

                    <div class="he_bantep3v">

                        <p>坚持自主创新，研发国产自主可控的智能制造+工业互联网平台软件，赋能中国工业创新发展。</p>

                    </div>

                    <div class="he_bantemo clearfix">

                        <div class="he_bantemoli he_bantemoli1 fl">

                             <a href="http://218.245.61.108/scplm/front/X-cache=scplm_1.0.0.1-X/scripts/mainpage.aspx#" class="clearfix">

                                <div class="g_bottonfl fl">免费体验</div>

                                <div class="g_bottonfr fr">

                                    <img src="__TMPL__images/baneric01.png">

                                </div>

                            </a>

                        </div>

                        <!-- <div class="he_bantemoli he_bantemoli1 fl">

                            <a href="http://p.qiao.baidu.com/cps/chat?siteId=7068912&amp;userId=10762368&amp;siteToken=df40424b6b4c48e528618d8d754928b8" class="clearfix">

                                <div class="g_bottonfl fl">立即咨询</div>

                                <div class="g_bottonfr fr">

                                    <img src="__TMPL__images/baneric01.png">

                                </div>

                            </a>

                        </div> -->

                    </div>
 									 
			   		


                </div>



            </div>
            
                   <!-- 面包屑 -->
			            <div class="he_breul">
							  		  <div class="he_common">
							       		你的位置：<?php echo ($nav); ?>
							         </div>
									</div>  

        </div>
        
     

    </div>

	</div>
        <!-- center -->

        <div class="he_ny he_c2bx he_main he_pulma">

            <!-- 二级导航 -->

            <div class="he_plucnav">

                <div class="he_plnavul he_common">
                	
                				 	<?php  $fid=get_field('type','typeid='.$type[typeid],'fid'); if($fid==0) { $pid=$type[typeid]; $pname=$type[typename]; } else { $pid=$fid; $pname=get_field('type','typeid='.$pid,'typename'); } ?>
									<?php $result=M('type')->where("fid=$pid and 1=1")->order("drank asc")->select();if(is_array($result)): $i = 0;foreach($result as $key=>$vo):++$i;?><div class="he_plnavli <?php if($type['typeid'] == $vo['typeid']){ ?>  yxnav_active2 <?php } ?> ">
											
										
										<h2>	<a href='<?php echo (url(lists,$vo["typeid"])); ?>'><?php echo ($vo["typename"]); ?></a></h2>
												<!--判定是否有子类-->
												<?php { ?>
												<div class="he_plnavli">
													<ul>
														<?php $result=M('type')->where("fid=$vo[typeid] and 1=1")->order("drank asc")->select();if(is_array($result)): $i = 0;foreach($result as $key=>$voo):++$i;?><li><span class="file <?php if($type['typeid'] == $voo['typeid']){ ?>  active <?php } ?>"><a href='<?php echo (url(lists,$voo["typeid"])); ?>' ><?php echo ($voo["typename"]); ?>(<?php echo $countofcurrenttypeid ?>)</a></span></li><?php endforeach;endif;?>
													</ul>
												</div>
												<?php } ?>
										</div><?php endforeach;endif;?>
									
                    <div class="he_plnavli ">
													<h2>

                        <a href="javascript:;" id="ids1">咨询热线：13661068044,微信同号</a>
												</h2>

                    </div>          
                    
         
                    
                                 </div>

            </div>


        </div>
        
             		&nbsp;
        	<?php if(count($list)==1){ ?>
						 	<div class="he_common">

                <div class="he_d2bxny">

                    <div class="he_d2bxp1">

                        <div class="he_d2bxp1ti">
						
																<h1>

                 			           <p><?php echo ($list[0]['title']); ?></p>
							
																</h1>

                        </div>
 										     <div class="he_d2bxnx clearfix">

                            <div class="he_d2bxnxle fl clearfix">

                                <div class="he_d2bxnkle fl">

                                    <img src="__TMPL__images/d2ic01.png">

                                </div>

                                <div class="he_d2bxnkri fl">

                                    <p><?php echo (msubstr($list[0]['addtime'],0,10)); ?></p>

                                </div>

                            </div>

                            <div class="he_d2bxnxri fl clearfix">

                                <div class="he_d2bxnxgle fl">

                                    <p>分享到</p>

                                </div>

                                <div class="he_d2bxnxgri bshare-custom fl clearfix">

                                    <div class="he_d2bxnili fl">

                                        <img src="__TMPL__images/d2pi02.jpg">

                                        <a title="分享到新浪微博" class="bshare-sinaminiblog" href="javascript:;"></a>

                                    </div>

                                    <div class="he_d2bxnili fl">

                                        <img src="__TMPL__images/d2pi03.jpg">

                                        <a title="分享到微信" class="bshare-weixin" href="javascript:;"></a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="he_d2bxp2">

                        <div class="he_d2bxp2ln yxedr_active">

                            <div class="he_d2bxp2bj">
					
           
        							  	   	<?php echo ($list[0]['content']); ?>
												
             	
          								  </div>
          							</div>
          					</div>
          					
          			</div>
          		</div>
						
							<?php }else{ ?>
						
               <div class="he_ny he_e1bx he_main">

        
            
			            <div class="he_e1p1 wow g_fadein1">

			                <div class="he_common">

			                    <div class="he_e1p1bx">

			                        <div class="he_e1p1ul">

												
																					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $idnumber= $idnumber+1; ?>
																				
																						
																							<div class="he_e1p1li">
																								
																									<a class="clearfix" href='<?php echo (url(articles,$vo["aid"])); ?>' target='_blank'>
																										   <div class="he_e1p1bxle fl">

															                                            <img src="__TMPL__images/e1flo1.png" class="he_img">

															                                            <img src=" __ROOT__<?php echo ($vo["imgurl"]); ?>" alt="" class="he_img1">

															                                        </div>

															                                        <div class="he_e1p1bxri fl">

															                                            <div class="he_e1p1bti">

															                                                <h4> <?php echo ($vo["title"]); ?></h4>

															                                            </div>

															                                            <div class="he_e1p1btp">

															                                                <p> <?php echo ($vo["description"]); ?></p>

															                                            </div>

															                                            <div class="he_e1p1bmo">

															                                                <p> <?php echo (msubstr($vo["addtime"],0,10)); ?></p>

															                                            </div>

															                                            <div class="he_e1p1bbmo">

															                                                <div class="g_botton">

															                                                    <div class="clearfix he_bott">

															                                                        <div class="g_bottonfl fl">了解更多</div>

															                                                        <div class="g_bottonfr fr"></div>

															                                                    </div>

															                                                </div>

															                                            </div>

															                                        </div>
																										
																										
																										
																										
																										
															                    
																										
																										
																										
																										</a>
																									
																								
																							</div><?php endforeach; endif; else: echo "" ;endif; ?>

			                          
			                        </div>


			                        
			                        <div class="he_e1p1qh clearfix">

			                            <div class="he_e1p1qhl he_e1p1qhle fl on">

			                                <img src="__TMPL__images/e1arrle1.png" class="he_img">

			                                <img src="__TMPL__images/e1arrle.png" class="he_img1">

			                            </div>

			                            <div class="he_e1p1qhl he_e1p1qhri fl">

			                                <img src="__TMPL__images/e1arri.png" class="he_img">

			                                <img src="__TMPL__images/e1arri1.png" class="he_img1">

			                            </div>

			                        </div>
			                        
			                    </div>

			                </div>

			            </div>        

			       		    <div class="he_e1p2">

			                <div class="he_common">

			                    <div class="he_e1p2bx">

			                        <div class="he_e1p2ul">

			                          
			                            	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="he_e1p2li  wow g_fadeup1">
																								
																									<a class="clearfix" href='<?php echo (url(articles,$vo["aid"])); ?>' target='_blank'>
																										   <div class="he_e1p1bxle fl">

															                              <img src="__TMPL__images/e1flo1.png" class="he_img"/>

															                               <img src=" __ROOT__<?php echo ($vo["imgurl"]); ?>" alt="" class="he_img1"/>

															                          </div>

					 																						<div class="he_e1p1bxri fl">

						                                            <div class="he_e1p1bti">

						                                                <h4><?php echo ($vo["title"]); ?></h4>

						                                            </div>

						                                            <div class="he_e1p1btp">

						                                                <p><?php echo ($vo["note"]); ?>
						                                            </div>

						                                            <div class="he_e1p1bmo">

						                                                <p><?php echo (msubstr($vo["addtime"],0,10)); ?></p>

						                                            </div>

						                                            <div class="he_e1p1bbmo">

						                                                <div class="g_botton">

						                                                    <div class="clearfix he_bott">

						                                                        <div class="g_bottonfl fl">了解更多</div>

						                                                        <div class="g_bottonfr fr"></div>

						                                                    </div>

						                                                </div>

						                                            </div>

					                                    		    </div>																								
																										
																										</a>
																									
																								
																							</div><?php endforeach; endif; else: echo "" ;endif; ?>
			                        </div>

			                    </div>

			                </div>

			   	         </div>

			            <div class="he_e1p3 wow g_fadein1">

			                <div class="he_common">

			                    <div class="he_e1p3bx">

			                        <div class="mc_fybox">

			                            <!-- pc分页 -->

			                            <div class="mc_pcfy">

			                               
			                                	 <?php echo ($page); ?>
			                               

			                            </div> 

			                        </div>

			                    </div>

			                </div>

			            </div>

   				     </div>
               	<?php } ?>

      <!-- foot -->
      <footer class="he_ft">

            <div class="g_foot clearfix">

                <div class="g_foottop clearfix">

                    <div class="g_foottopfl fl">

                        <div class="g_foottp clearfix fl">
                        	
                        	   	<?php if(is_array($menu)): $k = 0; $__LIST__ = array_slice($menu,0,7,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><div class="g_ftnav clearfix fl">
						                            	<div class="g_fttitle he_dttpc">   <a href="<?php if(($vo["url"]) == ""): echo (url(lists,$vo["typeid"])); else: ?>__ROOT__<?php echo ($vo["url"]); endif; ?>" target="<?php if(($vo["target"]) == "1"): ?>_self<?php else: ?>_blank<?php endif; ?>""><?php echo ($vo["typename"]); ?></a></div>
											                       	<!--第二级-->
																									<?php if($vo[submenu]){ ?>
																									<div class="he_navfu">
														                        	<?php if(is_array($vo[submenu])): $m = 0; $__LIST__ = $vo[submenu];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($m % 2 );++$m;?><div class="g_ftnavh2"><a href="<?php echo (url(lists,$sub["typeid"])); ?>"><?php echo ($sub["typename"]); ?>
														                               		<!--第三级-->
																																			<?php if(have_child($sub[typeid])){ ?>
																																		
																																			<ul>
																																			<?php $m=new Model("lvbo_type",NULL);$ret=$m->Distinct()->field("")->where("fid=$sub[typeid]")->group("")->order("drank asc")->limit("")->select();if(is_array($ret)):$i = 0;foreach($ret as $key=>$tree):++$i;?><li><a href='<?php echo (url(lists,$tree["typeid"])); ?>'><?php echo ($tree["typename"]); ?></a></li><?php endforeach;endif; ?>
																																			</ul>
																																			
																																			<?php } ?>
														                               	
														                               	</div><?php endforeach; endif; else: echo "" ;endif; ?>
											                  		      </div>
											                        			<?php } ?>
											                    </div><?php endforeach; endif; else: echo "" ;endif; ?>		
                    
											 					 
                         
                          
 																	
                            				
                            </div>

                        <div class="g_ftadd fl">

                           <div class="he_conttit">
                           	<h6 class="g_fttitle">联系我们</h6>
                           	<div class="g_fttitle he_dttph"><a href="/contact-us">联系我们</a></div>
                           	</div>
                           		<div class="g_ftaddnr clearfix">
                           			<div class="g_ftaddfl fl">
                           				<img src="__TMPL__/images/fticon1.png" alt=""/></div>
                           			  <div class="g_ftaddfr fl"><p>136-6106-8044</p></div>
                           			</div>
                           			
                           				<div class="g_ftaddnr clearfix">
                           				<div class="g_ftaddfl fl">
                           					<img src="__TMPL__/images/qq_login.png" alt=""/></div>
                           				
                           				<div class="g_ftaddfr fl"><p>1275697128</p></div>
                           				</div>
                           				<div class="g_ftaddnr clearfix">
                           				<div class="g_ftaddfl fl">
                           					<img src="__TMPL__/images/fticon2.png" alt=""/></div>
                           				
                           				<div class="g_ftaddfr fl"><p>tuan_zhang@sina.com</p></div>
                           				</div>
                           				
                           				<div class="g_ftaddnr clearfix"><div class="g_ftaddfl fl"><img src="__TMPL__/images/fticon3.png" alt=""/></div>
                           					<div class="g_ftaddfr fl"><p>北京昌平区建材城西路9号金燕龙写字楼616</p></div></div>
                        </div>

                    </div>

                    <div class="g_foottopfr fl">

                        <h6 class="g_fttitle">关注我们 | <a href="index.php?s=guestbook">在线留言</a></h6>

                        <div class="g_ftewm clearfix">

                            <div class="g_ftewmfl fl">

                                <div class="g_ftewmtu">

                                    <img src="__TMPL__/images/we_chat.jpg" alt="">

                                </div>

                                <p>添加微信</p>

                            </div>

                            <div class="g_ftewmfl fl">

                                <div class="g_ftewmtu">

                                    <img src="__TMPL__/images/wb.png" alt="">

                                </div>

                                <p>关注微博账号</p>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="g_footfriend clearfix">

                    <h6 class="g_fttitle fl">合作伙伴</h6>

                    <ul class="clearfix fl">
														 <?php $m=new Model("lvbo_link",NULL);$ret=$m->Distinct()->field("")->where("status=1")->group("")->order("rank asc")->limit("")->select();if(is_array($ret)):$i = 0;foreach($ret as $key=>$vo):++$i;?><li class="fl" ><a href="<?php echo ($vo["url"]); ?>" target="_blank"><?php echo ($vo["title"]); ?></a></li><?php endforeach;endif; ?>
           			 </ul>

                </div>

                <div class="g_footbot">

                    <p> 北京晨晖瑞汉科技有限公司 超云智能 版权所有 © 2015-2023 Supercloud Inteligence. All Rights Reserved<a href="http://www.beian.miit.gov.cn/" target="_blank" rel="”nofollow”"><?php echo ($config["sitetcp"]); ?></a>  
                    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <a href="index.php?s=/lists/2254.html"> 隐私政策</a> | <a href="/sitemap.html" target="_blank"> 网站地图</a></p>
                   
            </div>

        </footer>
         
    </div>
    <!-- 侧边导航 -->
   <div class="he_cenav">


        <div class="he_cenavli he_cenavli2">



            <div class="he_cenavjl">



                <div class="he_cenavig">



                    <img src="__TMPL__/images/ceic02.png">



                </div>



                <div class="he_cenavte">



                    <p>联系电话</p>



                </div>



            </div>



            <div class="mc_aside_zk">



                <span class="mc_icon mc_icon_tel"></span>



                <span>1366-1068-044</span>



            </div>



        </div>



        <div class="he_cenavli he_cenavli3">



        <a href="index.php?s=guestbook" class="tans">



            <div class="he_cenavjl">



                <div class="he_cenavig">



                    <img src="__TMPL__/images/ceic03.png">



                </div>



                <div class="he_cenavte">



                    <p>在线留言</p>



                </div>



            </div>



        </a>



        </div>

     <div class="he_cenavli he_cenavli3">



            <div class="he_cenavjl">



                <div class="he_cenavig">



                    <img src="__TMPL__/images/ceic04.png">



                </div>



                <div class="he_cenavte">



                    <p>关注微博</p>



                </div>



            </div>



            <div class="mc_aside_zk1">



                <div class="mc_aside_qrbox">



                    <div class="mc_aside_qrimgbox">



                        <img src="__TMPL__/images/wb.png" alt="">



                    </div>



                </div>



            </div>



        </div>


        <div class="he_cenavli he_cenavli3">



            <div class="he_cenavjl">



                <div class="he_cenavig">



                    <img src="__TMPL__/images/ceic04.png">



                </div>



                <div class="he_cenavte">



                    <p>添加微信</p>



                </div>



            </div>



            <div class="mc_aside_zk1">



                <div class="mc_aside_qrbox">



                    <div class="mc_aside_qrimgbox">



                        <img src="__TMPL__/images/we_chat.jpg" alt="">



                    </div>



                </div>



            </div>



        </div>



        <div class="he_cenavli he_cenavli4">



            <div class="he_cenavjl">



                <div class="he_cenavig">



                    <img src="__TMPL__/images/ceic05.png">



                </div>



                <div class="he_cenavte">



                    <p>TOP</p>



                </div>



            </div>



        </div>



    </div>




	

   


   

     

  
  
<script src="__TMPL__/js/jquery-3.3.1.min.js"></script>

<script src="__TMPL__/js/slick.min.js"></script>

<script src="__TMPL__/js/jquery.mCustomScrollbar.concat.min.js"></script>

<script src="__TMPL__/js/appear.js"></script>

<script src="__TMPL__/js/common.js" charset="utf-8"></script>
<script src="__TMPL__/js/jquery.gifplayer.js"></script>
<script src="__TMPL__/js/wow.min.js"></script>




  

    <script>

        new WOW().init();

    </script>

    <script>
 $(function(){

            $("#ids1").click(function() {

            $('.he_plnavli').removeClass('yxnav_active2');

            $(this).parent('.he_b1navli').addClass('yxnav_active2');

            $("html,body").animate({

                scrollTop: $('[yxdatop-pags="1"]').offset().top - 90

            }, 700);

        });

    

        

        $("#ids2").click(function() {

            $('.he_plnavli').removeClass('yxnav_active2');

            $(this).parent('.he_b1navli').addClass('yxnav_active2');

            $("html,body").animate({

                scrollTop: $('[yxdatop-pags="2"]').offset().top - 90

            }, 700);

        });

        $("#ids3").click(function() {

            $('.he_plnavli').removeClass('yxnav_active2');

            $(this).parent('.he_b1navli').addClass('yxnav_active2');

            $("html,body").animate({

                scrollTop: $('[yxdatop-pags="3"]').offset().top - 90

            }, 700);

        });

        $("#ids4").click(function() {

            $('.he_plnavli').removeClass('yxnav_active2');

            $(this).parent('.he_b1navli').addClass('yxnav_active2');

            $("html,body").animate({

                scrollTop: $('[yxdatop-pags="4"]').offset().top - 90

            }, 700);

        });

        $("#ids5").click(function() {

            $('.he_plnavli').removeClass('yxnav_active2');

            $(this).parent('.he_b1navli').addClass('yxnav_active2');

            $("html,body").animate({

                scrollTop: $('[yxdatop-pags="5"]').offset().top - 90

            }, 700);

        });

        $("#ids6").click(function() {

            $('.he_plnavli').removeClass('yxnav_active2');

            $(this).parent('.he_plnavli').addClass('yxnav_active2');

            $("html,body").animate({

                scrollTop: $('[yxdatop-pags="6"]').offset().top - 90

            }, 700);

        });

        $("#ids7").click(function() {

            $('.he_plnavli').removeClass('yxnav_active2');

            $(this).parent('.he_b1navli').addClass('yxnav_active2');

            $("html,body").animate({

                scrollTop: $('[yxdatop-pags="7"]').offset().top - 90

            }, 700);

        });

        $("#ids8").click(function() {

            $('.he_plnavli').removeClass('yxnav_active2');

            $(this).parent('.he_b1navli').addClass('yxnav_active2');

            $("html,body").animate({

                scrollTop: $('[yxdatop-pags="8"]').offset().top - 90

            }, 700);

        });

        })

        $('.he_c2p4glul').slick({

            dots: false,

            arrows: true,

            // speed: 500,

            fade: true,

            autoplaySpeed: 8000,

            slidesToShow: 1,

            slidesToScroll: 1,

            autoplay: true,

            pauseOnHover:true,


        });
        
         $(function () {

            $('.he_b2p6li').click(function () {

                var index = $(this).index();

                $(this).addClass("act").siblings().removeClass("act");

                $('.he_b2p6bsli').eq(index).stop().fadeIn().siblings('.he_b2p6bsli').stop().hide();

            })

        })

        $(function () {

            $('.he_b2p2tili').click(function () {

                var index = $(this).index();

                $(this).addClass("act").siblings().removeClass("act");

                $('.he_b2p7kuli').eq(index).stop().fadeIn().siblings('.he_b2p7kuli').stop().hide();

            })

        })
        
        
         // 工作空间 轮播
        $(function () {
            $(".he_b2p6bswh").slick({
                dots: false,
                arrows: true,
                // speed:3000,
                // autoplay:true,
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: ".he_b2p6ul",
                fade:true,
                autoplay: true,

                pauseOnHover:true,
            })

            $(".he_b2p6ul").slick({
                dots: false,
                arrows: true,
                // speed:3000,
                slidesToShow: 6,
                slidesToScroll: 1,
                focusOnSelect: true,


                asNavFor: ".he_b2p6bswh",
                responsive: [{

                    breakpoint: 1025,

                        settings: {

                    slidesToShow: 5,

                            }

                            }, 
                            {

                        breakpoint: 767,

                            settings: {

                        slidesToShow: 2,

                                }

                                }, 

                                 ]
                
            })
            $('.he_b2p6bswh').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
                var index = nextSlide;
                $(".he_b2p6li").eq(index).addClass("act").siblings().removeClass("act");
            });
          })



        $(".he_c2p4tili").click(function () {

            var index = $(this).index();

            $(this).addClass("act").siblings().removeClass("act");

            $(".he_c2p4glul").slick("slickGoTo", index)

        })

        $('.he_c2p4glul').on('beforeChange', function (event, slick, currentSlide, nextSlide) {

            var index = nextSlide;

            $(".he_c2p4tili").eq(index).addClass("act").siblings().removeClass("act");

        });

        $('.he_c2p4gbt .he_c2p4gle').click(function () {

            $('.he_c2p4glul').slick('prev')

        })

        $('.he_c2p4gbt .he_c2p4gri').click(function () {

            $('.he_c2p4glul').slick('next')

        });



        $('.he_c2p10nul').slick({

            dots: false,

            arrows: true,

            autoplaySpeed: 4000,

            slidesToShow: 3,

            slidesToScroll: 1,

            autoplay: true,

            autoplay: true,

            pauseOnHover:true,

            responsive: [{

                    breakpoint: 460,

                    settings: {

                        slidesToShow: 1,

                    }

                }, 

                ]

        });

        $('.he_c2p10sw .he_c2p4gle').click(function () {

            $('.he_c2p10nul').slick('prev')

        })

        $('.he_c2p10sw .he_c2p4gri').click(function () {

            $('.he_c2p10nul').slick('next')

        });
  <!-- $('.he_obtasli').click(function () { -->
            <!-- $(this).addClass('on'); -->
            <!-- $(this).siblings().removeClass('on'); -->
        <!-- }) -->

        <!-- $('.he_h3p3ubin').click(function (e) { -->
            <!-- e.stopPropagation(); -->
            <!-- $(this).siblings('.he_h3p3xl').slideToggle(); -->
            <!-- $(this).parents('.he_h3p3li').toggleClass('on'); -->
            <!-- $(this).parents('.he_h3p3li').siblings('.he_h3p3li').find('.he_h3p3xl').slideUp(); -->
            <!-- $(this).parents('.he_h3p3li').siblings('.he_h3p3li').removeClass('on'); -->
        <!-- }) -->
        <!-- $('body').click(function (e) { -->
            <!-- e.stopPropagation(); -->
            <!-- $('.he_h3p3xl').stop().slideUp(); -->
            <!-- $('.he_h3p3li').stop().removeClass('on'); -->
        <!-- }); -->
        <!-- $('.he_h3p3xl p').click(function () { -->
            <!-- var val = $(this).text(); -->
            <!-- $(this).parents('.he_h3p3xiala').find(".he_h3p3ubin input").attr('value', val); -->
        <!-- }) -->
        <!-- // 滚动条 -->
        <!-- $(function () { -->
            <!-- var scrollInertiaNum; -->
            <!-- if (/firefox/.test(navigator.userAgent.toLowerCase())) { -->
                <!-- scrollInertiaNum = 350; -->
            <!-- } else { -->
                <!-- scrollInertiaNum = 350; -->
            <!-- } -->
            <!-- $(".he_h3p3xhy").mCustomScrollbar({ -->
                <!-- theme: 'dark', -->
                <!-- scrollInertia: scrollInertiaNum, -->
                <!-- horizontalScroll: false, -->
                <!-- axis: "y", -->
            <!-- }); -->
        <!-- }); -->

        <!-- $(function () { -->
            <!-- var i = 0; -->
            <!-- var classes = ['rotate90', 'rotate180', 'rotate270', 'rotate360']; -->

            <!-- $('.he_h3p5z').on('click', function () { -->
                <!-- var $this = $(this).find('.he_h3p5zle img'); -->

                <!-- $this.addClass(classes[i++ % 4]) -->
                    <!-- .removeClass(function (idx, cls) { -->
                        <!-- var classes = cls.split(' '); -->
                        <!-- return classes.length > 1 ? classes[0] : ''; -->
                    <!-- }); -->
            <!-- }); -->
        <!-- }) -->

        <!-- if ($(window).width() < 1200) { -->

        <!-- // 滚动条 -->
        <!-- $(function () { -->
            <!-- var scrollInertiaNum; -->
            <!-- if (/firefox/.test(navigator.userAgent.toLowerCase())) { -->
                <!-- scrollInertiaNum = 350; -->
            <!-- } else { -->
                <!-- scrollInertiaNum = 350; -->
            <!-- } -->
            <!-- $(".he_h3pjur").mCustomScrollbar({ -->
                <!-- theme: 'dark', -->
                <!-- scrollInertia: scrollInertiaNum, -->
                <!-- horizontalScroll: false, -->
                <!-- axis: "y", -->
            <!-- }); -->
        <!-- }); -->
    <!-- } -->

        $('.he_bantemo').eq(0).click(function () {
            $('.he_obtain').fadeIn();
        })
        function shows(){
$('.he_obtain').fadeIn();
        }
        $('.he_obtagb').click(function () {
            $('.he_obtain').fadeOut();
        })
        $(window).on('scroll', function () {

            var heightb = $(window).scrollTop();
            // console.log(heightb)
            // console.log($('.he_main').offset().top - 86)
            if ($(window).scrollTop() > 1450) {
            if (heightb > $('.he_pulma').offset().top - 86 ) {
                $(".he_plucnav").stop().addClass('on');
                $('.g_syhead').stop().addClass('act');
            } else {
                $(".he_plucnav").stop().removeClass('on');
                $('.g_syhead').stop().removeClass('act');
            }
            }
            if ($(window).scrollTop() < 1450) {
                if (heightb > $('.he_pulma').offset().top - 60) {

                    $(".he_plucnav").stop().addClass('on');
                    $('.g_syhead').stop().addClass('act');
                } else {
                    $(".he_plucnav").stop().removeClass('on');
                    $('.g_syhead').stop().removeClass('act');
                }
                }
                if ($(window).scrollTop() < 1201) {
                    if (heightb > $('.he_pulma').offset().top - 90) {

                        $(".he_plucnav").stop().addClass('on');
                        $('.g_syhead').stop().addClass('act');
                    } else {
                        $(".he_plucnav").stop().removeClass('on');
                        $('.g_syhead').stop().removeClass('act');
                    }
                    }

            })

            if ($(window).width() < 768) {
                $('.he_c2p1ul').slick({

                    dots: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,

                    });
                    $('.he_b2p8ul').slick({

                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        autoplay: true,

                        });
                }
				
				   </script>
</body>



</html>