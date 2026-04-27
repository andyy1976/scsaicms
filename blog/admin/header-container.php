<?php
if (!defined('__TYPECHO_ADMIN__')) 
{
    exit;
}
$header = '<link rel="stylesheet" href="' . Typecho_Common::url('normalize.css?v=' . $suffixVersion, $options->adminStaticUrl('css')) . '">
<link rel="stylesheet" href="' . Typecho_Common::url('grid.css?v=' . $suffixVersion, $options->adminStaticUrl('css')) . '">
<link rel="stylesheet" href="' . Typecho_Common::url('style.css?v=' . $suffixVersion, $options->adminStaticUrl('css')) . '">
<!--[if lt IE 9]>
<script src="' . Typecho_Common::url('html5shiv.js?v=' . $suffixVersion, $options->adminStaticUrl('js')) . '"></script>
<script src="' . Typecho_Common::url('respond.js?v=' . $suffixVersion, $options->adminStaticUrl('js')) . '"></script>
<![endif]-->';

/** 注册一个初始化插件 */
$header = Typecho_Plugin::factory('admin/header.php')->header($header);

?>


