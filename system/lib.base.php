<?php

/*
file lib.base.php
递归转义数组
*/
defined('ACC')||exit('ACC Denied');

function _addslashes($arr){
	foreach($arr as $index=>$element){
		if(is_string($element)){
			$arr[$index]=addslashes($element);
		}else if(is_array($element)){
			$arr[$index] =_addslashes($element);
		}
	}
	return $arr;
}