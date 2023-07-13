<?php
/**
 * Class ActivityWithdrawalCondition - 指定日期内的提现
 *
 * @author Johnny 
 */
class ActivityWithdrawalCondition extends BaseActivityCondition
{
    /**
     * 参数列表
     *
     * @var array
     */
    static protected  $params=[
        'start_time'=>'开始时间',
        'end_time'=>'结束时间',
    ];

    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition)
    {
        $data = $userCondition->user()->first()->toArray();

        //临时先加上代理商身份限制,回头把这里做成一个身份限制条件类
        if ($data['is_agent'])
        {
            return false;
        }

        return Withdrawal::where('status', '=', 4)
            ->where('user_id', '=', $userCondition->user_id)
            ->where('created_at', '>=', $this->data->get('start_time'))
            ->where('created_at', '<', $this->data->get('end_time'))->exists();
    }
}