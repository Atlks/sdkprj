<?php

//  C:\phpstudy_pro\Extensions\php\php7.4.3nts\php.exe    C:\w\jbbot\tlgrm.php
//$chat_id = -960237539;
$bot_token = "6367905200:AAH0KUIu5uVKKCPWYi-aClaNW4lK9p-Rsps";  //chkbt

require __DIR__ . '/vendor/autoload.php';

  
$msgg = file_get_contents(__DIR__."/tmp/". $_SERVER['argv'][1].".json");
echo $msgg;
$json = json_decode($msgg, true); // decode the JSON into an associative array
$msg_txt = $json['text'];
echo $msg_txt ;


  
// db
$connstr=['mysql:host=localhost;dbname=jb_bot;charset=utf8mb4', 'root', 'root'];
$qry="select * from message where name='$msg_txt' ";
$rows= fetchAll_queryRows_pdo($qry,$connstr);
$msg_tmplt=$rows[0]['message'];

//  replce
$uname='@'.$json['from']['username'];
$nnkname=''.$json['from']['first_name'];
$grpname=$json['chat']['title'];
$today = date('Y/m/d H:i:s');
$msg_tmplt=str_replace('【交易方】' ,$uname,$msg_tmplt );
$msg_tmplt=str_replace('【创建时间】' ,$today ,$msg_tmplt);
$msg_tmplt=str_replace('@昵称' ,$nnkname ,$msg_tmplt);$msg_tmplt=str_replace('@grp' ,$grpname ,$msg_tmplt);
//sendmsg($bot_token,$json['chat']['id'] ,$msg_tmplt);

//replaymsg($bot_token,$json['chat']['id'] ,$msg_tmplt);

$rplmsgid=$json['message_id'];$chat_id=$json['chat']['id'];$msg=$msg_tmplt;
echo $url_tmp;
$url_tmp = "https://api.telegram.org/bot$bot_token/sendMessage?reply_to_message_id=$rplmsgid&chat_id=$chat_id&text=".urlencode($msg);
echo file_get_contents($url_tmp);




if ($msg_txt == "余额") {
    $uid = $json["from"]["id"];
    $fstname = $json["from"]["first_name"];
    $sendmsg ="用户ID: $uid \r\n用户名:  $fstname \r\n余额: 0 \r\n输赢: 0";
    echo  $sendmsg;
    $msg_urlcode= urlencode($sendmsg );
    $msg_url_tlgrm = "https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=$msg_urlcode";
    echo $msg_url_tlgrm;
    //send
    file_get_contents($msg_url_tlgrm);
}


function var_dump_local($o){
    global  $showDbgEcho;
    //   if($showDbgEcho)
    //  echo 'file_exists(../localtest)：：：'.file_exists(__DIR__."/../localtest");
    //    if (file_exists(__DIR__."/../localtest99"))
           var_dump($o);

}



function fetchAll_queryRows_pdo($sql, $pdo_conn_str)
{
    $pdo = new PDO($pdo_conn_str[0],  $pdo_conn_str[1],$pdo_conn_str[2] );
    global $main;
    var_dump_local( PHP_EOL . $sql . PHP_EOL );
    //  $main->info($sql);
    global $glb;
    $glb['sql'] = $sql;
    var_dump_local($glb);
 
    $stmt = $pdo->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    var_dump_local( 'qury cnt:' . $stmt->rowCount() . PHP_EOL );
    return $rows;
    // return array($pdo, $rows);
}




function sendmsg($bot_token,$chat_id, $msg)
{
    $url_tmp = "https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=".urlencode($msg);
    echo $url_tmp;

    echo file_get_contents($url_tmp);
}

function replaymsg($bot_token,$chat_id, $msg)
{
    $url_tmp = "https://api.telegram.org/bot$bot_token/sendMessage?reply_to_message_id=$rplmsgid&chat_id=$chat_id&text=".urlencode($msg);
    echo $url_tmp;

    echo file_get_contents($url_tmp);
}


  