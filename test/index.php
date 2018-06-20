<?php
include('./config.php');
$action=$_GET['act'];
switch($action){
	case 'adv':
		$res=getarr("select * from xiaozu_adv where advtype='weixinlb' order by id asc ");
		$json=json_encode($res);
		print_r($json);exit;
	break;
	case 'notice':
		$uid=$_GET['uid'];
		$member=select_one("select * from xiaozu_member where uid='".$uid."'");
		if($member['loca']!=0){
			$res=getarr("select * from xiaozu_information where type=1 and loca='".$member['loca']."' order by orderid asc limit 1");
		}else{	
			$res=getarr("select * from xiaozu_information where type=1 and loca=1 order by orderid asc limit 1");
		}	
		$json=json_encode($res);
		print_r($json);exit;
	break;
	case 'typebtn':
		$uid=$_GET['uid'];
		$member=select_one("select * from xiaozu_member where uid='".$uid."'");
		if($member['loca']!=0){
			$moretypelist = getarr("select* from xiaozu_appadv where type=2 and loca='".$member['loca']."' order by orderid  asc  limit 3 ");
		}else{
			$moretypelist = getarr("select* from xiaozu_appadv where type=2 and loca=1 order by orderid  asc  limit 3 ");
		}
		$json=json_encode($moretypelist);
		print_r($json);exit;
	break;
	case 'typeimg':
		$uid=$_GET['uid'];
		$member=select_one("select * from xiaozu_member where uid='".$uid."'");
		if($member['loca']!=0){
			$ztylist = getarr("select* from xiaozu_specialpage where is_show=1 and loca='".$member['loca']."' and imgwidth='50%'  order by orderid  asc limit 4 ");
		}else{
			$ztylist = getarr("select* from xiaozu_specialpage where is_show=1 and loca=1 and imgwidth='50%'  order by orderid  asc limit 4 ");
		}			
		$json=json_encode($ztylist);
		print_r($json);exit;
	break;
	case 'imglong':
		$uid=$_GET['uid'];
		$member=select_one("select * from xiaozu_member where uid='".$uid."'");
		if($member['loca']!=0){
			$ztylist = getarr("select* from xiaozu_specialpage where is_show=1 and loca='".$member['loca']."' and imgwidth='100%'  order by orderid  asc limit 10");
		}else{
			$ztylist = getarr("select* from xiaozu_specialpage where is_show=1 and loca=1 and imgwidth='100%'  order by orderid  asc limit 10");
		}
		
		$json=json_encode($ztylist);
		print_r($json);exit;
	break;
	case 'shoplist':
		$uid=$_GET['uid'];
		$member=select_one("select * from xiaozu_member where uid='".$uid."'");
		if($member['loca']!=0){
			$shops = getarr("SELECT id FROM xiaozu_shop WHERE loca ='".$member['loca']."' and is_open=1");	
		}else{
			$shops = getarr("SELECT id FROM xiaozu_shop WHERE loca =1 and is_open=1");
		}
		
		$shoplists='';
		foreach ($shops as $key => $value) {
			$shoplists.=$value['id'].",";
		}
		if(empty($shoplists)){
			$list = getarr("SELECT * FROM xiaozu_goods WHERE is_com = 1 and is_live=1  ORDER BY cx_order ASC  LIMIT 30 ");
		}else{
			$list = getarr("SELECT * FROM xiaozu_goods WHERE is_com = 1 and shopid in (".substr($shoplists,0,-1).") and is_live=1  ORDER BY cx_order ASC  LIMIT 30 ");
		}
		$json=json_encode($list);
		print_r($json);exit;
	break;
	case 'member':
		$uid=$_GET['uid'];
		$member=select_one("select * from xiaozu_member where uid='".$uid."'");
		$json=json_encode($member);
		print_r($json);exit;
	break; 
	case 'spagoods':
		$uid = $_GET['uid'];
	 	$res = select_one(" SELECT * FROM xiaozu_member WHERE uid = ".$uid);
	 	if(empty($res) || $res['loca']==0){
	 		$ztylist = getarr("select* from xiaozu_specialpage where is_show=1 and loca=1  order by orderid  asc");
	 	}else{
	 		$ztylist = getarr("select* from xiaozu_specialpage where is_show=1 and loca=".$res['loca']."  order by orderid  asc");
	 	}
	 	if(!empty($ztylist)){
	 		foreach ($ztylist as $key => $value) {
		    	if($value['id']==59){
		    		$gids=$value['listids'];
		    		$gids=explode(',',$gids);
		    		$goods=array();
		    		foreach($gids as $k=>$v){
		    			$goods[]=select_one("select * from xiaozu_goods where id='".$v."'");
		    		}			  
		    	}else if($value['id']==64){
		    		$gids=$value['listids'];
		    		$gids=explode(',',$gids);
		    		$goods=array();
		    		foreach($gids as $k=>$v){
		    			$goods[]=select_one("select * from xiaozu_goods where id='".$v."'");
		    		}
		    	}
		    }
		    exit(json_encode($goods));
	 	}
	break;

	default:
		echo "操作错误";exit;
	break;
}