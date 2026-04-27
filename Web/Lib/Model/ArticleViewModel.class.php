<?php

class ArticleViewModel extends ViewModel
{
	public $viewFields = array( 

  'article'=>array('*','_type'=>'LEFT'), 

  'type'=>array('typename', '_on'=>'article.typeid=type.typeid'), 

 ); 

}
?>