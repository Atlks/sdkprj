<?php

 
$errdir='/www/wwwroot/bot.521ck.vip/app/controller/';
$errdir='';
function exceptions_error_handler($errno, $message, $filename, $lineno) {

    $ex229['errno']=$errno; //错误等级 err lev
    $ex229['message']=$message;
    $ex229['filename']=$filename;
    $ex229['lineno']=$lineno;
    $j=json_encode($ex229);
    global $errdir;
    file_put_contents( $errdir.date('Y-m-d H')."exGlb304_55808.txt",  $j.PHP_EOL, FILE_APPEND);
}




set_error_handler('exceptions_error_handler');
ini_set('display_startup_errors', 'on');
ini_set('display_errors', 'on');
error_reporting( E_ALL & ~E_NOTICE);
ini_set("log_errors", 1);
ini_set("error_log", $errdir.date('Y-m-d H')."error_log236_55808.txt");



function shutdown()
{
   // print_r(error_get_last());
   echo  PHP_EOL.PHP_EOL."-----------shutdown echo--------------------".PHP_EOL;
    if (error_get_last()) {
        global $errdir;
        $j=json_encode(error_get_last(),JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        file_put_contents( $errdir.date('Y-m-d H')."e_shutdownCatchErr_55808.txt",  $j.PHP_EOL, FILE_APPEND);
       //print_r(error_get_last());
    }
    echo  PHP_EOL.PHP_EOL."-----------shutdown echo finish--------------------".PHP_EOL;
    echo 'Script executed with finish....', PHP_EOL;
}

register_shutdown_function('shutdown');







require __DIR__ . '/vendor/autoload.php';
function exceptions_error_handler22($severity, $message, $filename, $lineno) {
    $ex229['severity']=$severity;
    $ex229['message']=$message;
    $ex229['filename']=$filename;
    $ex229['lineno']=$lineno;
    $j=json_encode($ex229);
    file_put_contents(date('Y-m-d H')."231231.txt",  $j.PHP_EOL, FILE_APPEND);
}

set_error_handler('exceptions_error_handler');
ini_set('display_errors', 'on');
error_reporting(E_ALL);
ini_set("log_errors", 1);
ini_set("error_log", date('Y-m-d H')."log236.txt");



//  C:\phpstudy_pro\Extensions\php\php7.4.3nts\php.exe   C:\w\jbbot\dbtst.php
//   C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe C:\w\jbbot\dbtst.php

 
// include   __DIR__.'/vendor/topthink/think-helper/src/helper.php';


echo date('Y-m-d H') ;
file_put_contents(date('Y-m-d H'),"111".PHP_EOL, FILE_APPEND);

$message = \think\facade\Db::query("select * from message where name='我的报备' ");
// 
// 
 // 连接数据库
$db = new PDO('mysql:host=localhost;dbname=jb_bot;charset=utf8mb4', 'root', 'root');

// 执行查询
 
 $rows=fetchAll_queryRows("select * from message where name='我的报备' " ,$db);
dump( $rows[0]);

echo ($rows[0]['message']);
  

function fetchAll_queryRows($sql, $pdo)
{
    global $main;
    var_dump_local( PHP_EOL . $sql . PHP_EOL );
    //  $main->info($sql);
    global $glb;
    $glb['sql'] = $sql;
    var_dump_local($glb);
 
    $stmt = $pdo->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    var_dump_local( 'qury cnt:' . $stmt->rowCount() . PHP_EOL );
    return $rows;
    // return array($pdo, $rows);
}

function var_dump_local($o){
    global  $showDbgEcho;
    //   if($showDbgEcho)
    //  echo 'file_exists(../localtest)：：：'.file_exists(__DIR__."/../localtest");
    //    if (file_exists(__DIR__."/../localtest99"))
           var_dump($o);

}

// 调用tp提供的dump方法，友好的输出查询结果
//dump($teachers);