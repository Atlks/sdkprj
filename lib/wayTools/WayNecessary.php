<?php
// todo
class WayNecessary extends Way {

    private static $countArray = [
        2 => 9,
        3 => 54,
    ];

    private static $validDigitals = [2,3];

    public static function count($oSeriesWay,& $sNumber){
        if (!in_array($oSeriesWay->digital_count,static::$validDigitals)){
            return 0;
        }
        if (isset(static::$countArray[ $oSeriesWay->digital_count ])){
            $iNumberCount = count(array_unique(explode(Config::get('bet.split_char'),$sNumber)));
            $iCount       = $iNumberCount * static::$countArray[ $oSeriesWay->digital_count ];
        }
        else{
            $iCount = 0;
        }
        return $iCount;
    }

    function getCountArray( $iDigital = 3, $bCombin = false ){
        $sKey = self::getKey($bCombin);
        return static::$countArray[$iDigital][$sKey];
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