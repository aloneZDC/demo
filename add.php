<?php
	include("./demo2.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加</title>
</head>
<body>
	<div>
		<form action='./action.php?action=add' method='post'>
			<table>
				<tr>
					<td>用户名</td>
					<td>
						<input type='text' name='username'>
					</td>
				</tr>
				<tr>
					<td>密码</td>
					<td><input type='password' name='password'></td>
				</tr>
				<tr>
					<td><input type='submit' value='提交'></td>
				</tr>
			</table>	
		</form>
	</div>

</body>
</html>