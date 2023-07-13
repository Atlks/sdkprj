<?php


/**
 * PHP发送Json对象数据
 *
 * @param $url 请求url
 * @param $jsonStr 发送的json字符串
 * @return array
 */
function http_post_json($url, $jsonStr)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($jsonStr)
        )
    );
    $response_returnContent = curl_exec($ch);   //context ret
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //
    curl_close($ch);

    return array($httpCode, $response_returnContent);
}


/**
 * PHP发送Json对象数据
 *
 * @param $url 请求url
 * @param $jsonStr 发送的字符串
 * @return array
 */
function http_post_jsonV2($url, $str)
{
    echo 'start post data.' . PHP_EOL;
    echo $url . PHP_EOL;
    echo 'postdata:' . PHP_EOL;
    echo $str . PHP_EOL;
    $ch = curl_init($url);//    * @return resource|false|CurlHandle a cURL handle on success, false on errors.
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $str);


    //defalut is urlencode   ,,sevefr will use urlencode parser

    //send is json ,,let server use json parser..
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($str)
        )
    );
    /*
        //send is txt ,,let server use txt parser..
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: text/plain; charset=utf-8',
                'Content-Length: ' . strlen($str)
            )
        );
    */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//for setinto var not echo out

    // // Disabled SSL Cert checks
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//  is use ssl https.cant verif cert
    //  curl_setopt($ch,     CURLOPT_SSL_VERIFYHOST, 2);//  is use ssl https.cant verif cert

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//  is use ssl https.cant verif cert
    $response_returnContent = curl_exec($ch);   //context ret
// for Linux/Mac
    curl_setopt($ch, CURLOPT_CAINFO, '/home/petehouston/certs/cacert.pem');
    echo "response_returnContent:" . $response_returnContent . PHP_EOL;
    // die(curl_error($ch));
//    if($response_returnContent===  false)
//    {
//       die(curl_error($ch));
//    }
    $curl_getinfo = curl_getinfo($ch);
    echo PHP_EOL . 'curl_getinfo' . PHP_EOL;
    echo json_encode($curl_getinfo);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //

    curl_close($ch);
    global $glb;
    $glb['curl_getinfo'] = $curl_getinfo;
    $glb['httpCode'] = $httpCode;
    $glb['response_returnContent'] = $response_returnContent;
    return array($httpCode, $response_returnContent, $curl_getinfo);
}
