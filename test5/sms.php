<?php

//聚合数据短信接口

$sms_url="http://v.juhe.cn/sms/send"; 	//短信接口的URL
$smscode=randomkeys(4);
$smsConf=array(
	'key'=>'b6d90a78de37f6aa03a370d8944e5c9d',  					//您申请的APPKEY
	'mobile'=>'15112632313',    					//接受短信的用户手机号码
	'tpl_id'=>'75227',					//您申请的短信模板ID，根据实际情况修改
	'tpl_value'=>'#code#='.$smscode,	//您设置的模板变量随机数，根据实际情况修改
	);
$content=juhecurl($sms_url,$smsConf,1); //请求发送短信
if($content){
	$result=json_decode($content,true);
	$error_code=$result['error_code'];
	if($error_code==0){
		$return=array('status'=>1,'msg'=>'短信发送成功');
	}else{
		//状态非0，说明失败
		$return['msg']=$result['reason'];
	}
}else{
	//返回内容异常，以下可根据业务逻辑自行修改
	$return['msg']='请求短信发送失败';
}

//函数相当于file_get_contents
function juhecurl($url,$params=false,$ispost=1){
	$httpinfo=array();
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22');
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,30);
	curl_setopt($ch,CURLOPT_TIMEOUT,30);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	if($ispost){
		curl_setopt($ch,CURLOPT_POST,true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
		curl_setopt($ch,CURLOPT_URL,$url);
	}else{
		if($params){
			curl_setopt($ch,CURLOPT_URL,$url.'?'.$params);
		}else{
			curl_setopt($ch,CURLOPT_URL,$url);
		}
	}
	$response=curl_exec($ch);
	if($response==false){
		return false;
	}
	$httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
	$httpinfo=array_merge($httpinfo,curl_getinfo($ch));
	curl_close($ch);
	return $response;
}

//生成验证码
function randomkeys($length){
    $pattern='1234567890'; //字符池
    $key='';
    for($i=0;$i<$length;$i++){
        $key.=$pattern{mt_rand(0,9)};//生成php随机数
    }
    return $key;
}