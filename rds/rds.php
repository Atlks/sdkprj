




<?php

//  C:\phpstudy_pro\Extensions\php\php7.4.3nts\php.exe   C:\w\sdkprj\rds\rds.php



  
//连接本地的 Redis 服务
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
echo "Connection to server successfully";
//设置 redis 字符串数据
$redis->set("tutorial-name", "Redis tutorial");
// 获取存储的数据并输出
echo "Stored string in redis:: " . $redis->get("tutorial-name");
?>