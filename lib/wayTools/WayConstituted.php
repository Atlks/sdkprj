<?php
class WayConstituted extends Way {

    public static $shapeOfSingleConstituted = [
        '2|2'   => 2,
        '3|1'   => 1,
        '3|2'   => 2,
        '3|3'   => 2,
        '3|6'   => 3,
        '4|1'   => 1,
        '4|2'   => 2,
        '4|6'   => 2,
        '4|24'  => 4,
        '5|1'   => 1,
        '5|2'   => 2,
        '5|3'   => 2,
        '5|120' => 5,
    ];
    
    public static $needMultiples = [
        '3|3' => 2
    ];

    /**
     * 注数计算
     * @param SeriesWay $oSeriesWay
     * @param string     $sBetNumber
     * @return int
     */
    public static function count($oSeriesWay,& $sBetNumber){
        $sNeedNumberCountKey = $oSeriesWay->digital_count . '|' . $oSeriesWay->shape;
        if (array_key_exists($sNeedNumberCountKey, static::$shapeOfSingleConstituted)){     // single area
//            pr($aOrder['bet_number']);
            $iCount = self::countSingleConstituted($sBetNumber, static::$shapeOfSingleConstituted[$sNeedNumberCountKey]);
            if (array_key_exists($sNeedNumberCountKey, static::$needMultiples)){
                $iCount *= static::$needMultiples[$sNeedNumberCountKey];
            }
        }
        else{       // double area
//            $aParts = explode('|',$oSeriesWay->area_config);
//            $aCombin = [];
            $aAreaConfig = self::getAreaConfig($oSeriesWay);
            $aNums = explode('|', $sBetNumber);
            foreach($aNums as $k => $sNums){
                $aNumOfArea[$k] = str_split($sNums,1);
                sort($aNumOfArea[$k]);
            }
//            pr($aAreaConfig);
//            pr($aNumOfArea);
//            pr($oSeriesWay->toArray());
//            pr($sNeedNumberCountKey);
//            exit;
            switch ($sNeedNumberCountKey){
                case '5|60':        // 五星组选60
//                  combin(m同,1)*combin(n-1,3)+combin(m异,1)*combin(n,3)
                case '5|20':        // 五星组选20
//                  COMBIN(m同,1)*COMBIN(n-1,2)+COMBIN(m异,1)*COMBIN(n-0,2)
                case '5|10':        // 五星组选10
//                    COMBIN(m同,1)*COMBIN(n-1,1)+COMBIN(m异,1)*COMBIN(n,1)
                case '5|5':         // 五星组选5
//                    COMBIN(m同,1)*COMBIN(n-1,1)+COMBIN(m异,1)*COMBIN(n,1)
                case '4|12':
//                    COMBIN(m同,1)*COMBIN(n-1,2)+COMBIN(m异,1)*COMBIN(n,2)
                case '4|4':
                    $iNeedNumCountOfN = self::getNeedNumCountOfN($oSeriesWay, $aAreaConfig[0][0]);
                    $aRepeatM = array_intersect($aNumOfArea[0], $aNumOfArea[1]);
                    $iRepeatCountM = count($aRepeatM);
                    $iNonRepeatCountM = count($aNumOfArea[0]) - $iRepeatCountM;
                    $iCountN = count($aNumOfArea[1]);
                    $iCount = Math::combin($iRepeatCountM, 1) * Math::combin($iCountN - 1, $iNeedNumCountOfN) 
                            + Math::combin($iNonRepeatCountM,1) * Math::combin($iCountN, $iNeedNumCountOfN);
                    break;
                case '5|30':        // 五星组选30
                    $aRepeatN = array_intersect($aNumOfArea[1], $aNumOfArea[0]);
                    $iRepeatCountN = count($aRepeatN);
                    $iNonRepeatCountN = count($aNumOfArea[1]) - $iRepeatCountN;
                    $iCountM = count($aNumOfArea[0]);
                    $iCount = Math::combin($iRepeatCountN, 1) * Math::combin($iCountM - 1, 2) 
                            + Math::combin($iNonRepeatCountN, 1) * Math::combin($iCountM, 2);
//                  combin(n同,1)*combin(m-1,2)+combin(n异,1)*combin(m,2)
                    break;
                case '5|3':

                    break;
            }
//            pr($iCount);
//            exit;
        }
        return $iCount;
    }
    
