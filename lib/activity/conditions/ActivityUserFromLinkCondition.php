<?php
/**
 * Class ActivityUserFromLinkCondition - 精准用户控制
 *
 * @author Johnny 
 */
class ActivityUserFromLinkCondition extends BaseActivityCondition
{
    /**
     * 参数列表
     *
     * @var array
     */
    static protected  $params=[
        //0为拒绝,代表限制活动不允许精准开户的用户参与
        //1为允许,代表限制活动必须为精准开户的用户参与
        'status'=> '状态',
    ];

    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition)
    {
        $data = $userCondition->user()->first();

        if ($this->data->get('status'))
        {
            return $data->is_from_link ? false : true;
        }
        else
        {
            return $data->is_from_link ? true : false;
        }
    }
}