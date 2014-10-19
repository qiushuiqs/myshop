<?php
/*
主页
*/

define('ACC',true);
require('../system/init.php');

$goodsObj = new GoodsModel();


//取出5条新品
$newGoods = $goodsObj->getNewGoods(5);

//取出女装商品
$femaleCateID =4;
$femaleGoods = $goodsObj->goodsByCate($femaleCateID,5, 0);


//取出男装商品
$maleCateID =1;
$maleGoods = $goodsObj->goodsByCate($maleCateID,5, 0);

//print_r($maleGoods);
include(__ROOT__.'view/front/index.html');