<?php
   $orderID = '201911221545407743806721';

   
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
	
	
	$sql = "select order_time from order_bill where order_id='201911221545407743806721'";
	$ret = pg_query($db, $sql);
	$row=pg_fetch_array($ret);
	//echo $row[0];
	$phptime=strtotime($row[0]);
	echo date("m-d H:i",$phptime);
	echo $phptime;
  pg_close($db);
?>
