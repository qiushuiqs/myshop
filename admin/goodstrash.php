<?php

define('ACC',true);
require('../system/init.php');

/*
接受ID
model类声明
调用trash方法
*/
$goods = new GoodsModel();

if(isset($_GET['act']) && $_GET['act']=="showtrash"){
	//显示回收站
	$goodslist=$goods->getGoodsVsTrash(1);
	
	include(__ROOT__.'view/admin/templates/goodslist.html');
}else{
	$goods_id = $_GET['goods_id']+0;

	
	if($goods->inTrash($goods_id)){
		echo "goods was in Trash<br>";
	}else{
		echo "goods was fail to put in trash<br>";
	}
}