<?php
/**
 * Class ActivityMaxPrizeDayCondition - 控制奖品单日最大得奖次数
 *
 * @author Johnny 
 */
class ActivityMaxPrizeDayCondition extends BaseActivityCondition
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
    ];

    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition)
    {
        $query  = ActivityUserBonus::where('activity_id', '=', $userCondition->activity_id)
                            ->whereBetween('created_at', [date('Y-m-d'), date('Y-m-d').' 23:59:59']);

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