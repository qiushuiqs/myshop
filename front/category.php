<?php
/*
栏目页。
*/

define('ACC',true);
require('../system/init.php');


$cateObj = new CategoryModel();
$goodsObj = new GoodsModel();
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

//分页显示
$curPage = isset($_GET['page'])?$_GET['page']:1;
$goodsCnt = count($goodsObj->goodsByCate($catID));
$perPage = 4;

$pageObj = new PaginationHelper($goodsCnt,$perPage,$curPage);
$pageMenu = $pageObj->showPageMenu();

//取出栏目下的商品
$goodsList = $goodsObj->goodsByCate($catID,$perPage,($curPage-1)*$perPage);

//浏览记录
if(isset($_COOKIE['goods_history'])){
	$goods_history = _unserialize($_COOKIE['goods_history']);
}

//print_r($goodsList);
include(__ROOT__.'view/front/lanmu.html');