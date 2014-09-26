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
/*	
	已放置model类中
	public function setField($field){
		$this->field = $field;
	}
*/
	//商品编号(goods_sn)自动增加的迭代器
	public function snGenerator(){
		$sn = time().mt_rand(10000,99999);
		$sql = "select * from ".$this->table." where goods_sn = ".(int)$sn;
		return $this->db->getOne($sql)? snGenerator():$sn;
	}
	
	/*
		取出前N（5）个新品，根据加入的时间
		parm int number of new goods
		return array data
	*/
	public function getNewGoods($n = 5){
		$sql = 'select goods_id, goods_name, shop_price, market_price, thumb_img, add_time from '.$this->table.
		' where is_new = 1 order by add_time desc limit '.$n;
		$data = $this->db->getAll($sql);
		return $data;
	}
	/*
		取出指定栏目的商品。包括其子栏目的商品
		parm int category ID
			 int number of goods
		return array all the goods in terms of category IDs
	*/
	public function goodsByCate($cateID,$n = null){
		$cateObj = new CategoryModel();
		$allCates = $cateObj->select();
		$cateList = $cateObj->getCatTree($allCates,$cateID);
		$cateIDList = array($cateID);
		foreach($cateList as $v){
			$cateIDList[] = $v['cat_id'];
		}
		
		$instring = implode(',', $cateIDList);
		$sql = 'select goods_id,goods_name, shop_price, market_price, thumb_img, add_time, goods_img from '.$this->table.
		' where cat_id in ('.$instring.') order by add_time desc';
		if(is_numeric($n)){
			$sql .= ' limit '.$n;
		}
		$data = $this->db->getAll($sql);
		return $data;
	}
	/*
		根据购物车返回完整商品信息
		parm array list of items in cart
		return array list of items with more information about goods
	*/
	public function goodsByCart($cart){
		foreach($cart as $k=>$v){
			$sql = "select market_price, thumb_img from ".$this->table.' where goods_id='.$k;
			$data = $this->db->getRow($sql);
			$cart[$k]['market_price'] = $data['market_price'];
			$cart[$k]['thumb_img'] = $data['thumb_img'];
		}
		
		return $cart;
	}
}