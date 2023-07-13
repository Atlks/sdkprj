<?php
//文件注释：：本文件为cfg文件
//配置日志文件路径
$logfile = __DIR__ . '/logs/app.log';


require "sdk/envTestSuport.php";

//---------------------------------数据库配置  默认从环境变量读取

$mysql_conf['host'] = getenv("DB_HOST");
$mysql_conf['db'] = getenv("DB_NAME");
$mysql_conf['db_user'] = getenv("DB_USER");
$mysql_conf['db_pwd'] = getenv("DB_PASSWORD");
$mysql_conf['port'] = getenv("DB_PORT");


echo json_encode($mysql_conf);


