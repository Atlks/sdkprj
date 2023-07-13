<?php
header('Content-Type:text/html; charset=utf-8;');
$data = file_get_contents('php://input');

$jsonArr= json_decode($data,TRUE);
$id = $jsonArr['order_sn'];


require_once "../conn_pg.php";
if($id == null){
	$arr = array('code' => -1,'payed' => 'N','actionErrors'=>'参数错误');
	echo json_encode($arr, JSON_UNESCAPED_UNICODE);
	return;
	
}
if(!$db){
	$arr = array('code' => -1,'payed' => 'N','actionErrors'=>'数据库连接错误');
	echo json_encode($arr, JSON_UNESCAPED_UNICODE);
	return;
}
$sql = "select AMOUNT,pay_time,outer_order_sn from order_bill where order_id='$id'";
$ret = pg_query($db, $sql);
if(pg_num_rows($ret) == 0){
	$arr = array('code' => -1,'payed' => 'N','actionErrors'=>'该订单查询不存在');
	echo json_encode($arr, JSON_UNESCAPED_UNICODE);
	return;
}
$row = pg_fetch_array($ret);
if($row[1] == null){
	$arr = array('code' => -1,'payed' => 'N','actionErrors'=>'该订单未支付');
	echo json_encode($arr, JSON_UNESCAPED_UNICODE);
	return;
}
$sql = "select channel,remark from pay where order_id='$id'";
$ret = pg_query($db, $sql);
$roww = pg_fetch_array($ret);
$json_= json_decode($roww[1],TRUE);
$json_= json_decode($json_['extras'],TRUE);
$json_= json_decode($json_['msgApplyDetail'],TRUE);
$arr = array('pay_type'=>$roww[0], 'pay_sn' =>$json_['refId'],'code' => 0,'payed' => 'Y','money'=> $row[0],'pay_money'=> $row[0],'pay_time' => $row[1],'outer_order_sn'=>$row[2],'actionErrors'=>'');
echo json_encode($arr, JSON_UNESCAPED_UNICODE);
?>
