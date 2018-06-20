<?php
	include("./config.php");
	if(empty($_GET)){
		$title="添加";
		$act="add";
	}else{
		$title="修改";
		$act="edit";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title;?></title>
</head>
<body>
	<form action="./action.php?act=<?php echo $act;?>" method="post">
		<table>
			<?php
				if(!empty($_GET)){
					$id=$_GET['id'];
					$sql="select * from bg_cate where cate_Id='".$id."'";
					$row=select_one($sql);
					// $res=mysql_query($sql);
					// $row=mysql_fetch_assoc($res);
				}		
			?>
			<tr>
				<td>分类名</td>
				<td><input name="cate_Name" type="text" value="<?php if(!empty($_GET)){echo $row['cate_Name'];}?>"/></td>
			</tr>
			<tr>
				<td>描述</td>
				<td><textarea name="cate_Intro"><?php if(!empty($_GET)){echo $row['cate_Intro'];}?></textarea></td>
			</tr>
			<tr>
				<td><input type="hidden" name="cate_Id" value="<?php if(!empty($_GET)){echo $row['cate_Id'];}?>"/></td>
				<td><input type="submit" value="提交"/></td>
			</tr>
		</table>
	</form>
</body>
</html>