<?php

header("content-type:text/html;charset=utf-8");

require(".config.php");
$redis=new Redis();
$redis->connect("127.0.0.1",6379);
$data=$redis->get('data2');
if(empty($data)){
	$mysql=new PDO("mysql:host=127.0.0.1;dbname=weidogs","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
	$rs=$mysql->query("select * from bg_cate");
	$getarr=array();
	$i=0;
	while($row=$rs->fetch()){
		$getarr[$i]['title']=$row['cate_Name'];
		$getarr[$i]['content']=$row['cate_Intro'];
		$getarr[$i]['pid']=$row['cate_ParentId'];
		$getarr[$i]['id']=$row['cate_Id'];
		$i=$i+1;
	}
	print_r($getarr);
	$json=json_encode($getarr);
	$redis->set('data2',$json);
}else{
	$getarr=json_decode($data,true);
	print_r($getarr);
}


$memcache=new Memcache();
$memcache->connect('127.0.0.1',11211);
$data=$memcache->get('admindata');
if(empty($data)){
	echo "mysql";
	$mysql=new PDO("mysql:host=127.0.0.1;dbname=weidogs","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
	$rs=$mysql->query("select * from bg_cate");
	$getarr=array();
	$i=0;
	while($row=$rs->fetch()){
		$getarr[$i]['title']=$row['cate_Name'];
		$getarr[$i]['content']=$row['cate_Intro'];
		$getarr[$i]['pid']=$row['cate_ParentId'];
		$getarr[$i]['id']=$row['cate_Id'];
		$i=$i+1;
	}
	print_r($getarr);
	$json=json_encode($getarr);
	$memcache->set("admindata",$json);	
}else{
	echo "memcache";
	$getarr=json_decode($data);
	print_r($getarr);
}
$filename="./demo.txt";
$text="123456";
$fp=fopen($filename,'w');
fwrite($fp,$text);
fclose($fp);

file_put_contents($filename,$text,FILE_APPEND);

function gettree($pid,$data){
	$tree=array();
	foreach($data as $k=>$v){
		if($v['cate_ParentId']==$pid){
			$v['child']=gettree($v['cate_Id'],$data);		
			$tree[]=$v;
		}
	}
	return $tree;
}

header("content-type:text/html;charset=utf-8");
$cig=mysql_connect("127.0.0.1","root","root");
mysql_query("set names utf8");
mysql_select_db("weidogs",$cig);

header("content-type:text/html;charset=utf-8");
$cig=mysql_connect("127.0.0.1","root","root") or die("no connect");
mysql_query("set names utf8");
mysql_select_db("weidogs",$cig);

$redis=new Redis();
$redis->connect("127.0.0.1",6379);
$data=$redis->get("demodata");
if(empty($data)){
	$mysql=new PDO("mysql:host=127.0.0.1;dbname=weidogs","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
	$rs=$mysql->query("select * from bg_cate");
	$getarr=array();
	$i=0;
	while($row=$rs->fetch()){
		$getarr[$i]['title']=$row['cate_Name'];
		$getarr[$i]['content']=$row['cate_Intro'];
		$getarr[$i]['pid']=$row['cate_ParentId'];
		$getarr[$i]['id']=$row['cate_Id'];
		$i=$i+1;
	}
	print_r($getarr);
	$json=json_encode($getarr);
	$redis->set("demodata",$json);
}else{
	$getarr=json_decode($data,true);
	print_r($getarr);
}

$filename="./demo.txt";
$text="1234567";
$fp=fopen($filename,"w");
fwrite($fp,$text);
fclose($fp);

file_put_contents($filename,$text,FILE_APPEND);

$memcache=new Memcache();
$memcache->connect("127.0.0.1",11211);
$data=$memcache->get("data2");
if(empty($data)){
	$mysql=new PDO("mysql:host=127.0.0.1;dbname=weidogs","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
	$rs=$mysql->query("select * from bg_cate");
	$getarr=array();
	$i=0;
	while($row=$rs->fetch()){
		$getarr[$i]['title']=$row['cate_Name'];
		$getarr[$i]['content']=$row['cate_Intro'];
		$getarr[$i]['pid']=$row['cate_ParentId'];
		$getarr[$i]['id']=$row['cate_Id'];
		$i=$i+1;
	}
	print_r($getarr);
	$json=json_encode($getarr);
	$memcache->set("data2",$json);
}else{
	$getarr=json_decode($data,true);
	print_r($getarr);
}

$redis=new Redis();
$redis->connect("127.0.0.1",6379);
$data=$redis->get("data");
if(empty($data)){
	$mysql=new PDO("mysql:host=127.0.0.1;dbname=weidogs","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
	$rs=$mysql->query("select * from bg_cate");
	$getarr=array();
	$i=0;
	while($row=$rs->fetch()){
		$getarr[$i]['title']=$row['cate_Name'];
		$getarr[$i]['content']=$row['cate_Intro'];
		$getarr[$i]['pid']=$row['cate_ParentId'];
		$getarr[$i]['id']=$row['cate_Id'];
		$i=$i+1;
	}
	$json=json_encode($getarr);
	$redis->set("data",$json);
}else{
	$getarr=json_decode($data,true);
}

$mem=new Memcache();
$mem->connect("127.0.0.1",11211);
$data=$mem->get("data");
if(empty($data)){
	$mysql=new PDO("mysql:host=127.0.0.1;dbname=weidogs","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
	$rs=$mysql->query("select * from bg_cate");
	$getarr=array();
	$i=0;
	while($row=$rs->fetch()){
		$getarr[$i]['title']=$row['cate_Name'];
		$getarr[$i]['content']=$row['cate_Intro'];
		$getarr[$i]['pid']=$row['cate_Parent_Id'];
		$getarr[$i]['id']=$row['cate_Id'];
		$i=$i+1;
	}
	$json=json_encode($getarr);
	$mem->set('data',$json);
}else{
	$getarr=json_decode($data,true);
}

header("content-type:text/html;charset=utf-8");
$cig=mysql_connect("127.0.0.1","root","root") die("no connect");
mysql_query("set names utf8");
mysql_select_db("weidogs",$cig);
$res=mysql_query("select * from bg_cate");
$getarr=array();
$i=0;
while($row=mysql_fetch_assoc($res)){
	$getarr[$i]['title']=$row['cate_Name'];
	$getarr[$i]['content']=$row['cate_Intro'];
	$getarr[$i]['pid']=$row['cate_ParentId'];
	$getarr[$i]['id']=$row['cate_Id'];
	$i=$i+1;
}

function select_one($sql){
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
	return $row;
}

function getarr($sql){
	$res=mysql_query($sql);
	$getarr=array();
	while($row=mysql_fetch_assoc($res)){
		$getarr[]=$row;
	}
	return $getarr;
}

function insert($table,$data){
	$feil='';
	$values='';
	foreach($data as $k=>$v){
		$feil.="`".$k."`,";
		$values.="'".$v."',";
	}
	$sql="INSERT INTO ".$table." (".substr($feil,0,-1).") VALUES (".substr($values,0,-1).")";
	$res=mysql_query($sql);
	return $res;
}

function update($table,$data,$where){
	$values="";
	foreach($data as $k=>$v){
		$values.="`".$k."`='".$v."',";
	}
	$sql="UPDATE ".$table." SET ".substr($values,0,-1)." where ".$where." ";
	$res=mysql_query($sql);
	return $res;
}

function del($table,$where){
	$sql="DELETE FROM ".$table." where ".$where." ";
	$res=mysql_query($sql);
	return $res;
}

function counts($sql){
	$res=mysql_query($sql);
	$count=mysql_num_rows($res);
	return $count;
}

function gettree($pid,$data){
	$tree=array();
	foreach($data as $k=>$v){
		if($v['pid']==$pid){
			$v['chlid']=gettree($v['id'],$data);
			$tree[]=$v;
		}
	}
	return $tree;
}

function wtext($dbname,$text){
	$fp=fopen($dbname,'w');
	fwrite($fp,$text);
	return fclose($fp);
}

function puttext($dbname,$text){
	$res=file_put_contents($dbname,$text,FILE_APPEND);
	return $res;
}

$redis=new Redis();
$redis->connect("127.0.0.1",6379);
$data=$redis->get("data");
if(empty($data)){
	$mysql=new PDO("mysql:host=127.0.0.1;dbname=weidogs","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
	$rs=$mysql->query("select * from bg_cate");
	$getarr=array();
	$i=0;
	while($row=$rs->fetch()){
		$getarr[$i]['title']=$row['cate_Name'];
		$getarr[$i]['content']=$row['cate_Intro'];
		$getarr[$i]['pid']=$row['cate_ParentId'];
		$getarr[$i]['id']=$row['cate_Id'];
		$i=$i+1;
	}
	$json=json_encode($getarr);
	$redis->set('data',$json);
}else{
	$getarr=json_decode($data,true);
}

$mem=new Memcache();
$mem->connect("127.0.0.1",11211);
$data=$mem->get("data");
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
	$mem->set("data",$json);
}else{
	$getarr=json_decode($data);
}

