// 配置的定时时长与 任务脚本
timeout = 1500;
taskfile = 'task4_syncBetDataRdm.php'


//
chmod
777 / Users / ati / Desktop / prj2hzSyncNewec / 2
hz - sync - newec / timer_mac
// /Users/ati/Desktop/prj2hzSyncNewec/2hz-sync-newec/timer_mac task_test.php 3
var phpExe = '/Applications/MxSrvs/bin/php/bin/php';
phpExe = 'php ';
setInterval(intervalFunc, timeout);

//   composer create-project --prefer-dist yiisoft/yii2-app-basic basic
// php  composer.phar  require yiisoft/yii2-app-basic
// php  composer.phar  require  monolog/monolog
// php  composer.phar  require mtdowling/cron-expression
// php  composer.phar  require peppeocchi/php-cron-scheduler
// /Applications/MxSrvs/bin/php/bin/php composer.phar require mtdowling/cron-expression

function intervalFunc() {

    // \Users\ATI\PhpstormProjects\apiprj\task3_syncBetData.php
    console.log('timer start now!');
    var exec = require('child_process').exec;

    exec(phpExe + ' ' + taskfile, function (err, stdout, stderr) {
        if (err) {
            console.log('get  api error:' + stderr);
        } else {

            //  var data = JSON.parse(stdout);
            console.log(stdout);
        }
    });
}

