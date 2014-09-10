<?php

/*
后台文件
Background entry file
*/

define('ACC',true);

require('../system/init.php');


$cat = new CategoryModel();
$catlist = $cat->getList();
$cattree = $cat->getCatTree($catlist,0);
include(__ROOT__.'view/admin/templates/cateadd.html');
