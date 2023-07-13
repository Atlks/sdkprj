<?php


//  Workerman version:3.5.25          PHP version:5.6.31

require_once(__DIR__ . '/Workerman/Autoloader.php');  //. 
require_once "conn.php";


use Workerman\Worker;
use Workerman\Lib\Timer;

//echo phpinfo();
//die();
function task1()
{

    $sql = <<<EOF
            select * from help_topic limit 10;
EOF;

    $glb['sql'] = $sql;
    print_r($glb);
    global $pdo; //use global var
    $sth = $pdo->query($sql);
    $rows = $sth->fetchAll();
    foreach ($rows as $row) {
        echo "\r\n";
        echo json_encode($row);
        echo "\r\n";
        $url = 'http://localhost/';
        echo $url;
        echo file_get_contents($url);
    }
    echo "\r\n";
    // echo json_encode($rows);
}

//task1();
//die();

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
