<?php
namespace app\common;

class Helper 
{

    function http_request($url = '', $data = null, $header = [],  $timeout = 3)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, $header);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 
        }
        curl_setopt($curl,CURLOPT_TIMEOUT,$timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    function geturl($url){
        $headerArray =array("Content-type:application/json;","Accept:application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output,true);
        return $output;
}

    function puturl($url,$data){
        $data = json_encode($data);
        $ch = curl_init(); //初始化CURL句柄 
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"PUT"); //设置请求方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置提交的字符串
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output,true);
    }


    function swap(array &$arr, $a, $b)
    {

        $temp = $arr[$a];

        $arr[$a] = $arr[$b];

        $arr[$b] = $temp;
    }

    function BubbleSort1(array &$arr,$filed)
    {

        $length = count($arr);

        $flag = TRUE;

        for ($i = 0; ($i < $length - 1) && $flag; $i++) {

            $flag = FALSE;

            for ($j = $length - 2; $j >= $i; $j--) {

                if ($arr[$j][$filed] < $arr[$j + 1][$filed]) {

                    $this->swap($arr, $j, $j + 1);

                    $flag = TRUE;
                }
            }
        }
    }

    public static function replace_markdown($text)
    {
        $characters = "/[\_|\*|\[|\]|\(|\)|\~|\`|\>|\#|\+|\-|\=|\||\{|\}|\.|\!]+/";
        $replaced = [];
        if (preg_match_all($characters, $text, $mc)) {
            foreach ($mc[0] as $c) {
                if(!isset($replaced[$c])){
                    $reg = '/\\' . $c . '/u';
                    $text = preg_replace($reg, "\\" . $c, $text);
                    $replaced[$c] = 1;
                }
            }
        }
        return $text;
    }


    public static function replaceHashNo($hashNo, $text)
    {
        $replace_keyword = [
            "【区块号】" => $hashNo,
        ];
        foreach ($replace_keyword as $k => $v) {
            $text = preg_replace('/' . $k . '/u', $v, $text);
        }
        return $text;
    }


    public static function replaceFromUser($user,$text)
    {
        if($user)
        {
            $fullname = $user->getFirstName() ? $user->getFirstName() : "";
            $fullname = $user->getLastName() ? $fullname . $user->getLastName() : $fullname . "";
            $fullname = self::replace_markdown($fullname);
            $replace_keyword = [
                "【用户】" => $fullname,
                "【id】" =>  $user->getId(),
                "【@用户】" => '[' . $fullname . '](tg://user?id=' . $user->getId() . ')',
            ];
            foreach ($replace_keyword as $k => $v) {
                $text = preg_replace('/' . $k . '/u', $v, $text);
            }
            return $text;
        }
    }


    public static function replaceFromChat( $chat, $text)
    {
        $replace_keyword = [
            "【群名】" => $chat->getTitle(),
        ];
        foreach ($replace_keyword as $k => $v) {
            $text = preg_replace('/' . $k . '/u', $v, $text);
        }
        return $text;
    }

    public static function replace($text)
    {
        $replace_keyword = [
            "【换行】" => "\r\n",
        ];
        foreach ($replace_keyword as $k => $v) {
            $text = preg_replace('/' . $k . '/u', $v, $text);
        }
        return $text;
    }
}