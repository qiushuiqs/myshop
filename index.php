<?php

/*
入口文件
framework entry file
*/

//所有文件都需要加载init.php


require('./system/init.php');

$conf = conf::getIns();
print_r($conf->host);
$conf->template_dir = "TEMP_DIR";
print_r($conf->template_dir);
/*
log::write('111111');

class mysql{
	public function query($sql){
		log::write($sql);
	}
}

$mysql = new mysql();

for($i=0; $i<10000; $i++){
	$mysql->query('select * from desktop where hello = 111;select * from desktop where hello = 111;select * from desktop where hello = 111;select * from desktop where hello = 111;select * from desktop where hello = 111');
	usleep(1000);
}
*/

print_r($_GET);

$mysql = mysql::getIns();
//echo "<br>".$mysql->query('insert into test (id, name) values('.$_GET['id'].', \''.$_GET['name'].'\')');
print_r($mysql->getAll('select * from test'));
//echo $mysql->autoExecute($_GET,"test","insert");

//$test = new TestModel();
//var_dump($test->reg(array('id'=>'10','name'=>'frontuser')));