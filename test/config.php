<?php

header('content-type:text/html;charset=utf-8');
$cig=mysql_connect('127.0.0.1','root','debang2016') or die('数据库连接失败');
mysql_query('set names utf8');
mysql_select_db('wmrrrrrrrr',$cig) or die('连接表失败');
// mysql_select_db('chishi',$cig) or die('连接表失败');

function getarr($sql){
	$getarr=array();
	$res=mysql_query($sql);
	if($res){
		while($row=mysql_fetch_assoc($res)){
			$getarr[]=$row;
		}
	}
	return $getarr;
}

function select_one($sql){
	$res=mysql_query($sql);
	$row=mysql_fetch_assoc($res);
	return $row;
}

function insert($table,$data){
	$feild='';
	$values='';
	foreach($data as $k=>$v){
		$feild.="`".$k."`,";
		$values.="'".$v."',";
	}
	$sql="INSERT INTO ".$table." (".substr($feild,0,-1).") VALUES (".substr($values,0,-1).")";
	$res=mysql_query($sql);
	return $res;
}

//更新数据
function update($table,$arr,$where){
	$sqlud='';
	if(is_string($arr)){
		$sqlud=$arr.' ';
	}else{
		foreach($arr as $key=>$value){
			$sqlud.="`".$key."` = '".$value."',";
		}
	}
	$sql="UPDATE `".$table."` set ".substr($sqlud,0,-1)." where ".$where." ";
	return mysql_query($sql);
}

function del($table,$where){
	$wheres='';
	foreach($where as $k=>$v){
		$wheres="`".$k."`='".$v."'";
	}
	$sql="DELETE FROM ".$table." where ".$wheres."";
	$res=query($sql);
	return $res;
}

function catedelete($dbname,$where){
	$sql="DELETE FROM ".$dbname." where ".$where." ";
	$res=mysql_query($sql);
	return $res;
}

function query($sql){
	$res=mysql_query($sql);
	return $res;
}

function counts($sql){
	$res=mysql_query($sql);
	$row=@mysql_num_rows($res);
	return $row;
}

function insertid(){
   return mysql_insert_id();	 
}

/*  
  * $orderid  订单Id
  * $step 订单物流状态 
  *		function writewuliustatus($orderid,$step,$paytype){ }
  *		  1 为订单提交成功 			2 为订单被管理员取消  			 3为在线支付成功    		 	4为商家确认制作  		5为商家取消订单   
  *		  6 配送发货  				7 分配给配送员（配送员已接单）   8配送元已取货   		 		9 已完成（已送达） 	10 用户已确认收货 
  *	      11用户已评价，完成订单   12用户自己取消订单（货到付款）    13用户取消订单，申请退款（在线支付）  
  *		  14 管理员同意退款给用户      15 管理员拒绝退款给用户 
  * $paytype 支付方式 1 为在线支付 0为货到付款
  */
function writewuliustatus($orderid,$step,$paytype){
	$statusdata['orderid']     =  $orderid;
	switch ($step){ 
		case 1 : 
			$statusdata['statustitle'] =  "订单已提交";
			$statusdata['ststusdesc']  =  "请耐心等待商家确认";
			break; 
		case 2 : 
			
			break; 
		case 3 :
			$statusdata['statustitle'] =  "在线支付成功";
			$statusdata['ststusdesc']  =  "订单已在线支付成功";
			break;
		case 4 :
			$statusdata['statustitle'] =  "商家已接单";
			$statusdata['ststusdesc']  =  "商家正在准备商品";
			break;
		case 5 :
			$statusdata['statustitle'] =  "商家取消订单";
			if($paytype == 1){ $statusdata['ststusdesc']  =  "金额将于2个工作日内退还到您的支付账户"; }				
			break;	
		case 16 :
			$statusdata['statustitle'] =  "商家取消订单";
			if($paytype == 1){ $statusdata['ststusdesc']  =  "订单已被取消"; }				
			break;	
		case 6 :
			$statusdata['statustitle'] =  "商家已发货";
			$statusdata['ststusdesc']  =  "商品已经准备好"; 		
			break;
		case 7 :
			$statusdata['statustitle'] =  "配送员已接单";
			$statusdata['ststusdesc']  =  "配送员正赶往商家"; 		
			break;
		case 8 :
			$statusdata['statustitle'] =  "配送员已取货";
			$statusdata['ststusdesc']  =  "请耐心等待配送"; 		
			break;
/* 		case 9 :
			$statusdata['statustitle'] =  "已送达";
			$statusdata['ststusdesc']  =  "请确认收货"; 		
			break; */
		case 9 :
			$statusdata['statustitle'] =  "已完成订单";
			$statusdata['ststusdesc']  =  "请评价订单"; 		
			break;
		case 10 :
			$statusdata['statustitle'] =  "已确认收货";
			$statusdata['ststusdesc']  =  "请评价订单"; 		
			break;
		case 11 :
			$statusdata['statustitle'] =  "已完成订单";
			$statusdata['ststusdesc']  =  "已评价"; 		
			break;
		case 12 :
			$statusdata['statustitle'] =  "已取消订单";
			$statusdata['ststusdesc']  =  "已取消订单"; 		
			break;
		case 13 :
			$statusdata['statustitle'] =  "申请退款处理中";
			$statusdata['ststusdesc']  =  "申请同意后,金额将于2个工作日内退还到您的支付账户"; 		
			break;
		case 14 :
			$statusdata['statustitle'] =  "退款成功";
			$statusdata['ststusdesc']  =  "您可以在您对应的支付账户中查看款"; 		
			break;
		case 15 :
			$statusdata['statustitle'] =  "拒绝退款";
			$statusdata['ststusdesc']  =  "经审核，您的条件不符合退款标准"; 		
			break;
		default : 
			echo "没有这个方法";exit;
			break; 
	} 		
	$statusdata['addtime']     =  time();
    insert('xiaozu_orderstatus',$statusdata); 
}

//酒知识分类递归
function getTree($data,$pId){
	$tree = array();
	foreach($data as $k => $v){
  		if($v['parent_id'] == $pId) {        //父亲找到儿子
   			$v['cheli'] = getTree($data, $v['id']);
   			$tree[] = $v;
   			//unset($data[$k]);
  		}
	}
	return $tree;
}

 //过滤微信昵称特殊符号
function filter($str) {     
    if($str){
        $name = $str;
        $name = preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', $name);
        $name = preg_replace('/xE0[x80-x9F][x80-xBF]‘.‘|xED[xA0-xBF][x80-xBF]/S','?', $name);
        $return = json_decode(preg_replace("#(\\\ud[0-9a-f]{3})#ie","",json_encode($name)));
        if(!$return){
            return jsonName($return); 
        }
    }else{
        $return = '';
    }    
    return $return;
}

function jsonName($str) {
    if($str){
        $tmpStr = json_encode($str);
        $tmpStr2 = preg_replace("#(\\\ud[0-9a-f]{3})#ie","",$tmpStr);
        $return = json_decode($tmpStr2);
        if(!$return){
            return jsonName($return);
        }
    }else{
        $return = '小程序-'.time();
    }    
    return $return;
}