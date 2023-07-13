<?php
/**
 * Class ActivityRegsteredCondition - 填写邮箱
 *
 * @author Johnny 
 */
class ActivityWriteEmailCondition extends BaseActivityCondition
{
    /**
     * 参数列表
     *
     * @var array
     */
    static protected  $params=[];

    /**
     * 条件是否满足
     *
     * @return bool
     */
    public function complete($userCondition)
    {
        $data = $userCondition->user()->first()->toArray();

        return !empty($data['email']);
    }
}