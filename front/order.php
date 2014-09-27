<?php

/*
订单控制器
*/

define('ACC',true);
require('../system/init.php');

/*

加入model
*/

$order = new OrderinfoModel();

if(!$order->_validate($_POST)){
	$msg = implode(', ',$order->getErr());
	include(__ROOT__.'view/front/msg.html');
	exit;
}

$data = $order->_autofill($_POST);
$order->setField($order->showField());
$data = $order->_facade($data);

$data['user_id'] = isset($_SESSION['user_id'])? $_SESSION['user_id']:0;
$data['username'] = isset($_SESSION['username'])? $_SESSION['username']:'anonymous';
$data['order_amount'] = $_SESSION['t_shopprice'];

//插入订单信息
if(!$order->add($data)){
	$msg = "Order was fail to add in database";
	include(__ROOT__.'view/front/msg.html');
}else{
	$msg = "Order add in database";
	include(__ROOT__.'view/front/msg.html');
}
