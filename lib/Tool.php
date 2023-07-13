<?php

/**
 * 工具类，整合一些函数
 *
 * @author winter
 */
class Tool {

    /**
     * 生成随机码
     * 
     * @return String 随机码
     */
    public static function createRandomStr()
    {
        $sRandomStr = static::randomStr(6);
        $sKey = Hash::make($sRandomStr);
        Session::put($sKey, $sRandomStr);
        return $sKey . '_' . $sRandomStr;
    }

    /**
     *  生成指定长度的随机字符串(包含大写英文字母, 小写英文字母, 数字)
     *
     * @author Wu Junwei <www.wujunwei.net>
     *
     * @param int $length 需要生成的字符串的长度
     * @return string 包含 大小写英文字母 和 数字 的随机字符串
     */
    public static function randomStr($length)
    {
        //生成一个包含 大写英文字母, 小写英文字母, 数字 的数组
        $arr = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));

        $str = '';
        $arr_len = count($arr);
        for ($i = 0; $i < $length; $i++)
        {
            $rand = mt_rand(0, $arr_len-1);
            $str.=$arr[$rand];
        }

        return $str;
    }

    public static function getClientIp(){
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']))
        {
          return $_SERVER['HTTP_CLIENT_IP'];
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
          return strtok($_SERVER['HTTP_X_FORWARDED_FOR'], ',');
        }
        if (isset($_SERVER['HTTP_PROXY_USER']) && !empty($_SERVER['HTTP_PROXY_USER']))
        {
          return $_SERVER['HTTP_PROXY_USER'];
        }
        if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']))
        {
          return $_SERVER['REMOTE_ADDR'];
        }
        else
        {
          return "0.0.0.0";
        }
    }
    
    public static function getProxyIp(){
        return $_SERVER['REMOTE_ADDR'];
    }

}
