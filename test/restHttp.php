<?php
//  Workerman version:3.5.25          PHP version:5.6.31
echo "hhh";
echo(__DIR__);
require_once(__DIR__ . '/Workerman/Autoloader.php');  //. 

//die();
// require_once( __DIR__ . '/Workerman/Autoloader.php');

use Workerman\Worker;


// #### http worker ####

$http_worker = new Worker("http://0.0.0.0:80");


$http_worker->count = 4;


// 接收数据时发出

$http_worker->onMessage = function ($connection, $data) {

    //$_GET、$_POST、$_COOKIE、$_SESSION、$_SERVER、$_FILES都是可用的

    var_dump($_GET, $_POST, $_COOKIE, $_SESSION, $_SERVER, $_FILES);

    // 发送数据给客户端
    if ($_SERVER["REQUEST_URI"] == "/api1")

        $connection->send("hello world \n");

    if ($_SERVER["REQUEST_URI"] == "/api2")
        $connection->send("api2 \n");

    if ($_SERVER["REQUEST_URI"] == "/api2") {
        $connection->send("api2 \n");
    }
    $o['id'] = '123333';
    $o['key'] = 'k132233';
    $connection->send(json_encode($o));


    //$connection->flush();
    $connection->close();
    echo "finis this process..";
};


// 运行所有workers

Worker::runAll();

echo "ff";