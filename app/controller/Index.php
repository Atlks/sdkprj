<?php

namespace app\controller;

use think\facade\Request;
use app\BaseController;
use app\common\Game;
use app\common\GameLogic;
use app\model\BotWords;
use app\common\Logs;
use app\common\LotteryPC28;
use app\model\Setting;
use app\model\BetRecord;
use app\common\helper;
use app\model\BetTypes;

class Index extends BaseController
{
    public $Bot_Token = "1180404994:AAHmCvRboozX5lETFCaky5XgwWwvzxA2Zp8";
    public $chatId = -1001566212448;

    public function fff()
    {
        var_dump(7777);
        //    /index.php?s=handle/setHookSsc
       // return 1;
    }
    public function setHook()
    {
        $token = Setting::find(1)->s_value;
        $bot = new \TelegramBot\Api\BotApi($token);
        $host = Request::host();
        $url = $host . "/Handle";
        $res = $bot->setWebhook($url);
        var_dump($res);
    }

    public function setHookSsc()
    {
        $token = Setting::find(1)->s_value;
        $bot = new \TelegramBot\Api\BotApi($token);
        $host = Request::host();
        $url = $host . "/index.php?s=handle2/index";
        $res = $bot->setWebhook($url);
        var_dump($res);
    }

    public function setHook2()
    {
        $token = Setting::find(1)->s_value;
        $bot = new \TelegramBot\Api\BotApi($token);
        $host = Request::host();
        $url = $host . urldecode($_GET['hookurl']);
        $res = $bot->setWebhook($url);
        var_dump($res);
    }

    public function HookInfo()
    {
        $token = Setting::find(1)->s_value;
        $bot = new \TelegramBot\Api\BotApi($token);
        $res = $bot->getWebhookInfo();
        var_dump($res);
    }

    public function deleteHook()
    {
        $token = Setting::find(1)->s_value;
        $bot = new \TelegramBot\Api\BotApi($token);
        $res = $bot->deleteWebhook();
        var_dump($res);
    }

    public function gogo()
    {
        
        $game = new GameLogic();
        $res = $game->DrawFor(2984923, "0,6,5", 12313);
        return $res;
        $res = "";
        $content = "0 2 3 4.1000";


        $pattern = "/\d{1,2}[\x{4e00}-\x{9fa5}|\D]{1}\d+|\d+[\x{4e00}-\x{9fa5}]{1,2}|[\x{4e00}-\x{9fa5}]{1,2}\d+/u";
        //$pattern = "/^([0-9]{1}\D\d+|)/u";
        preg_match($pattern, $content, $string_list);


        //print_r($string_list);
        //$res = $game->regex_bet($content);
        return $res;
    }

    public function go()
    {
        $helper = new helper();
        $test = BetRecord::where('LotteryNo', 2980744)->select()->toArray();
        //print_r($test);
        $players = [];
        $temp = [];
        foreach ($test as $k => $v) {
            $income = $v['Payout'] - $v['Bet'];
            if (!isset($temp[$v['UserName']])) {
                $temp[$v['UserName']] = $income;
            } else
                $temp[$v['UserName']] += $income;
        }
        foreach ($temp as $name => $income) {
            $data = [
                'UserName' => $name,
                'Income' => $income,
            ];
            array_push($players, $data);
        }
        $helper->BubbleSort1($players, 'Income');
        foreach ($players as $v) {
            echo $v['UserName'] . ":" . $v['Income'] . "<br/>";
        }
        return "";
    }

