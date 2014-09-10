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
$cat = new CategoryModel();
$catelist = $cat->getList();
//print_r($catelist);
$catetree = $cat->getCatTree($catelist,0);
//print_r($catetree);
include(__ROOT__.'view/admin/templates/catelist.html');
