<?php

class TradeViewModel extends ViewModel
{
	public $viewFields = array( 
  'member_trade'=>array('*','_type'=>'LEFT'), 
  'article'=>array('title','typeid','content','price'=>'self_price','product_xinghao','color', '_on'=>'member_trade.gid=article.aid','_type'=>'LEFT'), 
  'type'=>array('typename', '_on'=>'article.typeid=type.typeid'),
 ); 

}
?>