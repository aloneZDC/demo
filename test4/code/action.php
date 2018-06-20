<?php

header("content-type:text/html;charset=utf-8");
session_start();
print_r($_POST);
echo "<br/>";
print_r($_SESSION);
$yzm=strtolower($_POST['yzm']);    //把字符串转换成小写
$yzm2=strtolower($_SESSION['captcha']);   
if($yzm==$yzm2){
	echo "相等";
}else{
	echo "不相等";
	print_r($yzm);
	print_r($yzm2);
}