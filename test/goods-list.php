<?php
	include('./config.php');
	$action=$_GET['act'];
	switch($action){
		case 'goodslist':
			$id=intval($_GET['id']);
			if($id==99){
				$list=getarr("select * from xiaozu_goods where is_old=1 and is_live=1  order by good_order asc");
			}else{
				$ztyinfo = select_one(" select * from xiaozu_specialpage where id = ".$id."  ");
				$list=getarr("select * from xiaozu_goods where id in(".$ztyinfo['listids'].") and is_live=1 order by good_order asc");
			}
			$json=json_encode($list);
			print_r($json);exit;
		break;
		case 'goodslogo':
			$id=intval($_GET['id']);
			if($id==99){
				$ztyinfo=array();
				$ztyinfo['specialimg']="/upload/goods/20170228164909560.jpg";
			}else{
				$ztyinfo = select_one(" select * from xiaozu_specialpage where id = ".$id."  ");
			}
			$json=json_encode($ztyinfo);
			print_r($json);exit;
		break;

		default:
			echo "操作错误";exit;
		break;
	}