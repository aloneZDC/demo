<?php
//其中 video 是表名；
//createtime 是字段；
//
//数据库time字段为时间戳
//
//查询当天：
 
$start = date('Y-m-d 00:00:00');
$end = date('Y-m-d H:i:s');
SELECT * FROM `table_name` WHERE `time` >= unix_timestamp( '$start' ) AND `time` <= unix_timestamp( '$end' )
 
//查询本周：
 
SELECT yearweek( '2011-04-17 15:38:22',1 ) //结果是201115
SELECT yearweek( '2011-04-17 15:38:22' ) //结果是201116
//yearweek的第2个参数设置为1的原因是，中国人习惯把周1作为本周的第一天
//另外补充下：
//2011-04-17 是周日。
SELECT dayofweek( '2011-04-17 15:38:22' )// 查询出的是1，把礼拜天作为一周的第一天。
SELECT dayofweek( '2011-04-18 15:38:22' ) //查询出的是2
SELECT weekday( '2011-04-17 15:38:22' )// 查询出的是6，
SELECT weekday( '2011-04-18 15:38:22' )// 查询出的是0，
//所以建议使用weekday，查询出来的结果+1就可以了，就比较符合国人的习惯了。
 
SELECT * FROM `table_name` WHERE YEARWEEK( FROM_UNIXTIME( `time`, '%Y-%m-%d %H:%i:%s' ) ,1) = YEARWEEK( now( ),1 )
 
//查询本月：
 
$start = date('Y-m-01 00:00:00');
$end = date('Y-m-d H:i:s');
SELECT * FROM `table_name` WHERE `time` >= unix_timestamp('”.$start.”') AND `time` <= unix_timestamp('$end')
 
//查询本年：
 
$start = date('Y-01-01 00:00:00');
$end = date('Y-m-d H:i:s');
SELECT * FROM `table_name` WHERE `time` >= unix_timestamp( '$start' ) AND `time` <= unix_timestamp( '$end' )