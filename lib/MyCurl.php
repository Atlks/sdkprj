<?php

/**
 * CURL CLASS
 * 
 * @todo auto mkdir
 * @version 1.1
 * @author Frank
 * 
 * @version 1.0 
 * @author Sun 
 * 
 */
class MyCurl {

    public $authentication = 0;
    public $auth_name = '';
    public $auth_pass = '';
    protected $_useragent = 'Mozilla/5.0 (Windows NT 6.1; rv:19.0)';
    protected $_url;
    protected $_followlocation;
    protected $_timeout;
    protected $_maxRedirects;
    protected $_cookieFileLocation = './cookie.txt';
    protected $_post;
    protected $_postFields;
    protected $_referer = ""; //"http://www.google.com";
    protected $_session;
    protected $_webpage;
    protected $_includeHeader;
    protected $_noBody;
    protected $_status;
    protected $_binary;
    protected $_binaryTransfer;
    protected $_oCurl;
    protected $_logPath;

    public function useAuth($use) {
        $this->authentication = 0;
        if ($use == true)
            $this->authentication = 1;
    }

    public function setName($name) {
        $this->auth_name = $name;
    }

    public function setPass($pass) {
        $this->auth_pass = $pass;
    }

    public function __construct($url, $sourceId = 0, $followlocation = true, $timeOut = 15, $maxRedirecs = 4, $binaryTransfer = false, $includeHeader = false, $noBody = false) {
        $this->_url = $url;
        $this->_followlocation = $followlocation;
        $this->_timeout = $timeOut;
        $this->_maxRedirects = $maxRedirecs;
        $this->_noBody = $noBody;
        $this->_includeHeader = $includeHeader;
        $this->_binaryTransfer = $binaryTransfer;
        $this->_logPath = Config::get('myurl.cookie');
        if (!file_exists($this->_logPath)) {
            MyFolder::createDir($this->_logPath, 0777);
        }
        $this->_cookieFileLocation = $this->_logPath . DIRECTORY_SEPARATOR . "cookie_{$sourceId}.txt";
    }

    public function setReferer($referer) {
        $this->_referer = $referer;
    }

    public function setCookiFileLocation($path) {
        $this->_cookieFileLocation = $path;
    }

    public function setPost($postFields) {
        $this->_post = true;
        $this->_postFields = $postFields;
    }

    public function setUserAgent($userAgent) {
        $this->_useragent = $userAgent;
    }

    public function createCurl($url = '', $aHeader = array(), $compression = 'gzip') {
        empty($url) OR $this->_url = $url;
        $this->_oCurl = curl_init();

//        $aHeader = array();
//        $aHeader[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
//        $aHeader[] = 'Connection: Keep-Alive';
//        $aHeader[] = 'Content-type: application/x-www-form-urlencoded';
//       $header[] = 'Etag: 2b68553-8048b-4e3f772a9cac0';
//       $header[] = 'If-None-Match: 2b68553-8048b-4e3f772a9cac0';
//       $header[] = 'If-Modified-Since: Thu, 15 Aug 2013 07:30:27 GMT';
        curl_setopt($this->_oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->_oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($this->_oCurl, CURLOPT_URL, $this->_url);
        curl_setopt($this->_oCurl, CURLOPT_HTTPHEADER, $aHeader);
        curl_setopt($this->_oCurl, CURLOPT_TIMEOUT, $this->_timeout);
        curl_setopt($this->_oCurl, CURLOPT_MAXREDIRS, $this->_maxRedirects);
        curl_setopt($this->_oCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_oCurl, CURLOPT_FOLLOWLOCATION, $this->_followlocation);
        curl_setopt($this->_oCurl, CURLOPT_COOKIEJAR, $this->_cookieFileLocation);
        curl_setopt($this->_oCurl, CURLOPT_COOKIEFILE, $this->_cookieFileLocation);
        curl_setopt($this->_oCurl, CURLOPT_ENCODING, $compression);

        if ($this->authentication == 1) {
            curl_setopt($this->_oCurl, CURLOPT_USERPWD, $this->auth_name . ':' . $this->auth_pass);
        }
        if ($this->_post) {
            curl_setopt($this->_oCurl, CURLOPT_POST, true);
            curl_setopt($this->_oCurl, CURLOPT_POSTFIELDS, $this->_postFields);
        }

        if ($this->_includeHeader) {
            curl_setopt($this->_oCurl, CURLOPT_HEADER, true);
        }

        if ($this->_noBody) {
            curl_setopt($this->_oCurl, CURLOPT_NOBODY, true);
        }

        if ($this->_binary) {
            curl_setopt($this->_oCurl, CURLOPT_BINARYTRANSFER, true);
        }

        curl_setopt($this->_oCurl, CURLOPT_USERAGENT, $this->_useragent);

        if (!empty($this->_referer)) {
            curl_setopt($this->_oCurl, CURLOPT_REFERER, $this->_referer);
        }
    }

    function multiCurl($aDatas) {

        if (count($aDatas) <= 0)
            return FALSE;
        $handles = array();

//        if(empty($aDatas["OPTIONS"])) // add default options
//            $aDatas["OPTIONS"] = array(
//                CURLOPT_HEADER=>0,
//                CURLOPT_RETURNTRANSFER=>1,
//            );
        // add curl options to each handle
        foreach ($aDatas as $k => $row) {
            $ch{$k} = curl_init();
            curl_setopt_array($ch{$k}, $row);
            $handles[$k] = $ch{$k};
        }

        $mh = curl_multi_init();

        foreach ($handles as $k => $handle) {
            curl_multi_add_handle($mh, $handle);
            //echo "<br>adding handle {$k}";
        }

        $running_handles = null;
        //execute the handles
        do {
            $status_cme = curl_multi_exec($mh, $running_handles);
        } while ($status_cme == CURLM_CALL_MULTI_PERFORM);


        $this->_full_curl_multi_exec($mh, $still_running); // start requests
        do { // "wait for completion"-loop
            curl_multi_select($mh); // non-busy (!) wait for state change
            $this->_full_curl_multi_exec($mh, $still_running); // get new state
            while ($info = curl_multi_info_read($mh)) {
                // process completed request (e.g. curl_multi_getcontent($info['handle']))
            }
        } while ($still_running);
        curl_multi_close($mh);
        return TRUE;
//        foreach($res as $k=>$row){
//            $res[$k]['error'] = curl_error($handles[$k]);
//            if(!empty($res[$k]['error']))
//                $res[$k]['data']  = '';
//            else
//                $res[$k]['data']  = curl_multi_getcontent( $handles[$k] );  // get results
//
//            // close current handler
//            curl_multi_remove_handle($mh, $handles[$k] );
//        }
//        curl_multi_close($mh);
//        return $res; // return response
    }

    private function _full_curl_multi_exec($mh, &$still_running) {
        do {
            $rv = curl_multi_exec($mh, $still_running);
        } while ($rv == CURLM_CALL_MULTI_PERFORM);
        return $rv;
    }

    public function execute() {
        if (!empty($this->_oCurl)) {
            $this->_webpage = curl_exec($this->_oCurl);
            $this->_status = curl_getinfo($this->_oCurl, CURLINFO_HTTP_CODE);
            curl_close($this->_oCurl);
        }
    }

    public function getCurlInstance() {
        return $this->_oCurl;
    }

    public function getHttpStatus() {
        return $this->_status;
    }

    public function __tostring() {
        return $this->_webpage;
    }

    public function setTimeout($iTimeOut) {
        $this->_timeout = $iTimeOut;
    }
}