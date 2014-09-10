<?php

define('ACC',true);
require('../system/init.php');

/*
	接受goods ID
	实例化
	调用方法
	显示在view上
*/

 $goods_id = $_GET['goods_id']+0;

$goods = new GoodsModel();
$goods123 = $goods->find($goods_id);

if(!empty($goods123)){
	print_r($goods123);
}

