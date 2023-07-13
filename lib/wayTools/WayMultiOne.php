<?php
/**
 * 定位胆组合
 */
class WayMultiOne extends WaySeparatedConstituted {

    public static function count($oSeriesWay,& $sNumber){
        $sSplitChar = Config::get('bet.split_char') or $sSplitChar = '|';
        if (!self::checkNumber($oSeriesWay,$sNumber,$sSplitChar)){
            return 0;
        }

        $aNumbers = explode($sSplitChar,$sNumber);
        $iCount   = 0;
        foreach ($aNumbers as $sNumber){
            $aNums = str_split($sNumber);
            $iCount += count(array_count_values($aNums));
        }
        return $iCount;
    }

    /**
     * 返回中奖号码
     *
     * @param string    $sNumber
     * @param int       $iShape
     * @return string
     */
    public static function getWinningNumber($oSeriesWay,$sNumber){
        return $oSeriesWay->shape == -1 ? $sNumber : '';
    }

}
