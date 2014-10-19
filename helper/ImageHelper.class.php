<?php

/*
获取图片信息
加水印
缩略图
验证码
*/


defined('ACC')||exit('ACC Denied');

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
		parm pic: original picture path
			 water:	attached water picture path
			 dest:	saved file location
			 pos:	position of water image, 1->top left, 2->top right, 3->bottom right(default), 4->bottom left, 5->center
			 alpha:	transparent of water image
		return bool
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
			$dest = $pic;
			unlink($pic);
		}
		$loadPic($des,$dest);
		
		//销毁资源
		imagedestroy($des);
		imagedestroy($src);
		return true;
	}
	
	//生成缩略图 等比缩放两边留白
	/*
		pram pic：原图片
			 dest: 目标图片存储地址
			 width: 新图片的宽
			 hight: 新图片的高
		return bool
	*/
	public static function thumbImage($pic, $dest, $width=200, $hight=200){
		//获取图片信息，check文件是否存在
		if(($base=self::imageInfo($pic))===false){
			return false;
		}
		if(!is_numeric($width) || !is_numeric($hight)){
			self::$errMsg = 'ERR(thumbImage)->width '.$width.' or hight '.$hight.' are not numbers';
			return false;
		}
		
		//开启图片资源并创建新白色画布
		$c_source = 'imagecreatefrom'.$base['t'];
		$org = $c_source($pic);
		
		
		$target = imagecreatetruecolor($width, $hight);
		$white = imagecolorallocate($target,255,255,255);
		imagefill($target,0,0,$white);
		
		//Preparation work for thumb picture: Calculation of width/length, padding
		$scaling = min($width/$base['w'], $hight/$base['l']);	//缩略比例
		$target_w = (int)($scaling*$base['w']);
		$target_h = (int)($scaling*$base['l']);
		$pos_x = ($width - $target_w)/2;			//置中
		$pos_y = ($hight - $target_h)/2;
		
		//生成缩略图
		imagecopyresampled($target, $org, $pos_x, $pos_y, 0, 0, $target_w, $target_h, $base['w'], $base['l']);
		
		//加载到图片文件或者替换源文件
		$loadPic = "image".$base['t'];
		if(!$dest){
			$dest = $pic;
			unlink($pic);
		}
		$loadPic($target, $dest);
		
		//销毁图片资源
		imagedestroy($target);
		imagedestroy($org);
		
		return true;
	}
	
	//生成验证码
	/*
	
	*/
	public static function captcha($width = 90, $height = 30, $mode = 1){
		//创建画布
		$cap1 = imagecreatetruecolor($width, $height);
		$cap2 = imagecreatetruecolor($width, $height);
		
		//设置颜色和背景
		$bg1 = imagecolorallocate($cap1,200,200,200);
		$bg2 = imagecolorallocate($cap2,200,200,200);
		imagefill($cap1, 0, 0, $bg1);
		imagefill($cap2, 0, 0, $bg2);
		
		//设置字体和干扰线的颜色
		$renderfont = imagecolorallocate($cap1,mt_rand(0,150),mt_rand(0,150),mt_rand(0,150));
		for( $i=1; $i<4; $i++){
			$linecolor1[$i] = imagecolorallocate($cap1,mt_rand(150,250),mt_rand(150,250),mt_rand(150,250));
			$linecolor2[$i] = imagecolorallocate($cap2,mt_rand(150,250),mt_rand(150,250),mt_rand(150,250));
		}
		
		//画出验证码
		$sample = strtoupper('qwertyupasdfghjkzxcvbnm').'qwertyupasdfghjkzxcvbnm23456789';
		$str = substr(str_shuffle($sample),rand(0,strlen($sample)-4),5);

		imagestring($cap1, 5, 18, 9, $str,$renderfont);
		
		//扭曲验证码
		$offset = mt_rand(1,4);
		$turn = mt_rand(1,3);
		for($i=0; $i<$width; $i++){
			$y = round(sin(2*M_PI/$width*$i*$turn)*$offset);
			imagecopymerge($cap2, $cap1, $i, $y, $i, 0, 1, $height, 100);
		}
		for( $i=1; $i<4; $i++){
			imageline($cap1, 0,mt_rand($height/3*($i-1),$height/3*$i),$width,mt_rand($height/3*($i-1),$height/3*$i),$linecolor1[$i]);
			imageline($cap2, 0,mt_rand($height/3*($i-1),$height/3*$i),$width,mt_rand($height/3*($i-1),$height/3*$i),$linecolor2[$i]);
		}
		//显示图片
		header('content-type: image/png');
		imagepng($cap2);
		
		//销毁资源
		imagedestroy($cap1);
		imagedestroy($cap2);
		return $str;
	}	
}
/*
print_r(ImageHelper::imageInfo('../data/uploads/201409/15/test.png'));
echo ImageHelper::getErr();
if (ImageHelper::waterImage('../data/uploads/201409/15/test.png', "../data/uploads/201409/15/fgozj5.png", './gaga.png',10,100)){
	echo "s";
}else{
	echo 'f';
}

echo ImageHelper::thumbImage('../data/uploads/201409/15/test.png', './gaga.png')? "s":"f";
echo ImageHelper::thumbImage('../data/uploads/201409/15/test.png', './gaga1.png', 200, 300)? "s":"f";
echo ImageHelper::thumbImage('../data/uploads/201409/15/test.png', './gaga2.png', 300, 200)? "s":"f";
echo ImageHelper::thumbImage('../data/uploads/201409/15/test.png', './gaga2.png', 'sdds', 200)? "s":ImageHelper::getErr();
*/