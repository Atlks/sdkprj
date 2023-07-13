<?php

class Calculate {

    public static function simulateCalculate($oIssue, $sWnNumber, & $aWonProjects = null){
        $oLottery = ManLottery::find($oIssue->lottery_id);
        $oIssue->wn_number = $sWnNumber;
        $aWnNumberOfMethods = static::getWnNumberOfSeriesMethods($oLottery,$oIssue->wn_number,$aWnNumberOfMethodsByName);
        $fPrize = 0;
        $aSeriesWayIds = ManProject::getWayIds($oLottery->id, $oIssue->issue);
        foreach ($aSeriesWayIds as $iSeriesWayId){
            $oSeriesWay = SeriesWay::find($iSeriesWayId);
            $sLogMsgOfWay    = " Way: $oSeriesWay->id $oSeriesWay->name ";
            $aWinningNumbers = & $oSeriesWay->getWinningNumber($aWnNumberOfMethods);
            $fPrize += static::calculateProjectsOfWay($oSeriesWay, $oIssue, $aWonProjects = null);
        }
        return $fPrize;
    }

    private static function & getWnNumberOfSeriesMethods($oLottery,$sFullWnNumber, & $aWnNumberOfMethodsByName){
        $aWnNumberOfMethods = Number::getWnNumberOfSeriesMethods($oLottery,$sFullWnNumber, $aWnNumberOfMethodsByName);
        return $aWnNumberOfMethods;
    }

    /**
     * 对指定SeriesWay的所有注单计奖
     *
     * @param Issue $oIssue
     * @return boolean
     */
    private static function calculateProjectsOfWay($oSeriesWay, $oIssue, & $aWonProjects = null){
        $DB        = DB::connection();
        if ($oSeriesWay->WinningNumber === false){
            return 0;
        }
        $oProjects           = ManProject::getValidProjects($oIssue->lottery_id,$oIssue->issue,$oSeriesWay->id);
        $aPrizedOfBetNumbers = [];
        $fTotalPrize = 0;
        foreach ($oProjects as $oProject){
            if ($oProject->is_tester){
                continue;
            }
            $fTotalPrize += static::calculateProject($oSeriesWay,$oIssue,$oProject,$aPrizedOfBetNumbers,$aWonProjects,$aLostProjects);
        }
        return $fTotalPrize;
    }

    /**
     * 对注单计奖
     * @param SeriesWay $oSeriesWay
     * @param Issue $oIssue
     * @param Project $oProject
     * @param array & $aPrizedOfBetNumbers
     * @param array & $aWonProjects
     * @param array & $aLostProjects
     * @param array & $aNeedStopTraces
     * @param array & $aNeedGenerateTrace
     * @return array &
     */
    private static function & calculateProject($oSeriesWay,$oIssue,$oProject,& $aPrizedOfBetNumbers,& $aWonProjects,& $aLostProjects){
        $sBetNumber = $oProject->bet_number;
        $sKey       = md5($sBetNumber);
        if (array_key_exists($sKey,$aPrizedOfBetNumbers)){
            $aPrized = $aPrizedOfBetNumbers[ $sKey ];
        }
        else{
            $aPrized   = $oSeriesWay->checkPrize($sBetNumber,$oProject->position);
            !$aPrized or $aPrizedOfBetNumbers[ md5($sBetNumber) ] = $aPrized;
        }
        if ($aPrized){
            $oProject  = ManProject::find($oProject->id);
            $oProject->countPrize($aPrized, $fPrize);
            $aWonProjects[] = $oProject->id;
        }
        else{
            $aLostProjects []     = $oProject->id;
            $fPrize = 0;
        }
        return $fPrize;
    }

}
