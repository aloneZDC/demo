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
	<div>
		<table border="1" style="margin:0 auto;">
			<tr>
				<td><a href='./add.php'>添加</a></td>
			</tr>
			<tr>
				<th>ID</th>
				<th>分类名</th>
				<th>描述</th>
				<th>操作</th>
			</tr>
			<?php
				// $sql="select * from bg_cate order by cate_Id asc";
				// $res=mysql_query($sql);
				// while($row=mysql_fetch_assoc($res)){
				$data=getarr("select * from bg_cate order by cate_Id asc");
				//print_r($row);exit;
				foreach($data as $k=>$row){
					echo "<tr><td>".$row['cate_Id']."</td><td>".$row['cate_Name']."</td><td>".$row['cate_Intro']."</td><td><a href='./add.php?id=".$row['cate_Id']."'>修改</a> | <a href='./action.php?act=del&id=".$row['cate_Id']."'>删除</a></td></tr>";
				}
			?>			
		</table>
	</div>

</body>
</html>