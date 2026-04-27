<?php

class ClassroomAction extends BaseAction
{
	
	Public function _empty()
	{ 
		alert('方法不存在',U('Classroom/index'));
	} 
	
	public function index()
	{
	    $this->assign('title','用户提问');
		//用于ajaxjs的根路径变量
			$url=__ROOT__;
		
		$this->assign('url',$url);
		$CategoryId=intval($_GET['CategoryId']);
		$this->assign('CategoryId',$CategoryId); 

	
		  //加载扩展字段	
		  //$typeid="2";
     	//	$extend_field =M('extend_show')->join(C('DB_PREFIX').'extend_fieldes on '.C('DB_PREFIX').'extend_show.field_id='.C('DB_PREFIX').'extend_fieldes.field_id')->where(C('DB_PREFIX').'extend_show.is_show=1 and '.C('DB_PREFIX').'extend_show.typeid='.$typeid)->field(C('DB_PREFIX').'extend_fieldes.*')->order(C('DB_PREFIX').'extend_fieldes.orders')->select();
		// $this->assign('extend_field', $extend_field);
    // $effectlevel=0;
  	$effectlevel=intval($_GET['effectlevel']);
    if($effectlevel!=0)
    {
        	inject_check($_GET['effectlevel']);   
        	$data['effectlevel'] =$effectlevel;   
    }
		$this->assign('effectlevel',$effectlevel);
				
	  //$location=0;
    $location=intval($_GET['location']);
    if($location!=0)
    {
        	inject_check($_GET['location']);    
        	$data['location'] =$location; 
    }
		$this->assign('location',$location);       
        
        	//读取数据库
		$course = M('course');
		$config = F('basic','','./Web/Conf/');
		
		//相关判断
		$data['status'] = 1;
	
		if($CategoryId!=0)
		{
				//echo "aa".$CategoryId;
			$data['CategoryId'] =$CategoryId;
		}
else{
		$data['CategoryId'] =0;
}		
		
		$list = $course->where($data)->select();
	
		
		//分页处理
	
		
		C('VAR_PAGE','page');
		import('ORG.Util.Page');	
		
		$count = $course->where($data)->count();
		$this->assign('count',$count);
			//每10条分页
		$pagenum = 10;
	  $p = new Page($count, $pagenum);
	  $p->setConfig('prev', '上一页');
    $p->setConfig('header', '篇文章');
    $p->setConfig('first', '首 页');
    $p->setConfig('last', '末 页');
    $p->setConfig('next', '下一页');
    if (check_wap()) 
    {
            $temp_str = "%first%%upPage%%downPage%%end%";
    } 
    else 
    {
            $temp_str = "%first%%upPage%%prePage%%linkPage%%nextPage%%downPage%%end%
						<select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select>共<font color='#CD4F07'><b>%totalRow%</b></font>篇 " . $pernum . "篇/每页";
    }    
    $p->setConfig('theme', $temp_str);
				
				
	
		
		//总页数
		$totalpages = ceil($count / $pagenum);
		$plist = $course->where($data)->order('public_time desc')->limit($p->firstRow.','.$p->listRows)->select();
	
		foreach($plist as $k=>$v)
		{
			if(!empty($v['recontent']))
			{
				$v['recontent'] = '<font color=red><b>问题回复：'.$v['recontent'].'</b></font>';
			}
			$pp[$k]=$v;
			$pp[$k]['num'] = $k + 1 + (intval($_GET['page']) - 1) * $pagenum;
		}
	
		//封装变量
    	$this->assign('page', $p->show());
      
		$this->assign('list',$pp);
	
		//当前页
		$nowpage=intval($_GET['page']);
		//$this->assign('nowpage',$nowpage);
		//起始编号
		if($nowpage!=0)
		{
			$startnumber=($nowpage-1)*$pagenum+1;
		}
		else
		{
				$startnumber=1;
		}
		$this->assign('startnumber',$startnumber);
		//总页数
		//$this->assign('totalpages',$totalpages); 
		
		//最后一条记录数
		//$this->assign('lastnum',$pagenum);
		  //释放内存
		 
    		unset($pp, $count, $p, $totalpages, $plist);
	
		$this->display(TMPL_PATH.cookie('think_template').'/classroom.html');

	}
	
public function chapter()
    {
	        $type = M('course');
			$list = $type->where('id='.$_GET['id'])->find();
			$this->assign('list',$list);
			echo($_GET['courseId']);
			$this->assign('courseid', $_GET['courseId']);
	        $this->display('chapter');
    }

