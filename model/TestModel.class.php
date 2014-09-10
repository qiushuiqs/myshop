<?php

class TestModel extends Model{
	protected $table = 'test';
	
	public function reg($data){
		return $this->db->autoExecute($data, $this->table,'insert');
	}
	
	//取所有数据
	public function select(){
		return $this->db->getAll('select * from '.$this->table);
	}
}