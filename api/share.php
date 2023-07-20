<?php
// api/share.php
//文件注释：：本文件
//初始化日志和db组件
//require "cfg.php";
//---------------------------------数据库配置  默认从环境变量读取
$showDbgEcho=true;


include __DIR__."/conn.php";
var_dump_local( '$mysql_conf:'.json_encode($mysql_conf) );
// // error_log(json_encode($mysql_conf));
 

 $sql="select 1" ;

 echo json_encode( pdo_query($sql)) ;
 