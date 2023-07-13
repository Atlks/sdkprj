<?php

/**
 * ftp  操作类
 *
 * @author Garin
 * @date 2016-11-21
 */
class Ftp {


    protected $connection = '';

    public function __construct($aConfig) {

        $this->connection = $this->connect($aConfig);

    }

    /**
     * 连接和登陆ftp
     *
     * @param $aConfig
     *
     * @return resource
     * @throws Exception
     */
    public function connect($aConfig) {
        if (empty($aConfig))
            throw new Exception('Ftp config is empty!');

        if (!isset($aConfig['username']))
            throw new Exception('Ftp config user_name is empty!');

        if (!isset($aConfig['password']))
            throw new Exception('Ftp config password is empty!');

        if (!isset($aConfig['port']))
            $aConfig['port'] = 21;

        if (!isset($aConfig['timeout']))
            $aConfig['timeout'] = 90;

        $rConnectionId = ftp_connect($aConfig['host'], $aConfig['port'], $aConfig['timeout']);
        if ($rConnectionId) {
            $rLoginRes = ftp_login($rConnectionId, $aConfig['username'], $aConfig['password']);
            ftp_pasv($rConnectionId, $aConfig['pasv']);
        }

        if (!$rConnectionId || !$rLoginRes) {
            throw new Exception('Connection Ftp host failure!');
        }

        return $rConnectionId;
    }

    /**
     * 获取ftp 服务器上某文件夹下文件列表
     *
     * @param string $sDirectory
     *
     * @return array|bool
     */
    public function getDirFileList($sDirectory = '/.') {

        try {
            return ftp_nlist($this->connection, $sDirectory);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 下载ftp上的某文件
     *
     * @param     $sFileFrom ftp上的文件
     * @param     $sFileTo 存放到本地的文件
     * @param int $iMode 传输模式
     *
     * @return bool
     */
    public function downloadFile($sFileFrom, $sFileTo, $iMode = FTP_ASCII) {
        try {

            if (ftp_get($this->connection, $sFileTo, $sFileFrom, $iMode, 0)) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 获取ftp 服务器上某文件的大小
     *
     * @param string $sFileFrom
     *
     * @return num|bool
     */
    public function getFileSize($sFileFrom) {

        try {
            return ftp_size($this->connection, $sFileFrom);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 获取ftp 服务器上某文件的大小
     *
     * @param string $sFileFrom
     *
     * @return num|bool
     */
    public function getFileModifyTime($sFileFrom) {

        try {
            return ftp_mdtm($this->connection, $sFileFrom);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 关闭ftp连接
     */
    public function disconnect() {
        ftp_close($this->connection);
    }
}
