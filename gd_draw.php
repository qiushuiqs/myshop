<?php
define('ACC',true);
require('./system/init.php');
/*

GD 画图

*/

/*
1创建画布，
可以用imageceatetruecolor创建空白画布，
也可以打开一个画布
*/

/*
	
	扭曲验证码
	正玄曲线函数，弧度函数
*/

$file = './jym1u4.jpg';

//$im = imagecreatefromjpeg($file);
$im = imagecreatetruecolor(650,500);
//配颜色

$purple = imagecolorallocate($im,0,255,255);
$grey = imagecolorallocate($im,150,150,150);
$render = imagecolorallocate($im,mt_rand(0,150),mt_rand(0,150),mt_rand(0,150));
$linecolor1 = imagecolorallocate($im,mt_rand(150,250),mt_rand(150,250),mt_rand(150,250));
$linecolor2 = imagecolorallocate($im,mt_rand(150,250),mt_rand(150,250),mt_rand(150,250));
$linecolor3 = imagecolorallocate($im,mt_rand(150,250),mt_rand(150,250),mt_rand(150,250));

//填充背景
imagefill($im,0,0,$grey);

//画图
$sample = 'qwertyupasdfghjkzxcvbnm23456789';
$csample = array('中','呵','二','想','分','收','人','做');//中文样本
shuffle($csample);
$code = implode('',array_slice($csample,0,4));
/*
$str = substr(str_shuffle($sample),rand(0,strlen($sample)-4),4);
imageline($im, 0,mt_rand(0,25),50,mt_rand(0,25),$linecolor1);
imageline($im, 0,mt_rand(0,25),50,mt_rand(0,25),$linecolor2);
imageline($im, 0,mt_rand(0,25),50,mt_rand(0,25),$linecolor3);
*/
//imagestring($im,5,8,5,$str,$render);
//输出中文
//imagettftext($im,12,0,1,15,$purple,'./simkai.ttf',$code);
//保存图片或者直接输出
/*
//画矩形&椭圆
imagerectangle($im,200,150,600,450,$render);
imageellipse($im,400,300,400,300,$linecolor3);
imageellipse($im,400,300,300,300,$linecolor2);

//填充效果
imagefilledellipse($im,400,300,200,300,$linecolor1);
*/
//画圆弧并填充 
/*IMG_ARC_CHORD	1
  IMG_ARC_PIE	0
  IMG_ARC_NOFILL	2
  IMG_ARC_EDGED	4
*/
//imagearc($im,400,300,300,300,270,0,$purple);
//imagearc($im,400,300,310,310,270,0,$render);
imagefilledarc($im,400,300,310,310,270,0,$render,0+2+4);
imagefill($im,200,200,$linecolor1);
//header('content-type: image/png');
//imagepng($im);



imagedestroy($im);


//图片复制
$sw = 131;
$sh = 40;
$big = imagecreatetruecolor($sw*2+10,$sh);
imagefill($big,0,0,$grey);
$small = imagecreatefrompng("./data/uploads/201409/15/fgozj5.png");
//print_r($small);
imagecopy($big,$small,0,0,0,0,$sw,$sh);
imagecopy($big,$small,$sw+10,0,0,0,$sw,$sh);

header('content-type: image/png');
imagepng($big);
imagedestroy($big);
