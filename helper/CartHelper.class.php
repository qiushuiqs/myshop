<?php

defined('ACC')||exit('ACC Denied');

//购物车类
/*
增删改查
查看所有的items
查看items的种类和数量和总价
增加/减少商品的数量
*/
//单例+session 供全局调用，跟单例加数据库有区别
class CartHelper{
	private static $ins=null;
	private $items = array();
	
	final protected function __construct(){
		//$this->sign = mt_rand(0,999);
	}	
	//获取实例
	protected static function getIns(){
		if(!(self::$ins instanceof CartHelper)){
			self::$ins = new CartHelper();
		}
		return self::$ins;
	}
	//将购物车实例放入session当中
	public static function getCart(){
		if(!isset($_SESSION['cart']) || !($_SESSION['cart'] instanceof self)){
			$_SESSION['cart'] = self::getIns();
		}
		return $_SESSION['cart'];
	}
	
	/*
		加入item到购物车
		para: id	goods_id
			  name	goods_name
			  price	goods_price
			  num	number of goods
		return:	bool
	*/
	public function addItems($id, $name, $price, $num){
		if($this->isItemExist($id)){
			$this->increaseByNum($id);
			return true;
		}
		
		$item=array();
		$item['name'] = $name;
		$item['price'] = $price;
		$item['num'] = $num;
		
		$this->items[$id] = $item; 
		return true;
	}
	
	/*
		清空购物车的item
		para: 
		return:
	*/
	public function clearItems(){
		$this->items= array();
	}
	
	/*
		item在购物车里是否存在
		para:	goods_id
		return:	bool
	*/
	public function isItemExist($id){
		if(array_key_exists($id,$this->items)){
			return true;
		}else{
			return false;
		}
	}
	/*
		增加item的数量
		para:	goods_id
				add number of goods
		return	bool
	*/
	public function increaseByNum($id,$num=1){
		if(!$this->isItemExist($id)){
			return false;
		}else{
			$this->items[$id]['num']+=$num;
		}
		return true;
	}
	/*
		减少item的数量
		para:	goods_id
				add number of goods
		return	bool
	*/
	public function decreaseByNum($id,$num=1){
		if(!$this->isItemExist($id)){
			return false;
		}else{
			if($this->items[$id]['num']<=$num){
				$this->removeItem($id);
			}else{
				$this->items[$id]['num']-=$num;
			}
		}
		return true;
	}
	/*
		删除购物车的item
		para:	goods_id	
		return:	bool
	*/
	public function removeItem($id){
		if(!$this->isItemExist($id)){
			return false;
		}else{
			unset($this->items[$id]);
		}
		return true;
	}
	/*
		查看商品的种类
		return:	商品的种类数
	*/
	public function getItemsNums(){
		return count($this->items);
	}
	/*
		查看商品的总数
		return:	商品数总量
	*/
	public function getItemCount(){
		$sum = 0;
		foreach($this->items as $item){
			$sum += $item['num'];
		}
		return $sum;
	}
	/*
		查看商品的总价格
		return: total price of all goods;
	*/
	public function getPrice(){
		$sum = 0;
		foreach($this->items as $item){
			$sum += $item['num']*$item['price'];
		}
		return $sum;
	}
	/*
		返回所有商品
		return: all items as array
	*/
	public function getAllItems(){
		return $this->items;
	}
	/*
		根据商品ID返回商品数量
		parm: int goods_id
		return: int numbers of this item in cart
	*/
	public function getNoByID($id){
		if(!$this->isItemExist($id)){
			return 0;
		}
		return $this->items[$id]['num'];
	}
}
/*
$obj = CartHelper::getCart();
if(isset($_GET['add'])){
	$obj->addItems($_GET['add'],"example",100,1);
}else if(isset($_GET['clear'])){
	$obj->clearItems();
}else if(isset($_GET['increase'])){
	$obj->increaseByNum($_GET['increase']);
}else if(isset($_GET['decrease'])){
	$obj->decreaseByNum($_GET['decrease']);
}else if(isset($_GET['show'])){
	echo "<br>".$obj->getItemsNums();
	echo "<br>".$obj->getItemCount();
	echo "<br>".$obj->getPrice();
	echo "<br>";
	print_r($obj->getAllItems());
}else{
	print_r($obj);
}
*/