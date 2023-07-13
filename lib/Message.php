<?php
class Message {

    /**
     * 需要加载的错误码定义文件
     * @var array
     */
    protected $errorFiles = [];
    protected $errors     = [];
    protected $errorMaps  = [];
    protected $isAjax;

    public function __construct($files = []){
        if ($this->errorFiles = $files){
            $this->loadErrors();
        }
        $this->isAjax = isset($_SERVER[ 'HTTP_X_REQUESTED_WITH' ]) && $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] == 'XMLHttpRequest';
    }

    /**
     * 根据错误号取信息字符串
     * @param int $iErrno
     * @return string
     */
    public function getResponseMsg($iErrno){
//        pr($iErrno);
        !empty($this->errors) or $this->loadErrors();
        !key_exists($iErrno,$this->errorMaps) or $iErrno = $this->errorMaps[ $iErrno ];
        return __($this->errors[ $iErrno ]);
    }

    /**
     * 初始化错误码定义
     */
    protected function loadErrors(){
        foreach ($this->errorFiles as $sFile){
            $sSet = 'errorcode/error-' . $sFile;
            $a    = Config::get($sSet);
            if (empty($this->errors)){
                $this->errors = $a;
            }
            else{
                foreach ($a as $iCode => $sKey){
                    $this->errors[ $iCode ] = $sKey;
                }
//                $this->errors = array_merge($this->errors,$a);
            }
        }
        $this->errorMaps = Config::get('errorcode/error-maps');
//        pr($this->errors);
    }

    /**
     * 组织反馈数据
     * @param bool      $bSuccess
     * @param string    $sType
     * @param int       $iErrno
     * @param array     & $aSuccessedBets
     * @param array     & $aFailedBets
     * @return array
     */
    private function & compileResponse($bSuccess,$sType,$iErrno = null,& $aSuccessedBets = null,& $aFailedBets = null,& $aData = null,$sLinkUrl = '', & $aTplData = []){
        $aResponse            = [
            'isSuccess' => intval($bSuccess),
            'type'      => $sType,
        ];
        !is_null($aTplData) or $aTplData               = [];
//        $aTplData  = [];
        if (!is_null($iErrno)){
            $aResponse[ 'Msg' ]   = $aTplData[ 'msg' ]      = $this->getResponseMsg($iErrno);
            $bSuccess or $aResponse[ 'errno' ] = abs($iErrno);
        }
        if (is_array($aFailedBets) && !empty($aFailedBets)){
            !is_array($aSuccessedBets) or $aTplData[ 'successful' ] = $aSuccessedBets;
            $aFailds                  = [];
            foreach ($aFailedBets as $aBet){
                $aBet[ 'reason' ] = $this->getResponseMsg($aBet[ 'reason' ]);
                $aFailds[]        = $aBet;
            }
            $aTplData[ 'failed' ] = & $aFailds;
        }
        !is_null($aData) or $aData               = [];
        empty($sLinkUrl) or $aTplData[ 'link' ]    = $sLinkUrl;
        empty($aTplData) or $aData[ 'tplData' ]  = & $aTplData;
        $aResponse[ 'data' ] = & $aData;
        return $aResponse;
    }

    /**
     * 根据参数输出信息，非Ajax方式待扩展
     * @param bool      $bSuccess
     * @param string    $sType
     * @param int       $iErrno
     * @param array     $aSuccessedBets
     * @param array     $aFailedBets
     * @param string $sLinkUrl
     * @param array $aTplData
     */
    public function output($bSuccess,$sType,$iErrno,& $aData,& $aSuccessedBets = null,& $aFailedBets = null, $sLinkUrl = '', & $aTplData = []){
        $aResonseData = $this->compileResponse($bSuccess,$sType,$iErrno,$aSuccessedBets,$aFailedBets,$aData,$sLinkUrl, $aTplData);
        $this->writeLog(var_export($aResonseData,true));
//        $this->isAjax = true;
        if ($this->isAjax){
            $this->writeLog(json_encode($aResonseData));
            echo json_encode($aResonseData);
        }
        else{
            pr($aResonseData);
        }
    }

    /**
     * 写日志，目前属临时用法
     * @param string $msg
     */
    private function writeLog($msg){
//        file_put_contents('/tmp/bet',$msg . "\n",FILE_APPEND);
    }

}
