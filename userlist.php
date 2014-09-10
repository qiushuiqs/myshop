<?php

require('./system/init.php');

$test = new TestModel();
$list = $test->select();
//print_r($list);
include(__ROOT__.'view/userlist.html');