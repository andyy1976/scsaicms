<?php

class WendaAction extends CommonAction
{	
    public function index()
    {
			import('ORG.Util.Page');
			$wenda = M('wenda');
			if(isset($_GET['status']))
			{
				$count = $wenda->where('status='.$_GET['status'])->order('addtime desc')->count();
				$p = new Page($count,20); 
				$list = $wenda->where('status='.$_GET['status'])->order('addtime desc')->limit($p->firstRow.','.$p->listRows)->select();
			}
			else
			{
				$count = $wenda->order('addtime desc')->count();
				$p = new Page($count,20); 
				$list = $wenda->order('addtime desc')->limit($p->firstRow.','.$p->listRows)->select();
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
			$this->display();
    }
	
	  public function wendagroup()
    {
        $this->display();

    }
		//添加、修改问答组
    function addgroup()
    {
        if ($_POST) 
        {
            $data = $_POST;
            $data['group_vail'] = implode(',', $_POST['typeids']);
            if (isset($data['group_id'])) 
            {
                M('wenda_group')->save($data);
                $this->assign("jumpUrl", U('Wenda/wendagroup'));
                $this->success('修改组成功');
            } 
            else 
            {
                $gid = M('wenda_group')->add($data);
                if ($gid <= 0) 
                {
                    $this->error('添加问答组失败!');
                } 
                else 
                {
                    $this->assign("jumpUrl", U('Wenda/wendagroup'));
                    $this->success('添加问答组成功!');
                }
            }
        } 
        else 
        {
            $group_id = intval($_REQUEST['group_id']);
            if ($group_id != 0) 
            {
                $info = M('wenda_group')->where('group_id=' . $group_id)->find();
                $this->assign('info', $info);
            }
            
            $this->display();
        }
    }

		//删除问答组
    function delgroup()
    {
        $group_id = (int)$_GET['group_id'];
        if ($group_id != 0) {
            M('wenda_group')->where('group_id=' . $group_id)->delete();
            M('wenda')->where('group_id=' . $group_id)->setField('group_id', 0);
        }
        $this->success('删除问答分组组成功!');

    }
		public function add()
    {
        $this->display();

    }
	
		public function doadd()
    {
			$wenda=M('wenda');
			
		//	$data['id'] =1;
			$data['status'] = "1";
			$data['group_id'] = intval($_POST['group_id']);
			$data['author'] = htmlspecialchars(unescape($_POST['author']));
			$data['content'] = stripslashes($_POST['content']);
			$data['recontent'] = stripslashes($_POST['recontent']);
			$data['title'] = htmlspecialchars("管理员添加");
			$data['tel'] = "";
			$data['ip'] ="";
			$data['addtime'] = date('Y-m-d H:i:s');
			$data['approval'] = stripslashes($_POST['approval']);
			$data['guide'] = stripslashes($_POST['guide']);
			$data['cases'] = stripslashes($_POST['cases']);
		//	$data['approvalid'] = intval($_POST['approvalid']);
		//	$data['casesid'] = intval($_POST['casesid']);
				
			if($wenda->add($data))
			{
				$this->assign("jumpUrl",U('Wenda/index'));
				$this->success('操作成功!');
			}
			
			$this->error('操作失败!');	
    }
    
    public function edit()
    {
    	$aid = intval($_GET['aid']);
    	$wenda = M('wenda');
    	if($aid!=0)
      {
       
      
	      $type = M('article');
	       $list = $type->where('aid=' . $aid)->find();
	    	$typeid = intval($_GET['typeid']);
	    	if($typeid==2)
	    	{
	    			$data['approvalid'] = $aid;
	    			if($list[note]!="")
	    			{
	    				$data['approval'] = $list[note];
	    			}
	    			else
	    			{
	    				$data['approval'] = $list[title];
	    			}
	    	}
	    	else if($typeid==3)
	    	{
	    			$data['casesid'] = $aid;
	    			if($list[note]!="")
	    			{
	    				$data['cases'] = $list[note];
	    			}
	    			else
	    			{
	    				$data['cases'] = $list[title];
	    			}
	    	}
	    	$data['id'] = $_GET['id'];

		    
		    $wenda->save($data);
	    }
			$list = $wenda->where('id='.$_GET['id'])->find();
			$this->assign('list',$list);
	    $this->display('edit');
    }
	
		public function doedit()
	  {
			$wenda = M('wenda');
			$data['id'] = $_POST['id'];
			//使用stripslashes 反转义,防止服务器开启自动转义
			$data['content'] = stripslashes($_POST['content']);
			$data['recontent'] = stripslashes($_POST['recontent']);
			$data['group_id'] = intval($_POST['group_id']);
			$data['approval'] = stripslashes($_POST['approval']);
			$data['guide'] = stripslashes($_POST['guide']);
			$data['cases'] = stripslashes($_POST['cases']);
		
			
			if($wenda->save($data))
			{
				$this->assign("jumpUrl",U('Wenda/index'));
				$this->success('操作成功!');
			}
			$this->error('操作失败!');
	  }
	
		public function del()
   		 {
			$type = M('wenda');
			if($type->where('id='.$_GET['id'])->delete())
			{
				$this->assign("jumpUrl",U('Wenda/index'));
				$this->success('操作成功!');
			} 
			$this->error('操作失败!');
 		}
	
		public function status()
		{
			$a = M('wenda');
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
		$wenda = M('wenda');
		if($_REQUEST['Del']	==	'删除')
		{
			if($wenda->where($map)->delete())
			{
				$this->assign("jumpUrl",U('Wenda/index'));
				$this->success('操作成功!');
			}
			$this->error('操作失败!');
		}
		
		if($_REQUEST['Del']	==	'批量未审')
		{
			$data['status'] = 0;
			if($wenda->where($map)->save($data))
			{
				$this->assign("jumpUrl",U('Wenda/index'));
				$this->success('操作成功!');
			}
			$this->error('操作失败!');
		}
		
		if($_REQUEST['Del']	==	'批量审核')
		{
			$data['status']=1;
			if($wenda->where($map)->save($data))
			{
				$this->assign("jumpUrl",U('Wenda/index'));
				$this->success('操作成功!');
			}
			$this->error('操作失败!');
		}
	}

	public function search()
	{
		import('ORG.Util.Page');
		$wenda = M('wenda');
		$map['content'] = array('like','%'.$_POST['keywords'].'%');
		$count = $wenda->where($map)->order('addtime desc')->count();
		$p = new Page($count,20); 
		$list = $wenda->where($map)->order('addtime desc')->limit($p->firstRow.','.$p->listRows)->select();
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
}
?>