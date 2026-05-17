<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="SCSAI ContentOS" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="format-detection" content="telephone=no, email=no" />
    <meta name="renderer" content="webkit">
    <title><?php if(($title) != ""): echo ($title); ?> -<?php endif; echo ($config["sitetitle"]); ?></title>
    <meta name="keywords" content="<?php echo ($keywords); ?>,AI数字员工,内容生成,智能制造,工业软件" />
    <meta name="description" content="<?php echo ($description); ?> - SCSAI智能内容管理与获客系统" />

    <link href="__TMPL__css/bootstrap.min-v3.3.5.css" type="text/css" rel="stylesheet" />
    <link href="__TMPL__css/base-v1.4.css" type="text/css" rel="stylesheet" />
    <link href="__TMPL__css/slick.css" type="text/css" rel="stylesheet" />
    <link href="__TMPL__css/slick-theme.css" type="text/css" rel="stylesheet" />
    <link href="__TMPL__css/jquery.mCustomScrollbar.min.css" rel="stylesheet" />
    <link href="__TMPL__css/animate.min.css" type="text/css" rel="stylesheet" />
    <link href="__TMPL__css/main.css" type="text/css" rel="stylesheet" />
    <link href="__TMPL__css/media.css" type="text/css" rel="stylesheet" />
    <link href="__TMPL__css/style.css?v=2026051208" type="text/css" rel="stylesheet" />
    <link href="__TMPL__css/ifplayer.css" type="text/css" rel="stylesheet" />
    <link href="__TMPL__css/style1.css" type="text/css" rel="stylesheet" />
    <link href="__TMPL__css/iconfont.css" type="text/css" rel="stylesheet">
    <link href="__TMPL__css/iframe.css" type="text/css" rel="stylesheet" />

    <style>
    /* 新头部样式 - 现代简洁设计 */
    .site-header {
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    .site-header-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .site-logo {
        display: flex;
        align-items: center;
    }
    .site-logo img {
        height: 45px;
        width: auto;
    }
    .site-nav {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .site-nav-item {
        position: relative;
    }
    .site-nav-link {
        display: block;
        padding: 10px 18px;
        color: #333;
        text-decoration: none;
        font-size: 15px;
        transition: all 0.3s;
        border-radius: 4px;
    }
    .site-nav-link:hover {
        color: #0066cc;
        background: rgba(0,102,204,0.05);
    }
    .site-nav-link.active {
        color: #0066cc;
        font-weight: 600;
    }
    .site-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 180px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s;
        padding: 8px 0;
    }
    .site-nav-item:hover .site-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .site-dropdown-link {
        display: block;
        padding: 10px 20px;
        color: #555;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s;
    }
    .site-dropdown-link:hover {
        color: #0066cc;
        background: rgba(0,102,204,0.05);
        padding-left: 25px;
    }
    .site-header-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .site-phone {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #333;
        font-size: 14px;
    }
    .site-phone-icon {
        width: 18px;
        height: 18px;
        fill: #0066cc;
    }
    .site-phone-number {
        font-weight: 600;
        color: #0066cc;
        font-size: 15px;
    }
    .site-search {
        position: relative;
    }
    .site-search-input {
        width: 180px;
        padding: 8px 35px 8px 15px;
        border: 1px solid #ddd;
        border-radius: 20px;
        font-size: 14px;
        transition: all 0.3s;
    }
    .site-search-input:focus {
        width: 220px;
        border-color: #0066cc;
        outline: none;
        box-shadow: 0 0 0 3px rgba(0,102,204,0.1);
    }
    .site-search-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
    }
    .site-search-btn img {
        width: 18px;
        height: 18px;
    }
    @media (max-width: 768px) {
        .site-header-inner {
            height: 60px;
            padding: 0 15px;
        }
        .site-nav {
            display: none;
        }
        .site-phone-text {
            display: none;
        }
        .site-search-input {
            width: 140px;
        }
        .site-search-input:focus {
            width: 160px;
        }
    }
    </style>
