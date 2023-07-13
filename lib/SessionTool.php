<?php
use Illuminate\Encryption\Encrypter;

class SessionTool {

    protected static $driver = 'memcached';
    
    public static function compileCacheKey($bIsAdmin, $sUsername){
        $sPrefix = Config::get('cache.prefix');
        $sPrefix .= 'session-';
        $sPrefix .= ($bIsAdmin ? 'admin' : 'user') . '-';
        return  $sPrefix . $sUsername;
    }

    protected static function setDriver(){
        Cache::setDefaultDriver(static::$driver);
    }
    
    public static function saveSessionId($bIsAdmin, $sUsername, $sSessionId){
        self::setDriver();
        $sKey = self::compileCacheKey($bIsAdmin, $sUsername);
        Cache::forever($sKey, $sSessionId);
    }

    public static function getSessionId($bIsAdmin, $sUsername){
        self::setDriver();
        $sKey = self::compileCacheKey($bIsAdmin, $sUsername);
        return Cache::get($sKey);
    }
    
    public static function deleteSession($bIsAdmin, $sUsername){
        if ($session_id = self::getSessionId($bIsAdmin, $sUsername)){
            $handler = Session::getHandler();
            $handler->destroy($session_id);
        }
    }

    public static function getSessionData($bIsAdmin, $sUsername){
        $session_id = self::getSessionId($bIsAdmin, $sUsername);
        $handler = Session::getHandler();
        $session = $handler->read($session_id);
        return unserialize($session);
    }
    
    public static function getLastUpdatedTime($bIsAdmin, $sUsername){
        $aData = self::getSessionData($bIsAdmin, $sUsername);
        return $aData['_sf2_meta']['u'];
    }
}
