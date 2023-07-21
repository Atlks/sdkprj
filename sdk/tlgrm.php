<?php



function sendmsg($bot_token,$chat_id, $msg)
{
    $url_tmp = "https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=".urlencode($msg);
    echo $url_tmp;

    echo file_get_contents($url_tmp);
}

function replaymsg($bot_token,$chat_id, $msg,$rplmsgid)
{
    $url_tmp = "https://api.telegram.org/bot$bot_token/sendMessage?reply_to_message_id=$rplmsgid&chat_id=$chat_id&text=".urlencode($msg);
    echo $url_tmp;

    echo file_get_contents($url_tmp);
}
