<?php

class WendaAction extends BaseAction
{
	
	Public function _empty()
	{ 
		alert('方法不存在',U('Wenda/index.html'));
	} 
	
	public function index()
	{
	     $typeid =6;
       	    $this->assign('typeid',$typeid);
	    $this->assign('title','用户提问');
		//用于ajaxjs的根路径变量
			$url=__ROOT__;
		
		$this->assign('url',$url);
		$group_id=$_GET['group_id'];
		$this->assign('group_id',$group_id); 


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
		$wenda = M('wenda');
		$config = F('basic','','./Web/Conf/');
		
		//相关判断
		$data['status'] = 1;
		$data['_string'] = "recontent != '' ";
		if($group_id!=0)
		{
				//echo "aa".$group_id;
			$data['group_id'] =$group_id;
		}
		$list = $wenda->where($data)->select();
	
		
		//分页处理
		//导入分页类
		
		C('VAR_PAGE','page');
		import('ORG.Util.Page');	
		
		$count = $wenda->where($data)->count();
		$this->assign('count',$count);
			//每10条分页
		$pernum = 10;
	  	$p = new Page($count, $pernum);
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
		$totalpages = ceil($count / $pernum);
		$plist = $wenda->where($data)->order('addtime desc')->limit($p->firstRow.','.$p->listRows)->select();
	
		foreach($plist as $k=>$v)
		{
			//if(!empty($v['recontent']))
		//	{
			//	$v['recontent'] = '<font color=red><b>问题回复：'.$v['recontent'].'</b></font>';
		//	}
			$pp[$k]=$v;
			$pp[$k]['num'] = $k + 1 + (intval($_GET['page']) - 1) * $pernum;
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
			$startnumber=($nowpage-1)*$pernum+1;
		}
		else
		{
				$startnumber=1;
		}
		$this->assign('startnumber',$startnumber);
	
		//总页数
		//$this->assign('totalpages',$totalpages); 
		
		//最后一条记录数
		//$this->assign('lastnum',$pernum);
		  //释放内存
		 
    		unset($pp, $count, $p, $totalpages, $plist);
	
		$this->display(TMPL_PATH.cookie('think_template').'/wenda.html');

	}
	
		public function answerlist()
	{
		   $typeid =6;
       $this->assign('typeid',$typeid);
	    $this->assign('title','用户提问');
		//用于ajaxjs的根路径变量
			$url=__ROOT__;
		
		$this->assign('url',$url);
		$group_id=$_GET['group_id'];
		$this->assign('group_id',$group_id); 

		//	echo $group_id;
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
		$wenda = M('wenda');
		$config = F('basic','','./Web/Conf/');
		
		//相关判断
		//$data['status'] = 1;
		$data['_string'] = "recontent = '' ";
		if($group_id!=0)
		{
				//echo "aa".$group_id;
			$data['group_id'] =$group_id;
		}
		$list = $wenda->where($data)->select();
	
		
		//分页处理
	
		
		C('VAR_PAGE','page');
		import('ORG.Util.Page');	
		
		$count = $wenda->where($data)->count();
		$this->assign('count',$count);
			//每10条分页
		$pernum = 10;
	  $p = new Page($count, $pernum);
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
		$totalpages = ceil($count / $pernum);
		$plist = $wenda->where($data)->order('addtime desc')->limit($p->firstRow.','.$p->listRows)->select();
	
		foreach($plist as $k=>$v)
		{
			if(!empty($v['recontent']))
			{
				$v['recontent'] = '<font color=red><b>问题回复：'.$v['recontent'].'</b></font>';
			}
			$pp[$k]=$v;
			$pp[$k]['num'] = $k + 1 + (intval($_GET['page']) - 1) * $pernum;
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
			$startnumber=($nowpage-1)*$pernum+1;
		}
		else
		{
				$startnumber=1;
		}
		$this->assign('startnumber',$startnumber);
		//总页数
		//$this->assign('totalpages',$totalpages); 
		
		//最后一条记录数
		//$this->assign('lastnum',$pernum);
		  //释放内存
		 
    		unset($pp, $count, $p, $totalpages, $plist);
	
		$this->display(TMPL_PATH.cookie('think_template').'/wenda_answerlist.html');

	}
	
