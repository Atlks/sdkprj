<?php

declare(strict_types=1);

namespace app\controller;

use think\Request;
use think\swoole;
use app\common\GameLogic as GL;
use app\common\NNGameLogic as NNGL;
use app\model\Setting;
use app\common\helper;


function sendmessage($text)
{
    //C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe C:\项目最新\jbbot\public\index2.php   gamectrl/startssc 
    //  C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe C:\项目最新\jbbot\public\index2.php   gamelogic/start2
    // must start2 ..bcs indx inm router,so cant acc
    //echo $text;
}

class Gamectrl
{

    public function start2($issue = null)
    {
        var_dump(111);
       $this-> start($issue);
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function start($issue = null)
    {
        //开奖时间
        $show_time = Setting::find(8)->value; //10*1000;
        $gl = new GL($issue);  //comm/gamelogc
        //swoole_timer_tick(10000,function($timer_id) use($gl){
        while (true) {
            try{
                var_dump($gl->game_state);  //"start"
              
            switch ($gl->game_state) {
                case 'start':
                    if ($gl->Start()) {
                        // 下注时间
                        $bet_time = Setting::find(6)->value; //1*60*1000;
                        $bet_time = $gl->adjustTime($bet_time);
                        $start_str = $gl->lottery_no . "期开始下注-" . $bet_time / 1000 . "秒后提醒\r\n";
                        sendmessage($start_str);
                        swoole_timer_after($bet_time, function () use ($gl) {
                            $gl->game_state = 'show_waring';
                        });
                        $gl->send_notice('start');
                        //     $this->game_state = 'waiting_bet';
                    }
                    break;
                case 'show_waring':
                    $gl->Waring();
                    //封盘警告时间
                    $waring_time = Setting::find(7)->value; //30*1000;
                    $waring_time = $gl->adjustTime($waring_time);
                    $waring_str = $gl->lottery_no . "期还有" . $waring_time / 1000 . "秒停止下注\r\n";
                    sendmessage($waring_str);
                    swoole_timer_after($waring_time, function () use ($gl) {
                        $gl->game_state = 'stop_bet';
                    });
                    $gl->send_notice('waring');
                    break;
                case 'stop_bet':
                    $gl->StopBet();
                    //封盘时间
                    $stop_bet_time = Setting::find(8)->value; //10*1000;
                    $stop_bet_time = $gl->adjustTime($stop_bet_time);
                    $stop_bet_str = $gl->lottery_no . "期停止下注==" . $stop_bet_time / 1000 . "秒后开奖\n";
                    sendmessage($stop_bet_str);                    
                    swoole_timer_after($stop_bet_time, function () use ($gl) {
                        $gl->game_state = 'draw';
                    });
                    $gl->send_notice('stop');
                    break;
                case 'draw':
                    $gl->game_state = 'drawing';
                    $gl->send_notice('draw');
                    break;
                case 'drawing':
                    $draw_str = $gl->lottery_no . "期开奖中";
                    sendmessage($draw_str);
                    $gl->DrawLottery();
                    if ($gl->game_state == 'next') {
                        $show_str = $gl->lottery_no . "期开奖完毕==开始下注\r\n";
                        sendmessage($show_str);
                        $gl->send_notice('result');
                    }
                    break;
                case 'next':
                    if($gl->Next())
                    {
                        $bet_time = Setting::find(6)->value; //1*60*1000;
                        $bet_time = $gl->adjustTime($bet_time);
                        $start_str = $gl->lottery_no . "期开始下注-" . $bet_time / 1000 . "秒后提醒\r\n";
                        sendmessage($start_str);
                        swoole_timer_after($bet_time, function () use ($gl) {
                            $gl->game_state = 'show_waring';
                        });
                        $gl->send_notice('start');
                    }
                    break;
            }
        }
        catch(\TelegramBot\Api\InvalidJsonException $e){
                //return $e->getMessage();
                
        } catch (\TelegramBot\Api\HttpException $e) {
            //return $e->getMessage();
        } catch (\TypeError $e){
            //return $e->getMessage();
        } catch(\Error $e){
            //return $e->getMessage();
        }
            sleep(1);
        };
    }


        /**
         * 
         *    /index.php?s=gamelogic/startSsc
     * 开始时时踩的主循环
     *
     * @return \think\Response
     */
    public function startssc($issue=null)
    {
        var_dump(137);
      //  ;
        //开奖时间
        $show_time = Setting::find(8)->value; //10*1000;
        $gl = new   \app\common\GameLogicSsc($issue);  //comm/gamelogc
        //swoole_timer_tick(10000,function($timer_id) use($gl){
        while (true) {
            try{
                var_dump($gl->game_state);  //"start"
              
            switch ($gl->game_state) {
                case 'start':
                    if ($gl->Start()) {
                        // 下注时间
                        $bet_time = Setting::find(6)->value; //1*60*1000;
                        $bet_time = $gl->adjustTime($bet_time);
                        $start_str = $gl->lottery_no . "期开始下注-" . $bet_time / 1000 . "秒后提醒\r\n";
                        sendmessage($start_str);
                        swoole_timer_after($bet_time, function () use ($gl) {
                            $gl->game_state = 'show_waring';
                        });
                        $gl->send_notice('start');
                        //     $this->game_state = 'waiting_bet';startssc
                    }
                    break;
                case 'show_waring':
                    $gl->Waring();
                    //封盘警告时间
                    $waring_time = Setting::find(7)->value; //30*1000;
                    $waring_time = $gl->adjustTime($waring_time);
                    $waring_str = $gl->lottery_no . "期还有" . $waring_time / 1000 . "秒停止下注\r\n";
                    sendmessage($waring_str);
                    swoole_timer_after($waring_time, function () use ($gl) {
                        $gl->game_state = 'stop_bet';
                    });
                    $gl->send_notice('waring');
                    break;
                case 'stop_bet':
                    $gl->StopBet();
                    //封盘时间
                    $stop_bet_time = Setting::find(8)->value; //10*1000;
                    $stop_bet_time = $gl->adjustTime($stop_bet_time);
                    $stop_bet_str = $gl->lottery_no . "期停止下注==" . $stop_bet_time / 1000 . "秒后开奖\n";
                    sendmessage($stop_bet_str);                    
                    swoole_timer_after($stop_bet_time, function () use ($gl) {
                        $gl->game_state = 'draw';
                    });
                    $gl->send_notice('stop');
                    break;
                case 'draw':
                    $gl->game_state = 'drawing';
                    $gl->send_notice('draw');
                    break;
                case 'drawing':
                    $draw_str = $gl->lottery_no . "期开奖中";
                    sendmessage($draw_str);
                    $gl->DrawLottery();
                    if ($gl->game_state == 'next') {
                        $show_str = $gl->lottery_no . "期开奖完毕==开始下注\r\n";
                        sendmessage($show_str);
                        $gl->send_notice('result');
                    }
                    break;
                case 'next':
                    if($gl->Next())
                    {
                        $bet_time = Setting::find(6)->value; //1*60*1000;
                        $bet_time = $gl->adjustTime($bet_time);
                        $start_str = $gl->lottery_no . "期开始下注-" . $bet_time / 1000 . "秒后提醒\r\n";
                        sendmessage($start_str);
                        swoole_timer_after($bet_time, function () use ($gl) {
                            $gl->game_state = 'show_waring';
                        });
                        $gl->send_notice('start');
                    }
                    break;
            }
        }
        catch(\TelegramBot\Api\InvalidJsonException $e){
                //return $e->getMessage();
                
        } catch (\TelegramBot\Api\HttpException $e) {
            //return $e->getMessage();
        } catch (\TypeError $e){
            //return $e->getMessage();
        } catch(\Error $e){
            //return $e->getMessage();
        }
            sleep(1);
        };
    }


    public function go(Request $request)
    {
        /*
        swoole_timer_tick(1000,function() {
                echo "tick\n";
            });
*/
        $gl = new GL();


        $bet_time = Setting::find(5)->value; //1*60*1000;
        //封盘警告时间
        $waring_time = Setting::find(6)->value; //30*1000;
        //封盘时间
        $stop_bet_time = Setting::find(7)->value; //10*1000;
        //开奖时间
        $show_time = Setting::find(8)->value; //10*1000;

        //$response->end("<h1>Go</h1>");


        $gl->Start();
        $start_str = $gl->lottery_no . "期开始下注-" . $bet_time / 1000 . "秒后提醒\r\n";
        sendmessage($start_str);

        /*
       swoole_timer_tick(1000,function(){
            echo "tick:" . "\n";
            //sendmessage("1秒");
        });*/



        swoole_timer_after($bet_time, function ($bet_time, $waring_time, $stop_bet_time, $show_time) use ($gl) {
            $waring_str = $gl->lottery_no . "期还有" . $waring_time / 1000 . "秒停止下注\r\n";
            sendmessage($waring_str);
            $gl->Waring();
            swoole_timer_after($waring_time, function ($bet_time, $stop_bet_time, $show_time) use ($gl) {
                $stop_bet_str = "停止下注==" . $stop_bet_time / 1000 . "秒后开奖\n";
                sendmessage($stop_bet_str);
                $gl->StopBet();
                swoole_timer_after($stop_bet_time, function ($bet_time, $show_time) use ($gl) {
                    $show_str = "开始开奖==" . $show_time / 1000 . "秒后开始下注\r\n";
                    sendmessage($show_str);
                    $gl->DrawLottery();
                    swoole_timer_after($show_time, function ($bet_time) use ($gl) {
                        $start_str = $gl->lottery_no . "期开始下注-" . $bet_time / 1000 . "秒后提醒\r\n";
                        sendmessage($start_str);
                        $gl->next();
                    }, $bet_time);
                }, $bet_time, $show_time);
            }, $bet_time, $stop_bet_time, $show_time);
        }, $bet_time, $waring_time, $stop_bet_time, $show_time);

        $wait_time = $bet_time + $waring_time + $stop_bet_time + $show_time;
        //echo 'wait time:' . $wait_time . "\n";
        swoole_timer_tick($wait_time, function ($time_id, $bet_time, $waring_time, $stop_bet_time, $show_time) use ($gl) {
            echo "进入2号循环任务." . "\n";
            swoole_timer_after($bet_time, function ($bet_time, $waring_time, $stop_bet_time, $show_time, $time_id) use ($gl) {
                $waring_str = $gl->lottery_no . "期还有" . $waring_time / 1000 . "秒停止下注\r\n";
                sendmessage($waring_str);
                $gl->Waring();
                swoole_timer_after($waring_time, function ($bet_time, $stop_bet_time, $show_time, $time_id) use ($gl) {
                    $stop_bet_str = $gl->lottery_no . "期停止下注==" . $stop_bet_time / 1000 . "秒后开奖\n";
                    sendmessage($stop_bet_str);
                    $gl->StopBet();
                    swoole_timer_after($stop_bet_time, function ($bet_time, $show_time, $time_id) use ($gl) {
                        $show_str = $gl->lottery_no . "期开始开奖==" . $show_time / 1000 . "秒后开始下注\r\n";
                        sendmessage($show_str);
                        $gl->DrawLottery();
                        if ($gl->isStop()) {
                            echo '尝试停止timer:' . $time_id;
                            swoole_timer_clear($time_id);
                        } else {
                            swoole_timer_after($show_time, function ($bet_time) use ($gl) {
                                $start_str = $gl->lottery_no . "期开始下注-" . $bet_time / 1000 . "秒后提醒\r\n";
                                sendmessage($start_str);
                                $gl->Next();
                            }, $bet_time);
                        }
                    }, $bet_time, $show_time, $time_id);
                }, $bet_time, $stop_bet_time, $show_time, $time_id);
            }, $bet_time, $waring_time, $stop_bet_time, $show_time, $time_id);
        }, $bet_time, $waring_time, $stop_bet_time, $show_time);
        return "开始跑逻辑";
        //$response->header('Content-Type', 'text/plain');
        //$response->end('Hello World ');

    }

    public function push($id)
    {
        $delay_time = Setting::find(9)->value;
        $helper = new Helper();
        $key = Setting::find(16)->s_value;
        $sign = md5("jb" . 1 . $id . $key );
        swoole_timer_after($delay_time, function ($id, $sign) use ($helper) {
            echo "开始上下分:" . $id . "\n";
            $data = [
                'id' => $id,
                'status' => 1,
                'sign' => $sign,
                'test' => 1,
            ];
            $url = Setting::find(14)->s_value;
            echo $url;
            $helper->puturl($url."/money/recharge/v2/status", $data);
            echo "结束上下分\n";
        }, $id, $sign);
        //echo "收到请求上分:".$id;
        return "投递成功";
    }

    public function stop()
    {
        $set = Setting::find('4');
        $set->value = 1;
        $set->save();
        return "游戏计时停止";
    }
}
