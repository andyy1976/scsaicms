<?php

class MemberAction extends BaseAction
{
    private $qqconfig = array();
    private $wxconfig = array();

    function _initialize()
    {
        parent::_initialize();
        $this->qqconfig['appid'] = C('QQ_APPID');
        $this->qqconfig['appkey'] = C('QQ_APPKEY');
        $this->qqconfig['callback'] = 'http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . "/index.php/Member/qqcallback";
        $this->wxconfig['appid'] = C('WX_APPID');
        $this->wxconfig['appsecret'] = C('WX_APPKEY');
        $this->wxconfig['callback'] = 'http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . "/index.php/Member/wxcallback";
        $member_menu = S('member_menu');
        if (!is_array($member_menu)) 
        {
            $member_menu = M('member_menu')->where('is_show=1')->order('drand')->select();
            S('member_menu', $member_menu);
        }
        $this->assign('member_menu', $member_menu);
    }

		//检查是否登录
    private function is_login()
    {
        header("Content-type: text/html; charset=utf-8");
        if (!isset($_SESSION['userid']) || $_SESSION['userid'] == '' || $_SESSION['userid'] == 0) 
        {
            $lasturl = urlencode(htmlspecialchars('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
            $this->assign('jumpUrl', __ROOT__ . '/index.php?m=Member&a=login&lasturl=' . $lasturl);
            $this->success('未登陆或登陆超时，请重新登陆,页面跳转中~');
        }
    }

		//用户登陆	
    public function login()
    {
        if (isset($_SESSION['userid']) && $_SESSION['userid'] != '') 
        {
            $this->redirect('Member/main');
        }
        $refer = $_SERVER['HTTP_REFERER'];
        $lasturl = stripos($refer, 'dologout') !== false || stripos($refer, 'doreg') !== false || stripos($refer, 'register') !== false ? '' : urlencode($refer);
        if (isset($_REQUEST['lasturl']) && strlen($_REQUEST['lasturl']) > 4) 
        {
            $lasturl = $_REQUEST['lasturl'];
        }
        $this->assign('lasturl', $lasturl);
        $this->display();
    }

    function hash($string, $salt = NULL)
    {
        /** 生成随机字符串 */
        $salt = empty($salt) ? $this->randString(9) : $salt;
        $length = strlen($string);
        $hash = '';
        $last = ord($string[$length - 1]);
        $pos = 0;

        /** 判断扰码长度 */
        if (strlen($salt) != 9) 
        {
            /** 如果不是9直接返回 */
            return  "";
        }

        while ($pos < $length) {
            $asc = ord($string[$pos]);
            $last = ($last * ord($salt[($last % $asc) % 9]) + $asc) % 95 + 32;
            $hash .= chr($last);
            $pos ++;
        }

        return '$T$' . $salt . md5($hash);
    }
    
    function randString($length, $specialChars = false)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        if ($specialChars) 
        {
            $chars .= '!@#$%^&*()';
        }

        $result = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[rand(0, $max)];
        }
        return $result;
    }
    
		//登录
    function dologin()
    {
				if(!isset($_SESSION['err_number']))
				{
					$_SESSION['err_number'] = 0;
				}
				if($_SESSION['err_number'] >=3)
				{
		        self::check_verify();
				}
        $username = inject_check($_REQUEST['username']);
        $userpwd = inject_check($_REQUEST['userpwd']);
        if ($username == '' || $userpwd == '') 
        {
            $this->error('请输入用户名和密码?');
            exit();
        }
        
        $info = M('member')->where("username='{$username}' and is_lock=0")->find();
        if (!$info) 
        {
            $this->error('用户不存在或账户未激活!');
        } 
        else 
        {
            if ($info['userpwd'] != md5(md5($userpwd))) 
            {
								$_SESSION['err_number'] += 1;
                $this->error('密码错误，请重新登录!');
            } 
            else 
            {
								$_SESSION['err_number'] = 0;
                $_SESSION['userid'] = $info['id'];
                $_SESSION['cms_username'] = $info['username'];
                $_SESSION['cms_usericon'] = $info['icon'];
							
               $_SESSION['cms_realname'] = $info['realname'];
              
               
               
               
               
                 
                 
                 
                $authCode =sha1($this->randString(20));
                
              	$hashauthCode=$this->hash($authCode);
              	
              	
              	//	echo "aaa".$hashauthCode;
                $_SESSION['cms_userauthCode'] = $hashauthCode;
         				$data=array();
         				 //$starttime=  $info['starttime'];            
         				 $endtime=  $info['endtime'];                  
         				                                               
         	 			$_SESSION['cms_bloggroup'] = $info['group'];                                             
         				                                               
         				
               	  if($endtime<time())              
               	  {                                
               	  	  $data['group_id'] =1;        
               	  	  $_SESSION['cms_usergroup'] = 1;                          
               	  } 
               	  else
               	  {
               	  
               	  	$_SESSION['cms_usergroup'] = $info['group_id'];  
               	  }                                                                                     
               	  $_SESSION['cms_uservail'] = get_field('member_group', 'group_id=' . $info['group_id'], 'group_vail');   
               	  $data['id'] = $_SESSION['userid'];
                  $data['authCode'] = $authCode;
                  $data['logged'] = time();
                  $data['activated'] =  time();
                  $id= $info['id'];
	               //	M('member')->save($data);
	               $username= $info['username'];
	               //  M('member')->where("id='{$id}'")->save($data);
	               // $data['last_uptime'] = time();
            		 M('member')->where("username='{$username}'")->save($data);
            	  
    
                if (!empty($_REQUEST['lasturl'])) 
                {
                   $this->assign('jumpUrl', htmlspecialchars(urldecode($_REQUEST['lasturl'])));
                    // $this->assign('jumpUrl', htmlspecialchars($lasturl));
                } 
                else 
                {
                   // $this->assign('jumpUrl', U('Member/main'));
                   $this->assign('jumpUrl', U('/index'));
                }
                $this->success('登录成功~');
            }
        }
    }

		//在线充值
    function chongzhi()
    {
        self::is_login();
        $info = M('member')->where('id=' . $_SESSION['userid'])->find();
        $this->assign('row', $info);
        $this->display();
    }

