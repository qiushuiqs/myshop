<?php

/*
MVCģʽ��

��������/��������

�����ݽ���modelȥд�����ݿ�

�ж�model�ķ���ֵ��

*/

define('ACC',true);
require('./system/init.php');

//��������
$data['catename'] = $_POST['catename'];
$data['dscrpt'] = $_POST['dscrpt'];

//���Ƽ�⣬$_POST���

//����model
$cateobj = new CateModel();
if($cateobj->add($data)){
	$res = true;
}else{
	$res = false;
}

//չʾ��view
echo $res? "YES":"FAIL";