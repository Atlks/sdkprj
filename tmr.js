// 配置的定时时长与 任务脚本
let timeout = 1500;
var taskfile = 'task3_syncBetData.php'
setInterval(intervalFunc, timeout);


function intervalFunc() {

    // \Users\ATI\PhpstormProjects\apiprj\task3_syncBetData.php
    console.log('timer start now!');
    var exec = require('child_process').exec;

    exec('php ' + taskfile, function (err, stdout, stderr) {
        if (err) {
            console.log('get  api error:' + stderr);
        } else {

            //  var data = JSON.parse(stdout);
            console.log(stdout);
        }
    });
}

