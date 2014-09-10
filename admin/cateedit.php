<?php

/*
后台文件
cateedit.php
取出cat_id
实例化model
调用方法
*/

define('ACC',true);

require('../system/init.php');

$cat_id = $_GET['cat_id'] + 0;

$cat = new CategoryModel();
$catrecord = $cat->find($cat_id);
$catlist = $cat->getList();
$cattree = $cat->getCatTree($catlist,0);
//print_r($catrecord);
include(__ROOT__.'view/admin/templates/cateedit.html');
