<?php

define('ACC',true);

require('../system/init.php');

//显示user注册页面
$msg = ''; //返回到前台的信息
$user = new UserModel();


$data = $user->_autofill($_POST);

//检测内容
/*
username: 4-20
password: 非空
email: 有email格式
username是否重复
*/
if(!$user->_validate($data)){
	list($error) = $user->getErr();
	$msg .= $error;
}else{
	$user ->setField($user ->showField());
	$data = $user->_facade($data);
}

if(!$user->reg($data)){
	list($error) = $user->getErr();
	$msg = $error;
}else{
	$msg .= "Register Sucessfully!";
}
include('../view/front/msg.html');

//echo $user->add($data)? "s":"f";