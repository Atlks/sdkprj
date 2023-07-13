// 配置的定时时长与 任务脚本
let timeout = 1500;
var taskfile = 'task1.php';

setInterval(() => {
        console.log('timer start now!');
        require('child_process').exec('php ' + taskfile, (err, stdout, stderr) => {
            //  var data = JSON.parse(stdout);
            console.log(stdout)
        });
    }
    , timeout);


//  Program\node.exe  \ATI\PhpstormProjects\apiprj\tmr_smp.js


/**/


/*
setInterval(  ()=>{


    console.log('timer start now!');

}
, timeout);
*/