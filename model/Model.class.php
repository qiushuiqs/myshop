<?php


class Model{
	protected $table = NULL; //是model所控制的表
	protected $pk = NULL; //表中的PK
	protected $field =array();
	protected $db = NULL; //是引入的mysql对象
	
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