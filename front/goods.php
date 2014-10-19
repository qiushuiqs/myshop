<?php
/*
商品页
*/

define('ACC',true);
require('../system/init.php');

$cateObj = new CategoryModel();
$goodsObj = new GoodsModel();

$goodsID = $_GET['goods_id'];
$goodsInfo = $goodsObj->find($goodsID);
if(!isset($goodsInfo)){
	header('Location: index.php');
}

//print_r(serialize($goodsInfo));
$catID = $goodsInfo['cat_id'];
$allCates =$cateObj->select();
$cateNav = $cateObj->getTree($allCates,$catID);
$cateInfo = $cateObj->find($catID);
//print_r($cateNav);
//加入浏览记录用cookie做
//是否有cookie，没有则设置，有则加入，超过5个自动删除
if(isset($_COOKIE['goods_history'])){
	$history = _unserialize($_COOKIE['goods_history']);
	foreach($history as $k=>$v){
		if($v['goods_id']!=$goodsID){
			continue;
		}else{
			array_splice($history, $k, 1);
			break;
		}
	}
	array_unshift($history, $goodsInfo);
	if(count($history)>5){
		array_pop($history);
	}
	setcookie('goods_history', _serialize($history), time()+3600*24*7);
}else{
	$history = array();
	array_unshift($history, $goodsInfo);
	setcookie('goods_history', _serialize($history), time()+3600*24*7);
}

if(isset($_SESSION['user_id'])){
	$userid=$_SESSION['user_id'];
	$username=$_SESSION['username'];
	$email = $_SESSION['email'];
}else{
	$userid=0;
	$username='annonnymous';
	$email='';
}

include(__ROOT__.'view/front/shangpin.html');