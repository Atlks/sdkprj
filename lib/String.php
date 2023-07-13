<?php

use Illuminate\Support\Str;

class String extends Str {

    public static function humenlize($sString) {
        return ucwords(str_replace(array('-', '_'), ' ', parent::snake($sString)));
//      return str_replace(' ', '', $value);
    }

    /**
     * 去除字符串中的脚本
     *
     * @param string $mString
     * @param boolean $bStripTag 是否一并去取HTML标签
     * @return string
     */
    public static function stripScript($mString, $bStripTag = false, $bTrim = false) {
        if (is_array($mString)) {
            foreach ($mString as $key => $val) {
                $mString[$key] = self::stripScript($val, $bStripTag, $bTrim);
            }
        } else {
            $sPattern = array("!<script.*>.*</script>!Uis", "!<\?.*\?>!Uis", "!<%.*%>!Uis");
            $mString  = preg_replace($sPattern, '', $mString);
            !$bStripTag or $mString  = strip_tags($mString);
            !$bTrim or $mString  = trim($mString);
        }

        return $mString;
    }

    /**
     * 将字符串转换为SQL安全的
     *
     * @param string $string
     * @param boolean $force  是否强制
     * @return unknown
     */
    public static function sqlSafe($string, $force = false) {
        if (isset($GLOBALS['magic_quotes_gpc']))
            $magic_quotes_gpc = $GLOBALS['magic_quotes_gpc'];
        else
            $magic_quotes_gpc = get_magic_quotes_gpc();

        if (!$magic_quotes_gpc || $force) {
            if (is_array($string)) {
                foreach ($string as $key => $val) {
                    $string[$key] = self::sqlSafe($val, $force);
                }
            } else {
                $string = addslashes($string);
            }
        }
        return $string;
    }

    /**
     * 传只有两个值的 array, 第一个为小第二个为大
     * 取大或小
     * TODO
     * 做成直接取数组最大或最小
     *
     * @author Rex
     * @date   2017-01-13
     * @param  arrray     $aValueList   只有两个值的 array, 第一个为小第二个为大
     * @param  string     $sChoice        选择取大或小
     * @return  int           $iValue          处理后的数字结果
     */
    public static function findIntInArray($aValueList, $sChoice = 'big') {
        $iValue     = 0;
        $aGiftValue = explode(',', $aValueList);
        if ($sChoice == 'big') {
            $iValue = $aGiftValue[1];
        } else if ($sChoice == 'samll') {
            $iValue = $aGiftValue[0];
        }
        return $iValue;
    }

    /**
     * 遮敝文字 中间区段 只留前后 (可指定遮敝符号)
     * @author Wright
     * @param  String  $sString
     * @param  String  $sSymbol     遮敝符号
     * @return  String
     * @date     2017-01-20
     */
    public static function maskString($sString, $sSymbol = '*') {
        return substr($sString, 0, 1) . str_repeat($sSymbol, strlen($sString) - 2) . substr($sString, -1, 1);
    }

}
