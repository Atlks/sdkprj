<?php
/**
 * Class BaseActivityCondition - 活动条件类基础类
 *
 * @author Johnny 
 */
class BaseActivityCondition extends FactoryClass
{
    const CAN_HANDLE_OBJECT_CLASS='ActivityUserCondition';

    /**
     * 条件满足则更新数据库
     *
     */
    public function complete($object)
    {
        return false;
    }
}