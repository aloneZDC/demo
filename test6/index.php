<?php 
	include("./config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>首页</title>
</head>
<body>
	<table style='margin:0 auto;' border="1px solid #000">
		<tr>
			<td><a href='./add.php'>添加</a></td>
		</tr>
		<tr>
			<td>ID</td>
			<td>分类名</td>
			<td>描述</td>
			<td>操作</td>
		</tr>
		<?php
			$sql="select * from bg_cate order by cate_Id asc";
			$res=mysql_query($sql);
			while($row=mysql_fetch_assoc($res)){
				echo "<tr><td>".$row['cate_Id']."</td><td>".$row['cate_Name']."</td><td>".$row['cate_Intro']."</td><td><a href='./add.php?id=".$row['cate_Id']."'>修改</a> | <a href='./action.php?act=del&id=".$row['cate_Id']."'>删除</a></td></tr>";
			}
		?>
		
	
	</table>
</body>
</html>