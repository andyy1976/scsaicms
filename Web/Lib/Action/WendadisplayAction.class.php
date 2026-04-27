<?php

class WendadisplayAction extends BaseAction
{
    Public function _empty()
    {
        alert('方法不存在', __APP__);
    }

   public function index()
    {
        if (!isset($_GET['qid'])) 
        {
            $this->error('非法操作');
        }
        inject_check($_GET['qid']);
        inject_check($_GET['p']);
        $qid = intval($_GET['qid']);
				//读取数据库和缓存
        ob_start();
				//用于生成静态HTML
        $is_build = C('IS_BUILD_HTML');
				//允许参数
        $allow_param = array('p', 'keyword');
        $static_file = './Html/' . cookie('think_template') . '/wenda/' . $qid;
        $mid_str = '';
        if (count($_REQUEST) > 1) 
        {
            foreach ($_REQUEST as $k => $v) {
                if ($k != 'id' && in_array($k, $allow_param)) {
                    $mid_str .= '/' . $k . '/' . md5($v);
                }
            }
        }
        
        $static_file .= ($mid_str . '.html');
        $path = './WendadisplayAction.class.php';
        $php_file = basename($path);
        parent::html_init($static_file, $php_file, $is_build);
				//以下是动态代码
        $wenda = M('wenda');
        $config = F('basic', '', './Web/Conf/');
        $page_model = 'wenda_page.html';
        //相关判断
        $qlist = $wenda->where('id=' . $qid)->find();
        if (!$qlist) 
        {
            alert('问题不存在或已删除!', __APP__);
        }

        //if ($qlist['status'] == 0) 
        {
          //  alert('问题未审核!', __APP__);
        }
        $answerid=$qlist['answerid'];
				 if ($answerid != 0) 
				 {
				 	  $answer = M('member')->where("id={$answerid}")->find();
        		$this->assign('answer', $answer);
				 }
				
        $this->assign('title', $qlist['title']);
        if ($qlist['content'] != "") 
        {
            $this->assign('content', $qlist['content']);
        }
        if ($qlist['recontent'] != "") 
        {
            $this->assign('recontent', $qlist['recontent']);
        }
        parent::tree_dir($qlist['group_id'], 'tree_list');
        $group = M('wenda_group');
        $list = $group->where('group_id=' . intval($qlist['group_id']))->find();
        if ($list) 
        {
         //   $pid = get_first_father($list['typeid']);
           // $cur_menu = get_field('type', 'typeid=' . $pid, 'drank');
           // $this->assign('cur_menu', $cur_menu);
           // $this->assign('type', $list);
        }
      
        R('Public/py_link');
        //统计处理
        if ($qlist['status'] == 1) 
        {
            //$map['hits'] = $qlist['hits'] + 1;
					//$wenda->where('id=' . $qid)->save($map);
        }
				//注销map
        unset($map);
     //   $qlist['hits'] += 1;
				//关键字替换
        $qlist['content'] = $this->key($qlist['content']);
				//鼠标轮滚图片
        if ($config['mouseimg'] == 1) 
        {
            $qlist['content'] = $this->mouseimg($qlist['content']);
        }
				//问题回复内容分页处理
        if ($qlist['pagenum'] == 0) 
        {
						//手动分页
            $qlist['recontent'] = $this->diypage($qlist['recontent']);
        } 
        else 
        {
						//自动分页
            $qlist['recontent'] = $this->autopage($qlist['pagenum'], $qlist['recontent']);
        }
				
        $url = __ROOT__;//用于心情js的根路径变量
        $this->assign('url', $url);
        //问题上下篇
        $map['status'] = 1;
        $map['group_id'] = $qlist['group_id'];
        $rows = $wenda->where($map)->field('id,title')->order('id desc,addtime desc')->select();
        $arr_qid = array();
        foreach ($rows as $row) 
        {
            $arr_qid[] = $row['id']; //取出每一行中的指定的列
        }
        $cur_key = array_search($qid, $arr_qid);
        if (isset($arr_qid[$cur_key + 1])) 
        {
            $up = $wenda->where('id=' . intval($arr_qid[$cur_key + 1]))->find();
            $up['title'] = msubstr($up['title'], 0, 20, 'utf-8');
            $lastpage = '<a href="' . U('wenda/question_show' . $up['id']) . '" data-icon="arrow-l" data-iconpos="left">' . $up['title'] . '</a>';
            $updown = '下一问题：<span><a href="' . U('wenda/question_show' . $up['id']) . '" >' . $up['title'] . '</a></span>';
        } 
        else 
        {
            $lastpage = '';
            $updown = '下一问题：<span>无</span>';
        }
        $this->assign('lastpage', $lastpage);

        if (isset($arr_qid[$cur_key - 1])) 
        {
            $down = $wenda->where('id=' . intval($arr_qid[$cur_key - 1]))->find();
            $dowm['title'] = msubstr($down['title'], 0, 20, 'utf-8');
            $nextpage = '<a href="' . U('wenda/question_show' . $down['id']) . '" data-icon="arrow-r" data-iconpos="right">' . $down['title'] . '</a>';
            $updown .= '  上一篇：<span><a href="' . U('wenda/question_show' . $down['id']) . '">' . $down['title'] . '</a></span>';
        } 
        else 
        {
            $nextpage = '';
            $updown .= '  上一篇：<span>无</span>';
        }
        $this->assign('nextpage', $nextpage);
        $this->assign('updown', $updown);

        //释放相关内存
        unset($rows, $updown, $up, $down, $map, $lastpage, $nextpage);
        //相关问题
        /*
        if ($qlist['keywords'] != '') 
        {
            $map['status'] = 1;
            $keywords = explode(",", $qlist['keywords']);
            foreach ($keywords as $k => $v) 
            {
                if ($k == 0) 
                {
                    $map['_string'] = "(keywords like '%{$v}%')";
                } 
                else 
                {
                    $map['_string'] = " OR (keywords like '%{$v}%')";
                }
            }
            $klist = $wenda->where($map)->field('id,title,addtime')->limit(6)->select();
						//封装变量
            $this->assign('keylist', $klist);
        }
        */
        $this->assign('wenda', $qlist);
				//释放内存
        unset($wenda, $qlist, $klist, $map);
				//模板输出
        $this->display(TMPL_PATH . cookie('think_template') . '/' . $page_model);
        if ($is_build == 1) 
        {
            $c = ob_get_contents();
            if (!file_exists(dirname($static_file))) 
            {
                @mk_dir(dirname($static_file));
            }
            file_put_contents($static_file, $c);
        }
      }


//关键字替换
    private function key($content)
    {
        import('ORG.Util.KeyReplace');
        $key = M('key');
        $keys = $key->field('url,title,num')->select();
        $map = array();
        foreach ($keys as $k => $v) {
            $map[$k]['Key'] = $v['title'];
            $map[$k]['Href'] = "<a href=\"{$v['url']}\" target=\"_blank\">{$v['title']}</a>";
            $map[$k]['ReplaceNumber'] = $v['num'];
        }
        $a = new KeyReplace($map, $content);
        $a->KeyOrderBy();
        $a->Replaces();
        return $a->HtmlString;
    }

