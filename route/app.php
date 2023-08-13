<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');

Route::get('go','index/gogo');
Route::get('start','Gamelogic/start');
//Route::get('startSsc','Gamelogic/startSsc');
Route::get('stop','Gamelogic/stop');
Route::get('push','Gamelogic/push');
Route::get('test','Gamelogic/test');

Route::get('image','index/getUpdate');

Route::get('process_message','processMessage/index');
Route::post('process_message','processMessage/index');

Route::post('handle','Handle/index');
Route::get('handleUpdates', 'HandleUpdates/index');


Route::get('setHook','index/setHook');
Route::get('hookinfo','index/hookinfo');