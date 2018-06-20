<?php
	include('./config.php');
	$action=$_GET['act'];
	switch($action){
		case "winetype":
			$res  = getarr("select * from xiaozu_newstype order by orderid asc");
			$winetype=getTree($res,0);
			$json=json_encode($winetype);
			print_r($json);exit;
		break;
		case 'winelist':
			$id=$_GET['id'];
			$res  = getarr("select * from xiaozu_newstype where id='".$id."' order by orderid asc");
			$winelist=array();
			foreach( $res as  $k=>$v){
				$newstype = getarr("select id,title,typeid from xiaozu_news WHERE typeid = '".$v['id']."'  order by orderid asc");
				$v['newstype'] = $newstype;
				$winelist[$k]   = $v;
			}
			$json=json_encode($winelist);
			print_r($json);exit;
		break;
		case 'winedetail':
			$id=$_GET['id'];
			$res=select_one("select * from xiaozu_news where  id='".$id."'");
			$json=json_encode($res);
			print_r($json);exit;
		break;
		case 'test':
			$id=$_GET['id'];
			$res=select_one("select * from xiaozu_news where  id='".$id."'");
			echo $res['content'];exit;
		break;

		default:
			echo "操作错误";exit;
		break;
	}