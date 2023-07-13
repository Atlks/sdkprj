<?php
/**
 * 接口公用父类.
 * User: damon
 * Date: 1/24/16
 * Time: 6:56 PM
 */

class BaseService{

    //商户编号
    private $_identity;
    //api key
    private $_sApiKey;
    //接口地址列表
    protected $_aApiServer;
    //执行超时时间
    private $_iTimeOut;
    //是否记录日志
    protected $writeTxtLog;
    //日志文件
    protected $logFile;
    //返回结果记录文件
    protected $writeResult = true;

    protected $protocolType = 'http';

    public function __construct($aConfig) {
        $this->setLogFile();
        $this->_iTimeOut   = 60;
        $this->_sApiKey = $aConfig['api_key'];
        $this->_aApiServer = $aConfig['api_server'];
        $this->_identity = $aConfig['identity'];
    }

    /**
     * 执行API调用
     *
     * @param string server, 采用哪个_aApiServer
     * @param string func, 执行哪个_aApiServer函数
     * @param array gets, 需要GET传输的参数
     * @param array posts, 需要POST传输的参数
     */
    protected function _doApi($server='', $func='', $gets=array(), $posts=array()) {
        $ret = array(
            'code'  => 0,
            'msg'   => '还没调用到接口',
            'data'  => array(),
        );

        if (empty($server)) {
            $ret['msg'] = 'server不能为空';
            return $ret;
        }

        // 判断API SERVER存不存在
        if ((!isset($this->_aApiServer[$server])) || empty($this->_aApiServer[$server])) {
            $ret['msg'] = $server.'对应的服务器在Config.service的_aApiServer里未定义或者为空';
            return $ret;
        }

        /// 到这里，表示可以调用API了
        $start_time=microtime(true);
        if(!empty($posts)){
            $posts['identity'] = $this->_identity;
        }else{
            $gets['identity'] = $this->_identity;
        }
        //设置get参数
        $urlRet = $this->_makeGets($server, $func, $gets);
        if($urlRet['code']!=1){
            return $urlRet;
        }
        $url = $this->protocolType.'://'.$urlRet['data']['url'];
        //设置post参数
        $postDataRet = $this->_makePosts($posts);
        if($postDataRet['code'] != 1){
            return $postDataRet;
        }
        $postData = $postDataRet['data'];
        //接口调用
        $ret = $this->execCurl($url, $postData);
        //校验返回数据签名
        if($ret['code'] == 1 && isset($ret['sign']) && isset($ret['data'])){
            $checkData = ['coding' => $ret['code'],'data' => $ret['data'],'msg' => $ret['msg']];
            $checkResult = $this->_checkSign($checkData,$ret['sign']);
            if(!$checkResult){
                $ret = $this->makeResult(-999,'check return data sign error',[]);
            }
        }
        $end_time=microtime(true);
        //执行时间
        $_iActSpendTime=round($end_time-$start_time,3);
        //记录日志
        $message=$server."|".$func."|".json_encode($ret)."|".$_iActSpendTime."|".json_encode($gets)."|".json_encode($posts);
        $this->writeLog($message,true);
        //正确返回时记录文件
        if($ret['code'] == 1 && isset($ret['data']) && $this->writeResult){
            //存储记录文件
            $this->saveResultAsFile($server,$func,json_encode($ret['data']));
        }
        return $ret;
    }

    /**
     * 获取Sign
     *
     * @param $aParams array 参数
     * @return array
     */
    private function _getSign($aParams){
        ksort($aParams);
        //拼接参数和密钥
        $sign = md5(http_build_query($aParams) . $this->_sApiKey);

        return $this->makeResult(1,'',['sign' =>$sign]);
    }

    private function _checkSign($aParams,$sign){
        $localSign = $this->_getSign($aParams);
        $localSign = $localSign['data']['sign'];
        if($localSign == $sign){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 拼装get参数和Sign
     *
     * @param $server string 接口
     * @param $func string 函数
     * @param $gets array 参数
     * @return string
     */
    private function _makeGets($server, $func, $gets) {
        //拼接server和function地址
        $url = $this->_aApiServer[$server].DS.$func;

        if (!is_array($gets) || empty($gets)){
            return $this->makeResult(1,'',['url' => $url]);
        }
        $_signRet = $this->_getSign($gets);
        if($_signRet['code'] != 1){
            return $_signRet;
        }
        $_sign = $_signRet['data']['sign'];
        $url .= '?'.http_build_query($gets);
        $url .= "&sign=".$_sign;
        return $this->makeResult(1,'',['url' => $url]);
    }

    /**
     * 拼装参数和Sign,get和post应该只有一个传递参数
     * @param $posts array 参数
     * @return array
     */
    private function _makePosts($posts) {
        $data = '';
        if (!is_array($posts) || empty($posts)){
            return $this->makeResult(1);
        }

        $_signRet = $this->_getSign($posts);
        if($_signRet['code'] != 1){
            return $_signRet;
        }
        $_sign = $_signRet['data']['sign'];
        $data .= http_build_query($posts)."&sign=".$_sign;
        return $this->makeResult(1,'',$data);
    }

    /**
     * 执行curl查询
     *
     * @param $url string 参数
     * @param string $postData post数据
     * @return array|mixed
     */
    private function execCurl($url, $postData='') {
        $tmp_time   = microtime(true);

        $userAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)";

        $ch = curl_init($url);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); /// 链接timeout 1秒
        curl_setopt ($ch, CURLOPT_TIMEOUT, $this->_iTimeOut); /// 执行timeout 3秒
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt ($ch, CURLOPT_REFERER, $url);

        // 允许重定向
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        // 支持HTTPS(SSL)
        if ($this->protocolType == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  false);
        }

