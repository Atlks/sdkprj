<?php

declare(strict_types=1);

namespace app\common;

use app\model\BotWords;
use app\model\LotteryLog;
use app\common\Logs;
use app\common\Player;
use app\model\BetTypes;
use app\model\BetRecord;
use app\model\User;
use app\model\Setting;
use app\common\Helper;
use app\model\GameString;
use app\model\Config;

use app\common\LotteryHash28 as Hash28;
use app\common\LotteryPC28 as PC28;


class NNGameLogic
{
    public $lottery_no = 2;     // 期号
    public $lottery_id = 4;     // 数据库里的索引
    public $hash_no = 0;        // hash玩法里开奖使用的波场期号
    public $bot_token = "";     // 机器人token
    public $chat_id = 0;        // 群id
    public $bot;                // bot的实例
    public $result = "功能开发中";      // 每个阶段要展示给群的信息
    public $hash = "";                 // hash玩法里根据波场开出的hash_no获得的hash值

    private $userDb = null;
    private $lottery = null;            // 彩票实例
    private $game_type = 0;             // 游戏类型 0 pc 1 hash
    private $start_issue;               // 开始的期号 可以由外部控制游戏启动时的期号,如果不给定将自动获取

    // 当前状态
    public $game_state = 'start';
    public $elapsed_time = 0;
    // 游戏状态
    // array [ '状态' => '回调函数' ];
    /*
    [
        'start' => 'Start',             // 新的开始
        'waiting_bet' => null,          // 等待下注
        'show_waring' =>  'Waring',     // 显示警告
        'waring' => null,               // 下注最后时段
        'stop_bet' => 'StopBet',        // 封盘警告
        'stop_time' => null,            // 封盘等待时间
        'draw' => 'DrawLottery',        // 开奖
        'next' => 'Next',               // 下一期开始
    ];
    */

    public $result_type =
    [
        '大' => 0,
        '小' => 1,
        "单" => 2,
        "双" => 3,
        "大单" => 4,
        "大双" => 5,
        '小单' => 6,
        '小双' => 7,
        '极大' => 8,
        '极小' => 9,
        '杂六' => 10,
        '对子' => 11,
        '豹子' => 12,
        '顺子' => 13,
        '和值' => 14,
    ];

    public $special_odds =
    [
        '大' => 1.6,
        '小' => 1.6,
        '单' => 1.6,
        '双' => 1.6,
        '大单' => 1,
        '大双' => 1,
        '小单' => 1,
        '小双' => 1,
        '极大' => 0,
        '极小' => 0,
        '杂六' => 0,
        '对子' => 0,
        '豹子' => 0,
        '顺子' => 0,
        '和值' => 0,
    ];

    public function __construct($start_issue = null)
    {
        $this->bot_token = Setting::find(1)->s_value;
        $this->chat_id = Setting::find(2)->value;
        $this->bot = new \TelegramBot\Api\BotApi($this->bot_token);
        $this->userDb = new User();
        $this->lottery = new PC28();
        $this->game_type = 0;
        $this->start_issue = $start_issue;
    }

    public function Ready()
    {
    }

    public function adjustTime($time)
    {
        if ($this->elapsed_time > 0) {
            $temp = $time;
            $time = $time - $this->elapsed_time;
            if ($time < 0) $time = 1;
            $this->elapsed_time -= $temp;
            if ($this->elapsed_time < 0)
                $this->elapsed_time = 0;
        }
        return $time;
    }

    public function Start()
    {
        $today = date("Y-m-d", time());
        if (empty($this->start_issue))
            $data = $this->lottery->get_last_no();
        else {
            $data =  [
                'lottery_no' => intval($this->start_issue) + 1,
                'hash_no' => intval($this->start_issue) + 1,
                'opentime' => time(),
            ];
            $this->lottery->setData($data);
        }
        if (is_bool($data)) return false;
        $this->lottery_no = $data['lottery_no'];
        $this->hash_no = $data['hash_no'];
        $this->elapsed_time = time() - $data['opentime'];
        $this->elapsed_time *= 1000;
        $log = Logs::addLotteryLog($today, $this->lottery_no, $this->hash_no);
        $this->lottery_id = $log->id;
        $set = Setting::find(3);
        $set->value = 0;
        $set->save();
        //$this->send_notice('start');
        $this->game_state = 'waiting_bet';
        return true;
    }

