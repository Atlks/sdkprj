<?php

/**
 * 每日首次充值
 *
 */
class ActivityDailyDepositCondition extends BaseActivityCondition {

    /**
     * 参数列表
     *
     * @var array
     */
    static protected $params = [
        'min_amount' => '最小充值额',
    ];

    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition) {
        $aCondition = [
            'user_id' => ['=', $userCondition->user_id],
            'activity_id' => ['=', $userCondition->activity_id],
            'task_id' => ['=', $userCondition->task_id],
            'sign_date' => ['=', date('Y-m-d')],
        ];
        $userTask = ActivityUserTask::doWhere($aCondition)->first();
        if (!is_object($userTask)) {
            return false;
        }
        if ($userTask && $userTask->is_signed) {
            $date = $userTask['signed_time'];
            $aCondition = [
                'status' => ['=', Deposit::DEPOSIT_STATUS_SUCCESS],
                'user_id' => ['=', $userCondition->user_id],
                'amount' => ['>=', $this->data->get('min_amount')],
                'updated_at' => ['>=', $date],
            ];
            if ($userTask->sign_date) {
                $aCondition['created_at'] = ['<=', $userTask['sign_date'] . ' 23:59:59'];
            }
            $query = Deposit::doWhere($aCondition);
            $oDeposit = new Deposit;
            $data = $oDeposit->doOrderBy($query, ['updated_at' => 'asc'])->first();
            if (!empty($data)) {
                $userTask->data = json_encode(['amount' => $data->amount, 'put_at' => $data->put_at]);
                return $userTask->save();
            }
        }

        return false;
    }

}
