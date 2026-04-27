<?php

class MemberListAction  extends BaseAction
{

 
	Public function _empty()
	{ 
		alert('方法不存在',U('Memberlist/index'));
	} 
	
	public function index()
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
        $this->display(TMPL_PATH.cookie('think_template').'/memberlist.html');
        
  }
  
  function user()
  {
    
    	$wenda = M('wenda');
			$config = F('basic','','./Web/Conf/');
		
			//相关判断
			$data['status'] = 1;
		  $group_id=$_GET['group_id'];
			$this->assign('group_id',$group_id); 

			if($group_id!=0)
			{
					//echo "aa".$group_id;
				$data['group_id'] =$group_id;
			}
			
			$data['answerid']=$_GET['userid'];
			$list = $wenda->where($data)->select();
		
			
			//分页处理

			C('VAR_PAGE','page');
			import('ORG.Util.Page');	
		
			$count = $wenda->where($data)->count();
			$this->assign('count',$count);
			
			 $user = M('member')->where('id=' . intval($_GET['userid']))->find();
       $this->assign('user', $user);
       
				//每10条分页
			$pagenum = 10;
		  $p = new Page($count, $pagenum);
		  $p->setConfig('prev', '上一页');
	    $p->setConfig('header', '个问题');
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
							<select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select>共<font color='#CD4F07'><b>%totalRow%</b></font>个 " . $pagenum . "个/每页";
	    }    
	    $p->setConfig('theme', $temp_str);
					
					
		
			
			//总页数
			$totalpages = ceil($count / $pagenum);
			$plist = $wenda->where($data)->order('addtime desc')->limit($p->firstRow.','.$p->listRows)->select();
		
			foreach($plist as $k=>$v)
			{

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
		 
		
       
    	unset($pp, $count, $p, $totalpages, $plist);
	
			$this->display(TMPL_PATH.cookie('think_template').'/user.html');    
    
	}
	
	 function article()
  {
    
    	$blog = M('contents');
			$config = F('basic','','./Web/Conf/');
		
			//相关判断
			$data['status'] = "publish";
			$data['type'] = "post";
		  $parent=$_GET['group_id'];
			$this->assign('group_id',$parent); 

			if($parent!=0)
			{
					//echo "aa".$group_id;
				$data['parent'] =$parent;
			}
			
			$data['authorId']=$_GET['userid'];
			$list = $blog->where($data)->select();
		
			
			//分页处理

			C('VAR_PAGE','page');
			import('ORG.Util.Pagenew');	
		
			$count = $blog->where($data)->count();
			$this->assign('count',$count);
			
			$user = M('member')->where('id=' . intval($_GET['userid']))->find();
      $this->assign('user', $user);
       
				//每10条分页
			$pagenum = 10;
		  $p = new Pagenew($count, $pagenum);
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
							<select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select>共<font color='#CD4F07'><b>%totalRow%</b></font>篇 " . $pagenum . "篇/每页";
	    }    
	    $p->setConfig('theme', $temp_str);
					
					
		
			
			//总页数
			$totalpages = ceil($count / $pagenum);
			  
        //查询数据库
      $prefix = C('DB_PREFIX');
			$plist = $blog->join('left join ' . $prefix . 'relationships on ' . $prefix . 'contents.cid=' . $prefix . 'relationships.cid')->where($data)->order('created desc')->limit($p->firstRow.','.$p->listRows)->select();
		
			foreach($plist as $k=>$v)
			{

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
		 
		
       
    	unset($pp, $count, $p, $totalpages, $plist);
	
			$this->display(TMPL_PATH.cookie('think_template').'/userarticle.html');    
    
	}
}