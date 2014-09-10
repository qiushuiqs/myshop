<?php


class Model{
	protected $table = NULL; //是model所控制的表
	protected $pk = NULL; //表中的PK
	protected $db = NULL; //是引入的mysql对象
	
	public function __construct(){
		$this->db = mysql::getIns();
	}
	
	public function settable($table){
		$this->table = $table;
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
		$rs = $this->autoExecute($data, $this->table, 'update',' where '.$this->pk.'='.$id);
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
		return $this->db->getall($sql);
	}
	
	/*
		parm int $id 主键
		return Array 单行数据
	*/
	public function find($id){
		$sql = 'select * from '. $this->table.' where '.$this->pk.'='.$id;
		return $this->db->getRow($sql);
	}
}