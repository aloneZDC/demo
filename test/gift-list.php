<?php

	include('./config.php');
	$action=$_GET['act'];
	switch($action){
		case 'img':
			$res=select_one("select * from xiaozu_adv where advtype='wxgift' limit 1");
			$json=json_encode($res);
			print_r($json);exit;
		break;
		case 'giftlist':
			$res=getarr("select * from xiaozu_gift order by id asc");
			$json=json_encode($res);
			print_r($json);exit;
		break;
		case 'gift':
			$uid=$_GET['uid'];
			$member=getarr("select * from xiaozu_memberlog where userid='".$uid."' order by id desc");
			foreach($member as $k=>$v){
				$member[$k]['addtime']=date("Y-m-d H:i",$v['addtime']);
			}
			$json=json_encode($member);
			print_r($json);exit;
		break;
		case 'duihuan':
			$uid=$_GET['uid'];
			$gid=$_GET['gid'];
			$score=$_GET['gscore'];
			$member=select_one("select * from xiaozu_member where uid='".$uid."'");
			if($member['score'] < $score){
				echo '404';exit;
			}
			$ndata['score'] = $member['score'] - $score;
			update('xiaozu_member',$ndata,"uid='".$uid."'");
			$addressinfo = 	select_one("select * from xiaozu_address where  userid = '".$uid."' and `default`=1 ");
	   		$gift = select_one("select * from xiaozu_gift where id='".$gid."'");
	   		if(!empty($addressinfo)){
	   			//兑换记录
		   		$data['address'] = $addressinfo['address'];
			    $data['contactman'] =$addressinfo['contactname'];
			   	$data['telphone'] = $addressinfo['phone'];
			   	$data['giftid'] = $gift['id'];
			   	$data['uid'] = $uid;
			   	$data['addtime'] = time();
			   	$data['status'] = 0;
			   	$data['count'] = 1;
			   	$data['score'] = $gift['score'];
		       	insert('xiaozu_giftlog',$data);
		       	//积分记录
		       	$sdata['userid'] =  $uid;
				$sdata['type'] = 1;
				$sdata['addtype'] = 2;
				$sdata['result'] = $score;
				$sdata['addtime'] = time();
				$sdata['title'] = '兑换礼品';
				$sdata['content'] = '兑换'.$gift['title'].'减少'.$gift['score'].'积分';  
				$sdata['acount'] = $ndata['score'];
				insert('xiaozu_memberlog',$sdata);

		       	//更新礼品表	       	
		       	$lidata['stock'] =  $gift['stock']-1;
		       	$lidata['sell_count'] =  $gift['sell_count']+1;
			   	update('xiaozu_gift',$lidata,"id='".$gift['id']."'");
			   	print_r("兑换成功");exit;	
		   	}else{
		   		print_r("兑换失败，请设置收货地址");exit;
		   	}
		break;
		case 'giftlog':
			$uid=$_GET['uid'];
			$giftlog=getarr("select * from xiaozu_giftlog  where uid='".$uid."'");
			$logstat = array('0'=>'待处理','1'=>'已处理，配送中','2'=>'已发货','3'=>'兑换成功','4'=>'已取消兑换'); 
			if(!empty($giftlog)){
				foreach($giftlog as $k=>$v){
					$gift=select_one("select * from xiaozu_gift where id='".$v['giftid']."'");
					$giftlog[$k]['addtime']=date('m-d H:i',$v['addtime']);
					$giftlog[$k]['gname']=$gift['title'];
					$giftlog[$k]['status']=$logstat[$v['status']];
				}
				$json=json_encode($giftlog);
				print_r($json);exit;	
			}
			
		break;

		default:
			echo "操作错误";exit;
		break;
	}
