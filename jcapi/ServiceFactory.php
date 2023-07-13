<?php
/**
 * 接口工厂类 单例
 * User: damon
 * Date: 1/24/16
 * Time: 6:15 PM
 */
class ServiceFactory{

    /**
     * 获取接口类实例
     *
     * @param $sServiceName string 接口类名称
     * @param bool|false $bInstance 是否单例
     * @return Object 类的实例
     */
    public static function getService($sServiceName,$aConfig,$bInstance = false){
        static $_instance = [];
        $sServiceClassName = ucfirst($sServiceName).'Service';
        if(!$bInstance){
            return new $sServiceClassName($aConfig);
        }

        if(!isset($_instance[$sServiceName])){
            $_instance[$sServiceName] = new $sServiceClassName($aConfig);
        }
        return $_instance[$sServiceName];
    }


}