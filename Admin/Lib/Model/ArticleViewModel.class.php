<?php

class ArticleViewModel extends ViewModel
{
	public $viewFields = array( 

  'article'=>array('aid','typeid','title','addtime','istop','hits','status','isimg','isflash','ishot','_type'=>'LEFT'), 

  'type'=>array('typename', '_on'=>'article.typeid=type.typeid'), 

 ); 

}
?>