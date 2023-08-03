<?php

//C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe composer.phar require telegram-bot/api 

//                        TelegramBot
//  C:\phpstudy_pro\Extensions\php\php7.4.3nts\php.exe    C:\w\jbbot\tlgrm.php
$chat_id = -960237539;
$bot_token = "6134198347:AAEdHZUkmYrpm0RHUrzZaKK9d11SiEIhSUk";   //msg 2024  msg2024_bot
$bot_token  = "6510408569:AAHrrbsKgCvklwiFje_TKPF-ABMz0kdxn2c"; // msg2025

require __DIR__ . '/vendor/autoload.php';
$bot = new \TelegramBot\Api\BotApi($bot_token);
//$bot->sendmessage($chat_id, "hahtxt");



$fname = $_SERVER['argv'][1];
$param = urldecode($fname);


$json = json_decode($param, true); // decode the JSON into an associative array

file_put_contents("732.json",json_encode($json,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
$msg_txt = $json['text'];
$msg = $json;



console_log($msg);
//bot.sendMessage(chatId, JSON.stringify(msg));

 



$xiazhuAmt = getNum_frmStr($msg_txt);
$bal = 999;

$reply = '成功投注，下注内容:' .getBetContxEcHo($msg_txt). PHP_EOL;
$uid = $msg['from']['id'];
$fstnm = $msg['from']['first_name'];
$reply = PHP_EOL . $reply . "${fstnm} --  ${uid}" . PHP_EOL;
$reply = PHP_EOL . $reply . PHP_EOL . "下注:${xiazhuAmt}" . PHP_EOL . "已押：${xiazhuAmt}" . PHP_EOL . "余额:${bal}";

$chatId = $msg['chat']['id'];
 
bot_sendMessage($chatId, $reply, $bot_token);
echo PHP_EOL;
//-------------------redisbal
$uid = $msg['from']['id'];
$cmd = `reduce_bal uid=${uid} rdcAmt=${xiazhuAmt}`;
console_log($cmd);

/**
 * 
 * function myFunc(arg) {
    process.exit(999)
}

setTimeout(myFunc, 5000, 'funky');
 */

//var_dump( getBetContxEcHo("1/大/1000") );
var_dump( getBetContxEcHo("1/2/1000") );
 function getBetContxEcHo($bet_str)
 {

    var_dump($bet_str);
    $cyo_arr = explode("/", $bet_str);
    $cyo_idex = $cyo_arr[0];
    $glb['$tozhu_arr'] = $cyo_arr;
    $glb['$cyo_idex'] = $cyo_idex;
    var_dump($glb);
    
    $cyoName_arr = ['A', 'b', 'c', 'd', 'e'];
    var_dump($cyo_idex);
    $cyoName = $cyoName_arr[$cyo_idex - 1];
    $cyo_num = $cyo_arr[1];
    
    $cyo_num_rply = "数字" . $cyo_num;
    if (!is_numeric($cyo_num))
        $cyo_num_rply = $cyo_num;   //大小单双
    return     $cyoName . "球" . $cyo_num_rply . "  " . $cyo_arr[2] . ".00";

 }

function getNum_frmStr($str)
{
    //   $str = $msg['text'];
    if (preg_match('/(\d+)[^\d]*$/', $str, $match)) {
        $number = $match[0];
    }
    return  $number;
}




function console_log($p)
{
    echo $p;
}


function bot_sendMessage($chat_id, $msg, $bot_token)
{
    $glb['__id'] = "glb";
    $glb['chat_id'] = $chat_id;
    $glb['msg'] = $msg;
    echo json_encode($glb, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    // die();  
    echo PHP_EOL;
    echo PHP_EOL;
    $msg = urlencode($msg);
    $url_tmp = "https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=$msg";
    echo $url_tmp;
    echo PHP_EOL;
    echo PHP_EOL;
    echo file_get_contents($url_tmp);
}


function sendmsg($chat_id, $msg)
{
    $url_tmp = "https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=$msg";
    echo $url_tmp;

    echo file_get_contents($url_tmp);
}
//{"id":-960237539,"title":"grptst","type":


function sendmsg_reply()
{
    $rplmsgid = $json['message_id'];
    $chat_id = $json['chat']['id'];
    $msg = $msg_tmplt;
    echo $url_tmp;
    echo PHP_EOL;
    echo PHP_EOL;
    $url_tmp = "https://api.telegram.org/bot$bot_token/sendMessage?reply_to_message_id=$rplmsgid&chat_id=$chat_id&text=" . urlencode($msg);
    echo PHP_EOL;
    echo PHP_EOL;
    echo file_get_contents($url_tmp);
}
