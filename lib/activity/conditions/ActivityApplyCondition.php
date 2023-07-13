<?php
/**
 * Class ActivityApplyCondition - 活动需要报名
 *
 * @author Johnny 
 */
class ActivityApplyCondition extends BaseActivityCondition
{
    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition)
    {
        $task   = $userCondition->task()->first();

        return ($task['is_signed'] == 1);
    }
}