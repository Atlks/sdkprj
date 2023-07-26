<?php
require_once './Workerman/Autoloader.php';
require_once(__DIR__ . '/Workerman/Autoloader.php');  //. 
use   \Workerman\Worker;
use \Workerman\Lib\Timer;





$task = new Worker(); // 开启多少个进程运行定时任务，注意多进程并发问题
$task->count = 1;
$task->onWorkerStart = function ($task) {

    // 要想$timer_id能正确传递到回调函数内部，$timer_id前面必须加地址符 &
    Timer::add(2, 'task_main');
    Timer::add(5, 'task2',array( ), false);

};
// 运行worker

Worker::runAll();




function task_main()
{


    echo "task main run\n";


}

function task2()
{

    echo "task2 run\n";
    global $timer_id22;
    //  Timer::del($timer_id22);
    //最后一个参数传递false，表示只运行一次   Timer::add(10, 'send_mail', array($to, $content), false);
}


echo 9999;

?>

