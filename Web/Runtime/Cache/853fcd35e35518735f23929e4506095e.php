<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="超云智能（SCIOT)" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="format-detection" content="telephone=no, email=no" />
    <meta name="renderer" content="webkit">
    <title><neq name="title" value=""><?php echo ($title); ?>-</neq><?php echo ($config["sitetitle"]); ?>-<?php echo ($config["sitetitle2"]); ?></title>
    <meta name="keywords" content="PLM,MES,QMS,数字员工,工业软件,智能制造"/>
    <meta name="description" content="超云智能专注于工业软件领域，提供PLM、MES、QMS等智能制造解决方案和数字员工服务，助力企业数字化转型升级。"/>
    <link rel="stylesheet" href="/Web/Tpl/arena/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="/Web/Tpl/arena/css/animate.min.css" type="text/css" rel="stylesheet" />
    <link href="/Web/Tpl/arena/css/iconfont.css" type="text/css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/Web/Tpl/arena/js/wow.min.js"></script>
    <script src="/Web/Tpl/arena/js/main.js"></script>
</head>
<body>
    <!-- 头部导航 -->
    

    

    <!-- 核心产品 -->
    <div id="products" class="he_products">
        <div class="he_common">
            <div class="text-center wow g_fadein1 mb-8">
                <h2>核心产品</h2>
                <p>专注于工业软件领域，为制造企业提供全方位的数字化解决方案，助力企业实现智能制造转型</p>
            </div>
            
            <div class="row">
                <!-- PLM产品生命周期管理 -->
                <div class="col-md-3 col-sm-6 wow g_fadein1" data-wow-delay="0.1s">
                    <div class="product-card text-center">
                        <div class="product-icon bg-primary text-white">
                            <img src="/Web/Tpl/arena/images/plm.png" alt="PLM" style="width: 50px; height: 50px;" />
                        </div>
                        <h3>PLM产品生命周期管理</h3>
                        <p>全面管理产品从概念到退役的整个生命周期，提高研发效率，降低成本，加速产品创新</p>
                        <a href="/plm.html" class="btn">了解详情</a>
                    </div>
                </div>
                
                <!-- MES制造执行系统 -->
                <div class="col-md-3 col-sm-6 wow g_fadein1" data-wow-delay="0.2s">
                    <div class="product-card text-center">
                        <div class="product-icon bg-success text-white">
                            <img src="/Web/Tpl/arena/images/mes.png" alt="MES" style="width: 50px; height: 50px;" />
                        </div>
                        <h3>MES制造执行系统</h3>
                        <p>实时监控生产过程，优化生产调度，提高生产效率和产品质量，实现生产数字化管理</p>
                        <a href="/mes.html" class="btn">了解详情</a>
                    </div>
                </div>
                
                <!-- QMS质量管理系统 -->
                <div class="col-md-3 col-sm-6 wow g_fadein1" data-wow-delay="0.3s">
                    <div class="product-card text-center">
                        <div class="product-icon bg-warning text-white">
                            <img src="/Web/Tpl/arena/images/qms.png" alt="QMS" style="width: 50px; height: 50px;" />
                        </div>
                        <h3>QMS质量管理系统</h3>
                        <p>规范质量管理流程，确保产品符合标准，提高客户满意度，实现质量追溯和合规管理</p>
                        <a href="/qms.html" class="btn">了解详情</a>
                    </div>
                </div>
                
                <!-- 数字员工 -->
                <div class="col-md-3 col-sm-6 wow g_fadein1" data-wow-delay="0.4s">
                    <div class="product-card text-center">
                        <div class="product-icon bg-purple text-white">
                            <img src="/Web/Tpl/arena/images/digital_employee.png" alt="数字员工" style="width: 50px; height: 50px;" />
                        </div>
                        <h3>数字员工</h3>
                        <p>自动化处理重复性工作，提高工作效率，降低人力成本，释放员工创造力</p>
                        <a href="/digital_employee.html" class="btn">了解详情</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 解决方案 -->
    <div id="solutions" class="he_soluti">
        <div class="he_common">
            <div class="text-center wow g_fadein1 mb-8">
                <h2>行业解决方案</h2>
                <p>针对不同行业的特点，提供定制化的智能制造解决方案，满足各行业的特定需求</p>
            </div>
            
            <div class="row">
                <!-- 汽车制造 -->
                <div class="col-md-4 wow g_fadein1" data-wow-delay="0.1s">
                    <div class="solution-card">
                        <div class="solution-icon bg-primary text-white">
                            <i class="iconfont icon-car" style="font-size: 40px;"></i>
                        </div>
                        <h3>汽车制造</h3>
                        <p>整合PLM、MES、QMS系统，实现汽车产品全生命周期管理，提高生产效率和产品质量，加速新产品上市</p>
                        <a href="/solution/automotive.html" class="read-more text-primary">查看详情 <i class="iconfont icon-right" style="margin-left: 8px; font-size: 18px;"></i></a>
                    </div>
                </div>
                
                <!-- 电子电器 -->
                <div class="col-md-4 wow g_fadein1" data-wow-delay="0.2s">
                    <div class="solution-card">
                        <div class="solution-icon bg-success text-white">
                            <i class="iconfont icon-electronics" style="font-size: 40px;"></i>
                        </div>
                        <h3>电子电器</h3>
                        <p>通过数字化解决方案，实现电子电器产品的快速研发和高质量生产，提升市场竞争力，满足快速变化的市场需求</p>
                        <a href="/solution/electronics.html" class="read-more text-success">查看详情 <i class="iconfont icon-right" style="margin-left: 8px; font-size: 18px;"></i></a>
                    </div>
                </div>
                
                <!-- 医疗器械 -->
                <div class="col-md-4 wow g_fadein1" data-wow-delay="0.3s">
                    <div class="solution-card">
                        <div class="solution-icon bg-warning text-white">
                            <i class="iconfont icon-medical" style="font-size: 40px;"></i>
                        </div>
                        <h3>医疗器械</h3>
                        <p>符合医疗器械行业法规要求，实现产品全流程追溯和质量管理，确保产品安全可靠，加速产品上市</p>
                        <a href="/solution/medical.html" class="read-more text-warning">查看详情 <i class="iconfont icon-right" style="margin-left: 8px; font-size: 18px;"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 客户案例 -->
    <div id="cases" class="he_case">
        <div class="he_common">
            <div class="text-center wow g_fadein1 mb-8">
                <h2>客户案例</h2>
                <p>我们为众多企业提供了数字化解决方案，帮助他们实现智能制造转型，提升企业竞争力</p>
            </div>
            
            <div class="row">
                <div class="col-md-4 wow g_fadein1" data-wow-delay="0.1s">
                    <div class="case-card">
                        <div class="case-img">
                            <img src="/Web/Tpl/arena/images/case1.jpg" alt="案例1">
                        </div>
                        <div class="case-content">
                            <h3>某汽车制造商PLM实施</h3>
                            <p>通过实施PLM系统，实现了产品研发流程的标准化和数字化，研发周期缩短30%，成本降低20%</p>
                            <a href="/case/automotive-plm.html" class="read-more">查看详情 <i class="iconfont icon-right" style="margin-left: 5px;"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 wow g_fadein1" data-wow-delay="0.2s">
                    <div class="case-card">
                        <div class="case-img">
                            <img src="/Web/Tpl/arena/images/case2.jpg" alt="案例2">
                        </div>
                        <div class="case-content">
                            <h3>电子企业MES系统部署</h3>
                            <p>部署MES系统后，生产效率提高40%，产品不良率降低50%，实现了生产过程的实时监控和管理</p>
                            <a href="/case/electronics-mes.html" class="read-more">查看详情 <i class="iconfont icon-right" style="margin-left: 5px;"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 wow g_fadein1" data-wow-delay="0.3s">
                    <div class="case-card">
                        <div class="case-img">
                            <img src="/Web/Tpl/arena/images/case3.jpg" alt="案例3">
                        </div>
                        <div class="case-content">
                            <h3>医疗器械QMS实施</h3>
                            <p>通过QMS系统的实施，实现了质量管理的标准化和合规性，顺利通过FDA和CE认证</p>
                            <a href="/case/medical-qms.html" class="read-more">查看详情 <i class="iconfont icon-right" style="margin-left: 5px;"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 关于我们 -->
    <div id="about" class="he_about">
        <div class="he_common">
            <div class="row">
                <div class="col-md-6 wow g_fadein1">
                    <div class="about-img">
                        <img src="/Web/Tpl/arena/images/about.jpg" alt="关于我们" />
                    </div>
                </div>
                <div class="col-md-6 wow g_fadein1" data-wow-delay="0.2s">
                    <div class="about-content">
                        <h2>关于我们</h2>
                        <p>超云智能科技（深圳）有限公司是一家专注于工业软件领域的高科技企业，致力于为客户提供智能化解决方案和产品。</p>
                        <p>我们拥有一支专业的研发团队，不断创新，为客户创造价值。公司核心产品包括PLM产品生命周期管理、MES制造执行系统、QMS质量管理系统和数字员工等，为制造企业提供全方位的数字化解决方案。</p>
                        <a href="/about.html" class="btn">了解更多</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 新闻动态 -->
    <div id="news" class="he_news">
        <div class="he_common">
            <div class="text-center wow g_fadein1 mb-8">
                <h2>新闻动态</h2>
                <p>了解最新行业资讯和公司动态</p>
            </div>
            
            <div class="row">
                <arclist model="article" where="status=1 AND typeid=4" order="addtime desc" id="vo" limit="3">
                    <div class="col-md-4 wow g_fadein1" data-wow-delay="0.1s">
                        <div class="news-card">
                            <div class="news-img">
                                <img src="__PUBLIC__/Uploads/<?php echo ($vo["pic"]); ?>" alt="<?php echo ($vo["title"]); ?>">
                            </div>
                            <div class="news-content">
                                <div class="news-date"><?php echo (date('Y-m-d',$vo["addtime"])); ?></div>
                                <h3><?php echo ($vo["title"]); ?></h3>
                                <p><?php echo ($vo["description"]); ?></p>
                                <a href="<?php echo (url(show,$vo["id"])); ?>" class="read-more">阅读全文 <i class="iconfont icon-right" style="margin-left: 5px;"></i></a>
                            </div>
                        </div>
                    </div>
                </arclist>
            </div>
        </div>
    </div>

    <!-- 联系我们 -->
    <div id="contact" class="he_contact">
        <div class="he_common">
            <div class="text-center wow g_fadein1 mb-8">
                <h2>联系我们</h2>
                <p>如有任何疑问，欢迎随时联系我们</p>
            </div>
            
            <div class="row">
                <div class="col-md-4 wow g_fadein1" data-wow-delay="0.1s">
                    <div class="contact-card">
                        <div class="contact-icon bg-primary text-white">
                            <i class="iconfont icon-phone" style="font-size: 24px;"></i>
                        </div>
                        <h3>联系电话</h3>
                        <p><?php echo ($config["phone"]); ?></p>
                    </div>
                </div>
                
                <div class="col-md-4 wow g_fadein1" data-wow-delay="0.2s">
                    <div class="contact-card">
                        <div class="contact-icon bg-success text-white">
                            <i class="iconfont icon-email" style="font-size: 24px;"></i>
                        </div>
                        <h3>邮箱地址</h3>
                        <p><?php echo ($config["email"]); ?></p>
                    </div>
                </div>
                
                <div class="col-md-4 wow g_fadein1" data-wow-delay="0.3s">
                    <div class="contact-card">
                        <div class="contact-icon bg-warning text-white">
                            <i class="iconfont icon-map" style="font-size: 24px;"></i>
                        </div>
                        <h3>公司地址</h3>
                        <p><?php echo ($config["address"]); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 底部 -->
    

    <!-- 回到顶部 -->
    <div class="he_backtop">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    </div>

    <script>
        // 初始化 Wow 动画
        document.addEventListener('DOMContentLoaded', function() {
            new WOW().init();
        });
    </script>
</body>
</html>