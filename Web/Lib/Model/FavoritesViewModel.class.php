<?php

class FavoritesViewModel extends ViewModel
{
  public $viewFields = array( 
  'favorites'=>array('id','_type'=>'LEFT'), 
  'article'=>array('*', '_on'=>'article.aid= favorites.aid'), 

 ); 

}
?>