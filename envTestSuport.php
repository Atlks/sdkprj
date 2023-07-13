<?php

// DB_HOST=172.16.110.170;DB_PORT=3306;DB_USER=root;DB_PASSWORD=123456;DB_NAME=version5
//defined('_VALID') or die('Restricted Access!');  DB_USER=root;DB_PASSWORD=123456;DB_NAME=version5
// cfg env var in file

//测试用配置环境变量 在ide或文件，注意不能有空格   本地测试可以打开此开关
$localdebg = false;
$localdebg = true;
if (file_exists("../localtest")) {
    putenv('DB_USER=root');
    putenv('DB_PASSWORD=123456');
    putenv('DB_HOST=172.16.110.170');
    putenv('DB_NAME=version5');
    putenv('DB_PORT=3306');

}

//一般dev  uat test fac等环境
//php composer.phar require peppeocchi/php-cron-scheduler
/**
 * $mysql_conf = array(
 * 'host' => 'localhost',
 * 'db' => 'mysql',
 * 'db_user' => 'root',
 * 'db_pwd' => '',
 * 'port'=>3306
 * );
 *
 * $mysql_conf_dev= array(
 * 'host' => '172.16.110.170',
 * 'db' => 'version5',
 * 'db_user' => 'root',
 * 'db_pwd' => '123456',
 * 'port'=>3306,
 * 'cff'=>1
 * );
 */


