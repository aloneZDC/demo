<?php
    $xml = $GLOBALS['HTTP_RAW_POST_DATA'];      
    // 这句file_put_contents是用来查看服务器返回的XML数据 测试完可以删除了
    //file_put_contents(APP_ROOT.'/Statics/log2.txt',$res,FILE_APPEND);
    
    //将服务器返回的XML数据转化为数组
    $data = self::xml2array($xml);
    // 保存微信服务器返回的签名sign
    $data_sign = $data['sign'];
    // sign不参与签名算法
    unset($data['sign']);
    $sign = self::makeSign($data);
    
    // 判断签名是否正确  判断支付状态
    if ( ($sign===$data_sign) && ($data['return_code']=='SUCCESS') && ($data['result_code']=='SUCCESS') ) {
        $result = $data;
        //获取服务器返回的数据
        $order_sn = $data['out_trade_no'];          //订单单号
        $openid = $data['openid'];                  //付款人openID
        $total_fee = $data['total_fee'];            //付款金额
        $transaction_id = $data['transaction_id'];  //微信支付流水号
        $orderdata=array(
            'status'=>2,
            'paystatus'=>1,
            'trade_no'=>$transaction_id,
            'paytype_name'=>'weixin'
        );
        //更新数据库
        update('xiaozu_order',$orderdata,"dno='".$order_sn."'");
        
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

    /**
     * 将xml转为array
     * @param  string   $xml xml字符串
     * @return array    转换得到的数组
     */
    function xml2array($xml){   
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $result= json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
        return $result;
    }

    /**
    * 生成签名
    * @return 签名
    */
    function makeSign($data){
        //获取微信支付秘钥
        $key = 'asdasd3e2332eewddsr3434342423232';
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