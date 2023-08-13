<?php

namespace app\common;

use app\model\BetRecord;
use app\model\BetTypes;
use app\model\MoneyLog;
use app\model\RechargeLog;
use app\model\UserDailyReport;
use app\model\LotteryLog;


class Logs
{

    public static function get_last_lottery_log()
    {
        $log =  LotteryLog::where('1=1')->order('id desc')->limit(1)->find();
        return $log;
    }

    public static function get_lottery_log($limit = 5)
    {
        $logs = LotteryLog::where('Result', '<>', "")->order('id desc')->limit($limit)->select();
        return $logs;
    }

    public static function getlotteryByNo($no)
    {
        $log = LotteryLog::where('No',$no)->find();
        return $log;
    }


    public static function addLotteryLog($date, $lottery_no, $hash_no)
    {
        $log = LotteryLog::where('No', $lottery_no)->find();
        if(empty($log))
        {
            $log = LotteryLog::create(array(
                'Date' => $date,
                'No' => $lottery_no,
                'Hash' => $hash_no,
            ));
        }
        return $log;
    }

    public static function addLotteryBet($lottery_no, $bet)
    {
        $log = LotteryLog::where('No', $lottery_no)->find();
        $log->Bets = $bet;
        $log->save();
    }

    public static function addlotteryResult($lottery_no, $result, $payout)
    {
        $log = LotteryLog::where('No', $lottery_no)->find();
        $log->Payouts += $payout;
        $log->Result = $result;
        $log->OpenTime = date('Y-m-d  H:i:s', time());
        $log->save();
    }

    public static function addRecord(
        $user,
        $lottery_no,
        $content,
        $bet,
        $type,
        $odds
    ) {
        $record = [
            'UserId' => $user->Tg_Id,
            'UserName' => $user->FullName,
            'LotteryNo' => $lottery_no,
            'BetContent' => $content,
            'Bet' => $bet,
            'Status' => 0,
            'Odds' => $odds,
            'Type' => $type,
            'Test' => $user->Test,
        ];
        return BetRecord::create($record);
    }

    public static function getBetRecordByLotteryNo($lottery_no, $status = 0)
    {
        $res = BetRecord::where('LotteryNo', $lottery_no)
            ->where('Status', $status)
            ->order('UserId', 'desc')
            ->select();
        return $res;
    }

    public static function cancelBet($user, $lottery_no)
    {
        $records = BetRecord::where('LotteryNo', $lottery_no)
            ->where('UserId', $user->Tg_Id)
            ->where('Status', 0)
            ->select();
        if (!empty($records)) {
            $change = false;
            foreach ($records as $k => $v) {
                $amount = $v['Bet'];
                $user->Balance += $amount;
                Logs::addMoneyLog($user, '取消下注', $amount, '系统自动记录', "", time());
                $change = true;
            }

            if ($change) {
                $records->update(['Status' => '2']);
                $user->save();
            }
        }
    }

    public static function cancelNNBet($user, $lottery_no)
    {
        $records = BetRecord::where('LotteryNo', $lottery_no)
            ->where('UserId', $user->Tg_Id)
            ->where('Status', 0)
            ->select();
        if (!empty($records)) {
            $change = false;
            foreach ($records as $k => $v) {
                $amount = $v['Bet'];
                $type = BetTypes::where('Id',$v['Type'])->find();
                $frozen = $amount * ($type['value'] + 10) - $amount;
                Logs::addMoneyLog($user, '取消下注', $amount + $frozen, '系统自动记录', "", time());
                $user->Balance += $amount + $frozen;
                $user->BlockBetAmount -= $frozen;
                $change = true;
            }

            if ($change) {
                $records->update(['Status' => '2']);
                $user->save();
            }
        }
    }

    public static function addRechargeLog($id, $name, $isTest, $amount, $type, $message_id, $remark = "")
    {
        $data =
            [
                'UserId' => $id,
                'UserName' => $name,
                'Type' => $type,
                'Amount' => abs($amount),
                'Status' => 0,
                'Test' => $isTest,
                'Remark' => $remark,
                'MessageId' => $message_id,
                'Date' => date('Y-m-d  H:i:s', time()),
            ];
        return RechargeLog::create($data);
    }


