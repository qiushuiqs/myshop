<?php
/*
商品页
*/

define('ACC',true);
require('../system/init.php');
session_start();
$cateObj = new CategoryModel();
$goodsObj = new GoodsModel();

$goodsID = $_GET['goods_id'];
$goodsInfo = $goodsObj->find($goodsID);
if(!isset($goodsInfo)){
	header('Location: index.php');
}

//print_r($goodsInfo);
$catID = $goodsInfo['cat_id'];
$allCates =$cateObj->select();
$cateNav = $cateObj->getTree($allCates,$catID);
//print_r($cateNav);

include(__ROOT__.'view/front/shangpin.html');