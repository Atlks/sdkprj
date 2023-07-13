<?php

/**
 * Number类
 *
 * @author winter
 */
class Number {

    /**
     * 由中奖号码分析得出各投注方式的中奖号码数组
     * @param Lottery $oLottery
     * @param string $sFullWnNumber
     * @param bool $bNameKey
     * @return array &
     */
    public static function & _getWnNumberOfSeriesMethods($oLottery,$sFullWnNumber,$bNameKey = false){
//        pr($oLottery);
//        pr($sFullWnNumber);
//        pr($oLottery->toArray());
//        exit;
        $oSeriesMethods = SeriesMethod::getAvailableMethods($oLottery->series_id);
//        pr($oSeriesMethods->count());
//        exit;
        $aWnNumbers     = [];
        $sKeyColumn     = $bNameKey ? 'name' : 'id';
        foreach ($oSeriesMethods as $oSeriesMethod){
            $aWnNumbers[ $oSeriesMethod->$sKeyColumn ] = $oSeriesMethod->getWinningNumber($sFullWnNumber);
        }
        return $aWnNumbers;
    }

    public static function & getWnNumberOfSeriesMethods($oLottery,$sFullWnNumber, & $aWnNumberOfMethodsByName){
        $aWnNumberOfMethods = Number::_getWnNumberOfSeriesMethods($oLottery,$sFullWnNumber);
        $aWnNumberOfMethodsByName = Number::_getWnNumberOfSeriesMethods($oLottery,$sFullWnNumber,true);
//        pr($aWnNumberOfMethods1);
//        exit;
//        file_put_contents($this->wnNumberFile,var_export($aWnNumberOfMethods,true));
//        file_put_contents($this->wnNumberFile2,var_export($aWnNumberOfMethodsByName,true));
        return $aWnNumberOfMethods;
    }

}
