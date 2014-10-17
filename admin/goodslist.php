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

//分页显示
$perPage = 7;
$curPage = isset($_GET['page'])?$_GET['page']:1;

$pageObj =new PaginationHelper(count($goodslist), $perPage, $curPage);
$pageMenu = $pageObj->showPageMenu();
$goodslist = $goods->selectLimited(($curPage-1)*$perPage, $perPage);

include(__ROOT__.'view/admin/templates/goodslist.html');