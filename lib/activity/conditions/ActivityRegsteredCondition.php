<?php

/**
 * 注册条件
 *
 */
class ActivityRegsteredCondition extends BaseActivityCondition {

    /**
     * 参数列表
     *
     * @var array
     */
    static protected $params = [
        'start_time' => '注册开始时间',
        'end_time' => '注册结束时间',
    ];

    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition) {
        $oData = $userCondition->user()->first();
        $registration_time = $oData->register_at;
        $userCondition->data = json_encode($oData->getAttributes());
        $aParentIds = explode(',', $oData->forefather_ids);
        foreach ($aParentIds as $iParentId) {
            $oRoleUser = RoleUser::getUserRoleFromUserIdRoleId(Role::ACTIVITY_REGIST_BLACK, $iParentId);
            if (is_object($oRoleUser)) {
                return false;
            }
        }
        if ($registration_time >= $this->data->get('start_time') && $registration_time < $this->data->get('end_time')) {
            return true;
        }
        return false;
    }

}
