<?php

/**
 * 系统进程处理类
 */
class ProcessManage {
    public static function getProcessList() {
        @exec('ps aux', $aOutPut);
        array_shift($aOutPut);
        $aProcesses = [];
        foreach($aOutPut as $sString){
            $sString = preg_replace('/ {2,}/', ' ', $sString);
            $aInfo = explode(' ',$sString);
            $aProcesses[$aInfo[1]] = array_diff($aInfo, array(''));
        }
        return $aProcesses;
    }

    public static function checkProcessExists($iProcessNo) {
        $aProcessList  = self::getProcessList();
//        $aProcessNo    = array_keys($aProcessList);
        return array_key_exists($iProcessNo, $aProcessList);
    }

}