<?php
/**
 * Class ActivityExclusiveTaskCondition - 互斥任务条件类
 *
 * @author Johnny 
 */
class ActivityExclusiveTaskCondition extends BaseActivityCondition
{
    /**
     * 参数列表
     *
     * @var array
     */
    static protected  $params=[
        'task_ids'=>'互斥条件列表',
    ];

    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition)
    {
        $task_ids   = explode(',', $this->data->get('task_ids'));

        return !ActivityUserTask::where('user_id', '=', $userCondition->user_id)
                ->where('status', '=', 1)
                ->whereIn('task_id', $task_ids)
                ->exists();
    }
}