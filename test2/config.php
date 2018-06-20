<?php

header("content-type:text/html;charset=utf-8");
$cig=mysql_connect("127.0.0.1","root","root") or die("数据库连接失败");
mysql_query("set names utf8");
mysql_select_db("weidogs",$cig) or die("连接表失败");

function select_one($sql){
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
	return $row;
}

function getarr($sql){
	$getarr=array();
	$res=mysql_query($sql);
	while($row=mysql_fetch_assoc($res)){
		$getarr[]=$row;
	}
	return $getarr;
}

function insert($table,$data){
	$felid='';
	$values='';
	foreach($data as $k=>$v){
		$felid.="`".$k."`,";
		$values.="'".$v."',";
	}
	$sql="INSERT INTO ".$table." (".substr($felid,0,-1).") VALUES (".substr($values,0,-1).")";
	$res=mysql_query($sql);
	return $res;
}

function update($table,$data,$where){
	$values='';
	foreach($data as $k=>$v){
		$values.="`".$k."`='".$v."',";
	}
	$sql="UPDATE ".$table." SET ".substr($values,0,-1)." where ".$where;
	$res=mysql_query($sql);
	return $res;
}

function del($table,$where){
	$sql="DELETE FROM ".$table." where ".$where."";
	$res=mysql_query($sql);
	return $res;
}