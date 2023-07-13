<?php

/**
 * 单式
 */
class WayEnum extends Way {

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
        $aBetNumbers = array_unique(explode($sSplitChar,$sNumber));
        $iCount       = count($aBetNumbers);
        if ($oSeriesWay->shape > '-1'){
            $aTrueNumbers = [];
            foreach ($aBetNumbers as $sBetNumber){
                if (DigitalNumber::getShape($sBetNumber) != $oSeriesWay->shape){
                    $iCount         = 0;
                    break;
                }
                $aTrueNumbers[] = DigitalNumber::getCombinNumber($sNumber);
            }
            $sNumber = implode($sSplitChar,$aTrueNumbers);
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
    public static function getWinningNumber($oSeriesWay, $sNumber){
        $sWinningNumber = $sNumber;
        if ($oSeriesWay->shape > -1){
            $iShapeOfNumber = DigitalNumber::getShape($sNumber);
//            if ($oSeriesWay->id == 5){
////                die('shape' . $iShapeOfNumber);
//                pr(DigitalNumber::getCombinNumber($sWinningNumber,true));
//                exit;
//            }
            $sWinningNumber = $iShapeOfNumber == $oSeriesWay->shape ? DigitalNumber::getCombinNumber($sWinningNumber,true) : '';
        }
        return $sWinningNumber;
    }

    public static function checkPrize($oSeriesWay,$sBetNumber){
//        die($sNumber);
//        $oSeriesWay->WinningNumber = '789';
        $aBetNumber = explode('|',$sBetNumber);
        foreach ($aBetNumber as $sNum){
            if ($sNum === $oSeriesWay->WinningNumber){
                return 1;
            }
        }
        return 0;
    }

}
