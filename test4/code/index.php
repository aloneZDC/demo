
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>验证码</title>
</head>
<script type="text/javascript" src='./jquery.js'></script>
<body>
	<form action='./action.php' method="post">
		<table>
			<tr>
				<td><input type='text' name='yzm'/></td>
				<td><img src="./yanzhengma.php"  onclick='javascript:yzmRefresh(this,this.src);'/></td>
			</tr>
			<tr>
				<td><input type='submit' value='提交'/></td>
			</tr>
		</table>
	</form>
<script>
	function yzmRefresh(obj,url){
		obj.src = url+ '?nowtime=' + new Date().getTime(); 
		//后面传递一个随机参数，否则在IE7和火狐下，不刷新图片 
	}
</script>
</body>
</html>