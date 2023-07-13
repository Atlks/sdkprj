<?php

/**
 * 中文数字类
 *
 * @author winter
 */
class ChnNumber {

    private static $chnNumbers = ['零','一','二','三','四','五','六','七','八','九'];
    
    public static function getChnNumber($iNumber){
        return static::$chnNumbers[$iNumber];
    }
    
    public static function getChnNumbers(){
        return static::$chnNumbers;
    }
    
    public static function getLevels(){
        for($i = 1, $levels = []; $i < 10; $i++){
            $levels[$i] = static::getChnNumber($i) . '等奖';
        }
        return $levels;
    }
    
    public static function getLevel($iLevel = 1){
        return static::getChnNumber($iLevel) . '等奖';
    }
}