	public function mywendalist()
	{
	    $this->assign('title','用户提问');
		//用于ajaxjs的根路径变量
			$url=__ROOT__;
		   $member_menu = S('member_menu');
        if (!is_array($member_menu)) 
        {
            $member_menu = M('member_menu')->where('is_show=1')->order('drand')->select();
            S('member_menu', $member_menu);
        }
        $this->assign('member_menu', $member_menu);
        
		$this->assign('url',$url);
		$CategoryId=$_GET['CategoryId'];
		$this->assign('CategoryId',$CategoryId); 

		//	echo $CategoryId;
		  //加载扩展字段	
		  //$typeid="2";
     	//	$extend_field =M('extend_show')->join(C('DB_PREFIX').'extend_fieldes on '.C('DB_PREFIX').'extend_show.field_id='.C('DB_PREFIX').'extend_fieldes.field_id')->where(C('DB_PREFIX').'extend_show.is_show=1 and '.C('DB_PREFIX').'extend_show.typeid='.$typeid)->field(C('DB_PREFIX').'extend_fieldes.*')->order(C('DB_PREFIX').'extend_fieldes.orders')->select();
		// $this->assign('extend_field', $extend_field);
    // $effectlevel=0;
  	$effectlevel=intval($_GET['effectlevel']);
    if($effectlevel!=0)
    {
        	inject_check($_GET['effectlevel']);   
        	$data['effectlevel'] =$effectlevel;   
    }
		$this->assign('effectlevel',$effectlevel);
				
	  //$location=0;
    $location=intval($_GET['location']);
    if($location!=0)
    {
        	inject_check($_GET['location']);    
        	$data['location'] =$location; 
    }
		$this->assign('location',$location);       
        
        	//读取数据库
		$Course = M('wenda');
		$config = F('basic','','./Web/Conf/');
		
		//相关判断
		$data['status'] = 1;
	
		if($CategoryId!=0)
		{
				//echo "aa".$CategoryId;
			$data['CategoryId'] =$CategoryId;
		}
		
		$data['userid']=$_SESSION['userid'];
		$list = $Course->where($data)->select();
	
		
		//分页处理

		C('VAR_PAGE','page');
		import('ORG.Util.Page');	
		
		$count = $Course->where($data)->count();
		$this->assign('count',$count);
			//每10条分页
		$pagenum = 10;
	  $p = new Page($count, $pagenum);
	  $p->setConfig('prev', '上一页');
    $p->setConfig('header', '篇文章');
    $p->setConfig('first', '首 页');
    $p->setConfig('last', '末 页');
    $p->setConfig('next', '下一页');
    if (check_wap()) 
    {
            $temp_str = "%first%%upPage%%downPage%%end%";
    } 
    else 
    {
            $temp_str = "%first%%upPage%%prePage%%linkPage%%nextPage%%downPage%%end%
						<select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select>共<font color='#CD4F07'><b>%totalRow%</b></font>篇 " . $pernum . "篇/每页";
    }    
    $p->setConfig('theme', $temp_str);
				
				
	
		
		//总页数
		$totalpages = ceil($count / $pagenum);
		$plist = $Course->where($data)->order('public_time desc')->limit($p->firstRow.','.$p->listRows)->select();
	
		foreach($plist as $k=>$v)
		{
			if(!empty($v['recontent']))
			{
				$v['recontent'] = '<font color=red><b>问题回复：'.$v['recontent'].'</b></font>';
			}
			$pp[$k]=$v;
			$pp[$k]['num'] = $k + 1 + (intval($_GET['page']) - 1) * $pagenum;
		}
	
		//封装变量
    	$this->assign('page', $p->show());
      
		$this->assign('list',$pp);
	
		//当前页
		$nowpage=intval($_GET['page']);
		//$this->assign('nowpage',$nowpage);
		//起始编号
		if($nowpage!=0)
		{
			$startnumber=($nowpage-1)*$pagenum+1;
		}
		else
		{
				$startnumber=1;
		}
		$this->assign('startnumber',$startnumber);
		//总页数
		//$this->assign('totalpages',$totalpages); 
		
		//最后一条记录数
		//$this->assign('lastnum',$pagenum);
		  //释放内存
		 
    		unset($pp, $count, $p, $totalpages, $plist);
	
		$this->display(TMPL_PATH.cookie('think_template').'/wenda_mine.html');

	}    
	public function tiwen()
	{
	  $this->assign('title','用户提问');
	//用于ajaxjs的根路径变量
		$url=__ROOT__;
		
		$this->assign('url',$url);
		$CategoryId=$_GET['CategoryId'];
		//echo $CategoryId;
		$this->display(TMPL_PATH.cookie('think_template').'/wenda_tiwen.html');
	}
	public function update()
	{
	//输出gb2312码,ajax默认转的是utf-8
		header("Content-type: text/html; charset=utf-8");
		
	//	echo "aaa";
		if(!isset($_POST['author']) or !isset($_POST['content']))
		{
			alert('非法操作!',3);
		}
		//读取数据库和缓存
		$Course = M('wenda');
		$config = F('basic','','./Web/Conf/');
		//相关判断
		if(Session::is_set('posttime'))
		{
			$temp = Session::get('posttime') + $config['postovertime'];
			if(time() < $temp)
			{
				echo "请不要连续发布!";
				exit;
			}
		}
		//准备工作
		if($config['bookoff'] == 0) 
		$data['status'] = "0";

		//先解密js的escape
		$data['author'] = htmlspecialchars(unescape($_POST['author']));
		$data['content'] = htmlspecialchars(trim(unescape($_POST['content'])));
		$data['recontent'] = "";
		$data['location'] = "";
		$data['effectlevel'] = "";
		$data['userid'] = $_SESSION['userid'];	
		$data['title'] = htmlspecialchars(trim(unescape($_POST['title'])));
		$data['tel'] = htmlspecialchars(trim(unescape($_POST['tel'])));
		$data['email'] = htmlspecialchars(trim(unescape($_POST['email'])));
		$data['ip'] = remove_xss(htmlentities(get_client_ip()));
		$data['public_time'] = date('Y-m-d H:i:s');
		$data['CategoryId'] = intval($_POST['CategoryId']);
		//处理数据
		if($Course->add($data))
		{
			Session::set('posttime', time());
			
			if($config['bookoff'] == 0)
			{
				echo '发布成功,问题需要管理员审核!';
				exit;
				//$this->assign("jumpUrl",U('Wenda/tiwen'));
				//$this->success('发布成功,问题需要管理员审核!');
			}
			else
			{
				echo '发布成功!';
				exit;
			//	$this->assign("jumpUrl",U('Wenda/tiwen'));
			//	$this->success('发布成功,问题需要管理员审核!');
			}
		}
		else
		{
			echo '发布失败!';
			exit;
		}
	}
	
