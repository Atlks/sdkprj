<?php
/**
 * Class ActivityMaxPrizeIpCondition - 控制单个IP单个活动最大得奖次数
 *
 * @author Johnny 
 */
class ActivityMaxPrizeIpCondition extends BaseActivityCondition
{
    /**
     * 参数列表
     *
     * @var array
     */
    static protected  $params=[
        'max_num'   => '最大次数',
        'prize_ids' => '奖品列表',
        'source'    => '来源',
        //是否应用全部活动, 1为是 0为否
        'isAll'     => '是否应用全部活动',
    ];

    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition)
    {
        $data = $userCondition->user()->first();

        $query  = ActivityUserBonus::whereIn('remote_ip', [$data->login_ip, $data->register_ip]);

        if (!$this->data->get('isAll'))
        {
            $query  = $query->where('activity_id', '=', $userCondition->activity_id);
        }

        if ($this->data->get('source'))
        {
            $query  = $query->where('source', '=', $this->data->get('source'));
        }

        if ($this->data->get('prize_ids'))
        {
            $prize_ids  = @explode(',', $this->data->get('prize_ids'));
            $query  = $query->whereIn('prize_id', $prize_ids);
        }

        $sum = $query->sum('count');

        return ($sum < $this->data->get('max_num'));
    }
}