		public function myanswerlist()
	{
		   $typeid =6;
       $this->assign('typeid',$typeid);
	    $this->assign('title','用户提问');
		//用于ajaxjs的根路径变量
			$url=__ROOT__;
		   /*$member_menu = S('member_menu');
        if (!is_array($member_menu)) 
        {
            $member_menu = M('member_menu')->where('is_show=1')->order('drand')->select();
            S('member_menu', $member_menu);
        }
        $this->assign('member_menu', $member_menu);
        */
			$this->assign('url',$url);
			
			$group_id=$_GET['group_id'];
			$this->assign('group_id',$group_id); 


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
		$wenda = M('wenda');
		$config = F('basic','','./Web/Conf/');
		
		//相关判断
		$data['status'] = 1;
	
		if($group_id!=0)
		{
				//echo "aa".$group_id;
			$data['group_id'] =$group_id;
		}
		
		$data['answerid']=$_SESSION['userid'];
		$list = $wenda->where($data)->select();
	
		
		//分页处理

		C('VAR_PAGE','page');
		import('ORG.Util.Page');	
		
		$count = $wenda->where($data)->count();
		$this->assign('count',$count);
			//每10条分页
		$pernum = 10;
	  $p = new Page($count, $pernum);
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
						<select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select>共<font color='#CD4F07'><b>%totalRow%</b></font>个 " . $pernum . "个/每页";
    }    
    $p->setConfig('theme', $temp_str);
				
				
	
		
		//总页数
		$totalpages = ceil($count / $pernum);
		$plist = $wenda->where($data)->order('addtime desc')->limit($p->firstRow.','.$p->listRows)->select();
	
		foreach($plist as $k=>$v)
		{
			$pp[$k]=$v;
			$pp[$k]['num'] = $k + 1 + (intval($_GET['page']) - 1) * $pernum;
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
			$startnumber=($nowpage-1)*$pernum+1;
		}
		else
		{
				$startnumber=1;
		}
	
		$this->assign('startnumber',$startnumber);
		//总页数
		//$this->assign('totalpages',$totalpages); 
		
		//最后一条记录数
		//$this->assign('lastnum',$pernum);
		  //释放内存
		 
    unset($pp, $count, $p, $totalpages, $plist);
	
