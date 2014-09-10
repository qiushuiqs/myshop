<?php
/*
file db.class.php
Uniform Config singleton class
*/

defined('ACC')||exit('ACC Denied');

class conf{
	protected static $ins = null;
	protected $data =array();	//配置信息储存
	//不能继承
	final protected function __construct(){
		//一次性把配置文件信息读过来赋给 单列成员变量，之后要配置信息，直接用get属性找
		include(__ROOT__."system\config.init.php");
		$this->data = $_CFG;
	}
	final protected function __clone(){
	}
	
	public static function getIns(){
		if(self::$ins instanceof self){
			return self::$ins;
		}else{
			self::$ins = new self();
			return self::$ins;
		}
	}
	//用魔术方法读取DATA信息
	public function __get($key){
		if(array_key_exists($key, $this->data)){
			return $this->data[$key];
		}else
			return null;
	}
	
	//用魔术方法动态增加或改变DATA信息（配置文件）
	public function __set($key, $value){
		$this->data[$key] = $value;
	}
}
/***
$conf = conf::getIns();
print_r($conf->host);
$conf->template_dir = "TEMP_DIR";
print_r($conf->template_dir);
***/