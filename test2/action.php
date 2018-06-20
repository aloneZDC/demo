<?php

include("./config.php");
$action=$_GET['act'];
switch($action){
	case 'add':
		$name=trim($_POST['cate_Name']);
		$intro=$_POST['cate_Intro'];
		if(empty($name) || empty($intro)){
			echo "<script>alert('内容不能为空');location.href='./add.php';</script>";
		}
		//$sql="INSERT INTO bg_cate (`cate_ParentId`,`cate_Name`,`cate_Intro`) VALUES ('0','".$name."','".$intro."')";
		//$res=mysql_query($sql);
		$data=array(
			'cate_ParentId'=>0,
			'cate_Name'=>$name,
			'cate_Intro'=>$intro
		);
		$res=insert('bg_cate',$data);
		if($res){
			echo "<script>alert('添加成功');location.href='./index.php';</script>";
		}else{
			echo "<script>alert('添加失败');location.href='./add.php';</script>";
		}
	break;
	case 'edit':
		$name=trim($_POST['cate_Name']);
		$intro=$_POST['cate_Intro'];
		$id=$_POST['cate_Id'];
		if(empty($name) || empty($intro)){
			echo "<script>alert('内容不能为空');location.href='./edit.php';</script>";
		}
		$data=array(
			'cate_ParentId'=>0,
			'cate_Name'=>$name,
			'cate_Intro'=>$intro
		);
		//$sql="UPDATE bg_cate SET `cate_Name`='".$name."',`cate_Intro`='".$intro."' where cate_Id='".$id."'";
		//$res=mysql_query($sql);
		$res=update('bg_cate',$data," cate_Id='".$id."'");
		if($res){
			echo "<script>alert('修改成功');location.href='./index.php';</script>";
		}else{
			echo "<script>alert('修改失败');location.href='./add.php?id=".$id."';</script>";
		}
	break;
	case 'del':
		$id=$_GET['id'];
		//$sql="DELETE FROM bg_cate where cate_Id='".$id."'";
		//$res=mysql_query($sql);
		$res=del('bg_cate'," cate_Id='".$id."'");
		if($res){
			echo "<script>alert('删除成功');location.href='./index.php';</script>";
		}else{
			echo "<script>alert('删除失败');location.href='./index.php';</script>";
		}
	break;

	default:
		echo "<script>alert('操作错误');location.href='./index.php';</script>";
	break;
}