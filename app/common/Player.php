<?php

declare(strict_types=1);
//    app\common\Player
namespace app\common;

use app\model\User;
use app\model\BetRecord;
use app\model\MoneyLog;
use app\model\UserDailyReport;
use app\common\Logs;
use app\model\RebateConfig;
use app\common\helper;
use app\model\Setting;

class Player
{
    protected $data;
    protected $records;

    // 可变动属性
    protected $id = 0;
    protected $fullname = "";
    protected $test = 0;
    protected $balance = 0;
    protected $blockBlance = 0;
    protected $rebate = 0;
    protected $total_payout = 0;
    protected $income = 0;

    protected $last_error = "";

    // 通用配置
    protected $rebate_config;

    public function __construct($data)
    {
        $this->data = $data;
        $this->records = new BetRecord();
        $this->id = $data['Tg_Id'];
        $this->fullname = $data['FullName'];
        $this->test = $data['Test'];
        $this->balance = $data['Balance'];
        $this->blockBlance = $data['BlockBetAmount'];
        $this->total_payout = $data['Total_Payouts'];
        $this->rebate_config = ReBateConfig::find(1);
        $this->income = Logs::get_user_report($this->id, "输赢");
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->fullname;
    }

    public function getBalance($decimal = true)
    {
        return $decimal ? $this->balance / 100.00 : $this->balance;
    }

    public function getFrozen($decimal = true)
    {
        return $decimal ? $this->blockBlance / 100.00 : $this->blockBlance;
    }

    public function getBetRecord($lottery_no)
    {
        $res = $this->records->where('UserId', $this->id)
            ->where('Status', 0)
            ->where('LotteryNo', $lottery_no)
            ->select();

        $bet = [];
        foreach ($res as $v) {
            if (isset($bet[$v['Type']]))
                $bet[$v['Type']] += $v['Bet'];
            else
                $bet[$v['Type']] = $v['Bet'];
        }
        return $bet;
    }

    public function getRecords($limit = 4)
    {
        $res = $this->records->where('UserId', $this->id)
            ->where('Status', '<>', 2)
            ->order('id', 'desc')
            ->limit($limit)
            ->select()
            ->toArray();
        return $res;
    }

    public function getRollover($decimal = true)
    {
        $rollover = 0;
        $today = date("Y-m-d", time());
        $res = UserDailyReport::where('UserId', $this->id)
            ->where('Date', $today)
            ->find();
        if (!empty($res)) {
            $rollover = $res->Rollover;
        }
        return $decimal ? $rollover / 100.00 : $rollover;
    }

    public function getTotalRollover($decimal = true)
    {
        $rollover = 0;
        $today = date("Y-m-d", time());
        $res = UserDailyReport::where('UserId', $this->id)
            ->where('Date', $today)
            ->find();
        if (!empty($res)) {
            $rollover = $res->TotalRollover;
        }
        return $decimal ? $rollover / 100.00 : $rollover;
    }

    public function getRebate_rate($decimal = true)
    {
        return $decimal ? $this->rebate_config['Rate'] / 10000.00 : $this->rebate_config['Rate'];
    }

    public function last_rebate_amount($decimal = true)
    {
        return $decimal ? $this->rebate / 100.00 : $this->rebate;
    }

    public function getIncome($decimal = true)
    {
        return $decimal ? $this->income / 100.00 : $this->income;
    }

    public function isTest()
    {
        return $this->test;
    }


    public function error($error)
    {
        $this->last_error = $error;
    }

    public function get_last_error()
    {
        return $this->last_error;
    }

    // 金流相关=====================================================
    // 下注
    public function bet($amount, $lottery_no, $content, $bet_type)
    {
        if ($amount > $this->balance) {
            $this->error("余额不足");
            return false;
        }
        $user = User::where('Tg_Id', $this->id)->find();
        $this->balance = $user->Balance;
        //xxxxx   .... bettype,,betodds
        $res = Logs::addRecord($user, $lottery_no, $content, $amount, $bet_type['Id'], $bet_type['Odds']);
        if (!empty($res)) {
            Logs::addMoneyLog($user, "下注", -$amount, "系统自动记录", $content, time());
            $this->balance -= $amount;
            $user->Balance = $this->balance;
            $user->save();
            return true;
        }
        $this->error("下注订单生成失败");
        return false;
    }

