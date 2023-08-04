<?php




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
 
/**
 * 
 * $chat_id=-960237539;
$bot_token="5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA";

require __DIR__ . '/vendor/autoload.php';
$bot = new \TelegramBot\Api\BotApi($bot_token);
//$bot->sendmessage($chat_id, "hahtxt");

$txt= "hahtxt";
$url_tmp="https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=$txt";
echo $url_tmp;

echo file_get_contents($url_tmp);
 * 
 */
//  C:\phpstudy_pro\Extensions\php\php7.4.3nts\php.exe    C:\w\jbbot\tlgrm.php


//{"id":-960237539,"title":"grptst","type":