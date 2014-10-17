<?php

/*
后台文件
Background entry file
*/
if(!defined('ACC')){
	define('ACC',true);
	require('../system/init.php');
}
//
$order = new OrderinfoModel();
$orderlist = $order->select();
//print_r($orderlist);
/* [1] => Array
        (
            [order_id] => 2
            [order_sn] => 
            [user_id] => 3
            [username] => qiushuiqs
            [zone] => shanghai
            [address] => wewewe
            [postcode] => 2213
            [receiver] => xionghao
            [email] => wangjian@13.com
            [tel] => 1322213
            [mobile] => 12312321232
            [building] => 
            [best_time] => 
            [add_time] => 1411832523
            [order_amount] => 398.00
            [pay_method] => 4
        ) 
		*/
//print_r($catetree);
include(__ROOT__.'view/admin/templates/orderlist.html');
