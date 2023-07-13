<?php

require "conn.php";
/*
require __DIR__ . '/vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$main = new Logger('main');
$main->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log'));

$main->pushHandler(new StreamHandler('php://stdout', $level = Logger::DEBUG,
    $bubble = true));
*/
echo "\n";
$main->info('Information message...');
$main->debug('dbg message');