<?php

/**
 * 每日投注量
 *
 */
class ActivityDailyBetCondition extends BaseActivityCondition {

    /**
     * 参数列表
     *
     * @var array
     */
    static protected $params = [
        'times' => '流水倍数',
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
        $oData = json_decode($userTask->data);
        $fTargetTurnover = $oData->amount * $this->data->get('times');
        $turnover = Project::getCurrentDayTurnover($userCondition->user_id, $oData->put_at, date('Y-m-d') . ' 23:59:59');
        $fPercent = $turnover / $fTargetTurnover;
        $data = json_decode($userTask->data, true);
        if (is_array($data)) {
            $data['turnover'] = $turnover;
        } else {
            $data = ['turnover' => $turnover];
        }
        $userTask->data = json_encode($data);
        $userTask->percent = $fPercent;
        $userTask->save();
        if ($fPercent >= 1) {
            return true;
        } else {
            return false;
        }
    }

}
