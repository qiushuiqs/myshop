<?php

define('ACC',true);
require('../system/init.php');

/*
	实例化
	调用方法
	显示在view上
*/

$goods = new GoodsModel();
$goodslist = $goods->getGoodsVsTrash(0);

include(__ROOT__.'view/admin/templates/goodslist.html');