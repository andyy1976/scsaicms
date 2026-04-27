<?php

class CourseAction extends CommonAction
{	
    public function index()
    {
			import('ORG.Util.Page');
			$course = M('course');
			if(isset($_GET['status']))
			{
				$count = $course->where('status='.$_GET['status'])->order('public_time desc')->count();
				$p = new Page($count,20); 
				$list = $course->where('status='.$_GET['status'])->order('public_time desc')->limit($p->firstRow.','.$p->listRows)->select();
			}
			else
			{
				$count = $course->order('public_time desc')->count();
				$p = new Page($count,20); 
				$list = $course->order('public_time desc')->limit($p->firstRow.','.$p->listRows)->select();
			}
			
			$p->setConfig('prev','上一页');
			$p->setConfig('header','条问答');
			$p->setConfig('first','首 页');
			$p->setConfig('last','末 页');
			$p->setConfig('next','下一页');
			$p->setConfig('theme',"%first%%upPage%%linkPage%%downPage%%end%
			<li><span><select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select></span></li>\n<li><span>共<font color='#009900'><b>%totalRow%</b></font>条评论 20条/每页</span></li>");
			$this->assign('page',$p->show());
			$this->assign('list',$list);
			$this->display('index');
    }
	
	
		public function add()
    {
        $this->display();

    }
	
		public function doadd()
    {
			$course=M('course');
			
		//	$data['id'] =1;
			$data['status'] = "1";
			$data['CategoryId'] = intval($_POST['CategoryId']);
			$data['course_name'] = htmlspecialchars(unescape($_POST['course_name']));
			$data['content'] = stripslashes($_POST['content']);
			$data['price'] = stripslashes($_POST['price']);
			//$data['online_time'] = stripslashes("onlinetime");
		    empty($_POST['onlinetime']) ? $data['online_time'] = date('Y-m-d H:i:s') : $data['online_time'] = trim($_POST['onlinetime']);
			// $data['tel'] = "";
			// $data['ip'] ="";
			$data['public_time'] = date('Y-m-d H:i:s');
			
			
			if($course->add($data))
			{
				$this->assign("jumpUrl",U('Course/index'));
				$this->success('操作成功!');
			}
			
			$this->error('操作失败!');	
    }
    
		public function edit()
    {
	    $type = M('course');
			$list = $type->where('id='.$_GET['id'])->find();
			$this->assign('list',$list);
	    $this->display('edit');
    }
	
		public function doedit()
	  {
			$course = M('course');
			$data['id'] = $_POST['id'];
			//使用stripslashes 反转义,防止服务器开启自动转义
			$data['content'] = stripslashes($_POST['content']);
			$data['recontent'] = stripslashes($_POST['recontent']);
			$data['CategoryId'] = intval($_POST['CategoryId']);
			if($course->save($data))
			{
				$this->assign("jumpUrl",U('Course/index'));
				$this->success('操作成功!');
			}
			$this->error('操作失败!');
	  }
	
		public function del()
    {
			$type = M('course');
			if($type->where('id='.$_GET['id'])->delete())
			{
				$this->assign("jumpUrl",U('Course/index'));
				$this->success('操作成功!');
			} 
			$this->error('操作失败!');
    }
	
		public function status()
		{
			$a = M('course');
			if($_GET['status'] == 0)
			{
				$a->where( 'id='.$_GET['id'] )-> setField( 'status',1);
			}
			elseif($_GET['status'] == 1)
			{
				$a->where( 'id='.$_GET['id'] )-> setField( 'status',0);
			}
			else
			{
				$this->error('非法操作!');
			}
			$this->redirect('index');
		}

	public function delall()
	{
		$id = $_REQUEST['id'];  //获取文章id
		$ids = implode(',',$id);//批量获取id
		$id = is_array($id)?$ids:$id;
		$map['id'] = array('in',$id);
		if(!$id)
		{
			$this->error('请勾选记录!');
		}
		$course = M('course');
		if($_REQUEST['Del']	==	'删除')
		{
			if($course->where($map)->delete())
			{
				$this->assign("jumpUrl",U('Course/index'));
				$this->success('操作成功!');
			}
			$this->error('操作失败!');
		}
		
		if($_REQUEST['Del']	==	'批量未审')
		{
			$data['status'] = 0;
			if($course->where($map)->save($data))
			{
				$this->assign("jumpUrl",U('Course/index'));
				$this->success('操作成功!');
			}
			$this->error('操作失败!');
		}
		
		if($_REQUEST['Del']	==	'批量审核')
		{
			$data['status']=1;
			if($course->where($map)->save($data))
			{
				$this->assign("jumpUrl",U('Course/index'));
				$this->success('操作成功!');
			}
			$this->error('操作失败!');
		}
	}

	public function search()
	{
		import('ORG.Util.Page');
		$course = M('course');
		$map['content'] = array('like','%'.$_POST['keywords'].'%');
		$count = $course->where($map)->order('public_time desc')->count();
		$p = new Page($count,20); 
		$list = $course->where($map)->order('public_time desc')->limit($p->firstRow.','.$p->listRows)->select();
		$p->setConfig('prev','上一页');
		$p->setConfig('header','条问答');
		$p->setConfig('first','首 页');
		$p->setConfig('last','末 页');
		$p->setConfig('next','下一页');
		$p->setConfig('theme',"%first%%upPage%%linkPage%%downPage%%end%
		<li><span><select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select></span></li>\n<li><span>共<font color='#009900'><b>%totalRow%</b></font>条评论 20条/每页</span></li>");
		$this->assign('page',$p->show());
		$this->assign('list',$list);
		$this->display('index');
	}
	
	
	//课程类别操作开始--------
	  public function courseCategory()
    {
        $this->display();

    }
		//添加、修改问答组
    function addCategory()
    {
        if ($_POST) 
        {
            $data = $_POST;
            $data['group_vail'] = implode(',', $_POST['typeids']);
            if (isset($data['CategoryId'])) 
            {
                M('course_category')->save($data);
                $this->assign("jumpUrl", U('Course/courseCategory'));
                $this->success('修改课程分类成功');
            } 
            else 
            {
                $gid = M('course_category')->add($data);
                if ($gid <= 0) 
                {
                    $this->error('添加课程分类失败!');
                } 
                else 
                {
                    $this->assign("jumpUrl", U('Course/courseCategory'));
                    $this->success('添加课程分类成功!');
                }
            }
        } 
        else 
        {
            $CategoryId = intval($_REQUEST['CategoryId']);
            if ($CategoryId != 0) 
            {
                $info = M('course_category')->where('CategoryId=' . $CategoryId)->find();
                $this->assign('info', $info);
            }
            
            $this->display();
        }
    }

		//删除问答组
    function delCategory()
    {
        $CategoryId = (int)$_GET['CategoryId'];
        if ($CategoryId != 0) {
            M('course_category')->where('CategoryId=' . $CategoryId)->delete();
            M('course')->where('CategoryId=' . $CategoryId)->setField('CategoryId', 0);
        }
        $this->success('删除课程类别成功!');

    }
	//课程类别操作结束--------
}
?>