		$this->display(TMPL_PATH.cookie('think_template').'/wenda_mine_answerlist.html');

	}    
	
	 public function searchfg()
   {
        $article = D('ArticleView');
      
       
        $typeid = 2;
        
        $arr = get_children($typeid);
        $map['article.typeid'] = array('in', $arr);
        	
		    
        $map['status'] = 1;
        $map['title'] = array('like', '%' . $_POST['keywords'] . '%');
        $count = $article->where($map)->order('addtime desc')->count();
        import('ORG.Util.Pagenew');
        
        $p = new Pagenew($count, 10);
        $list = $article->where($map)->order('addtime desc')->limit($p->firstRow . ',' . $p->listRows)->select();
         if ($_POST) 
        {
	    			$allow_par = array('p','keywords','page');
            foreach ($_POST as $key => $val)
            {
				    	if(in_array($key,$allow_par))
							{
			                	//$p->parameter .= "/$key/" . urlencode($val);
			                  	$p->parameter .= "&$key=" . urlencode($val);
							}
            }
        }
       
     
        $p->parameter .= "&typeid=" . urlencode($typeid);
        $p->setConfig('prev', '上一页');
        $p->setConfig('header', '篇文章');
        $p->setConfig('first', '首 页');
        $p->setConfig('last', '末 页');
        $p->setConfig('next', '下一页');
        $p->setConfig('theme', "%first%%upPage%%linkPage%%downPage%%end%
				<li><span><select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select></span></li>\n<li><span>共<font color='#009900'><b>%totalRow%</b></font>篇文章 10篇/每页</span></li>");
        $this->assign('page1', $p->show());
        $this->assign('list1', $list);
        $this->display(TMPL_PATH.cookie('think_template').'/wenda_answer.html');
        
   }
   
    public function searchal()
   {
        $article = D('ArticleView');
        
 			
        $typeid = 3;
        
        $arr = get_children($typeid);
        $map['article.typeid'] = array('in', $arr);
        	
		    
        $map['status'] = 1;
        $map['title'] = array('like', '%' . $_POST['keywords'] . '%');
        $count = $article->where($map)->order('addtime desc')->count();
        import('ORG.Util.Pagenew');
        
        $p = new Pagenew($count, 10);
        $list = $article->where($map)->order('addtime desc')->limit($p->firstRow . ',' . $p->listRows)->select();
        $p->parameter .= "&typeid=" . urlencode($typeid);
        $p->setConfig('prev', '上一页');
        $p->setConfig('header', '篇文章');
        $p->setConfig('first', '首 页');
        $p->setConfig('last', '末 页');
        $p->setConfig('next', '下一页');
        $p->setConfig('theme', "%first%%upPage%%linkPage%%downPage%%end%
				<li><span><select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select></span></li>\n<li><span>共<font color='#009900'><b>%totalRow%</b></font>篇文章 10篇/每页</span></li>");
        $this->assign('page2', $p->show());
        $this->assign('list2', $list);
          $this->display(TMPL_PATH.cookie('think_template').'/wenda_answer.html');
        
   }
	public function answer()
	{
		
    $this->assign('typeid',6);
	  $this->assign('title','用户提问');
	//用于ajaxjs的根路径变量
		$url=__ROOT__;
	
		$this->assign('url',$url);

    $aid = intval($_GET['aid']);
    $wenda = M('wenda');
    $qid =$_GET['qid'];
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
	    	$data['id'] = $qid;

		    
		    $wenda->save($data);
	  }
	 
	  $this->assign('qid',$qid);
		$info = $wenda->where('id='.$qid)->find();
		$this->assign('info',$info);
		
		$article = D('ArticleView');
  
    $condition = '1=1';
       
    $typeid = 2;
   
      $type= intval($_GET['type']);
   
        
    //这里其实不完善没有查找子类的文章
     $arr = get_children($typeid);
     $condition .= ' and article.typeid in(' . $arr . ')';
        
     if ($type == 2) 
     {
         $keyword = inject_check(urldecode($_REQUEST['keywords1']));
				
      	if(!empty($keyword))
        {
        	
           $condition .= ' and article.title like \'%'. $keyword . '%\'';
           
            $this->assign('keywords1',$keyword);
        }
        	
     }
     $condition .= ' and article.status= 1 ';
      
   //   alert($condition,1);
        
      $order = 'addtime desc';
      
       
        $count = $article->where($condition)->count();
        import('ORG.Util.Pagenew');
    	  C('VAR_PAGE','p');
        $p = new Pagenew($count, 10);
     
        //$p->parameter = "&typeid=" . urlencode($typeid);
        $list = $article->where($condition)->order($order)->limit($p->firstRow . ',' . $p->listRows)->select();
        //echo 	$article->getLastSql();
        $p->setConfig('prev', '上一页');
        $p->setConfig('header', '篇文章');
        $p->setConfig('first', '首 页');
        $p->setConfig('last', '末 页');
        $p->setConfig('next', '下一页');
        $p->setConfig('theme', "%first%%upPage%%linkPage%%downPage%%end%
				<li><span><select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select></span></li>\n<li><span>共<font color='#009900'><b>%totalRow%</b></font>篇文章 10篇/每页</span></li>");
        $this->assign('page1', $p->show());
        $this->assign('list1', $list);
        
    		unset( $typeid,$count,$p, $condition, $arr,$list);
	
        $typeid = 3;
        $condition = '1=1';
        $arr = get_children($typeid);
        $condition .= ' and article.typeid in(' . $arr . ')';
           
		    if ($type ==3) 
		    {
		      $keyword = inject_check(urldecode($_REQUEST['keywords2']));
					if(!empty($keyword))
	        {
	       
	         $this->assign('keywords2',$keyword);
	         $condition .= ' and article.title like \'%'. $keyword . '%\'';
	       }
			        	
		    }
        $condition .= ' and article.status= 1 ';
      
      
        
        $order = 'addtime desc';
        
       
        $count = $article->where($condition)->count();
        C('VAR_PAGE','page');
        $p = new Pagenew($count, 10);
        $list = $article->where($condition)->order($order)->limit($p->firstRow . ',' . $p->listRows)->select();
      //  $p->parameter = "&typeid=" . urlencode($typeid);
        $p->setConfig('prev', '上一页');
        $p->setConfig('header', '篇文章');
        $p->setConfig('first', '首 页');
        $p->setConfig('last', '末 页');
        $p->setConfig('next', '下一页');
        $p->setConfig('theme', "%first%%upPage%%linkPage%%downPage%%end%
				<li><span><select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select></span></li>\n<li><span>共<font color='#009900'><b>%totalRow%</b></font>篇文章 10篇/每页</span></li>");
        $this->assign('page2', $p->show());
        $this->assign('list2', $list);
        
				unset( $typeid,$count,$p, $condition, $arr,$list);
		   $this->display(TMPL_PATH.cookie('think_template').'/wenda_answer.html');
	}
	
	public function tiwen()
	{
		   $typeid =6;
       $this->assign('typeid',$typeid);
	  $this->assign('title','用户提问');
	//用于ajaxjs的根路径变量
		$url=__ROOT__;
		
		$this->assign('url',$url);
		$group_id=$_GET['group_id'];
		//echo $group_id;
		$this->display(TMPL_PATH.cookie('think_template').'/wenda_tiwen.html');
	}
	public function mywendalist()
	{
		   $typeid =6;
       $this->assign('typeid',$typeid);
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
			$group_id=$_GET['group_id'];
			$this->assign('group_id',$group_id); 


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
		$wenda = M('wenda');
		$config = F('basic','','./Web/Conf/');
		
		//相关判断
		$data['status'] = 1;
	
		if($group_id!=0)
		{
				//echo "aa".$group_id;
			$data['group_id'] =$group_id;
		}
		
		$data['userid']=$_SESSION['userid'];
		$list = $wenda->where($data)->select();
	
		
		//分页处理

		C('VAR_PAGE','page');
		import('ORG.Util.Page');	
		
		$count = $wenda->where($data)->count();
		$this->assign('count',$count);
			//每10条分页
		$pernum = 10;
	  $p = new Page($count, $pernum);
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
		$totalpages = ceil($count / $pernum);
		$plist = $wenda->where($data)->order('addtime desc')->limit($p->firstRow.','.$p->listRows)->select();
	
		foreach($plist as $k=>$v)
		{
			//if(!empty($v['recontent']))
		//	{
				//$v['recontent'] = '<font color=red><b>问题回复：'.$v['recontent'].'</b></font>';
			//}
			$pp[$k]=$v;
			$pp[$k]['num'] = $k + 1 + (intval($_GET['page']) - 1) * $pernum;
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
			$startnumber=($nowpage-1)*$pernum+1;
		}
		else
		{
				$startnumber=1;
		}
		$this->assign('startnumber',$startnumber);
		//总页数
		//$this->assign('totalpages',$totalpages); 
		
		//最后一条记录数
		//$this->assign('lastnum',$pernum);
		  //释放内存
		 
    		unset($pp, $count, $p, $totalpages, $plist);
	
		$this->display(TMPL_PATH.cookie('think_template').'/wenda_mine.html');

	}    

	
		public function tiwen_mine()
	{
		   $typeid =6;
       $this->assign('typeid',$typeid);
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
		$group_id=$_GET['group_id'];
		//echo $group_id;
		$this->display(TMPL_PATH.cookie('think_template').'/wenda_mine_tiwen.html');
	}
	public function updatequestion()
	{
	//输出gb2312码,ajax默认转的是utf-8
		header("Content-type: text/html; charset=utf-8");
		
	//	echo "aaa";
		if(!isset($_POST['author']) or !isset($_POST['content']))
		{
			alert('非法操作!',3);
		}
		//读取数据库和缓存
		$wenda = M('wenda');
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
		$data['addtime'] = date('Y-m-d H:i:s');
		$data['group_id'] = intval($_POST['group_id']);
		//处理数据
		if($wenda->add($data))
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
			}
		}
		else
		{
			echo '发布失败!';
			exit;
		}
	}
	
		public function updateanswer()
	{
	//输出gb2312码,ajax默认转的是utf-8
		header("Content-type: text/html; charset=utf-8");
		
	//	echo "aaa";
		if(!isset($_POST['id']) or !isset($_POST['recontent']))
		{
			alert('非法操作!',3);
		}
		//读取数据库和缓存
		$wenda = M('wenda');
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

		//先解密js的escape
	//	$data['answername'] = htmlspecialchars(unescape($_POST['author']));
		$data['recontent'] = htmlspecialchars(trim(unescape($_POST['recontent'])));
		$data['approval'] = htmlspecialchars(trim(unescape($_POST['approval'])));
		$data['guide'] = htmlspecialchars(trim(unescape($_POST['guide'])));
		$data['cases'] = htmlspecialchars(trim(unescape($_POST['cases'])));
		
		$data['answerid'] = $_SESSION['userid'];	
		$data['id'] = $_POST['id'];	
		$data['answertime'] = date('Y-m-d H:i:s');
		//处理数据
		if($wenda->save($data))
		{
			Session::set('posttime', time());
			
			if($config['bookoff'] == 0)
			{
				echo '发布成功,答案需要管理员审核!';
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
	

}
?>