<?php
	include('./config.php');
	$action=$_GET['act'];
	switch($action){
		case 'search':
			$name=$_GET['id'];
			$res=getarr("select * from xiaozu_goods where name like '%".$name."%' and is_live=1 ");
			$json=json_encode($res);
			print_r($json);exit;
		break;
		case 'searchshop':
			$name=$_GET['id'];
			$res=getarr("select * from xiaozu_specialpage where name like '%".$name."%' and is_show=1 and loca=1 order by orderid asc");
			$json=json_encode($res);
			print_r($json);exit;
		break;

		default:
			echo "操作错误";exit;
		break;
	}