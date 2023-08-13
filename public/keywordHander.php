<?php


// php  C:\modyfing\jbbot\public\keywordHander.php
$errdir= __DIR__ . "/../runtime/";
require_once __DIR__ . "/../lib/ex.php";
$t=file_get_contents('php://input');
file_put_contents( $errdir.date('Y-m-d H')."lg142_PostHdlr_.log",  "----------------".PHP_EOL, FILE_APPEND);
file_put_contents( $errdir.date('Y-m-d H')."lg142_PostHdlr_.log",  $t.PHP_EOL, FILE_APPEND);
file_put_contents( $errdir.date('Y-m-d H')."lg142_PostHdlr_.log",  "----------finish--------".PHP_EOL, FILE_APPEND);

var_dump( urldecode("https%3A%20%2F%2Fgame.gq1sx.cc%2FkeywordHander.php"));
var_dump($t);
   $update = json_decode($t, true);;

   var_dump($update);
   $msg=$update["message"];

   $logtxt=json_encode($msg);
   file_put_contents( $errdir.date('Y-m-d H')."lg142_shtdwnHdlr_.log",  $logtxt.PHP_EOL, FILE_APPEND);
$phpexe = "php";
// $tlghr_msg_hdl = " C:\\w\\jbbot\\tlgrmHdl_temacyo.php ";
$filename = __DIR__ . "/../think";
$cmd = $phpexe ." " . $filename. "    keywdReqHdlr  " . urlencode(json_encode( $msg));
//console.log(cmd)

var_dump($cmd);
file_put_contents( $errdir.date('Y-m-d H')."lg142_cmd_.log",  $cmd.PHP_EOL, FILE_APPEND);exec($cmd);
 //system($cmd );
//passthru($cmd);
sleep(5);
echo 999999;
