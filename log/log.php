<?php


// C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe  C:\w\sdkprj\log\log.php

$content="111155";
$logf=__DIR__."/".date("Y-m-d h")."log728.txt";
echo $logf;
file_put_contents($logf,$content.PHP_EOL, FILE_APPEND);