    protected static $MoneyChange =
    [
        '上分' => 0,
        '下分' => 1,
        '返水' => 2,
        '赔付' => 3,
        '下注' => 4,
        '取消下注' => 5,
        '后台上分' => 6,
        '后台下分' => 7,
        '拒绝下分' => 8,
        '彩金-首充' => 9,
        '彩金-奖励' => 10,
        '彩金-返水' => 11,
        '彩金-扣除' => 12,
        '反亏损'    => 13,
        '管理员提现' => 14,
        '下分冻结'  => 15,
        '下注冻结'  => 16,
    ];

    public static function addMoneyLog($user, $type, $amount, $operator, $remark, $time)
    {
        if (isset(self::$MoneyChange[$type])) {
            $data =
                [
                    'UserId' => $user->Tg_Id,
                    'UserName' => $user->FullName,
                    'Type' => self::$MoneyChange[$type],
                    'Amount' => abs($amount),
                    'BeforeAmount' => $user->Balance,
                    'AfterAmount' => $user->Balance + $amount,
                    'Date' =>  date('Y-m-d  H:i:s', $time),
                    'Operator' => $operator,
                    'Remark' => $remark,
                    'Test' => $user->Test,
                ];
            MoneyLog::create($data);
        }
    }

    protected static $user_report_type =
    [
        '下注' => 'Rollover',
        '赔付' => 'PayoutAmount',
        '充值' => 'RechargeAmount',
        '提现' => 'WithdarwAmount',
        '返水' => 'RebateAmount',
        '输赢' => 'Income',
    ];

    // $id is a UserId
    public static function get_user_report($id, $type)
    {
        if (!isset(self::$user_report_type[$type])) {
            return false;
        }
        $today = date("Y-m-d", time());
        $res = UserDailyReport::where('UserId', $id)
            ->where('Date', $today)
            ->find();
        return empty($res) ? 0 : $res[self::$user_report_type[$type]];
    }

    public static function user_report(
        $user,
        $amount,
        $type
    ) {

        $log_txt=__METHOD__. json_encode( func_get_args());
      
        \think\facade\Log::debug (  $log_txt);
        if (is_array($type)) {
            $check = true;
            foreach ($type as $k => $t) {
                if (!isset(self::$user_report_type[$k])) {
                    $check = false;
                    break;
                }
            }

            if (!$check) return;

            $today = date("Y-m-d", time());
            $res = UserDailyReport::where('UserId', $user->Tg_Id)
                ->where('Date', $today)
                ->find();
            if (empty($res)) {
                $data = [
                    'UserId' => $user->Tg_Id,
                    'UserName' => $user->FullName,
                    'Date' => $today,
                    'Test' => $user->Test,
                ];

                foreach ($type as $k => $v) {
                    $data[self::$user_report_type[$k]] = $v;
                    if ($k === "下注") {
                        $data['BetCount'] = 1;
                        $data['TotalRollover'] = $v;
                    }
                }

                UserDailyReport::create($data);
            } else {
                foreach ($type as $k => $v) {
                    $res[self::$user_report_type[$k]] += $v;
                    if ($k === "下注") {
                        $res['BetCount'] += 1;
                        $res['TotalRollover'] += $v;
                    } elseif ($k === "返水")    //一旦返水就要清空流水
                    {
                        $res['Rollover'] = 0;
                    }
                }

                $res->save();
            }
        } else {
            if (isset(self::$user_report_type[$type])) {
                $today = date("Y-m-d", time());
                $res = UserDailyReport::where('UserId', $user->Tg_Id)
                    ->where('Date', $today)
                    ->find();
                if (empty($res)) {
                    $data = [
                        'UserId' => $user->Tg_Id,
                        'UserName' => $user->FullName,
                        'Date' => $today,
                        'Test' => $user->Test,
                    ];

                    $data[self::$user_report_type[$type]] = $amount;
                    if ($type === "下注") {
                        $data['BetCount'] = 1;
                        $data['TotalRollover'] = $amount;
                    }

                    UserDailyReport::create($data);
                } else {
                    $res[self::$user_report_type[$type]] += $amount;
                    if ($type === "下注") {
                        $res['BetCount'] += 1;
                        $res['TotalRollover'] += $amount;
                    } elseif ($type === "返水")    //一旦返水就要清空流水
                    {
                        $res['Rollover'] = 0;
                    }
                    $res->save();
                }
            }
        }
    }
}
