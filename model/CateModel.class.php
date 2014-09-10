<?php

class CateModel extends Model{
	protected $table = 'cate';
	
	public function add($data){
		return $this->db->autoExecute($data, $this->table,'insert');
	}
}