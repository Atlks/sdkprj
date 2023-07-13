<?php

/*
 * 与日期有关的操作类
 *
 * @version 1.0.0
 * @author Frank
 * @date 2013-08-07
 */

class Date {

    /**
     * 星期名字数组，存储英语名
     * @var type array
     */
    public static $weeks  = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        0 => 'Sunday'
    ];
    public static $months = [
        1  => 1,
        2  => 2,
        3  => 3,
        4  => 4,
        5  => 5,
        6  => 6,
        7  => 7,
        8  => 8,
        9  => 9,
        10 => 10,
        11 => 11,
        12 => 12
    ];

    /**
     * 一星期中所有天的标识数字
     * @var type integer
     */
    public $allDays = 127;

    /**
     *
     * @param integer $iDaysNumber  标识哪些天的数字
     * @param bool $bReturnName     是否返回名字，为假时返回的数组中的值是数字，星期天为0；为真时，数组中的值是英语的名称
     * @return array &
     */
    public static function & checkWeekDays($iDaysNumber, $bReturnName = false) {
        for ($i = 0; $i < 7; $i++) {
            $iBase = pow(2, $i);
            if (($iDaysNumber & $iBase) == $iBase) {
                $aWeek[] = $bReturnName ? self::$weeks[$i] : $i;
            }
        }
        return $aWeek;
    }

    /**
     * 检测是否是合法日期
     * 标准日期格式:2009-08-12
     *
     * @param string $sDate 	需要检测的日期
     * @param return boolean	返回是否合法
     */
    public static function isLegalDate($sDate) {
        if (empty($sDate))
            return false;
        list($sYear, $sMonth, $sDay) = explode('-', $sDate);
        if (!is_numeric($sYear) || !is_numeric($sMonth) || !is_numeric($sDay))
            return false;
        if (strlen($sYear) != 4 || strlen($sMonth) != 2 || strlen($sDay) != 2)
            return false;
        return checkdate($sMonth, $sDay, $sYear);
    }

    public static function makeDaysNumber($aSelected) {
        $iNumber = 0;
        foreach ($aSelected as $iWeek) {
            $iNumber += pow(2, $iWeek);
        }
        return $iNumber;
    }

    public static function dateAdd($sDate, $iStep = 1, $sLong = 'day') {
        $iStamp  = strtotime($sDate);
        list($year, $month, $day, $hour, $minute, $second) = explode('-', date('Y-m-d-H-i-s', $iStamp));
        $$sLong  += $iStep;
        $sFormat = $hour > 0 ? 'Y-m-d H:i:s' : 'Y-m-d';
        return date($sFormat, mktime($hour, $minute, $second, $month, $day, $year));
    }

    public static function getMonth($iYear, $iMonth, $sSplitChar = '-') {
        $iMonth = str_pad($iMonth, 2, '0', STR_PAD_LEFT);
        return $iYear . $sSplitChar . $iMonth;
    }

    /**
     * 计算两个日期之间差多少天,返回永远是正数
     * @param string $date1 日期1
     * @param string $date2 日期2
     * @return int      差多少天
     */
    public static function between($date1, $date2) {
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);
        $days  = ceil(abs($date1 - $date2) / 86400);
        return $days;
    }

    public static function getMonths() {
        return static::$months;
    }

    /**
     * 将给定的时间段按自然天分解为两个数组：一个保存不足一天的时间段，另一个保存整天的日期
     * @param datetime $dMinTime    开始时间
     * @param datetime $dMaxTime    结束时间
     * @param array $aPartTimes     保存不足一天的时间段
     * @param array $aFullDays  保存整天的日期
     */
    public static function groupTimeSlice($dMinTime, $dMaxTime, &$aPartTimes, &$aFullDays) {
        $aPartTimes     = $aFullDays      = [];
        $dDateOfMinTime = substr($dMinTime, 0, 10);
        $dDateOfMaxTime = substr($dMaxTime, 0, 10);
        if (substr($dMinTime, 11) != '00:00:00' && substr($dMaxTime, 11) != '23:59:59') {
            if ($dDateOfMinTime == $dDateOfMaxTime) {
                $aPartTimes[] = [$dMinTime, $dMaxTime];
            } else {
                $aPartTimes[] = [$dMinTime, $dDateOfMinTime . ' 23:59:59'];
                $aPartTimes[] = [$dDateOfMaxTime, $dMaxTime];
            }
        } else {
            if ($dDateOfMinTime == $dDateOfMaxTime) {
                $aPartTimes[] = [$dMinTime, $dMaxTime];
            } else {
                $aPartTimes[] = [$dDateOfMaxTime, $dMaxTime];
                $aFullDays[]  = $dDateOfMinTime;
            }
        }
        $iDateOfMaxTime = strtotime($dDateOfMaxTime);
        for ($i = strtotime($dDateOfMinTime . '+1 day'); $i < $iDateOfMaxTime; $i += 3600 * 24) {
            $aFullDays[] = date('Y-m-d', $i);
        }
    }

    /**
     * 根据关键字取得时间范围
     * @param string $sFlg  日期范围关键字 today  lastWeek  currentWeek  currentMonth  preHalfMonth  nextHalfMonth
     * @return array
     * [
     *  'dtFrom'
     *  'dtTo'
     * ]
     */
    public static function getDateTimeRange($sFlg) {
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
