<?php

//  C:\phpstudy_pro\Extensions\php\php7.4.3nts\php.exe    C:\w\jbbot\tlgrm.php
$chat_id=-960237539;
$bot_token="5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA";

require __DIR__ . '/vendor/autoload.php';
$bot = new \TelegramBot\Api\BotApi($bot_token);
//$bot->sendmessage($chat_id, "hahtxt");

 

$fname=$_SERVER ['argv'][1];

$msgg=file_get_contents($fname.".json");
$json = json_decode($msgg, true); // decode the JSON into an associative array
$msg_txt=$json ['text'];



if ($msg_txt == "余额") {
    $uid=$json["from"]["id"];
    $fstname=$json["from"]["first_name"];
    $sendmsg=urlencode("用户ID: $uid \r\n用户名:  $fstname \r\n余额: 0 \r\n输赢: 0");
    $msg_url_tlgrm= "https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=$sendmsg";
echo $msg_url_tlgrm ;
//send
file_get_contents($msg_url_tlgrm);

}



function sendmsg($url,$msg)
{
    $url_tmp="https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=$msg";
echo $url_tmp;

echo file_get_contents($url_tmp);
}
//{"id":-960237539,"title":"grptst","type":