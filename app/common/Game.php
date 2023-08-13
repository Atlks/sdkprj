<?php

declare(strict_types=1);

namespace app\common;

use app\common\Player;
use app\model\User;
use app\model\Config;
use app\model\BetTypes;
use app\model\BotWords;
use app\common\Logs;
use app\model\Setting;
use app\common\helper;
use app\model\GameString;
use think\log;

class Game
{
    // 当前玩家
    private $player = null;
    // 用户数据库
    private $userDB = null;
    private $bet_types = null;
    // 游戏配置
    // 单局总下注限制
    private $total_limit = null;
    // 单局单个玩家下注限制
    private $bet_limit = null;
    // 单局单个玩家最大赔付
    private $payout_limit = null;
    // 最小下注
    private $min_limit = null;

    private $command = [];
    private $exec_pattern = null;

    public $bot_words;
    private $replace_keyword = [
        "【用户】" => 'playerName',
        "【id】" => 'playerId',
        "【换行】" => "w_enter",
        "【金额】" => "w_amount",
    ];

    // 游戏相关
    public $lottery_no = 0;
    // 群信息相关
    private $message_id = 0;
    private $action = false;
    private $parse_mode = null;
    private $trend = false;
    public $keyboard = "";

    private $use_paybot = false;

    public function __construct($from = null)
    {
        $this->userDB = new User();
        $config = Config::find(1);
        $this->setup($config);
        $this->bet_types = BetTypes::select()->toArray();
        $this->lottery_no = Logs::get_last_lottery_log()['No'];
        if (!empty($from)) {
            $this->getPlayer($from);
        }
        $bot_words = BotWords::where('Id', 1)->find();

        $this->bot_words =
            [
                '下注余额不足' => $bot_words->Bet_Failed,
                '下分申请成功' => $bot_words->Withdraw_Finish,
                '上分申请成功' => $bot_words->Recharge_Finish,
                '上分公告' => $bot_words->Recharge_Tips,
            ];

        $this->use_paybot = env('app.use_paybot', false);
    }

    private function addCommand($cmd_str, $call_back, $regx_str = null)
    {
        $out = preg_split('/\||\x20/', $cmd_str);
        foreach ($out as $k => $v) {
            if (!empty($regx_str) && is_string($regx_str)) {
                $v = $v . $regx_str;
            }
            $this->command[$v] = $call_back;
        }
    }

    private function getWords($type)
    {
        $text = "";

        if (isset($this->bot_words[$type])) {
            $text = $this->bot_words[$type];
            foreach ($this->replace_keyword as $k => $v) {
                $text = preg_replace('/' . $k . '/u', $this->$v(), $text);
            }
        }
        return $text;
    }

    private function playerId()
    {
        if ($this->player)
            return $this->player->getId() . "";
        return "";
    }

    private function playerName()
    {
        if ($this->player)
            return $this->player->getName();
        return "";
    }

    private function w_enter()
    {
        return "\r\n";
    }

    private function w_amount()
    {
        return "0";
    }

    public function setup($config)
    {
        $this->total_limit = $config['Total_limit'];
        $this->bet_limit = $config['Bet_limit'];
        $this->payout_limit = $config['Payout_limit'];
        $this->min_limit = $config['Min_limit'];
        // 指令和函数绑定

        $this->addCommand($config['Balance'], 'callBalance');
        $this->addCommand($config['Rollover'], 'callRollover');
        $this->addCommand($config['CancelAll'], 'callCancelAll');
        $this->addCommand($config['Cancel'], 'callCancel');
        $this->addCommand($config['Withdraw'], 'callWithdraw', "\d+$");
        $this->addCommand($config['LastRecord'], 'callLastRecord');
        $this->addCommand($config['Results'], 'callResults');
        $this->addCommand($config['Address'], 'callAddress');
        $this->addCommand($config['Rebate'], 'callRebate');
        $this->addCommand($config['Recharge'], 'callRecharge', "\d+$");
        $this->addCommand($config['Trend'], 'callResults');
        $this->addCommand("汇旺", "callHuiOne");
        //$this->addCommand($config['Trend'], 'callTrend', "\d+$");

        $pattern = null;
        foreach ($this->command as $key => $value) {

            $pattern = $pattern === null ? $key : $pattern . "|" . $key;
        }

        $this->exec_pattern = '/^(' . $pattern . ')$/u';
    }

