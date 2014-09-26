<?php
/*
将商品加入购物车
*/

define('ACC',true);
require('../system/init.php');

//实例化购物车类和商品类
$cartObj = CartHelper::getCart();
$goods = new GoodsModel();

$act = isset($_GET['act'])? $_GET['act']:'buy';

//购买商品，去结算
if($act=='buy'){
	if(isset($_GET['goods_id'])){
		$goods_id = $_GET['goods_id'];
		$goods_info = $goods->find($goods_id);
		$num = isset($_GET['num'])? $_GET['num']+0:1;
		//商品是否存在
		if(!isset($goods_info)){
			$msg = "The ware is not exist<br>";
			include(__ROOT__.'view/front/msg.html');
			exit;
		}
		//商品是否上架或者删除
		if($goods_info['is_delete'] || (!$goods_info['is_on_sale'])){
			$msg = "The ware is not available<br>";
			include(__ROOT__.'view/front/msg.html');
			exit;
		}
		//商品是否有库存
		if(($cartObj->getNoByID($goods_id)+$num)>$goods_info['goods_number']){
			$msg = "Out of stock<br>";
			include(__ROOT__.'view/front/msg.html');
			exit;
		}
		
		$cartObj->addItems($goods_id,$goods_info['goods_name'],$goods_info['shop_price'],$num);
		
	}
	

}else if($act == 'clear'){
	//清空购物车中所有的商品
	if(!isset($_GET['goods_id'])){
		$cartObj->clearItems();
		$msg = "Cart was empty now<br>";
		include(__ROOT__.'view/front/msg.html');
		exit;
	}else{
	//根据ID删除购物车中的商品
		$goods_id = $_GET['goods_id'];
		if($cartObj->removeItem($goods_id)==false){
			$msg = "You can not delete the Item which was not in the cart<br>";
			include(__ROOT__.'view/front/msg.html');
			exit;
		}
	}
}

$items = $cartObj->getAllItems();

if(empty($items)){
	header('Location: index.php');
	exit;
}
$items = $goods->goodsByCart($items);
$numOfGoods =$cartObj->getItemCount();
$t_shopprice = $cartObj->getPrice();
//算出市场总价
$t_mktprice = 0;
foreach($items as $item){
	$t_mktprice += $item['market_price']*$item['num'];
}
$discount =$t_mktprice-$t_shopprice; 
$discount_prc = floor((int)$discount/$t_mktprice*100);
include(__ROOT__.'view/front/jiesuan.html');