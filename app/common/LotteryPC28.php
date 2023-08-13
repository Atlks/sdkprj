<?php

namespace app\common;

use app\common\Lottery;
use app\common\helper;
use app\common\Logs;
use app\model\Setting;
use think\facade\App;

class LotteryPC28 extends Lottery
{

    protected $api_url = "https://api.8828355.com/api?token=f4b90db01ad0a510&t=jnd28&limit=1&p=json";
    protected $http_helper;
    protected $data = false;

    public function __construct()
    {
        $this->http_helper = new Helper();
        //$url = Setting::find(15)->s_value;
        //$this->api_url = $url;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

     // 获取最后彩期
     public function get_last_no()
    {
        try{
            $url = Setting::find(19)->s_value;
            //trace("获取开奖结果开始","info");
            $context = stream_context_create(
                array(
                    'http' => array(
                        'method' => 'GET',
                        'timeout' => 3 //超时时间，单位为秒
                    )
                )
            );
            $html = file_get_contents($url,false,$context);
            $json = json_decode($html,true);
            if ($json['data']){
                foreach($json['data'] as $r){
                    $expect = $r['issue'];
                    $time = $r['opentime'];
                    $this->data = [
                        'lottery_no' => $expect,
                        'hash_no' => $expect,
                        'opentime' => $time,
                    ];
                    return $this->data;
                }
            }
            return false;
        }catch(\Exception $e){
            echo $e->getMessage();
            return false;
        }
    }

     // 获取当前彩期
     public function get_current_no()
     {
        if(!$this->data) return false;
        try{
            $url = Setting::find(19)->s_value;
            //trace("获取开奖结果开始","info");
            $context = stream_context_create(
                array(
                    'http' => array(
                        'method' => 'GET',
                        'timeout' => 3 //超时时间，单位为秒
                    )
                )
            );
            $html = file_get_contents($url,false,$context);
            $json = json_decode($html,true);
            if ($json['data']){
                foreach($json['data'] as $r){
                    $expect = $r['issue'];
                    $time = $r['opentime'];
                    if(intval($expect) > intval($this->data['lottery_no']))
                    {
                        $this->data = [
                            'lottery_no' => $expect,
                            'hash_no' => $expect,
                            'opentime' => $time,
                        ];
                        return $this->data;
                    }
                }
            }
            return false;   
        }catch(\Exception $e){
            echo $e->getMessage();
            return false;
        }
     }
 
     // 开奖
     public function draw()
     {
        if(!$this->data) return false;
        try{
            $html = file_get_contents($this->api_url);
            $json = json_decode($html,true);
            if (isset($json['rows'])){
                foreach($json['data'] as $r){
                    $expect = preg_replace("/^(\d{8})(\d{3})$/","\\1-\\2",$r['expect']);
                    $opencode = $r['opencode'];
                    $opentime = $r['opentime'];
                    if($expect == $this->data['lottery_no'])
                    {
                        return $opencode;
                    }
                }
            }
            return false;   
        }catch(\Exception $e){
            echo $e->getMessage();
            return false;
        }
     }

     public function drawV2()
     {
        if(!$this->data) return false;
        try{
            $url = Setting::find(15)->s_value;
            //trace("获取开奖结果开始","info");
            $context = stream_context_create(
                array(
                    'http' => array(
                        'method' => 'GET',
                        'timeout' => 3 //超时时间，单位为秒
                    )
                )
            );
            $html = file_get_contents($url.$this->data['lottery_no'],false,$context);
            $json = json_decode($html,true);
            if ($json['data']){
                foreach($json['data'] as $r){
                    return $r['code'];
                }
            }
            //trace("获取开奖结果:" . $html,"info");
            return false;   
        }catch(\Exception $e){
            echo $e->getMessage();
            return false;
        }
     }

}