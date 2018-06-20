<?php

header("content-type:text/html;charset=utf-8");
$cig=@mysql_connect("127.0.0.1","root","root") or die("数据库连接失败");
mysql_query("set names utf8");
mysql_select_db('weidogs',$cig) or die("数据库表连接失败");

function query($sql){
	$res=mysql_query($sql);
	return $res;
}

function select_one($sql){
	$res=query($sql);
	$row=mysql_fetch_assoc($res);
	return $row;
}

function getarr($sql){
	$res=query($sql);
	$getarr=array();
	while($row=mysql_fetch_assoc($res)){
		$getarr[]=$row;
	}
	return $getarr;
}

function insert($table,$data){
	$feile='';
	$values='';
	foreach($data as $k=>$v){
		$feile.="`".$k."`,";
		$values.="'".$v."',";
	}
	$sql="INSERT INTO ".$table." (".substr($feile,0,-1).") VALUES (".substr($values,0,-1).")";
	$res=query($sql);
	return $res;
}

function update($table,$data,$where){
	$values='';
	foreach($data as $k=>$v){
		$values.="`".$k."`='".$v."',";
	}
	$wheres='';
	foreach($where as $k=>$v){
		$wheres="`".$k."`='".$v."'";
	}
	$sql="UPDATE ".$table." SET ".substr($values,0,-1)." where ".$wheres."";
	$res=query($sql);
	return $res;
}

function del($table,$where){
	$wheres='';
	foreach($where as $k=>$v){
		$wheres="`".$k."`='".$v."'";
	}
	$sql="DELETE FROM ".$table." where ".$wheres."";
	$res=query($sql);
	return $res;
}

function counts($sql){
	$res=query($sql);
	$num=mysql_num_rows($res);
	return $num;
}