<?php
use Illuminate\Support\Facades\Redis;

Class LockHandle {

    /**
     * Redis 程序锁
     * 传进的方法或闭包 在同一时间只会有一个在执行
     *
     * @author   Wright
     * @date     2017-05-05
     *
     * example:
     * LockHandle::redisLock($sRedisKey, [$oClass, $sMethodName], $aParam);
     * LockHandle::redisLock($sRedisKey, [$sNameSpace, $sClassName, $sMethodName], $aParam);
     *
     * @param  string $sRedisKey     指定做锁的Redis key
     * @param  mixed  $fun
     * @param  array $aParam         方法参数
     * @param  integer $iWaitingTime 等待的解锁时间上限 (秒)
     * @return  mixed  $result       方法或闭包的回传
     */
    public static function redisLock($sRedisKey, $fun, $aParam = [], $iWaitingTime = 10) {
        $result = null;

        $oRedis = Redis::connection();
        $bLock = false;
        $iStartTime = time();
        while (!$bLock) {
            $bLock = $oRedis->setnx($sRedisKey, 1);
            if ($bLock) {
                try {
                    $result = call_user_func_array($fun, $aParam);
                } catch (Exception $oE) {
                    Log::error($oE);
                }
                break;
            } // if end

            $iRunningTime = time() - $iStartTime;
            if ($iRunningTime >= $iWaitingTime) {
                break;
            } // if end

            usleep(10000);

        } // while end

        $oRedis->del($sRedisKey);
        return $result;
    }
}