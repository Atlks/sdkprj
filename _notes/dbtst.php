<?php

//  C:\phpstudy_pro\Extensions\php\php7.4.3nts\php.exe   C:\w\jbbot\dbtst.php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';
include   __DIR__.'/vendor/topthink/think-helper/src/helper.php';

//$message = \think\facade\Db::query("select * from message where name='我的报备' ");
// 
// 
 // 连接数据库
$db = new PDO('mysql:host=localhost;dbname=jb_bot;charset=utf8mb4', 'root', 'root');

// 执行查询
 
 $rows=fetchAll_queryRows("select * from message where name='我的报备' " ,$db);
dump( $rows[0]);

echo ($rows[0]['message']);
  

function fetchAll_queryRows($sql, $pdo)
{
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

function var_dump_local($o){
    global  $showDbgEcho;
    //   if($showDbgEcho)
    //  echo 'file_exists(../localtest)：：：'.file_exists(__DIR__."/../localtest");
    //    if (file_exists(__DIR__."/../localtest99"))
           var_dump($o);

}

// 调用tp提供的dump方法，友好的输出查询结果
dump($teachers);