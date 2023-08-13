<?php



//  php  C:\modyfing\jbbot\app\timer.php

global  $tasksList;
$tasksList = [];




//-----test 
$f = function () {
   // sleep(10);
    echo 55555555555555;
    echo date("Y-m-d G:H:s");
     echo PHP_EOL;
};
timer_add("tsk11", 5, $f);

$f2 = function () {
    echo 222222222222222222;
    echo date("Y-m-d G:H:s");
    echo PHP_EOL;
};
timer_add("tsk11", 2, $f2);


Worker_runAll();


function timer_add($tskname, $sec, $f, $forever = false)
{
 //   var_dump( date("Y-m-d G:H:s"));
    $task = [];
    $task['name'] = $tskname;
    $task['f'] = $f;
    $task['timSec'] = $sec;
    $task['start datetime'] = date("Y-m-d G:H:s");
    $task['start timestamp'] = time();
    $task['next_exec_datetime'] = date("Y-m-d G:H:s", strtotime("+" . $sec . " seconds"));
    $task['next_exec_timestamp'] = time() + $sec ;

 //   var_dump($task);
    global  $tasksList;
    $tasksList[] = $task;
}

function Worker_runAll()
{
    while (true) {
        global  $tasksList;
        foreach ($tasksList as &$task) {
          //  var_dump(time());
          //  var_dump($task['next_exec_timestamp']);
            $isPass=time() >   $task['next_exec_timestamp'];
          //  var_dump($isPass);
            if ($isPass)
            {
                $sec=$task['timSec'] ;
                $task['next_exec_timestamp'] = time() + $task['timSec']  ;
                $task['next_exec_datetime'] = date("Y-m-d G:H:s", strtotime("+" . $sec . " seconds"));
                $task['f']();

            }


          //  $task['next_exec_timestamp'] = time() + 3  ;
          //  var_dump( $task);
        }

      //  var_dump($tasksList);die();
      usleep(100*1000);  //100ms
    


     //   var_dump($tasksList);
    }
}
