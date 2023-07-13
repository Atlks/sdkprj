<?php

/**
 * Class ActivityPrizeMoney - 现金类奖品
 *
 * @author Johnny 
 */
class ActivityPrizeMoneyLuckMoney extends BaseActivityPrize {

    /**
     * 可选参数列表
     *
     * @var array
     */
    static protected $params = [
        'amount_column' => '金额字段名称',
    ];

    /**
     * 账户锁
     *
     * @var array
     */
    protected $locks = [];

    /**
     * 加锁
     * @param FactoryObjectClassInterface $userPrize
     */
    protected function lock(FactoryObjectClassInterface $userPrize) {
        if (!isset($this->locks[$userPrize->user_id])) {
            $oUser = User::find($userPrize->user_id);
            if ($oAccount = Account::lock($oUser->account_id, $locker)) {
                $this->locks[$userPrize->user_id] = [
                    'user' => $oUser,
                    'account' => $oAccount,
                    'locker' => $locker,
                ];
            } else {
                throw new Exception("User [{$userPrize->user_id}] account lock failed");
            }
        }

        return $this->locks[$userPrize->user_id];
    }

    /**
     * 批量导入处理,适合需要事务的处理
     *
     * @param FactoryObjectClassInterface $userPrize
     * @return mixed
     */
    public function load(FactoryObjectClassInterface $userPrize) {
        $this->lock($userPrize);
        return parent::load($userPrize);
    }

    /**
     * 实际处理类
     *
     * @param $userPrize
     * @return bool|mixed|void
     */
    protected function complete($userPrize) {
        $sNote = "任务系统派送: 活动[{$userPrize->activity_id}] - 奖品[{$userPrize->prize_name}]";
        $aData = json_decode($userPrize->data, true);
        $fAmount = is_null($aData) ? $userPrize->prize()->first()->value : array_get($aData, $this->data->get('amount_column'));

        $lock = $this->lock($userPrize);
        $oUser = $lock['user'];
        $oAccount = $lock['account'];

        $aExtraData = [
            'note' => $sNote,
        ];
        return Transaction::addTransaction($oUser, $oAccount, TransactionType::TYPE_NEW_GAME_LUCKY_MONEY, $fAmount, $aExtraData) == Transaction::ERRNO_CREATE_SUCCESSFUL ? true : false;
    }

    /**
     * 批量解锁
     *
     */
    protected function unlocks() {
        //批量解锁用户
        foreach ($this->locks as $key => $lock) {
            Account::unLock($lock['account']->account_id, $lock['locker']);
        }
    }

    /**
     * 析构函数
     *
     */
    public function __destruct() {
        $this->unlocks();
    }

}
