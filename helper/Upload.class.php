<?php

/*
文件上传类


*/

defined('ACC')||exit('ACC Denied');

/*
UPLOAD_ERR_INI_SIZE
其值为 1，上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。

UPLOAD_ERR_FORM_SIZE
其值为 2，上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。

UPLOAD_ERR_PARTIAL
其值为 3，文件只有部分被上传。

UPLOAD_ERR_NO_FILE
其值为 4，没有文件被上传。

UPLOAD_ERR_NO_TMP_DIR
其值为 6，找不到临时文件夹。PHP 4.3.10 和 PHP 5.0.3 引进。

UPLOAD_ERR_CANT_WRITE
上传文件
配置允许的后缀
配置允许的大小

获取文件的后缀
检测文件的大小
创建文件夹目录
*/ 

class Upload{
	protected $allowExt = 'jpg,jpeg,gif,bmp,png';
	protected $maxsize = 1;  //以M为单位
	protected $errno = 0;
	protected $errMsg =array(
							0=>'Successful',
							1=>'ERR: Upload file exceeds PHP Limit',
							2=>'ERR: Upload file exceeds HTML Limit',
							3=>'ERR: Upload file partly received',
							4=>'ERR: No Upload file',
							6=>'ERR: No Temp directory',
							7=>'ERR: Upload file cannot be written',
							8=>'ERR: File Extension is not allowed',
							9=>'ERR: Upload file exceeds Class Limit',
							10=>'ERR: Persistence Directory Created Failed',
							11=>'ERR: Move Uploaded file Failed',
							12=>'ERR: _File not Exist'
	);
	/*
	
	*/
	public function doUpload($key){
		//测试文件信息
		if(!isset($_FILES[$key])){
			$this->errno = 12;
			return false;
		}
		$file = $_FILES[$key];
		if($file['error']){
			$this->errno = $file['error'];
			return false;
		}
		
		$ext = $this->getExt($file['name']);
		if(!$this->isAllowExt($ext)){
			$this->errno = 8;
			return false;
		}
		if(!$this->isAllowSize($file['size'])){
			$this->errno = 9;
			return false;
		}
		//创建目录以及改变上传文件名称
		$dir = $this->mk_dir();
		
		if($dir==false){
			$this->errno = 10;
			return false;
		}
		
		$newname = $this->randName().'.'.$ext;
		//移动临时文件到目的文件夹
		if(!move_uploaded_file($file['tmp_name'], $dir.$newname)){
			$this->errno = 11;
			return false;
		}
		return $dir;
	}
	
	public function getErr(){
		return $this->errMsg[$this->errno];
	}
	
	/*
		parm string $file ->filename
		return string extension name
	*/
	protected function getExt($file){
		$ext = explode('.',$file);
		return end($ext);
	}
	
	/*
		parm string $extension name
	*/
	protected function isAllowExt($ext){
		if(in_array(strtolower($ext),explode(',',strtolower($this->allowExt)))){
			return true;
		}
		return false;
	}
	
	protected function isAllowSize($size){
		return $this->maxsize*1024*1024>=$size;
	}
	
	/*
		按日期创造文件目录
	*/
	protected function mk_dir(){
		$dir = __ROOT__.'data/uploads/'.date('Ym/d').'/';
		if(is_dir($dir)||mkdir($dir,0777,true)){
			return $dir;
		}else{
			return false;
		}
	}
	/*
	生成随机文件名
	*/
	protected function randName($length=6){
		$str = 'qwertyuiopasdfghhjklzxcvbnm1234567890';
		return substr(str_shuffle($str),rand(0,strlen($str)-$length),$length);
		
	}
	
}