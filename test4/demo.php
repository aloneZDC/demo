<?php

header("content-type:text/html;charset=utf-8");
$mem=new Memcache();
$mem->connect('127.0.0.1',11211);
$name=$mem->get('data');
if(empty($name)){
	echo "mysql";
	$mysql=new PDO("mysql:host=127.0.0.1;dbname=weidogs","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
	$rs=$mysql->query("select * from bg_cate");
	$getarr=array();
	$i=0;
	while($row=$rs->fetch()){
		$getarr[$i]['title']=$row['cate_Name'];
		$getarr[$i]['content']=$row['cate_Intro'];
		$i=$i+1;
	}
	print_r($getarr);
	$json=json_encode($getarr);
	$mem->set('data',$json);
}else{
	echo "memcache";
	$getarr=json_decode($name,true);
	print_r($getarr);
}

header("content-type:text/html;charset=utf-8");
$mem=new memcache();
$mem->connect("127.0.0.1",11211);
$name=$mem->get('data');
if(empty($name)){
	$mysql=new PDO("mysql:host=127.0.0.1;dbname=weidogs","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
	$rs=$mysql->query("select * from bg_cate");
	$getarr=array();
	$i=0;
	while($row=$rs->fetch()){
		$getarr[$i]['title']=$row['cate_Name'];
		$getarr[$i]['content']=$row['cate_Intro'];
		$i=$i+1;
	}
	$json=json_encode($getarr);
	$mem->set('data',$json);
}else{
	$getarr=json_decode($name,true);
}

$redis=new redis();
$redis->connect('127.0.0.1',6379);
$data=$redis->get('data');
if(empty($data)){
	$mysql=new PDO("mysql:host=127.0.0.1;dbname=weidogs","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
	$rs=$mysql->query("select * from bg_cate");
	$getarr=array();
	$i=0;
	while($row=$rs->fetch()){
		$getarr[$i]['title']=$row['cate_Name'];
		$getarr[$i]['content']=$row['cate_Intro'];
		$i=$i+1;
	}
	$json=json_encode($getarr);
	$redis->set('data',$json);
}else{
	$getarr=json_decode($data,true);
}