		//卡充值
    function card_money()
    {
        self::is_login();
        $uid = intval($_SESSION['userid']);
        $User = D("card"); // 实例化User对象
        if (!$User->create()) {
            $this->error($User->getError());
        } else {
            $data = array_map('strval', $_POST);
            $data = loopxss($data);
            $card_number = $data['card_number'];
            $card_pwd = $data['card_pwd'];
            $t = $User->where("card_num='$card_number' and status=0")->find();
            if (!$t) {
                $this->error('卡号错误或已使用');
            }
            if ($t['card_pwd'] != $card_pwd) {
                $this->error('卡号密码有误!充值失败!');
            } else {
                M('member')->where('id=' . $uid)->setInc('money', floatval($t['money']));
                
                $data['uid'] = $uid;
                $data['addtime'] = time();
                $data['price'] = floatval($t['money']);
                $data['trade_no'] = $card_number;
                $data['remark'] = "用户用卡号:{$card_number}充值";
                $data['log_type'] = 0;
                M('money_log')->add($data);
                $this->success('恭喜您充值成功!');
            }
        }
    }

//注销登录
    function dologout()
    {
        unset($_SESSION['userid']);
        unset($_SESSION['cms_username']);
        unset($_SESSION['cms_usericon']);
        unset($_SESSION['cms_uservail']);
        session_destroy();
      //  $this->assign('jumpUrl', U('Member/login'));
        $this->assign('jumpUrl', U('/index'));
        $this->success('注销成功~'); 
    }

		//用户注册 
    public function register()
    {
        $this->display();
    }

		//确认注册
    function doreg()
    {
        if (intval(C('MOBILE_VERIFY')) == 1) {
            self::check_verify(1);
        }
        $User = D("Member"); // 实例化User对象
        if (!$User->create()) {
            $this->error($User->getError());
        } else {
            $data = array_map('strval', $_POST);
            if (strlen($data['username']) > 16) {
                $this->error('用户名太长!');
            }
            $data['userpwd'] = md5(md5($_POST['userpwd']));
            $data['money'] = 0;
            $config = F('basic', '', './Web/Conf/');
            if (intval(C('MAIL_REG')) == 1) {
                $data['is_lock'] = 1;
                $body = '点击或复制以下链接,激活您的账号:<br><a href="http://' . $_SERVER['HTTP_HOST'] . '/' . U('Member/doactive', array('username' => $data['username'])) . '">http://' . $_SERVER['HTTP_HOST'] . '/' . U('Member/doactive', array('username' => $data['username'])) . '</a>';
                send_mail($data['email'], $config[sitetitle] . '用户', '用户注册激活邮件', $body);
                $message = "恭喜你注册成功，但需要邮件激活，请登陆您的邮箱激活!";
            } else {
                $message = "注册成功,请登录~";
                $data['is_lock'] = 0;
            }

            $data['group_id'] = intval($config['defaultmp']);
            $data['addtime'] = time();
            $User->add($data);
            $this->assign('jumpUrl', U('Member/login'));
            $this->success($message);
        }
    }

