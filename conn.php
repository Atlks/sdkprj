<?php
//文件注释：：本文件
//初始化日志和db组件
require "cfg.php";


//------------------ini log sys
//可以here overwrtei log cfg..
require __DIR__ . '/vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$main = new Logger('main');

$main->pushHandler(new StreamHandler($logfile));

$main->pushHandler(new StreamHandler('php://stdout', $level = Logger::DEBUG,
    $bubble = true));

//$main->info('Information message...');
//$main->debug('dbg message');


//------------------------ini db sys
$dbstr = "mysql:host=" . $mysql_conf['host'] . ";port=" . $mysql_conf['port'] . ";dbname=" . $mysql_conf['db'];
print_r($dbstr);
$pdo = new PDO($dbstr, $mysql_conf['db_user'], $mysql_conf['db_pwd']); //创建一个pdo对象
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$pdo->exec("set names 'utf8'");


/**
 * @param $sql
 * @param PDO $pdo
 */
function exec_sql($sql, $pdo)
{
    global $main;
    $main->info($sql);
    echo PHP_EOL . $sql . PHP_EOL;
    echo("exec rzt:" . $pdo->exec($sql));
    echo PHP_EOL;
}

/**
 * @param $sql
 * @param $glb
 * @param PDO $pdo
 * @return array
 */
function queryPdo($sql, $pdo)
{
    global $main;
    echo PHP_EOL . $sql . PHP_EOL;
    $main->info($sql);
    global $glb;
    $glb['sql'] = $sql;
    print_r($glb);
    global $pdo; //use global var
    $stmt = $pdo->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo 'qury cnt:' . $stmt->rowCount() . PHP_EOL;
    return $rows;
    // return array($pdo, $rows);
}