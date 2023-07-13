<?php
/**
 * 三星特殊
 */
class WaySpecialConstitutedOld extends Way {

    /**
     * 允许的数位数组
     * @var array 
     */
    private static $validDigitals = [3];

    /**
     * 注数计算
     * @param SeriesWay $oSeriesWay
     * @param string     $sNumber
     * @return int
     */
    public static function count($oSeriesWay,& $sNumber){
        if (!in_array($oSeriesWay->digital_count, static::$validDigitals)) return 0;
        $pattern = '/[^' . $oSeriesWay->valid_nums . ']+$/';
        return preg_match($pattern,$sNumber) ? 0 : count(array_unique(str_split($sNumber)));
    }

    /**
     * 返回中奖号码
     * 
     * @param string    $sNumber
     * @param int       $iShape
     * @return string
     */
    public static function getWinningNumber($oSeriesWay,$sNumber){
        $aNumCount = array_count_values(str_split($sNumber));
        $iNumCount = count($aNumCount);
        switch ($iNumCount){
            case 1:
                $sWinningNumber = 0;
                break;
            case 2:
                $sWinningNumber = 2;
                break;
            case 3:
                $sWinningNumber = max($aNumCount) - min($aNumCount) == 2 ? 1 : '';
        }

        return $sWinningNumber;
    }
}