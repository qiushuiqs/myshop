<?php

/*
后台文件
Background entry file
*/
if(!defined('ACC')){
	define('ACC',true);
	require('../system/init.php');
}
//
$user = new UserModel();
$userlist = $user->select();
$regtime = array();
$lastlogin = array();
foreach($userlist as $v){
	if(isset($v['regtime'])){
		array_push($regtime, getdate($v['regtime']));
	}else{
		array_push($regtime, null);
	}
	$v['regtime1'] = $regtime;
}
print_r($userlist);
//[user_id] => 1 [username] => sdsd [email] => sdsd [password] => sdsd [regtime] => 0 [lastlogin] => 0 
//print_r($catetree);
//include(__ROOT__.'view/admin/templates/userlist.html');
