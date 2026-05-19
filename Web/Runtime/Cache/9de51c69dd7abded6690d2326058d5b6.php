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

<!-- 补充jQuery (head.html未包含) -->
<script src="__TMPL__js/jquery-1.10.2.min.js" type="text/javascript"></script>
<style>
.guestbook-container {
  max-width: 800px;
  margin: 30px auto;
  padding: 0 20px;
}
.guestbook-title {
  font-size: 24px;
  color: #1a1f4e;
  margin-bottom: 8px;
  padding-bottom: 12px;
  border-bottom: 3px solid #6c5ce7;
}
.guestbook-note {
  background: #f8f9ff;
  border: 1px solid #e0e4ff;
  border-radius: 8px;
  padding: 15px 20px;
  margin-bottom: 25px;
  line-height: 1.8;
  color: #555;
  font-size: 14px;
}
.guestbook-form {
  background: #fff;
  border: 1px solid #e8e8e8;
  border-radius: 10px;
  padding: 30px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
.form-row {
  display: flex;
  margin-bottom: 18px;
  align-items: flex-start;
}
.form-label {
  width: 90px;
  text-align: right;
  padding-right: 15px;
  padding-top: 8px;
  font-size: 14px;
  color: #333;
  font-weight: 500;
  flex-shrink: 0;
}
.form-label .required {
  color: #e74c3c;
  margin-right: 4px;
}
.form-input {
  flex: 1;
}
.form-input input[type="text"],
.form-input input[type="tel"],
.form-input textarea {
  width: 100%;
  max-width: 500px;
  padding: 10px 14px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 14px;
  color: #333;
  transition: border-color 0.3s;
  box-sizing: border-box;
  font-family: -apple-system, "Microsoft YaHei", sans-serif;
}
.form-input input:focus,
.form-input textarea:focus {
  outline: none;
  border-color: #6c5ce7;
  box-shadow: 0 0 0 3px rgba(108,92,231,0.1);
}
.form-input textarea {
  min-height: 120px;
  resize: vertical;
  max-width: 500px;
}
.btn-submit {
  margin-left: 105px;
  padding: 10px 36px;
  background: linear-gradient(135deg, #6c5ce7, #a29bfe);
  color: #fff;
  border: none;
  border-radius: 25px;
  font-size: 16px;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
  font-family: -apple-system, "Microsoft YaHei", sans-serif;
}
.btn-submit:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 15px rgba(108,92,231,0.35);
}
/* 留言列表 */
#content {
  margin-top: 30px;
}
#list {
  list-style: none;
  padding: 0;
}
#MultiPage {
  margin-top: 20px;
  text-align: center;
}
#MultiPage a {
  display: inline-block;
  padding: 5px 12px;
  margin: 0 3px;
  border: 1px solid #ddd;
  border-radius: 4px;
  color: #333;
  text-decoration: none;
  font-size: 13px;
}
#MultiPage a:hover {
  background: #6c5ce7;
  color: #fff;
  border-color: #6c5ce7;
}
</style>

<div class="guestbook-container">
  
  <h1 class="guestbook-title">📝 在线留言</h1>
  
  <div class="guestbook-note">
    欢迎留言！我们会尽快回复您的咨询。如有紧急需求，请直接致电：<strong>186-0192-1816</strong>
  </div>

  <!-- 发表留言表单 -->
  <div class="guestbook-form">
    <form id="form1" name="form1" method="post" action="">
      <table id="commentform" style="width:100%;border:none;">
        <tr>
          <td style="padding:8px 0;">
            <div class="form-row">
              <div class="form-label"><span class="required">*</span>姓名</div>
              <div class="form-input">
                <input name="author" type="text" id="Author" size="30" maxlength="30" placeholder="请输入您的姓名">
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td style="padding:8px 0;">
            <div class="form-row">
              <div class="form-label">联系电话</div>
              <div class="form-input">
                <input name="tel" type="text" id="tel" size="30" maxlength="80" placeholder="选填，方便我们联系您">
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td style="padding:8px 0;">
            <div class="form-row">
              <div class="form-label">留言标题</div>
              <div class="form-input">
                <input name="title" type="text" id="title" size="30" maxlength="30" placeholder="选填，简述您的问题">
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td style="padding:8px 0;">
            <div class="form-row">
              <div class="form-label"><span class="required">*</span>留言内容</div>
              <div class="form-input">
                <textarea name="content" cols="60" rows="7" value="" id="plContent" placeholder="请详细描述您的需求或问题..."></textarea>
                <span class="FontRed" style="color:#e74c3c;font-size:12px;">*</span>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td style="padding:15px 0 5px 0;">
            <button class="btn-submit" type="button" id="sendGuest" onClick="AddNew();">✉️ 发表留言</button>
          </td>
        </tr>
      </table>
    </form>
  </div>

  <!-- 留言列表 -->
  <div id="content">
    <div id="list"></div>
    <ul id="MultiPage"></ul>
    <div id="pinglunother">
      <div id="pinglunym"></div>
    </div>
  </div>

</div>

<script type="text/javascript" src="__TMPL__js/ajaxly.js"></script>
<script>
$(function(){
	showre(1);
});
// 硬编码root URL，避免<?php echo ($url); ?>变量未解析
var root = "/index.php?s=";
</script>