<?php

/*
file lib.base.php
递归转义数组
*/
defined('ACC')||exit('ACC Denied');

function _addslashes($arr){
	foreach($arr as $index=>$element){
		if(is_string($element)){
			$arr[$index]=addslashes($element);
		}else if(is_array($element)){
			$arr[$index] =_addslashes($element);
		}
	}
	return $arr;
}

function _displayCart(){
	$comm_cart=array(0,0);
	if(isset($_SESSION['cart'])){
		$cartObj = CartHelper::getCart();
		$comm_cart[0] = $cartObj->getItemCount();
		$comm_cart[1] = $cartObj->getPrice();
	}
	return $comm_cart;
}

function _serialize($obj_array){
	return base64_encode(gzcompress(serialize($obj_array)));
}

function _unserialize($str){
	return unserialize(gzuncompress(base64_decode($str)));
}