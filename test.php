<?php
include("./demo2.php");

?>
<html>
	<head>
		<title>增删改查</title>
	</head>
	<style>
		.boback{border:1px solid #000;}
		td{border:1px solid #000;}
	</style>
	<body>
		<div>
			<table class='boback'>
				<tr>
					<td>ID</td>
					<td>用户名</td>
					<td>操作</td>
				</tr>
				<?php
					$row=mysql_query("select * from tp_user");
					while($res=mysql_fetch_assoc($row)){
						echo "<tr><td>".$res['id']."</td><td>".$res['username']."</td><td><a href='./edit.php?id=".$res['id']."'>修改</a> | <a href='./action.php?action=delete&id=".$res['id']."'>删除</a></td></tr>";
					}
				?>	
			</table>
		</div>
		<div>
			<a href='./add.php'>添加</a>
		</div>
	</body>
</html>