    public function test($content)
    {
        $pattern = "/\d{1,2}[\x{4e00}-\x{9fa5}|\D]{1}\d+|\d+[\x{4e00}-\x{9fa5}]{1,2}|[\x{4e00}-\x{9fa5}]{1,2}\d+/u";
        $total_bet_amount = 0;
        $str2 = preg_replace($pattern, '', $content);
        echo $str2 . "<br/>";
        $str2 = preg_replace('/\ /', '', $str2);
        echo $str2 . "<br/>";
        $notOnlyBetText = false;
        if (!empty($str2)) {
            $notOnlyBetText = true;
        }
        $bet_types = BetTypes::select()->toArray();
        if (preg_match_all($pattern, $content, $string_list)) {
            $bet_string_list = $string_list[0];
            if ($notOnlyBetText)
                return "下注命令错误";
            // $before_bet = $this->player->getBetRecord($this->lottery_no);
            $bets = array();
            $text = "";
            foreach ($bet_string_list as $k => $v) {
                $match = false;
                $error = false;
                $ag_regx = '/^\d{1,2}[\x{4e00}-\x{9fa5}.]{1}/u';
                if (preg_match($ag_regx, $v, $out)) {
                    $bet_str = $out[0];

                    foreach ($bet_types as $key => $type) {
                        if (preg_match('/^' . $type['Regex'] . '/u', $v)) {
                            preg_match('/\d+/', $bet_str, $out);
                            $bet_text = $type['Display'];
                            $bet = [
                                'bet_type' => $type,
                                'text' => "",
                                'amount' => 0,
                            ];
                            $substr = preg_split($ag_regx, $v);
                            foreach ($substr as $kk => $vv) {
                                if (!empty($vv)) {
                                    $bet_text = $bet_text . "-" . $vv; //. "(" . $type['Odds'] . "赔率)";
                                    $bet['amount'] = intval($vv) * 100;
                                    $bet['text'] = $bet_text;
                                    $text = $text . $bet_text . "(" . $type['Odds'] . "赔率)";
                                    $total_bet_amount += $bet['amount'];
                                }
                            }
                            if ($bet['amount'] == 0)
                                break;
                            $min = $type['Bet_Min'];
                            //if ($min <= 0)
                            //$min = $this->min_limit;
                            if ($bet['amount'] < $min) {
                                $text = "没有达到最小下注:" . $min / 100;
                                $error = true;
                                break;
                            }

                            if ($bet['amount'] > $type['Bet_Max']) {
                                $text = "超过单笔的最大下注,限额:" . $type['Bet_Max'] / 100;
                                $error = true;
                                break;
                            }

                            /*
                            if (isset($before_bet[$type['Id']]))
                                $before_bet[$type['Id']] += $bet['amount'];
                            else
                                $before_bet[$type['Id']] = $bet['amount'];

                            if ($before_bet[$type['Id']] > $type['Bet_Max_Total']) {
                                $text = "超过总最大下注,限额:" . $type['Bet_Max_Total'] / 100;
                                $error = true;
                                break;
                            }
                            */
                            array_push($bets, $bet);
                            $match = true;
                            break;
                        } else if (preg_match('/\d+' . $type['Regex'] . '$/u', $v)) {
                            $bet = [
                                'bet_type' => $type,
                                'text' => "",
                                'amount' => 0,
                            ];

                            preg_match('/[\x{4e00}-\x{9fa5}]+/u', $v, $out);
                            $bet_text = $type['Display'];
                            preg_match('/\d+/', $v, $out);
                            $bet_text = $bet_text . "-" . $out[0]; //. "(" . $type['Odds'] . "赔率)";
                            $bet['amount'] = intval($out[0]) * 100;
                            $bet['text'] = $bet_text;
                            $total_bet_amount += $bet['amount'];

                            if ($bet['amount'] == 0)
                                break;
                            $min = $type['Bet_Min'];
                            //if ($min <= 0)
                            //    $min = $this->min_limit;
                            if ($bet['amount'] < $min) {
                                $text = "没有达到最小下注:" . $min / 100;
                                $error = true;
                                break;
                            }

                            if ($bet['amount'] > $type['Bet_Max']) {
                                $text = "超过最大下注,限额:" . $type['Bet_Max'] / 100;
                                $error = true;
                                break;
                            }

                            /*
                            if (isset($before_bet[$type['Id']]))
                                $before_bet[$type['Id']] += $bet['amount'];
                            else
                                $before_bet[$type['Id']] = $bet['amount'];

                            if ($before_bet[$type['Id']] > $type['Bet_Max_Total']) {
                                $text = "超过总最大下注,限额:" . $type['Bet_Max_Total'] / 100;
                                $error = true;
                                break;
                            }
*/
                            array_push($bets, $bet);
                            $text = $text . $bet_text . "(" . $type['Odds'] . "赔率)";
                            $match = true;
                            break;
                        }
                    }
                } else {
                    foreach ($bet_types as $key => $type) {
                        if (preg_match('/^' . $type['Regex'] . '\d+|^\d+' . $type['Regex'] . '$/u', $v, $out)) {
                            $bet = [
                                'bet_type' => $type,
                                'text' => "",
                                'amount' => 0,
                            ];

                            preg_match('/[\x{4e00}-\x{9fa5}]+/u', $v, $out);
                            $bet_text = $type['Display'];
                            preg_match('/\d+/', $v, $out);
                            $bet_text = $bet_text . "-" . $out[0]; //. "(" . $type['Odds'] . "赔率)";
                            $bet['amount'] = intval($out[0]) * 100;
                            $bet['text'] = $bet_text;
                            $total_bet_amount += $bet['amount'];

                            if ($bet['amount'] == 0)
                                break;
                            $min = $type['Bet_Min'];
                            //if ($min <= 0)
                            //    $min = $this->min_limit;
                            if ($bet['amount'] < $min) {
                                $text = "没有达到最小下注:" . $min / 100;
                                $error = true;
                                break;
                            }

                            if ($bet['amount'] > $type['Bet_Max']) {
                                $text = "超过最大下注,限额:" . $type['Bet_Max'] / 100;
                                $error = true;
                                break;
                            }
                            /*
                            if (isset($before_bet[$type['Id']]))
                                $before_bet[$type['Id']] += $bet['amount'];
                            else
                                $before_bet[$type['Id']] = $bet['amount'];

                            if ($before_bet[$type['Id']] > $type['Bet_Max_Total']) {
                                $text = "超过总最大下注,限额:" . $type['Bet_Max_Total'] / 100;
                                $error = true;
                                break;
                            }
*/
                            array_push($bets, $bet);
                            $text = $text . $bet_text . "(" . $type['Odds'] . "赔率)";
                            $match = true;
                            break;
                        }
                    }
                }

                if (!$match) {
                    if ($error)
                        return $text;
                    else
                        return "下注命令错误";
                }
                $text = $text . "\r\n";
            }
        }
        return $text;
    }

