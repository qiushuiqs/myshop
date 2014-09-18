<?php

define('ACC',true);

require('../system/init.php');

//显示user注册页面

$user = new UserModel();

$user ->setField($user ->showField());
$data = $user->_facade($_POST);

//检测内容
/*
username: 4-20
password: 非空
email: 有email格式
username是否重复

*/
echo $user->add($data)? "s":"f";