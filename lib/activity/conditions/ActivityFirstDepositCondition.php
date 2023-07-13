<?php

class ActivityFirstDepositCondition extends BaseActivityCondition {

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
        $userTask = $userCondition->userTask()->first();

        if ($userTask && $userTask->is_signed == 1) {
            $date = $userTask['signed_time'];

            $data = Deposit::where('status', '=', Deposit::DEPOSIT_STATUS_SUCCESS)
                    ->where('user_id', '=', $userCondition->user_id)
                    ->where('amount', '>=', $this->data->get('min_amount'))
                    ->where('created_at', '>=', $date)
                    ->orderBy('created_at', 'asc')
                    ->first();

            if (!empty($data)) {
                $userCondition->data = json_encode($data);
                return true;
            }
        }

        return false;
    }

}
