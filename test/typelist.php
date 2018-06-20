<?php
	include('./config.php');
	$action=$_GET['act'];
	switch($action){
		case 'goodslist':
			$id=intval($_GET['id']);
			$list=getarr("select * from xiaozu_goods where typeid='".$id."' and is_live=1  order by good_order asc");
			$json=json_encode($list);
			print_r($json);exit;
		break;
		case 'typename':
			$id=intval($_GET['id']);
			$list=select_one("select * from xiaozu_goodstype where id='".$id."' ");
			$json=json_encode($list);
			print_r($json);exit;
		break;

		default:
			echo "操作错误";exit;
		break;
	}