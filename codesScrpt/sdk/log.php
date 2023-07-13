<?php
//配置日志文件路径
$logfile = __DIR__ . '/logs/app.log';


require __DIR__ . "/../vendor/autoload.php";

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$main = new Logger('main');
$main->pushHandler(new StreamHandler($logfile));

$main->pushHandler(new StreamHandler('php://stdout', $level = Logger::DEBUG,
    $bubble = true));
