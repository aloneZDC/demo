<?php
//连接数据库 
/**
*创建中奖号码表
CREATE TABLE `member` ( 
 `id` int(11) NOT NULL auto_increment, 
 `mobile` varchar(20) NOT NULL, 
 `status` tinyint(1) NOT NULL default '0', 
 `name` varchar(100) NOT NULL, 
 PRIMARY KEY (`id`) 
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 
*/
header("content-type:text/html;charset=utf-8");
$cig=@mysql_connect("127.0.0.1","root","root") or die("no connect");
mysql_query("set names utf8");
mysql_select_db("choujiang",$cig);
  
$action = $_GET['action']; 
if($action==""){ //读取数据，返回json 
    $query = mysql_query("select * from member where status=0"); 
    while($row=mysql_fetch_array($query)){ 
        $arr[] = array( 
            'id' => $row['id'], 
            'mobile' => substr($row['mobile'],0,3)."****".substr($row['mobile'],-4,4),
            'name'=> $row['name']
        ); 
    } 
    echo json_encode($arr); 
}else{ //标识中奖号码 
    $id = $_POST['id']; 
    $jpid=$_POST['jpid'];
    $sql = "update member set status='".$jpid."' where id='".$id."'"; 
    $query = mysql_query($sql); 
    if($query){ 
          echo '1'; 
    } 
} 