<?php
require_once('email.class.php');

//发送邮件

//主題
$subject = "test send email";

//收件人
$sendto = '824654504@qq.com';

//發件人
$replyto = '15112632313@163.com';

//內容 
$message = "test send email content";

//附件
$filename = 'test.jpg';

//附件類別
$mimetype = "image/jpeg";

$excelname="email";
ini_set('SMTP','smtp.163.com');//发件SMTP服务器  
ini_set('smtp_port',25);//发件SMTP服务器端口  
ini_set('sendmail_from',"15112632313@163.com");//发件人邮箱 
ini_set("sendmail_path","D:/phpStudy/tools/sendmail/sendmail.exe -t"); 
$mailfile = new CMailFile($subject,$sendto,$replyto,$message,$filename,$excelname,$mimetype);
$mailfile->sendfile();
?>