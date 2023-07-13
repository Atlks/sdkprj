<?php
$appId = "n6Gt5uWMYfWRSWHL";
$appSecret = "TUIsepqColazaBYwCnKanAqede1A15vA";
//  https://c7c776100d07.ngrok.io/doc.html
//@ATLKS
$url = "https://0b523cb9a87d.ngrok.io/v1/api/order/build";
$url = 'https://7398c09d63b0.ngrok.io/v1/api/order/build';

$row['bet_data'] = $bet_data;
$row['appId'] = 'appid111';
$row['orderNo'] = $row['username'] . $row['created_at'];
$row['issue'] = 'issuexxx';
$row['userId'] = $row['user_id'];
$row['bet'] = $row['bet_data'];
$row['betNum'] = $row['bet_count'];
$row['betTime'] = $row['created_at'];

echo PHP_EOL;
echo json_encode($row);

$sign = signMe($row, $appId, $appSecret);

$row['sign'] = $sign;
echo PHP_EOL . 'psotdata::' . json_encode($row) . PHP_EOL;


//$url="http://localhost:888/pst";
//$url="http://localhost:888/pstxt";

echo PHP_EOL;
echo $url . PHP_EOL;
//echo    http_post_json($url, 'sendPams');
//echo json_encode($glb);
//echo PHP_EOL.'response_returnContent::'.$glb['response_returnContent'].PHP_EOL;
//die();
list($returnCode_httpCode, $returnContent) = http_post_json($url, '{}');
echo PHP_EOL;
echo '$returnCode_httpCode::' . $returnCode_httpCode;
echo PHP_EOL;
echo '$returnContent::' . $returnContent;


/**
 * @param $row
 * @param $appId
 * @param $appSecret
 * @return string
 */
function signMe($row, $appId, $appSecret)
{
    $orderNo = 'aa';
    $issue = $row['issue'];
    $lotteryCode = '';
    $betCode = '';
    $bet = $row['bet'];
    $amount = 1;
    $betNum = $row['betNum'];
    $betTime = $row['betTime'];

    $sign_wait_str = "appId={$appId}&orderNo={$orderNo}&issue={$issue}&lotteryCode={$lotteryCode} &betCode={$betCode}&bet={$bet}&amount={$amount}&betNum={$betNum}&betTime={$betTime} &appSecret={$appSecret}";

    $sign = md5(md5(md5($sign_wait_str)));
    return $sign;
}


/**
 * PHP发送Json对象数据
 *
 * @param $url 请求url
 * @param $jsonStr 发送的字符串
 * @return array
 */
function http_post_json($url, $str)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//for setinto var not echo out


    //defalut is urlencode   ,,sevefr will use urlencode parser

    //send is json ,,let server use json parser..
    /*  */
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


    $response_returnContent = curl_exec($ch);   //context ret
    $curl_getinfo = curl_getinfo($ch);
    echo 'curl_getinfo' . PHP_EOL;
    echo json_encode($curl_getinfo);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //

    curl_close($ch);
    global $glb;
    $glb['curl_getinfo'] = $curl_getinfo;
    $glb['httpCode'] = $httpCode;
    $glb['response_returnContent'] = $response_returnContent;
    return array($httpCode, $response_returnContent, $curl_getinfo);
}