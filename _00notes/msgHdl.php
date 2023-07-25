<?php 

//  //  C:\phpstudy_pro\Extensions\php\php7.4.3nts\php.exe    C:\w\jbbot\async.php

sleep(8);
//  //  C:\phpstudy_pro\Extensions\php\php7.4.3nts\php.exe    C:\w\jbbot\async.php
$chat_id=-960237539;
$bot_token="5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA";

require __DIR__ . '/vendor/autoload.php';
$bot = new \TelegramBot\Api\BotApi($bot_token);
//$bot->sendmessage($chat_id, "hahtxt");

$txt= "task1 msg,slp+9";
$url_tmp="https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=$txt";
echo $url_tmp;

echo file_get_contents($url_tmp);

?>

