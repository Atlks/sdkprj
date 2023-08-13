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
use app\model\GameString;

class NNGame
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

    public $keyboard;
    public $keyword;
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
        return "调用这个";
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

    public function regex_bet($content)
    {
        if (!$this->player) return;

        // 判断是否是下注的指令
        $pattern = "/(a{1,2}|b{1,2})([1-9]\d*)/ui";
        $str2 = preg_replace($pattern, '', $content);
        $str2 = preg_replace('/\ /', '', $str2);
        $notOnlyBetText = false;
        if (!empty($str2)) {
            $notOnlyBetText = true;
        }
        // string_list [0] 所有匹配的下注命令
        // string_list[1] 类型
        // string_list[2] 金额
        if (preg_match_all($pattern, $content, $string_list)) {
            // 总下注
            $total_bet_amount = 0;
            // 需要冻结的金额
            $frozen_amount = 0;
            $bet_string_list = $string_list[0];
            if ($notOnlyBetText)
                return "下注命令错误";

            $config = Config::find(1);
            $this->min_limit = $config['Min_limit'];

            // bets 所有注单
            $bets = array();
            // text 下注内容打印
            $text = "";
            $this->bet_types = BetTypes::select()->toArray();
            foreach ($bet_string_list as $v) {
                foreach ($this->bet_types as $type) {
                    if (preg_match('/^' . $type['Regex'] . '/iu', $v, $out)) {
                        $amount = intval($out[1]);
                        $bet_text = $type['Display'] . "-" . $amount;
                        // type的扩展值来表示开始的倍数
                        // pc牛牛  a/b 0 aa/bb 10
                        // 10倍牛牛 平0 a-e 10
                        // 加10以庄家牛牛赢为基础冻结
                        $bet = [
                            'bet_type' => $type,
                            'text' => $bet_text,
                            'amount' => $amount * 100,
                            'frozen' => $amount * 100 * ($type['value'] + 10)
                        ];

                        // 金额为0
                        if ($bet['amount'] == 0) {
                            return "下注命令错误";
                        }

                        // 最小下注判断, bet_type的字段为0,就使用全局默认
                        $min = $type['Bet_Min'];
                        if ($min <= 0)
                            $min = $this->min_limit;

                        if ($bet['amount'] < $min) {
                            return "没有达到最小下注:" . $min / 100;
                        }

                        // 最大下注判断
                        if ($bet['amount'] > $type['Bet_Max']) {
                            return "超过单笔的最大下注,限额:" . $type['Bet_Max'] / 100;
                        }

                        // 这种type的总注判断,如果为0则不判断
                        if ($type['Bet_Max_Total'] > 0) {
                            if (isset($before_bet[$type['Id']]))
                                $before_bet[$type['Id']] += $bet['amount'];
                            else
                                $before_bet[$type['Id']] = $bet['amount'];

                            if ($before_bet[$type['Id']] > $type['Bet_Max_Total']) {
                                return "超过总最大下注,限额:" . $type['Bet_Max_Total'] / 100;
                            }
                        }
                        $total_bet_amount += $bet['amount'];
                        $frozen_amount += $bet['frozen'];
                        $text .= $bet_text . "\n";
                        array_push($bets, $bet);
                    }
                }
            }

            // 判断余额是否足够冻结
            if ($frozen_amount > $this->player->getBalance(false)) {
                return $this->getWords('下注余额不足');
            }

            $this->action = true;

            // 下注扣除注单金额,记录到moneylog里
            // 这里做一次双保险,以防前面的判断出错
            foreach ($bets as $key => $value) {
                if (!$this->player->Bet($value['amount'], $this->lottery_no, $value['text'], $value['bet_type'])) {
                    $text = "下注失败:" . $this->player->get_last_error();
                    $this->action = false;
                    return $text;
                }
            };

            // 冻结余额
            $frozen_amount -= $total_bet_amount;
            if (!$this->player->frozen($frozen_amount, $this->lottery_no, "下注冻结")) {
                $text = "下注失败:" . $this->player->get_last_error();
                $this->action = false;
                return $text;
            }

            $text =
                "【" . $this->player->getName() . '-' . $this->player->getId() . '】' . "\r\n"
                . '下注内容：' . "\r\n"
                . $text
                . "\r\n"
                . "冻结金额:" . number_format($frozen_amount / 100, 2, ".", "") . "\n"
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
        $res = $this->regex_bet($text);

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
            $this->player->cancelNN($this->lottery_no);
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
            return "";
        }
        return "";
    }

    public function callLastRecord($text = null)
    {
        $text = "";
        if ($this->player) {
            $records = $this->player->getRecords();
            $text = "\t\t" . "期数 类型 金钱 赔付" . "\r\n";
            foreach ($records as $k => $v) {
                $text = $text . "\t\t"
                    . $v['LotteryNo']
                    . "  " . $v['BetContent']
                    . "  " . $v['Bet'] / 100
                    . "  " . $v['Payout'] / 100 . "\r\n";
            }
        }
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
        $count = 10;
        if (preg_match('/\d+/', $text, $out)) {
            $count = $out[0];
            if ($count > 50)
                $count = 50;
        }

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
}
