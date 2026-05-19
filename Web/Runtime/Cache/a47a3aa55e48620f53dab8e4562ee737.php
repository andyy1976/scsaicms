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

                <img src="/Public/Uploads/uploadfile/images/c2banner.jpg" alt="c2banner.jpg" class="he_banpc">

                <img src="/Public/Uploads/uploadfile/images/c2-373.jpg" alt="c2-373.jpg" class="he_banph">

            </div>

            <div class="he_bante he_common">

                <div class="he_bantepy">

                    <div class="he_bantep2t">
					<h1>

                        <p>SCIOT智能制造+工业互联网平台解决方案</p>
						
						</h1>

                    </div>

                    <div class="he_bantep3v">

                        <p>打造以质量、工艺及三维模型等数据为核心的智能制造+工业互联网平台,构建基于海量数据的采集、汇聚、分析、协同和服务体系。</p>

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

        </div>

    </div>

</div>
        <!-- center -->

        <div class="he_ny he_c2bx he_main he_pulma">

            <!-- 二级导航 -->

            <div class="he_plucnav">

                <div class="he_plnavul he_common">
                    <div class="he_plnavli yxnav_active2">
					<h2>

                        <a href="javascript:;" id="ids1">业务挑战</a>
					</h2>

                    </div>                    <div class="he_plnavli">
					<h2>
                        <a href="javascript:;" id="ids2">方案概述</a>
					</h2>
                    </div>                    <div class="he_plnavli">
					<h2>
                        <a href="javascript:;" id="ids3">方案架构</a>
					</h2>
                    </div>                    <div class="he_plnavli">
					<h2>
                        <a href="javascript:;" id="ids4">应用场景</a>
					</h2>
                    </div>                                        <div class="he_plnavli">
					<h2>
                        <a href="javascript:;" id="ids6">客户案例</a>
					</h2>
                    </div>                    <div class="he_plnavli">
					<h2>
                        <a href="javascript:;" id="ids7">推荐产品</a>
					</h2>
                    </div>                    <div class="he_plnavli">
					<h2>
                        <a href="javascript:;" id="ids8">选择超云智能</a>
					</h2>
                    </div>                </div>

            </div>

    
            <div class="he_nybx">
                <div class="he_c2p1" yxdatop-pags="1">

                    <div class="he_common">

                        <div class="he_c2p1bx">

                            <div class="he_c2p1ti wow g_fadeup1">

                                <h2 class="he_puclti">业务挑战</h2>

                            </div>

                            <div class="he_c2p1ul clearfix">

                       		     <div class="he_c2p1li fl wow g_fadeup1">

                                    <div class="he_c2p1lbx clearfix">

                                        <div class="he_c2p1lble fl">

                                            

                                            <div class="he_c2p1leig">

                                                <img src="__TMPL__images/c2flo1.png" class="he_img">

                                                <img src="/Public/Uploads/uploadfile/images/chanpinyoushi-duozhongduanyingyong.svg" alt="chanpinyoushi-duozhongduanyingyong.svg" class="he_img1">

                                            </div>

                                        </div>

                                        <div class="he_c2p1lbri fl">

                                            <div class="he_b3p6lic2n">
                                                <div class="he_c2p1leti">

                                                    <h4> IT系统孤岛现象严重</h4>
    
                                                </div>


                                                <div class="he_b3p6li clearfix"><div class="he_b3p6lile fl"><img src="__TMPL__images/b2ic_01.png"/></div><div class="he_b3p6liri fl"><p><span style=""><span style="">IT<span style="">系统多，各系统之间数据集成复杂，存在重复投入问题，数据共享困难。</span></span></span></p><p><br/></p></div></div><p><br/></p>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                
                                <div class="he_c2p1li fl wow g_fadeup1">

                                    <div class="he_c2p1lbx clearfix">

                                        <div class="he_c2p1lble fl">

                                            

                                            <div class="he_c2p1leig">

                                                <img src="__TMPL__images/c2flo1.png" class="he_img">

                                                <img src="/Public/Uploads/uploadfile/images/chanpinyoushi-gongyisanweiguantong.svg" alt="chanpinyoushi-gongyisanweiguantong.svg" class="he_img1">

                                            </div>

                                        </div>

                                        <div class="he_c2p1lbri fl">

                                            <div class="he_b3p6lic2n">
                                                <div class="he_c2p1leti">

                                                    <h4> 数据难支撑实时的决策能力</h4>
    
                                                </div>


                                                <div class="he_b3p6li clearfix"><div class="he_b3p6lile fl"><img src="__TMPL__images/b2ic_01.png"/></div><div class="he_b3p6liri fl"><p><span style=""><span style="">IT<span style="">垂直集成的数据，上一层是下一层的汇聚和抽象数据，层次越高，数据失真就越大。</span></span></span></p><p><br/></p></div></div><p><br/></p>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <div class="he_c2p1li fl wow g_fadeup1">

                                    <div class="he_c2p1lbx clearfix">

                                        <div class="he_c2p1lble fl">

                                            

                                            <div class="he_c2p1leig">

                                                <img src="__TMPL__images/c2flo1.png" class="he_img">

                                                <img src="/Public/Uploads/uploadfile/images/chanpinyoushi-kuapingtaiyingyong.svg" alt="chanpinyoushi-kuapingtaiyingyong.svg" class="he_img1">

                                            </div>

                                        </div>

                                        <div class="he_c2p1lbri fl">

                                            <div class="he_b3p6lic2n">
                                                <div class="he_c2p1leti">

                                                    <h4>数据无法应对复杂的变化和预测</h4>
    
                                                </div>


                                                <div class="he_b3p6li clearfix"><div class="he_b3p6lile fl"><img src="__TMPL__images/b2ic_01.png"/></div><div class="he_b3p6liri fl"><p><span style=""><span style="">IT<span style="">数据增值服务亟待进一步挖掘，高级的数据利用，如设备可靠性的预测、产能的预测等还没发挥出作用。</span></span></span></p><p><br/></p></div></div><p><br/></p>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                
                                <div class="he_c2p1li fl wow g_fadeup1">

                                    <div class="he_c2p1lbx clearfix">

                                        <div class="he_c2p1lble fl">

                                            

                                            <div class="he_c2p1leig">

                                                <img src="__TMPL__images/c2flo1.png" class="he_img">

                                                <img src="/Public/Uploads/uploadfile/images/chanpinyoushi-kuaisubushu.svg" alt="chanpinyoushi-kuaisubushu.svg" class="he_img1">

                                            </div>

                                        </div>

                                        <div class="he_c2p1lbri fl">

                                            <div class="he_b3p6lic2n">
                                                <div class="he_c2p1leti">

                                                    <h4>系统扩展性和灵活性差</h4>
    
                                                </div>


                                                <div class="he_b3p6li clearfix"><div class="he_b3p6lile fl"><img src="__TMPL__images/b2ic_01.png"/></div><div class="he_b3p6liri fl"><p><span style=""><span style="">IT<span style="">单体应用架构，紧耦合、业务复杂，维护变更困难，功能和性能的无法灵活扩展、个性化定制。</span></span></span></p><p><br/></p></div></div><p><br/></p>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>                <div class="he_b2p1 he_c2p2" yxdatop-pags="2">

                    <div class="he_common">

                        <div class="he_b2p1bx">

                            <div class="he_bap1ti wow g_fadeup1">

                                <h2 class="he_puclti">方案概述</h2>

                            </div>

                            <div class="he_bap1tp wow g_fadeup1">

                                <p>SCIOT<span style="">工业互联网平台是面向制造业虚拟化、数字化、网络化、智能化需求，构建基于海量数据的采集、汇聚、分析、协同和服务体系，支撑制造资源泛在连接、弹性供给、互联互通、高效配置的开放式工业云平台，结合自身<span style="">3D<span style="">优势，形成以<span style="">工艺、质量、三维模型等<span style="">数据为核心的智能制造+工业互联网平台。</span></span></span></span></span></p><p><br/></p>
                            </div>

                        </div>

                    </div>

                </div>                <div class="he_b2p2 he_c2p3" yxdatop-pags="3">

                    <div class="he_common">

                        <div class="he_b2p2bx">

                            <div class="he_b2p2ti wow g_fadeup1">

                                <h2 class="he_puclti">方案架构</h2>

                            </div>

                            <div class="he_b2p2ig wow g_fadeup1">

                                <img src="/Public/Uploads/uploadfile/images/gyhlw.png" alt="gyhlw.png">

                            </div>

                        </div>

                    </div>

                </div>                <div class="he_c2p4" yxdatop-pags="4">

                    <div class="he_c2p4n" style="background: url(__TMPL__images/c2pibj.jpg) no-repeat center;background-size:cover">

                        <div class="he_common">

                            <div class="he_c2p4bx">

                                <div class="he_c2p4ti wow g_fadeup1">

                                    <h2 class="he_puclti">应用场景</h2>

                                </div>

                                <div class="he_c2p4tiul wow g_fadeup1">

                                    <div class="he_c2p4tkul clearfix">

                                    <div class="he_c2p4tili act ">

                                            <p>全生命周期管理</p>

                                        </div><div class="he_c2p4tili  ">

                                            <p>3D协同评审</p>

                                        </div><div class="he_c2p4tili  ">

                                            <p>项目协同管理</p>

                                        </div><div class="he_c2p4tili  ">

                                            <p>计划看板</p>

                                        </div><div class="he_c2p4tili  ">

                                            <p>数据中台</p>

                                        </div><div class="he_c2p4tili  ">

                                            <p>远程运维</p>

                                        </div><div class="he_c2p4tili  ">

                                            <p>AR\VR\MR</p>

                                        </div>
                                  

                                    </div>

                                </div>

                                <div class="he_c2p4gl">

                                    <div class="he_c2p4glul">

                                    <div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>全生命周期管理</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>


																									SCIOT以产品结构树为主线，零部件、元器件为核心组织多种产品信息视图，对产品相关数据进行关联管理。机械结构、电子结构在统一的系统进行显示。同时，通过BOM报表视图管理，迅速生成采购、生产所需的各种BOM表。在产品的BOM数据中，可以直接查看到零部件关联的设计文档、元器件的证书、灌装软件等信息。对产品不同阶段，不同技术状态下，需要进行产品数据审批业务可根据企业自身特点定制。 </p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                                <div class="he_xjbtn">
                                                    <div class="g_botton wow g_fadeup1 animated" style="visibility: visible; animation-name: fadeInUp;">
        
                                                              <a href="http://218.245.61.108/scplm/front/X-cache=scplm_1.0.0.1-X/scripts/mainpage.aspx#" class="clearfix">
                                                        
                                                            <div class="g_bottonfl fl">免费体验</div>
                                                        
                                                            <div class="g_bottonfr fr"></div>
                                                        
                                                        </a>
                                                        
                                                        </div>
                                                    </div>

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/1.png" alt="1.png">

                                            </div>

                                        </div><div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>3D协同评审</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>基于3D数据模型可以让不同企业或部门的领导、技术专家、设计师、供应商等人员，随时随地开启远程协同。通过3D可视化打破技术壁垒，参会者可轻松的展示技术交流；通过3D轻量化去除数据保密信息，让产品设计远程评审更安全、可控！
                                                    </p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                                <div class="he_xjbtn">
                                                    <div class="g_botton wow g_fadeup1 animated" style="visibility: visible; animation-name: fadeInUp;">
        
                                                             <a href="http://218.245.61.108/scplm/front/X-cache=scplm_1.0.0.1-X/scripts/mainpage.aspx#" class="clearfix">
                                                        
                                                            <div class="g_bottonfl fl">免费体验</div>
                                                        
                                                            <div class="g_bottonfr fr"></div>
                                                        
                                                        </a>
                                                        
                                                        </div>
                                                    </div>

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/2.png" alt="2.png">

                                            </div>

                                        </div><div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>项目协同管理</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>

																										SCIOT以IPD（集成产品开发）先进的产品开发思想为指导，采用项目驱动产品数据研发管理的技术手段，为企业搭建产品及零部件的协同开发环境和实时项目的信息分享平台，实现电子化、自动化的业务流程，将项目组的业务活动纳入灵活、规范的业务框架内，以确保项目信息的实时、准确与完整。
                                                    	以三维模型为核心，三维设计为基础，轻量化三维模型、智能化二维图纸、业务数据（文档、进度、成本、质量、经验反馈等），实现3D+2D+XD联动，实现多维数据集成。提高数据共享的效率，提升数据的应用价值。 
                                                    </p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                                <div class="he_xjbtn">
                                                    <div class="g_botton wow g_fadeup1 animated" style="visibility: visible; animation-name: fadeInUp;">
        
                                                                <a href="http://218.245.61.108/scplm/front/X-cache=scplm_1.0.0.1-X/scripts/mainpage.aspx#" class="clearfix">
                                                        
                                                            <div class="g_bottonfl fl">免费体验</div>
                                                        
                                                            <div class="g_bottonfr fr"></div>
                                                        
                                                        </a>
                                                        
                                                        </div>
                                                    </div>

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/XMXT.jpg" alt="xmxt.jpg">

                                            </div>

                                        </div><div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>计划看板</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>项目看板：直观展示当前项目整体运行情况，保证管理人员对整体项目的全面把控。 工作台： 下级反馈的项目问题，上级下达的任务命令，其他参建单位需要完成的协同问题，一目了然。轻松完成跨地域、跨时间、跨团队协同工作。
                                                    </p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                                <div class="he_xjbtn">
                                                    <div class="g_botton wow g_fadeup1 animated" style="visibility: visible; animation-name: fadeInUp;">
        
                                                                  <a href="http://218.245.61.108/scplm/front/X-cache=scplm_1.0.0.1-X/scripts/mainpage.aspx#" class="clearfix">
                                                        
                                                            <div class="g_bottonfl fl">免费体验</div>
                                                        
                                                            <div class="g_bottonfr fr"></div>
                                                        
                                                        </a>
                                                        
                                                        </div>
                                                    </div>

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/4.png" alt="4.png">

                                            </div>

                                        </div><div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>数据中台</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>数据中台具备数据汇聚整合、数据提纯加工、数据服务可视化、数据价值变现４个核心能力，让企业员工、客户、伙伴能够方便地应用数据。
                                                    </p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                                <div class="he_xjbtn">
                                                    <div class="g_botton wow g_fadeup1 animated" style="visibility: visible; animation-name: fadeInUp;">
        
                                                                   <a href="http://218.245.61.108/scplm/front/X-cache=scplm_1.0.0.1-X/scripts/mainpage.aspx#" class="clearfix">
                                                            <div class="g_bottonfl fl">免费体验</div>
                                                        
                                                            <div class="g_bottonfr fr"></div>
                                                        
                                                        </a>
                                                        
                                                        </div>
                                                    </div>

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/5.png" alt="5.png">

                                            </div>

                                        </div><div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>远程运维</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>提供相应的接口，供用户接入数据；相应的计算方法和自动模型训练服务；可自定义的图标展示。 （1）预测，即利用装备的历史和当前状态数据，对未来状态进行估计； （2）健康管理，即基于预测式估计对设备进行管理，实现设备的持续可靠运行甚至零宕机。 （3）将大数据AI模型、机理模型、故障知识库深度融合，平台能够精准识别设备故障部件、故障原因、故障等级及改善措施。
                                                    </p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                                <div class="he_xjbtn">
                                                    <div class="g_botton wow g_fadeup1 animated" style="visibility: visible; animation-name: fadeInUp;">
        
                                                           <a href="http://218.245.61.108/scplm/front/X-cache=scplm_1.0.0.1-X/scripts/mainpage.aspx#" class="clearfix">
                                                        
                                                            <div class="g_bottonfl fl">免费体验</div>
                                                        
                                                            <div class="g_bottonfr fr"></div>
                                                        
                                                        </a>
                                                        
                                                        </div>
                                                    </div>

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/6.png" alt="6.png">

                                            </div>

                                        </div><div class="he_c2p4gli clearfix">

                                            <div class="he_c2p4glle fl">

                                                <div class="he_b2p4p1ti wow g_fadeup1">

                                                    <h4>AR\VR\MR</h4>

                                                    <span>CORE</span>

                                                </div>

                                                <div class="he_c2p4glp1 wow g_fadeup1">

                                                    <p>1、提供多个产品线上的AR、VR、MR服务，用户可以直接显示在大屏上打开使用。 2、提供根据用户需求定制的AR、VR、MR的模型制作。 3、提供用户已有产品的轻量化，直接利用SCIOT使用。
                                                    </p>

                                                </div>

                                                <div class="he_c2p4glp2 wow g_fadeup1">

                                                    
                                                </div>
                                                <div class="he_xjbtn">
                                                    <div class="g_botton wow g_fadeup1 animated" style="visibility: visible; animation-name: fadeInUp;">
        
                                                          <a href="http://218.245.61.108/scplm/front/X-cache=scplm_1.0.0.1-X/scripts/mainpage.aspx#" class="clearfix">
                                                        
                                                            <div class="g_bottonfl fl">免费体验</div>
                                                        
                                                            <div class="g_bottonfr fr"></div>
                                                        
                                                        </a>
                                                        
                                                        </div>
                                                    </div>

                                            </div>

                                            <div class="he_c2p4glri fr wow g_fadein1">

                                                <img src="/Public/Uploads/uploadfile/images/7.png" alt="7.png">

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
                        <div class="he_b2p9" yxdatop-pags="6">

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
                
             <div class="he_c2p10" yxdatop-pags="7">

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
                
                 <div class="he_b2p10" yxdatop-pags="8">

                    <div class="he_b2p10bx">

                        <div class="he_common">

                            <div class="he_b2p10l clearfix">

                                <div class="he_b2p10le fl">

                                    <div class="he_b2p10ti wow g_fadeup1">

                                        <h4>选择超云智能</h4>

                                    </div>

                                    <div class="he_b2p10p wow g_fadeup1">

                                        <p>开启您的智能制造模式 ，加速企业数字化转型</p>

                                    </div>

                                </div>

                                <div class="he_b2p10ri fl wow g_fadeup1">

                                    <a href="http://218.245.61.108/scplm/front/X-cache=scplm_1.0.0.1-X/scripts/mainpage.aspx#" class="clearfix">

                                        <div class="g_bottonfl fl">免费体验</div>

                                        <div class="g_bottonfr fr">

                                        </div>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="he_b2p10ig wow g_fadein1">

                        <img src="/Public/Uploads/uploadfile/images/6066d21875c18.jpg" alt="6066d21875c18.jpg">

                    </div>

                </div>            </div>

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