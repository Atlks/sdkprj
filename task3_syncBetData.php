<?php
//从头顺序处理fifo  lifo  扫描
$limit = 1;  //配置项，每次抓取的数量

//todo  youxie 玩法不需要传递到，，，过滤掉。。
// order by order
$sql = <<<EOF
select * from bet_records where id not in (    select id from    bet_record_ext where sync_flag = 1) 
 order by created_at desc limit   $limit ;
 
       //     select * from bet_records where sync_flag is null  order by created_at desc limit 3;
EOF;


require "syncBetDataCore.php";