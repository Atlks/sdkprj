<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;

//$_GET['s']='gamelogic/fff';
//      //echo $text;   http://localhost:888/index2.php?s=gamelogic/fff
//  C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe C:\项目最新\jbbot\public\index2.php  gamelogic/fff
//   C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe C:\项目最新\jbbot\public\index2.php   handle/processMessageTest
//   $fname = $_SERVER['argv'][1];
$_GET['s'] = $_SERVER['argv'][1];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

var_dump($_GET['s']);
require __DIR__ . '/../vendor/autoload.php';


error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
define('NO_CACHE_RUNTIM', True);

$errdir = '/www/wwwroot/ssc.521ck.vip/app/controller/';
$errdir = '';






ini_set('display_errors', 'on');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
ini_set("log_errors", 1);
ini_set("error_log", $errdir . date('Y-m-d H') . "lg142_errLog.txt");


set_error_handler("think\\error_handler142");
register_shutdown_function('think\\shutdown_hdlr');
function error_handler142($errno, $message, $filename, $lineno)
{
    $ex229['errno'] = $errno;
    $ex229['message'] = $message;
    $ex229['filename'] = $filename;
    $ex229['lineno'] = $lineno;
    $j = json_encode($ex229);
    global $errdir;
    file_put_contents($errdir . date('Y-m-d H') . "lg142_errHdlr_.log",  $j . PHP_EOL, FILE_APPEND);
    \think\facade\Log::info($j);
    var_dump($j); //also echo throw 
    throw $j;
}

function shutdown_hdlr()
{
    // print_r(error_get_last());
    //cant show echo ,bcs of ok also output
    // 
    $errLast = error_get_last();
   // var_dump($errLast);
    if ($errLast) {

        if ($errLast['line'] == "")
            return;
    //    echo  PHP_EOL . PHP_EOL . "-----------shutdown echo--------------------" . PHP_EOL;
        global $errdir;
        $j = json_encode($errLast, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents($errdir . date('Y-m-d H') . "lg142_shtdwnHdlr_.log",  $j . PHP_EOL, FILE_APPEND);
        //print_r(error_get_last());
   //     var_dump($errLast); //also echo throw 
        \think\facade\Log::info (  json_encode($errLast) );
     //   echo  PHP_EOL . PHP_EOL . "-----------shutdown echo finish--------------------" . PHP_EOL;
     //   echo 'Script executed with finish....', PHP_EOL;
    }
}



function var_dumpx($o)
{
    var_dump($o);
}

define('NO_CACHE_RUNTIME', True);

// 执行HTTP应用并响应
$http = (new App())->http;

$response = $http->run();

$response->send();

$http->end($response);
