<?php
/**
*mysql_connect()    				打开非持久的 MySQL 连接
*mysql_set_charset(charset)			设置客户端的字符集
*mysql_select_db(database_name)     设置活动的 MySQL 数据库
*mysql_query(query)					执行一条 MySQL 查询
*mysql_fetch_row(result)			从结果集中取得一行作为数字数组
*mysql_fetch_assoc(result)			从结果集中取得一行作为关联数组
*mysql_num_rows(result)				从结果集中取得行数量

*dbname  数据库
*table   表
*select * from table where id=1 order by id asc
*查询数据 asc升序排序  desc降序排序
*delete from table where id=1 
*删除数据
*update table set name=name1 where id=1
*更新数据
*insert into table (id,name) values (1,name1)
*添加数据
*show tables from dbname
*查看数据库的所有表
*/
header("content-type:text/html;charset=utf-8");
$cfg=mysql_connect('127.0.0.1','root','root') or die('数据库连接失败');
mysql_set_charset('utf8');		//mysql_query('SET NAMES UTF8');一样的;
mysql_select_db('weidogs',$cfg) or die('连接表失败');

//查询
//$sql="select * from tp_user order by id asc";
//$row=mysql_query($sql);
//$res=mysql_fetch_assoc($row);   //mysql_fetch_row($row);一样的;

//更新
//$sql2="update tp_user set username='admin' where id='1'";
//$row2=mysql_query($sql2);

//删除
//$sql3="delete from tp_user where id='1'";
//$row3=mysql_query($sql3);

//添加
//$sql4="insert into tp_user (username,password,role,status) VALUES ('admin','123456',5,1)";
//$row4=mysql_query($sql4);

//查看数据库的表
//$sql5="show tables from weidogs";
//$row5=mysql_query($sql5);

/**
*方法
*/

//查询一条数据
function select_one($sql){
	$row=mysql_query($sql);
	return mysql_fetch_assoc($row);
}

//查询全部数据
function getarr($sql){
	$getarr=array();
	$row=mysql_query($sql);
	while($res=mysql_fetch_assoc($row)){
		$getarr[]=$res;
	}
	return $getarr;
}

//返回数据数量
function counts($sql){
	$row=mysql_query($sql);
	$count=mysql_num_rows($row);
	return $count;
}

//添加数据
function insert($table,$arr){
	$fields='';
	$values='';
	foreach($arr as $key=>$value){
		$fields.="`".$key."`,";
		$values.="'".$value."',";
	}
	$sql="INSERT INTO `".$table."` (".substr($fields,0,-1).") VALUES (".substr($values,0,-1).")";
	return mysql_query($sql); 
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

//删除数据
function delete($table,$where){
	$sql="DELETE FROM `".$table."` where ".$where." ";
	return mysql_query($sql);
}

//复制数据到另一张表
function fzdata($table,table2){
	$sql="INSERT INTO '".$table."' SELECT * FROM  '".$table2."' ";
	return mysql_query($sql);
}


//析构函数关闭数据库
// function __destruct(){	 
//     @mysql_close($cfg);
// }
//$ud=update("tp_user","role=6","id=8");
// UPDATE tp_user SET role=6 where id=8
















