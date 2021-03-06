<?php

define('ACC',true);
require('../system/init.php');
/*
$data = array();

$data['goods_name'] = trim($_POST['goods_name']);
$data['goods_sn'] = trim($_POST['goods_sn']);
$data['cat_id'] = $_POST['cat_id']+0;
$data['shop_price'] = $_POST['shop_price']+0;
$data['market_price'] = $_POST['market_price']+0;
$data['goods_desc'] = trim($_POST['goods_desc']);
$data['goods_weight'] = $_POST['goods_weight']*$_POST['weight_unit'];
$data['is_best'] = isset($_POST['is_best'])? 1:0;
$data['is_new'] = isset($_POST['is_new'])? 1:0;
$data['is_hot'] = isset($_POST['is_hot'])? 1:0;
$data['is_on_sale'] = isset($_POST['is_on_sale'])? 1:0;
//$data['keywords'] = trim($_POST['keywords']);
$data['goods_brief'] = trim($_POST['goods_brief']);

$data['add_time'] = time();
*/
$goods = new GoodsModel();
$data = array();
$goods->setField($goods->showField());

//自动格式化数据
$data=$goods->_facade($_POST);
$data['goods_weight'] = $_POST['goods_weight']*$_POST['weight_unit'];
//自动填充
$data=$goods->_autofill($data);
//自动校验
if(!$goods->_validate($data)){
	echo $goods->getErr()[0];
	exit;
}
//若没有goods_sn，自动生成
if(!$data['goods_sn']){
	$data['goods_sn'] = $goods->snGenerator();
}

//上传图片
$updriver = new UploadHelper();
$ori_img = $updriver->doUpload('goods_img');
if($ori_img){
	$data['ori_img'] = $ori_img;

//处理缩略图文件名	
	$abs_ori = __ROOT__.$ori_img;
	
	$abs_goods = dirname($abs_ori)."/goods_".basename($abs_ori);
	$goods_img = str_replace(__ROOT__,'',$abs_goods);
	$abs_thumb = dirname($abs_ori)."/thumb_".basename($abs_ori);
	$thumb_img = str_replace(__ROOT__,'',$abs_thumb);
		
//将上传图片按一下两种格式resample
//goods picture 300*400 thumb picture: 160*220
	$data['goods_img'] = $goods_img;
	$data['thumb_img'] = $thumb_img;
	
	ImageHelper::thumbImage($abs_ori, $abs_goods, 300, 400);
	ImageHelper::thumbImage($abs_ori, $abs_thumb, 160, 220);
}

if($goods->add($data)){
	echo 'goods add successfully<br>';
}else{
	echo 'goods add unsuccessfully<br>';
}
//print_r($data);

