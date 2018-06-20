<?php  
ini_set('max_execution_time', '0');//mysql执行时间   
@mysql_pconnect("127.0.0.1","root","root") or die('connect failed');   
@mysql_select_db("weidogs") or die('select db failed');   
//这一步很重要  取消mysql的自动提交  
mysql_query('SET AUTOCOMMIT=0;');   
  
mysql_query('set names utf8');   
$begin = time();   
$count = 1;  
  
for($i=1;$i<=1000000;$i++){   
 mysql_query("insert into cache values($i,'name')");  
 //插入20W提交一次  
 if($i%200000=='0'){  
    $count++;  
 mysql_query("insert into log cachelog($i,$count)");   
 mysql_query("commit");   
 }  
}   
  
$end = time();   
echo "用时 ".($end-$begin)." 秒 <hr/>";  
  
  
  
?> 