    //鼠标鼠标滚轮控制图片大小的函数
    private function mouseimg($content)
    {
        $pattern = "/<img.*?src=(\".*?\".*?\/)>/is";
        $content = preg_replace($pattern, "<img src=\${1} onload=\"javascript:resizeimg(this,575,600)\">", $content);
        return $content;
    }

    //文章内容分页-自定义分页
    private function diypage($content)
    {
        $str = explode('[lvbo_page]', $content);
        $num = count($str);
        if ($num == 1) {
            return $content;
            exit;
        }
        import('ORG.Util.Page');
        $p = new Page($num, 1);
        $p->setConfig('prev', '上一页');
        $p->setConfig('next', '下一页');
        $p->setConfig('theme', "%upPage%%linkPage%%downPage%");
        $this->assign('page', $p->show());
        $this->assign('nowpage', $p->nowPage);
        $nowpage = $p->nowPage - 1;
        //释放内存
        unset($p);
        return $str[$nowpage];
    }


    //问题自动分页
    private function autopage($pagenum, $content)
    {
        if ($pagenum == 0) {
            return $content;
        }
        if (strlen($content) < $pagenum) {
            return $content;
        }
        //导入分页类和函数库
        import('ORG.Util.Page');
        $num = ceil(strlen($content) / $pagenum);
        $p = new Page($num, 1);
        $p->setConfig('prev', '上一页');
        $p->setConfig('next', '下一页');
        $p->setConfig('theme', "%upPage%%linkPage%%downPage%");
        $this->assign('page', $p->show());
        $this->assign('nowpage', $p->nowPage);
        $content = msubstr($content, ($p->nowPage - 1) * $pagenum, $pagenum);
        //释放内存
        unset($p);
        return $content;
    }
}