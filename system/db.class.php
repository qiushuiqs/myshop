<?php
/*
file db.class.php
Database abstract class
*/
defined('ACC')||exit('ACC Denied');

//目前数据库不知道

/*
	database class
	parms $h host
	parms $u username
	parms $p password
*/
abstract class db{
	//connect database
	public abstract function connect($h, $u, $p, $d);
	//query: return mixed bool/resource
	public abstract function query($sql);
	//getall: return array/bool
	public abstract function getall($sql);
	//
	public abstract function getrow($sql);
	//
	public abstract function getone($sql);
	//
	public abstract function autoExecute($table, $data, $act='insert', $where='');
}