        // 是否启用POST提交
        if (!empty($postData)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }

        $ret    = curl_exec($ch);
        $header = curl_getinfo($ch);
        $http_code = isset($header['http_code']) ? $header['http_code'] : 200;

        $error = '';
        if ($http_code != 200) {
            $error = curl_error($ch);
            !$this->writeTxtLog or $this->writeLog('httpcode:'.$http_code.', error:'.$error);
        }

        curl_close ($ch);

        $tmp_time = microtime(true) - $tmp_time;

        // 增加API的简单调试功能
        if (Config::get('app.debug') == 1) {
            if (function_exists('dump')) {
                dump($url);
                dump('HTTPCODE: '.$http_code);
                dump('EXEC TIME: '.$tmp_time.' seconds');
                if ($error) dump('ERROR: '.$error);
                dump($ret);
            }
            else {
                echo $url."<br />\n";
                echo 'HTTPCODE='.$http_code."<br />\n";
                echo 'EXEC TIME: '.$tmp_time." seconds<br />\n";
                if ($error) echo 'ERROR: '.$error."<br />\n";
                print_r($ret);
            }
        }
        // 备份RET，用于错误日志记录
        $ret_bak = $ret;
        if (empty($ret) || ($http_code == 201)) {
            $this->writeLog("返回值为空，或者http_code201:$url".$ret_bak);
            return array('code'=>-1,'msg'=>'服务繁忙');
        }
        $ret = json_decode($ret, true);
        /// 如果不是数组，表示API返回出错啦
        if (!is_array($ret)) {
            $ret = array('code'=>-100, 'msg'=>"API返回的信息json_decode结果不是数组=>$ret_bak",'data'=>['url'=>$url,'post'=>$postData]);
            $this->writeLog("api接口返回值不是数组:$url:".$ret_bak);
            //api_log('接口返回值不是数组:'.substr($ret_bak, 0, 50));
            return $ret;
        }
        // 如果执行时间大于1秒，记录DNS
        if ($tmp_time > 1.0) {
            $header_str = 'total_time:'.$header['total_time'].',namelookup_time:'.$header['namelookup_time'].',connect_time:'.$header['connect_time'].',pretransfter_time:'.$header['pretransfer_time'];
            $this->writeLog($header_str);
        }
        if ($tmp_time > 0.5) {
            $header_str = 'total_time:'.$header['total_time'].',namelookup_time:'.strval($header['namelookup_time']).',connect_time:'.strval($header['connect_time']).',pretransfter_time:'.strval($header['pretransfer_time']);
            $this->writeLog($header_str);
        }

        $code = isset($ret["coding"]) ? $ret["coding"] : 0;
        /// 记录返回值的code
        $this->writeLog('coding:'.$code);
        if ($code != 1) {
            $this->writeLog('msg:'.$ret["msg"].',postdata:'.json_encode($postData));
        }
        $ret['code'] = $code;
        unset($ret['coding']);
        return $ret;
    }

    /**
     * 用于client api返回结果数据
     *
     * @param $code
     * @param $msg
     * @param $data
     */
    public function makeResult($code, $msg='', $data=array()) {
        $ret = array (
            'code' => $code,
            'msg'  => $msg,
            'data' => $data
        );
        return $ret;
    }

    /**
     * 设置日志目录
     */
    protected function setLogFile(){
        if ($this->writeTxtLog = SysConfig::check('service_write_log', true)) {
            $logPath = storage_path() . '/logs' . DS . 'api' . DS . date('Ym/d');
            if (!file_exists($logPath)) {
                @mkdir($logPath, 0777, true);
                @chmod($logPath, 0777);
            }
//            $this->setLogFileName();
            if($this->logFile){
                $this->logFile = $logPath . DS . $this->logFile;
            }else{
                $this->logFile = $logPath . DS . get_called_class();
            }
        }
    }

    /**
     * 写文件日志
     * @param string 日志内容
     * @param boolean 是否追加空行
     * @return boolean 写日志成功或者失败
     */
    protected function writeLog($sString, $bAppendSpaceLine = false) {
        if (!$this->writeTxtLog)
            return true;
        $sString = date('Y-m-d H:i:s') . ', ' . 'pid=' . posix_getpid() . ': ' . $sString . "\n";
        !$bAppendSpaceLine or $sString .= "\n";
        return file_put_contents($this->logFile, $sString, FILE_APPEND);
    }

    /**
     * 记录接口返回内容
     * @param $sContent
     */
    private function saveResultAsFile($service,$func,$sContent){
        $logPath = storage_path() . '/api-data' . DS . date('Ym/d') ;
        if (!file_exists($logPath)) {
            @mkdir($logPath, 0777, true);
            @chmod($logPath, 0777);
        }
        $time = date('His');
        $logFile = $logPath . DS . "{$service}-{$func}-{$time}.json" ;
        file_put_contents($logFile, $sContent, FILE_APPEND);
    }

}