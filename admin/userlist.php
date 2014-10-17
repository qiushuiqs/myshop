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
$user = new UserModel();
$userlist = $user->select();

$perPage = 7;
$curPage = isset($_GET['page'])?$_GET['page']:1;
$pageObj =new PaginationHelper(count($userlist), $perPage, $curPage);

$pageMenu = $pageObj->showPageMenu();
$userlist = $user->selectLimited(($curPage-1)*$perPage, $perPage);
$userlist = $user->dataByRealDate($userlist);
include(__ROOT__.'view/admin/templates/userlist.html');
