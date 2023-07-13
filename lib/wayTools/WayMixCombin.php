<?php
class WayMixCombin extends Way {

    /**
     * 注数计算
     * @param SeriesWay $oSeriesWay
     * @param string     $sNumber
     * @return int
     */
    public static function count($oSeriesWay,& $sNumber){
        $sSplitChar = Config::get('bet.split_char') or $sSplitChar = '|';

        $sTimesStr = '{' . $oSeriesWay->digital_count . '}';
        $pattern = '/^[\d]' . $sTimesStr . '(' . preg_quote($sSplitChar) . '[\d]' . $sTimesStr . ')*$/';
        if (!preg_match($pattern, $sNumber)){
            return 0;
        }
        $aBetNumber = explode($sSplitChar, $sNumber);
        $aNeedShapes = explode(',', $oSeriesWay->shape);
        $aTrueNumber = [];
        foreach($aBetNumber as $sBetNumber){
            !in_array(DigitalNumber::getShape($sBetNumber),$aNeedShapes) or $aTrueNumber[] = DigitalNumber::getCombinNumber($sBetNumber);
        }
        $aTrueNumber = array_unique($aTrueNumber);
        $sNumber     = implode($sSplitChar,$aTrueNumber);
        return count(array_count_values($aTrueNumber));
    }

    /**
     * 返回中奖号码
     * 
     * @param string    $sNumber
     * @param int       $iShape
     * @return string
     */
    public static function getWinningNumber($oSeriesWay, $sNumber){
        $sWinningNumber = $sNumber;
        $aNeedShapes = explode(',', $oSeriesWay->shape);
        $iShapeOfNumber = DigitalNumber::getShape($sNumber);
        return in_array(DigitalNumber::getShape($sNumber), $aNeedShapes) ? DigitalNumber::getCombinNumber($sNumber) : '';
    }

}