    public function send_notice($state)
    {
        $bot_words = BotWords::where('Id', 1)->find();
        $text = "";
        $bot = $this->bot;
        $chat_id = $this->chat_id;
        switch ($state) {
            case 'start':
                $words = $bot_words->Start_Bet;
                $cfile = new \CURLFile(app()->getRootPath() . "public/static/start.jpg");
                $text = $this->lottery_no . "期 开始下注!\r\n";
                $text = $text . $words;
                if ($this->game_type ==  1) {
                    $elapsed = Setting::find(6)->value + Setting::find(7)->value;
                    $stop_time = date("Y-m-d H:i:s", time() + $elapsed / 1000);
                    $text = $text . "\n\n封盘时间：$stop_time\n";
                    $elapsed +=  Setting::find(8)->value;
                    $draw_time = date("Y-m-d H:i:s", time() + $elapsed / 1000);
                    $text = $text . "开奖时间：$draw_time\n";
                    $text = Helper::replace_markdown($text);
                    $text = $text . "开奖区块号 ：[" . $this->hash_no . "](https://tronscan.org/#/block/" . $this->hash_no . ")";
                } else {
                    $text = Helper::replace_markdown($text);
                }
                $bot->sendPhoto($chat_id, $cfile, $text, null, null, null, false, "MarkdownV2");
                break;
            case 'waring':
                $words = $bot_words->StopBet_Waring;
                $text = $words;
                $bot->sendmessage($chat_id, $text);
                break;
            case 'stop':
                $words = $bot_words->StopBet_Notice;
                $text = $words;
                $bot->sendmessage($chat_id, $text);
                $records = Logs::getBetRecordByLotteryNo($this->lottery_no);
                $text = "--------本期下注玩家---------" . "\r\n";
                $sum = 0;
                foreach ($records as $k => $v) {
                    $text = $text . $v['UserName'] . "【" . $v['UserId'] . "】" . $v['BetContent'] . "\r\n";
                    $sum += $v['Bet'];
                }
                Logs::addLotteryBet($this->lottery_no, $sum);
                $str_len = mb_strlen($text, 'UTF-8');
                if ($str_len > 4096) {
                    $offset = 0;
                    $sub_str = $text;
                    $break = false;
                    while (true) {
                        $sub_str = mb_substr($text, $offset, 4096, 'UTF-8');
                        $offset += mb_strlen($sub_str, 'UTF-8');
                        $bot->sendmessage($chat_id, $sub_str);
                        if ($offset >= $str_len)
                            break;
                    }
                } else
                    $bot->sendmessage($chat_id, $text);
                break;
            case 'draw':
                if ($this->game_type ==  1) {
                    $text = "第" . $this->lottery_no . "期 [点击官方开奖](https://tronscan.org/#/block/" . $this->hash_no . ")";
                } else {
                    $words = GameString::where('name', '开始开奖')->find()->text;
                    $text = "第" . $this->lottery_no . $words;
                }
                $bot->sendmessage($chat_id, $text, 'MarkdownV2', true);
                break;
            case 'result':
                $text = "第" . $this->lottery_no . "期开奖结果" . "\r\n";
                if ($this->game_type ==  1) {
                    $text = $text . "本期区块号码:" . $this->hash_no . "\r\n"
                        . "本期哈希值:\r\n" . $this->hash . "\r\n";
                }
                $text .= $this->result . "\r\n";
                $bot->sendmessage($chat_id, $text);
                $this->SendTrendImage(20);
                $cfile = new \CURLFile(app()->getRootPath() . "public/trend.jpg");
                $bot->sendPhoto($chat_id, $cfile);
                break;
        }
    }

