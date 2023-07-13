<?php
class WaySeparatedConstituted extends Way {

    public static function count($oSeriesWay,& $sNumber){
        $sSplitChar = Config::get('bet.split_char') or $sSplitChar = '|';
        if (!self::checkNumber($oSeriesWay, $sNumber, $sSplitChar)){
            return 0;
        }
        $aNumbers = explode($sSplitChar, $sNumber);
        $iCount = 1;
        foreach($aNumbers as $sNumber){
            $aNums = str_split($sNumber);
            $aNumber = array_count_values($aNums);
            $iCount *= count($aNumber);
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
        return $oSeriesWay->shape == -1 ? $sNumber : '';
    }

    /**
     * 检查投注码是否合法
     * 
     * @param SeriesWay $oSeriesWay
     * @param string    $sNumber
     * @param string    $sSplitChar
     * @return bool
     */
    public static function checkNumber($oSeriesWay, $sNumber, $sSplitChar){
        $pattern = self::compilePattern($oSeriesWay,$sSplitChar);
        return preg_match($pattern, $sNumber);
//        $pattern = '/' ;
//        $pattern = '/^[\d]+(' . preg_quote($sSplitChar) . '[\d]+){' . ($oSeriesWay->digital_count - 1) . '}$/';

    }

    /**
     * 返回判断号码是否合法的正則表达式
     * 
     * @param SeriesWay $oSeriesWay
     * @param string $sSplitChar
     * @return string
     */
    protected static function compilePattern($oSeriesWay, $sSplitChar){
//        $aPatterns = array_fill(0, $oSeriesWay->digital_count, '[' . $oSeriesWay->valid_nums . ']+');
//        $pattern = '/^' . implode(preg_quote($sSplitChar), $aPatterns) . '$/';
//        $oSeriesWay->valid_nums = '0-9|0-9';
        $a = explode($sSplitChar, $oSeriesWay->valid_nums);
        $a = array_map('self::compileSubPattern', $a);
        if (count($a) == 1){
            $b = array_fill(1, $oSeriesWay->digital_count - 1, $a[0]);
            $a = array_merge($a, $b);
        }
        $pattern = '/^' . implode(preg_quote($sSplitChar), $a) . '$/';
        return $pattern;
    }

    private static function compileSubPattern($s) {
        return '[' . $s . ']+';
    }

}