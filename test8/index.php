<?php
 require_once("./class.smtp.php");
 $smtpserver = "smtp.163.com";                                              //SMTP服务器
 $smtpserverport = 25;                                                                //SMTP服务器端口
 $smtpusermail = "15112632313@163.com";                     //SMTP服务器的用户邮箱
 $smtpemailto = "824654504@qq.com";                          //发送给谁
 $smtpuser = "15112632313";                                                 //SMTP服务器的用户帐号 （发送者的邮箱）
 $smtppass = "zdc412318869";                                                           //SMTP服务器的用户密码（发送者的邮箱密码）
 $mailsubject = "hello world";                                                 //邮件主题 

  $mailbody = "This is a test mail from liuxueping.";            //邮件内容 

 $mailtype = "TXT";                                                                     //邮件格式（HTML/TXT）,TXT为文本邮件
 $smtp1 = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
 $smtp1->debug = TRUE;         //是否显示发送的调试信息
 if($smtp1->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype)){
    echo "邮件发送成功!";
 }
 else{
    echo "邮件发送失败!";
 }
?> 