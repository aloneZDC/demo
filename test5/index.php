<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>短信模块</title>

<style type="text/css">
<!--
body,td,th {
    font-size: 12px;
    font-family: 微软雅黑;
}
.number{ height:22px; line-height:22px;font-family: 微软雅黑;}
-->
</style>
</head>

<body>

<!--以下功能是根据需要调用 A-->

<script language="JavaScript" type="text/javascript" src="js_yz.js"></script>
<form id="feedbackform" name="feedbackform" action="" method="post" >
    <table width="501" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" style="margin-top:50px;">
      <tr>
        <td width="133" height="45" bgcolor="#FAFAFA" style="padding-left:10px;">获取短信验证码：</td>
        <td width="365" height="45" bgcolor="#FAFAFA" style="padding-left:10px;"><input name="scms_gettel" id="scms_gettel" class="number" type="text" value="18810306233" />
        <input name="right_yzcode" id="right_yzcode" type="hidden" value="" />              <input name="Submitbfs" type="button" value="获取验证码" class="btn submit" id="Submitbfs" onclick="giveduanxin(document.getElementById('scms_gettel').value)" style="height:28px;"/></td>
      </tr>
      <tr>
        <td height="45" bgcolor="#FAFAFA" style="padding-left:10px;">您收到的验证码：</td>
        <td height="45" bgcolor="#FAFAFA" style="padding-left:10px;"><input type="text" name="scms_yzcode" id="scms_yzcode" class="number" value="" maxlength="6" onblur="giveyz(document.getElementById('scms_yzcode').value)" style="float:left" /><div id="show_statu" style=" float:left;font-size:12px; text-align:left; border:1px solid #FFCC00; line-height:25px; background:#FFFFCC; color:#333333; display:none; height:25px; padding-left:10px; margin-left:8px;"></div></td>
      </tr>
    </table>

</form>

<!--以下功能是根据需要调用 B-->

</body>
</html>