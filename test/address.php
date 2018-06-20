<?php

	include('./config.php');
	$action=$_GET['act'];
	switch($action){
		case 'address':
			$uid=$_GET['uid'];
			$address=getarr("select * from xiaozu_address where userid='".$uid."' ");
			$json=json_encode($address);
			print_r($json);exit;
		break;
		case 'checkAddress':
			$uid=$_GET['uid'];
			$address=select_one("select * from xiaozu_address where userid='".$uid."' and `default`=1");
			$str=preg_split('//u', $address['bigadr']);
			$newstr='';
			foreach( $str as $k=>$v){
			    if($v=='省' || $v=='市'){
			    	$str[$k]=$v.",";
			    }
			    if(empty($v)){
			    	unset( $str[$k] );
			    }            
			}
			foreach ($str as $key => $value) {
				$newstr.=$value;
			}
			$newarr=explode(',', $newstr);
			$address['newadrp']=$newarr[0];
			$address['newadrc']=$newarr[1];
			$address['newadra']=$newarr[2];
			$json=json_encode($address);
			print_r($json);exit;
		break;
		case 'address-one':
			$uid=$_GET['uid'];
			$id=$_GET['id'];
			$address=select_one("select * from xiaozu_address where userid='".$uid."' and id='".$id."'");
			$str=preg_split('//u', $address['bigadr']);
			$newstr='';
			foreach( $str as $k=>$v){
			    if($v=='省' || $v=='市'){
			    	$str[$k]=$v.",";
			    }
			    if(empty($v)){
			    	unset( $str[$k] );
			    }            
			}
			foreach ($str as $key => $value) {
				$newstr.=$value;
			}
			$newarr=explode(',', $newstr);
			$address['newadrp']=$newarr[0];
			$address['newadrc']=$newarr[1];
			$address['newadra']=$newarr[2];
			$json=json_encode($address);
			print_r($json);exit;
		break;
		case 'address-add':
			$data=$_GET;			
			if(empty($data['id'])){
				$checknum = counts("select * from xiaozu_address where userid='".$data['uid']."' ");
				$member=select_one("select * from xiaozu_member where uid='".$data['uid']."'");
				$arr['userid'] = $data['uid'];
				$arr['username'] = $member['username']; 		
				$arr['address'] =  $data['provinceId'].$data['cityId'].$data['districtId'].$data['address'];
				$arr['phone'] = $data['mobile'];
				$arr['otherphone'] = '';
				$arr['contactname'] = $data['linkMan'];
				$arr['sex'] =  0;
				$arr['default'] = $checknum == 0?1:0;
				$arr['addtime'] = time();
				$arr['bigadr'] =  $data['provinceId'].$data['cityId'].$data['districtId'];
				$arr['detailadr'] =  $data['address'];
				insert('xiaozu_address',$arr);
				$addid = insertid();
				update('xiaozu_address',array('default'=>0),'userid = '.$member['uid'].' ');
		        update('xiaozu_address',array('default'=>1),'userid = '.$member['uid'].' and id='.$addid.'');
		    }else{
		    	$arr['address'] =  $data['provinceId'].$data['cityId'].$data['districtId'].$data['address'];
			 	$arr['phone'] = $data['mobile'];
			 	$arr['otherphone'] = '';
			 	$arr['contactname'] = $data['linkMan'];
			 	$arr['sex'] =  0;
			  	$arr['addtime'] = time();
			  	$arr['bigadr'] =  $data['provinceId'].$data['cityId'].$data['districtId'];
				$arr['detailadr'] =  $data['address'];
				update('xiaozu_address',$arr,'userid = '.$data['uid'].' and id='.$data['id'].'');
			 	update('xiaozu_address',array('default'=>0),'userid = '.$data['uid'].' ');
	         	update('xiaozu_address',array('default'=>1),'userid = '.$data['uid'].' and id='.$data['id'].'');
		    }
			print_r('提交成功');exit;
		break;
		case 'delete':
			$id=$_GET['id'];
			del("xiaozu_address",array('id'=>$id));			
			print_r("删除成功");exit;
		break;
		case 'update':
			$id=$_GET['id'];
			$uid=$_GET['uid'];
			$address=select_one("select * from xiaozu_address where id='".$id."' and userid='".$uid."'");
			if(!empty($address)){
				update('xiaozu_address',array('default'=>0),'userid = '.$uid.' ');
				update('xiaozu_address',array('default'=>1),'userid = '.$uid.' and id='.$id.'');
				print_r("修改成功");exit;
			}else{
				print_r("修改失败");exit;
			}

		break;
		case 'loca':
			$loca=getarr("select * from xiaozu_loca where is_show=1");
			$json=json_encode($loca);
			print_r($json);exit;	
		break;

		default:
			echo "操作错误";exit;
		break;
	}