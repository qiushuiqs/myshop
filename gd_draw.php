<?php

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
$im = imagecreatetruecolor(65,25);
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

$str = substr(str_shuffle($sample),rand(0,strlen($sample)-4),4);
imageline($im, 0,mt_rand(0,25),50,mt_rand(0,25),$linecolor1);
imageline($im, 0,mt_rand(0,25),50,mt_rand(0,25),$linecolor2);
imageline($im, 0,mt_rand(0,25),50,mt_rand(0,25),$linecolor3);

//imagestring($im,5,8,5,$str,$render);
//输出中文
imagettftext($im,12,0,1,15,$purple,'./simkai.ttf',$code);
//保存图片或者直接输出
header('content-type: image/png');
imagepng($im);

imagedestroy($im);
?>

