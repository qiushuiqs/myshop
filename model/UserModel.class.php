<?php

class UserModel extends Model{
	protected $table = "user";
	protected $pk = "user_id";
	protected $_fill = array(
							array('regtime','function','time'),
							array('agreement','value',0)
	);
	protected $_valid = array(
							array('username',1,'username is not valid <br>','length', array(4,20)),
							array('email',2,'email is not valid <br>','email'),
							array('password',1,'user must have password <br>','require')
	);
	
	//重写model类的验证方法，加入密码两遍输入的匹配和同意条款的确认
	public function _validate($data){
		if(!parent::_validate($data)){
			return false;
		}
		if($data['repassword']!=$data['password']){
			$this->error[] = "Passwords are not same <br>";
			return false;
		}
		if($data['agreement']!=1){
			$this->error[] = "You don't agree the regulation <br>";
			return false;
		}
		return true;
	}
	
	protected function encodeM5($pw){
		return md5($pw);
	}	

	public function reg($data){
		$sql = 'select count(*) from '.$this->table.' where username=\''.$data['username'].'\'';
		if($this->db->getOne($sql)){
			$this->error[] = "The username was occupied <br>";
			return false;
		}
		$data['password'] = $this->encodeM5($data['password']);
		return parent::add($data);
	}
}