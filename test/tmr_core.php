<?php


//  Workerman version:3.5.25          PHP version:5.6.31

require_once(__DIR__ . '/Workerman/Autoloader.php');  //. 

use Workerman\Worker;
use Workerman\Lib\Timer;


echo "----\r\n";
//-----------------tier
$task = new Worker();

$task->onWorkerStart = function ($task) {

    // 2.5秒

    $time_interval = 2.5;

    $timer_id = Timer::add($time_interval,

        function () {
            //  require_once('task1.php');
            //  http://localhost/
            echo "Timer run\n";
            //  task1();

        }

    );

};

// 运行所有workers

Worker::runAll();