    /**
     * 返回第二区需要选择的号码个数
     * 
     * @param SeriesWay $oSeriesWay
     * @param int $iMaxRepeatTimeOfM   第一区内重号的重复次数
     * @return int
     */
    private static function getNeedNumCountOfN($oSeriesWay, $iMaxRepeatTimeOfM){
        $iNeedNumCountOfN = $oSeriesWay->digital_count - $iMaxRepeatTimeOfM;
        $oSeriesWay->shape != 10 or $iNeedNumCountOfN--;
        return $iNeedNumCountOfN;
    }
    
    /**
     * 计算单区复式的注数
     * 
     * @param string $sbetNumber
     * @param int $iNeedNumCount
     * @return int
     */
    private static function countSingleConstituted($sbetNumber, $iNeedNumCount){
        $aNums = str_split($sbetNumber);
        $aNumCounts = array_count_values($aNums);
        $iNumCount = count($aNumCounts);
        $iCount = ($iNumCount < $iNeedNumCount) ? 0 : Math::combin($iNumCount, $iNeedNumCount);
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
        $sKey = $oSeriesWay->digital_count . '.' . intval($oSeriesWay->shape);
        if ($oSeriesWay->shape > -1){
            switch ($sKey){
                case '2|1':     // 一码不定位
                case '3|1':     // 三星一码不定位
                case '4|1':     // 4星一码不定位
                case '3|2':     // 三星二码不定位
                case '4|2':     // 4星二码不定位
                case '5|2':     // 5星二码不定位
                case '5|3':     // 5星二码不定位
                    $iNeedle = self::getNeedleUnqiueNumberCount($sKey);
                    $aWinningNumbers = array_unique(str_split($sWinningNumber, 1));
                    if (count($aWinningNumbers) < $iNeedle) return '';
                    sort($aWinningNumbers);
                    return $aWinningNumbers;
                    break;
                case '2|2':     // 二星组选
                    $iShapeOfNumber    = DigitalNumber::getShape($sNumber);
                    return $iShapeOfNumber == $oSeriesWay->shape ? DigitalNumber::getCombinNumber($sNumber,true) : '';
//                    return DigitalNumber::getCombinNumber($sNumber, true);
                    break;
                case '2|4':     // 大小单双
                    list ($aBig, $aOdd) = self::getBigOddShape($sWinningNumber);
                    $aWinningNumbers[] = $aBig[0] . $aBig[1];
                    $aWinningNumbers[] = $aBig[0] . $aOdd[1];
                    $aWinningNumbers[] = $aOdd[0] . $aOdd[1];
                    $aWinningNumbers[] = $aOdd[0] . $aBig[1];
                    return $aWinningNumbers;
                    break;
                case '3|8':
                    list ($aBig, $aOdd) = self::getBigOddShape($sWinningNumber);
                    $aWinningNumbers[] = $aBig[0] . $aBig[1] . $aBig[2];
                    $aWinningNumbers[] = $aBig[0] . $aBig[1] . $aOdd[2];
                    $aWinningNumbers[] = $aBig[0] . $aOdd[1] . $aBig[2];
                    $aWinningNumbers[] = $aBig[0] . $aOdd[1] . $aOdd[2];
                    $aWinningNumbers[] = $aBig[1] . $aBig[1] . $aBig[2];
                    $aWinningNumbers[] = $aBig[1] . $aBig[1] . $aOdd[2];
                    $aWinningNumbers[] = $aBig[1] . $aOdd[1] . $aBig[2];
                    $aWinningNumbers[] = $aBig[1] . $aOdd[1] . $aOdd[2];
                    return $aWinningNumbers;
                    break;
                case '4|4':
                case '5|5':
//                    pr($oSeriesWay->area_config);
                    $aAreaConfig = self::getAreaConfig($oSeriesWay);
//                    pr($aAreaConfig);
                    $aNum = str_split($sWinningNumber,1);
                    $aCounts = array_count_values($aNum);
                    $sWinningNumber = max($aCounts) == $aAreaConfig[0][0] ? DigitalNumber::getCombinNumber($sWinningNumber, false) : '';
                    break;
                case '4|6':
                    $aNum = str_split($sWinningNumber,1);
                    $aCounts = array_count_values($aNum);
                    $aCountValues = array_values($aCounts);
                    $sWinningNumber = (count($aCounts) == 2 && $aCountValues[0] == $aCountValues[1]) ? DigitalNumber::getCombinNumber($sWinningNumber, false) : '';
                    break;
                case '4|12':
                case '5|20':
//                    $sWinningNumber = '9987';
                    $aAreaConfig = self::getAreaConfig($oSeriesWay);
                    $aNum = str_split($sWinningNumber,1);
                    $aCounts = array_count_values($aNum);
                    sort($aCounts);
                    $iMaxCount = array_pop($aCounts);
                    $iCount = count($aCounts);
                    $sWinningNumber = ($iMaxCount == $aAreaConfig[0][0] && $iCount == $aAreaConfig[1][1]) ? DigitalNumber::getCombinNumber($sWinningNumber, false) : '';
                    break;
                case '4|24':
                case '5|120':
                    $aNum = str_split($sWinningNumber,1);
                    $aCounts = array_count_values($aNum);
                    $sWinningNumber = (count($aCounts) == $oSeriesWay->digital_count) ? DigitalNumber::getCombinNumber($sWinningNumber, false) : '';
                    break;
                case '5|10':
                    $aAreaConfig = self::getAreaConfig($oSeriesWay);
//                    $aAreaConfig = self::getAreaConfig($oSeriesWay);
//                    var_dump($aAreaConfig);
//                    pr($aAreaConfig[0]);
                    $aNum = str_split($sWinningNumber,1);
                    $aCounts = array_count_values($aNum);
                    $sWinningNumber = (max($aCounts) == $aAreaConfig[0][0] && min($aCounts) == $aAreaConfig[1][0]) ? DigitalNumber::getCombinNumber($sWinningNumber, false) : '';
                    break;
                case '5|30':
                    $aAreaConfig = self::getAreaConfig($oSeriesWay);
                    $aNum = str_split($sWinningNumber,1);
                    $aCounts = array_count_values($aNum);
                    $sWinningNumber = (max($aCounts) == $aAreaConfig[0][0] && count($aCounts) == 3) ? DigitalNumber::getCombinNumber($sWinningNumber, false) : '';
                    break;
                case '5|60':
                    $aAreaConfig = self::getAreaConfig($oSeriesWay);
                    $aNum = str_split($sWinningNumber,1);
                    $aCounts = array_count_values($aNum);
                    $sWinningNumber = (max($aCounts) == $aAreaConfig[0][0] && count($aCounts) == 4) ? DigitalNumber::getCombinNumber($sWinningNumber, false) : '';
                    break;
                default:
                    $iShapeOfNumber = DigitalNumber::getShape($sNumber);
                    if ($iShapeOfNumber == $oSeriesWay->shape){
                        if ($oSeriesWay->area_count == 1){
                            return DigitalNumber::getCombinNumber($sNumber, true);
                        }
                        else{
                            // todo:
                        }
                    }
                    else{
                        $sWinningNumber = '';
                    }
            };
        }
        return $sWinningNumber;
    }

