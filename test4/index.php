<?php
	include("./config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>查询</title>
</head>
<body>
	<table border='1' style="margin:0 auto;">
		<tr>
			<td><a href="./add.php">添加</a></td>
		</tr>
		<tr>
			<td>ID</td>
			<td>分类名</td>
			<td>描述</td>
			<td>操作</td>
		</tr>
		<?php
			$sql="select * from bg_cate order by cate_Id asc";
			$row=getarr($sql);
			foreach($row as $k=>$v){
				echo "<tr><td>".$v['cate_Id']."</td><td>".$v['cate_Name']."</td><td>".$v['cate_Intro']."</td><td><a href='./add.php?id=".$v['cate_Id']."'>修改</a> | <a href='./action.php?act=del&id=".$v['cate_Id']."'>删除</a></td></tr>";
			}
			// $res=mysql_query($sql);
			// while($row=mysql_fetch_assoc($res)){
			// 	echo "<tr><td>".$row['cate_Id']."</td><td>".$row['cate_Name']."</td><td>".$row['cate_Intro']."</td><td><a href='./add.php?id=".$row['cate_Id']."'>修改</a> | <a href='./action.php?act=del&id=".$row['cate_Id']."'>删除</a></td></tr>";
			// }
		?>
		
	</table>
</body>
</html>