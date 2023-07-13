<?php

//  //文件注释：：本文件为调用newec api的代码
//$appId="n6Gt5uWMYfWRSWHL";
//$appSecret="TUIsepqColazaBYwCnKanAqede1A15vA";
////  https://c7c776100d07.ngrok.io/doc.html
////@ATLKS
//$url="https://7398c09d63b0.ngrok.io/v1/api/order/build";

$txt = file_get_contents('cfg_newecApi.json');
$cfgObj = json_decode($txt, true);
$url = $cfgObj['url'];
$appId = $cfgObj['appId'];
$appSecret = $cfgObj['appSecret'];

//$bet_data_obj = json_decode($row['bet_data'], true);

$bet_data_obj = $row['bet_data'];
$cyishu = $bet_data_obj['orders'];
$cyishu_str = json_encode($cyishu);

$cyishu_substr = substr($cyishu_str, 2, 10);


$post['appId'] = $appId;
$post['orderNo'] = $row['username'] . $row['created_at'];
$post['issue'] = $cyishu_substr;
$post['userId'] = $row['user_id'];
$post['bet'] = $bet_data_obj['balls'][0]['ball'];
$post['betNum'] = $row['bet_count'];
$post['betTime'] = str_replace(' ', 'T', $row['created_at']);


$post['lotteryCode'] = $row['lottery_id'];  //tsaijon id
$post['betCode'] = $bet_data_obj['gameId'];  //veshwa shwafa  id
$post['amount'] = $bet_data_obj['balls'][0]['onePrice'];

$post['ip'] = '10.137.10.1';
$_SERVER['REMOTE_ADDR'];


echo PHP_EOL;
echo json_encode($post);

$sign = signMe($post, $appId, $appSecret);

$post['sign'] = $sign;
echo PHP_EOL . 'psotdata::' . json_encode($post) . PHP_EOL;


//$url="http://localhost:888/pst";
//$url="http://localhost:888/pstxt";

echo PHP_EOL;
echo $url . PHP_EOL;
$main->info($url);
$main->info('pstdata:', ($post));
//echo    http_post_json($url, 'sendPams');
//echo json_encode($glb);
//echo PHP_EOL.'response_returnContent::'.$glb['response_returnContent'].PHP_EOL;
//die();
require "sdk/str.php";
if (startsWith($url, "https") && $cfgObj['https_poster'] === 'node') {
    $jscmd = "node httpclient_post.js " . base64_encode(json_encode($post));
    echo $jscmd . PHP_EOL;
    $returnContent = exec($jscmd);
} else
    list($returnCode_httpCode, $returnContent) = http_post_jsonV2($url, json_encode($post));

echo PHP_EOL;
//echo '$returnCode_httpCode::'.$returnCode_httpCode;echo PHP_EOL;
echo '$returnContent::' . $returnContent;








