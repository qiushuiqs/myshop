<?php

/*
后台文件
category栏目删除文件
*/

define('ACC',true);

require('../system/init.php');

$cat_id = $_GET['cat_id'] + 0;

/*
判断该栏目是否有子栏目，没有则不能删，后台检验（还有前台检验和数据库检验）
如果有子栏目则不能删除
*/


$cat = new CategoryModel();
$sons = $cat->getSon($cat_id);
if(!empty($sons)){
	exit("You need to delete sub categories before delete this subject! ");
}
$isDel = $cat->delete($cat_id);

if($isDel){
	echo "OK";
}else
	echo "Fail";
include(__ROOT__.'admin/catelist.php');
