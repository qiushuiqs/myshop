<?php

define('ACC',true);

require('../system/init.php');

if(!isset($_POST['act'])){
	if(isset($_COOKIE['keepuser'])){
		$keepuser = $_COOKIE['keepuser'];
	}else{
		$keepuser = '';
	}
	include(__ROOT__.'view/front/denglu.html');//第一次登陆指向登陆界面
}else{
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	//接受登陆界面的请求，若成功请求，将用户信息录入$_SESSION;
	$user = new UserModel(); 
	if(($res = $user->checkUser($username,$password))==false){
		list($error) = $user->getErr();
		$msg = $error;
		include(__ROOT__.'view/front/msg.html');
	}else{
		$_SESSION = $res;
		$msg='login successfully';
		//用户选择记住用户名，保存用户名7天
		if(isset($_POST['remember'])){
			setcookie('keepuser', $username, time()+3600*24*7);
		}else{
			setcookie('keepuser', '', time() - 42000);
		}
		include(__ROOT__.'view/front/msg.html');
	}
	
}


