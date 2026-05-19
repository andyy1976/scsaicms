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
	                    <img src="/Public/Uploads/uploadfile/images/pcb2.jpg" alt="pcb2.jpg" class="he_banpc">
	                    <img src="/Public/Uploads/uploadfile/images/pcb2.jpg" alt="pcb2.jpg" class="he_banph">
	                </div>
	                <div class="he_bante he_common">
	                    <div class="he_bantepy">
	                        <div class="he_bantep2t">
							<h1>
	                            <p>硬件方案AMS101-t982</p>
							</h1>
	                        </div>
	                        <div class="he_bantep3v">
	                            <p>
	                        <!-- AMS101-T982 属于安卓智能主板，支持 10-100 寸的显示。普遍适用于智慧显示终端产品、视频类终端产品、工业自 动化终端产品，如：广告机、数字标牌、智能自助终端、智能零售终端、O2O 智能设备、工控主机、机器人设备、大屏多媒体显示等。-->
	                        	</p>
	                        </div>
	                       <!--
	                        <div class="he_bantemo clearfix">
	                            <div class="he_bantemoli he_bantemoli1 fl">
	                                <a href="http://218.245.61.108/scplm/front/X-cache=scplm_1.0.0.1-X/scripts/mainpage.aspx#" class="clearfix">
	                                    <div class="g_bottonfl fl">免费体验</div>
	                                    <div class="g_bottonfr fr">
	                                        <img src="__TMPL__images/baneric01.png">
	                                    </div>
	                                </a>
	                            </div>
	                            <div class="he_bantemoli he_bantemoli1 fl">
	                                <a href="http://218.245.61.108/scplm/front/X-cache=scplm_1.0.0.1-X/scripts/mainpage.aspx#" class="clearfix">
	                                    <div class="g_bottonfl fl">产品演示</div>
	                                    <div class="g_bottonfr fr">
	                                        <img src="__TMPL__images/baneric02.png">
	                                    </div>
	                                </a>
	                            </div>
	                        </div>
	                        -->
	                    </div>
	                </div>
	            </div>
	        </div>
  		  </div>
        <!-- center -->

        <div class="he_ny he_main he_main he_pulma">

            <!-- 二级导航 -->

            <div class="he_plucnav">

                <div class="he_plnavul he_common">
                    <div class="he_plnavli yxnav_active2">
													<h2>

								                        <a href="javascript:;" id="ids1">适用范围</a>
													</h2>
                    </div>                 
                       <div class="he_plnavli">
											<h2>
                        <a href="javascript:;" id="ids2">产品概述</a>
													</h2>
                    </div>                  
                      <div class="he_plnavli">
															<h2>
										                        <a href="javascript:;" id="ids3">产品特点</a>
															</h2>
                    </div>                 
                       <div class="he_plnavli">
													<h2>
								                        <a href="javascript:;" id="ids4">外观示意图</a>
													</h2>
                    </div>             
                   <div class="he_plnavli">
														<h2>
									                        <a href="javascript:;" id="ids5">功能列表</a>
														</h2>
                    </div>
                     <div class="he_plnavli">
														<h2>
									                        <a href="javascript:;" id="ids6">PCB 尺寸</a>
														</h2>
                    </div>   
                    
                          <div class="he_plnavli">
														<h2>
									                        <a href="javascript:;" id="ids7">接口参数说明</a>
														</h2>
                    </div>    
                    
                                
                      <div class="he_plnavli">
															<h2>
										                        <a href="javascript:;" id="ids8">客户案例</a>
															</h2>
                    </div>      
                    
                              </div>

            </div>

    
            <div class="he_nybx">
                <div class="he_c2p1" yxdatop-pags="1">

                    <div class="he_common">

                        <div class="he_c2p1bx">

                            <div class="he_c2p1ti wow g_fadeup1">

                                <h2 class="he_puclti">业务范围</h2>

                            </div>

                            <div class="he_bap1tp">

                                <p>
                                	AMS101-T982 属于安卓智能主板，支持 10-100 寸的显示。普遍适用于智慧显示终端产品、视频类终端产品、工业自 动化终端产品，如：广告机、数字标牌、智能自助终端、智能零售终端、O2O 智能设备、工控主机、机器人设备、大屏多媒体显示等。
                                </p><p><br/></p>
                            </div>

                        </div>

                    </div>

                </div>    
       				  <div class="he_b2p1 he_c2p2" yxdatop-pags="2">

                    <div class="he_common">

                        <div class="he_b2p1bx">

                            <div class="he_bap21ti">

                                <h2 class="he_puclti">产品概述</h2>

                            </div>

                            <div class="he_bap1tp">

                                <p>
                                	AMS101-T982 采用晶晨 T 9 8 2 Cortex-A55 四核处理器 ， 搭载 Android11 系统， 主频最高达 1.8 GHz，超强性能。采用 Mali-G52 GPU，支持解码 8K 视频，且可识别更多格式的视频资源。无论是 游戏、跑分还是解码都是超一流，是您在人机交互、工控项目上的最佳选择。搭载了最先进的 HDR 格式杜比视界，能展示颜色更为丰富，杜比视界的画面能够展现687 亿种颜色，颜色的展现效果能力更高。</p><p><br/></p>
                            </div>

                        </div>

                    </div>

                </div>     
                         
               <div class="he_b2p2 he_c2p3" yxdatop-pags="3">

                    <div class="he_common">

                        <div class="he_b2p2bx">

                            <div class="he_b2p2ti wow g_fadeup1">

                                <h2 class="he_puclti">产品特点</h2>

                            </div>

                           <div class="he_bap1tp">

                                <p>
                                	高集成度。集成 LVDS/Vbyone/以太网/HDMI-IN/WIFI/蓝牙多功能于一体。丰富的扩展接口.1 个 USB3.0 标准接口和 5 个 USB2.0(3 个插针,2 个标准 USB 口),3 个可扩展串口（1 路 TTL，1 路 RS232，1 路 RS485）,4 个 GPIO/ADC 接口，可以满足市场上各种外设的要求。高清晰度。支持 VBYONE、单 8 位 LVDS 和双 8 位 LVDS 接口的 LCD 显示屏，分辨率最高支持 3840x2160，支持各 LCD 尺寸及分辨率裁剪屏。</p>
                                	<p>目前系统支持分辨率为 3840x2160、1920*1080 和 1280x720.切换不同分辨率 LCD 不需下载，单个版本，同时支持。开机时切换分辨率配置即可。 </p>
																					<p>支持 Android 系统定制，提供系统调用接口 API 参考代码，完美支持客户上层 应用 APP 开发。 完美支持红外、光学、电容、触摸膜等多种主流触摸屏，支持免驱触摸屏的 HID 配置， 无需调试。</p>
																					 </div>

                        </div>

                    </div>

                </div>  
                   <div class="he_b2p2 he_c2p3" yxdatop-pags="4">

                    <div class="he_common">

                        <div class="he_b2p2bx">

                            <div class="he_b2p2ti wow g_fadeup1">

                                <h2 class="he_puclti">外观及接口示意图</h2>

                            </div>

                            <div class="he_b2p2ig wow g_fadeup1">

                                <img src="/Public/Uploads/uploadfile/images/pcb1.jpg" alt="gyhlw.png">

                            </div>

                        </div>

                    </div>

                </div>         
               
                  <div class="he_b2p2 he_c2p3" yxdatop-pags="5">

                    <div class="he_common">

                        <div class="he_b2p2bx">

                            <div class="he_b2p2ti wow g_fadeup1">

                                <h2 class="he_puclti">基本功能列表</h2>

                            </div>

                            <div class="he_b2p2ig wow g_fadeup1">

                                <img src="/Public/Uploads/uploadfile/images/hwfunctionlist.png" alt="hwfunctionlist.png">

                            </div>

                        </div>

                    </div>

                </div>         
                  <div class="he_b2p2 he_c2p3" yxdatop-pags="6">

                    <div class="he_common">

                        <div class="he_b2p2bx">

                            <div class="he_b2p2ti wow g_fadeup1">

                                <h2 class="he_puclti">PCB 尺寸图</h2>

                            </div>

                            <div class="he_b2p2ig wow g_fadeup1">

                                <img src="/Public/Uploads/uploadfile/images/hwpcbsize.png" alt="hwpcbsize.png">

                            </div>

                        </div>

                    </div>

                </div>  
                 <div class="he_c2p4" yxdatop-pags="7">

                    <div class="he_c2p4n" style="background: url(__TMPL__images/c2pibj.jpg) no-repeat center;background-size:cover">

                        <div class="he_common">

                            <div class="he_c2p4bx">

                                <div class="he_c2p4ti wow g_fadeup1">

                                    <h2 class="he_puclti">系统接口</h2>

                                </div>

                                <div class="he_c2p4tiul wow g_fadeup1">

                                    <div class="he_c2p4tkul clearfix">

                                    <div class="he_c2p4tili act ">

                                            <p>电源输入接口</p>

                                        </div><div class="he_c2p4tili  ">

                                            <p>MIC 接口</p>

                                        </div><div class="he_c2p4tili  ">

                                            <p>状态指示灯</p>

                                        </div><div class="he_c2p4tili  ">

                                            <p>触摸屏接口</p>

                                        </div><div class="he_c2p4tili  ">

                                            <p>RTC 电池接口</p>

                                        </div><div class="he_c2p4tili  ">

                                            <p>IO 扩展 接口</p>

                                        </div>
                                        <div class="he_c2p4tili  ">

                                            <p>IIC 扩展 接口</p>

                                        </div>
                                  
																				<div class="he_c2p4tili  ">

                                            <p>更多接口</p>

                                        </div>
                                    </div>

                                </div>

                                <div class="he_c2p4gl">

                                    <div class="he_c2p4glul">

                                    <div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>电源输入接口</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>	采用 12Ｖ的直流电源供电，只允许从 DC 座和电源插座给板子系统供电，电源适配器的插头 DC IN 规格为Ｄ6.0，d2.5。在未接外设空负载情况下，主板功耗可达 8W。考虑外围功耗，适配器需要选用 12V4A以上。电源插座接口的电 气定义如下，可以采用电源板供电，座子规格为 6pin*2.54mm 间距：
																									 </p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                       

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/hwi1.png" alt="hwi1.png">

                                            </div>

                                        </div>
                                        <div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>MIC 接口</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>数字麦克。</p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                      

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/hwi2.png" alt="hwi2.png">

                                            </div>

                                        </div>
                                        <div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>状态指示灯</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>

																										指示灯颜色说明：上电红色，开机后蓝色。 </p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                              

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/hwi3.png" alt="hwi3.png">

                                            </div>

                                        </div>
                                        <div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>触摸屏接口</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>触摸屏接口（6pin*2.0mm） </p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                        

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/hwi4.png" alt="hwi4.png">

                                            </div>

                                        </div>
                                        <div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>RTC 电池接口</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>采用标准的 2032 接口，用于断电时给系统时钟供电。 </p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                             

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/hwi5.png" alt="hwi5.png">

                                            </div>

                                        </div>
                                        <div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>IO 扩展 接口</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>IO 用于给外设提供控制信号的输入/输出，电平为</p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                      
                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/hwi6.png" alt="6.png">

                                            </div>

                                        </div>
                                        <div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>IIC 扩展 接口</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>IIC 扩展接口，3.3V 电平。</p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                        

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/hwi7.png" alt="7.png">

                                            </div>

                                        </div>
                                           <div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>更多接口</h4>

                                                    <span>More</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>更多接口，请给我们来电吧，杨先生：18501250170，qq：1275697128</p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                        

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/company.png" alt="7.png">

                                            </div>

                                        </div>

                                    </div>

                                    <!-- 切换按钮 -->

                                    <div class="he_c2p4gbt wow g_fadein1">

                                        <div class="he_c2p4ght he_c2p4gle">

                                            <img src="__TMPL__images/c2arrle.png">

                                        </div>

                                        <div class="he_c2p4ght he_c2p4gri">

                                            <img src="__TMPL__images/c2arri.png">

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="he_c2p4bj wow g_fadein1">

                        <img src="__TMPL__images/c2pibj.jpg">

                    </div>

                </div>
                       
                <div class="he_b2p9" yxdatop-pags="8">

                    <div class="he_common">

                        <div class="he_b2p9bx">

                            <div class="he_b2p9ti wow g_fadeup1">

                                <h2 class="he_puclti">客户案例</h2>

                            </div>

                            <div class="he_b2p9ul clearfix">

                           
                                	 <?php $m=new Model("lvbo_article",NULL);$ret=$m->Distinct()->field("")->where("status=1 and typeid in (3,31,32,2252,2251) ")->group("")->order("ishot desc,addtime desc")->limit("4")->select();if(is_array($ret)):$i = 0;foreach($ret as $key=>$vo):++$i;?><div class="he_b2p9li fl">

					                                    <div class="he_b2p9gn">

					                                        <a href="<?php echo (url(articles,$vo["aid"])); ?>">

					                                            <div class="he_b2p9gnlo">

					                                                <img src="__TMPL__images/syimg0.png" class="he_img">

					                                                <img src="<?php echo ($vo["imgurl"]); ?>" alt="lantianqise-977.png" class="he_img1">

					                                            </div>

					                                            <div class="he_b2p9gnte">

					                                                <p><?php echo ($vo["title"]); ?></p>

					                                            </div>

					                                        </a>

					                                    </div>

                            					    </div><?php endforeach;endif; ?>
                                
                              
                                
                            </div>

                        </div>

                    </div>

                </div>     
                
       		      <div class="he_c2p10" yxdatop-pags="9">

                    <div class="he_common">

                        <div class="he_c2p10b">

                            <div class="he_c2p10ti wow g_fadeup1">

                                <h2 class="he_puclti">推荐产品</h2>

                            </div>

                            <div class="he_c2p10ul">

                                <div class="he_c2p10nul clearfix">

                                     <div class="he_c2p10li fl wow g_fadeup1">

                      			  <a href="index.php?s=/lists/51.html">

                            <div class="he_c2p10bl">

                                <div class="he_c2p10bti">

                                    <h4>航天军工领先的质量管理系统SCQMS</h4>

                                </div>

                                <div class="he_c2p10btp">

                                    <p>SCQMS是基于航天质量体系的质量管理系统软件，软件易学易用。</p>

                                </div>

                            </div>

                        </a>

 										   </div>
 										   
 									
				   						 		<div class="he_c2p10li fl wow g_fadeup1">

				                        <a href="index.php?s=/lists/54.html">

				                            <div class="he_c2p10bl">

				                                <div class="he_c2p10bti">

				                                    <h4>产品数据管理 SCPDM</h4>

				                                </div>

				                                <div class="he_c2p10btp">

				                                    <p>超云智能PDM产品数据管理系统以产品为中心，把企业生产过程中所有与产品相关的信息和过程集成起来统一管理。</p>

				                                </div>

				                            </div>

				                        </a>

				 							   </div>
										    <div class="he_c2p10li fl wow g_fadeup1">

                        <a href="index.php?s=/lists/55.html">

                            <div class="he_c2p10bl">

                                <div class="he_c2p10bti">

                                    <h4>生产执行管理系统SCMES</h4>

                                </div>

                                <div class="he_c2p10btp">

                                    <p>助力企业打造智能工厂，实现精益生产、精细管理，降本增效</p>

                                </div>

                            </div>

                        </a>

    </div>
 
				    <div class="he_c2p10li fl wow g_fadeup1">

				                        <a href="index.php?s=/lists/52.html">

				                            <div class="he_c2p10bl">

				                                <div class="he_c2p10bti">

				                                    <h4>全数字化工艺设计与管理系统SCPPS</h4>

				                                </div>

				                                <div class="he_c2p10btp">

				                                    <p>SCPPS是以2D为核心的工艺设计与管理平台，并逐步支持三维工艺设计，并于质量系统、PLM、MES实现融合的融合全数字化工艺设计与管理系统。</p>

				                                </div>

				                            </div>

				                        </a>

				    </div>
				    <div class="he_c2p10li fl wow g_fadeup1">

                        <a href="index.php?s=/lists/54.html">

                            <div class="he_c2p10bl">

                                <div class="he_c2p10bti">

                                    <h4>产品数据管理系统PDM</h4>

                                </div>

                                <div class="he_c2p10btp">

                                    <p>超云智能PDM产品数据管理系统以产品为中心，把企业生产过程中所有与产品相关的信息和过程集成起来统一管理。</p>

                                </div>

                            </div>

                        </a>

   					 </div>
  						  <div class="he_c2p10li fl wow g_fadeup1">

                        <a href="index.php?s=/lists/55.html">

                            <div class="he_c2p10bl">

                                <div class="he_c2p10bti">

                                    <h4>生产执行管理系统MES</h4>

                                </div>

                                <div class="he_c2p10btp">

                                    <p>助力企业打造智能工厂，实现精益生产、精细管理，降本增效</p>

                                </div>

                            </div>

                        </a>

   						 </div>
   						 <div class="he_c2p10li fl wow g_fadeup1">

                        <a href="index.php?s=/lists/54.html">

                            <div class="he_c2p10bl">

                                <div class="he_c2p10bti">

                                    <h4>产品全生命周期管理系统SCPLM</h4>

                                </div>

                                <div class="he_c2p10btp">

                                    <p>产品全生命周期管理系统InforCenter PLM，为企业提供从研发到制造一体化解决方案，助力企业数字化转型 。</p>

                                </div>

                            </div>

                        </a>

  						  </div>
                                </div>

                                <div class="he_c2p10sw wow g_fadein1">

                                    <div class="he_c2p4ght he_c2p4gle">

                                        <img src="__TMPL__images/c2arrle.png">

                                    </div>

                                    <div class="he_c2p4ght he_c2p4gri">

                                        <img src="__TMPL__images/c2arri.png">

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>       
                
                 

        	  </div>
			</div>
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