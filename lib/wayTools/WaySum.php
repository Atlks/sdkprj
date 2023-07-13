<?php
class WaySum extends Way {

    /**
     * 注数数组
     * @var array 
     */
    private static $countArray = [
        2 => [
            'separated' => [ 1,2,3,4,5,6,7,8,9,10,9,8,7,6,5,4,3,2,1],
            'combin'    => [ 0,1,1,2,2,3,3,4,4,5,4,4,3,3,2,2,1,1,0 ]
        ],
        3 => [
            'separated' => [ 1,3,6,10,15,21,28,36,45,55,63,69,73,75,75,73,69,63,55,45,36,28,21,15,10,6,3,1 ],
            'combin'    => [ 0,1,2,2,4,5,6,8,10,11,13,14,14,15,15,14,14,13,11,10,8,6,5,4,2,2,1,0 ]
        ]
    ];
    
    /**
     * 允许的数位数组
     * @var array 
     */
    private static $validDigitals = [2,3];

    /**
     * 返回需要的键，用此键到计数数组中取得相应的值
     * 
     * @param bool $bCombin
     * @return string
     */
    private static function getKey($bCombin){
        return $bCombin ? 'combin' : 'separated';
    }
    
    /**
     * 注数计算
     * @param SeriesWay $oSeriesWay
     * @param string     $sNumber
     * @return int
     */
    public static function count($oSeriesWay,& $sNumber){
        $bCombin = $oSeriesWay->shape != -1;
        $iDigital = $oSeriesWay->digital_count;
        $sSplitChar = Config::get('bet.split_char') or $sSplitChar = '|';

        if (!in_array($iDigital, static::$validDigitals)) return 0;
        $aSums = explode($sSplitChar, $sNumber);
        $iCount = 0;
        $sKey = self::getKey($bCombin);
        foreach($aSums as $iSum){
            if (isset(static::$countArray[$iDigital][$sKey][$iSum])){
                 $iCount += static::$countArray[$iDigital][$sKey][$iSum];
            }
            else{
                return 0;
            }
        }
        return $iCount;
    }
    
    public static function & getCountArray($iDigital = 3, $bCombin = false ){
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
        $sWinningNumber = '';
        if ($oSeriesWay->shape > -1){
            $iShapeOfNumber = DigitalNumber::getShape($sNumber);
            $sWinningNumber = $iShapeOfNumber == $oSeriesWay->shape ? DigitalNumber::getSum($sNumber) : '';
        }
        else{
            $sWinningNumber = DigitalNumber::getSum($sNumber);
        }
        return $sWinningNumber;
    }
}
