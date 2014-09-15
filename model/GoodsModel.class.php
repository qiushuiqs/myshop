<?php



class GoodsModel extends Model{
	protected $table = 'goods';
	protected $pk = 'goods_id';
	protected $field=array();
	protected $_fill = array(
								array('is_hot','value',0),
								array('is_new','value',0),
								array('is_best','value',0),
								array('add_time','function','time')
									);
	protected $_valid =array(
								array('goods_name',1,'goods must have names','require'),
								array('cat_id',1,'catID must be number','number'),
								array('is_new',0,'must be new or not','in',array(1,0)),
								array('is_hot',0,'must be hot or not','in',array(1,0)),
								array('is_best',0,'must be best or not','in',array(1,0)),
								array('goods_brief',2,'between 10 to 100','length',array(10,100))
									);
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