<?php

define('ACC',true);
require('../system/init.php');

//echo __ROOT__;exit;
$cat = new CategoryModel();
$catlist = $cat->getList();
$cattree = $cat->getCatTree($catlist,0);

include(__ROOT__.'view/admin/templates/goodsadd.html');

