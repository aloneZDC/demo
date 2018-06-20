<?php 
include('./demo2.php');
$id=$_GET['id'];
$sql="select * from tp_user where id='".$id."'";
$row=mysql_query($sql);
$res=mysql_fetch_assoc($row);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>修改</title>
</head>
<body>
	<form action='./action.php?action=edit' method='post'>
		<table>
			<tr>
				<td>用户名</td>
				<td>
					<input type='text' name='username' value="<?php echo $res['username'];?>">
					<input type='hidden' name='id' value='<?php echo $res['id']?>'>
				</td>
			</tr>
			<tr>
				<td><input type='submit' value='提交'></td>
			</tr>
		</table>
	</form>

</body>
</html>