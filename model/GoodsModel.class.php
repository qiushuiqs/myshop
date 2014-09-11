<?php



class GoodsModel extends Model{
	protected $table = 'goods';
	protected $pk = 'goods_id';
	protected $field=array();
	/*
		放入回收站，将is_delete变为1
		parm int id 删除的key
		return bool
	*/
	public function inTrash($id){
		return $this->update(array('is_delete'=>1),$id);
	}	
	/*
		根据下架不下架显示商品
		parm int delete =1 下架， =0 未下架
		return data
	*/
	public function getGoodsVsTrash($delete){
		$sql = 'select * from '. $this->table.' where is_delete = '.$delete;
		return $this->db->getAll($sql);
	}
	public function setField($field){
		$this->field = $field;
	}
}