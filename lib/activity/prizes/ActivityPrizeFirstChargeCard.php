<?php

/**
 * Class ActivityPrizeFirstChargeCard - 首充卡
 *
 * @author Johnny 
 */
class ActivityPrizeFirstChargeCard extends BaseActivityPrize
{
    static public $params=[
        'condition_id'=>'条件ID',
    ];

    /**
     * 实际处理类
     *
     * @param $userPrize
     * @return bool|mixed|void
     */
    protected function complete($userPrize)
    {
        $userCondition   = ActivityUserCondition::where('condition_id', '=', $this->data->get('condition_id'))
                                ->where('user_id', '=', $userPrize->user_id)->first();

        if ($userCondition)
        {
            $userPrize->datas   = Deposit::doWhere(['company_order_num' => ['=', $userCondition->datas['company_order_num']]])->first()->toArray();
            return true;
        }
        return false;
    }
}