<?php
class Math {
    
    static function combin($iBase, $iChoosed){
        if ($iBase < $iChoosed) return 0;
        if ($iBase == $iChoosed) return 1;
        if (($iEqual = $iBase - $iChoosed) < $iChoosed){
            return self::combin($iBase, $iEqual);
        }
        return self::permut($iBase, $iChoosed) / self::factorial($iChoosed);
    }
    
    static function permut($iBase, $iChoosed){
        if ($iBase < $iChoosed) return 0;
        for($i = 0, $p = 1; $i < $iChoosed; $p *= ($iBase - $i++));
        return $p;
    }
    
    static function factorial($iNum){
        for($f = 1, $i = 2; $i <= $iNum; $f *= $i++);
        return $f;
    }
    
    static function truncateNumber($fNumber, $iDecimal = 2){
        $p = pow(10,intval($iDecimal));
        return intval($fNumber * $p) / $p;
    }
    
}