    public function run()
    {
        /*
        if(!isset($this->game_state[$this->state]))
        {
            $func = $this->game_state[$this->state];
            if(!empty($func))
                $this->$func();
        }
        */
    }

    public function SendTrendImage($count = 10)
    {
        $lotterys = Logs::get_lottery_log($count);
        $records = [];
        foreach ($lotterys as $log) {
            $data = [
                'turn' => "" . $log->No,
            ];

            $arr = preg_split('/\|/', $log->Result);
            if (!is_bool($arr))
                $data['result'] = $arr[0];

            if (preg_match_all('/(?<=a|b|c)牛(\d|牛)/u', $log->Result, $mc)) {
                $data['a'] = $mc[0][0];
                $data['b'] = $mc[0][1];
                $data['c'] = $mc[0][2];
            }

            array_push($records, $data);
        }

        //print_r($records);
        $this->createTrendImage($records);
    }


    private function createTrendImage($records)
    {
        // 数据
        $data = ["turn" => '期数', "result" => "结果", "a" => "a(闲)", "b" => "b(闲)", "c" => "c(庄)"];
        $row_x = ["turn" => '1234567', "result" => "1 2 3", "a" => "牛几", "b" => "牛几", "c" => "牛几"];
        // TODO::字体路径
        $font = app()->getRootPath() . "public/msyhbd.ttc";

        //echo $font;
        $font_title_size = 16;
        $font_size = 20;
        // 标题长度
        //$this_title_box = imagettfbbox($font_size, 0, $font, $title);
        //$title_x_len = $this_title_box[2] - $this_title_box[0];
        $title_height = 40;

        // 每行高度
        $row_hight = $title_height - 10;
        $pre_title_w = [];
        foreach ($data as $key => $value) {
            $this_box = imagettfbbox($font_size, 0, $font, $value);
            $pre_title_w[$key] = $this_box[2] - $this_box[0];
        }


        $text_x_len = 0;
        $pre_col_w = [];
        $pre_col_x = [];
        foreach ($row_x as $key => $value) {
            $this_box = imagettfbbox($font_size, 0, $font, $value);
            $pre_col_w[$key] = $this_box[2] - $this_box[0];
            $text_x_len += $pre_col_w[$key];
        }

        // 列数
        $column = count(array_values($row_x));

        $title_height = 40;
        // 文本左右内边距
        $x_padding = 10;
        $y_padding = 10;
        // 图片宽度（每列宽度 + 每列左右内边距）
        $img_width = ($text_x_len) + $column * $x_padding * 2;
        // 图片高度（标题高度 + 每行高度 + 每行内边距）
        $img_height = $title_height + count($records) * ($row_hight + $y_padding);

        # 开始画图
        // 创建画布
        $img = imagecreatetruecolor($img_width, $img_height);

        # 创建画笔
        // 背景颜色（蓝色）
        $bg_color = imagecolorallocate($img, 10, 10, 10);
        // 表面颜色（浅灰）
        $surface_color = imagecolorallocate($img, 235, 242, 255);
        // 标题字体颜色（白色）
        $title_color = imagecolorallocate($img, 255, 255, 255);
        // 内容字体颜色（灰色）
        $text_color = imagecolorallocate($img, 0, 0, 0);

        // 大双为红色
        $big_2_color = imagecolorallocate($img, 255, 0, 0);
        // 小单为青色
        $small_1_color = imagecolorallocate($img, 100, 149, 237);
        // 无的颜色
        $null_color = imagecolorallocate($img, 125, 125, 125);
        // 对子
        $pair_color = imagecolorallocate($img, 10, 200, 10);
        // 顺子
        $_color = imagecolorallocate($img, 200, 134, 0);
        // 豹子
        $all_color = imagecolorallocate($img, 255, 0, 0);
        $box = imagettfbbox($font_size, 0, $font, "小");
        $big_small_with = $box[2] - $box[0];


        // 画矩形 （先填充一个大背景，小一点的矩形形成外边框）
        imagefill($img, 0, 0, $bg_color);
        imagefilledrectangle($img, 2, $title_height, $img_width - 3, $img_height - 3, $surface_color);

        $x = 0;
        $title_x = 0;

        $small_nn = array("牛1", "牛2", "牛3", "牛4", "牛5");
        $big_nn = array("牛6", "牛7", "牛8", "牛9");
        $big_nn_color = imagecolorallocate($img, 65, 105, 225);
        $small_nn_color = imagecolorallocate($img, 0, 205, 205);
        $text_nn_color = imagecolorallocate($img, 255, 255, 255);

        foreach ($pre_col_w as $k => $col_x) {
            $x += $x_padding * 2;
            $x += $col_x;
            imageline($img, $x, $title_height, $x, $img_height, $bg_color);
            $pre_col_x[$k] = $x;
            //写入首行 
            imagettftext($img, $font_title_size, 0, $title_x + intval(($col_x + $x_padding * 2 - $pre_title_w[$k]) / 2), intval($title_height - $font_title_size / 2), $title_color, $font, $data[$k]);
            $title_x += $col_x + $x_padding * 2;
        }

        // 写入表格
        $room_in = 4;
        $temp_height = $title_height;
        foreach ($records as $key => $record) {
            # code...
            $next_x = 0;
            $temp_height += $row_hight + $y_padding;
            // 画线
            $x = 0;
            imageline($img, 0, $temp_height, $img_width, $temp_height, $bg_color);
            foreach ($record as $k => $value) {
                $col_x = $pre_col_w[$k];
                $x += $x_padding * 2;
                $x += $col_x;
                if ($k == 'zuhe') {
                    $strarr =  preg_split('/(?<!^)(?!$)/u', $value);
                    $color1 = $color2 = 0;
                    if ($strarr[0] == "小") {
                        $color1 = $small_1_color;
                    } else {
                        $color1 = $big_2_color;
                    }

                    if ($strarr[1] == "单") {
                        $color2 = $small_1_color;
                    } else {
                        $color2 = $big_2_color;
                    }
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $color1, $font, $strarr[0]);
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + $big_small_with, $temp_height - $font_size / 2, $color2, $font, $strarr[1]);
                } elseif ($k == 'limit') {
                    if ($value == "极小") {
                        $color = $big_2_color;
                    } elseif ($value == "极大") {
                        $color = $text_color;
                    } else
                        $color = $null_color;

                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $color, $font, $value);
                } elseif ($k == "kind") {
                    if ($value == "对子") {
                        $color = $pair_color;
                    } elseif ($value == "顺子") {
                        $color = $_color;
                    } elseif ($value == "豹子") {
                        $color = $all_color;
                    } else
                        $color = $null_color;

                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $color, $font, $value);
                } else if ($k === "a") {
                    imagefilledrectangle($img, $x - $col_x - $x_padding * 2 + $room_in, $temp_height - $row_hight - $y_padding + 1 + $room_in, $x - $room_in, $temp_height - $room_in, $big_nn_color);
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $text_nn_color, $font, $value);
                } else if ($k === "b") {
                    imagefilledrectangle($img, $x - $col_x - $x_padding * 2 + $room_in, $temp_height - $row_hight - $y_padding + 1 + $room_in, $x - $room_in, $temp_height - $room_in, $big_nn_color);
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $text_nn_color, $font, $value);
                } else if ($k === "c") {
                    imagefilledrectangle($img, $x - $col_x - $x_padding * 2 + $room_in, $temp_height - $row_hight - $y_padding + 1 + $room_in, $x - $room_in, $temp_height - $room_in, $big_2_color);
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $text_nn_color, $font, $value);
                } else {
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $text_color, $font, $value);
                }
            }
        }

        imagepng($img, app()->getRootPath() . "public/trend.jpg");
    }


    public function Waring()
    {
        //$this->send_notice('waring');
        $this->game_state = 'waring';
    }

    public function StopBet()
    {
        $set = Setting::find(3);
        $set->value = 1;
        $set->save();
        //$this->send_notice('stop');
        $this->game_state = 'stop_time';
    }

    private function checkStraight($a, $b, $c)
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


    public function DrawFor($no, $result, $lottery_id)
    {
        $this->lottery_no = $no;
        $this->lottery_id = $lottery_id;
        $hash = $result;
        $this->hash = substr($hash, 0, 15) . "..." . substr($hash, -10);
        $total_payout = 0;
        $text = "";
        if (preg_match_all('/\d{1}+/', $hash, $matches)) {
            $arr = $matches[0];
            $count = count($arr);
            // a-e门的胜负
            $odds_a = $odds_b = $odds_c = $odds_d = $odds_e = 0;
            if ($this->game_type == 0) {
                $result = ['a' => intval($arr[$count - 3]), 'b' => intval($arr[$count - 2]), 'c' => intval($arr[$count - 1])];
                $type_a = $result['a'] == 0 ? "牛" : $result['a'] . "";
                $type_b = $result['b'] == 0 ? "牛" : $result['b'] . "";
                $type_c = $result['c'] == 0 ? "牛" : $result['c'] . "";
                $result['a'] = $result['a'] == 0 ? 10 : $result['a'];
                $result['b'] = $result['b'] == 0 ? 10 : $result['b'];
                $result['c'] = $result['c'] == 0 ? 10 : $result['c'];
                $text = $result['a'] . " " . $result['b'] . " " . $result['c'] . "\r\n" .
                    "a牛" . $type_a . " b牛" . $type_b . " c牛" . $type_c;
                if ($result['a'] === $result['b'] && $result['a'] === $result['c']) {
                    $odds_a = $odds_b = -$result['c'];
                } else {

                    $odds_a = $result['a'] > $result['c'] ? $result['a'] : -$result['c'];
                    $odds_b = $result['b'] > $result['c'] ? $result['b'] : -$result['c'];

                    if ($result['a'] === $result['c'])
                        $odds_a = 0;
                    if ($result['b'] === $result['c'])
                        $odds_b = 0;
                }
            }
        }

        //print_r($win_bet_ids);
        $records = Logs::getBetRecordByLotteryNo($this->lottery_no);


        $players = [];
        // bet_records需要跟新字段 Payout,Status,ResultId,Rebate
        $records_update = [];
        $bet_types = BetTypes::select()->toArray();
        $total_payout = 0;

        foreach ($records as $k => $v) {
            $record_id = $v['Id'];
            $user_id = $v['UserId'];
            $betType_id = $v['Type'];
            if (!isset($players[$user_id])) {
                $user = $this->userDb->findByUserId($user_id);
                $players[$user_id] = [
                    'bet' => 0,
                    'payout' => 0,
                    'lose' => 0,            // 比pc28多一个字段,因为pc28玩家不赔付,而牛牛玩家需要赔付
                    'back' => 0,
                    'player' => new Player($user),
                ];
            }

            $update = [
                'Id' => $record_id,
                'Payout' => 0,
                'Status' => 1,
                'ResultId' => $this->lottery_id,
                'Rebate' => 0
            ];


            $players[$user_id]['bet'] += $v['Bet'];
            $odds = 0;
            // 根据bet_type里的type字段来确定是哪一门
            // 0-4 对应 a-e 0a1b2c3d4e
            switch ($bet_types[$betType_id]['type']) {
                case 0:
                    $odds = $odds_a;
                    break;
                case 1:
                    $odds = $odds_b;
                    break;
                case 2:
                    $odds = $odds_c;
                    break;
                case 3:
                    $odds = $odds_d;
                    break;
                case 4:
                    $odds = $odds_e;
                    break;
            }

            $commission = Config::find(1)->Commission;

            if ($odds > 0) {
                $payout = $v['Bet'] * ($odds + $bet_types[$betType_id]['value']) * (1 - $commission / 100);
                $players[$user_id]['payout'] += $payout;
                $players[$user_id]['back'] += $v['Bet'];
                $update['Payout'] = $payout;
                $total_payout += $payout;
            } else {
                $lose = $v['Bet'] * ($odds - $bet_types[$betType_id]['value']);
                $players[$user_id]['lose'] += $lose;
            }
        }
        array_push($records_update, $update);

        // 开奖记录更新
        Logs::addlotteryResult($this->lottery_no, $text, $total_payout);

        $text  = $text . "\r\n"
            . "=====本期中奖名单======" . "\r\n";

        $temp_arr = [];
        foreach ($players as $id => $v) {
            $player = $v['player'];
            $income = $v['payout'] + $v['lose'];
            $back = $v['back'];
            // 玩家需要更新字段,Total_Payout;
            // 玩家的日报需要更新字段 PayoutAmount,Income;
            // 结算之后计入玩家流水
            $player->win($v['bet'], $v['payout'], $income, $back);
            array_push($temp_arr, array('player' => $player, 'income' => $income));
        }

        $helper = new Helper();
        $helper->BubbleSort1($temp_arr, 'income');
        foreach ($temp_arr as $v) {
            $player = $v['player'];
            $income = $v['income'];
            $text = $text . $player->getName() . "【" . $player->getId() . "】" . number_format($income / 100.0, 2, ".", "") . "\r\n";
        }

        $bet_recoreds = new BetRecord();
        $bet_recoreds->saveAll($records_update);

        $this->result = $text;
        return $this->result;
    }


    public function DrawLottery()
    {
        $hash = $this->lottery->drawV2();
        if (is_bool($hash)) return;
        $this->hash = substr($hash, 0, 15) . "..." . substr($hash, -10);
        $total_payout = 0;
        $text = "";
        if (preg_match_all('/\d{1}+/', $hash, $matches)) {
            $arr = $matches[0];
            $count = count($arr);
            // a-e门的胜负
            $odds_a = $odds_b = $odds_c = $odds_d = $odds_e = 0;
            if ($this->game_type == 0) {
                $result = ['a' => intval($arr[$count - 3]), 'b' => intval($arr[$count - 2]), 'c' => intval($arr[$count - 1])];
                $number_text = $result['a'] . " " . $result['b'] . " " . $result['c'] . "|";
                $type_a = $result['a'] == 0 ? "牛" : $result['a'] . "";
                $type_b = $result['b'] == 0 ? "牛" : $result['b'] . "";
                $type_c = $result['c'] == 0 ? "牛" : $result['c'] . "";
                $result['a'] = $result['a'] == 0 ? 10 : $result['a'];
                $result['b'] = $result['b'] == 0 ? 10 : $result['b'];
                $result['c'] = $result['c'] == 0 ? 10 : $result['c'];
                $text = "a牛" . $type_a . " b牛" . $type_b . " c牛" . $type_c;

                if ($result['a'] === $result['b'] && $result['a'] === $result['c']) {
                    $odds_a = $odds_b = -$result['c'];
                } else {

                    $odds_a = $result['a'] > $result['c'] ? $result['a'] : -$result['c'];
                    $odds_b = $result['b'] > $result['c'] ? $result['b'] : -$result['c'];

                    if ($result['a'] === $result['c'])
                        $odds_a = 0;
                    if ($result['b'] === $result['c'])
                        $odds_b = 0;
                }
            }
        }

        //print_r($win_bet_ids);
        $records = Logs::getBetRecordByLotteryNo($this->lottery_no);


        $players = [];
        // bet_records需要跟新字段 Payout,Status,ResultId,Rebate
        $records_update = [];
        $bet_types = [];
        foreach (BetTypes::select()->toArray() as $type) {
            $bet_types[$type['Id']] = $type;
        }
        $total_payout = 0;

        foreach ($records as $k => $v) {
            $record_id = $v['Id'];
            $user_id = $v['UserId'];
            $betType_id = $v['Type'];
            if (!isset($players[$user_id])) {
                $user = $this->userDb->findByUserId($user_id);
                $players[$user_id] = [
                    'bet' => 0,
                    'payout' => 0,
                    'lose' => 0,            // 比pc28多一个字段,因为pc28玩家不赔付,而牛牛玩家需要赔付
                    'back' => 0,            // 赔付时需要退还的本金
                    'lose_bet' => 0,        // 输掉时已经扣除的本金
                    'return' => 0,          // 回本时需要退还的本金
                    'player' => new Player($user),
                ];
            }

            $update = [
                'Id' => $record_id,
                'Payout' => 0,
                'Status' => 1,
                'ResultId' => $this->lottery_id,
                'Rebate' => 0
            ];


            $players[$user_id]['bet'] += $v['Bet'];
            $odds = 0;
            // 根据bet_type里的type字段来确定是哪一门
            // 0-4 对应 a-e 0a1b2c3d4e
            switch ($bet_types[$betType_id]['type']) {
                case 0:
                    $odds = $odds_a;
                    break;
                case 1:
                    $odds = $odds_b;
                    break;
                case 2:
                    $odds = $odds_c;
                    break;
                case 3:
                    $odds = $odds_d;
                    break;
                case 4:
                    $odds = $odds_e;
                    break;
            }

            $commission = Config::find(1)->Commission;

            if ($odds > 0) {
                $payout = $v['Bet'] * ($odds + $bet_types[$betType_id]['value']) * (1 - $commission / 100);
                $players[$user_id]['payout'] += $payout;
                $players[$user_id]['back'] += $v['Bet'];
                $update['Payout'] = $payout;
                $total_payout += $payout;
            } else if ($odds < 0) {
                $lose = $v['Bet'] * ($odds - $bet_types[$betType_id]['value']);
                $players[$user_id]['lose'] += $lose;
                $players[$user_id]['lose_bet'] += $v['Bet'];
                $update['Payout'] = $lose;
            } else {
                $players[$user_id]['return'] += $v['Bet'];
            }

            array_push($records_update, $update);
        }

        // 开奖记录更新
        Logs::addlotteryResult($this->lottery_no, $number_text . $text, $total_payout);

        $text  = $text . "\r\n"
            . "=====本期中奖名单======" . "\r\n";

        $temp_arr = [];
        foreach ($players as $id => $v) {
            $player = $v['player'];
            $income = $v['payout'] + $v['lose'];
            $lose = $v['lose'];
            $back = $v['back'];
            $lose_bet = $v['lose_bet'];
            $return = $v['return'];
            // 玩家需要更新字段,Total_Payout;
            // 玩家的日报需要更新字段 PayoutAmount,Income;
            // 结算之后计入玩家流水
            $player->win($v['bet'], $v['payout'], $income, $lose + $lose_bet, $back + $return);
            array_push($temp_arr, array('player' => $player, 'income' => $income + $back));
        }

        $helper = new Helper();
        $helper->BubbleSort1($temp_arr, 'income');
        foreach ($temp_arr as $v) {
            $player = $v['player'];
            $income = $v['income'];
            $text = $text . $player->getName() . "【" . $player->getId() . "】" . number_format($income / 100.0, 2, ".", "") . "\r\n";
        }

        $bet_recoreds = new BetRecord();
        $bet_recoreds->saveAll($records_update);

        $this->result = $text;
        //$this->send_notice('result');
        $this->game_state = 'next';
    }

    public function Next()
    {
        $data = $this->lottery->get_current_no();
        if (is_bool($data)) return false;
        $this->lottery_no = $data['lottery_no'];
        $this->hash_no = $data['hash_no'];
        $this->elapsed_time = time() - $data['opentime'];
        $this->elapsed_time *= 1000;
        $today = date("Y-m-d", time());
        $log = Logs::addLotteryLog($today, $this->lottery_no, $this->hash_no);
        $this->lottery_id = $log->id;
        $set = Setting::find(3);
        $set->value = 0;
        $set->save();
        $this->chat_id = Setting::find(2)->value;
        //$this->send_notice('start');
        $this->game_state = 'waiting_bet';
        return true;
    }


    public function isStop()
    {
        return Setting::find(4)->value;
    }
}
