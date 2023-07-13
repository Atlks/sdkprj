<?php
header('Content-Type:text/html; charset=utf-8;');
function up($key_,$order_sn,$money,$pay_type,$outer_order_sn,$pay_time,$refId,$callback){
	$url = $callback;
	$params = json_encode(array(
	   'order_sn' => $order_sn, 'sign'=>md5($order_sn.'&'.$outer_order_sn.$key_),'money' => doubleval($money),'pay_money'=>doubleval($money),'pay_type'=>$pay_type,'outer_order_sn'=>$outer_order_sn,'pay_time'=>$pay_time,'pay_sn'=>$refId),JSON_UNESCAPED_UNICODE);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($params)
	));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	$res = curl_exec($ch);
	curl_close($ch);
}

   var_dump($_POST);
   $targetSys = $_POST["targetSys"];
   $totalAmount = $_POST["totalAmount"];
   $remark = $_POST["remark"];
   $orderID = $_POST["orderID"];

   $totalAmount =str_replace("元","",$totalAmount);
   
   $host        = "host=65.49.145.72";
   $port        = "port=5432";
   $dbname      = "dbname=postgres";
   $credentials = "user=postgres password=woaitav1314";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }
   
   $sql = "UPDATE order_bill SET pay_time=now() WHERE order_id='$orderID'";
   $ret = pg_query($db, $sql);

   $sql = "select order_time,pay_time,outer_order_sn,oncall,app_id from order_bill where order_id='$orderID'";
   $ret = pg_query($db, $sql);
   $row=pg_fetch_array($ret);	
   $outer_order_sn = $row[2];
   $callback = $row[3];
   $app_id = $row[4];
   $phptime=strtotime($row[0]);
   $time_ = date("y-m-d H:i:s",$phptime);
   
   $phptime_=strtotime($row[1]);
   $pay_time = date("y-m-d H:i:s",$phptime_);
   
$sql =<<<EOF
   INSERT INTO PAY (ORDER_ID,APP_ID,CHANNEL,REMARK,AMOUNT,order_time)
   VALUES ('$orderID','$app_id', '$targetSys','$remark',$totalAmount,'$time_');
EOF;
  $ret = pg_query($db, $sql);
  if(!$ret){
   echo pg_last_error($db);
  } else {
   echo "Records created successfully\n";
  }
  
  
     $sql = "select feilv手续费率,merchan_key from merchan WHERE id=$app_id ";
	$ret = pg_query($db, $sql);
	$row=pg_fetch_array($ret);
	$bank_charge = $row[0];
	$key_ = $row[1];
	
$json_= json_decode($remark,TRUE);
$json_= json_decode($json_['extras'],TRUE);
$json_= json_decode($json_['msgApplyDetail'],TRUE);

  up($key_,$orderID,$totalAmount,$targetSys,$outer_order_sn,$pay_time ,$json_['refId'],$callback);
$sql =<<<EOF
    UPDATE merchan SET account_balance=account_balance+($totalAmount-$totalAmount*$bank_charge)
    , available_balance=available_balance+($totalAmount-$totalAmount*$bank_charge) WHERE id=$app_id;
EOF;
  $ret = pg_query($db, $sql);

  pg_close($db);
?>
