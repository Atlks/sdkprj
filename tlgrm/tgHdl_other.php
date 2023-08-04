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
$msg=$json ;
 
{
    $processed=true;
    $chatId = $msg['chat']['id'];
    require_once "tlgrm.php";
    $reply_txt="cant find keywd hdl ,rcv..:".$json['text'];
    bot_sendMessage($chatId, $reply_txt, $bot_token);
}