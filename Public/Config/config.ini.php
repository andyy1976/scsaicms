<?php
if (!defined('THINK_PATH')) exit();
return array(
  'DB_TYPE'=>'mysqli',
	'DB_HOST'=>'localhost',
	'DB_NAME'=>'eastaiai',
	'DB_USER'=>'root',
	'DB_PWD'=>'gyc1234567',
	'DB_PORT'=>'3306',
	'DB_PREFIX'=>'lvbo_',
	'DB_CHARSET'=>'utf8',
	'DEFAULT_CHARSET'=>'utf8',
	'COOKIE_PREFIX'=>'BkGOp9578O'.'_',
	'AP_EMAIL'=>'lvbo919@163.com',	
	'AP_PID'=>'2088631153629125',	
	'AP_KEY'=>'yfgr7ehq6yzp03wqu3twdsth73hds6ay',
	'AP_TYPE'=>'1',
	'LOCAL_REMOTE_PIC'=>0,
	'WX_APPID'=>'wxeb5a1b9ed655****',
	'WX_APPKEY'=>'9b8a783685ce51324c41e9f4a20*****',
	'WX_TOKEN'=>'lvb0tokenaaaaaaaaa****o',
	'WX_JQRKEY'=>'f4124fcc8feb767af3f90d63e1725597',
	'WX_TRADE'=>'0',//是否开启微信支付
	'WX_LOGIN'=>'0',//是否开启微信快捷登陆
	'QQ_APPID'=>'',
	'QQ_APPKEY'=>'',
	'QQ_LOGIN'=>'0',
	'MOBILE_VERIFY'=>'0',//手机短信验证码http://www.ihuyi.cn/
	'SMS_USER'=>'',
	'SMS_PWD'=>'',
	'MAIL_TRADE'=>0,
	'MAIL_REG'=>0,
	'MAIL_SMTP_SERVER'=>'',
	'MAIL_FROM'=>'',
<<<<<<< HEAD
	'MAIL_PASSSWORD'=>'ZQ==',
=======
	'MAIL_PASSSWORD'=>'ZQ==',
>>>>>>> c15b4682e8292755d9d569e23243221feeb9913d
	'MAIL_TOADMIN'=>'',
	'MAIL_PORT'=>,
	'TRADE_TYPE'=>array(1=>'支付宝在线支付',5=>'微信扫码支付',2=>'货到付款',3=>'站内扣款'),//4:在微信里直接是微信支付（所以缺少4）
	'TRADE_STATUS'=>array(0=>'等待付款',1=>'已付款，等待发货',2=>'已发货，等待收货',3=>'已收货，交易完成',4=>'申请换货',5=>'换货处理中',6=>'换货完成',7=>'申请退货',8=>'退货处理中',9=>'退货完成',10=>'交易关闭',11=>'货到付款，等待发货'), 
	'VERSION'=>'7.0',
	'SERVER_URL'=>'http://www.lvbo.com/',
	);
?>