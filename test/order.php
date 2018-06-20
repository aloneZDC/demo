<?php
	include('./config.php');
	include('./iplocation.class.php');
	$action=$_GET['act'];
	switch($action){
		case 'orderlist':
			$uid=$_GET['uid'];
			$order=getarr("select * from xiaozu_order where buyeruid='".$uid."' order by id desc");
			foreach($order as $k=>$v){
				$shop=select_one("select * from xiaozu_shop where id='".$v['shopid']."'");
				$order[$k]['shopname']=$shop['shopname'];
				$order[$k]['shoplogo']=$shop['shoplogo'];
				$orderwuliustatus = select_one("select * from xiaozu_orderstatus where  orderid = ".$v['id']." order by id desc limit 0,1 ");
				$order[$k]['orderwuliustatus'] = $orderwuliustatus['statustitle'];
				$order[$k]['addtime']=date("Y-m-d H:i:s",$v['addtime']);
			}
			$json=json_encode($order);
			print_r($json);exit;
		break;
		case 'orderdetail':
			$orderid=$_GET['id'];
			$orderstatus=getarr("select * from xiaozu_orderstatus where   orderid = ".$orderid." order by addtime asc limit 0,10 ");
			foreach($orderstatus as $k=>$v){
				$orderstatus[$k]['addtime']=date("m-d H:i",$v['addtime']);
			}
			$data['orderwuliustatus'] = $orderstatus;
			$order = select_one("select * from xiaozu_order where id = ".$orderid."");   
			$orderdet = getarr("select * from xiaozu_orderdet where order_id='".$order['id']."'");  
	        $order['cp'] = count($orderdet); 
            $buyerstatus= array(
     	     	'0'=>'等待处理',
     	     	'1'=>'订餐成功处理中',
     	     	'2'=>'订单已发货',
     	     	'3'=>'订单完成',
     	     	'4'=>'订单已取消',
     	     	'5'=>'订单已取消'
     	    );
     	    $paytypelist = array(0=>'货到支付',1=>'在线支付');	     
     	    $paytypearr = $paytypelist; 
     	    $order['is_acceptorder'] = $order['is_acceptorder'];
     	    $order['surestatus'] = $order['status'];
     	    $order['basetype'] = $order['paytype'];
     	    $order['basepaystatus'] =$order['paystatus'];
     	    $order['paytype'] =  $order['paytype'];
     	    $order['paystatus'] = $order['paystatus'] ;
     	    $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
     	    $order['posttime'] = date('Y-m-d H:i:s',$order['posttime']);
     	    $data['order'] = $order;
            $data['orderdet'] = $orderdet;
            $json=json_encode($data);
            print_r($json);exit;	
		break;
		case 'order-add':
			$uid=$_POST['uid'];
			$goodsarr=json_decode($_POST['goodsJsonStr'],true);
			$allcost='';
			$fanx=$_POST['fanx'];
			$actid=$_POST['actid'];
			foreach($goodsarr as $k=>$v){
				$allcost+=$v['price']*$v['number'];
			}
			$data['shopid']=195;
			$shopinfo=select_one("select * from xiaozu_shop where id='".$data['shopid']."'");
			$data['areaids'] = '133';
		    $data['admin_id'] = $shopinfo['admin_id']; 
			$data['shoptype'] = 0;//: 0:普通订单，1订台订单 
			//获取店铺商品总价  获取超市商品总价
			$data['shopcost'] = $allcost;
			$data['allcost']=$allcost;
			$data['shopps'] = 0; 
			$data['bagcost'] =  0;
			$data['ordertype'] = 6;

			//优惠券
			if(!empty($_POST['couponId'])){
				$data['yhjids']=$_POST['couponId'];
				$data['yhjcost']=$_POST['coucost'];
				$data['shopcost'] = $allcost-$data['yhjcost'];
				$data['allcost']=$allcost-$data['yhjcost'];
			}
			//红酒返现
			if(!empty($fanx)){
				$data['allcost']= $data['allcost']-$fanx;
				$data['shopcost'] = $data['shopcost']-$fanx;
				$data['act']=$actid;
				$data['fxcost']=$fanx;
			}
			$loca=select_one("select *  from xiaozu_member  where uid=".$uid." ");
			$ulist=getarr("select uid  from xiaozu_member  where loca=".$loca['loca']." ");
			$uid='';
			foreach ($ulist as $key => $value) {
				$uid.=$value['uid'].',';
			}
			$start = date('Y-m-d 00:00:00',time());
			$end = date('Y-m-d 23:59:59',time());
			$newstr = substr($uid,0,strlen($uid)-1);
			$dxuhao = select_one("select *  from xiaozu_order  where addtime >= ".strtotime($start)." and addtime<=".strtotime($end)." and buyeruid in(".$newstr.") order by id desc");
			if(empty($dxuhao)){
			 	$data['dxuhao']=1;
			}else{
			 	$data['dxuhao']=$dxuhao['dxuhao']+1;
			}
			//支付方式检测
			$userid = $uid;
			if(!empty($_POST['paytype'])){
				$data['paytype'] = $_POST['paytype']; 
				if($data['paytype'] == 0){
				 	$data['status'] = 0;
			  	}else{
			  		$data['status'] = 1;
			  	}
			}else{
				$data['paytype'] = 0; 
			}
		  	$data['paystatus'] = 0;// 支付状态1已支付	
			$data['cxids'] = '';
			$data['cxcost'] = 0;
			//$data['taoc']=$info['taoc'];
			//生成订单序号
			$start = date('Y-m-d 00:00:00',time());
			$end = date('Y-m-d 23:59:59',time());
			$data['content']=$_POST['remark'];
			//: 配送时间  
		  	$data['postdate'] = date("H:i",time()).'-'.date("H:i", time() +1800);//配送时间段
		  	$data['othertext'] = '';//其他说明 	  
		  	$data['is_make'] = 0;
		  	$data['is_goshop'] = 0;
		  	//  :审核时间
		  	$data['passtime'] = time();
		  	$data['addtime']=time();
		  	$data['buycode'] = substr(md5(time()),9,6);
			$data['dno'] = time().rand(1000,9999);	
			//检测店铺	 
		  	$data['shopuid'] = $shopinfo['uid'];// 店铺UID	
		  	$data['shopid'] =  $shopinfo['id']; //店铺ID	
		  	$data['shopname'] = $shopinfo['shopname']; //店铺名称	
		  	$data['shopphone'] = $shopinfo['phone']; //店铺电话
		  	$data['shopaddress'] = $shopinfo['address'];// 店铺地址	
		  	if(!empty($_POST['address'])){
		  		$data['buyeraddress'] = $_POST['address'];
			  	$data['buyeruid'] = $_POST['uid'];// 购买用户ID，0未注册用户	
			  	$data['buyername'] =  $_POST['linkMan'];//购买热名称
			  	$data['buyerphone'] = $_POST['mobile'];// 联系电话  
		  	}
		  	$ip_l=new iplocation(); 
		  	$ipaddress=$ip_l->getaddress($ip_l->getIP());  
	        if(isset($ipaddress["area1"])){
			    $data['ipaddress']  = $ipaddress['ip'].mb_convert_encoding($ipaddress["area1"],'UTF-8','GB2312');//('GB2312','ansi',);
		    }
		    //创建订单
		    if(!empty($goodsarr)){
			  	insert('xiaozu_order',$data);  //写主订单 	  
			  	$orderid = insertid();		
				writewuliustatus($orderid,1,$data['paytype']);
				$data['is_make']=1;
				$this->writewuliustatus($orderid,4,$data['paytype']); 
			  	$info=array();
			  	$i=0;
			  	foreach($goodsarr as $k=>$v){
			  		$info[$i]=select_one("select * from xiaozu_goods where id='".$v['goodsId']."'");
			  		$info[$i]['gcount']=$v['number'];
			  		$i=$i+1;
			  	}
			  	foreach($info as $key=>$value){ 
				    $cmd['order_id'] = $orderid; 
				    $cmd['goodsid'] = $value['id'];
				    $cmd['goodsname'] = $value['name'];
				    $cmd['goodscost'] = $value['cost'];
				  	$cmd['goodscount'] = $value['gcount'];
				  	$cmd['shopid'] = $value['shopid'];
				  	$cmd['status'] = 0; 
				  	$cmd['is_send'] = 0;
					$cmd['have_det'] = $value['have_det'];
					$cmd['product_id'] = 0;
				  	insert('xiaozu_orderdet',$cmd);
				  	$gdata=array(
				  		'count'=>$value['count']-$value['gcount'],
				  		'sellcount'=>$value['sellcount']+$value['gcount']
				  	);
					update('xiaozu_goods',$gdata,"id='".$cmd['goodsid']."'"); 		
			  	}	
			  	$order=select_one("select * from xiaozu_order where id='".$orderid."'");
			  	$order['addtime']=date("Y-m-d H:i:s",$order['addtime']);
			  	$json=json_encode($order);
			  	print_r($json);exit;
		  	}	

			print_r("创建订单成功");
		break;
		case 'orderdel':
			$oid=$_GET['orderid'];
			$res=del("xiaozu_order",array('id'=>$oid));
			if($res){
				echo "删除成功";exit;
			}else{
				echo "删除失败";exit;
			}
		break;

		default:
			echo "操作错误";exit;
		break;
	}