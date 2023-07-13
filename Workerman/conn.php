<?php


$mysql_conf = array(
    'host' => 'pgm-j6c4r878wvy3680zfo.pg.rds.aliyuncs.com',
    'db' => 'postgres',
    'db_user' => 'postgres',
    'db_pwd' => 'woaitav1314!',
    'port' => 1433
);
$dbstr = "pgsql:host=" . $mysql_conf['host'] . ";port=" . $mysql_conf['port'] . ";dbname=" . $mysql_conf['db'];
//print_r($dbstr);
$pdo = new PDO($dbstr, $mysql_conf['db_user'], $mysql_conf['db_pwd']); //创建一个pdo对象
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("set names 'utf8'");
