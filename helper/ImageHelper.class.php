<?php

/*
获取图片信息
加水印
缩略图

*/

define('ACC',true);
//require('./system/init.php');

class ImageHelper{
	protected static $errMsg;
	//获取图片信息 --静态类
	/*
		parm filename string
		return array of fileinfo
	*/
	public static function imageInfo($filename){
		if(!file_exists($filename)){
			self::$errMsg = 'ERR\(imageInfo\)-> Cannot find file: '.$filename;
			return false;
		}
		$arr = getimagesize($filename);
		$info['w'] = $arr[0];
		$info['l'] = $arr[1];
		$info['t'] = substr($arr['mime'],stripos($arr['mime'],'/')+1);
		
		return $info;
	}
	public static function getErr(){
		return self::$errMsg;
	}
	//增加水印
	/*
		parm 
		return 
	*/
	public static function waterImage($pic, $water, $dest=null, $pos=3, $alpha=50){
		//判断原图片大小 要大于水印图片返回真
		if(($base = self::imageInfo($pic))===false){
			return false;
		}
		if(($attch = self::imageInfo($water))===false){
			return false;
		}
		if($base['w']<$attch['w'] ||$base['l']<$attch['l'] ){
			self::$errMsg = 'ERR\(waterImage\)->'.$pic.' should bigger than '.$water;
			return false;
		}
		
		//根据类型选择打开画布的函数
		$c_source = 'imagecreatefrom'.$base['t'];
		$c_water = 'imagecreatefrom'.$attch['t'];
		
		if(!function_exists($c_source) || !function_exists($c_water)){
			self::$errMsg = 'ERR\(waterImage\)->unknown '.$base['t'].' or unknown '.$attch['t'];
			return false;
		}
		$des = $c_source($pic);
		$src = $c_water($water);
		
		//加水印
		switch($pos){
			case 1:
			$pos_x = 0;
			$pos_y = 0;
			break;
			case 2:
			$pos_x = $base['w']-$attch['w'];
			$pos_y = 0;
			break;
			case 4:
			$pos_x = 0;
			$pos_y = $base['l']-$attch['l'];
			break;
			case 5:
			$pos_x = ($base['w']-$attch['w'])/2;
			$pos_y = ($base['l']-$attch['l'])/2;
			break;
			default:
			$pos_x = $base['w']-$attch['w'];
			$pos_y = $base['l']-$attch['l'];
		}
		imagecopymerge($des,$src,$pos_x,$pos_y,0,0,$attch['w'],$attch['l'],$alpha);
		
		//加载到图片文件或者替换源文件
		$loadPic = 'image'.$base['t'];
		if(!$dest){
			unlink($pic);
			$loadPic($des,$pic);
		}
		$loadPic($des,$dest);
		
		//销毁资源
		imagedestroy($des);
		imagedestroy($src);
		return true;
	}
}

print_r(ImageHelper::imageInfo('../data/uploads/201409/15/test.png'));
echo ImageHelper::getErr();
if (ImageHelper::waterImage('../data/uploads/201409/15/test.png', "../data/uploads/201409/15/fgozj5.png", './gaga.png',10,100)){
	echo "s";
}else{
	echo 'f';
}