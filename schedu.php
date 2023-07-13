<?php require_once __DIR__ . '/vendor/autoload.php';

use GO\Scheduler;

// Create a new scheduler
$scheduler = new Scheduler();

// ... configure the scheduled jobs (see below) ...
echo 'aa' . PHP_EOL;

$scheduler->php('\task1_test.php');


$scheduler->php(
    '\task1_test.php', // The script to execute
    'php', // The PHP bin
    [
        '-c' => 'ignore',
        '--merge' => null,
    ],
    'myCustomIdentifier'
);
$scheduler->call(function () {
    echo 'aa' . PHP_EOL;
    return true;
});

$scheduler->php('task1_test.php')->everyMinute();
// Let the scheduler execute jobs which are due.
$scheduler->run();
