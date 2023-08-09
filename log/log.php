<?php


// C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe  C:\w\sdkprj\log\log.php

$content = "111155";
$logf = __DIR__ . "/" . date("Y-m-d h") . "log728.txt";
echo $logf;
//file_put_contents($logf,$content.PHP_EOL, FILE_APPEND);

global  $logfile;
$logfile = "lg748.log";


try {


    override_function('m1', '$a', 'echo "DOING TEST"; return $a * $b;');
    m1(1235);  //lign exe f n param

    function m11($prm)
    {
    }
  


    log_info("select from db");

    echo 999;
} catch (Throwable $exception) {

    var_dump($exception);
    $j = json_encode($exception, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    log_err("----------------errrrr---------------------------");
    log_err("errmsg:" . $exception->getMessage());
    log_err("file_linenum:" . $exception->getFile() . ":" . $exception->getLine());

    //   \think\facade\Log::error("errtrace:".$exception->getTrace());
    log_err("errtraceStr:" . $exception->getTraceAsString());
    log_err("----------------errrrr finish---------------------------");
}


function log_err($content)
{
    global  $logfile;
    file_put_contents($logfile, $content . PHP_EOL, FILE_APPEND);
}

function log_info($content)
{
    global  $logfile;
    file_put_contents($logfile, $content . PHP_EOL, FILE_APPEND);
}



function m1($prm)
{

    $lineNumStr =  __METHOD__ . json_encode(func_get_args()) . "  " . __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__;
    //$logtxt = " dwijyo() betnumL:" . $betContext . "  kaijnum:" . $kaij_num  . $lineNumStr;

    log_info($lineNumStr);
    var_dump("m1exe");

    //....

}