    public function gogogo()
    {

        $chat_id = $this->chatId;
        $messageText = "测试信息";

        $res = $this->test("大双8091");
        return $res;
        /*
        $player =  $game->getPlayer();
        if(!empty($player))
          {
    
           
                $records = $player->getRecords();
                $text = "   期数 类型 金钱 赔付" . "\r\n";
                foreach($records as $k => $v)
                {
                    $text = $text . "       " 
                    . $v['LotteryNo'] 
                    . " " . $v['BetContent'] 
                    . " " . $v['Bet']/100 
                    . " " . $v['Payout']/100 . "\r\n";
                }
                return $text;
                */

        //$res = $game->createPlayer(123123123,"苦力5","");
        //$cmd_str = "流水";
        //$out = preg_split('/\|/',$cmd_str);
        //print_r($res);
        // $keyboard_array = json_decode(BotWords::where('Id',1)->find()->Button_Text);
        //print_r($keyboard_array);
        //return $keyboard_array;
        //$keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($keyboard_array);

        //$bot->sendMessage($chatId, "单机测试",null,false,null,null,$keyboard);

        //return $game->exec_pattern;


        /*
                $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                    [
                        [
                            ['text' => 'link', 'url' => 'https://core.telegram.org']
                            
                        ],
                        [
                            ['text' => 'down', 'callback_data' => 'test data']
                        ]
                    ]
             );


        //return $bot->sendMessage($chatId, $messageText, null, false, null, null,$keyboard)->toJson(); 

                //$url = 'https://bot.yszh5.cc/process_message';
                $res = $bot->getWebhookInfo()->toJson();
                $res = json_decode($res);
                if($res->last_error_date !== null)
                {
                    $res->last_error_date = date('Y-m-d  H:i:s',$res->last_error_date);
                }
                $reply_text = "测试";
                $message_id = null;
                if(!empty($reply_text)){

                    $keyboard_array = json_decode(BotWords::where('Id',1)->find()->Button_Text);
                    $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($keyboard_array);
                    $res = $bot->sendMessage($chat_id, $reply_text,null,false,null,565,$keyboard);
                    return $res->toJson();
                    } 
                $data['text']=json_encode($res);
            $data['name']="test";
            $data['chat_id']=0;
            $data['time']=  date('Y-m-d  H:i:s',time());
            \think\facade\Db::connect('test')->table('message')->insert($data);
            */
        //$res->last_error_date = date('Y-m-d  H:i:s',$res->last_error_date);
        return json_encode($res);
    }


    public function checkStraight($a, $b, $c)
    {
        $straight = false;
        if ($a < 8) {
            $straight = $a == ($b + 1) ?  $b == ($c + 1) : false;
            //echo "$a = $b + 1 = $c + 2 <br/>";
            if ($straight) return $straight;
            $straight = $a == ($c + 1) ?  $c == ($b + 1) : false;
            //echo "$a = $b + 2 = $c + 1 <br/>";
            if ($straight) return $straight;
        }

        if ($c > 2 || $b > 2) {
            $straight = $a == ($b - 1) ?  $b == ($c - 1) : false;
            //echo "$a = $b -1  = $c - 2 <br/>";
            if ($straight) return $straight;
            $straight = $a == ($c - 1) ?  $c == ($b - 1) : false;
            //echo "$a = $b - 2 = $c - 1 <br/>";
            if ($straight) return $straight;
        }

        return $straight;
    }

    public function getUpdate()
    {
        $text = "";
        for ($a = 1; $a < 10; $a++) {
            for ($b = 1; $b < 10; $b++) {
                for ($c = 1; $c < 10; $c++) {
                    $result = [$a, $b, $c];

                    $straight = $this->checkStraight($result[0], $result[1], $result[2]);
                    if (!$straight)
                        $straight = $this->checkStraight($result[1], $result[0], $result[2]);
                    if (!$straight)
                        $straight = $this->checkStraight($result[2], $result[1], $result[0]);

                    $straight ? $text = $text . "$a $b $c : 顺子 | " : "无";
                }
            }
            $text = $text . "<br>";
        }
        echo $text;
    }
}
