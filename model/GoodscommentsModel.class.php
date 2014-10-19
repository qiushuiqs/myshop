<?php



class GoodscommentsModel extends Model{
	protected $table = 'goodscomments';
	protected $pk = 'comments_id';
	protected $field=array();
	protected $_fill = array(
								array('add_time','function','time')
									);
	protected $_valid =array(
								array('email',1,'email format was wrong','email'),
								array('clevel',1,'The level of comment have to be filled','in',array(1,2,3,4,5)),
								array('goods_brief',2,'between 10 to 100','length',array(10,100))
									);
	
}