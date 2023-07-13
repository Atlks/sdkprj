<?php
/**
 * 用于区间玩法，从直选定位复式方式继承而来。需要重载中奖号码方法
 */
class WaySectionalizedSeparatedConstituted extends WaySeparatedConstituted {

    /**
     * 返回中奖号码
     * 
     * @param string    $sNumber
     * @param int       $iShape
     * @return string
     */
    public static function getWinningNumber($oSeriesWay, $sNumber){
        $sSplitChar = Config::get('bet.split_char') or $sSplitChar = '|';
        $aValidNum = explode($sSplitChar, $oSeriesWay->valid_nums);
        $a = [];
        $aNumOfNumber = str_split($sNumber);
        foreach($aValidNum as $i => $sValidNumConfig){
            list($min, $max) = explode('-', $sValidNumConfig);
            $a[$i] = $max > 4 ? $aNumOfNumber[$i] : floor($aNumOfNumber[$i] / 2);
        }
        return implode($a);
    }

}