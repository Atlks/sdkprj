<?php

/**
 * 团队盈亏报表时间范围取得
 *
 * @author okra
 * @date 2017-3-2
 */
class DateUtils{
    /**
     * 团队盈亏报表时间范围取得
     * @param string $sFlg  日期范围的类别
     * @return array
     */
    public static function getDateBetween($sFlg) {
        $aDtArray = [];
        switch($sFlg){
            case 'today':
                $dtTmp = strtotime('now');
                $aDtArray['dtFrom'] = date('Y-m-d',$dtTmp);
                $aDtArray['dtTo'] = date('Y-m-d',$dtTmp);
                break;
            case 'lastWeek':
                $aDtArray['dtFrom'] = date('Y-m-d',mktime(0, 0 , 0,date('m'),date('d')-date('w')+1-7,date('Y')));
                $aDtArray['dtTo'] = date('Y-m-d',mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y')));
                break;
            case 'currentWeek':
                $aDtArray['dtFrom'] = date('Y-m-d',mktime(0, 0 , 0,date('m'),date('d')-date('w')+1,date('Y')));
                $aDtArray['dtTo'] = date('Y-m-d',mktime(23,59,59,date('m'),date('d')-date('w')+7,date('Y')));
                break;
            case 'currentMonth':
                $aDtArray['dtFrom'] = date('Y-m-d',mktime(0, 0 , 0,date('m'),1,date('Y')));
                $aDtArray['dtTo'] = date('Y-m-d',mktime(23,59,59,date('m'),date('t'),date('Y')));
                break;
            case 'preHalfMonth':
                $aDtArray['dtFrom'] = date('Y-m-d',mktime(0, 0 , 0,date('m'),1,date('Y')));
                $aDtArray['dtTo'] = date('Y-m-15',mktime(23,59,59,date('m'),1,date('Y')));
                break;
            case 'nextHalfMonth':
                $aDtArray['dtFrom'] = date('Y-m-16',mktime(0, 0 , 0,date('m'),1,date('Y')));
                $aDtArray['dtTo'] = date('Y-m-d',mktime(23,59,59,date('m'),date('t'),date('Y')));
                break;
        }
        return $aDtArray;
    }

}