    // 下注冻结
    public function frozen($amount, $lottery_no, $content)
    {
        if ($amount > $this->balance) {
            $this->error("余额不足");
            return false;
        }

        $user = User::where('Tg_Id', $this->id)->find();
        $this->balance = $user->Balance;
        if (!empty($user)) {
            Logs::addMoneyLog($user, "下注冻结", -$amount, "系统自动记录", "$lottery_no 期- $content", time());
            $this->balance -= $amount;
            $this->blockBlance += $amount;
            $user->Balance = $this->balance;
            $user->BlockBetAmount += $amount;
            $user->save();
            return true;
        }
        $this->error("下注订单生成失败");
        return false;
    }

    public function cancel($lottery_no)
    {
        $user = User::where('Tg_Id', $this->id)->find();
        if (!empty($user)) {
            Logs::cancelBet($user, $lottery_no);
        }
    }

    public function cancelNN($lottery_no)
    {
        $user = User::where('Tg_Id', $this->id)->find();
        if (!empty($user)) {
            Logs::cancelNNBet($user, $lottery_no);
        }
    }

    public function win($bet, $payout, $income, $lose = null, $back = null)
    {
        // [10000,20000,10000]
        var_dump(__METHOD__ . json_encode(func_get_args()));
        $lineNumStr = "  " . __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__ . " m:" . __METHOD__ . "  ";
        \think\facade\Log::info($lineNumStr);
        \think\facade\Log::info(json_encode(func_get_args()));
        //  [null,20000,20000]

        $lineNumStr = "  " . __FILE__ . ":" . __LINE__ . " f:" . __FUNCTION__ . " m:" . __METHOD__ . "  ";
        $user = User::where('Tg_Id', $this->id)->find();
        $dirty = false;
        if ($payout > 0) {
            $user->Total_Payouts += $payout;
            Logs::addMoneyLog($user, "赔付", $payout, "系统自动记录", "", time());
            $user->Balance += $payout;
            if (!is_null($back))
                $user->Balance += $back;
            $dirty = true;
        }

        if (!is_null($lose)) {
            $user->BlockBetAmount += $lose;
            $user->Balance += $user->BlockBetAmount;
            $user->BlockBetAmount = 0;
            $dirty = true;
        }
        if ($dirty)
            $user->save();
        $this->balance = $user->Balance;
        Logs::user_report($user, null, array("下注" => $bet, "赔付" => $payout, "输赢" => $income));
    }

    public function rebate()
    {
        $rollover = $this->getRollover(false);
        if ($rollover == 0) {
            $this->error("暂无流水");
            return false;
        }
        /*
        if ($rollover < $this->rebate_config['Min']) {
            $this->error("流水没达到最小返水要求");
            return false;
        }
        if ($rollover > $this->rebate_config['Max']) {
            $this->error("流水超出最大返水要求");
            return false;
        }*/

        $rate =  $this->getRebate_rate();
        $amount = intval($rollover * $rate);
        $this->rebate = $amount;
        $user = User::where('Tg_Id', $this->id)->find();
        Logs::user_report($user, $amount, "返水");
        Logs::addMoneyLog($user, "返水", $amount, "系统自动记录", "", time());
        $this->balance = $user->Balance;
        $this->balance += $amount;
        $user->Balance = $this->balance;
        $user->save();
        return true;
    }

    public function Recharge($amount, $message_id, $remark)
    {
        $log = Logs::addRechargeLog($this->id, $this->fullname, $this->test, $amount, 6, $message_id, $remark);
        if (empty($log)) {
            $this->error("上分列表记录创建失败");
            return false;
        }
        if ($this->test) {
            $helper = new Helper();
            //var_dump($log->id);
            $push_url = Setting::find(13)->s_value;
            $helper->http_request($push_url . $log->id);
        }
        return true;
    }

    public function WithDraw($amount, $message_id, $remark)
    {
        if ($this->balance < $amount) {
            $this->error("您的余额不足");
            return false;
        }

        Logs::addMoneyLog($this->data, "下分冻结", -$amount, "系统自动记录", $remark, time());
        $this->data->Balance -= $amount;
        $this->data->BlockAmount += $amount;
        $this->data->Save();
        $log = Logs::addRechargeLog($this->id, $this->fullname, $this->test, $amount, 7, $message_id, $remark);
        if (empty($log)) {
            $this->error("上分列表记录创建失败");
            return false;
        }
        if ($this->test) {
            $helper = new Helper();
            //var_dump($log->id);
            $push_url = Setting::find(13)->s_value;
            $helper->http_request($push_url . $log->id);
        }
        return true;
    }
}
