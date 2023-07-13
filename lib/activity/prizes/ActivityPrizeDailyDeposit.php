<?php

/**
 * 现金返还处奖品处理类
 *
 */
class ActivityPrizeDailyDeposit extends BaseActivityPrize {

    static public $params = [
        'condition_id' => '条件ID',
    ];

    /**
     * 实际处理类
     *
     * @param $userPrize
     * @return bool|mixed|void
     */
    protected function complete($userPrize) {
        $userCondition = ActivityUserCondition::where('condition_id', '=', $this->data->get('condition_id'))
                        ->where('user_id', '=', $userPrize->user_id)->first();

        if ($userCondition) {
            //todo增加手动充值记录处理
            $oUser = User::find($userPrize->user_id);
            if (!is_object($oUser)) {
                return false;
            }
            $oTransactionType = TransactionType::find(TransactionType::TYPE_PROMOTIANAL_BONUS);
            if (!is_object($oTransactionType)) {
                return false;
            }
            $data = json_decode($userCondition->data);
            $oDeposit = new ManualDeposit;
            $oDeposit->user_id = $oUser->id;
            $oDeposit->username = $oUser->username;
            $oDeposit->is_tester = $oUser->is_tester;
            $oDeposit->amount_add_coin = $data->money;
            $oDeposit->transaction_type_id = $oTransactionType->id;
            $oDeposit->transaction_description = $oTransactionType->cn_title;
            $oDeposit->note = '首充返现';
//            $oDeposit->administrator = Session::get('admin_username');
//            $oDeposit->admin_user_id = Session::get('admin_user_id');
            $oDeposit->status = ManualDeposit::STATUS_NOT_VERIFIED;
            if ($oDeposit->save()) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

}
