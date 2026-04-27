<?php

class SearchAction extends BaseAction
{
	 
	Public function _empty()
	{ 
		alert('方法不存在',U('Search/search.html'));
	} 

    public function index()
    {
         if (empty($_REQUEST['k'])) 
        {
            alert('请输入关键字!', 1);
        }
        
      
        inject_check($_GET['p']);
          $typeid = intval(inject_check(urldecode($_REQUEST['typeid'])));
				 if($typeid==6)
        	{
        		$this->wenda();
        		return;
        	}
       // $article = M('article');
        $article = D('ArticleView');
        $map['status'] = 1;
        $keyword = inject_check(urldecode($_REQUEST['k']));
				
        $this->assign('typeid',$typeid);
        $this->assign('keyword',$keyword);
	      $keyword = remove_xss($keyword);
			  if ($typeid!=-1) 
        {
        	
        	$arr = get_children($typeid);
        	$map['article.typeid'] = array('in', $arr);
        	//$map['typeid'] =$typeid;
        }
        $map['title'] = array('like', '%' . $keyword . '%');
        
        if($_REQUEST['tag'] !='')
        {
            $map['keywords'] = array('like', '%' . urldecode($_REQUEST['tag']) . '%');
        }
        
        //导入分页类
				C('VAR_PAGE','page');
        import('ORG.Util.Pagenew');
        $count = $article->where($map)->count();
        $this->assign('count',$count);
				$pernum =10;
        $p = new Pagenew($count, $pernum);
        //保持分页参数
        if ($_POST) 
        {
	    			$allow_par = array('p','k','tag','page');
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
  			if (check_wap()) 
        {
            $temp_str = "%first%%upPage%%downPage%%end%";
        } 
        else 
        {
            $temp_str = "%first%%upPage%%prePage%%linkPage%%nextPage%%downPage%%end%
					 <li><select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select></li><li>共<font color='#CD4F07'><b>%totalRow%</b></font>篇 " . $pernum . "篇/每页</li>";
        }
        
        
        $p->setConfig('theme', $temp_str);
        
          
        //查询数据库
        $prefix = C('DB_PREFIX');
      // $list = $article->join('left join ' . $prefix . 'type on ' . $prefix . 'article.typeid=' . $prefix . 'type.typeid')->where($map)->field("aid,title,addtime," . $prefix . "article.typeid as typeid1,typename")->limit($p->firstRow . ',' . $p->listRows)->order("addtime desc")->select();
        $list = $article->where($map)->order('istop desc,addtime desc')->limit($p->firstRow . ',' . $p->listRows)->select();
        
        //封装变量
				foreach($list as $k=>$v)
				{			
					array_walk($v,"highlight_keyword",$keyword);
					$list[$k] = $v;
				}
					
        
        $this->assign('num', $count);
        $this->assign('page', $p->show());
				$this->assign('list', $list);
        $this->assign('keyword', $keyword);
        
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
				
	//释放内存
       
        unset($article, $keyword, $p, $list);
        //模板输出
        $this->display(TMPL_PATH . cookie('think_template') . '/search.html');
    }  
    
    
    private function wenda()
    {
        
        
        $wenda = M('wenda');
        $map['status'] = 1;
        $keyword = inject_check(urldecode($_REQUEST['k']));
				$typeid = 6;
				 
        $this->assign('typeid',$typeid);
        $this->assign('keyword',$keyword);
	      $keyword = remove_xss($keyword);
			 
        $map['title'] = array('like', '%' . $keyword . '%');
        $map['_string'] = "recontent != '' ";
        if($_REQUEST['content'] !='')
        {
            $map['keywords'] = array('like', '%' . urldecode($_REQUEST['content']) . '%');
        }
        
        //导入分页类
				C('VAR_PAGE','page');
        import('ORG.Util.Pagenew');
        $count = $wenda->where($map)->count();
        $this->assign('count',$count);
				$pernum =10;
        $p = new Pagenew($count, $pernum);
        //保持分页参数
        if ($_POST) 
        {
	    			$allow_par = array('p','k','content','page');
            foreach ($_POST as $key => $val)
            {
				    	if(in_array($key,$allow_par))
							{
			                	//$p->parameter .= "/$key/" . urlencode($val);
			                  	$p->parameter .= "&$key=" . urlencode($val);
							}
            }
        }
       
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
					 <li><select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select></li><li>共<font color='#CD4F07'><b>%totalRow%</b></font>篇 " . $pernum . "篇/每页</li>";
        }
        
        
        $p->setConfig('theme', $temp_str);
        
          
        //查询数据库
        $prefix = C('DB_PREFIX');
        $list = $wenda->join('left join ' . $prefix . 'wenda_group on ' . $prefix . 'wenda.group_id=' . $prefix . 'wenda_group.group_id')->where($map)->field("id,title,content,recontent,addtime," . $prefix . "wenda.group_id as groupid,group_name")->limit($p->firstRow . ',' . $p->listRows)->order("addtime desc")->select();
       // $list = $wenda->where($map)->order('addtime desc')->limit($p->firstRow . ',' . $p->listRows)->select();
        
        //封装变量
				foreach($list as $k=>$v)
				{			
					array_walk($v,"highlight_keyword",$keyword);
					$list[$k] = $v;
				}
					
        
        $this->assign('num', $count);
        $this->assign('page', $p->show());
				$this->assign('list', $list);
        $this->assign('keyword', $keyword);
        
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
				
	//释放内存
       
        unset($wenda, $keyword, $p, $list);
        //模板输出
        $this->display(TMPL_PATH . cookie('think_template') . '/search_wenda.html');
    }  
}
?>