<?php
echo 111;

error_reporting(E_ALL);




function runx($rb){
    echo 22;
    
    $pid = pcntl_fork();
   // if($pid > 0){
    //    pcntl_wait($status);
//父进程和子进程都  会执 
// 
// 
echo "pid::".$pid;
    if ($pid == -1) {
        //错误处理：创建子进程失败时返  回-1.
        die('could not fork');
    } else if ($pid) {   //parent task
        //父进程会得到子进程号，所以这里是父进程执行的逻辑
        pcntl_wait($status); //等待子进程中断，防止子进程成为僵尸进程。
    } else {  //pid==0   subtask
        //子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
        // 
           $rb();;
    }
    


}



$time_out = 3;
 
$time_out = 3;
runx(function() use ($time_out){
    //这里写我们要执行的代码
    // 
    sleep($time_out);
    echo 999999999999999999;
   
});


while (true) {
    
    echo 888;

    
 sleep(1);
}
