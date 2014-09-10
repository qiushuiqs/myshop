<?php

define('ACC',true);
require('../system/init.php');
/***
Controller:
file catedoedit.php
作用：接受修改category表单。
调用category model，入库
***/

//print_r($_POST);

//第一步：后台检查数据
if(empty($_POST['cat_name'])){
	exit('category name has to be set');
}
//第二步：接受数据
$cat_id = $_POST['cat_id'];
$data['cat_name'] = $_POST['cat_name'];
$data['dscrpt'] = $_POST['cat_desc'];
$data['parent_id'] = $_POST['parent_id']+0;

/*
检查修改后的数据是否引起闭环
*/
$cat = new CategoryModel();
$catlist = $cat->getList();
$trees = $cat->getTree($catlist, $data['parent_id']);

//echo $cat_id."修改后上层栏目页是".$data['parent_id']."<br>";
$canupdate = true;
foreach($trees as $v){
	if($v['cat_id']==$cat_id){
			$canupdate = false;
	}
}

if(!$canupdate){
	echo 'Error: Cannot update '.$cat_id.'是'.$data['parent_id'].'的祖先<br>';
	exit;
}

if($cat->update($cat_id,$data)!=-1){
	echo "category updated successfully";
}else{
	echo "category updated unsuccessfully";
}
