<?php  
/** 
 * Created by PhpStorm. 
 * User: UFO 
 * Date: 17/7/18 
 * Time: 下午5:31 
 */  
require_once ('WxPay.Api.php');  
  
class WXPay  {  
    function index($remark,$orderno,$orderid,$money,$openid) {  
        //         初始化值对象  
        $input = new WxPayUnifiedOrder();  
        //         文档提及的参数规范：商家名称-销售商品类目  
        $input->SetBody($remark);  
        //         订单号应该是由小程序端传给服务端的，在用户下单时即生成，demo中取值是一个生成的时间戳  
        $input->SetAttach($orderno);
        //         订单ID
        $input->SetOut_trade_no($orderid);  
        //         费用应该是由小程序端传给服务端的，在用户下单时告知服务端应付金额，demo中取值是1，即1分钱  
        $input->SetTotal_fee($money*100);  
        $input->SetNotify_url("https://zb.debangjs.com/pay/notify.php");//需要自己写的notify.php  
        $input->SetTrade_type("JSAPI");  
        //         由小程序端传给后端或者后端自己获取，写自己获取到的，  
        $input->SetOpenid($openid);  
        //$input->SetOpenid($this->getSession()->openid);  
        //         向微信统一下单，并返回order，它是一个array数组  
        $order = WxPayApi::unifiedOrder($input);  
        //         json化返回给小程序端  
        header("Content-Type: application/json");  
        echo $this->getJsApiParameters($order);  
    }  
  
    function getJsApiParameters($UnifiedOrderResult)  
    {    //判断是否统一下单返回了prepay_id  
        if(!array_key_exists("appid", $UnifiedOrderResult)  
            || !array_key_exists("prepay_id", $UnifiedOrderResult)  
            || $UnifiedOrderResult['prepay_id'] == "")  
        {  
            throw new WxPayException("参数错误");  
        }  
        $jsapi = new WxPayJsApiPay();  
        $jsapi->SetAppid($UnifiedOrderResult["appid"]);  
        $timeStamp = time();  
        $jsapi->SetTimeStamp("$timeStamp");  
        $jsapi->SetNonceStr(WxPayApi::getNonceStr());  
        $jsapi->SetPackage("prepay_id=" . $UnifiedOrderResult['prepay_id']);  
        $jsapi->SetSignType("MD5");  
        $jsapi->SetPaySign($jsapi->MakeSign());  
        $parameters = json_encode($jsapi->GetValues());  
        return $parameters;  
    }  
//这里是服务器端获取openid的函数  
//    private function getSession() {  
//        $code = $this->input->post('code');  
//        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.WxPayConfig::APPID.'&secret='.WxPayConfig::APPSECRET.'&js_code='.$code.'&grant_type=authorization_code';  
//        $response = json_decode(file_get_contents($url));  
//        return $response;  
//    }  
}  
$uid=$_GET['uid'];
$money=$_GET['money'];
$remark=$_GET['remark'];
$orderno=$_GET['orderno'];
$orderid=$_GET['id'];
$openid=$_GET['openid'];
$WxPay = new WXPay(); 
$WxPay->index($remark,$orderno,$orderid,$money,$openid);  