<?php



ini_set('display_errors', 'on');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
ini_set("log_errors", 1);
ini_set("error_log", $errdir . date('Y-m-d H') . "lg142_errLog.txt");


function test752()
{
    return 1;
}




set_error_handler('error_handler142');  //this only for log dbg ,,,if local dbg ,,console dbg is more easy
register_shutdown_function('shutdown_hdlr');
set_exception_handler('ex_hdlr');
 

function ex_hdlr($exception)
{
  //  \think\facade\Log::info (  json_encode($exception) );
       var_dump($exception);

}


function error_handler142($errno, $message, $filename, $lineno) {
    $ex229['errno']=$errno;
    $ex229['message']=$message;
    $ex229['filename']=$filename;
    $ex229['lineno']=$lineno;
    $j=json_encode($ex229);
    global $errdir;
    file_put_contents( $errdir.date('Y-m-d H')."lg142_errHdlr_.log",  $j.PHP_EOL, FILE_APPEND);
    var_dump( $j); //also echo throw 
    
    
}

function shutdown_hdlr()
{
      //cant show echo ,bcs of ok also output  ...not good for api output json mode. must no other output ,only json
   // print_r(error_get_last());
  
    if (error_get_last()) {
        echo  PHP_EOL.PHP_EOL."-----------shutdown echo--------------------".PHP_EOL;
        global $errdir;
        $j=json_encode(error_get_last(),JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        file_put_contents( $errdir.date('Y-m-d H')."lg142_shtdwnHdlr_.log",  $j.PHP_EOL, FILE_APPEND);
       //print_r(error_get_last());
       var_dump( error_get_last()); //also echo throw 
       echo  PHP_EOL.PHP_EOL."-----------shutdown echo finish--------------------".PHP_EOL;
       echo 'Script executed with finish....', PHP_EOL;
    }
   
}