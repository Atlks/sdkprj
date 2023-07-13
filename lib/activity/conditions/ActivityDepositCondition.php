<?php
/**
 * Class ActivityDepositCondition - 指定日期内的充值
 *
 * @author Johnny 
 */
class ActivityDepositCondition extends BaseActivityCondition
{
    /**
     * 参数列表
     *
     * @var array
     */
    static protected  $params=[
        'min_amount'=>'最小充值额',
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
        $data   = Deposit::where('status', '=', 3)
            ->where('user_id', '=', $userCondition->user_id)
            ->where('real_amount', '>=', $this->data->get('min_amount'))
            ->where('pay_time', '>=', $this->data->get('start_time'))
            ->where('pay_time', '<', $this->data->get('end_time'))->first();

        if ($data)
        {
            $userCondition->datas   = ['company_order_num'=> $data['company_order_num']];
            return true;
        }
        return false;
    }
}