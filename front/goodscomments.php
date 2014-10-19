<?php

//商品留言板控制器
define('ACC',true);

require('../system/init.php');

if(!isset($_POST)){
	header('Location: index.php');
}
$data = $_POST;
$gmObj = new GoodscommentsModel();
$data = $gmObj->_autofill($data); 
if(!$gmObj->_validate($data)){
	list($error) = $gmObj->getErr();
	$msg = $error;
	include(__ROOT__.'view/front/msg.html');
	exit;
}
//后端验证注册码 前端之后用JS来实现 
if(!isset($_SESSION['capstr'])){
	$msg = "验证码出现问题，请重新登陆主页";
	include(__ROOT__.'view/front/msg.html');
	exit;
}else{
	if($_SESSION['capstr'] != strtoupper($data['captcha'])){
		$msg = "验证码出错，返回重填";
		include(__ROOT__.'view/front/msg.html');
		exit;
	}
}
$gmObj->setField($gmObj->showField());
$data = $gmObj->_facade($data);

//插入goods comments
if($gmObj->add($data)){
	$msg = "评论提交成功";
	include(__ROOT__.'view/front/msg.html');
}else{
	$msg = "评论提交失败";
	include(__ROOT__.'view/front/msg.html');
}

