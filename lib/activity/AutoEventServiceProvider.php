<?php

/**
 * 注册监听事件
 *
 * 注册监听器相关程序
 *
 *
 */
class AutoEventServiceProvider extends \Illuminate\Support\ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Booting,这边只是初始化
     */
    public function boot() {
        $this->bootEvent();
    }

    /**
     * Register the commands
     *
     * @return void
     */
    public function register() {

    }

    /**
     * 注册事件相关
     *
     */
    protected function bootEvent() {
//        $classes = ActivityConditionClass::findAllValidEvent();
//        foreach ($classes as $class) {
//            $event = $class['event'];
//            $this->app['events']->listen($event, function($user_id, $data = []) use ($event) {
//                Queue::push('EventTaskQueue', ['event'=>$event, 'user_id'=>$user_id, 'data'=>$data], 'activity');
//            });
//        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

}
