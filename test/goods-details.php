<?php
	include('./config.php');
	$action=$_GET['act'];
	switch($action){
		case 'goodsdetails':
			$id = intval($_GET['id']);
			$templist=getarr("select * from xiaozu_goods where id='".$id."' ");
			$pointcount = counts("select * from xiaozu_comment where  goodsid  = ".$id." "); 
			foreach($templist as $k=>$v){
				$templist[$k]['pointcount']=$pointcount;
			}
			$json=json_encode($templist);
			print_r($json);exit;
		break;
		case 'point':
			$id = intval($_GET['id']);
			$templist=getarr("select * from xiaozu_comment where goodsid='".$id."' ");
			foreach($templist as $k=>$v){
				$member=select_one("select * from xiaozu_member where uid='".$v['uid']."'");
				$templist[$k]['username']=$member['username'];
				$templist[$k]['logo']=$member['logo'];
				$templist[$k]['time']=date('Y-m-d H:i',$v['addtime']);
			}

			$json=json_encode($templist);
			print_r($json);exit;
		break;

		default:
			echo "操作错误";exit;
		break;
	}