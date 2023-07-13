<?php
/**
 * Class ActivityLockBankCardCondition - 锁定银行卡
 *
 * @author Johnny 
 */
class ActivityLockBankCardCondition extends BaseActivityCondition
{
    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition)
    {
        return UserBankCard::where('user_id', '=', $userCondition->user_id)
            ->where('islock', '=', 1)
            ->exists();
    }
}