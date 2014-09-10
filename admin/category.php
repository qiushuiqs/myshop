<?php

define('ACC',true);
require('../system/init.php');
/***
Controller:
file category.php
作用：接受添加category表单。
调用category model，入库
***/

//print_r($_POST);

//第一步：后台检查数据
if(empty($_POST['cat_name'])){
	exit('category name has to be set');
}
//第二步：接受数据
$data['cat_name'] = $_POST['cat_name'];
$data['dscrpt'] = $_POST['cat_desc'];
$data['parent_id'] = $_POST['parent_id'];

//print_r($data);
//第三步：实例化model，调用方法

$cat = new CategoryModel();
if($cat->add($data)){
	echo "category added successfully";
}else{
	echo "category added unsuccessfully";
}
