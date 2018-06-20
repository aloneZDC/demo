<?php

header("content-type:text/html;charset=utf-8");
$cig=mysql_connect("127.0.0.1","root","root") or die("no connect");
mysql_query("set names utf8");
mysql_select_db("weidogs",$cig);
$res=mysql_query("select * from bg_cate ");
$getarr=array();
while($row=mysql_fetch_assoc($res)){
  $getarr[]=$row;
}

function gettree($data,$pid){
  $getarr=array();
  foreach($data as $k=>$v){
    if($v['cate_ParentId']==$pid){
      $v['cid']=gettree($data,$v['cate_Id']);
      $getarr[]=$v;
    }
  }
  return $getarr;
} 

//$data=gettree($getarr,0);
$t=mktime();   
set_time_limit(1000);   
$myFile="./insert.sql";   
$fhandler=fopen($myFile,'wb');   
if($fhandler){   
  
$i=0;   
while($i<1000000)//1,0000,000   
{   
$i++;   
$sql="$i\t'bb'";   
fwrite($fhandler,$sql."\r\n");   
}   
echo"写入成功,耗时：",mktime()-$t;   
}   