<?php



$errdir='/www/wwwroot/bot.521ck.vip/app/controller/';
$errdir='';
function exceptions_error_handler($errno, $message, $filename, $lineno) {
    $ex229['errno']=$errno;
    $ex229['message']=$message;
    $ex229['filename']=$filename;
    $ex229['lineno']=$lineno;
    $j=json_encode($ex229);
    global $errdir;
    file_put_contents( $errdir.date('Y-m-d H')."exGlb304_55808.txt",  $j.PHP_EOL, FILE_APPEND);
}




set_error_handler('exceptions_error_handler');
ini_set('display_errors', 'on');
error_reporting(E_ALL);
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