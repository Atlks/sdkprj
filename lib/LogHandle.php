<?php

Class LogHandle
{

    /**
     *  写Log档
     * @param  string        $sLogString                    Log 内容
     * @param  string        $sPath                             Log 档名(含路迳)
     * @param  boolean    $bAppendSpaceLine    是否加入空白行
     * @return  boolean                                             是否执行成功
     * @author Wright
     * @date     2016-12-27
     */
    public static function writeLog(
        $sLogString = '',
        $sPath = DIRECTORY_SEPARATOR,
        $bAppendSpaceLine = false
    ) {
        // 预设 Log 启始路迳
        $sPath = Config::get('log.root') . DIRECTORY_SEPARATOR . $sPath;

        $aPath = explode(DIRECTORY_SEPARATOR, $sPath);
        $sFileName = end($aPath);
        unset($aPath[count($aPath) - 1]);
        $sFolderPath = join(DIRECTORY_SEPARATOR, $aPath);

        self::_checkFolder($sFolderPath);
        self::_writeLog($sLogString, $sPath, $bAppendSpaceLine);

        return true;
    }

    /*
     *  建立资料夹并给予权线
     */
    protected static function _checkFolder($sPath)
    {
        if (!file_exists($sPath)) {
            @mkdir($sPath, 0777, true);
            @chmod($sPath, 0777);
        }
    }

    /*
     *  实际写log档
     */
    protected static function _writeLog($sString, $sPath, $bAppendSpaceLine = false)
    {
         $sString = date('Y-m-d H:i:s') . ', ' . 'pid=' . posix_getpid() . ': ' . $sString . "\n";
         if ($bAppendSpaceLine) {
            $sString .= "\n";
         }
         return file_put_contents($sPath, $sString, FILE_APPEND);
    }

}