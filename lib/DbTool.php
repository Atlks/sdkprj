<?php
class DbTool {

    public static function getDbThreadId(){
        $link = DB::connection()->getPdo();
        $thread_id = $link->query('SELECT CONNECTION_ID() as cid')->fetch(PDO::FETCH_ASSOC)['cid'];
        return $thread_id;
    }

    public static function & getDbThreads(){
        $aInfo = DB::select('show processlist');
        $data = [];
        foreach($aInfo as $aObject){
            $data[] = $aObject->Id;
        }
//        pr($data);
        return $data;
    }

    public static function & getColumnTypes($sTable, $sDatabase = null){
        $sDatabase or $sDatabase = DB::connection()->getConfig('database');
        $sql = "select column_name, data_type from information_schema.columns where table_schema = '$sDatabase' and table_name = '$sTable' order by ordinal_position;";
        $aColumns = DB::select($sql);
        $data = [];
        foreach ($aColumns as $oConfig) {
            $data[$oConfig->column_name] = $oConfig->data_type;
        }
        return $data;
    }
    
    public static function & getColumnConfigs($sTable, $sDatabase = null){
        $sDatabase or $sDatabase = DB::connection()->getConfig('database');
        $sql = "select column_name, data_type, column_type,character_maximum_length,is_nullable,column_default,ordinal_position"
                . " from information_schema.columns where table_schema = '$sDatabase' and table_name = '$sTable'"
                . " order by ordinal_position";
        $aColumns = DB::select($sql);
        $data = [];
        foreach ($aColumns as $oConfig) {
            $data[$oConfig->column_name] = [
                'type' => $oConfig->data_type,
                'full_type' => $oConfig->column_type,
                'width' => $oConfig->character_maximum_length,
                'default' => $oConfig->column_default,
                'null' => $oConfig->is_nullable,
                'position' => $oConfig->ordinal_position,
            ];
        }
        return $data;
    }
    
    public static function & getTables($sDbName){
        $sql = "select TABLE_NAME from information_schema.TABLES where TABLE_SCHEMA = '$sDbName' order by TABLE_NAME";
        $aTableInfos = DB::select($sql);
        $data = [];
        foreach($aTableInfos as $oConfig){
            $data[] = $oConfig->TABLE_NAME;
        }
        return $data;
    }
    
    public static function getAppLock($sLockName, $iSeconds = 20){
        $sSql = "select get_lock('$sLockName',$iSeconds) as applock";
        $a = DB::select($sSql);
        return $a[0]->applock == 1;
    }
    
    public static function releaseAppLock($sLockName){
        $sSql = "select release_lock('$sLockName') as apprelease";
        $a = DB::select($sSql);
        return $a[0]->apprelease == 1;
    }

//    /**
//     * 从数据库服务器返回mysql线程ID列表
//     * @return array 包含mysql线程ID的一维数组
//     */
//    public function getMysqlThreadList(){
//        $aProcessList   = DB::connection()->select("show processlist");
//        $aProcessIdList = array();
//        foreach ($aProcessList as $val){
//            $aProcessIdList[] = $val->Id;
//        }
//        return $aProcessIdList;
//    }

}