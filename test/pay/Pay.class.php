<?php
	include("../config.php");	
	
	//微信支付参数配置(appid,商户号,支付秘钥)
	$config = array(
		'appid'		 => 'wx8cf22053afd7930b',
		'pay_mchid'	 => '1367847302',
		'pay_apikey' => 'asdasd3e2332eewddsr3434342423232',
	);

	$action=$_GET['act'];
	if($action=='prepay'){
		prepay();
	}else if($action=='pay'){
		pay();
	}else if($action=='notify'){
		notify();
	}else if($action=='orderok'){
		$orderid=$_POST['orderid'];
		$orderdata=array(
			'status'=>2,
			'paystatus'=>1,
			'paytype_name'=>'weixin'
		);
		//更新数据库
		update('xiaozu_order',$orderdata,"id='".$orderid."'");
		writewuliustatus($orderid,3,1);
	}
	/**
     * 预支付请求接口(POST)
     * @param string $openid 	openid
     * @param string $body 		商品简单描述
     * @param string $order_sn  订单编号
     * @param string $total_fee 金额
     * @return  json的数据
     */
	function prepay(){
		$config = $GLOBALS['config'];		
		$openid = $_POST['openid'];
		$body = $_POST['remark'];
		$order_sn = $_POST['order_sn'];
		$total_fee = $_POST['total_fee'];
		$orderid=$_POST['id'];

		//统一下单参数构造
		$unifiedorder = array(
			'appid'			=> $config['appid'],
			'body'			=> $body,
			'mch_id'		=> $config['pay_mchid'],
			'nonce_str'		=> getNonceStr(),
			'notify_url'	=> "https://zb.debangjs.com/pay/Pay.class.php?act=notify",
			'openid'		=> $openid,
			'attach'        => $order_sn,
			'out_trade_no'	=> $orderid,
			'spbill_create_ip'	=> $_SERVER['REMOTE_ADDR'],
			'total_fee'		=> $total_fee * 100,
			'trade_type'	=> 'JSAPI',			
		);
		$unifiedorder['sign'] = makeSign($unifiedorder);
		//请求数据
		$xmldata = array2xml($unifiedorder);
		$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $res = curl_post_ssl($url, $xmldata);
        if(!$res){
			return_err("Can't connect the server");
        }
		// 这句file_put_contents是用来查看服务器返回的结果 测试完可以删除了
		//file_put_contents(APP_ROOT.'/Statics/log1.txt',$res,FILE_APPEND);
		
		$content = xml2array($res);

		if(strval($content['result_code']) == 'FAIL'){
			return_err(strval($content['err_code_des']));
        }
		if(strval($content['return_code']) == 'FAIL'){
			return_err(strval($content['return_msg']));
        }
        return_data(array('data'=>$content));
		//$this->ajaxReturn($content);
	}
	
	
	/**
     * 进行支付接口(POST)
     * @param string $prepay_id 预支付ID(调用prepay()方法之后的返回数据中获取)
     * @return  json的数据
     */
	function pay(){
		$config =  $GLOBALS['config'];
		$prepay_id = $_POST['prepay_id'];
		
		$data = array(
			'appId'		=> $config['appid'],
			'timeStamp'	=> time(),
			'nonceStr'	=> getNonceStr(),
			'package'	=> 'prepay_id='.$prepay_id,
			'signType'	=> 'MD5'
		);
		
		$data['paySign'] = makeSign($data);
		exit(json_encode($data));
	}
	
	//微信支付回调验证
	function notify(){
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		
		// 这句file_put_contents是用来查看服务器返回的XML数据 测试完可以删除了
		//file_put_contents(APP_ROOT.'/Statics/log2.txt',$res,FILE_APPEND);
		
		//将服务器返回的XML数据转化为数组
		$data = xml2array($xml);
		// 保存微信服务器返回的签名sign
		$data_sign = $data['sign'];
		// sign不参与签名算法
		unset($data['sign']);
		$sign = makeSign($data);
		// 判断签名是否正确  判断支付状态
		if ( ($sign===$data_sign) && ($data['return_code']=='SUCCESS') && ($data['result_code']=='SUCCESS') ) {
			$result = $data;
			//获取服务器返回的数据
			$order_sn = $data['out_trade_no'];			//订单单号
			$openid = $data['openid'];					//付款人openID
			$total_fee = $data['total_fee'];			//付款金额
			$transaction_id = $data['transaction_id']; 	//微信支付流水号

			$orderdata=array(
				'status'=>2,
				'paystatus'=>1,
				'trade_no'=>$transaction_id,
				'paytype_name'=>'weixin'
			);
			//更新数据库
			update('xiaozu_order',$orderdata,"id='".$order_sn."'");
		}else{
			$result = false;
		}
		// 返回状态给微信服务器
		if ($result) {
			$str='<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
		}else{
			$str='<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[签名失败]]></return_msg></xml>';
		}
		echo $str;
		return $result;
	}
	
