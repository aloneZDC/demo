<?php

	include('./config.php');
	$action=$_GET['act'];
	switch($action){
		//登录
		case 'wxlogin':
			$appid="wx8cf22053afd7930b";//输入小程序appid  
            $secret="9d17e84c6b9585bd788b5cf0d115bbb9";//输入小程序app_secret  
            $js_code=$_GET['js_code'];
            $grant_type=$_GET['grant_type'];
            $nickName=$_GET['nickName'];
            if(empty($nickName)){
            	$nickName='小程序-'.time();
            	$username=$nickName;
            }else{
            	$username=filter($nickName);
				
				$k = 0;
				while(!empty($username)){
					$username= $k==0? $username:$username.$k;
					$checkusername = select_one("select * from xiaozu_member where username ='".$username."' ");
					$k = $k+1;
					if(empty($checkusername)){
						break;
					}
				}
            }
			$url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$secret."&js_code=".$js_code."&grant_type=".$grant_type;
			$json=file_get_contents($url);
			$data=json_decode($json,true);
			$wx=select_one("select * from xiaozu_wxuser where openid='".$data['openid']."'");
			$pwd=123456;
			if(empty($wx)){
				$arr['username'] = $username;
				$arr['phone'] = '';
				$arr['address'] = '';
				$arr['password'] = md5($pwd);
				$arr['wxopenid']=$data['openid'];
				$arr['email'] = '';
				$arr['creattime'] = time(); 
				$arr['score']  =0;
			    $arr['logintime'] = time(); 
				$arr['logo'] = '';
				$arr['loginip'] ='';
				$arr['group'] = 10;
			    $ehckinfo = select_one("select * from xiaozu_member  where username='".$data['openid']."'");
				if(empty($ehckinfo)){
					insert("xiaozu_member",$arr);
					$uid = insertid();
					$wxdata['uid'] = $uid;
					$wxdata['openid'] = $data['openid'];
					$wxdata['is_bang'] = 0; 
					insert('xiaozu_wxuser',$wxdata);  
				}else{
					$uid = $ehckinfo['uid'];
				}
				$res=select_one("select * from xiaozu_member where uid='".$uid."'");
				$json=json_encode($res);
			}else{
				$membername=select_one("select * from xiaozu_member where uid='".$wx['uid']."'");
				if($membername['username'] != $username){
					update("xiaozu_member",array('username'=>$username),"uid='".$membername['uid']."'");
				}
				$member=select_one("select * from xiaozu_member where uid='".$wx['uid']."'");
				$json=json_encode($member);			
			}
			print_r($json);exit;

		break;
		case 'perfect':
			$formData=json_decode($_GET['formData'],true);
			$img=$_GET['img'];
			$uid=$_GET['uid'];
			$res = select_one(" SELECT * FROM xiaozu_member WHERE uid = ".$uid);
			$check=select_one("select * from xiaozu_member where phone='".$formData['mobile']."'");
			if(!empty($check)){
				print_r("手机号码已存在");exit;
			}
			$data = array(
				'name'      => $formData['username'],
				'tel'       => $formData['mobile'],
				'phone'       => $formData['mobile'],
				'image'     => $img,
				'number'    => $formData['numbers'],
				'level'     => 1,
				'group'     => 50,
				'loca'=>$formData['cityname'],					
			);
			$upda = update('xiaozu_member',$data,"uid=".$uid);
			if(!$upda){
				echo "提交失败";exit;
			}else{
				echo "提交成功";exit;
			}
		break;
		case 'score':
			$uid=$_GET['uid'];
			$member=select_one("select * from xiaozu_member where uid='".$uid."'");
			if(!empty($member)){
				$data=array('score'=>$member['score']+10);
				update('xiaozu_member',$data,"uid='".$uid."'");
				$datas['userid']=$uid;
				$datas['type'] = 1;
				$datas['addtype'] = 1;
				$datas['result'] = 10;
				$datas['acount'] = $member['score']+10;
				$datas['addtime'] = time();
				$datas['title']='每天签到';
				$datas['content'] = '用户登陆赠送积分10 总积分'.$datas['acount'];	
				insert("xiaozu_memberlog",$datas);
				$json=select_one("select * from xiaozu_member where uid='".$uid."'");
				$memjson=json_encode($json);
				print_r($memjson);exit;
			}
		break;
		case 'scoreNum':
			$uid=$_GET['uid'];
			$member=select_one("select * from xiaozu_member where uid='".$uid."'");	
			if(!empty($member)){				
				$num=counts("select * from xiaozu_memberlog where userid='".$uid."'");
				$memberlog=select_one("select * from xiaozu_memberlog where userid='".$uid."' order by id desc");
				$memtime=date("Y-m-d",$memberlog['addtime']);
				$memtime=strtotime($memtime);
				$time=date("Y-m-d",time());
				$time=strtotime($time);
				$data=array();
				$data['num']=$num;
				if($time > $memtime){
					$data['time']=0;
				}else{
					$data['time']=1;
				}
				$json=json_encode($data);
				print_r($json);exit;
			}
		break;
		case 'jifen':
			$uid=$_GET['uid'];
			$member=select_one("select * from xiaozu_member where uid='".$uid."'");	
			if(!empty($member)){
				$json=json_encode($member);
				print_r($json);exit;
			}else{
				echo "操作错误";exit;
			}
		break;

		default:
			echo "操作错误";exit;
		break;
	}