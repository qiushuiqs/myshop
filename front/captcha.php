<?php

//验证码

define('ACC',true);
require('../system/init.php');
$img = new ImageHelper();
$_SESSION['capstr']=strtoupper($img->captcha());