</head>
<body>
<!-- 新头部 -->
<header class="site-header">
    <div class="site-header-inner">
        <!-- Logo -->
        <div class="site-logo">
            <a href="/">
                <img src="__PUBLIC__/Uploads/logo/<?php echo ($config["sitelogo"]); ?>" alt="<?php echo ($config["sitetitle"]); ?>">
            </a>
        </div>

        <!-- 导航 -->
        <nav class="site-nav">
            <?php if(is_array($menu)): $i = 0; $__LIST__ = array_slice($menu,0,7,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="site-nav-item">
                    <a class="site-nav-link <?php if(($vo["typeid"]) == "1"): ?>active<?php endif; ?>" 
                       href="<?php if(($vo["url"]) == ""): echo (url(lists,$vo["typeid"])); else: ?>__ROOT_<?php echo ($vo["url"]); endif; ?>" 
                       target="<?php if(($vo["target"]) == "1"): ?>_self<?php else: ?>_blank<?php endif; ?>">
                        <?php echo ($vo["typename"]); ?>
                    </a>
                    <?php if($vo['submenu']){ ?>
                    <div class="site-dropdown">
                        <?php if(is_array($vo[submenu])): $i = 0; $__LIST__ = $vo[submenu];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?><a class="site-dropdown-link" href="<?php echo (url(lists,$sub["typeid"])); ?>"><?php echo ($sub["typename"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <?php } ?>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </nav>

        <!-- 右侧：电话+搜索 -->
        <div class="site-header-right">
            <div class="site-phone">
                <svg class="site-phone-icon" viewBox="0 0 24 24">
                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                </svg>
                <span class="site-phone-text">咨询热线：</span>
                <span class="site-phone-number">186-0192-1816</span>
            </div>
            
            <div class="site-search">
                <input type="text" class="site-search-input" placeholder="搜索..." id="keywords" autocomplete="off">
                <button class="site-search-btn" onclick="search()">
                    <img src="__TMPL__images/heaser1.png">
                </button>
            </div>
        </div>
    </div>
</header>

<script>
function search() {
    var keyword = document.getElementById('keywords').value;
    if(keyword) {
        location.href = '/index.php?s=/search/keyword/' + encodeURIComponent(keyword) + '.html';
    }
}
// 回车搜索
document.getElementById('keywords').addEventListener('keypress', function(e) {
    if(e.key === 'Enter') {
        search();
    }
});
</script>


 <!-- Hero Banner -->
<div class="g_sy he_main">
    <section class="hero-section" style="background: linear-gradient(135deg, #0a0e27 0%, #1a1f4e 50%, #2d1b69 100%); min-height: 600px; display: flex; align-items: center;">
        <div class="g_common" style="text-align: center; padding: 80px 0;">
            <h1 class="wow fadeInUp" style="font-size: 48px; color: #fff; margin-bottom: 20px; font-weight: 700;">
                AI数字内容生成发布管理<span style="color: #6c5ce7;">与获客系统</span>
            </h1>
            <p class="wow fadeInUp" style="font-size: 20px; color: rgba(255,255,255,0.8); max-width: 800px; margin: 0 auto 40px; line-height: 1.8;">
                自动采集热点 → AI智能评分 → 内容生成 → 多平台发布 → 精准获客<br>
                一站式AI内容数字员工，赋能企业内容营销全链路
            </p>
            <div class="wow fadeInUp" style="display: flex; gap: 20px; justify-content: center; margin-top: 40px;">
                <a href="index.php?s=/lists/4.html" style="background: #6c5ce7; color: #fff; padding: 16px 40px; border-radius: 8px; font-size: 18px; text-decoration: none; display: inline-block;">
                    免费体验
                </a>
                <a href="index.php?s=/lists/2.html" style="background: rgba(255,255,255,0.15); color: #fff; padding: 16px 40px; border-radius: 8px; font-size: 18px; text-decoration: none; border: 1px solid rgba(255,255,255,0.3); display: inline-block;">
                    了解更多
                </a>
            </div>
            <!-- 数据亮点 -->
            <div class="wow fadeInUp" style="display: flex; gap: 60px; justify-content: center; margin-top: 60px;">
                <div style="text-align: center;">
                    <div style="font-size: 36px; color: #6c5ce7; font-weight: 700;">4</div>
                    <div style="color: rgba(255,255,255,0.6); font-size: 14px;">大产品线</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 36px; color: #6c5ce7; font-weight: 700;">5+</div>
                    <div style="color: rgba(255,255,255,0.6); font-size: 14px;">信源平台</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 36px; color: #6c5ce7; font-weight: 700;">7x24</div>
                    <div style="color: rgba(255,255,255,0.6); font-size: 14px;">自动运行</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 36px; color: #6c5ce7; font-weight: 700;">3+</div>
                    <div style="color: rgba(255,255,255,0.6); font-size: 14px;">发布平台</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 四大产品线 -->
    <section style="padding: 80px 0; background: #f8f9ff;">
        <div class="g_common">
            <div class="g_title" style="text-align: center; margin-bottom: 60px;">
                <h3 style="font-size: 36px; color: #1a1f4e;">四大产品线，驱动企业智能化转型</h3>
                <p style="font-size: 16px; color: #666; margin-top: 15px;">从内容创作到智能制造，全栈AI赋能</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px;">
                <!-- 数字员工 -->
                <div class="wow fadeInUp" style="background: #fff; border-radius: 16px; padding: 40px 30px; text-align: center; transition: all 0.3s; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <div style="width: 80px; height: 80px; border-radius: 20px; background: linear-gradient(135deg, #6c5ce7, #a29bfe); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 36px;">
                        🤖
                    </div>
                    <h4 style="font-size: 22px; color: #1a1f4e; margin-bottom: 12px;">数字员工</h4>
                    <p style="font-size: 14px; color: #666; line-height: 1.8;">AI内容数字员工、营销数字员工、客服数字员工，7x24自动运行</p>
                    <a href="suzhou-ai-digital-employee-topic.html" style="display: inline-block; margin-top: 20px; color: #fff; font-size: 14px; text-decoration: none; background: #6c5ce7; padding: 8px 20px; border-radius: 20px;">
                        📚 查看专题
                    </a>
                    <a href="index.php?s=/lists/4.html" style="display: inline-block; margin-top: 20px; margin-left: 10px; color: #6c5ce7; font-size: 14px; text-decoration: none;">
                        了解更多 →
                    </a>
                </div>
                <!-- 人工智能 -->
                <div class="wow fadeInUp" style="background: #fff; border-radius: 16px; padding: 40px 30px; text-align: center; transition: all 0.3s; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <div style="width: 80px; height: 80px; border-radius: 20px; background: linear-gradient(135deg, #00b894, #55efc4); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 36px;">
                        🧠
                    </div>
                    <h4 style="font-size: 22px; color: #1a1f4e; margin-bottom: 12px;">人工智能</h4>
                    <p style="font-size: 14px; color: #666; line-height: 1.8;">大模型、AI智能体、多模态应用，拥抱AGI时代</p>
                    <a href="index.php?s=/lists/12.html" style="display: inline-block; margin-top: 20px; color: #00b894; font-size: 14px; text-decoration: none;">
                        了解更多 →
                    </a>
                </div>
                <!-- 智能制造 -->
                <div class="wow fadeInUp" style="background: #fff; border-radius: 16px; padding: 40px 30px; text-align: center; transition: all 0.3s; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <div style="width: 80px; height: 80px; border-radius: 20px; background: linear-gradient(135deg, #fdcb6e, #ffeaa7); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 36px;">
                        🏭
                    </div>
                    <h4 style="font-size: 22px; color: #1a1f4e; margin-bottom: 12px;">智能制造</h4>
                    <p style="font-size: 14px; color: #666; line-height: 1.8;">PLM/MES/QMS/ERP全链路工业软件，赋能制造企业数字化转型</p>
                    <a href="index.php?s=/lists/2.html" style="display: inline-block; margin-top: 20px; color: #e17055; font-size: 14px; text-decoration: none;">
                        了解更多 →
                    </a>
                </div>
                <!-- 机器人 -->
                <div class="wow fadeInUp" style="background: #fff; border-radius: 16px; padding: 40px 30px; text-align: center; transition: all 0.3s; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <div style="width: 80px; height: 80px; border-radius: 20px; background: linear-gradient(135deg, #e17055, #fab1a0); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 36px;">
                        🦾
                    </div>
                    <h4 style="font-size: 22px; color: #1a1f4e; margin-bottom: 12px;">机器人</h4>
                    <p style="font-size: 14px; color: #666; line-height: 1.8;">具身智能、人形机器人、工业机器人，人机协同新未来</p>
                    <a href="index.php?s=/lists/4.html" style="display: inline-block; margin-top: 20px; color: #fd79a8; font-size: 14px; text-decoration: none;">
                        了解更多 →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- AI 内容引擎 -->
    <section style="padding: 80px 0; background: #fff;">
        <div class="g_common">
            <div class="g_title" style="text-align: center; margin-bottom: 60px;">
                <h3 style="font-size: 36px; color: #1a1f4e;">AI内容数字员工工作流</h3>
                <p style="font-size: 16px; color: #666; margin-top: 15px;">5步自动完成，从热点到获客全链路</p>
            </div>
            <div style="display: flex; align-items: center; justify-content: center; gap: 15px; flex-wrap: wrap;">
                <div style="background: #f0f0ff; border-radius: 12px; padding: 25px; text-align: center; width: 180px;">
                    <div style="font-size: 30px; margin-bottom: 8px;">📡</div>
                    <div style="font-weight: 600; color: #6c5ce7;">自动采集</div>
                    <div style="font-size: 12px; color: #999; margin-top: 4px;">5+信源平台</div>
                </div>
                <div style="font-size: 24px; color: #6c5ce7;">→</div>
                <div style="background: #f0fff4; border-radius: 12px; padding: 25px; text-align: center; width: 180px;">
                    <div style="font-size: 30px; margin-bottom: 8px;">🎯</div>
                    <div style="font-weight: 600; color: #00b894;">AI评分</div>
                    <div style="font-size: 12px; color: #999; margin-top: 4px;">五维评分筛选</div>
                </div>
                <div style="font-size: 24px; color: #00b894;">→</div>
                <div style="background: #fff8f0; border-radius: 12px; padding: 25px; text-align: center; width: 180px;">
                    <div style="font-size: 30px; margin-bottom: 8px;">✍️</div>
                    <div style="font-weight: 600; color: #e17055;">智能生成</div>
                    <div style="font-size: 12px; color: #999; margin-top: 4px;">AI改写创作</div>
                </div>
                <div style="font-size: 24px; color: #e17055;">→</div>
                <div style="background: #fff0f6; border-radius: 12px; padding: 25px; text-align: center; width: 180px;">
                    <div style="font-size: 30px; margin-bottom: 8px;">🚀</div>
                    <div style="font-weight: 600; color: #fd79a8;">多平台发布</div>
                    <div style="font-size: 12px; color: #999; margin-top: 4px;">公众号/小红书/抖音</div>
                </div>
                <div style="font-size: 24px; color: #fd79a8;">→</div>
                <div style="background: #f0f7ff; border-radius: 12px; padding: 25px; text-align: center; width: 180px;">
                    <div style="font-size: 30px; margin-bottom: 8px;">💰</div>
                    <div style="font-weight: 600; color: #0984e3;">精准获客</div>
                    <div style="font-size: 12px; color: #999; margin-top: 4px;">私域+线索转化</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 最新AI热点 -->
    <section style="padding: 80px 0; background: #f8f9ff;">
        <div class="g_common">
            <div class="g_title" style="text-align: center; margin-bottom: 50px;">
                <h3 style="font-size: 36px; color: #1a1f4e;">AI热点速递</h3>
                <p style="font-size: 16px; color: #666; margin-top: 15px;">由AI数字员工7x24自动采集、评分、精选</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px;">
                <?php if(is_array($list_new)): $i = 0; $__LIST__ = $list_new;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="wow fadeInUp" style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                    <div style="padding: 25px;">
                        <h4 style="font-size: 16px; color: #1a1f4e; line-height: 1.6; margin-bottom: 12px;">
                            <a href='<?php echo (url(articles,$vo["aid"])); ?>' style="color: #1a1f4e; text-decoration: none;"><?php echo ($vo["title"]); ?></a>
                        </h4>
                        <p style="font-size: 13px; color: #999; line-height: 1.6;"><?php echo (msubstr($vo["description"],0,80,'utf-8')); ?></p>
                        <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 12px; color: #bbb;"><?php echo (msubstr($vo["addtime"],0,10)); ?></span>
                            <a href='<?php echo (url(articles,$vo["aid"])); ?>' style="font-size: 13px; color: #6c5ce7; text-decoration: none;">阅读 →</a>
                        </div>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div style="text-align: center; margin-top: 40px;">
                <a href="index.php?s=/lists/121.html" style="background: #6c5ce7; color: #fff; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-size: 15px;">
                    查看更多AI热点 →
                </a>
            </div>
        </div>
    </section>

    <!-- 订阅/体验入口 -->
    <section style="padding: 80px 0; background: linear-gradient(135deg, #1a1f4e, #2d1b69);">
        <div class="g_common" style="text-align: center;">
            <h3 style="font-size: 36px; color: #fff;">开始使用AI数字内容员工</h3>
            <p style="font-size: 16px; color: rgba(255,255,255,0.7); margin-top: 15px; max-width: 600px; margin-left: auto; margin-right: auto;">
                免费体验，感受AI自动化内容营销的力量
            </p>
            <div style="display: flex; gap: 30px; justify-content: center; margin-top: 40px;">
                <div style="background: rgba(255,255,255,0.1); border-radius: 16px; padding: 35px; width: 250px; border: 1px solid rgba(255,255,255,0.2);">
                    <h4 style="color: #fff; font-size: 20px; margin-bottom: 10px;">免费版</h4>
                    <div style="font-size: 36px; color: #6c5ce7; font-weight: 700;">¥0</div>
                    <div style="color: rgba(255,255,255,0.5); font-size: 13px; margin: 10px 0 20px;">每月50条内容</div>
                    <a href="index.php?s=/Guestbook/index" style="background: rgba(255,255,255,0.2); color: #fff; padding: 10px 25px; border-radius: 6px; text-decoration: none; display: inline-block;">开始体验</a>
                </div>
                <div style="background: rgba(255,255,255,0.1); border-radius: 16px; padding: 35px; width: 250px; border: 2px solid #6c5ce7; position: relative;">
                    <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #6c5ce7; color: #fff; padding: 2px 15px; border-radius: 10px; font-size: 12px;">推荐</div>
                    <h4 style="color: #fff; font-size: 20px; margin-bottom: 10px;">专业版</h4>
                    <div style="font-size: 36px; color: #6c5ce7; font-weight: 700;">¥99<span style="font-size: 14px; color: rgba(255,255,255,0.5);">/月</span></div>
                    <div style="color: rgba(255,255,255,0.5); font-size: 13px; margin: 10px 0 20px;">每月500条 + AI评分</div>
                    <a href="index.php?s=/Guestbook/index" style="background: #6c5ce7; color: #fff; padding: 10px 25px; border-radius: 6px; text-decoration: none; display: inline-block;">立即订阅</a>
                </div>
                <div style="background: rgba(255,255,255,0.1); border-radius: 16px; padding: 35px; width: 250px; border: 1px solid rgba(255,255,255,0.2);">
                    <h4 style="color: #fff; font-size: 20px; margin-bottom: 10px;">企业版</h4>
                    <div style="font-size: 36px; color: #fdcb6e; font-weight: 700;">定制</div>
                    <div style="color: rgba(255,255,255,0.5); font-size: 13px; margin: 10px 0 20px;">不限量 + PLM集成</div>
                    <a href="index.php?s=/Guestbook/index" style="background: rgba(255,255,255,0.2); color: #fff; padding: 10px 25px; border-radius: 6px; text-decoration: none; display: inline-block;">咨询方案</a>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- foot - 现代简洁设计 -->
<footer class="site-footer">
    <div class="site-footer-inner">
        
        <!-- 顶部：导航 + 联系 + 关注 -->
        <div class="site-footer-top">
            
            <!-- 左侧：站点导航 -->
            <div class="site-footer-section">
                <h6 class="site-footer-title">快速导航</h6>
                <div class="site-footer-links">
                    <?php if(is_array($menu)): $k = 0; $__LIST__ = array_slice($menu,0,7,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><a href="<?php if(($vo["url"]) == ""): echo (url(lists,$vo["typeid"])); else: ?>__ROOT__<?php echo ($vo["url"]); endif; ?>" target="<?php if(($vo["target"]) == "1"): ?>_self<?php else: ?>_blank<?php endif; ?>"><?php echo ($vo["typename"]); ?></a>
                        <?php if($vo[submenu]){ ?>
                        <?php if(is_array($vo[submenu])): $m = 0; $__LIST__ = $vo[submenu];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($m % 2 );++$m;?><a href="<?php echo (url(lists,$sub["typeid"])); ?>" class="site-footer-sublink"><?php echo ($sub["typename"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php } endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>

            <!-- 中间：联系方式 -->
            <div class="site-footer-section site-footer-contact">
                <h6 class="site-footer-title">联系我们</h6>
                <div class="site-footer-contact-items">
                    <div class="site-footer-contact-item">
                        <img src="__TMPL__images/fticon1.png" alt="电话"/>
                        <span>186-0192-1816</span>
                    </div>
                    <div class="site-footer-contact-item">
                        <img src="__TMPL__images/qq_login.png" alt="QQ"/>
                        <span>1275697128</span>
                    </div>
                    <div class="site-footer-contact-item">
                        <img src="__TMPL__images/fticon2.png" alt="邮箱"/>
                        <span>tuan_zhang@sina.com</span>
                    </div>
                    <div class="site-footer-contact-item">
                        <img src="__TMPL__images/fticon3.png" alt="地址"/>
                        <span>北京昌平区建材城西路9号金燕龙写字楼16层</span>
                    </div>
                </div>
            </div>

            <!-- 右侧：二维码 -->
            <div class="site-footer-section site-footer-qrcode">
                <h6 class="site-footer-title">关注我们</h6>
                <div class="site-footer-qr-list">
                    <div class="site-footer-qr-item">
                        <img src="__TMPL__images/we_chat.jpg" alt="微信">
                        <span>添加微信</span>
                    </div>
                    <div class="site-footer-qr-item">
                        <img src="__TMPL__images/wb.png" alt="微博">
                        <span>关注微博</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 底部：版权信息 -->
        <div class="site-footer-bottom">
            <div class="site-footer-copyright">
                <p>Copyright © 2026 东方艾艾（北京）科技有限公司 All Rights Reserved.</p>
                <p>电话：186-0192-1816 | <a href="http://beian.miit.gov.cn" target="_blank">京ICP备XXXXXXXX号</a></p>
            </div>
            <div class="site-footer-actions">
                <a href="index.php?s=/Guestbook/index" class="site-footer-action">在线留言</a>
                <a href="#" class="site-footer-action site-footer-backtop" onclick="window.scrollTo(0,0);return false;">返回顶部 ↑</a>
            </div>
        </div>
    </div>
</footer>

<style>
/* 现代Footer样式 */
.site-footer {
    background: #1a1a2e;
    color: #fff;
    padding: 40px 0 0;
    margin-top: 60px;
}
.site-footer-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.site-footer-top {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}
.site-footer-section {
    flex: 1;
    min-width: 200px;
}
.site-footer-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #fff;
}
.site-footer-links {
    display: flex;
    flex-wrap: wrap;
    gap: 8px 15px;
}
.site-footer-links a {
    color: #aaa;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s;
}
.site-footer-links a:hover {
    color: #fff;
}
.site-footer-sublink {
    color: #888 !important;
    font-size: 13px !important;
}
.site-footer-contact-items {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.site-footer-contact-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #aaa;
    font-size: 14px;
}
.site-footer-contact-item img {
    width: 18px;
    height: 18px;
    opacity: 0.7;
}
.site-footer-qr-list {
    display: flex;
    gap: 15px;
}
.site-footer-qr-item {
    text-align: center;
}
.site-footer-qr-item img {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    background: #fff;
    padding: 5px;
}
.site-footer-qr-item span {
    display: block;
    margin-top: 8px;
    font-size: 13px;
    color: #aaa;
}
.site-footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 0;
    flex-wrap: wrap;
    gap: 15px;
}
.site-footer-copyright {
    color: #666;
    font-size: 13px;
    text-align: center;
}
.site-footer-copyright p {
    margin: 5px 0;
}
.site-footer-copyright a {
    color: #666;
    text-decoration: none;
}
.site-footer-copyright a:hover {
    color: #fff;
}
.site-footer-actions {
    display: flex;
    gap: 20px;
}
.site-footer-action {
    color: #888;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s;
}
.site-footer-action:hover {
    color: #fff;
}
@media (max-width: 768px) {
    .site-footer-top {
        flex-direction: column;
    }
    .site-footer-section {
        width: 100%;
    }
    .site-footer-bottom {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<!-- ==================== AI智能客服悬浮按钮 + 聊天窗口 ==================== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<!-- 悬浮按钮组 -->
<div class="ai-fab-container">
    <!-- 客服按钮（主按钮） -->
    <button class="ai-fab ai-fab-primary" id="aiFabCustomer" onclick="openAiChat('customer')" title="AI智能客服">
        <i class="fas fa-robot"></i>
        <span class="ai-fab-badge">在线</span>
    </button>
    
    <!-- 营销助手按钮 -->
    <button class="ai-fab ai-fab-secondary" id="aiFabMarketing" onclick="openAiChat('marketing')" title="AI营销助手">
        <i class="fas fa-pen-fancy"></i>
    </button>
    
    <!-- 返回顶部 -->
    <button class="ai-fab ai-fab-top" id="aiFabTop" onclick="window.scrollTo({top:0,behavior:'smooth'})" title="返回顶部" style="display:none;">
        <i class="fas fa-chevron-up"></i>
    </button>
</div>

<!-- 聊天窗口 -->
<div class="ai-chat-window" id="aiChatWindow">
    <!-- 头部 -->
    <div class="ai-chat-header" id="aiChatHeader">
        <div class="ai-chat-header-left">
            <div class="ai-chat-avatar" id="aiChatAvatar">🤖</div>
            <div class="ai-chat-header-info">
                <h4 id="aiChatTitle">AI智能客服</h4>
                <span class="ai-chat-status"><i class="fas fa-circle"></i> 在线</span>
            </div>
        </div>
        <div class="ai-chat-header-right">
            <button class="ai-chat-mode-btn" id="aiModeToggle" onclick="toggleAiMode()" title="切换模式">
                <i class="fas fa-exchange-alt"></i> 切换
            </button>
            <button class="ai-chat-close-btn" onclick="closeAiChat()" title="关闭">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    
    <!-- 快捷入口 -->
    <div class="ai-chat-shortcuts" id="aiChatShortcuts">
        <button class="ai-shortcut-btn" onclick="aiQuickAsk('产品介绍')">📦 产品介绍</button>
        <button class="ai-shortcut-btn" onclick="aiQuickAsk('价格和套餐')">💰 价格咨询</button>
        <button class="ai-shortcut-btn" onclick="aiQuickAsk('免费体验')">🎯 免费体验</button>
        <button class="ai-shortcut-btn" onclick="aiQuickAsk('联系我们')">📞 联系人工</button>
    </div>
    
    <!-- 消息区域 -->
    <div class="ai-chat-messages" id="aiChatMessages">
        <div class="ai-msg ai-msg-bot">
            <div class="ai-msg-avatar">🤖</div>
            <div class="ai-msg-content" id="aiWelcomeMsg">
                加载中...
            </div>
        </div>
    </div>
    
    <!-- 输入区域 -->
    <div class="ai-chat-input-area">
        <div class="ai-chat-input-row">
            <textarea id="aiChatInput" placeholder="输入您的问题..." rows="1" 
                      onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendAiMessage();}"></textarea>
            <button class="ai-send-btn" id="aiSendBtn" onclick="sendAiMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
        <div class="ai-chat-hint">按 Enter 发送，Shift+Enter 换行 · 对话内容仅用于本次会话</div>
    </div>
</div>

<!-- 遮罩层 -->
<div class="ai-chat-overlay" id="aiChatOverlay" onclick="closeAiChat()"></div>

<style>
/* ====== 悬浮按钮组 ====== */
.ai-fab-container {
    position: fixed;
    right: 24px;
    bottom: 30px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 12px;
    align-items: center;
}
.ai-fab {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #fff;
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}
.ai-fab:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 24px rgba(0,0,0,0.3);
}
.ai-fab-primary {
    background: linear-gradient(135deg, #6c5ce7, #a29bfe);
    width: 60px;
    height: 60px;
    font-size: 26px;
    animation: ai-pulse 2s infinite;
}
@keyframes ai-pulse {
    0%, 100% { box-shadow: 0 4px 16px rgba(108,92,231,0.4); }
    50% { box-shadow: 0 4px 24px rgba(108,92,231,0.7), 0 0 0 10px rgba(108,92,231,0.1); }
}
.ai-fab-badge {
    position: absolute;
    top: -2px;
    right: -2px;
    background: #00d26a;
    color: #fff;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 10px;
    font-weight: 600;
    border: 2px solid #fff;
}
.ai-fab-secondary {
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    width: 44px;
    height: 44px;
    font-size: 18px;
}
.ai-fab-top {
    background: #555;
    width: 40px;
    height: 40px;
    font-size: 16px;
}

/* ====== 聊天窗口 ====== */
.ai-chat-window {
    position: fixed;
    bottom: 100px;
    right: 24px;
    width: 380px;
    height: 560px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.15);
    z-index: 10001;
    display: none;
    flex-direction: column;
    overflow: hidden;
    font-family: -apple-system, "Microsoft YaHei", sans-serif;
    animation: ai-slide-up 0.3s ease-out;
}
@keyframes ai-slide-up {
    from { opacity: 0; transform: translateY(20px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.ai-chat-window.open { display: flex; }

/* 头部 */
.ai-chat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 18px;
    background: linear-gradient(135deg, #6c5ce7, #a29bfe);
    color: #fff;
    flex-shrink: 0;
}
.ai-chat-header.marketing {
    background: linear-gradient(135deg, #ff6b35, #f7931e);
}
.ai-chat-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.ai-chat-avatar {
    width: 38px;
    height: 38px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}
.ai-chat-header-info h4 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
}
.ai-chat-status {
    font-size: 11px;
    opacity: 0.85;
}
.ai-chat-status i {
    font-size: 7px;
    margin-right: 3px;
    animation: ai-blink 1.5s infinite;
}
@keyframes ai-blink {
    50% { opacity: 0.3; }
}
.ai-chat-header-right {
    display: flex;
    gap: 8px;
}
.ai-chat-mode-btn,
.ai-chat-close-btn {
    background: rgba(255,255,255,0.2);
    border: none;
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    transition: background 0.2s;
}
.ai-chat-mode-btn:hover,
.ai-chat-close-btn:hover {
    background: rgba(255,255,255,0.35);
}

/* 快捷入口 */
.ai-chat-shortcuts {
    display: flex;
    gap: 6px;
    padding: 10px 14px;
    background: #f8f9ff;
    border-bottom: 1px solid #eee;
    flex-shrink: 0;
    overflow-x: auto;
}
.ai-shortcut-btn {
    white-space: nowrap;
    padding: 6px 14px;
    border: 1px solid #e0d8ff;
    background: #fff;
    border-radius: 20px;
    font-size: 12px;
    color: #6c5ce7;
    cursor: pointer;
    transition: all 0.2s;
}
.ai-shortcut-btn:hover {
    background: #6c5ce7;
    color: #fff;
    border-color: #6c5ce7;
}

/* 消息区域 */
.ai-chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    scroll-behavior: smooth;
}
.ai-chat-messages::-webkit-scrollbar { width: 4px; }
.ai-chat-messages::-webkit-scrollbar-thumb { background: #ddd; border-radius: 2px; }
.ai-msg { display: flex; gap: 10px; max-width: 90%; }
.ai-msg.bot { align-self: flex-start; }
.ai-msg.user { align-self: flex-end; flex-direction: row-reverse; }
.ai-msg-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
    background: #f0eeff;
}
.ai-msg.user .ai-msg-avatar { background: #e8f4fd; }
.ai-msg-content {
    padding: 10px 14px;
    border-radius: 12px;
    font-size: 14px;
    line-height: 1.65;
    word-break: break-word;
}
.ai-msg.bot .ai-msg-content {
    background: #f5f3ff;
    color: #333;
    border-top-left-radius: 4px;
}
.ai-msg.user .ai-msg-content {
    background: linear-gradient(135deg, #6c5ce7, #a29bfe);
    color: #fff;
    border-top-right-radius: 4px;
}
.ai-msg-content a { color: #6c5ce7; text-decoration: underline; }
.ai-msg.user .ai-msg-content a { color: #fff; text-decoration: underline; }
.ai-msg-content strong { font-weight: 600; }

/* 打字动画 */
.ai-typing {
    display: inline-flex;
    gap: 4px;
    padding: 4px 0;
}
.ai-typing span {
    width: 7px;
    height: 7px;
    background: #aaa;
    border-radius: 50%;
    animation: ai-dot 1.2s infinite;
}
.ai-typing span:nth-child(2) { animation-delay: 0.2s; }
.ai-typing span:nth-child(3) { animation-delay: 0.4s; }
@keyframes ai-dot {
    0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
    40% { transform: scale(1); opacity: 1; }
}

/* 输入区域 */
.ai-chat-input-area {
    padding: 12px 14px;
    border-top: 1px solid #eee;
    flex-shrink: 0;
    background: #fafafa;
}
.ai-chat-input-row {
    display: flex;
    gap: 8px;
    align-items: flex-end;
}
#aiChatInput {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 14px;
    resize: none;
    max-height: 80px;
    min-height: 42px;
    line-height: 1.4;
    font-family: inherit;
    outline: none;
    transition: border-color 0.2s;
}
#aiChatInput:focus { border-color: #6c5ce7; box-shadow: 0 0 0 3px rgba(108,92,231,0.1); }
.ai-send-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, #6c5ce7, #a29bfe);
    color: #fff;
    cursor: pointer;
    font-size: 16px;
    transition: transform 0.2s;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
.ai-send-btn:hover { transform: scale(1.05); }
.ai-send-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
.ai-chat-hint {
    margin-top: 6px;
    font-size: 11px;
    color: #bbb;
    text-align: center;
}

/* 遮罩层 (移动端) */
.ai-chat-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.3);
    z-index: 9999;
    display: none;
}

/* 响应式 */
@media (max-width: 480px) {
    .ai-chat-window {
        width: calc(100vw - 20px);
        height: calc(100vh - 80px);
        bottom: 0;
        right: 10px;
        left: 10px;
        border-radius: 16px 16px 0 0;
    }
    .ai-fab-container { right: 16px; bottom: 16px; }
    .ai-chat-overlay.open { display: block; }
}
</style>

<script>
// ========== AI智能客服 全局状态 ==========
var aiCurrentMode = 'customer'; // customer | marketing
var aiChatHistory = [];
var aiIsTyping = false;

// 欢迎语
var aiWelcomeTexts = {
    customer: '您好！👋 我是 **SCSAI AI智能客服**，很高兴为您服务！\n\n我可以帮您：\n• 📦 了解数字员工产品功能\n• 💰 咨询价格和套餐方案\n• 🎯 预约免费产品演示\n• 🏭 了解PLM/MES/ERP工业软件\n• 📞 转接人工客服\n\n请选择上方快捷按钮，或直接输入您的问题~',
    marketing: '您好！✨ 我是 **AI营销助手**，帮您搞定内容创作！\n\n我可以帮您：\n• ✍️ 生成营销文案和文章\n• 📊 制定内容策略建议\n• 🎨 优化社交媒体内容\n• 📅 规划发布日历\n\n告诉我您的需求，让我来帮您吧~'
};

// ========== 窗口控制 ==========
function openAiChat(mode) {
    aiCurrentMode = mode || 'customer';
    var win = document.getElementById('aiChatWindow');
    var overlay = document.getElementById('aiChatOverlay');
    
    // 更新头部样式
    var header = document.getElementById('aiChatHeader');
    var avatar = document.getElementById('aiChatAvatar');
    var title = document.getElementById('aiChatTitle');
    var shortcuts = document.getElementById('aiChatShortcuts');
    
    if (mode === 'marketing') {
        header.className = 'ai-chat-header marketing';
        avatar.textContent = '✍️';
        title.textContent = 'AI营销助手';
        shortcuts.innerHTML = '<button class="ai-shortcut-btn" onclick="aiQuickAsk(\'生成一篇公众号文章\')">📝 生成文章</button>'+
            '<button class="ai-shortcut-btn" onclick="aiQuickAsk(\'帮我写小红书文案\')">📕 小红书文案</button>'+
            '<button class="ai-shortcut-btn" onclick="aiQuickAsk(\'内容策略建议\')">📊 内容策略</button>'+
            '<button class="ai-shortcut-btn" onclick="aiQuickAsk(\'优化这段文案\')">🔧 文案优化</button>';
    } else {
        header.className = 'ai-chat-header';
        avatar.textContent = '🤖';
        title.textContent = 'AI智能客服';
        shortcuts.innerHTML = '<button class="ai-shortcut-btn" onclick="aiQuickAsk(\'产品介绍\')">📦 产品介绍</button>'+
            '<button class="ai-shortcut-btn" onclick="aiQuickAsk(\'价格和套餐\')">💰 价格咨询</button>'+
            '<button class="ai-shortcut-btn" onclick="aiQuickAsk(\'免费体验\')">🎯 免费体验</button>'+
            '<button class="ai-shortcut-btn" onclick="aiQuickAsk(\'联系我们\')">📞 联系人工</button>';
    }
    
    // 设置欢迎语
    if (!aiChatHistory.length) {
        document.getElementById('aiWelcomeMsg').innerHTML = formatAiMessage(aiWelcomeTexts[aiCurrentMode]);
    }
    
    win.classList.add('open');
    overlay.classList.add('open');
}

function closeAiChat() {
    document.getElementById('aiChatWindow').classList.remove('open');
    document.getElementById('aiChatOverlay').classList.remove('open');
}

function toggleAiMode() {
    aiChatHistory = []; // 清空历史
    openAiChat(aiCurrentMode === 'customer' ? 'marketing' : 'customer');
    // 清空消息区域只保留欢迎语
    var msgs = document.getElementById('aiChatMessages');
    msgs.innerHTML = '<div class="ai-msg ai-msg-bot"><div class="ai-msg-avatar">'+(aiCurrentMode==='marketing'?'✍️':'🤖')+'</div><div class="ai-msg-content" id="aiWelcomeMsg">'+formatAiMessage(aiWelcomeTexts[aiCurrentMode])+'</div></div>';
}

// ========== 消息发送 ==========
function sendAiMessage() {
    var input = document.getElementById('aiChatInput');
    var msg = input.value.trim();
    if (!msg || aiIsTyping) return;
    
    // 显示用户消息
    appendAiMessage(msg, 'user');
    input.value = '';
    input.style.height = 'auto';
    
    // 显示打字动画
    showTyping();
    
    // 发送到后端API
    callAiApi(msg);
}

function aiQuickAsk(question) {
    document.getElementById('aiChatInput').value = question;
    sendAiMessage();
}

function callAiApi(message) {
    aiIsTyping = true;
    
    fetch('/Web/api/ai-chat.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            message: message,
            history: aiChatHistory,
            mode: aiCurrentMode
        })
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        hideTyping();
        aiIsTyping = false;
        if (data.reply) {
            appendAiMessage(data.reply, 'bot');
            aiChatHistory.push({role:'user', content:message});
            aiChatHistory.push({role:'assistant', content:data.reply});
        } else if (data.error) {
            appendAiMessage('抱歉，服务暂时不可用。请稍后再试，或拨打 186-0192-1816 联系人工客服。', 'bot');
        }
    })
    .catch(function(err) {
        hideTyping();
        aiIsTyping = false;
        console.error('AI Chat Error:', err);
        appendAiMessage('网络连接异常，请检查网络后重试。如需帮助请致电 **186-0192-1816**', 'bot');
    });
}

// ========== UI辅助函数 ==========
function appendAiMessage(text, type) {
    var container = document.getElementById('aiChatMessages');
    var div = document.createElement('div');
    div.className = 'ai-msg ai-msg-' + type;
    var avatar = type === 'bot' ? (aiCurrentMode === 'marketing' ? '✍️' : '🤖') : '😊';
    div.innerHTML = '<div class="ai-msg-avatar">'+avatar+'</div><div class="ai-msg-content">'+formatAiMessage(text)+'</div>';
    container.appendChild(div);
    scrollToBottom();
}

function formatAiMessage(text) {
    // Markdown转简单HTML：**bold** -> <strong>, \n -> <br>
    return text.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
               .replace(/\n/g, '<br>');
}

function showTyping() {
    var container = document.getElementById('aiChatMessages');
    var div = document.createElement('div');
    div.className = 'ai-msg ai-msg-bot';
    div.id = 'aiTypingMsg';
    div.innerHTML = '<div class="ai-msg-avatar">'+(aiCurrentMode==='marketing'?'✍️':'🤖')+'</div><div class="ai-msg-content"><div class="ai-typing"><span></span><span></span><span></span></div></div>';
    container.appendChild(div);
    scrollToBottom();
}

function hideTyping() {
    var el = document.getElementById('aiTypingMsg');
    if (el) el.remove();
}

function scrollToBottom() {
    var c = document.getElementById('aiChatMessages');
    c.scrollTop = c.scrollHeight;
}

// 自动调整输入框高度
document.addEventListener('DOMContentLoaded', function() {
    var input = document.getElementById('aiChatInput');
    if (input) {
        input.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 80) + 'px';
        });
    }
});

// 返回顶部按钮显示逻辑
window.addEventListener('scroll', function() {
    var btn = document.getElementById('aiFabTop');
    if (btn) {
        btn.style.display = window.scrollY > 300 ? 'flex' : 'none';
    }
});
</script>