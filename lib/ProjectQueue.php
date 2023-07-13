<?php
class ProjectQueue {
    
    protected $key = 'waiting_projects';
    
    protected static $instance ;
    
    function __construct() {
        Queue::setDefaultDriver('redis');
        pr(Queue::pop('prjs'));
//        pr(Config::get('cache.prefix'));
//        Cache::setDefaultDriver('redis');
//        $result = Cache::get('a');
//        pr($result);
//        self::$instance = new Redis();
////        pr($this->app['config']['database.connections']);
////        pr(Config::get('database.redis.default'));
//        $config = Config::get('database.redis.default');
////        exit;
//        $host = $config['host'];
//        $port = $config['port'];
////        pr(self::$instance->connect($host,$port,2));
////        exit;
//        try {
//            self::$instance->success = intval(self::$instance->connect($host,$port,2));
//        } catch (Exception $e)
//        {
//            file_put_contents("/tmp/redis.exception", $e->getMessage(),FILE_APPEND);
//        }

    }
    
}