		//找回密码
    function find_password()
    {
        if ($_POST) 
        {
            self::check_verify();
            $_POST = array_map('strval', $_POST);
            if (empty($_POST['username']) || empty($_POST['email']) || !preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $_POST['email'])) {
                $this->error('请输入用户名与注册邮件');
            }
            $map['username'] = inject_check($_POST['username']);
            $map['email'] = inject_check($_POST['email']);
            $t = M('member')->where($map)->find();
            if (!$t) 
            {
                $this->error('用户名与邮件不匹配');
            } 
            else 
            {
                $map['hash'] = cms_encrypt(time());
                $map['addtime'] = time();
                M('find_password')->add($map);
                $url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . U('Member/reset_password', $map);
                $body = "您在" . date('Y-m-d H:i:s') . "提交了找回密码请求。请点击下面的链接重置密码（48小时内有效）。<br><a href=\"{$url}\" target=\"_blank\">{$url}</a>";
                send_mail($t['email'], $t['email'] . '用户', '用户找回密码邮件', $body);
                $this->assign("waitSecond", 30);
                $this->assign("jumpUrl", U('Member/login'));
                $this->success('找回密码成功！请在48小时内登陆邮箱重置密码!');
            }
        } else {
            $this->display();
        }
    }

		//重置密码
    function reset_password()
    {
        if ($_REQUEST['email'] == '' || $_REQUEST['username'] == '' || $_REQUEST['hash'] == '' || $_REQUEST['addtime'] == '') {
            $this->errpr('URL参数不完整');
        }
        $_REQUEST = array_map('strval', $_REQUEST);
        $map['username'] = inject_check($_REQUEST['username']);
        $map['email'] = inject_check($_REQUEST['email']);
        $map['hash'] = inject_check($_REQUEST['hash']);
        $map['addtime'] = inject_check($_REQUEST['addtime']);
        $t = M('find_password')->where($map)->find();
        if (!$t) {
            $this->error('URL参数不正确');
        } else {
            if (time > $t['addtime'] + 48 * 3600) {
                $this->error('URL已经过期');
                M('find_password')->where('id=' . $t['id'])->delete();
            }
        }
        if ($_POST) {
            if ($_POST['newpwd'] == '' || $_POST['newpwd'] != $_POST['newpwd2']) {
                $this->error('密码不能为空，两次密码输入必须一致');
            }
            unset($map['hash']);
            unset($map['addtime']);
            M('member')->where($map)->setField('userpwd', md5(md5($_POST['newpwd'])));
            $this->assign("jumpUrl", U('Member/login'));
            $this->success('密码已经修改成功！请登陆');
        } else {
            $this->display();
        }
    }

		//用户激活
    function doactive()
    {
        $username = inject_check($_REQUEST['username']);
        $t = M('member')->where("username='{$username}' and last_uptime is null")->find();
        if (!$t) {
            $this->error('邮件已过期或已经激活!');
        } else {
            $data['is_lock'] = 0;
            $data['last_uptime'] = time();
            M('member')->where("username='{$username}' and last_uptime is null")->save($data);
            $this->assign('jumpUrl', 'http://' . $_SERVER['HTTP_HOST']);
            $this->success('邮件激活，请登陆`');
        }
    }

    //生成验证码
    public function verify()
    {
        import('ORG.Util.Image');
        ob_end_clean();
        Image::buildImageVerify(5, 1, 'png', 78, 20, 'verify');
    }

    //手机验证码
    public function sms_verify()
    {
        $mobile = $_GET['mobile'];
        $this->ajaxReturn(send_smsmess($mobile, null, 1));
    }

			//验证验证码(包括手机验证码)
    private function check_verify($type = 0)
    {
        if (empty($_POST['verify']) && cookie('think_template') != C('DEFAULT_WAP_THEME')) {
            $this->error('验证码必须!');
        }
        $verify = ($type == 1 ? 'mobile_verify' : 'verify');
        if (md5($_POST['verify']) != $_SESSION[$verify] && cookie('think_template') != C('DEFAULT_WAP_THEME')) {
            $this->error('验证码错误!');
        }
    }
		//团队展示
    function memberlist()
    {
    	
    	
        $model = M('member');
        import('ORG.Util.Page');
        $where = '';
        if (!empty($_REQUEST['keyword'])) 
        {
            $where .= "(username like '%" . htmlspecialchars(trim($_REQUEST['keyword'])) . "%' or realname like '%" . htmlspecialchars(trim($_REQUEST['keyword'])) . "%' or address like '%" . htmlspecialchars(trim($_REQUEST['keyword'])) . "%') and ";
        }
        $where .= "1=1 and `group`  !='visitor' ";

        $count = $model->where($where)->count();
        $p = new Page($count, 5);
        $list = $model->where($where)->order('addtime desc')->limit($p->firstRow . ',' . $p->listRows)->select();
        $p->setConfig('prev', '上一页');
        $p->setConfig('header', '人');
        $p->setConfig('first', '首 页');
        $p->setConfig('last', '末 页');
        $p->setConfig('next', '下一页');
        $p->setConfig('theme', "%first%%upPage%%linkPage%%downPage%%end%
				<li><span><select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select></span></li>\n<li><span>共<font color='#009900'><b>%totalRow%</b></font>人 5人/每页</span></li>");
        $this->assign('page', $p->show());
        $this->assign('list', $list);
         $this->display();
        
    }

		//个人资料修改
    function main()
    {
        self::is_login();
        if ($_POST) 
        {
            $data = array_map('strval', $_POST);
            $data = loopxss($data);
						$data = array_map('htmlentities',$data);
            unset($data['username']);//禁止修改用户名
            unset($data['money']);//禁止修改money
            unset($data['is_lock']);//禁止修改锁定状态
            unset($data['group_id']);//禁止修改锁定状态
            $data['id'] = $_SESSION['userid'];
            $User = D("Member"); // 实例化User对象
            if (!$User->create($_POST,2)) 
            {
                $this->error($User->getError());
            } 
            else 
            {
                $User->save($data);
                $this->success('资料保存成功~');
            }
        } 
        else 
        {
            $info = M('member')->where('id=' . $_SESSION['userid'])->find();
            $this->assign('info', $info);
            $this->display();
        }
    }

		//修改密码
    function changepwd()
    {
        self::is_login();
        if ($_POST) 
        {
            if ($_POST['oldpwd'] == '') 
            {
                $this->error('请输入旧密码!');
            }
            if ($_POST['newpwd'] == '' || $_POST['newpwd'] != $_POST['newpwd2']) 
            {
                $this->error('密码输入不一致!');
            }
            $info = M('member')->where("id=" . $_SESSION['userid'] . " and userpwd='" . md5(md5($_POST['oldpwd'])) . "'")->find();
            if (!$info) 
            {
                $this->error('旧密码不正确!');
            } 
            else 
            {
                $data['id'] = $_SESSION['userid'];
                $data['userpwd'] = md5(md5($_POST['newpwd']));
                M('member')->save($data);
                unset($_SESSION['userid']);
                unset($_SESSION['cms_username']);
                unset($_SESSION['cms_usericon']);
                unset($_SESSION['cms_uservail']);
                $this->assign('jumpUrl', U('Member/login'));
                $this->success('密码修改成功~,请重新登录!');
            }

        } 
        else 
        {
            $this->display();
        }
    }

		//投稿列表
    function tougaolist()
    {
        self::is_login();
        $list = M('article')->where('userid=' . $_SESSION['userid'])->select();
        $this->assign('list', $list);
        $this->display();
    }

	//问答列表
    function wendaolist()
    {
    //    self::is_login();
							
															
				$wenda = M('wenda');
				$map['status'] = 1;
				$list = $wenda->where($map)->select();									
													
        //$list = M('wenda')->where('userid=' . $_SESSION['userid'])->select();
        $this->assign('list', $list);
        $this->display();
    }


    function modpage()
    {
        self::is_login();
        $aid = intval($_REQUEST['aid']);
        if ($_POST) 
        {
						//模拟关闭magic_quotes_gpc 不关闭有时视频用不起
            if(get_magic_quotes_gpc())
            {
            	$_POST = stripslashesRecursive($_POST);
            }
            $_POST['status'] = 0;
            $arc = M('article');
            if (C('TOKEN_ON') && !$arc->autoCheckToken($_POST)) 
            {
                $this->error(L('_TOKEN_ERROR_'));
            }//防止乱提交表单
						$data = array_map('strval', $_POST);
            $data = loopxss($data);
            $arc->where('userid=' . $_SESSION['userid'] . ' and aid=' . $aid)->save($data);
            $this->assign('jumpUrl', U('Member/tougaolist'));
            $this->success('修改成功~,请等待审核!');
        } 
        else 
        {
            $info = M('article')->where('userid=' . $_SESSION['userid'] . ' and aid=' . $aid)->find();
            if (!$info) {
                $this->error('记录不存在');
                exit();
            }
            self::pub_class($info['typeid']);
            $this->assign('info', $info);
        }
        $this->display();
    }

    function delpage()
    {
        self::is_login();
        $aid = intval($_REQUEST['aid']);
        M('article')->where('userid=' . $_SESSION['userid'] . ' and status=0 and aid=' . $aid)->delete();
        $this->success('删除成功!');
    }

		
		//用户投稿可以搞成游客投稿会员投稿只做简单演示表单按自己需求改进
    function tougao()
    {
        self::is_login();
        if ($_POST) 
        {
						//模拟关闭magic_quotes_gpc 不关闭有时视频用不起
            if(get_magic_quotes_gpc()){
            $_POST = stripslashesRecursive($_POST);
            }
            if (empty($_POST['verify']) && !check_wap()) {
                $this->error('验证码必须!');
            }
            if (md5($_POST['verify']) != $_SESSION['verify'] && !check_wap()) {
                $this->error('验证码错误!');
            }
            $data = array_map('strval', $_POST);
            $data = loopxss($data);
						//过滤下标题
            $data['title'] = htmlspecialchars($_POST['title']);
            $data['content'] = htmlspecialchars($_POST['content']);
            $data['status'] = 0;
						$data['addtime'] = date('Y-m-d H:i:s',time());
            $data['userid'] = $_SESSION['userid'];
            $arc = M('article');
            if (C('TOKEN_ON') && !$arc->autoCheckToken($_POST)) {
                $this->error(L('_TOKEN_ERROR_'));
            }//防止乱提交表单
            $arc->add($data);
            $this->success('发布成功请等待管理员审核~');
        } 
        else 
        {
            self::pub_class();
            $this->display();
        }
    }

//订单列表
    function buylist()
    {
        self::is_login();
        $dao = D('TradeView');
        $list = $dao->where('uid=' . $_SESSION['userid'])->select();
        $this->assign('list', $list);
        $this->display();
    }

		//提现
    function tixian()
    {
        self::is_login();
        $money = floatval($_POST['money']);
        if ($_POST['your_email'] == '' || $money <= 0) {
            $this->error('提现参数有错误!');
        }
        $have_money = M('member')->where('id=' . $_SESSION['userid'])->getField('money');
        if (floatval($have_money) < $money) {
            $this->error('提现金额大于您的余额,提现失败!');
        }
        $data = array_map('strval', $_POST);
        $data = loopxss($data);
        $data['status'] = 0;
        $data['uid'] = $_SESSION['userid'];
        $data['addtime'] = time();
        $tx = M('tixian');
        if (C('TOKEN_ON') && !$tx->autoCheckToken($_POST)) {
            $this->error(L('_TOKEN_ERROR_'));
        }//防止乱提交表单
        $tx->add($data);
        unset($data);
        $this->success('提现申请成功，等待2-3个工作日处理!');
    }

    //公共分类
    private function pub_class($type_value = 0)
    {
        $type = M('type');
        $oplist = $type->where('islink=0 and isuser=1')->field("typeid,typename,fid,concat(path,'-',typeid) as bpath")->group('bpath')->select();
        foreach ($oplist as $k => $v) 
        {
            $check = '';
            if ($v['typeid'] == $type_value) 
            {
                $check = 'selected="selected"';
            }
            if ($v['fid'] == 0) 
            {
                $count[$k] = '';
            } 
            else 
            {
                for ($i = 0; $i < count(explode('-', $v['bpath'])) * 2; $i++) 
                {
                    $count[$k] .= '&nbsp;';
                }
            }
            $op .= "<option value=\"" . $v['typeid'] . "\" $check>{$count[$k]}|-{$v['typename']}</option>";
        }
        $this->assign('op', $op);
    }
		//购买VIP
    function vip()
    {
        self::is_login();
        $group_id=intval($_GET['group_id']);
        if($group_id==0)
        {
        	$group_id=5;
        }
        
        $map['_string'] = 'group_id not in(1,2)';
        $membergroups = M('member_group')->where($map)->select();

        $this->assign('membergroup', $membergroups);
        
        $group = M('member_group')->where('group_id=' . $group_id)->find();
       
        $this->assign('group', $group);
        $info = M('member')->where('id=' . $_SESSION['userid'])->find();
        
        $this->assign('uinfo', $info);
        

        $this->display();
    }
		//购物第一步:确认订单
    function gobuy()
    {
        self::is_login();
        $lastbuy = M('member_trade')->where('uid=' . $_SESSION['userid'])->order('addtime desc')->find();
        if ($lastbuy) 
        {
            $info['realname'] = $lastbuy['sh_name'];
            $info['tel'] = $lastbuy['sh_tel'];
            $info['province'] = $lastbuy['province'];
            $info['city'] = $lastbuy['city'];
            $info['area'] = $lastbuy['area'];
            $info['address'] = $lastbuy['address'];
        } 
        else 
        {
            $info = M('member')->where('id=' . $_SESSION['userid'])->find();
        }
        $this->assign('uinfo', $info);
        $iscart = $_REQUEST['iscart'];
        if ($iscart == 1) 
        {
            import('ORG.Util.Cart');
            $cart = new Cart();
            $list = $cart->contents();
            foreach ($list as $k => $v) {
                if ($v['id']) {
                    $list[$k]['gtype'] = $v['option']['gtype'];
                    $list[$k]['pic'] = $v['option']['pic'];
                    $list[$k]['id'] = $v['option']['gid'];
                }
            }
        } 
        else 
        {
						$_REQUEST['price'] = floatval(get_field('article','aid='.intval($_REQUEST['id']),'price'));
            $list = array(0 => $_REQUEST);
        }
        if (!$list) 
        {
            $this->error('您的购物为空，请先选择物品!');
            exit();
        }
        $this->assign('list', $list);
        $this->display();
    }
		
		//下单后付款
    function payagain()
    {
        self::is_login();
        $group_trade_no = I('get.group_trade_no');
        $list = M('member_trade')->where("group_trade_no='{$group_trade_no}'")->select();
        if($list)
        {
            $trade_type = intval($list[0]['trade_type']);
            $total_fee = 0;
            $subject ='';
            foreach($list as $k=>$v)
            {
                $total_fee += $v['price'] * $v['num'];
                if (strlen($subject) < 200) 
                {
                    $subject .= get_field('article','aid='.$v['gid'],'title');
                }
            }
            
            if($trade_type==0 || $trade_type== 2)
            {
                $this->error('该订单为货到付款无须支付!');
            }
            
						$new_trade_no = $group_trade_no . '-'.time();
            if ($trade_type == 1) 
            {
								//支付宝支付
                $t_path = (intval(C('AP_TYPE')) == 1) ? 'ap_jishi' : 'ap_danbao';
                $url = "http://" . $_SERVER['HTTP_HOST'] . __ROOT__ . "/Trade/" . $t_path . "/alipayapi.php";
                $post_data = array("WIDtotal_fee" => $total_fee, "WIDsubject" => $subject, "WIDreceive_name" => $list[0]['sh_name'], "WIDreceive_address" => $list[0]['province'].$list[0]['city'].$list[0]['area'].$list[0]['address'], "WIDreceive_mobile" => $list[0]['sh_tel'], "WIDreceive_phone" => "", "WIDout_trade_no" => $new_trade_no, "WIDshow_url" => "http://www.qiruanwang.com/Public/donate", "WIDbody" => "", "WIDreceive_zip" => "", "WIDseller_email" => C("AP_EMAIL"));
            } 
            else 
            {
								//微信支付
                if ($trade_type == 4) 
                {
                    $url = "http://" . $_SERVER['HTTP_HOST'] . __ROOT__ . "/Trade/Wxpay/dopay/jsapi.php";
                } 
                else 
                {
                    $url = "http://" . $_SERVER['HTTP_HOST'] . __ROOT__ . "/Trade/Wxpay/dopay/native.php";
                }
                $post_data = array("WIDtotal_fee" => $total_fee, "WIDsubject" => $subject, "WIDout_trade_no" => $new_trade_no, "WIDbody" => strip_tags('支付订单'.$group_trade_no));
            }
            
            //var_dump($post_data);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            $output = curl_exec($ch);
            curl_close($ch);
            echo $output;
        }
        else
        {
            $this->error('找不到订单');
        }
    }
    
		//订单处理
    function dobuy()
    {
        self::is_login();
        if (!$_POST) 
        {
            exit();
        }
        if (!is_array($_POST['id'])) 
        {
            $this->error('您的购物为空!');
            exit();
        }
      
        if ($_POST['realname'] == '' || $_POST['tel'] == '') 
        {
            $this->error('收货人信息为空!');
            exit();
        }
        $trade_type = (int)$_POST['trade_type'];
        $iscart = (int)$_POST['iscart'];
        $group_trade_no = "GB" . time() . "-" . $_SESSION['userid'];
        
        if ($iscart == 1) 
        {
            import('ORG.Util.Cart');
            $cart = new Cart();
            $cart->destroy();
        }
        $_POST = loopxss($_POST);
        $trade = M('member_trade');
        if (C('TOKEN_ON') && !$trade->autoCheckToken($_POST)) 
        {
            $this->error(L('_TOKEN_ERROR_'));
        }
        
				//循环出购物车 写进数据库
        if ($trade_type == 1 || $trade_type == 4 || $trade_type == 5) 
        {
        	  
            $title = '';
            $subject = '';
            $total_fee = 0;
            $total_num = 0;
            for ($i = 0; $i < count($_POST['id']); $i++) 
            {
                if (!is_numeric($_POST['id'][$i]) || !is_numeric($_POST['price'][$i]) || !is_numeric($_POST['qty'][$i])) 
                {
                    continue;
                }
                $data['gid'] = $_POST['id'][$i];
                $data['uid'] = $_SESSION['userid'];
                $data['price'] = floatval(get_field('article','aid='.intval($_POST['id'][$i]),'price'));//$_POST['price'][$i];//信任客户端表单可以改写哈$_POST['price'][$i]
                $data['province'] = $_POST['province'];
                $data['city'] = $_POST['city'];
                $data['area'] = $_POST['area'];
                $data['sh_name'] = $_POST['realname'];
                $data['sh_tel'] = $_POST['tel'];
                $data['address'] = $_POST['address'];
                $data['group_trade_no'] = $group_trade_no;
                $data['out_trade_no'] = "DB" . time() . "-" . $_SESSION['userid'];
                $data['servial'] = $_POST['gtype'][$i];
                $data['status'] = 0;
                $data['trade_type'] = $trade_type;
                $data['addtime'] = time();
                $data['num'] = abs(intval($_POST['qty'][$i]));
                $total_fee += ($data['num'] * $data['price']) * 1;
                $total_num += $data['num'];
                $trade->add($data);
                if (strlen($subject) < 200) 
                {
                    $subject .= $_POST['name'][$i];
                }
                if (strlen($title) < 400) 
                {
                    $title .= $_POST['name'][$i] . "&nbsp;&nbsp;数量:" . $data['num'] . ' 单价:' . $data['price'] . '<br>';
                }
            }
            if (intval(C('MAIL_TRADE')) == 1) 
            {
                $config = F('basic', '', './Web/Conf/');
                $user_name = $config[sitetitle] . '管理员';
                $subject = $config[sitetitle] . '订单提醒';
                $bodyurl = '下单时间：' . date('Y-m-d H:i:s', time()) . '<br>会员编号:' . $_SESSION['userid'] . '<br>姓名：' . $_POST['realname'] . '<br>订单号：' . $group_trade_no . '<br>付款方式:支付宝在线交易<br>订购物件：<br>' . $title . '<br>总数量:' . $total_num . '<br>总金额:' . $total_fee . '元';
                $sendto_email = C('MAIL_TOADMIN');
                $email_port = C('MAIL_PORT');
                send_mail($sendto_email, $user_name, $subject, $bodyurl, $email_port);
            }
            if ($trade_type == 1) 
            {
								//支付宝支付
								
                $t_path = (intval(C('AP_TYPE')) == 1) ? 'ap_jishi' : 'ap_danbao';
                $url = "http://" . $_SERVER['HTTP_HOST'] . __ROOT__ . "/Trade/" . $t_path . "/alipayapi.php";
                //  $this->error($url);
                $post_data = array("WIDtotal_fee" => $total_fee, "WIDsubject" => $subject, "WIDreceive_name" => $_POST['realname'],
                 "WIDreceive_address" => $_POST['address'], "WIDreceive_mobile" => $_POST['tel'], 
                 "WIDreceive_phone" => "", "WIDout_trade_no" => $group_trade_no, 
                 "WIDshow_url" => "http://localhost/index.php?s=/articles/127.html", "WIDbody" => "", "WIDreceive_zip" => "", "WIDseller_email" => C("AP_EMAIL"));
            } 
            else 
            {
								//微信支付
                if ($trade_type == 4) 
                {
                    $url = "http://" . $_SERVER['HTTP_HOST'] . __ROOT__ . "/Trade/Wxpay/dopay/jsapi.php";
                } 
                else 
                {
                    $url = "http://" . $_SERVER['HTTP_HOST'] . __ROOT__ . "/Trade/Wxpay/dopay/native.php";
                }
                $post_data = array("WIDtotal_fee" => $total_fee, "WIDsubject" => $subject, "WIDout_trade_no" => $group_trade_no, "WIDbody" => strip_tags($title));
            }
              
         /*   foreach ($post_data as $k => $v) 
            {
                $tdata[] = ($k . '=' . $v);
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            $output = curl_exec($ch);
            curl_close($ch);
           //  $this->error($output);
            echo $output;
            */
            
         
            require_once("trade/ap_jishi/logs.php");
						require_once("trade/ap_jishi/alipay.config.php");
						
						require_once("trade/ap_jishi/lib/alipay_submit.class.php");

						insertToLogRoot("alipayapi.php", "begin...");
		        //支付类型
						$payment_type="1";
						$notify_url='http://localhost/index.php/Public/shouquan';
						//需http://格式的完整路径，不能加?id=123这类自定义参数
						//页面跳转同步通知页面路径(客户端的)
						$return_url='http://localhost/Trade/ap_jishi/return_url.php';
		        //卖家支付宝帐户
		        $seller_email =  C("AP_EMAIL");
            
		        //必填
						insertToLogRoot("alipayapi.php",$seller_email);
		        //商户订单号
		        $out_trade_no = $group_trade_no;
		        //商户网站订单系统中唯一订单号，必填


		     
		        //订单描述

		        $body = strip_tags($title);
       
		        //商品展示地址
		        $show_url = "http://localhost/index.php?s=/articles/127.html";
		        //需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html

				
				 //收货人姓名
		        $receive_name = $_POST['realname'];
		        //如：张三

		        //收货人地址
		        $receive_address = $_POST['address'];
		        //如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号

		        //收货人邮编
		        $receive_zip ="";
		        //如：123456

		        //收货人电话号码
		        $receive_phone = "";
		        //如：0571-88158090

		        //收货人手机号码
		        $receive_mobile = $_POST['tel'];
		        //如：13312341234
				
		        //防钓鱼时间戳
		        $anti_phishing_key = "";
		        //若要使用请调用类文件submit中的query_timestamp函数

		        //客户端的IP地址
		        $exter_invoke_ip = "";
		        //非局域网的外网IP地址，如：221.0.0.1
				

						//构造要请求的参数数组，无需改动
						$parameter = array(
							"service" => "create_direct_pay_by_user",
							"partner" => trim($alipay_config['partner']),
							"payment_type"	=> $payment_type,
							"notify_url"	=> $notify_url,
							"return_url"	=> $return_url,
							"seller_email"	=> $seller_email,
							"out_trade_no"	=> $out_trade_no,
							"subject"	=> $subject,
							"total_fee"	=> $total_fee,
							"body"	=> $body,
							"show_url"	=> $show_url,
							"receive_name"	=> $receive_name,
							"receive_address"	=> $receive_address,
							"receive_zip"	=> $receive_zip,
							"receive_phone"	=> $receive_phone,
							"receive_mobile"	=> $receive_mobile,
							"anti_phishing_key"	=> $anti_phishing_key,
							"exter_invoke_ip"	=> $exter_invoke_ip,
							"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
					);

						//建立请求
						
						$alipaySubmit = new AlipaySubmit($alipay_config);
						$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
						echo $html_text;
						/*
						require_once("trade/ap_jishi/lib/qrcode.php");
						$appid = "2088002634919909";  //https://open.alipay.com 账户中心->密钥管理->开放平台密钥，填写添加了电脑网站支付的应用的APPID
						$notify_url='http://localhost/index.php/Public/shouquan';   //付款成功后的异步回调地址
						$outTradeNo =  $group_trade_no;//uniqid();     //你自己的商品订单号，不能重复
						$payAmount = $total_fee;          //付款金额，单位:元
						$orderName =  $subject;    //订单标题
						$signType = 'RSA2';			//签名算法类型，支持RSA2和RSA，推荐使用RSA2
						$rsaPrivateKey=$alipay_config['key'];		//商户私钥，填写对应签名算法类型的私钥，如何生成密钥参考：https://docs.open.alipay.com/291/105971和https://docs.open.alipay.com/200/105310
							insertToLogRoot("alipayapi.php", 	$rsaPrivateKey);
						
						$aliPay = new AlipayService();
						$aliPay->setAppid($appid);
						$aliPay->setNotifyUrl($notifyUrl);
						$aliPay->setRsaPrivateKey($rsaPrivateKey);
						$aliPay->setTotalFee($payAmount);
						$aliPay->setOutTradeNo($outTradeNo);
						$aliPay->setOrderName($orderName);

						$result = $aliPay->doPay();
						$result = $result['alipay_trade_precreate_response'];
						if($result['code'] && $result['code']=='10000')
						{
						    //生成二维码
						    $url = 'https://www.kuaizhan.com/common/encode-png?large=true&data='.$result['qr_code'];
						    echo "<img src='{$url}' style='width:300px;'><br>";
						    echo '二维码内容：'.$result['qr_code'];
						}
						else
						{
						    echo $result['msg'].' : '.$result['sub_msg'];
						}
						 */
        } 
        else if ($trade_type == 2) 
        {
						//货到付款
            $title = '';
            $total_fee = 0;
            $total_num = 0;
            for ($i = 0; $i < count($_POST['id']); $i++) 
            {
                if (!is_numeric($_POST['id'][$i]) || !is_numeric($_POST['price'][$i]) || !is_numeric($_POST['qty'][$i])) {
                    continue;
                }
                $data['gid'] = $_POST['id'][$i];
                $data['uid'] = $_SESSION['userid'];
                $data['price'] = floatval(get_field('article','aid='.intval($_POST['id'][$i]),'price'));//$_POST['price'][$i];//必须,信任客户端表单可以改写哈$_POST['price'][$i]
                $data['province'] = $_POST['province'];
                $data['city'] = $_POST['city'];
                $data['area'] = $_POST['area'];
                $data['sh_name'] = $_POST['realname'];
                $data['sh_tel'] = $_POST['tel'];
                $data['address'] = $_POST['address'];
                $data['group_trade_no'] = $group_trade_no;
                $data['out_trade_no'] = "DB" . time() . "-" . $_SESSION['userid'];
                $data['servial'] = $_POST['gtype'][$i];
                $data['status'] = 11;//等待付款,等待发货
                $data['trade_type'] = 2;
                $data['addtime'] = time();
                $data['num'] = abs(intval($_POST['qty'][$i]));
                $total_fee += ($data['num'] * $data['price']) * 1;
                $total_num += $data['num'];
                $trade->add($data);
                //echo $trade->getLastSql().'<BR>';
                if (strlen($title) < 400) {
                    $title .= $_POST['name'][$i] . "&nbsp;&nbsp;数量:" . $data['num'] . ' 单价:' . $data['price'] . '<br>';
                }
            }
            if (intval(C('MAIL_TRADE')) == 1) 
            {
                $config = F('basic', '', './Web/Conf/');
                $user_name = $config[sitetitle] . '管理员';
                $subject = $config[sitetitle] . '订单提醒';
                $bodyurl = '下单时间：' . date('Y-m-d H:i:s', time()) . '<br>会员编号:' . $_SESSION['userid'] . '<br>姓名：' . $_POST['realname'] . '<br>订单号：' . $group_trade_no . '<br>付款方式:货到付款<br>订购物件：<br>' . $title . '<br>总数量:' . $total_num . '<br>总金额:' . $total_fee . '元';
                $sendto_email = C('MAIL_TOADMIN');
                $email_port = C('MAIL_PORT');
                send_mail($sendto_email, $user_name, $subject, $bodyurl, $email_port);
            }
            $this->assign('group_trade_no', $group_trade_no);
            $this->display('buysuccess');
        } 
        else if ($trade_type == 3) 
        {
            $title = '';
            $total_fee = 0;
            $total_num = 0;
            for ($i = 0; $i < count($_POST['id']); $i++) 
            {
                $price = (float)M('article')->where('aid=' . intval($_POST['id'][$i]))->getField('price');
                if (!is_numeric($_POST['id'][$i]) || !is_numeric($_POST['price'][$i]) || !is_numeric($_POST['qty'][$i])) {
                    continue;
                }
                $total_fee += (abs(intval($_POST['qty'][$i])) * $price) * 1;
            }
            $have_money = M('member')->where('id=' . $_SESSION['userid'])->getField('money');
            if ($have_money < $total_fee) {
                $this->assign('jumpUrl', U('Member/chongzhi'));
                $this->error('您的余额不足，请充值!');
                exit();
            }
            for ($i = 0; $i < count($_POST['id']); $i++) {
                if (!is_numeric($_POST['id'][$i]) || !is_numeric($_POST['price'][$i]) || !is_numeric($_POST['qty'][$i])) {
                    continue;
                }
                $data['gid'] = $_POST['id'][$i];
                $data['uid'] = $_SESSION['userid'];
                $data['price'] = floatval(get_field('article','aid='.intval($_POST['id'][$i]),'price'));//$_POST['price'][$i];//必须,信任客户端表单可以改写哈$_POST['price'][$i]
                $data['province'] = $_POST['province'];
                $data['city'] = $_POST['city'];
                $data['area'] = $_POST['area'];
                $data['sh_name'] = $_POST['realname'];
                $data['sh_tel'] = $_POST['tel'];
                $data['address'] = $_POST['address'];
                $data['group_trade_no'] = $group_trade_no;
                $data['out_trade_no'] = "DB" . time() . "-" . $_SESSION['userid'];
                $data['servial'] = $_POST['gtype'][$i];
                $data['status'] = 1;//已付款等待发货
                $data['trade_type'] = 3;
                $data['addtime'] = time();
                $data['num'] = abs(intval($_POST['qty'][$i]));
                $total_num += $data['num'];
                $trade->add($data);
                if (strlen($title) < 400) {
                    $title .= $_POST['name'][$i] . "&nbsp;&nbsp;数量:" . $data['num'] . ' 单价:' . $data['price'] . '<br>';
                }
            }
//扣款
            M('member')->where('id=' . $_SESSION['userid'])->setDec('money', $total_fee);
            if (intval(C('MAIL_TRADE')) == 1) {
                $config = F('basic', '', './Web/Conf/');
                $user_name = $config[sitetitle] . '管理员';
                $subject = $config[sitetitle] . '订单提醒';
                $bodyurl = '下单时间：' . date('Y-m-d H:i:s', time()) . '<br>会员编号:' . $_SESSION['userid'] . '<br>姓名：' . $_POST['realname'] . '<br>订单号：' . $group_trade_no . '<br>付款方式:站内扣款<br>订购物件：<br>' . $title . '<br>总数量:' . $total_num . '<br>总金额:' . $total_fee . '元';
                $sendto_email = C('MAIL_TOADMIN');
                $email_port = C('MAIL_PORT');
                send_mail($sendto_email, $user_name, $subject, $bodyurl, $email_port);
            }
            $this->assign('group_trade_no', $group_trade_no);
            $this->display('buysuccess');
        } 
        else 
        {
            $this->error('交易方式不确定!');
            exit();
        }
    }

		//删除交易记录
    function deltrade()
    {
        $buyid = intval($_REQUEST['buyid']);
        M('member_trade')->where('buy_id=' . $buyid . ' and uid=' . $_SESSION['userid'])->delete();
				//echo M('member_trade')->getLastSql();
        $this->success('删除成功!');
    }

		//QQ登陆
    function qqlogin()
    {
        //$lasturl = urlencode(htmlspecialchars($_SERVER['HTTP_REFERER']));
        //$this->qqconfig['callback'] .= ('&lasturl=' . $lasturl);
        import('ORG.Util.Qqlogin');
        $o_qq = Oauth_qq::getInstance($this->qqconfig);
        $o_qq->login();
    }

    //微信扫码登陆
    function wxlogin()
    {
        //$lasturl = urlencode(htmlspecialchars($_SERVER['HTTP_REFERER']));
        //$this->wxconfig['callback'] .= ('&lasturl=' . $lasturl);
        import('ORG.Util.Wxlogin');
        $wx = Wxlogin::getInstance($this->wxconfig);
        $wx->login();
    }

    function qqcallback()
    {
        import('ORG.Util.Qqlogin');
        $lasturl = urlencode(htmlspecialchars('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
        $o_qq = Oauth_qq::getInstance($this->qqconfig);
        $o_qq->callback();
        $qid = $o_qq->get_openid();
        if ($qid != '') 
        {
            $info = M('member')->where("qid='$qid'")->find();
            if ($info) 
            {
								//已经绑定帐号
                $_SESSION['userid'] = $info['id'];
                $_SESSION['cms_username'] = $info['username'];
                $_SESSION['cms_usericon'] = $info['icon'];
                if (!empty($_REQUEST['lasturl'])) 
                {
                    $this->assign('jumpUrl', urldecode(htmlspecialchars($_REQUEST['lasturl'])));
                } 
                else 
                {
                    $this->assign('jumpUrl', U('Member/main'));
                }
                $this->success('登录成功~');
            } 
            else 
            {
								//首次绑定
                $userinfo = $o_qq->get_user_info();
								//print_r($userinfo);
                $this->assign('userinfo', $userinfo);
                $this->assign('qid', $qid);
                $this->display();
            }
        }
    }

    public function call_wxbind($openid,$userinfo = null)
    {
        if ($openid != '') 
        {
            $info = M('member')->where("wx_openid='{$openid}'")->find();
            if ($info) 
            {
                //已经绑定帐号
                $_SESSION['userid'] = $info['id'];
                $_SESSION['cms_username'] = $info['username'];
                $_SESSION['cms_usericon'] = $info['icon'];
                if (!empty($_REQUEST['lasturl'])) {
                    $this->assign('jumpUrl', urldecode(htmlspecialchars($_REQUEST['lasturl'])));
                } else {
                    $this->assign('jumpUrl', U('Member/main'));
                }
                $this->success('登录成功~');
            } 
            else 
            { 
            	//首次绑定
                $this->assign('userinfo', $userinfo);
                $this->assign('wx_openid', $openid);
                $this->display('qqcallback');
            }
        }
        else
        {
        	$this->error('参数错误');
        }
    }
    
    //微信授权返回
    function wxcallback()
    {
        import('ORG.Util.Wxlogin');
        $wx = Wxlogin::getInstance($this->wxconfig);
        $userinfo = $wx->get_user_info();
        $openid = $userinfo->openid;
        self::call_wxbind($openid,$userinfo);
    }

    //微信里的微信绑定
    function bindwx()
    {
        $openid = I('openid');
        self::call_wxbind($openid);
    }

		//创建帐号
    function qqcreate()
    {
        $data = array_map('strval', $_POST);
        $data = loopxss($data);
        unset($data['money']);//禁止修改money
        unset($data['is_lock']);//禁止修改锁定状态
        if ($data['realname'] == '' || ($data['wx_openid'] == '' && $data['qid'] == '')) {
            $this->error('参数错误!');
            exit();
        }
        $t = M('member')->where("username='" . $data['realname'] . "'")->find();
        
        if (!$t) 
        {
            $data['username'] = $data['realname'];
        } 
        else 
        {
            $data['username'] = (string)time();
        }
        $data['userpwd'] = md5(md5(time() . rand(0, 9999)));
        $User = D("Member"); // 实例化User对象
        if (!$User->create()) 
        {
            $this->error($User->getError());
        } 
        else 
        {
            $config = F('basic', '', './Web/Conf/');
            $data['group_id'] = intval($config['defaultmp']);
            $uid = M('member')->add($data);
            $_SESSION['userid'] = $uid;
            $_SESSION['cms_username'] = $data['username'];
            $_SESSION['cms_usericon'] = $data['icon'];
            $_SESSION['cms_uservail'] = get_field('member_group', 'group_id=' . $data['group_id'], 'group_vail');
            if (!empty($_REQUEST['lasturl'])) 
            {
                $this->assign('jumpUrl', urldecode(htmlspecialchars($_REQUEST['lasturl'])));
            } 
            else 
            {
                $this->assign('jumpUrl', U('Member/main'));
            }
            $this->success('绑定成功,正在登陆~');
        }
    }


		//绑定帐号
    function qqupdate()
    {
        $username = inject_check($_POST['username']);
        $userpwd = $_POST['userpwd'];
        $qid = $_POST['qid'];
        $openid = $_POST['openid'];
        $icon = $_POST['icon'];
        if ($username == '' || $userpwd == '' || ($openid == '' && $qid == '')) {
            $this->error('请输入用户名和密码?');
            exit();
        }
        $info = M('member')->where("username='{$username}' and is_lock=0")->find();
        if (!$info) {
            $this->error('用户不存在或已经禁止登陆!');
        } else {
            if ($info['userpwd'] != md5(md5($userpwd))) {
                $this->error('密码错误，绑定失败!');
            } else {
                $_SESSION['userid'] = $info['id'];
                $_SESSION['cms_username'] = $info['username'];
                $_SESSION['cms_usericon'] = $icon;
                $_SESSION['cms_uservail'] = get_field('member_group', 'group_id=' . $info['group_id'], 'group_vail');
                if ($qid != '') {
                    $data['qid'] = $qid;
                }
                if ($openid != '') {
                    $data['openid'] = $openid;
                }
                if ($icon != '') {
                    $data['icon'] = $icon;
                }
                M('member')->where("username='{$username}' and is_lock=0")->save($data);
                if (!empty($_REQUEST['lasturl'])) {
                    $this->assign('jumpUrl', urldecode(htmlspecialchars($_REQUEST['lasturl'])));
                } else {
                    $this->assign('jumpUrl', U('Member/main'));
                }
                $this->success('绑定成功,正在登陆~');
            }
        }
    }

		//收藏夹列表
    function fav()
    {
        $this->title = '我的收藏';
        $list = D('FavoritesView')->where('favorites.uid=' . $_SESSION['userid'])->select();
        $this->list = $list;
        $this->display();
    }

		//加入收藏夹
    function fav_save()
    {
        if (!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
            $this->ajaxReturn(array('status' => 0, 'info' => '您还没有登录，请登录!'));
        }
        $aid = intval($_REQUEST['aid']);
        if ($aid > 0) {

            $t = M('favorites')->where('aid=' . $aid)->find();
            if ($t) {
                $this->ajaxReturn(array('status' => 0, 'info' => '您已经收藏过该文章!'));
            } else {
                $data['aid'] = $aid;
                $data['uid'] = $_SESSION['userid'];
                $data['addtime'] = time();
                M('favorites')->add($data);
                $this->ajaxReturn(array('status' => 1, 'info' => '收藏成功!'));
            }
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '文章ID错误,收藏失败!'));
        }
    }

		//删除收藏夹
    function fav_del()
    {
        if (!isset($_SESSION['userid']) || $_SESSION['userid'] == '') 
        {
            $this->ajaxReturn(array('status' => 0, 'info' => '您还没有登录，请登录!'));
        }
        $aid = intval($_REQUEST['aid']);
        M('favorites')->where('aid=' . $aid . ' and uid=' . $_SESSION['userid'])->delete();
        $this->ajaxReturn(array('status' => 1, 'info' => '收藏删除成功!'));
    }
		//类结束
}