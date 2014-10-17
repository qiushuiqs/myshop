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
$userlist = $user->dataByRealDate($userlist);
//print_r($userlist);
//[user_id] => 1 [username] => sdsd [email] => sdsd [password] => sdsd [regtime] => 0 [lastlogin] => 0 
//print_r($catetree);
include(__ROOT__.'view/admin/templates/userlist.html');
