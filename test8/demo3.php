<?php
 $ch = curl_init();
 // // 2. 设置选项，包括URL
 // curl_setopt($ch,CURLOPT_URL,"http://www.baidu.com");//我弄的一个小论坛 ＝＝
 // curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
 // curl_setopt($ch,CURLOPT_HEADER,0);
 // // 3. 执行并获取HTML文档内容
 // $output = curl_exec($ch);
 // if($output === FALSE ){
 // echo "CURL Error:".curl_error($ch);
 // }
 // print_r($output);
 // // 4. 释放curl句柄
 // curl_close($ch);
    // 获取的curl结果
    $re = curl_exec($ch);
    list ($header, $body) = explode("\r\n\r\n", $re, 2);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // 有的网站会检查referer地址来判断是否请求来自重定向，这里保存上次请求的url供重定向构造referer使用
    $last_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    if ($http_code == 301 || $http_code == 302) {
        if (preg_match('/Location:(.*?)\n/', $header, $matches)) {
            // 继续抓取目标页面
            $urlinfo = parse_url($url);
            // 这里match的url地址可能不一样，所以不一定这么简单的拼接就行
            $re_url = $urlinfo['scheme'] . '://' . $urlinfo['host'] . substr($urlinfo['path'], 0, strrpos($urlinfo['path'], '/')+1) . trim($matches[1]);
            return $this->_http_get($re_url, $last_url);
        } else {
            return FALSE;
        }
    } else if ($http_code == 200) {
        return $body;
    } else {
        echo 'Error: CURL failed.[url='.$url.']; [http code= '. $http_code.']';
        return FALSE;
    }