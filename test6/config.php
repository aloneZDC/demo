<?php

header("content-type:text/html;charset=utf-8");
$cig=mysql_connect("127.0.0.1","root","root") or die("no connect");
mysql_query("set names utf8");
mysql_select_db("weidogs",$cig);


