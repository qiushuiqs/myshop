<?php

define('ACC',true);

require('../system/init.php');

//��ʾuserע��ҳ��

$user = new UserModel();

$user ->setField($user ->showField());
$data = $user->_facade($_POST);

//�������
/*
username: 4-20
password: �ǿ�
email: ��email��ʽ
username�Ƿ��ظ�

*/
echo $user->add($data)? "s":"f";