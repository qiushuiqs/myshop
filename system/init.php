<?php
/*
file init.php
framework init file
*/

//常量的检验防止非法访问内部ini文件
defined('ACC')||exit('ACC Denied');

//初始化当前的绝对路径-->设为常量
define('__ROOT__', str_replace('\\','/',dirname(dirname(__FILE__))).'/');
define('DEBUG', true);

//引入参数文件
require(__ROOT__.'system/lib.base.php');
//按顺序自动加载model文件（先加载model父类再加载子类），配置文件

function __autoload($class){
	if(substr($class,0,5)=='Model'){
		require(__ROOT__.'model/'.$class.'.class.php');
	}
	else if(stripos(strtolower($class),'model')){
		require(__ROOT__.'model/'.$class.'.class.php');
	}else if(stripos(strtolower($class),'helper')){
		require(__ROOT__.'helper/'.$class.'.class.php');
	}else{
		require(__ROOT__.'system/'.$class.'.class.php');
	}
}

//过滤参数, 用递归方法过滤$_GET, $_POST, $_COOKIE
$_GET = _addslashes($_GET);
$_POST = _addslashes($_POST);
$_COOKIE = _addslashes($_COOKIE);

//启动session
session_start();

//设置报错级别
if(defined('DEBUG')){
	error_reporting(E_ALL);
}else{
	error_reporting(0);
}

