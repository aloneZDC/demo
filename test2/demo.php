 <?php

header("content-type:text/html;charset=utf-8");
// $cig=mysql_connect('127.0.0.1','root','root');
// mysql_query("set names utf8");
// mysql_select_db("weidogs",$cig);

// $sql="select * from bg_cate order by cate_Id asc";
// $res=mysql_query($sql);
// $getarr=array();
// while($row=mysql_fetch_assoc($res)){
// 	$getarr[]=$row;
// }
// function gettree($data,$pid){
// 	$tree=array();
// 	foreach($data as $k=>$v){
// 		if($v['cate_ParentId']==$pid){
// 			$v['cate_ParentId']=gettree($data,$v['cate_Id']);
// 			$tree[]=$v;
// 		}
// 	}
// 	return $tree;
// }
// $test=gettree($getarr,0);
// print_r($test);

$filename='./demo.txt';
$text="123456789";
function wtext($filename,$text){
	$fp=fopen($filename,'w');
	fwrite($fp,$text);
	fclose($fp);
}

function ftext($filename,$text){
	file_put_contents($filename,$text,FILE_APPEND);
}

$redis=new Redis();
$redis->connect('127.0.0.1',6379);
$data=$redis->get('demodata');
if(empty($data)){
	echo "mysql";
	$mysql=new PDO("mysql:host=127.0.0.1;dbname=weidogs","root","root",array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"));
	$rs=$mysql->query("select * from bg_cate");
	$demodata=array();
	$i=0;
	while($row=$rs->fetch()){
		$demodata[$i]['id']=$row['cate_Id'];
		$demodata[$i]['pid']=$row['cate_ParentId'];
		$demodata[$i]['title']=$row['cate_Name'];
		$demodata[$i]['content']=$row['cate_Intro'];
		$i=$i+1;
	}
	//print_r($demodata);
	$json=json_encode($demodata);
	$redis->set('demodata',$json);
}else{
	echo "redis";
	$demodata=json_decode($data,true);
	//print_r($demodata);
}

function gettree($data,$pid){
	$tree=array();
	foreach($data as $v){
		if($v['pid']==$pid){
			$v['child']=gettree($data,$v['id']);
			$tree[]=$v;
		}
	}
	return $tree;
}
$a=gettree($demodata,0);


function procHtml($data,$pid=0,$n=-1){   
	$options = '';   
	static $i = 0;   
	if ($i == 0){   
		$options .= '<option value="0" >请选择</option>';   
	}   
	if ($data){   		
		$n++;   
		foreach($data as $k=>$v){  
			$i++;
			if($v['pid']==$pid){
				$options .="<option value='{$v['id']}'";
				$options .=">".str_repeat(' &nbsp;',$n*3).$v['title']."</option>\n";   
				$options .=procHtml ($data,$v['id'],$n); 
			}			  
		}   
	}   
	return $options;   
}
$html=procHtml($demodata);
echo "<select>".$html."<select>";


