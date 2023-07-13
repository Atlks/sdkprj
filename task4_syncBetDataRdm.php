<?php
// 随机扫描法

$limit = 1;  //配置项，每次抓取的数量


//session_start(); // start session
$sql = "
select * from bet_records where id not in (    
select id from    bet_record_ext where sync_flag = 1) 
 order by rand()  limit $limit ;
 
";
echo $sql;

//die();


require "syncBetDataCore.php";