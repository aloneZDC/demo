<?php
function randomkeys($length){
    $pattern='1234567890'; //字符池
    for($i=0;$i<$length;$i++){
        $key.=$pattern{mt_rand(0,9)};//生成php随机数
    }
    return $key;
}

$code=randomkeys(4);
print_r($code);