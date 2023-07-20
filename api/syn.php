<?php
//文件注释：：本文件
//初始化日志和db组件
//require "cfg.php";
//---------------------------------数据库配置  默认从环境变量读取
$showDbgEcho=true;

include __DIR__."/envTestSuport.php";
$mysql_conf['host'] = getenv("hostname");
$mysql_conf['db'] = getenv("database");
$mysql_conf['db_user'] = getenv("username");
$mysql_conf['db_pwd'] = getenv("password");
$mysql_conf['port'] = getenv("hostport");
if (file_exists(__DIR__."/../localtest99")) {
    $mysql_conf['db_user']='bocat';
}

var_dump_local( '$mysql_conf:'.json_encode($mysql_conf) );
// // error_log(json_encode($mysql_conf));

/*
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
*/

//------------------------ini db sys
$dbstr = "mysql:host=" . $mysql_conf['host'] . ";port=" . $mysql_conf['port'] . ";dbname=" . $mysql_conf['db'];
// // error_log('$mysql_conf:'.json_encode($mysql_conf));
var_dump_local($dbstr); // for secury only dbg can open
global  $pdo;
$pdo = new PDO($dbstr, $mysql_conf['db_user'], $mysql_conf['db_pwd']); //创建一个pdo对象
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

var_dump_local($pdo);

$pdo->exec("set names 'utf8'");
function var_dump_ati($o){
    global  $showDbgEcho;
    //   if($showDbgEcho)
    //  echo 'file_exists(../localtest)：：：'.file_exists(__DIR__."/../localtest");
        if (file_exists(__DIR__."/../localtest99"))
            var_dump($o);

}
function var_dump_local($o){
            global  $showDbgEcho;
            //   if($showDbgEcho)
            //  echo 'file_exists(../localtest)：：：'.file_exists(__DIR__."/../localtest");
                if (file_exists(__DIR__."/../localtest99"))
                    var_dump($o);

}
$logfile78a = __DIR__ . "/logs/log78.log";
/**
 * @param $sql
 * @param PDO $pdo
 */
function exec_sql($sql, $pdo)
{
    echo "<p>\n".$sql."<p>\n";
    global $main;
   // $main->info($sql);
    if (file_exists(__DIR__."/../localtest"))
         echo "<p>\n".$sql."<p>\n";
 global  $logfile78a;
    // error_log($sql,3, $logfile78a);
    // error_log()
    $exec = $pdo->exec($sql);
    echo("<p>\n exec rzt:" . $exec."<p>\n");
    echo PHP_EOL;
    return $exec;
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
    var_dump_local( PHP_EOL . $sql . PHP_EOL );
    echo  PHP_EOL . $sql . PHP_EOL."<p>";;
    global $logfile78a;
    try {
        // error_log($sql,3, $logfile78a);
    }catch (Exception $e){}

    //  $main->info($sql);
    global $glb;
    $glb['sql'] = $sql;
    var_dump_local($glb);
    // error_log($sql);
    global $pdo; //use global var

// works regardless of statements emulation

//    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);

    $stmt = $pdo->query($sql);
    // error_log('$stmt = $pdo->query($sql)::'.json_encode($stmt)    );
  //  $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo 'qury cnt:' . $stmt->rowCount() . PHP_EOL."<p>";
    var_dump_local( 'qury cnt:' . $stmt->rowCount() . PHP_EOL );
    return $rows;
    // return array($pdo, $rows);
}
function pdo_exec($sql )
{
    global $main;
    var_dump_local( PHP_EOL . $sql . PHP_EOL );
    //  $main->info($sql);
    global $glb;
    $glb['sql'] = $sql;
    var_dump_local($glb);
    global $pdo; //use global var
   return  $pdo->exec($sql);




    // return array($pdo, $rows);
}

function pdo_query($sql)
{
    global $main;
    var_dump_local( PHP_EOL . $sql . PHP_EOL );
    //  $main->info($sql);
    global $glb;
    $glb['sql'] = $sql;
    var_dump_local($glb);
    global $pdo; //use global var
    $stmt = $pdo->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    var_dump_local( 'qury cnt:' . $stmt->rowCount() . PHP_EOL );
    return $rows;
    // return array($pdo, $rows);
}

/**
 * @param $sql
 * @param $pdo
 * @return mixed
 */
function fetchAll_queryRows($sql, $pdo)
{
    global $main;
    var_dump_local( PHP_EOL . $sql . PHP_EOL );
    //  $main->info($sql);
    global $glb;
    $glb['sql'] = $sql;
    var_dump_local($glb);
    global $pdo; //use global var
    $stmt = $pdo->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    var_dump_local( 'qury cnt:' . $stmt->rowCount() . PHP_EOL );
    return $rows;
    // return array($pdo, $rows);
}

/**query scanl val...tsasyon biaolyeo
 * @param $sql
 * @param $pdo
 * @return mixed
 */
function fetchColumnVal($sql)
{
 //   global $pdo;
    global $main;
    var_dump_local( PHP_EOL . $sql . PHP_EOL );
    // error_log($sql);
    //  $main->info($sql);
    global $glb;
    $glb['sql'] = $sql;
    var_dump_local($glb);
    global $pdo; //use global var
    $stmt = $pdo->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $val = $stmt->fetchColumn();
    var_dump_local( PHP_EOL .' fetchColumn rzt:'. $val  . PHP_EOL );
    // error_log('$stmt->fetchColumn()::'.$val);
    return $val;
    // return array($pdo, $rows);
}