<?php
header('Content-Type:text/html; charset=utf-8;');
require('../vendor/autoload.php');
use WebSocket\Client;
$data = file_get_contents('php://input');
$jsonArr= json_decode($data,TRUE);
$id = $jsonArr['channel_code'];	
$money = $jsonArr['money'];	
$callback = $jsonArr['callback'];	
$outer_order_sn = $jsonArr['outer_order_sn'];	
$merchant_sn = $jsonArr['merchant_sn'];	
$sign = $jsonArr['sign'];
// 检查参数
if($id == null || $money == null || $merchant_sn == null){
	$arr = array('code' => -1, 'pay_money' => 0, 'pay_url' => '','order_sn'=>'','actionErrors'=>'参数错误');
	echo json_encode($arr, JSON_UNESCAPED_UNICODE);
	return;
}

require_once "../conn_pg.php";

if($id == null){
        $arr = array('code' => -1,'actionErrors'=>'数据库连接失败');
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        return;

}

$sql = "select merchan_key from merchan where id=$merchant_sn";
$ret = pg_query($db, $sql);
if(pg_num_rows($ret) == 0){
        $arr = array('code' => -1,'actionErrors'=>'商户不存在');
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        return;
}

$row = pg_fetch_array($ret);
$key_= $row[0];
$sig= strtoupper(md5($merchant_sn.'&'.$outer_order_sn.'&'.$key_));


$e =  strncmp($sig,$sign,32);

if($e != 0){
 
$arr = array('code' => -1,'actionErrors'=>'商户签名错误');
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        return;

}
$client = new Client("ws://65.49.145.72:8081/",array('timeout' => 30));
$arr1 = array('MerchantID' => $merchant_sn, 'ChannelID' => 1, 'CMD' => "GETORCODE",'amount'=> (string)$money,'callback'=> (string)$callback,'outer_order_sn'=> (string)$outer_order_sn);
$client->send(json_encode($arr1));
$r = $client->receive();
$json_= json_decode($r,TRUE);

$arr = array('code' => 0, 'pay_money' => $money, 'pay_url' => $json_['url'],'order_sn'=>$json_['order_id'],'actionErrors'=>'');
echo json_encode($arr);
?>
