<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit03fa64cac47e4f0074e361daf66dc689
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TelegramBot\\Api\\' => 16,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
        'G' => 
        array (
            'GO\\' => 3,
        ),
        'C' => 
        array (
            'Cron\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TelegramBot\\Api\\' => 
        array (
            0 => __DIR__ . '/..' . '/telegram-bot/api/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
        'GO\\' => 
        array (
            0 => __DIR__ . '/..' . '/peppeocchi/php-cron-scheduler/src/GO',
        ),
        'Cron\\' => 
        array (
            0 => __DIR__ . '/..' . '/mtdowling/cron-expression/src/Cron',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit03fa64cac47e4f0074e361daf66dc689::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit03fa64cac47e4f0074e361daf66dc689::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit03fa64cac47e4f0074e361daf66dc689::$classMap;

        }, null, ClassLoader::class);
    }
}
