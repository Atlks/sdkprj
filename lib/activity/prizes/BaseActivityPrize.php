<?php

/**
 * Class BaseActivityPrize - 活动奖品发放
 *
 * @author Johnny 
 */
class BaseActivityPrize extends FactoryClass
{
    const CAN_HANDLE_OBJECT_CLASS='ActivityUserBonus';

    /**
     * 实际赠送类
     *
     * @param $userPirze
     * @return mixed|void
     */
    protected function complete($userPirze)
    {
        return true;
    }
}