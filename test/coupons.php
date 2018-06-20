<?php

	include('./config.php');
	$action=$_GET['act'];
	switch($action){
		case 'list':
			$uid=$_GET['uid'];
			if(empty($uid)){
				exit;
			}
			$juan=getarr("select * from xiaozu_juan where uid='".$uid."' and endtime > ".time()." and status = 1 ");
			if(!empty($juan)){
				foreach($juan as $k=>$v){
					$juan[$k]['endtime']=date("Y-m-d H:i",$v['endtime']);
				}
				$json=json_encode($juan);
				print_r($json);exit;
			}else{
				exit();
			}
			
		break;
		case 'juan':
			$uid=$_GET['uid'];
			$cost=$_GET['cost'];
			$juan=getarr("select * from xiaozu_juan where uid='".$uid."' and endtime > ".time()." and status = 1 and limitcost <= '".$cost."' ");
			if(!empty($juan)){
				foreach($juan as $k=>$v){
					$juan[$k]['endtime']=date("Y-m-d H:i",$v['endtime']);
				}
				$json=json_encode($juan);
			}else{
				$json='';
			}
			
			print_r($json);exit;
		break;

		default:
			echo "操作错误";exit;
		break;
	}