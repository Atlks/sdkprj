<?php
@date_default_timezone_set("PRC");
$order_date = date('Y-m-d'); 
//订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
$order_id_main = date('YmdHis') . rand(10000000,99999999); 
//订单号码主体长度
$order_id_len = strlen($order_id_main);
$order_id_sum = 0; 
for($i=0; $i<$order_id_len; $i++){    
    $order_id_sum += (int)(substr($order_id_main,$i,1));
}

$order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);


require_once "../conn_pg.php";
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
    //  echo "Opened database successfully\n";
   }
$amount = $_GET["amount"];
$oncall = $_GET["oncall"];
$outer_order_sn = $_GET["outer_order_sn"];
$appid = $_GET["appid"];
$sql =<<<EOF
   INSERT INTO ORDER_BILL (ORDER_ID,APP_ID,AMOUNT,CHANNEL,oncall,outer_order_sn)
   VALUES ('$order_id',$appid,$amount,'商家固码','$oncall','$outer_order_sn');
EOF;

$ret = pg_query($db, $sql);
if(!$ret){
echo pg_last_error($db);
} else {
//echo "Records created successfully\n";
}
pg_close($db);

$arr = array('order_id' => $order_id, 'status' => 'ok');
echo json_encode($arr);
?>
