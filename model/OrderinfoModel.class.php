<?php



class OrderinfoModel extends Model{
	protected $table = 'orderinfo';
	protected $pk = 'order_id';
	protected $field=array();
	protected $_fill = array(
								array('add_time','function','time')
									);
	protected $_valid =array(
								array('receiver',1,'receiver must have names','require'),
								array('mobile',2,'mobile must be number','number'),
								array('email',1,'email format was wrong','email'),
								array('pay_method',1,'must select a payment method','in',array(3,4,5)),
								array('address',1,'must have address','require')
							);
	
}