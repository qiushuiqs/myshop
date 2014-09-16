<?php

/*
入口文件
framework entry file
*/

//所有文件都需要加载init.php

define('ACC',true);
require('./system/init.php');
/*
if(isset($_POST['dosubmit'])){
	//$conf = conf::getIns();
	//print_r($conf->host);
	//$conf->template_dir = "TEMP_DIR";
	//print_r($conf->template_dir);
	$up = new UploadHelper();
	$up->setExt('jpg,jpeg,gif,bmp,png,pdf');
	if($res = $up->doUpload('file')){
		echo "successful<br>";
		echo $res."</br>";
	}else{
		echo $up->getErr();
	}
}
*/
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

//print_r($_GET);

//$mysql = mysql::getIns();
//echo "<br>".$mysql->query('insert into test (id, name) values('.$_GET['id'].', \''.$_GET['name'].'\')');
//print_r($mysql->getAll('select * from test'));
//echo $mysql->autoExecute($_GET,"test","insert");
//$test = new TestModel();
//var_dump($test->reg(array('id'=>'10','name'=>'frontuser')));


class ImageHelper{
	protected $errMsg;
	//获取图片信息 --静态类
	/*
		parm filename string
		return array of fileinfo
	*/
	public static imageInfo($filename){
		if(!file_exists($filename)){
			$errMsg = 'ERR\(imageInfo\)-> Cannot find file: '.$filename;
			return false;
		}
		$arr = getimagesize($filename);
		$info['w'] = $arr[0];
		$info['l'] = $arr[1];
		$info['t'] = substr($arr['mime'],stripos($arr['mime'],'/')+1);
		
		return $info;
	}
	
	public waterImage(){
	}
}

print_r(ImageHelper::imageInfo());
/*
?>
<form action ="" method="post" enctype='multipart/form-data'>
filename:<input type='text' name='filename' value='' /><br/>
file: <input type='file' name='file' /><br/>
<input type='submit' name='dosubmit' value='OK' />
</form>
*/