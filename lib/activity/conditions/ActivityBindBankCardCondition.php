<?php

/**
 * 绑定银行卡
 *
 */
class ActivityBindBankCardCondition extends BaseActivityCondition {

    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition) {
        $aUserBankCard = UserBankCard::where('user_id', '=', $userCondition->user_id)->get();
        $bSucc = true;
        $oFirstUserBankCard = null;
        $i = 0;
        foreach ($aUserBankCard as $oUserBankCard) {
            if (is_object($oUserBankCard)) {
                $i > 0 or $oFirstUserBankCard = $oUserBankCard;
                $oUserCondition = ActivityUserCondition::getObjectByParams(['data' => $oUserBankCard->account]);
                if (is_object($oUserCondition)) {
                    $bSucc = false;
                    break;
                }
            }
        }
        if ($bSucc && is_object($oFirstUserBankCard)) {
            $userCondition->data = $oFirstUserBankCard->account;
            return true;
        } else {
            return false;
        }
    }

}