    /**
     * 返回投注区配置数组
     * 
     * @param SeriesWay $oSeriesWay
     * @return array
     */
    public static function getAreaConfig($oSeriesWay) {
        $a = explode('|', $oSeriesWay->area_config);
        foreach($a as $k => $s){
            $aAreaConfig[$k] = explode('*', $s);
        }
        return $aAreaConfig;
    }

    public static function getBigOddShape($sNumber){
        $aWei = str_split($sNumber,1);
        $iDigitalCount = count($aWei);
        $aBig = $aOdd = [];
        foreach($aWei as $i => $iNum){
            $aBig[$i] = intval($iNum > 4);
            $aOdd[$i] = $iNum % 2 + 2;
//            $aWinningNumbers[] 
        }
        return [$aBig, $aOdd];
    }
    
    public static function getNeedleUnqiueNumberCount($sKey){
        switch($sKey){
            case '3|1':     // 三星一码不定位
            case '4|1':     // 4星一码不定位
                $iNeedle = 1;
                break;
            case '3|2':     // 三星二码不定位
            case '4|2':     // 4星二码不定位
            case '5|2':     // 5星二码不定位
                $iNeedle = 2;
                break;
            case '5|3':     // 5星二码不定位
                $iNeedle = 3;
                break;
        }
        return $iNeedle;
    }
}