    public function receive($message_id)
    {
        $this->message_id = $message_id;
    }

    public function action()
    {
        return $this->action;
    }

    public function sendTrend()
    {
        return $this->trend;
    }

    public function parse_mode()
    {
        return $this->parse_mode;
    }

    public function createPlayer($id, $full_name, $user_name)
    {
        if ($this->getPlayer($id)) {
            return "请勿重复注册,避免被永久踢出群";
        }
        $data = [
            'Tg_Id' => $id,
            'FullName' => $full_name,
            'UserName' => $user_name,
        ];
        $res = User::create($data);
        if (empty($res)) {
            return "注册失败";
        }
        $this->getPlayer($id);
        return "注册成功";
    }

    public function getPlayer($id)
    {
        $data = $this->userDB->findByUserId($id);
        if (!empty($data))
            $this->player = new Player($data);
        else
            $this->player = null;
        return $this->player;
    }


    public function regex_betV2($content)
    {
        if (!$this->player) return;
        $config = Config::find(1);
        $this->min_limit = $config['Min_limit'];
        $total_bet_amount = 0;

        $regext_first = '/^[1-9]/';
        // ABC组合位
        $pattern_abc_zuhe = null;
        // 组合
        $pattern_zuhe = null;
        $pattern = null;

        // 先判断
        $text = $content;

        $bet_types = [];
        foreach ($this->bet_types as $type) {
            array_push($bet_types, $type['Regex']);
        }

        $first = preg_match($regext_first, $content);

        foreach ($bet_types as $v) {
            if (preg_match('/^' . $v . '/iu', $text)) {
                $first = false;
            }
        }

        foreach ($bet_types as $v) {

            if (preg_match('/^[A-C]大双$|^[A-C]大单$|^[A-C]小双$|^[A-C]小单$/iu', $v)) {
                $pattern_abc_zuhe = $pattern_abc_zuhe === null ? $v . "[1-9]\d+" : $pattern_abc_zuhe . "|" . $v . "[1-9]\d+";
            }

            if (preg_match('/^大单$|^大双$|^小单$|^小双$|^尾大双$|^尾大单$|^尾小双$|^尾小单$/u', $v)) {
                if ($first) {
                    $pattern_zuhe = $pattern_zuhe === null ? "[1-9]\d+" . $v : $pattern_zuhe . "|" . "[1-9]\d+" . $v;
                } else {
                    $pattern_zuhe = $pattern_zuhe === null ?  $v . "[1-9]\d+" : $pattern_zuhe . "|" . $v . "[1-9]\d+";
                }
            } else if (preg_match('/^尾双$|^尾单$|^尾小$|^尾大$/u', $v)) {
                if ($first) {
                    $pattern = $pattern === null ?  "[1-9]\d+" . $v : $pattern . "|" . "[1-9]\d+" . $v;
                } else {
                    $pattern = $pattern === null ?  $v . "[1-9]\d+" : $pattern . "|" . $v . "[1-9]\d+";
                }
            } else if (preg_match('/^[大|小|单|双]$/u', $v)) {
                if ($first) {
                    $pattern = $pattern === null ?  "[1-9]\d+" . $v : $pattern . "|" . "[1-9]\d+" . $v;
                } else {
                    $pattern = $pattern === null ?  $v . "[1-9]\d+" : $pattern . "|" . $v . "[1-9]\d+";
                }
            } else {
                $pattern = $pattern === null ?  $v . "[1-9]\d+" : $pattern . "|" . $v . "[1-9]\d+";
            }
        }

        $pattern_abc_zuhe = '/' . $pattern_abc_zuhe . '/iu';
        $pattern = '/' . $pattern . '/iu';
        $pattern_zuhe = '/' . $pattern_zuhe . '/u';
        //下注语句 array
        $bet_str = [];
        /*
        if (preg_match_all($pattern_abc_zuhe, $text, $out)) {
            foreach ($out[0] as $bet) {
                $text = preg_replace('/' . $bet . '/iu', "", $text, 1);
                array_push($bet_str, $bet);
            }
        }
*/
        if (preg_match_all($pattern_zuhe, $text, $out)) {
            foreach ($out[0] as $bet) {
                $text = preg_replace('/' . $bet . '/u', "", $text, 1);
                array_push($bet_str, $bet);
            }
        }

        if (preg_match_all($pattern, $text, $out)) {
            foreach ($out[0] as $bet) {
                $text = preg_replace('/' . $bet . '/iu', "", $text, 1);
                array_push($bet_str, $bet);
            }
        }
        $text = preg_replace('/\ /', "", $text);
        if (!empty($text))
            return "下注命令错误";

        $before_bet = $this->player->getBetRecord($this->lottery_no);
        $bets = array();
        $text = "";
        foreach ($bet_str as $str) {
            foreach ($this->bet_types as $t) {
                $match = false;
                if (preg_match('/^' . $t['Regex'] . '\d+$/iu', $str, $out)) {
                    $type = $t;
                    $temp = preg_replace('/^' . $t['Regex'] . '/iu', "", $str);
                    preg_match('/\d+/', $temp, $m);
                    $amount = intval($m[0]) * 100;
                    $match = true;
                } else if (preg_match('/^\d+' . $t['Regex'] . '$/iu', $str, $out)) {
                    $type = $t;
                    $temp = preg_replace('/' . $t['Regex'] . '$/iu', "", $str);
                    preg_match('/\d+/', $temp, $m);
                    $amount = intval($m[0]) * 100;
                    $match = true;
                }
                if ($match) {
                    $bet_text = $type['Display'];
                    $bet_text = $bet_text . " " . $amount / 100;
                    $bet = [
                        'bet_type' => $type,
                        'text' => $bet_text,
                        'amount' => $amount,
                    ];

                    if ($bet['amount'] == 0)
                        break;

                    $min = $type['Bet_Min'];
                    if ($min <= 0)
                        $min = $this->min_limit;
                    if ($bet['amount'] < $min) {
                        return $text = "没有达到最小下注:" . $min / 100;
                    }

                    if ($bet['amount'] > $type['Bet_Max']) {
                        return $text = "超过单笔的最大下注,限额:" . $type['Bet_Max'] / 100;
                    }

                    if (isset($before_bet[$type['Id']]))
                        $before_bet[$type['Id']] += $bet['amount'];
                    else
                        $before_bet[$type['Id']] = $bet['amount'];

                    if ($before_bet[$type['Id']] > $type['Bet_Max_Total']) {
                        return $text = "超过总最大下注,限额:" . $type['Bet_Max_Total'] / 100;
                    }

                    $text = $text . $bet_text . "(" . $type['Odds'] . "赔率)\r\n";
                    $total_bet_amount += $bet['amount'];

                    array_push($bets, $bet);
                }
            }
        }

        if ($total_bet_amount > $this->player->getBalance(false)) {
            return $this->getWords('下注余额不足');
        }

        if (count($bets) > 0) {
            $this->action = true;
            $text = $text . "\r\n";

            foreach ($bets as $key => $value) {
                if (!$this->player->Bet($value['amount'], $this->lottery_no, $value['text'], $value['bet_type'])) {
                    $text = "下注失败:" . $this->player->get_last_error();
                    $this->action = false;
                    return $text;
                }
            };

            $current_bets = $this->player->getBetRecord($this->lottery_no);
            $text = "";
            foreach ($current_bets as $k => $v) {
                $res = BetTypes::where('Id', $k)->find();
                $text .= $res->Display . "-" . $v / 100 . "(" . $res->Odds . "赔率)\r\n";
            }

            $text =
                "【" . $this->player->getName() . '-' . $this->player->getId() . '】' . "\r\n"
                . '下注内容：' . "\r\n"
                . $text
                . "\r\n"
                . "余额:" . $this->player->getBalance();
            return $text;
        }

        return "";
    }