//---------------------------------------------------------------用到的函数------------------------------------------------------------
	/**
     * 错误返回提示
     * @param string $errMsg 错误信息
     * @param string $status 错误码
     * @return  json的数据
     */
	function return_err($errMsg='error',$status=0){
		exit(json_encode(array('status'=>$status,'result'=>'fail','errmsg'=>$errMsg)));
	}
	
	
	/**
     * 正确返回
     * @param 	array $data 要返回的数组
     * @return  json的数据
     */
	function return_data($data=array()){
		exit(json_encode(array('status'=>1,'result'=>'success','data'=>$data)));
	}
  
	/**
     * 将一个数组转换为 XML 结构的字符串
     * @param array $arr 要转换的数组
     * @param int $level 节点层级, 1 为 Root.
     * @return string XML 结构的字符串
     */
    function array2xml($arr, $level = 1) {
        $s = $level == 1 ? "<xml>" : '';
        foreach($arr as $tagname => $value) {
            if (is_numeric($tagname)) {
                $tagname = $value['TagName'];
                unset($value['TagName']);
            }
            if(!is_array($value)) {
                $s .= "<{$tagname}>".(!is_numeric($value) ? '<![CDATA[' : '').$value.(!is_numeric($value) ? ']]>' : '')."</{$tagname}>";
            } else {
                $s .= "<{$tagname}>" . array2xml($value, $level + 1)."</{$tagname}>";
            }
        }
        $s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
        return $level == 1 ? $s."</xml>" : $s;
    }
	
	/**
	 * 将xml转为array
	 * @param  string 	$xml xml字符串
	 * @return array    转换得到的数组
	 */
	function xml2array($xml){   
		//禁止引用外部xml实体
		libxml_disable_entity_loader(true);
		$result= json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
		return $result;
	}
	
	/**
	 * 
	 * 产生随机字符串，不长于32位
	 * @param int $length
	 * @return 产生的随机字符串
	 */
	function getNonceStr($length = 32) {
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {  
			$str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
		} 
		return $str;
	}
	
	/**
	* 生成签名
	* @return 签名
	*/
	function makeSign($data){
		$config =  $GLOBALS['config'];
		//获取微信支付秘钥
		$key = $config['pay_apikey'];
		// 去空
		$data=array_filter($data);
		//签名步骤一：按字典序排序参数
		ksort($data);
		$string_a=http_build_query($data);
		$string_a=urldecode($string_a);
		//签名步骤二：在string后加入KEY
		//$config=$this->config;
		$string_sign_temp=$string_a."&key=".$key;
		//签名步骤三：MD5加密
		$sign = md5($string_sign_temp);
		// 签名步骤四：所有字符转为大写
		$result=strtoupper($sign);
		return $result;
	}
	
	/**
	 * 微信支付发起请求
	 */
	function curl_post_ssl($url, $xmldata, $second=30,$aHeader=array()){
		$ch = curl_init();
		//超时时间
		curl_setopt($ch,CURLOPT_TIMEOUT,$second);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		//这里设置代理，如果有的话
		//curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
		//curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
 
		if( count($aHeader) >= 1 ){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
		}
	 
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$xmldata);
		$data = curl_exec($ch);
		if($data){
			curl_close($ch);
			return $data;
		}
		else { 
			$error = curl_errno($ch);
			echo "call faild, errorCode:$error\n"; 
			curl_close($ch);
			return false;
		}
	}



