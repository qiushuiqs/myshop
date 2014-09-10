<?php
/*
file db.class.php
Uniform Config singleton class
*/

defined('ACC')||exit('ACC Denied');

class conf{
	protected static $ins = null;
	protected $data =array();	//������Ϣ����
	//���ܼ̳�
	final protected function __construct(){
		//һ���԰������ļ���Ϣ���������� ���г�Ա������֮��Ҫ������Ϣ��ֱ����get������
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
	//��ħ��������ȡDATA��Ϣ
	public function __get($key){
		if(array_key_exists($key, $this->data)){
			return $this->data[$key];
		}else
			return null;
	}
	
	//��ħ��������̬���ӻ�ı�DATA��Ϣ�������ļ���
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