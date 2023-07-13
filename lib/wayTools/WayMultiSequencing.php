<?php
class WayMultiSequencing extends Way {

    /**
     * 注数计算
     * @param SeriesWay $oSeriesWay
     * @param string     $sNumber
     * @return int
     */
    public static function count($oSeriesWay,& $sNumber){
        return $oSeriesWay->digital_count * WaySeparatedConstituted::count($oSeriesWay, $sNumber);
    }

    /**
     * 返回中奖号码
     * 
     * @param string    $sNumber
     * @param int       $iShape
     * @return string
     */
    public static function getWinningNumber($oSeriesWay, $sNumber){
        return $sNumber;
    }

}
