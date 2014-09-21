<?php
/*
栏目页。
*/

define('ACC',true);
require('../system/init.php');


$cateObj = new CategoryModel();
$catID = $_GET['cat_id'];
$cateInfo = $cateObj->find($catID);
if(!isset($cateInfo)){
	header('Location: index.php');
}


//树状导航
$allCates =$cateObj->select();
$cateList = $cateObj->getCatTree($allCates,0,1);

//面包屑导航
$cateNav = $cateObj->getTree($allCates,$catID);
//print_r($cateNav);

//取出栏目下的商品
$goodsObj = new GoodsModel();
$goodsList = $goodsObj->goodsByCate($catID);
//print_r($goodsList);
include(__ROOT__.'view/front/lanmu.html');