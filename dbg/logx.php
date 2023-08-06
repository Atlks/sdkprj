

<?php



tttt(123456);

function  tttt($msg)
{
    log_info(__FILE__.":".__LINE__." f:".__FUNCTION__." m:".__METHOD__);
    log_info($msg);
}
function  log_info($msg)
{

   // $msg="";
    $f= date("Y-m-d H")."log1221.log";
    file_put_contents($f, json_encode($msg,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) .PHP_EOL,FILE_APPEND);

}

