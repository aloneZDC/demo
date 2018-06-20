<?php
// 	include('./config.php');
// 	include('./upload.class.php');
// 	$filename="/upload/";
//  $upload = new UploadFile($_FILES['file'],$filename);//upload
//  $file = $upload->upload();
    //包含一个文件上传类中的上传类aaa
    // include("upload.class.php");
    // $up = new FileUpload;
    // //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)a
    // $up -> set("path", "./upload/member/");
    // $up -> set("maxsize", 2000000);
    // $up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
    // $up -> set("israndname", true);
    // //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
    // if($up -> upload("file")) {
    //     //获取上传后文件名子
    //     print_r($up->getFileName());
    // } else {
    //     //获取上传失败以后的错误提示
    //     print_r($up->getErrorMsg());
    // }

    /**
    * 把图片上传到http://www.debangjs.com
    */
    $files  =   $_FILES;  
    if(empty($files)){  
        print_r('没有上传的文件！');  
        return false;  
    }  
    $curl = curl_init();
    $ext = pathinfo(strip_tags($files['file']['name']), PATHINFO_EXTENSION);  
    $new_name = dirname($files['file']['tmp_name']).'/'.date("YmdHis").rand(0,99).".".$ext;  
    rename($files['file']['tmp_name'],$new_name);  
    $fields['file'] = new \CURLFile(realpath($new_name));
    //初始化curl          
    $ch = curl_init();  
    curl_setopt($ch,CURLOPT_URL, "http://www.debangjs.com/upload.php");  
    curl_setopt($ch, CURLOPT_POST, TRUE );  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields );  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
    //运行curl  
    $r = curl_exec($ch);  
    curl_close($ch);  
    @unlink($new_name);  
    if($r){  
        print_r($r);exit;  
    }else{  
        print_r("请求失败");  
        return false;  
    }
?>