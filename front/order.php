<?php

/*
订单控制器
*/

define('ACC',true);
require('../system/init.php');

/*

订单信息表(orderinfo) 处理
*/

$cartObj = CartHelper::getCart();
$order = new OrderinfoModel();

//先处理表单传来的数据
if(!$order->_validate($_POST)){
	$msg = implode(', ',$order->getErr());
	include(__ROOT__.'view/front/msg.html');
	exit;
}

$data = $order->_autofill($_POST);
$order->setField($order->showField());
$data = $order->_facade($data);

//处理表单外的数据，例如外键信息
$data['user_id'] = isset($_SESSION['user_id'])? $_SESSION['user_id']:0;
$data['username'] = isset($_SESSION['username'])? $_SESSION['username']:'anonymous';
$data['order_amount'] = $cartObj->getPrice();
$data['order_sn'] = $order->snGenerator();
$order_sn = $data['order_sn']; 
$totalprice = $cartObj->getPrice();
//插入订单信息
if(!$order->add($data)){
	$msg = "Order was fail to add in database";
	include(__ROOT__.'view/front/msg.html');
	exit;
}
$rowid = $order->insertedRowNo();


/*
订单商品关联表(transaction) 处理
*/
$data =array();
$trans = new TransactinfoModel();
$goodsObj = new GoodsModel();
$items = $cartObj->getAllItems();
$itemCnt = 0;
foreach($items as $k=>$item){
	$data['goods_id'] = $k;
	$data['goods_name'] = $item['name'];
	$data['goods_number'] = $item['num'];
	$data['shop_price'] = $item['price'];
	$data['subtotal'] = $item['num']*$item['price'];
	$data['order_sn'] = $order_sn;
	$data['order_id'] = $rowid;
	//print_r($data);
	if($trans->add($data)){
		$itemCnt++;
	}
}
//判断是否购物车中所有的商品都添加成功，没有则取消订单以及取消交易,有则修改商品类库存
if($itemCnt!=$cartObj->getItemsNums()){
	if($trans->cancelTrans($rowid)===false || $order->delete($rowid)===false){
		$msg = "Database Corrupt<br>";
		include(__ROOT__.'view/front/msg.html');
		exit;
	}
	$msg = "Problem: checkout not performed<br>";
	include(__ROOT__.'view/front/msg.html');
	exit;
}else{
	foreach($items as $k=>$item){
		if(!$goodsObj->updateStock($k,$item['num'])){
			$msg = "Database Corrupt<br>";
			include(__ROOT__.'view/front/msg.html');
			exit;
		}
	}
}

//清空购物车
$cartObj -> clearItems();

$msg = "S<br>";
include(__ROOT__.'view/front/order.html');