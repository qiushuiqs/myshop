<?php


class Model{
	protected $table = NULL; //是model所控制的表
	protected $pk = NULL; //表中的PK
	protected $field =array();
	protected $_fill = array();
	protected $db = NULL; //是引入的mysql对象
	protected $error = array();
	
	public function __construct(){
		$this->db = mysql::getIns();
	}
	
	public function table($table){
		$this->table = $table;
	}
	/*
		负责把传来的数组清除不用的字段。
		留下数据表中对应的字段
		思路： 循环数组，分别判断key是不是数据表的字段。
			先获取数据表的字段。用
	*/
	public function _facade($array=array()){
		$data = array();
		foreach($array as $k=>$v){
			if(in_array($k,$this->field)){
				$data[$k] = $v;
			}
		}
		return $data;
	}
	
	/*
		自动填充
		把未通过表单传过来的字段自动填充到数据库重
		
	*/
	public function _autofill($data){
		foreach($this->_fill as $v){
			if(!array_key_exists($v[0],$data)){
				switch($v[1]){
					case 'value':
					$data[$v[0]] = $v[2];
					break;
					case 'function':
					$data[$v[0]] = $v[2]();
					break;
				}	
			}
		}
		return $data;
	}
	
	/*
		$this->_valid = array(
							array("验证字段","验证类型","错误提示","验证规则","验证规则2")
		);
		验证类型：1 -> 必须填
				  0 -> 有在判断
				  2 -> 非空再判断
		字段验证方法
	*/
	
	public function _validate($data){
		if(empty($this->_valid)){
			return true;
		}
		$this->error=array();
		foreach($this->_valid as $k=>$v){
			switch($v[1]){
				case 1:
					if(!isset($data[$v[0]])|| empty($data[$v[0]])){
						$this->error[]=$v[2];
						return false;
					}
					break;
				case 0:
					if(!isset($data[$v[0]])){
						continue;
					}
					break;
				case 2:
					if(empty($data[$v[0]])){
						continue;
					}
					break;
			}
			switch($v[3]){
				case 'require':
					if(empty($data[$v[0]])){
						$this->error[]=$v[2];
						return false;
					}
					break;
				case 'number':
					if(!is_numeric($data[$v[0]])){
						$this->error[]=$v[2];
						return false;
					}
					break;
				case 'in':
					if(!in_array($data[$v[0]],$v[4])){
						$this->error[]=$v[2];
						return false;
					}
					break;
				case 'between':
					if($data[$v[0]]<$v[4][0] || $data[$v[0]]>$v[4][1]){
						$this->error[]=$v[2];
						return false;
					}
					break;
				case 'length':
					if(strlen($data[$v[0]])<$v[4][0] || strlen($data[$v[0]])>$v[4][1]){
						$this->error[]=$v[2];
						return false;
					}
					break;
				default:
					return false;
			}
		}
		return true;
	}
	
	public function getErr(){
		return $this->error;
	}
	
	/*
	在model父类里，写最基本的增删改查操作
	*/
	/*
		parm array $data
		return bool
	*/
	public function add($data){
		return $this->db->autoExecute($data,$this->table);
	}
	/*
		parm int $id 主键
		return int $affectedrow 影响的行数
	*/
	public function delete($id){
		$sql = 'delete from '.$this->table.' where '.$this->pk.'='.$id;
		if($this->db->query($sql)){
			return $this->db->affected_rows();
		}else{
			return fales;
		}
	}
	
	/*
		parm array  $data
			 int	$id
		return	int 影响行数
	*/
	public function update($data, $id){
		$rs = $this->db->autoExecute($data, $this->table, 'update',' where '.$this->pk.'='.$id);
		if($rs >0){
			return $this->db->affected_rows();
		}else{
			return false;
		}
	}
	
	/*
		return Array 所有行数据
	*/
	public function select(){
		$sql = 'select * from '. $this->table;
		return $this->db->getAll($sql);
	}
	
	/*
		parm int $id 主键
		return Array 单行数据
	*/
	public function find($id){
		$sql = 'select * from '. $this->table.' where '.$this->pk.'='.$id;
		return $this->db->getRow($sql);
	}
	/*
		return all columns name
	*/
	public function showField(){
		$sql = "SHOW COLUMNS FROM ".$this->table;
		$rs = $this->db->getAll($sql);
		$data =array();
		foreach($rs as $v){
			$data[] = $v['Field'];
		}
		
		return $data;
	}
}