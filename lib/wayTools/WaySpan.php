<?php
// todo:
class WaySpan extends Way {

    /**
     * 注数数组
     * @var array 
     */
    private static $countArray = [
        2 => [ 10,18,16,14,12,10,8,6,4,2 ],
        3 => [ 10,54,96,126,144,150,144,126,96,54 ],
    ];

    /**
     * 允许的数位数组
     * @var array 
     */
    private static $validDigitals = [2,3];

    /**
     * 注数计算
     * @param SeriesWay $oSeriesWay
     * @param string     $sNumber
     * @return int
     */
    public static function count($oSeriesWay,& $sNumber){
        if (!in_array($oSeriesWay->digital_count, static::$validDigitals)) return 0;
        if (!isset(static::$countArray[$oSeriesWay->digital_count])){
            return 0;
        }
        else{
            $aNumbers = str_split($sNumber);
            $iCount   = 0;
            foreach ($aNumbers as $iSpan){
                $iCount += static::getCountArray($oSeriesWay->digital_count,$iSpan);
            }
        }
        return $iCount;
    }

    public static function getCountArray( $iDigital ,$iSpan ){
        return isset(static::$countArray[$iDigital][$iSpan]) ? static::$countArray[$iDigital][$iSpan] : 0;
    }

    /**
     * 返回中奖号码
     * 
     * @param string    $sNumber
     * @param int       $iShape
     * @return string
     */
    public static function getWinningNumber($oSeriesWay, $sNumber){
        $aWei = str_split($sNumber);
        return max($aWei) - min($aWei);
    }

}