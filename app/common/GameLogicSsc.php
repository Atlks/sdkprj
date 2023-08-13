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

use app\common\LotteryHash28 as Hash28;
use app\common\LotteryPC28 as PC28;
use Nette\Utils\Arrays;

class GameLogicSsc
{
    public $lottery_no = 2;
    public $lottery_id = 4;
    public $hash_no = 0;
    public $bot_token = "1180404994:AAHmCvRboozX5lETFCaky5XgwWwvzxA2Zp8";
    public $chat_id = -1001566212448;
    public $bot;
    public $result = "功能开发中";
    public $hash = "";

    private $userDb = null;
    private $limit_special = 1000000;
    public $lottery = null;
    // 特殊玩法 0,1,2,3
    // 0 4.2 正常玩法
    // 1 4.6 遇13,14 总注小于1万 大小单双1.6 大于6万 大小单双保本 组合保本
    // 2 5.0 遇13. 14大小单双赔1.6总注10000(包含10000)以上回本  组合通吃!
    // 3 6.0 遇13. 14对子 顺子 豹子 中奖回本!
    private $special_mode = 0;
    private $game_type = 0;
    private $start_issue;

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
        '尾数' => 15,
        '尾单双' => 16,
        '尾大小' => 17,
        '尾组合' => 18,
        'A数字' => 19,
        'A单双' => 20,
        'A大小' => 21,
        'A组合' => 22,
        'B数字' => 23,
        'B单双' => 24,
        'B大小' => 25,
        'B组合' => 26,
        'C数字' => 27,
        'C单双' => 28,
        'C大小' => 29,
        'C组合' => 30,
    ];

    // 特殊赔率表
    // 默认4.6特殊赔率
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
        '尾数' => 0,
        '尾单双' => 0,
        '尾大小' => 0,
        '尾组合' => 0,
        'A数字' => 0,
        'A单双' => 0,
        'A大小' => 0,
        'A组合' => 0,
        'B数字' => 0,
        'B单双' => 0,
        'B大小' => 0,
        'B组合' => 0,
        'C数字' => 0,
        'C单双' => 0,
        'C大小' => 0,
        'C组合' => 0,
    ];

    public function __construct($start_issue = null)
    {
        $this->bot_token = Setting::find(1)->s_value;
        $this->chat_id = Setting::find(2)->value;
        $this->bot = new \TelegramBot\Api\BotApi($this->bot_token);
        $this->userDb = new User();
        //    $this->lottery = new PC28();
        //    $this->game_type = 0;

        $this->lottery = new LotteryHashSsc();
        $this->game_type = 1;


        $this->special_mode = intval(Setting::find(10)->value);
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
        if (empty($this->start_issue)) {
            $data = $this->lottery->get_last_no();
            $data['opentime'] = time();
        } else {
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
                    $text = $text . "开奖区块号 ：[" . $this->hash_no . "](https://etherscan.io/block/" . $this->hash_no . ")";
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
                    $text = "第" . $this->lottery_no . "期 [点击官方开奖](https://etherscan.io/block/" . $this->hash_no . ")";
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
                if ($this->game_type == 1) {
                    $words = GameString::where('name', '开奖验证')->find()->text;
                    $words = Helper::replaceHashNo($this->hash_no, $words);
                    $keyboard_array = json_decode($words);
                    $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($keyboard_array);
                    $bot->sendmessage($chat_id, $text, null, false, null, null, $keyboard);
                } else
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

            $result = explode(' ', $log->Result);
            if (preg_match('/(?<==)\d+$/u', $result[0], $mc)) {
                if ($mc[0] < 10) {
                    $data['sum'] = "0" . $mc[0];
                    $data['result'] = substr($result[0], 0, -1);
                } else {
                    $data['sum'] = "" . $mc[0];
                    $data['result'] = substr($result[0], 0, -2);
                }
            }

            $data['result'] = $log->Result;
            require_once  __DIR__ . "/../lotrySsc.php";
            $data['sum'] = "" .   array_sum(str_split($log->Result));
            $data['zuhe'] = join("", getKaijNumArr_hezDasyods($log->Result));  //和值大小单双;

            \think\facade\Log::info("zuhe大小单双:" . $data['zuhe']);
            $lineNumStr = __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__ . " m:" . __METHOD__ . "  ";
            \think\facade\Log::info($lineNumStr);
            \think\facade\Log::info("kaijnum:" . $log->Result);
            $data['limit'] = getKaijNumFly_longhuHaeWefa($log->Result);  //龙湖
            array_push($records, $data);
        }

        //print_r($records);
        // var_dump($records);
        $this->createTrendImage($records);
    }


    private function createTrendImage($records)
    {
        $log_txt = __METHOD__ . json_encode(func_get_args(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        \think\facade\Log::debug($log_txt);
        // 数据
        $data = ["turn" => '期数', "result" => "结果", "sum" => "和", "zuhe" => "组合", 'limit' => "龙虎"];
        $row_x = ["turn" => '12345678', "result" => "a+b+c=102", "sum" => "bb", "zuhe" => "组合", 'limit' => "极"];
        // TODO::字体路径
        $font = app()->getRootPath() . "public/msyhbd.ttc";
        $font_path =  $font;
        var_dump($font_path);

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
        $column = 5;

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

        $text_color_black = imagecolorallocate($img, 0, 0, 0);
        $green_color = imagecolorallocate($img, 100, 149, 237);

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
        $intN = 0;
        foreach ($pre_col_w as $k => $col_x) {
            $x += $x_padding * 2;
            $x += $col_x;

            $intN++;

              //  break;
                imageline($img, $x, $title_height, $x, $img_height, $bg_color);
              
            $pre_col_x[$k] = $x;
            //写入首行 
            imagettftext($img, $font_title_size, 0, $title_x + intval(($col_x + $x_padding * 2 - $pre_title_w[$k]) / 2), intval($title_height - $font_title_size / 2), $title_color, $font, $data[$k]);
            $title_x += $col_x + $x_padding * 2;

         
        }

        // 写入表格
        $temp_height = $title_height;


        //这里已经打印了title n 竖线。。没有横线
        foreach ($records as $key => $record) {
            //  continue;
            # code...
            $next_x = 0;
            $temp_height += $row_hight + $y_padding;
            // 画线 hengsye
            imageline($img, 0, $temp_height, $img_width, $temp_height, $bg_color);
            foreach ($record as $k => &$value) {
                if ($k == "result") {
                    require_once(__DIR__ . "/../../lib/paint.php");
                    $temp_x = 13;
                    $px_thick = 50;
                    $red_color = imagecolorallocate($img, 255, 0, 0);
                    $elipse_width = $elipse_height = 30;

                    $pos_x =  intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + 12;
                    $pos_y =  $temp_height - 20;
                    var_dump($pos_x . "  " . $pos_y);
                    $leftpad = 33;
                    draw_oval($img, $pos_x, $pos_y, $elipse_width, $elipse_height, $red_color, $px_thick);
                    $pos_x = $pos_x + $leftpad;
                    draw_oval($img, $pos_x, $pos_y, $elipse_width, $elipse_height, $red_color, $px_thick);
                    $pos_x = $pos_x + $leftpad;
                    draw_oval($img, $pos_x, $pos_y, $elipse_width, $elipse_height, $red_color, $px_thick);
                    $pos_x = $pos_x + $leftpad;
                    draw_oval($img, $pos_x, $pos_y, $elipse_width, $elipse_height, $red_color, $px_thick);
                    $pos_x = $pos_x + $leftpad;
                    draw_oval($img, $pos_x, $pos_y, $elipse_width, $elipse_height, $red_color, $px_thick);


                    $a = str_split($value);
                    $str = join("  ", $a);
                    $white_color = imagecolorallocate($img, 255, 255, 255);
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding)+4, $temp_height - $font_size / 2, $white_color, $font, $str);
                } else if ($k == 'zuhe') {
                    $strarr =  preg_split('/(?<!^)(?!$)/u', $value);
                    $color1 = $color2 = 0;

                    if ($strarr[0] == "小") {
                        $color2 = $small_1_color;
                    } else {
                        $color2 = $big_2_color;
                    }
                    if ($strarr[1] == "单") {
                        $color1 = $small_1_color;
                    } else {
                        $color1 = $big_2_color;
                    }

$a=trim($strarr[0]);  $b=trim($strarr[1]);
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $color1, $font, "" . $strarr[0]);
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + $big_small_with +0, $temp_height - $font_size / 2, $color2, $font, $strarr[1]);
                } elseif ($k == 'limit') {
                    $green_color = imagecolorallocate($img, 100, 149, 237);
                    if ($value == "龙") {
                        $text_color_black = imagecolorallocate($img, 0, 0, 0);

                        $color = $text_color_black;
                    } elseif ($value == "虎") {
                        $color =  $green_color;
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
                } else {
                    //qihao result sum
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
        $max = max([$a, $b]);
        $mid = max([$b, $c]);
        $min = min([$a, $b, $c]);
        if ($max == $a) {
            $max = max([$a, $mid]);
            $mid = min([$a, $mid]);
        } else {
            if ($max == $mid)
                $mid = max([$a, $c]);
            else {
                $mid = $b;
                $max = $c;
            }
        }

        $sub = $max - $min;
        $sub2 = $max - $mid;
        if ($sub == 2 && $sub2 == 1)
            return true;
        if ($this->special_mode == 3) {
            if ($max == 9 && $mid == 8 && $min == 0)
                return true;
            if ($max == 9 && $mid == 1 && $min == 0)
                return true;
            if ($max == 2 && $mid == 1 && $min == 0)
                return true;
        }
        return false;
    }

    //depx
    public function DrawFor($no, $result)
    {
        $lottery = Logs::getlotteryByNo($no);
        if (empty($lottery)) {
            return "没有找到奖期: $no 的记录";
        }
        $this->lottery_no = $no;
        $this->lottery_id = $lottery->Id;
        $hash = $result;
        $this->hash = $hash;
        $total_payout = 0;
        if ($this->special_mode == 3)
            $this->limit_special = 0;
        else
            $this->limit_special = 1000000;
        if (preg_match_all('/\d{1}+/', $hash, $matches)) {
            $arr = $matches[0];
            $count = count($arr);
            $card_types = [];
            $A = $arr[$count - 3];
            $B = $arr[$count - 2];
            $C = $arr[$count - 1];
            $tail = $C;
            $result = array($arr[$count - 3], $arr[$count - 2], $arr[$count - 1]);
            $result = array($arr[$count - 3], $arr[$count - 2], $arr[$count - 1]);


            // 和值
            $sum = $result[0] + $result[1] + $result[2];

            //13/14 特殊算法
            $special = $sum == 13 || $sum == 14 ? true : false;
            if ($this->special_mode === 0) {
                $special = false;
            }
            $text = "开奖数字: " . $result[0] . $result[1] . $result[2] . "\r\n";
            $text .= "数字计算: " . $result[0] . " + " . $result[1] . " + "  . $result[2] . " = " . $sum;
            $result_text = $result[0] . "+" . $result[1] . "+"  . $result[2] . "=" . $sum;
            $type = $this->result_type['和值'];
            $card_types[$type] = $sum;

            // 大小
            $big = $sum > 13 ? true : false;
            $b_text = $big ? "大" : "小";
            $type = $this->result_type[$b_text];
            $card_types[$type] = $this->special_odds[$b_text];

            // 单双
            $double = $sum % 2 ? false : true;
            $d_text = $double ? "双" : "单";
            $type = $this->result_type[$d_text];
            $card_types[$type] = $this->special_odds[$d_text];

            // 大/小双/单
            $type = $this->result_type[$b_text . $d_text];
            $card_types[$type] = $this->special_odds[$b_text . $d_text];

            $text = $text . " " . $b_text . " " . $d_text;
            $result_text = $result_text . " " . $b_text . $d_text;
            $limit = false;
            if ($sum < 6) {
                $b_text = "极小";
                $limit = true;
                $type = $this->result_type[$b_text];
                $card_types[$type] = $this->special_odds[$b_text];
            }
            if ($sum > 21) {
                $b_text = "极大";
                $limit = true;
                $type = $this->result_type[$b_text];
                $card_types[$type] = $this->special_odds[$b_text];
            }


            if ($limit)
                $result_text = $result_text . "|" . $b_text;

            // 牌型 顺子
            $t_text = "";
            $check = true;
            $straight = false;
            if ($this->special_mode != 3) {
                for ($i = 0; $i < 3; $i++) {
                    if ($result[$i] == 0) {
                        $check = false;
                        break;
                    }
                }
            }
            if ($check) {
                $straight = $this->checkStraight($result[0], $result[1], $result[2]);
            }


            if ($straight) {
                $t_text = "顺子";
                $result_text = $result_text . "|" . $t_text;
                $type = $this->result_type[$t_text];
                $card_types[$type] = $this->special_odds[$t_text];
            }

            // 豹子 | 对子
            $s_text = "";
            $p_text = "";
            $same = $result[0] == $result[1] ? $result[1] == $result[2] : false;

            $pair = false;
            if ($same) {
                $s_text = "豹子";
                $result_text = $result_text . "|" . $s_text;
                $type = $this->result_type[$s_text];
                $card_types[$type] = $this->special_odds[$s_text];
            } elseif ($result[0] == $result[1] || $result[0] == $result[2] || $result[1] == $result[2]) {
                $pair = true;
                $p_text = "对子";
                $result_text = $result_text . "|" . $p_text;
                $type = $this->result_type[$p_text];
                $card_types[$type] = $this->special_odds[$p_text];
            }

            if ($this->special_mode == 3) {
                if ($straight || $pair || $same)
                    $special = true;
            }

            // 杂6
            if (false) {
                $six = false;
                $six_text = "";
                if (!$straight && !$same && !$pair) {
                    //if($result[0] < 6 && $result[1] < 6 && $result[2] < 6)
                    {
                        $six = true;
                        $six_text = "杂六";
                        $result_text = $result_text . "|" . $six_text;
                        $type = $this->result_type[$six_text];
                        $card_types[$type] = $this->special_odds[$six_text];
                    }
                }
            }

            if ($tail != 0 && $tail != 9) {
                // 尾 单双
                $t_double = $tail % 2 ? false : true;
                $type = $this->result_type['尾单双'];
                $card_types[$type] = $t_double ? 1 : 0;
                // 尾 大小
                $t_big = $tail > 4 ? true : false;
                $type = $this->result_type['尾大小'];
                $card_types[$type] = $t_big ? 1 : 0;

                // 尾 组合
                $type = $this->result_type['尾组合'];
                // 小双
                if ($t_double && !$t_big) {
                    $card_types[$type] = 0;
                }
                //小单
                elseif (!$t_big && !$t_double) {
                    $card_types[$type] = 1;
                }
                // 大双
                elseif ($t_big && $t_double) {
                    $card_types[$type] = 2;
                }
                // 大单
                else
                    $card_types[$type] = 3;

                // 尾 数 0/9 通杀
                $type = $this->result_type['尾数'];
                $card_types[$type] = $tail;
            }

            $text .= " " . "尾$tail";

            // A
            $double = $A % 2 ? false : true;
            $type = $this->result_type['A单双'];
            $text = "\r\n" . $text . "A" . $A . " ";
            if ($double)
                $text = $text . "双";
            else
                $text = $text . "单";
            $card_types[$type] = $double ? 1 : 0;
            $big = $A > 4 ? true : false;
            if ($big)
                $text = $text . "|大";
            else
                $text = $text . "|小";
            $type = $this->result_type['A大小'];
            $card_types[$type] = $big ? 1 : 0;
            // 组合
            $type = $this->result_type['A组合'];
            // 小双
            if ($double && !$big) {
                $card_types[$type] = 0;
            }
            //小单
            elseif (!$big && !$double) {
                $card_types[$type] = 1;
            }
            // 大双
            elseif ($big && $double) {
                $card_types[$type] = 2;
            }
            // 大单
            else
                $card_types[$type] = 3;
            $type = $this->result_type['A数字'];
            $card_types[$type] = $A;
            $text = $text . "\r\n";

            // B
            $double = $B % 2 ? false : true;
            $type = $this->result_type['B单双'];
            $text = $text . "B" . $B . " ";
            $card_types[$type] = $double ? 1 : 0;
            if ($double)
                $text = $text . "双";
            else
                $text = $text . "单";
            $big = $B > 4 ? true : false;
            if ($big)
                $text = $text . "|大";
            else
                $text = $text . "|小";
            $type = $this->result_type['B大小'];
            $card_types[$type] = $big ? 1 : 0;
            // 组合
            $type = $this->result_type['B组合'];
            // 小双
            if ($double && !$big) {
                $card_types[$type] = 0;
            }
            //小单
            elseif (!$big && !$double) {
                $card_types[$type] = 1;
            }
            // 大双
            elseif ($big && $double) {
                $card_types[$type] = 2;
            }
            // 大单
            else
                $card_types[$type] = 3;
            $type = $this->result_type['B数字'];
            $card_types[$type] = $B;
            $text = $text . "\r\n";

            // C
            $double = $C % 2 ? false : true;
            $text = $text . "C" . $C . " ";
            $type = $this->result_type['C单双'];
            if ($double)
                $text = $text . "双";
            else
                $text = $text . "单";
            $card_types[$type] = $double ? 1 : 0;
            $big = $C > 4 ? true : false;
            if ($big)
                $text = $text . "|大";
            else
                $text = $text . "|小";
            $type = $this->result_type['C大小'];
            $card_types[$type] = $big ? 1 : 0;
            // 组合
            $type = $this->result_type['C组合'];
            // 小双
            if ($double && !$big) {
                $card_types[$type] = 0;
            }
            //小单
            elseif (!$big && !$double) {
                $card_types[$type] = 1;
            }
            // 大双
            elseif ($big && $double) {
                $card_types[$type] = 2;
            }
            // 大单
            else
                $card_types[$type] = 3;
            $type = $this->result_type['C数字'];
            $card_types[$type] = $C;
            $text = $text . "\r\n";


            //计算输赢
            $bet_types = BetTypes::select()->toArray();
            $win_bet_ids = [];
            foreach ($bet_types as $i => $v) {
                if (isset($card_types[$v['type']])) {
                    if (
                        $v['type'] == $this->result_type['和值']
                        || $v['type'] == $this->result_type['尾数']
                        || $v['type'] ==  $this->result_type['尾单双']
                        || $v['type'] ==  $this->result_type['尾大小']
                        || $v['type'] ==  $this->result_type['尾组合']
                        || $v['type'] ==  $this->result_type['A大小']
                        || $v['type'] ==  $this->result_type['A单双']
                        || $v['type'] ==  $this->result_type['A组合']
                        || $v['type'] ==  $this->result_type['A数字']
                        || $v['type'] ==  $this->result_type['B大小']
                        || $v['type'] ==  $this->result_type['B单双']
                        || $v['type'] ==  $this->result_type['B组合']
                        || $v['type'] ==  $this->result_type['B数字']
                        || $v['type'] ==  $this->result_type['C大小']
                        || $v['type'] ==  $this->result_type['C单双']
                        || $v['type'] ==  $this->result_type['C组合']
                        || $v['type'] ==  $this->result_type['C数字']
                    ) {
                        if ($v['value'] == $card_types[$v['type']]) {
                            $win_bet_ids[$v['Id']] = 0;
                        }
                    } else {
                        // 5.0 赔率
                        if ($this->special_mode ==  2 && $special) {
                            if (
                                $v['type'] != $this->result_type['大单'] &&
                                $v['type'] != $this->result_type['大双'] &&
                                $v['type'] != $this->result_type['小单'] &&
                                $v['type'] != $this->result_type['小双']
                            ) {
                                $win_bet_ids[$v['Id']] = $card_types[$v['type']];
                            }
                        } else {
                            $win_bet_ids[$v['Id']] = $card_types[$v['type']];
                        }
                    }
                }
            }
            //print_r($win_bet_ids);
            $records = Logs::getBetRecordByLotteryNo($this->lottery_no);


            $players = [];
            // bet_records需要跟新字段 Payout,Status,ResultId,Rebate
            $records_update = [];
            // 特殊计算 需要先统计这期玩家的总下注
            if ($special) {
                foreach ($records as $k => $v) {
                    $user_id = $v['UserId'];
                    if (!isset($players[$user_id])) {
                        $user = $this->userDb->findByUserId($user_id);
                        $players[$user_id] = [
                            'bet' => 0,
                            'payout' => 0,
                            'player' => new Player($user),
                        ];
                    }
                    $players[$user_id]['bet'] += $v['Bet'];
                }
            }

            foreach ($records as $k => $v) {
                $record_id = $v['Id'];
                $user_id = $v['UserId'];
                $betType_id = $v['Type'];
                if (!isset($players[$user_id])) {
                    $user = $this->userDb->findByUserId($user_id);
                    $players[$user_id] = [
                        'bet' => 0,
                        'payout' => 0,
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

                // 非特殊情况,这里要累计
                if (!$special)
                    $players[$user_id]['bet'] += $v['Bet'];

                if (isset($win_bet_ids[$betType_id])) {
                    if (!$special || $win_bet_ids[$betType_id] == 0) {
                        $odds = $v['Odds'];
                        //echo $odds;
                    } else {
                        if ($players[$user_id]['bet'] >= $this->limit_special && $special && $win_bet_ids[$betType_id] != 0) {
                            $odds = 1;
                        } else
                            $odds = $win_bet_ids[$betType_id];
                    }

                    $payout = $v['Bet'] * $odds;
                    //echo $players[$user_id]['player']->getName() . "+" . $v['Bet'] . "x" . $odds. "</br>";
                    // Rebate还没有计算过,暂时搁浅
                    $players[$user_id]['payout'] += $payout;
                    $update['Payout'] = $payout;
                    $total_payout += $payout;
                }
                array_push($records_update, $update);
            }


            if (!$records->isEmpty()) {
                // 开奖记录更新
                Logs::addlotteryResult($this->lottery_no, $text, $total_payout);
            }

            $text  = $text . "<br/>"
                . "=====本期中奖名单======" . "<br/>";

            foreach ($players as $id => $v) {
                $player = $v['player'];
                $income = $v['payout'] - $v['bet'];
                // 玩家需要更新字段,Total_Payout;
                // 玩家的日报需要更新字段 PayoutAmount,Income;
                // 结算之后计入玩家流水
                $player->win($v['bet'], $v['payout'], $income);
                $text = $text . $player->getName() . "【" . $player->getId() . "】" . number_format($income / 100.0, 2, ".", "") . "<br/>";
                //array_push($temp_arr, array('player' => $player, 'income' => $income));
            }

            $bet_recoreds = new BetRecord();
            $bet_recoreds->saveAll($records_update);


            $this->result = $text;
        }
        return $this->result;
    }


    //  对讲计算
    public function DrawLotteryV2($hash)
    {

        $log_txt = __METHOD__ . json_encode(func_get_args());

        \think\facade\Log::debug($log_txt);

        //    \think\facade\Log::debug ( debug_backtrace());

        $lineNumStr = "  " . __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__ . " m:" . __METHOD__ . "  ";
        \think\facade\Log::debug($lineNumStr);
        $total_payout = 0;
        \think\facade\Log::debug("bef getKaijNumFromBlkhash:" . $hash);
        require_once  __DIR__ . "/../lotrySsc.php";

        $kaij_num = getKaijNumFromBlkhash($hash);
        $result_text = $kaij_num;
        \think\facade\Log::debug("aft getKaijNumFromBlkhash:" . $hash);
        //if not inc number exit prcs
        if (!preg_match('/\d{1}+/', $hash))
            return;
        //计算输赢
        $bet_types = BetTypes::select()->toArray();
        $win_bet_ids = [];

        //print_r($win_bet_ids); 
        var_dump($this->lottery_no);
        //select from  BetRecord
        $records = Logs::getBetRecordByLotteryNo($this->lottery_no);
        //var_dump( $records);
        var_dump(count($records));
        $players = [];    //zhonjyo wanja
        // bet_records需要跟新字段 Payout,Status,ResultId,Rebate
        $records_update = [];  //中奖记录
        $temp_arr = [];  //榜单显示临时变量
        //---------------------#开始计算输赢   得到中奖玩家名单 get bingo user lst
        foreach ($records as $k => $v) {
            $record_id = $v['Id'];
            $user_id = $v['UserId'];  //tg id
            $betType_id = $v['Type'];


            //-------------###判断输赢
            $betContext = $v['BetContent'];
            $wanfa = getWefa($betContext);

            $lineNumStr = "  " . __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__ . " m:" . __METHOD__ . "  ";
            $logtxt = " dwijyo() betnumL:" . $betContext . "  kaijnum:" . $kaij_num  . $lineNumStr;
            var_dump($logtxt);
            \think\facade\Log::info($lineNumStr);
            \think\facade\Log::info($logtxt);
            $player = $v['player'];
            $income = $payout - $v['Bet'];
            var_dump($income);
            $user = $this->userDb->findByUserId($user_id);
            $player = new \app\common\Player($user);
            if (!dwijyo($betContext, $kaij_num)) {
                \think\facade\Log::info("dwijyuo rzt false");
                var_dump("dwijyuo rzt false");
            } else {
                var_dump("dwijyuo rzt true");
                \think\facade\Log::info("dwijyuo rzt true");
                $odds = $v['Odds'];
                var_dump($odds);
                var_dump($v);
                $payout = $v['Bet'] * $odds;
                var_dump($payout);
                //---------------------### 赢家 结算之后计入玩家流水----------------------



                // 玩家需要更新字段,Total_Payout;
                // 玩家的日报需要更新字段 PayoutAmount,Income;
                // 结算之后计入玩家流水

                //  var_dump(  $user);
                // $user['']
                var_dump($user);
                \think\facade\Db::name('bet_record')
                    ->where('userid', $user_id)->where('id', $record_id)
                    ->update(['Payout' => $payout]);
            }

            //  win （betAmt,PaybackAmt,IncomeAmt
            //不管输赢都要计算流水
            $player->win($v['Bet'], $payout, $income);



            ////======-------------================= 回显榜单 zhun背
            // Rebate还没有计算过,暂时搁浅
            //   $user_id=12;
            //    array_push($temp_arr, array('player' => $player, 'income' => $income));

            $total_payout += $payout;
        }
        //  结束对讲


        //--------------------- #开奖记录更新  updt 本期中将结果总结过统计
        // updt  LotteryLog
        var_dump($total_payout);
        // Attempt to assign property "Payouts" on null     result_text jsut kaijnum
        Logs::addlotteryResult($this->lottery_no, $result_text, $total_payout);
        ////======-------------=================#回显榜单

        $kaij_num_fly_echo = "";


        $text = "第" . $this->lottery_no . "期开奖结果" .  $result_text . "\r\n";
        $text  = $text
            .   kaij_echo_x($result_text) . PHP_EOL
            . "=====本期中奖名单======" . "\r\n";
        // $helper = new Helper();
        //  $helper->BubbleSort1($temp_arr, 'income');

        $text = $text . $this->calcIncome($this->lottery_no);




        $lineNumStr = __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__ . " m:" . __METHOD__ . "  ";
        // var_dump($lineNumStr);
        \think\facade\Log::info($lineNumStr);
        \think\facade\Log::info("text:" . $text);
        var_dump("text:" . $text);
        $this->result = $text;

        //end   if (preg_match_all
        $this->game_state = 'next';
        return  $text;
    }


    public function kaij_echo_x($result_text)
    {

        try {
            return kaij_echo($result_text);
        } catch (\Throwable $exception) {

            $lineNumStr = __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__ . " m:" . __METHOD__ . "  ";
            \think\facade\Log::error(" kaij_echo($result_text)");
            \think\facade\Log::error("errmsg:" . $exception->getMessage());
            \think\facade\Log::error("file_linenum:" . $exception->getFile() . ":" . $exception->getLine());
            \think\facade\Log::error("errtraceStr:" . $exception->getTraceAsString());
            return "";
        }
    }


    public function calcIncome($lotteryno)
    {
        try {
            $a = [];
            $rows =  \think\facade\Db::name('bet_record')->where('lotteryno', '=', $lotteryno)->select();
            //  var_dump( $rows);
            //  var_dump( $rows[0]['UserName']);
            foreach ($rows as $row) {
                $betamt = $row['Bet'] / 100;

                var_dump($row['Payout'] / 100);
                var_dump($betamt);
                $payout = $row['Payout'];
                var_dump($row['Payout'] / 100 - $betamt);
                $income = $row['Payout'] / 100 -  $betamt;
                $uid = $row['UserId'];
                $uname = $row['UserName'];
                $bettx = $row['BetContent'];
                $txt = "$uname [$uid] $bettx 下注金额:$betamt 盈亏: $income \r\n";
                var_dump($txt);
                $a[] = $txt;
            }
            return join("", $a);
        } catch (\Throwable $exception) {
            $lineNumStr = __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__ . " m:" . __METHOD__ . "  ";
            \think\facade\Log::error("----------------errrrr5---------------------------");
            \think\facade\Log::error("file_linenum:" . $exception->getFile() . ":" . $exception->getLine());
            \think\facade\Log::error("errmsg:" . $exception->getMessage());
            \think\facade\Log::error("errtraceStr:" . $exception->getTraceAsString());
            var_dump($exception);
            return "";
            // throw $exception; // for test
        }
    }

    public function Next()
    {
        $data = $this->lottery->get_current_no();
        if (is_bool($data)) return false;
        $this->lottery_no = $data['lottery_no'];
        $this->hash_no = $data['hash_no'];
        $this->elapsed_time = time(); // - $data['opentime'];
        $this->elapsed_time *= 1000;
        $today = date("Y-m-d", time());
        $log = Logs::addLotteryLog($today, $this->lottery_no, $this->hash_no);
        $this->lottery_id = $log->id;
        $set = Setting::find(3);
        $set->value = 0;
        $set->save();
        $this->chat_id = Setting::find(2)->value;
        $this->special_mode = intval(Setting::find(10)->value);
        $this->game_state = 'waiting_bet';
        return true;
    }


    public function isStop()
    {
        return Setting::find(4)->value;
    }

    //===================================================================================================================================

    /**
     * curl请求
     * @param string $url
     * @param null $data
     * @param array $header
     * @return bool|string
     */
    protected function http_request($url = '', $data = null, $header = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, $header);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_TIMEOUT, 180);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    protected function http_async_request($url = '', $data = [], $heard = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_HEADER, $heard);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}