	public function show()
	{
	//读取数据库
		$Course = M('wenda');
		$config = F('basic','','./Web/Conf/');
		
		//相关判断
		$data['status'] = 1;
		$CategoryId=$_GET['CategoryId'];
	
		if($CategoryId!=0)
		{
				//echo "aa".$CategoryId;
			$data['CategoryId'] =$CategoryId;
		}
		$list = $Course->where($data)->select();
		if(!$list)
		{
			$this->display(TMPL_PATH.cookie('think_template').'/wenda_nopl.html','utf-8','text/xml');
			exit;
		}
		
		//分页处理
	
		
		C('VAR_PAGE','page');
		import('ORG.Util.Page');	
		
		$count = $Course->where($data)->count();
		$this->assign('count',$count);
			//每10条分页
		$pagenum = 10;
	  $p = new Page($count, $pagenum);
	  $p->setConfig('prev', '上一页');
    $p->setConfig('header', '篇文章');
    $p->setConfig('first', '首 页');
    $p->setConfig('last', '末 页');
    $p->setConfig('next', '下一页');
    if (check_wap()) 
    {
            $temp_str = "%first%%upPage%%downPage%%end%";
    } 
    else 
    {
            $temp_str = "%first%%upPage%%prePage%%linkPage%%nextPage%%downPage%%end%
						<select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select>共<font color='#CD4F07'><b>%totalRow%</b></font>篇 " . $pernum . "篇/每页";
    }    
    $p->setConfig('theme', $temp_str);
				
				
	
		
		//总页数
		$totalpages = ceil($count / $pagenum);
		$plist = $Course->where($data)->order('public_time desc')->limit($p->firstRow.','.$p->listRows)->select();
	
		foreach($plist as $k=>$v)
		{
			if(!empty($v['recontent']))
			{
				$v['recontent'] = '<font color=red><b>管理员回复：'.$v['recontent'].'</b></font>';
			}
			$pp[$k]=$v;
			$pp[$k]['num'] = $k + 1 + (intval($_GET['page']) - 1) * $pagenum;
		}
	
		//封装变量
    $this->assign('page', $p->show());
      
		$this->assign('list',$pp);
	
		//当前页
	//	$this->assign('nowpage',intval($_GET['page']));
		
		//总页数
		//$this->assign('totalpages',$totalpages); 
		
		//最后一条记录数
		//$this->assign('lastnum',$pagenum);
		  //释放内存
       
    unset($pp, $count, $p, $totalpages, $plist);
	
		$this->display(TMPL_PATH.cookie('think_template').'/classroom.html');
	}
}
?>