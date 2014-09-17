<?php

/*
file mysql.class.php
mysql Database class implement abstract datbase class (db.class.php)
*/
defined('ACC')||exit('ACC Denied');


class mysql extends db{
	private static $ins = NULL;
	private $conf = array(); //定义一个自身的属性来存储静态config文件
	private $conn = NULL; 
	
	protected function __construct(){
		
		$this->conf = conf::getIns();
		
		$this->connect($this->conf->host, $this->conf->user, $this->conf->password,$this->conf->db);
		//$this->select_db($this->conf->db);
		$this->setChar($this->conf->char);
	}
	
	public function __destruct(){
	}
	
	public static function getIns(){
		if(self::$ins == false){
			self::$ins = new self();
		}
		return self::$ins;
	}
	
	public function connect($h, $u, $p, $d){
		$this->conn = new mysqli($h,$u,$p,$d);
		if(!$this->conn){
			$err = new Exception('Connection Failed');
			throw $err;
		}
	}
	
	protected function select_db($db){
		$sql = 'use '.$db;
		return $this->query($sql);
	}
	
	protected function setChar($char){
		$sql = 'set names '.$char;
		return $this->query($sql);
	}
	//query: return mixed bool/resource
	public function query($sql){
	//	if($this->conf->debug){
	//		log::write($sql);
	//	}
		$rs = $this->conn->query($sql);
		log::write($sql);
		if(!$rs){
			//log::write($this->error());
			log::write("error");
		}
		return $rs;
	}
	
	public function autoExecute($arr, $table, $node='insert', $where=' where 1 limit 1'){
		//insert into tbname(username, value, email) values ()
		if(!is_array($arr)){
			return false;
		}
		//update clause
		if($node == 'update'){
			$sql = 'update '.$table.' set ';
			foreach($arr as $k=>$v){
				$sql .= $k." = '".$v."',"; 
			}
			$sql = rtrim($sql,',');
			$sql .= $where;
			return $this->query($sql);
		}
		
		//insert clause
		$sql = 'insert into '.$table." (".implode(',',array_keys($arr)).')';
		$sql .= 'values (\'';
		$sql .= implode("','", array_values($arr));
		$sql .= '\')';
		
		return $this->query($sql);
	}
	
	public function getAll($sql){
		$rs = $this->query($sql);
		
		$list = array();
		while($row = mysqli_fetch_assoc($rs)){
			$list[] = $row;
		}
		return $list;
	}
	
	public function getRow($sql){
		$rs = $this->query($sql);
		
		return mysqli_fetch_assoc($rs);
	}
	
	public function getOne($sql){
		$rs = $this->query($sql);
		$row = mysqli_fetch_row($rs);
		return $row[0];
	}
	
	//返回影响行数的函数
	public function affected_rows(){
		return mysqli_affected_rows($this->conn);
	}
	
	//返回最新的auto increment 列的自增长的值
	public function insert_id(){
		return mysqli_insert_id($this->conn);
	}
}
