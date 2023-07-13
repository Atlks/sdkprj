<?php

//  \bin\php\php7.1.9\php  \ATI\PhpstormProjects\apiprj\tmrRefrsParam.php -t 1 -b task2.php
// \bin\php\php7.1.9\php  \ATI\PhpstormProjects\apiprj\tmrRefrsParam.php
//  Workerman version:3.5.25          PHP version:5.6.31

require_once(__DIR__ . '/Workerman/Autoloader.php');  //. 
require_once "conn.php";


use Workerman\Worker;
use Workerman\Lib\Timer;

echo "接收到{$argc}个参数";
print_r($argv);
$taskfile = $argv[1];
$time_interval = (int)$argv[2];
//-----------------tier
$task = new Worker();

echo 'cccc';
$task->onWorkerStart = function ($taskObj) {

    global $time_interval;
    $timer_id = Timer::add($time_interval,
        function () {
            global $taskfile;

            //   echo "taskfile is :". $taskfile;
            //   require( $taskfile);  //req file task
            // echo time()."123\r\n";

        }

    );

};

// 运行所有workers

Worker::runAll();
