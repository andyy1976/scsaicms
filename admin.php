<?php
if(!file_exists(dirname(__FILE__).'/install.lck')) header('Location:./install/index.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
define('THINK_PATH', './Core/');
define('APP_NAME', 'Admin');
define('APP_PATH', './Admin/'); 
define('APP_DEBUG',true);
require(THINK_PATH."/Core.php");
?>