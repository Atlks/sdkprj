<?php 

//  C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe  composer.phar require amphp/react-adapter

//  C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe  composer.phar require  spatie/async
//  //  C:\phpstudy_pro\Extensions\php\php7.4.3nts\php.exe    C:\w\jbbot\async.php
echo 11;
// exec('start node  timer_php.js 3 C:\w\jbbot\task1.php  ');
echo 22;
//exec('start node  timer_php.js 9  C:\w\jbbot\task2.php');
echo 99;

require 'vendor/autoload.php';


require_once(__DIR__.'/Workerman/Autoloader.php') ;  //. 


use \Workerman\Worker; use \Workerman\Lib\Timer; require_once './Workerman/Autoloader.php';

$task = new Worker(); // 开启多少个进程运行定时任务，注意多进程并发问题
 $task->count = 1;
  $timer_id=1;  $timer_id22=1;
$task->onWorkerStart = function($task) {

    // 每2.5秒执行一次
      $time_interval = 2.5;
   // global $timer_id;
    // 要想$timer_id能正确传递到回调函数内部，$timer_id前面必须加地址符 &
      $timer_id =   Timer::add(3, function()   {

          echo "task run\n";
          global $timer_id;
          Timer::del($timer_id);
    });
    global $timer_id22;
    $timer_id22 =   Timer::add(1, function()   {

        echo "task2 run\n";
        global $timer_id22;
        Timer::del($timer_id22);
    });

};
// 运行worker

Worker::runAll();


echo 11;
echo 9999;

?>