    public function regex_bet($content)
    {
        if (!$this->player) return;
        $config = Config::find(1);
        $this->min_limit = $config['Min_limit'];
        // 再判断是否是下注的指令
        // 先查询[最大2位数字][中文|.][金额] 这种模式   exp: 10.100 10杀100 10押100
        // 再查询[中文][数字] | [数字][中文] 这种模式   exp: 双100 100小单
        $pattern = "/\d{1,2}[\x{4e00}-\x{9fa5}|\D]{1}\d+|\d+[\x{4e00}-\x{9fa5}]{1,2}|[\x{4e00}-\x{9fa5}]{1,2}\d+/u";
        $total_bet_amount = 0;
        $str2 = preg_replace($pattern, '', $content);
        $str2 = preg_replace('/\ /', '', $str2);
        $notOnlyBetText = false;
        if (!empty($str2)) {
            $notOnlyBetText = true;
        }
        if (preg_match_all($pattern, $content, $string_list)) {
            $bet_string_list = $string_list[0];
            if ($notOnlyBetText)
                return "下注命令错误";
            $before_bet = $this->player->getBetRecord($this->lottery_no);
            $bets = array();
            $text = "";
            foreach ($bet_string_list as $k => $v) {
                $match = false;
                $error = false;
                $ag_regx = '/^\d{1,2}[\x{4e00}-\x{9fa5}.]{1}/u';
                if (preg_match($ag_regx, $v, $out)) {
                    $bet_str = $out[0];

                    foreach ($this->bet_types as $key => $type) {
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
                            if ($min <= 0)
                                $min = $this->min_limit;
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

                            if (isset($before_bet[$type['Id']]))
                                $before_bet[$type['Id']] += $bet['amount'];
                            else
                                $before_bet[$type['Id']] = $bet['amount'];

                            if ($before_bet[$type['Id']] > $type['Bet_Max_Total']) {
                                $text = "超过总最大下注,限额:" . $type['Bet_Max_Total'] / 100;
                                $error = true;
                                break;
                            }
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
                            if ($min <= 0)
                                $min = $this->min_limit;
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

                            if (isset($before_bet[$type['Id']]))
                                $before_bet[$type['Id']] += $bet['amount'];
                            else
                                $before_bet[$type['Id']] = $bet['amount'];

                            if ($before_bet[$type['Id']] > $type['Bet_Max_Total']) {
                                $text = "超过总最大下注,限额:" . $type['Bet_Max_Total'] / 100;
                                $error = true;
                                break;
                            }

                            array_push($bets, $bet);
                            //$text = $text . $bet_text . "(" . $type['Odds'] . "赔率)";
                            $match = true;
                            break;
                        }
                    }
                } else {
                    foreach ($this->bet_types as $key => $type) {
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
                            if ($min <= 0)
                                $min = $this->min_limit;
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

                            if (isset($before_bet[$type['Id']]))
                                $before_bet[$type['Id']] += $bet['amount'];
                            else
                                $before_bet[$type['Id']] = $bet['amount'];

                            if ($before_bet[$type['Id']] > $type['Bet_Max_Total']) {
                                $text = "超过总最大下注,限额:" . $type['Bet_Max_Total'] / 100;
                                $error = true;
                                break;
                            }

                            array_push($bets, $bet);
                            //$text = $text . $bet_text . "(" . $type['Odds'] . "赔率)";
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

                if ($total_bet_amount > $this->player->getBalance(false)) {
                    return $this->getWords('下注余额不足');
                }

                $this->action = true;
                //$text = $text . "\r\n";
            }


            foreach ($bets as $key => $value) {
                if (!$this->player->Bet($value['amount'], $this->lottery_no, $value['text'], $value['bet_type'])) {
                    $text = "下注失败:" . $this->player->get_last_error();
                    $this->action = false;
                    return $text;
                }
            };

            $current_bets = $this->player->getBetRecord($this->lottery_no);
            $text = "";
            foreach ($current_bets as $k => $v) {
                $res = BetTypes::where('Id', $k)->find();
                $text .= $res->Display . "-" . $v / 100 . "(" . $res->Odds . "赔率)\r\n";
            }

            $text =
                "【" . $this->player->getName() . '-' . $this->player->getId() . '】' . "\r\n"
                . '下注内容：' . "\r\n"
                . $text
                . "\r\n"
                . "余额:" . $this->player->getBalance();
            return $text;
        }

        return "";
    }


    public function player_exec($text, $stop_bet = false)
    {
        // 先判断是否是执行一般指令
        if (preg_match($this->exec_pattern, $text, $cmd)) {
            if (preg_match('/\d+$/u', $cmd[0], $test)) {
                $cmd[0] = substr($cmd[0], 0, -strlen($test[0])) . "\d+$";
            }
            $func = $this->command[$cmd[0]];
            if (!empty($func)) {
                return $this->$func($text);
            }
        }

        if ($stop_bet) return "封盘时请不要下注!";
        $res = $this->regex_betV2($text);

        return $res;
    }


    public function callBalance($text = null)
    {
        if ($this->player) {
            return    "用户ID: " . $this->player->getId() . "\r\n"
                . "用户名: " . $this->player->getName() . "\r\n"
                . "余额: " . $this->player->getBalance() . "\r\n"
                . "输赢: " . $this->player->getIncome();
        }

        return "";
    }

    public function callRollover($text = null)
    {
        $text = "";
        if ($this->player) {
            $text =  "用户ID: " . $this->player->getId() . "\r\n"
                . "余额: " . $this->player->getBalance() . "\r\n"
                . "流水: " . $this->player->getRollover() . "\r\n"
                . "输赢: " . $this->player->getIncome();
        }
        return $text;
    }

    public function queryRollover()
    {
        $text = "";
        if ($this->player) {
            $text =  "用户ID: " . $this->player->getId() . "\r\n"
                . "余额: " . $this->player->getBalance() . "\r\n"
                . "总流水: " . $this->player->getTotalRollover() . "\r\n"
                . "输赢: " . $this->player->getIncome();
        }
        return $text;
    }

    public function callCancelAll($text = null)
    {
        if ($this->player) {
            if (Setting::find(3)->value == 1)
                return "封盘时不能取消注单";
            $this->player->cancel($this->lottery_no);
        }
        return "本期下注已为您取消";
    }

    public function callCancel($text = null)
    {
        return $this->callCancelAll($text);
    }

    public function callWithdraw($text = null)
    {
        if ($this->player) {
            if (preg_match('/\d+/', $text, $out)) {
                $amount = $out[0] * 100;
                if ($amount > 9000000000) return "";
                if ($this->player->getBalance(false) < $amount) {
                    return "您的余额不足";
                }
                if ($this->use_paybot) {
                    $text = "上下分步骤：\n1️⃣入款流程：点击下方【充值提现】\n2️⃣点击菜单【充值】复制上分地址充值\n3️⃣成功到帐后自动到游戏余额 无需查分!";
                    $this->keyboard = json_decode(GameString::where('name', '上分机器人')->find()->text);
                    if ($this->player->isTest()) {
                        if (!$this->player->Withdraw($amount, $this->message_id, "")) {
                            $text = $this->player->get_last_error();
                            $this->keyboard = null;
                        }
                    }
                } else {
                    if ($this->player->Withdraw($amount, $this->message_id, "")) {
                        $text = $this->getWords('下分申请成功');
                    } else {
                        $text = $this->player->get_last_error();
                    }
                }
                return $text;
            }
        }
        return "";
    }

    public function callLastRecord($text = null)
    {
        $text = "";
        if ($this->player) {
            $records = $this->player->getRecords(5);
            $text =  "期数        类型    金额    盈亏" . "\r\n";
            foreach ($records as $k => $v) {
                $type = preg_replace('/\-\d+$/u', "", $v['BetContent']);
                //$text .= mb_strlen ($type) . "\n";
                $length = mb_strlen($type);
                $money = $v['Bet'] / 100;
                $text = $text
                    . $v['LotteryNo']
                    . " " . $type;

                if ($length == 1)
                    $text .= "       " . $money;
                elseif ($length == 2)
                    $text .= "   " . $money;
                else {
                    $text .= "  " . $money;
                }

                $payout = $v['Payout'] / 100;
                $income = $payout - $money;
                $text .=  "   " . $income . "\r\n";
            }
        }
        //$text = Helper::replace_markdown($text);
        //$text = "```\n" . $text . "```";
        //$this->parse_mode = "MarkdownV2";
        return $text;
    }

    public function callResults($text = null)
    {
        $this->trend = true;
        return "开奖结果查询";
    }

    public function callAddress($text = null)
    {
        if ($this->use_paybot) {
            $text = "上下分步骤：\n1️⃣入款流程：点击下方【充值提现】\n2️⃣点击菜单【充值】复制上分地址充值\n3️⃣成功到帐后自动到游戏余额 无需查分!";
            $this->keyboard = json_decode(GameString::where('name', '上分机器人')->find()->text);
        } else {
            $text = $this->getWords("上分公告");
            $this->parse_mode = "MarkdownV2";
        }
        return $text;
    }

    public function callRebate($text = null)
    {
        $text = "";
        if ($this->player) {
            $rollover = $this->player->getRollover();
            if (!$this->player->rebate()) {
                $text = $this->player->get_last_error();
            } else {
                $text = "返水成功!" . "\r\n"
                    . "流水总额: " . $rollover . "\r\n"
                    . "返水比例: " . $this->player->getRebate_rate() * 100 . "%" . "\r\n"
                    . "返水金额: " . $this->player->last_rebate_amount() . "\r\n"
                    . "您的余额: " . $this->player->getBalance();
            }
        }
        return $text;
    }

    public function callRecharge($text = null)
    {
        //$text = "";
        if ($this->player) {
            if (preg_match('/\d+/', $text, $out)) {
                $amount = $out[0] * 100;
                if ($amount > 9000000000) return "";
                if ($this->player->isTest() || !$this->use_paybot)
                    $this->player->Recharge($amount, $this->message_id, "");
                if ($this->use_paybot) {
                    $text = "上下分步骤：\n1️⃣入款流程：点击下方【充值提现】\n2️⃣点击菜单【充值】复制上分地址充值\n3️⃣成功到帐后自动到游戏余额 无需查分!";
                    $this->keyboard = json_decode(GameString::where('name', '上分机器人')->find()->text);
                } else {
                    $text = $this->getWords('上分申请成功');
                }
                return $text;
            }

            return "";
        }
        return "";
    }

    public function callTrend($text = null)
    {
        $count = 0;
        if (preg_match('/\d+/', $text, $out)) {
            $count = $out[0];
        }

        if ($count == 0)
            return $this->callResults($text);

        $lotterys = Logs::get_lottery_log($count);
        //print_r($lotterys);
        if (!empty($lotterys)) {

            $text = "最近" . $count . "期走势:\r\n```\r\n";
            foreach ($lotterys as $k => $v) {
                $replace = " ";
                $amount = 0;
                if (preg_match("/(?<==)\d+/", $v->Result, $out)) {
                    $amount = $out[0];
                }
                $result = explode(' ', $v->Result);

                if ($amount < 10) {

                    $result[0] = substr($result[0], 0, -1);
                    $result[0] = $result[0] . "0$amount";
                }
                $text = $text . $v->No . "期" . $result[0] . $replace . $result[1] . "\r\n";
            }
            $text = $text . "```";
        }
        $this->parse_mode = "MarkdownV2";
        return  $text;
    }

    public function callHuiOne($text)
    {
        $text = $this->getWords("上分公告");
        $this->parse_mode = "MarkdownV2";
        return $text;
    }
}
