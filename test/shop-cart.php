<?php

	include('./config.php');
	$action=$_GET['act'];
	switch($action){
		case 'goods':
			$id=$_GET['id'];
			$goods=select_one("select * from xiaozu_goods where id='".$id."'");
			$json=json_encode($goods);
			print_r($json);exit;
		break;
		case 'wineact':
			$goods=json_decode($_POST['goods'],true);
			$uid = $_POST['uid'];
		 	$res = select_one(" SELECT * FROM xiaozu_member WHERE uid = ".$uid);
		 	if($res['loca']==3){
		 		$spid='63';
		 	}else{
		 		$spid='58';
		 	}
		 	$spec = select_one(" select * from xiaozu_specialpage  where id=".$spid."");
		 	if(!empty($spec)){
		 		$gid='';
			 	foreach($goods as $k=>$v){
			 		$gid.=$v['goodsId'].',';
			 	}
			 	$gid=substr($gid,0,-1);	 	
				$actid=explode(',',$spec['listids']);
				$goid=explode(',',$gid);
				$ngids='';
				foreach ($goid as $v) {
					foreach ($actid as $k) {
						if($k==$v){
							$ngids.=$v.',';	
						}
					}
				}
				$allcost=0;
				if(!empty($ngids)){
					$ngid=explode(',',substr($ngids,0,-1));
					foreach($goods as $k=>$v){
						foreach($ngid as $g){
							if($v['goodsId']==$g){
								$allcost+=$v['number']*$v['price'];
							}
						}
					}
					$act =  select_one("select * from xiaozu_act  where  is_open = 1 and monerye >= '".$allcost."' and monerys <= '".$allcost."'");
					$json=json_encode($act);
					print_r($json);exit;
				}
		 	}
			
		break;

		default:
			echo "操作错误";exit;
		break;
	}