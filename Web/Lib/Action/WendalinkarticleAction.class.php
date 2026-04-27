<?php
class WendalinkarticleAction extends BaseAction
{
	    Public function _empty()
    {
        $this->error('方法不存在');
    }
    
    public function index()
    {
       
        $article = D('ArticleView');
        import('ORG.Util.Pagenew');
        $condtion = '1=1';
        if (isset($_REQUEST['typeid']) && intval($_REQUEST['typeid']) != 0) {
            $typeid = intval($_REQUEST['typeid']);
        } else if (cookie('curr_typeid') != '') {
            $typeid = intval(cookie('curr_typeid'));
        }
        if ($typeid > 0) 
        {
            $is_last = 0;
            //这里其实不完善没有查找子类的文章
            $arr = get_children($typeid);
            $condtion .= ' and article.typeid in(' . $arr . ')';
            //判定是否为最底层栏目

            $t_num = M('type')->where('islink=0 and fid=' . $typeid)->count();
            if ($t_num == 0) 
            {
                $is_last = 1;
            } 
            else 
            {
                $fid = M('type')->where('islink=0 and typeid=' . $typeid)->getField('fid');
                if ($fid > 0 && $t_num > 0) {
                    $is_last = 1;
                }
            }
            if ($is_last == 1) {
                $this->assign('is_last', '1');
                cookie('curr_typeid', $typeid);
            }
        }

       

     
         if (isset($_GET['status'])) {
            $condtion .= ' and status=' . $_GET['status'];
        }
        if (isset($_GET['istop'])) {
            $condtion .= ' and istop=' . $_GET['istop'];
        }
        if (isset($_GET['ishot'])) {
            $condtion .= ' and ishot=' . $_GET['ishot'];
        }
        if (isset($_GET['isflash'])) {
            $condtion .= ' and isflash=' . $_GET['isflash'];
        }
        if (isset($_GET['isimg'])) {
            $condtion .= ' and isimg=' . $_GET['isimg'];
        }
        if (isset($_GET['islink'])) {
            $condtion .= ' and islink=' . $_GET['islink'];
        }
        if (isset($_GET['hits'])) {
            $order = 'hits desc';
        } 
        else 
        {
            $order = 'addtime desc';
        }
       
        $count = $article->where($condtion)->count();
        $p = new Pagenew($count, 20);
        $list = $article->where($condtion)->order($order)->limit($p->firstRow . ',' . $p->listRows)->select();
        //echo 	$article->getLastSql();
        $p->setConfig('prev', '上一页');
        $p->setConfig('header', '篇文章');
        $p->setConfig('first', '首 页');
        $p->setConfig('last', '末 页');
        $p->setConfig('next', '下一页');
        $p->setConfig('theme', "%first%%upPage%%linkPage%%downPage%%end%
				<li><span><select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select></span></li>\n<li><span>共<font color='#009900'><b>%totalRow%</b></font>篇文章 20篇/每页</span></li>");
        $this->assign('page', $p->show());
        $this->assign('list', $list);
        $this->display(TMPL_PATH.cookie('think_template').'/wendalinkarticlelist.html');
    }

    

   

   


  




    public function search()
    {
        $article = D('ArticleView');
        import('ORG.Util.Page');
        $map['title'] = array('like', '%' . $_POST['keywords'] . '%');
        $count = $article->where($map)->order('addtime desc')->count();
        $p = new Page($count, 20);
        $list = $article->where($map)->order('addtime desc')->limit($p->firstRow . ',' . $p->listRows)->select();
        $p->setConfig('prev', '上一页');
        $p->setConfig('header', '篇文章');
        $p->setConfig('first', '首 页');
        $p->setConfig('last', '末 页');
        $p->setConfig('next', '下一页');
        $p->setConfig('theme', "%first%%upPage%%linkPage%%downPage%%end%
				<li><span><select name='select' onChange='javascript:window.location.href=(this.options[this.selectedIndex].value);'>%allPage%</select></span></li>\n<li><span>共<font color='#009900'><b>%totalRow%</b></font>篇文章 20篇/每页</span></li>");
        $this->assign('page', $p->show());
        $this->assign('list', $list);
       
        $this->display(TMPL_PATH.cookie('think_template').'/wendalinkarticlelist.html');
    }
}

?>