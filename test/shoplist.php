<?php
	include('./config.php');
	$action=$_GET['act'];
	switch($action){
		case 'shoptype':
			$uid=$_GET['uid'];
			$member=select_one("select * from xiaozu_member where uid='".$uid."'");
			if($member['loca']!=0){
				$templist=getarr("select id,shopname,shopicon from xiaozu_shop where loca='".$member['loca']."' and is_open=1 order by sort asc ");
			}else{
				$templist=getarr("select id,shopname,shopicon from xiaozu_shop where loca=1 and is_open=1 order by sort asc ");
			}
			
			foreach( $templist as  $k=>$v){
				$goodstype = getarr("select * from xiaozu_goodstype WHERE shopid = '".$v['id']."'  order by orderid asc");
				foreach($goodstype as $k1=>$v1){
					$goods=getarr("select * from xiaozu_goods where typeid='".$v1['id']."' and is_live=1");
					if(empty($goods)){
						unset($goodstype[$k1]);	  
					}
				}	
				$v['goodstype'] = $goodstype;
				$templist[$k]   = $v;	  
			}
			$json=json_encode($templist);
			print_r($json);exit;
		break;

		default:
			echo "操作错误";exit;
		break;
	}