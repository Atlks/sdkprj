<?php
class WaySumTail extends Way {

    /**
     * 注数计算
     * @param SeriesWay $oSeriesWay
     * @param string     $sNumber
     * @return int
     */
    public static function count($oSeriesWay,$sNumber){
        return strlen($sNumber);
    }
    
    /**
     * 返回中奖号码
     * 
     * @param string    $sNumber
     * @param int       $iShape
     * @return string
     */
    public static function getWinningNumber($oSeriesWay,& $sNumber){
        return DigitalNumber::getSum($sNumber) % 10;
    }

}
