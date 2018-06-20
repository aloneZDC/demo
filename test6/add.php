<?php
	include("./config.php");//require()
	if(empty($_GET['id'])){
		$title="添加";
		$act='add';
	}else{
		$title="修改";
		$act='edit';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title><?php echo $title;?></title>
</head>
<body>
	<form action="./action.php?act=<?php echo $act;?>" method="post">
		<table style="margin:0 auto;">
			<?php
				if(!empty($_GET['id'])){
					$id=$_GET['id'];
					$sql="select * from bg_cate where cate_Id='".$id."'";
					$res=mysql_query($sql);
					$row=mysql_fetch_assoc($res);
				}
			?>
			<tr>
				<td>分类名</td>
				<td><input type="text" name="cate_Name" value="<?php if(!empty($row)){echo $row['cate_Name'];}?>"/></td>
			</tr>
			<tr>
				<td>描述</td>
				<td><textarea name="cate_Intro"><?php if(!empty($row)){echo $row['cate_Intro'];}?></textarea></td>
			</tr>
			<tr>
				<td><input type='hidden' name="cate_Id" value="<?php if(!empty($row)){echo $row['cate_Id'];}?>"/></td>
				<td><input type="submit" value="提交"/></td>
			</tr>
		</table>
	</form>
</body>
</html>