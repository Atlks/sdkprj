<?php


//签名

/**
 * @param $row
 * @param $appId
 * @param $appSecret
 * @return string
 */
function signMe($row, $appId, $appSecret)
{
    $orderNo = $row['orderNo'];
    $issue = $row['issue'];
    $lotteryCode = $row['lotteryCode'];
    $betCode = $row['betCode'];
    $bet = $row['bet'];
    $amount = $row['amount'];
    $betNum = $row['betNum'];
    $betTime = $row['betTime'];

    $sign_wait_str = "appId={$appId}&orderNo={$orderNo}&issue={$issue}&lotteryCode={$lotteryCode}&betCode={$betCode}&bet={$bet}&amount={$amount}&betNum={$betNum}&betTime={$betTime}&appSecret={$appSecret}";
    echo PHP_EOL . '$sign_wait_str:' . PHP_EOL;
    echo $sign_wait_str . PHP_EOL;
    $sign = md5(md5(md5($sign_wait_str)));
    //   $sign =  md5($sign_wait_str);
    echo 'sign:' . $sign . PHP_EOL;
    return $sign;
}


