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
                    <img src="/Public/Uploads/uploadfile/images/B2jiandanchanpin-398.jpg" alt="B2jiandanchanpin-398.jpg" class="he_banpc">
                    <img src="/Public/Uploads/uploadfile/images/B2jiandanchanpinph-344.jpg" alt="B2jiandanchanpinph-344.jpg" class="he_banph">
                </div>
                <div class="he_bante he_common">
                    <div class="he_bantepy">
                        <div class="he_bantep2t">
						<h1>
                            <p>工艺设计与管理系统PPS</p>
						</h1>
                        </div>
                        <div class="he_bantep3v">
                            <p>超云智能PPS集成化工艺设计与管理系统，实现对工艺数据的集中管控，建立企业工艺资源库，工艺设计时快速查询调用，实现工艺设计资源共享。</p>
                        </div>
                        <div class="he_bantemo clearfix">
                            <div class="he_bantemoli he_bantemoli1 fl">
                                <a href="javascript:;" class="clearfix">
                                    <div class="g_bottonfl fl">免费体验</div>
                                    <div class="g_bottonfr fr">
                                        <img src="__TMPL__images/baneric01.png">
                                    </div>
                                </a>
                            </div>
                            <div class="he_bantemoli he_bantemoli1 fl">
                                <a href="/application" class="clearfix">
                                    <div class="g_bottonfl fl">产品演示</div>
                                    <div class="g_bottonfr fr">
                                        <img src="__TMPL__images/baneric02.png">
                                    </div>
                                </a>
                            </div>
                        </div>
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

                        <a href="javascript:;" id="ids1">PPS产品概述</a>
					</h2>
                    </div>                    <div class="he_plnavli">
					<h2>
                        <a href="javascript:;" id="ids2">PPS产品架构</a>
					</h2>
                    </div>                    <div class="he_plnavli">
					<h2>
                        <a href="javascript:;" id="ids3">PPS产品优势</a>
					</h2>
                    </div>                    <div class="he_plnavli">
					<h2>
                        <a href="javascript:;" id="ids4">PPS产品功能</a>
					</h2>
                    </div>                                        <div class="he_plnavli">
					<h2>
                        <a href="javascript:;" id="ids6">PPS应用价值</a>
					</h2>
                    </div>                    <div class="he_plnavli">
					<h2>
                        <a href="javascript:;" id="ids7">客户案例</a>
					</h2>
                    </div>                </div>

            </div>

            <!-- 内容区 -->

            <div class="he_nybx">
                <div class="he_b2p1" yxdatop-pags="1">

                    <div class="he_common">

                        <div class="he_b2p1bx">

                            <div class="he_bap1ti">

                                <h2 class="he_puclti">PPS产品概述</h2>

                            </div>

                            <div class="he_bap1tp">

                                <p><span style="">超云智能<span style="">PPS<span style="">是“以产品数据为基础、交互式设计为手段、工艺知识库为核心、实现企业信息集成为目标，面向产品的工艺设计与管理”的应用模式，规范企业的工艺流程，提高工艺设计效率及规范性，提升工艺管理水平。</span></span></span></p><p><br/></p>
                            </div>

                        </div>

                    </div>

                </div>           
                
                     <div class="he_b2p2" yxdatop-pags="2">

                    <div class="he_common">

                        <div class="he_b2p2bx">

                            <div class="he_b2p2ti">

                                <h2 class="he_puclti">PPS产品架构</h2>

                            </div>

                            <div class="he_b2p2ig">

                                <img src="/Public/Uploads/uploadfile/images/64c9c7d4b2868.png" alt="cappjiagoutu.png">

                            </div>

                        </div>

                    </div>

                </div>              
                
                  <div class="he_b2p3" yxdatop-pags="3">

                    <div class="he_common">

                        <div class="he_b2p3p1">

                            <div class="he_b2p3ti">

                                <h2 class="he_puclti">PPS产品优势</h2>

                            </div>

                            <div class="he_b2p3ul clearfix">

                                <div class="he_b2p3li fl">

                                        <div class="he_b2p3lin">

                                            <div class="he_b2p3lig">

                                                <img src="__TMPL__images/b2flo01.png" class="he_img">

                                                <img src="/Public/Uploads/uploadfile/images/64c9c7d4b2e76.svg" class="he_img1">

                                            </div>

                                            <div class="he_b2p3te">

                                                <div class="he_b2p3tep1 clearfix">

                                                    <div class="he_b2p3p1le fl">

                                                        <img src="__TMPL__images/b2ic_01.png">

                                                    </div>

                                                    <div class="he_b2p3p1ri fl">

                                                        <p>BS架构</p>

                                                    </div>

                                                </div>

                                                <div class="he_b2p3tep2">

                                                    <p>技术先进，超云智能PPS系统BS架构模式操作体验更佳。</p>

                                                </div>

                                            </div>

                                        </div>

                                    </div><div class="he_b2p3li fl">

                                        <div class="he_b2p3lin">

                                            <div class="he_b2p3lig">

                                                <img src="__TMPL__images/b2flo01.png" class="he_img">

                                                <img src="/Public/Uploads/uploadfile/images/64c9c7d4b344f.svg" class="he_img1">

                                            </div>

                                            <div class="he_b2p3te">

                                                <div class="he_b2p3tep1 clearfix">

                                                    <div class="he_b2p3p1le fl">

                                                        <img src="__TMPL__images/b2ic_01.png">

                                                    </div>

                                                    <div class="he_b2p3p1ri fl">

                                                        <p>产品易扩展</p>

                                                    </div>

                                                </div>

                                                <div class="he_b2p3tep2">

                                                    <p>PPS系统支持卡片工艺、结构化工艺、三维工艺等多种工艺。</p>

                                                </div>

                                            </div>

                                        </div>

                                    </div><div class="he_b2p3li fl">

                                        <div class="he_b2p3lin">

                                            <div class="he_b2p3lig">

                                                <img src="__TMPL__images/b2flo01.png" class="he_img">

                                                <img src="/Public/Uploads/uploadfile/images/64c9c7d4b3bab.svg" class="he_img1">

                                            </div>

                                            <div class="he_b2p3te">

                                                <div class="he_b2p3tep1 clearfix">

                                                    <div class="he_b2p3p1le fl">

                                                        <img src="__TMPL__images/b2ic_01.png">

                                                    </div>

                                                    <div class="he_b2p3p1ri fl">

                                                        <p>系统集成性强</p>

                                                    </div>

                                                </div>

                                                <div class="he_b2p3tep2">

                                                    <p>超云智能PPS系统完全满足主流PDM和ERP/MES的集成应用，实现数据流的打通。</p>

                                                </div>

                                            </div>

                                        </div>

                                    </div><div class="he_b2p3li fl">

                                        <div class="he_b2p3lin">

                                            <div class="he_b2p3lig">

                                                <img src="__TMPL__images/b2flo01.png" class="he_img">

                                                <img src="/Public/Uploads/uploadfile/images/64c9c7d4b41d1.svg" class="he_img1">

                                            </div>

                                            <div class="he_b2p3te">

                                                <div class="he_b2p3tep1 clearfix">

                                                    <div class="he_b2p3p1le fl">

                                                        <img src="__TMPL__images/b2ic_01.png">

                                                    </div>

                                                    <div class="he_b2p3p1ri fl">

                                                        <p>丰富的行业经验</p>

                                                    </div>

                                                </div>

                                                <div class="he_b2p3tep2">

                                                    <p>拥有多个行业成功实施经验，提供全面支持服务，专业的技术团队，丰富的项目管理能力。</p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                            </div>

                        </div>

                    </div>

                </div>                                 
                
                   <div class="he_b2p4" yxdatop-pags="4" >
                            <div class="he_common">
                                <div class="he_b2p4bx">
                                <div class="he_b2p4ti">
                                        <h2 class="he_puclti">PPS产品功能</h2>
                                    </div>                                    <div class="he_b2p4p1 he_b2p4p2 clearfix">
                                        <div class="he_b2p4p1ri fr">
                                            <img class="new_ueditor_box_img" src="/Public/Uploads/uploadfile/images/64c9c7d4bcbe5.png" alt="PPS.png"/>
                                    </div>
                                    <div class="he_b2p4p1le fl">
                                        <div class="1">
                                            <div class="he_b2p4p1ti">
                                                <h4>
                                                    工艺BOM管理                                                </h4><span>TRAIT </span>
                                            </div>
                                            <div class="he_b2p4p1tp">
                                                <p>超云智能PPS系统支持BOM的多视图的管理，支持设计BOM---工艺BOM---制造BOM和转换。在工艺BOM上可方便进行合件、拆分件的快速维护。</p>                                            </div>
                                            <div class="he_xjbtn">
                                                <div class="g_botton">
    
                                                    <a href="http://218.245.61.108/scplm/pps/default.aspx" class="clearfix">
                                                    
                                                        <div class="g_bottonfl fl">免费体验</div>
                                                    
                                                        <div class="g_bottonfr fr"></div>
                                                    
                                                    </a>
                                                    
                                                    </div>
                                                </div>
                                        </div>

                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                            
                          <div class="he_b2p5">
                            <div class="he_common">
                                <div class="he_b2p4bx">
                                    <div class="he_b2p4p1 clearfix">
                                        <div class="he_b2p4p1ri fr">
                                                <img class="new_ueditor_box_img" src="/Public/Uploads/uploadfile/images/64c9c7d4bd6f9.png" alt="capp2.png"/>
                                        </div>
                                        <div class="he_b2p4p1le fl">
                                            <div class="">
                                                <div class="he_b2p4p1ti">
                                                    <h4>
                                                        工艺路线管理                                                    </h4><span>TRAIT</span>
                                                </div>
                                                <div class="he_b2p4p1tp">
                                                    <p>PPS系统通过工艺路线单元库、典型工艺路线库等多种方式，实现工艺路线的快速维护。支持两级工艺路线、相对路径和全路径的记录；支持多工艺路线编辑。</p>                                                </div>
                                            </div>
                                            <div class="he_xjbtn">
                                                <div class="g_botton">
    
                                                    <a href="http://218.245.61.108/scplm/pps/default.aspx" class="clearfix">
                                                    
                                                        <div class="g_bottonfl fl">免费体验</div>
                                                    
                                                        <div class="g_bottonfr fr"></div>
                                                    
                                                    </a>
                                                    
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
               

                <div class="he_b2p6">

                    <div class="he_common">

                        <div class="he_b2p6bx">

                            <div class="he_b2p6ul">

                            <div class="he_b2p6li act ">

                                    <p>工艺任务管理</p>

                                </div><div class="he_b2p6li  ">

                                    <p>工艺资源管理</p>

                                </div><div class="he_b2p6li  ">

                                    <p>工装管理</p>

                                </div><div class="he_b2p6li  ">

                                    <p>工艺卡片编辑</p>

                                </div><div class="he_b2p6li  ">

                                    <p>16949体系</p>

                                </div><div class="he_b2p6li  ">

                                    <p>工艺汇总</p>

                                </div><div class="he_b2p6li  ">

                                    <p>结构化工艺</p>

                                </div><div class="he_b2p6li  ">

                                    <p>三维工艺</p>

                                </div><div class="he_b2p6li  ">

                                    <p>系统集成</p>

                                </div>
                            </div>

                            <div class="he_b2p6bswh">

                            <div class="he_b2p6bsli clearfix">

                                    <div class="he_b2p6svri fr">

                                        <img src="/Public/Uploads/uploadfile/images/64c9c7d4b4cdb.png" alt="3.png">

                                    </div>

                                    <div class="he_b2p6svle fl">

                                        <div class="he_b2p4p1ti">

                                            <h4>工艺任务管理</h4>

                                            <span>TRAIT</span>

                                        </div>

                                        <div class="he_b2p4p1tp">

                                            <p> 超云智能PPS系统支持根据工艺类型进行工艺任务的创建和下发，方便工艺人员进行工艺任务的接收和对应工艺设计工作的开展。支持手动分派工艺任务；基于模板的标准工艺任务分派；批量创建工艺任务。
                                            </p>

                                        </div>
                                        <div class="he_xjbtn">
                                            <div class="g_botton">

                                                <a href="http://218.245.61.108/scplm/pps/default.aspx" class="clearfix">
                                                
                                                    <div class="g_bottonfl fl">免费体验</div>
                                                
                                                    <div class="g_bottonfr fr"></div>
                                                
                                                </a>
                                                
                                                </div>
                                            </div>

                                    </div>

                                </div><div class="he_b2p6bsli clearfix">

                                    <div class="he_b2p6svri fr">

                                        <img src="/Public/Uploads/uploadfile/images/64c9c7d4b5871.png" alt="4.png">

                                    </div>

                                    <div class="he_b2p6svle fl">

                                        <div class="he_b2p4p1ti">

                                            <h4>工艺资源管理</h4>

                                            <span>TRAIT</span>

                                        </div>

                                        <div class="he_b2p4p1tp">

                                            <p>PPS支持工艺资源库管理，形成企业的工艺知识库。支持工艺卡片与工艺资源库的关联填写。
                                            </p>

                                        </div>
                                        <div class="he_xjbtn">
                                            <div class="g_botton">

                                                <a href="http://218.245.61.108/scplm/pps/default.aspx" class="clearfix">
                                                
                                                    <div class="g_bottonfl fl">免费体验</div>
                                                
                                                    <div class="g_bottonfr fr"></div>
                                                
                                                </a>
                                                
                                                </div>
                                            </div>

                                    </div>

                                </div><div class="he_b2p6bsli clearfix">

                                    <div class="he_b2p6svri fr">

                                        <img src="/Public/Uploads/uploadfile/images/64c9c7d4b6442.png" alt="5.png">

                                    </div>

                                    <div class="he_b2p6svle fl">

                                        <div class="he_b2p4p1ti">

                                            <h4>工装管理</h4>

                                            <span>TRAIT</span>

                                        </div>

                                        <div class="he_b2p4p1tp">

                                            <p> PPS系统能够管理从工装申请，到工装入库的全过程，还能管理工装的使用记录及寿命。支持工装模具全生命周期的管理。
                                            </p>

                                        </div>
                                        <div class="he_xjbtn">
                                            <div class="g_botton">

                                                <a href="http://218.245.61.108/scplm/pps/default.aspx" class="clearfix">
                                                
                                                    <div class="g_bottonfl fl">免费体验</div>
                                                
                                                    <div class="g_bottonfr fr"></div>
                                                
                                                </a>
                                                
                                                </div>
                                            </div>

                                    </div>

                                </div><div class="he_b2p6bsli clearfix">

                                    <div class="he_b2p6svri fr">

                                        <img src="/Public/Uploads/uploadfile/images/64c9c7d4b6fe6.png" alt="6.png">

                                    </div>

                                    <div class="he_b2p6svle fl">

                                        <div class="he_b2p4p1ti">

                                            <h4>工艺卡片编辑</h4>

                                            <span>TRAIT</span>

                                        </div>

                                        <div class="he_b2p4p1tp">

                                            <p>超云智能PPS系统内置可视化、Excel风格的工艺卡片模板配置环境。支持将Excel格式的工艺卡片导入，快速形成卡片模板。支持多种方式创建工艺卡片。“所见即所得”的编辑环境。支持各种图片、附图、二维图形、三维数模等对象的插入。
                                            </p>

                                        </div>
                                        <div class="he_xjbtn">
                                            <div class="g_botton">

                                                <a href="http://218.245.61.108/scplm/pps/default.aspx" class="clearfix">
                                                
                                                    <div class="g_bottonfl fl">免费体验</div>
                                                
                                                    <div class="g_bottonfr fr"></div>
                                                
                                                </a>
                                                
                                                </div>
                                            </div>

                                    </div>

                                </div><div class="he_b2p6bsli clearfix">

                                    <div class="he_b2p6svri fr">

                                        <img src="/Public/Uploads/uploadfile/images/64c9c7d4b7c3e.png" alt="7.png">

                                    </div>

                                    <div class="he_b2p6svle fl">

                                        <div class="he_b2p4p1ti">

                                            <h4>16949体系</h4>

                                            <span>TRAIT</span>

                                        </div>

                                        <div class="he_b2p4p1tp">

                                            <p>超云智能PPS系统支持16949体系文件的关联生成和关联修改，减少编制过程中大量的重复工作和提高准确率。
                                            </p>

                                        </div>
                                        <div class="he_xjbtn">
                                            <div class="g_botton">

                                                <a href="http://218.245.61.108/scplm/pps/default.aspx" class="clearfix">
                                                
                                                    <div class="g_bottonfl fl">免费体验</div>
                                                
                                                    <div class="g_bottonfr fr"></div>
                                                
                                                </a>
                                                
                                                </div>
                                            </div>

                                    </div>

                                </div><div class="he_b2p6bsli clearfix">

                                    <div class="he_b2p6svri fr">

                                        <img src="/Public/Uploads/uploadfile/images/64c9c7d4b87d3.png" alt="9.png">

                                    </div>

                                    <div class="he_b2p6svle fl">

                                        <div class="he_b2p4p1ti">

                                            <h4>工艺汇总</h4>

                                            <span>TRAIT</span>

                                        </div>

                                        <div class="he_b2p4p1tp">

                                            <p>超云智能PPS系统支持定义工时、设备、材料、工装等汇总公式。系统自动生成各种明细表，提供准确工艺数据信息。PPS支持创建即完成的生成方式。
                                            </p>

                                        </div>
                                        <div class="he_xjbtn">
                                            <div class="g_botton">

                                                <a href="http://218.245.61.108/scplm/pps/default.aspx" class="clearfix">
                                                
                                                    <div class="g_bottonfl fl">免费体验</div>
                                                
                                                    <div class="g_bottonfr fr"></div>
                                                
                                                </a>
                                                
                                                </div>
                                            </div>

                                    </div>

                                </div><div class="he_b2p6bsli clearfix">

                                    <div class="he_b2p6svri fr">

                                        <img src="/Public/Uploads/uploadfile/images/64c9c7d4b902b.png" alt="undefined">

                                    </div>

                                    <div class="he_b2p6svle fl">

                                        <div class="he_b2p4p1ti">

                                            <h4>结构化工艺</h4>

                                            <span>TRAIT</span>

                                        </div>

                                        <div class="he_b2p4p1tp">

                                            <p>超云智能PPS系统结构化工艺功能模块，实现产品、工艺、工厂和资源（P3R）的有机关联，减少工艺数据的冗余，促进工艺数据的重用，提升工艺过程开发效率，同时保证了制造数据的准确性、一致性和有效性。
                                            </p>

                                        </div>
                                        <div class="he_xjbtn">
                                            <div class="g_botton">

                                                <a href="http://218.245.61.108/scplm/pps/default.aspx" class="clearfix">
                                                
                                                    <div class="g_bottonfl fl">免费体验</div>
                                                
                                                    <div class="g_bottonfr fr"></div>
                                                
                                                </a>
                                                
                                                </div>
                                            </div>

                                    </div>

                                </div><div class="he_b2p6bsli clearfix">

                                    <div class="he_b2p6svri fr">

                                        <img src="/Public/Uploads/uploadfile/images/64c9c7d4b9e70.png" alt="10.png">

                                    </div>

                                    <div class="he_b2p6svle fl">

                                        <div class="he_b2p4p1ti">

                                            <h4>三维工艺</h4>

                                            <span>TRAIT</span>

                                        </div>

                                        <div class="he_b2p4p1tp">

                                            <p>超云智能三维工艺设计模块以三维数模为对象，并在其基础上，根据企业实际机加、装配路线、产品零部件的工艺性原则，调整产品的装配结构，用户根据产品的三维数模，可视化的规划装配过程，同时进行可视化工序组件分配（工序的装入件清单），调用装配过程中的工装资源，然后在虚拟环境中模拟仿真产品的装配过程、工装资源的操作过程，验证产品的可装配性、工装资源的可达性等，最后输出可视化的装配仿真文件等。
                                            </p>

                                        </div>
                                        <div class="he_xjbtn">
                                            <div class="g_botton">

                                                <a href="javascript:;" class="clearfix">
                                                
                                                    <div class="g_bottonfl fl">免费体验</div>
                                                
                                                    <div class="g_bottonfr fr"></div>
                                                
                                                </a>
                                                
                                                </div>
                                            </div>

                                    </div>

                                </div><div class="he_b2p6bsli clearfix">

                                    <div class="he_b2p6svri fr">

                                        <img src="/Public/Uploads/uploadfile/images/64c9c7d4ba9f9.png" alt="12.png">

                                    </div>

                                    <div class="he_b2p6svle fl">

                                        <div class="he_b2p4p1ti">

                                            <h4>系统集成</h4>

                                            <span>TRAIT</span>

                                        </div>

                                        <div class="he_b2p4p1tp">

                                            <p>提供标准的系统接口，支持通过系统集成的方式，进行设计---工艺---制造数据的打通。
                                            </p>

                                        </div>
                                        <div class="he_xjbtn">
                                            <div class="g_botton">

                                                <a href="javascript:;" class="clearfix">
                                                
                                                    <div class="g_bottonfl fl">免费体验</div>
                                                
                                                    <div class="g_bottonfr fr"></div>
                                                
                                                </a>
                                                
                                                </div>
                                            </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>               
              
                           
                  <div class="he_b2p8"  yxdatop-pags="6">

                    <div class="he_common">

                        <div class="he_b2p8bx">

                            <div class="he_b2p8ti">

                                <h2 class="he_puclti">PPS应用价值</h2>

                            </div>

                            <div class="he_b2p8bp">

                                <div class="he_b2p8ul clearfix">

                                <div class="he_b2p8li fl">

                                        <div class="he_b2p8ubx clearfix">

                                            <div class="he_b2p8ule fl">

                                                <img src="__TMPL__images/hutpng.png" class="he_img">

                                                <img src="/Public/Uploads/uploadfile/images/64c9c7d4baf05.svg" alt="yingyongjiazhi-suoduanchanpinjiaofuzhouqi.svg" class="he_img1">

                                            </div>

                                            <div class="he_b2p8uri fl">

                                                <div class="he_b2p3te">

                                                    <div class="he_b2p3tep1 clearfix">

                                                        <div class="he_b2p3p1le fl">

                                                            <img src="__TMPL__images/b2ic_01.png">

                                                        </div>

                                                        <div class="he_b2p3p1ri fl">

                                                            <p>缩短产品交付周期40%</p>

                                                        </div>

                                                    </div>

                                                    <div class="he_b2p3tep2">

                                                        <p>超云智能PPS系统提高工艺设计效率，减少重复劳动。</p>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div><div class="he_b2p8li fl">

                                        <div class="he_b2p8ubx clearfix">

                                            <div class="he_b2p8ule fl">

                                                <img src="__TMPL__images/hutpng.png" class="he_img">

                                                <img src="/Public/Uploads/uploadfile/images/64c9c7d4bb4f7.svg" alt="yingyongjiazhi-jiangdiyanfachengben.svg" class="he_img1">

                                            </div>

                                            <div class="he_b2p8uri fl">

                                                <div class="he_b2p3te">

                                                    <div class="he_b2p3tep1 clearfix">

                                                        <div class="he_b2p3p1le fl">

                                                            <img src="__TMPL__images/b2ic_01.png">

                                                        </div>

                                                        <div class="he_b2p3p1ri fl">

                                                            <p>降低生产成本40%</p>

                                                        </div>

                                                    </div>

                                                    <div class="he_b2p3tep2">

                                                        <p>PPS提高工艺规范性，减少工艺不合理带来的返工。</p>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div><div class="he_b2p8li fl">

                                        <div class="he_b2p8ubx clearfix">

                                            <div class="he_b2p8ule fl">

                                                <img src="__TMPL__images/hutpng.png" class="he_img">

                                                <img src="/Public/Uploads/uploadfile/images/64c9c7d4bbadf.svg" alt="yingyongjiazhi-jiangdigoutongchengben.svg" class="he_img1">

                                            </div>

                                            <div class="he_b2p8uri fl">

                                                <div class="he_b2p3te">

                                                    <div class="he_b2p3tep1 clearfix">

                                                        <div class="he_b2p3p1le fl">

                                                            <img src="__TMPL__images/b2ic_01.png">

                                                        </div>

                                                        <div class="he_b2p3p1ri fl">

                                                            <p>降低沟通成本75%</p>

                                                        </div>

                                                    </div>

                                                    <div class="he_b2p3tep2">

                                                        <p>PPS跨部门信息共享，实现无纸化办公。</p>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div><div class="he_b2p8li fl">

                                        <div class="he_b2p8ubx clearfix">

                                            <div class="he_b2p8ule fl">

                                                <img src="__TMPL__images/hutpng.png" class="he_img">

                                                <img src="/Public/Uploads/uploadfile/images/64c9c7d4bc0cf.svg" alt="yingyongjiazhi-guifangongyisheji.svg" class="he_img1">

                                            </div>

                                            <div class="he_b2p8uri fl">

                                                <div class="he_b2p3te">

                                                    <div class="he_b2p3tep1 clearfix">

                                                        <div class="he_b2p3p1le fl">

                                                            <img src="__TMPL__images/b2ic_01.png">

                                                        </div>

                                                        <div class="he_b2p3p1ri fl">

                                                            <p>规范工艺设计</p>

                                                        </div>

                                                    </div>

                                                    <div class="he_b2p3tep2">

                                                        <p>规范工艺设计，提高工艺设计水平，进一步提升产品质量和市场竞争力。</p>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>               
                
                <div class="he_b2p9" yxdatop-pags="7">

                    <div class="he_common">

                        <div class="he_b2p9bx">

                            <div class="he_b2p9ti">

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
                  <div class="he_b2p10">

                    <div class="he_b2p10bx">

                        <div class="he_common">

                            <div class="he_b2p10l clearfix">

                                <div class="he_b2p10le fl">

                                    <div class="he_b2p10ti">

                                        <h4>选择超云智能</h4>

                                    </div>

                                    <div class="he_b2p10p">

                                        <p>开启您的智能制造模式 ，加速企业数字化转型</p>

                                    </div>

                                </div>

                                <div class="he_b2p10ri fr">

	                                    <a href="http://218.245.61.108/scplm/front/X-cache=scplm_1.0.0.1-X/scripts/mainpage.aspx#" class="clearfix">

	                                        <div class="g_bottonfl fl">免费体验</div>

	                                        <div class="g_bottonfr fr">

	                                        </div>

	                                    </a>

	                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="he_b2p10ig">

                        <img src="__TMPL__images/b2bgt.jpg">

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