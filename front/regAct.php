<?php

define('ACC',true);

require('../system/init.php');

//��ʾuserע��ҳ��
$msg = ''; //���ص�ǰ̨����Ϣ
$user = new UserModel();


$data = $user->_autofill($_POST);

//�������
/*
username: 4-20
password: �ǿ�
email: ��email��ʽ
username�Ƿ��ظ�
*/
if(!$user->_validate($data)){
	list($error) = $user->getErr();
	$msg .= $error;
}else{
	$user ->setField($user ->showField());
	$data = $user->_facade($data);
}

if(!$user->reg($data)){
	list($error) = $user->getErr();
	$msg = $error;
}else{
	$msg .= "Register Sucessfully!";
}
include('../view/front/msg.html');

//echo $user->add($data)? "s":"f";