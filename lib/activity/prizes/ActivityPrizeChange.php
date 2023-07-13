<?php

/**
 * Class ActivityPrizeChange - 中奖机会
 *
 * @author Johnny 
 */
class ActivityPrizeChange extends BaseActivityPrize
{
    /**
     * 实际处理类
     *
     * @param $userPrize
     * @return bool|mixed|void
     */
    protected function complete($userPrize)
    {
        $userInfo   = ActivityUserInfo::firstOrCreate(['user_id'=>$userPrize->user_id,
                                        'activity_id'=>$userPrize->activity_id]);

        $userInfo->lottery_count    += $userPrize->count;

        return $userInfo->save();
    }
}