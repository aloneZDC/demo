<?php
include("./demo2.php");
$action=$_GET['action'];
if($action=='edit'){
	$username=$_POST['username'];
	$id=$_POST['id'];
	$sql="update tp_user set username='".$username."' where id='".$id."'";
	$row=mysql_query($sql);
	if($row){
		echo "<script>alert('修改成功');location.href='./test.php';</script>";
	}else{
		echo "<script>alert('修改失败');location.href='./edit.php';</script>";
	}
}else if($action=='add'){
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$time=time();
	$sql="insert into tp_user (`username`,`password`,`role`,`status`,`last_login_time`,`last_login_ip`,`is_admin`) VALUES ('".$username."','".$password."','5','1','".$time."','127.0.0.1','1')";
	$row=mysql_query($sql);
	if($row){
		echo "<script>alert('添加成功');location.href='./test.php';</script>";
	}else{
		echo "<script>alert('添加失败');location.href='./add.php';</script>";
	}
}else if($action=='delete'){
	$id=$_GET['id'];
	$sql="delete from tp_user where id='".$id."'";
	$row=mysql_query($sql);
	if($row){
		echo "<script>alert('删除成功');location.href='./test.php';</script>";
	}else{
		echo "<script>alert('删除失败');location.href='./test.php';</script>";
	}
	
}else{
	echo "<script>windows.location.href='./test.php';</script>";
}













