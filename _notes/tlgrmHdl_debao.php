<?php

//  C:\phpstudy_pro\Extensions\php\php7.4.3nts\php.exe    C:\w\jbbot\tlgrm.php
//$chat_id = -960237539;
$bot_token = "5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA";

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
$today = date('Y/m/d H:i:s');
$msg_tmplt=str_replace('【交易方】' ,$uname,$msg_tmplt );
$msg_tmplt=str_replace('【创建时间】' ,$today ,$msg_tmplt);
  
sendmsg($bot_token,$json['chat']['id'] ,$msg_tmplt);




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
