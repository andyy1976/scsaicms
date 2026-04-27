<?php

class AdminViewModel extends ViewModel
{
	protected $viewFields = array( 

		'admin' => array('id','username','lastlogintime','lastloginip','status','_type'=>'LEFT'), 

		'role_admin' => array('role_id', '_on' => 'admin.id=role_admin.user_id'), 
	); 
}
?>