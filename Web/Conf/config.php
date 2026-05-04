<?php

// 网站配置文件

return array(

    // 模板设置

    'DEFAULT_THEME' => 'huatian',
    'TMPL_TEMPLATE_SUFFIX' => '.html',
    'TMPL_L_DELIM' => '{',
    'TMPL_R_DELIM' => '}',
    'TAGLIB_BEGIN' => '{',
    'TAGLIB_END' => '}',
    'TMPL_PARSE_STRING' => array(
        '__TMPL__' => '/Web/Tpl/huatian/',
    ),

    // 语言设置

    'DEFAULT_LANG' => 'zh-cn',

    // URL模式

    'URL_MODEL' => 2,

    // 数据库配置

    'DB_TYPE' => 'mysqli',

    'DB_HOST' => 'localhost',

    'DB_NAME' => 'eastaiai',

    'DB_USER' => 'root',

    'DB_PWD' => 'gyc1234567',

    'DB_PORT' => '3306',

    'DB_PREFIX' => 'lvbo_',

    // 网站信息

    'WEB_SITE_TITLE' => '超云智能',

    'WEB_SITE_KEYWORDS' => '超云智能,智能制造,智能硬件',

    'WEB_SITE_DESCRIPTION' => '超云智能科技（深圳）有限公司是一家专注于智能制造领域的高科技企业，致力于为客户提供智能化解决方案和产品。',

    // 上传配置

    'UPLOAD_MAX_SIZE' => 10 * 1024 * 1024,

    'UPLOAD_ALLOW_EXTS' => array('jpg', 'jpeg', 'png', 'gif', 'swf'),

    // 缓存配置

    'DATA_CACHE_TIME' => 3600,

    'DATA_CACHE_TYPE' => 'File',

    // 日志配置

    'LOG_RECORD' => true,

    'LOG_LEVEL' => 'EMERG,ALERT,CRIT,ERR',

);

?>