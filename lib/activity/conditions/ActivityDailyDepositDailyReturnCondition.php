<?php

/**
 * 每日充，每日送活动条件
 *
 */
class ActivityDailyDepositDailyReturnCondition extends BaseActivityCondition {

    /**
     * 参数列表
     */
    static protected $params = [
        'min_amount' => '最小充值额',
        'start_time' => '开始时间',
        'end_time' => '结束时间',
        'times' => '倍数',
    ];

    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition) {
        //需要报名，因为这样可以在活动结束的时候，获取到所有需要返现金的用户信息
        //状态：报名，但是没有完成的(finish_time==null)，
        /**
         * if(finish_time==null){
         *      begin_time =充值确认时间
         *      end_time=活动结束时间
         * }else{
         *      begin_time = finish_time
         *      end_time = 活动结束时间
         * }
         * 根据begin_time,end_time计算销量，然后添加用户中奖信息
         */
        $userTask = $userCondition->userTask()->first();
        $sStartTime = is_object($userTask) && !is_null($userTask->finish_time) ? $userTask->finish_time : $this->data->get('start_time');
        $sEndTime = $this->data->get('end_time');
        $data = Transaction::where('user_id', '=', $userCondition->user_id)
                ->whereIn('type_id', [TransactionType::TYPE_DEPOSIT, TransactionType::TYPE_DEPOSIT_BY_ADMIN])
                ->where('amount', '>=', $this->data->get('min_amount'))
                ->where('created_at', '>=', $sStartTime)
                ->where('created_at', '<=', $sEndTime)
                ->orderBy('created_at', 'asc')
                ->first();
        if (!empty($data)) {
            $profit = Project::getCurrentDayTurnover($userCondition->user_id, $data['created_at'], $sEndTime);
            if ($profit > ($data['amount'] * $this->data->get('times'))) {
                $userCondition->datas = ['money' => $data['amount']];
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

}
