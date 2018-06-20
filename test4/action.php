<?php

include('./config.php');
$action=$_GET['act'];
switch($action){
	case 'add':
		$name=$_POST['cate_Name'];
		$intro=$_POST['cate_Intro'];
		if(empty($name) || empty($intro)){
			echo "<script>alert('内容不能为空');location.href='./add.php';</script>";
			exit;
		}
		$data=array('cate_Name'=>$name,'cate_Intro'=>$intro);
		$res=insert('bg_cate',$data);
		// $sql="INSERT INTO bg_cate (`cate_ParentId`,`cate_Name`,`cate_Intro`) VALUES('0','".$name."','".$intro."')";
		// $res=mysql_query($sql);
		if($res){
			echo "<script>alert('添加成功');location.href='./index.php';</script>";
		}else{
			echo "<script>alert('添加失败');location.href='./add.php';</script>";
		}
	break;
	case 'edit':
		$name=$_POST['cate_Name'];
		$intro=$_POST['cate_Intro'];
		$id=$_POST['cate_Id'];
		if(empty($name) || empty($intro)){
			echo "<script>alert('内容不能为空');location.href='./add.php?id=".$id."';</script>";
			exit;
		}
		$data=array('cate_Name'=>$name,'cate_Intro'=>$intro);
		$where=array('cate_Id'=>$id);
		$res=update('bg_cate',$data,$where);
		// $sql="UPDATE bg_cate SET `cate_Name`='".$name."',`cate_Intro`='".$intro."' where cate_Id='".$id."'";
		// $res=mysql_query($sql);
		if($res){
			echo "<script>alert('修改成功');location.href='./index.php';</script>";
		}else{
			echo "<script>alert('修改失败');location.href='./add.php?id=".$id."';</script>";
		}
	break;
	case 'del':
		$id=$_GET['id'];
		$where=array('cate_Id'=>$id);
		$res=del('bg_cate',$where);
		// $sql="DELETE FROM bg_cate where cate_Id='".$id."'";
		// $res=mysql_query($sql);
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