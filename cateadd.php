<?php

/*
MVC模式：

接收数据/检验数据

把数据交给model去写入数据库

判断model的返回值。

*/

define('ACC',true);
require('./system/init.php');

//接受数据
$data['catename'] = $_POST['catename'];
$data['dscrpt'] = $_POST['dscrpt'];

//名称检测，$_POST检测

//调用model
$cateobj = new CateModel();
if($cateobj->add($data)){
	$res = true;
}else{
	$res = false;
}

//展示到view
echo $res? "YES":"FAIL";