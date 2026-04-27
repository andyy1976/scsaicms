<?php

class TixianViewModel extends ViewModel
{
public $viewFields = array( 
  'tixian'=>array('*','_type'=>'LEFT'), 
  'member'=>array('id'=>'uid','username','realname','tel','money'=>'have_money','address','province','city','area','email','qq','sex', '_on'=>'tixian.uid=member.id'),
 ); 
}
?>