<?php



class TransactinfoModel extends Model{
	protected $table = 'transactinfo';
	protected $pk = 'trans_id';
	protected $field=array();
	
	
	/*
		根据orderid删除以加入transaction表的数据
		para int
		return bool
	*/
	public function cancelTrans($order_id){
		$sql = 'delete from '.$this->table.' where order_id = '.$order_id;
		if($this->db->query($sql)){
			return $this->db->affected_rows();
		}else{
			return false;
		}
	}
}