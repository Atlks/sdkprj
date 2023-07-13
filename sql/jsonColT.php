<?php


require_once "../conn.php";

$sql_query_bls = "select * from merchan where uname ='mer'";
print_r($sql);
$rs_one_mer = ($pdo->query($sql_query_bls)->fetch());
echo (gettype($rs_one_mer['mrz']));
echo    $rs_one_mer['mrz'];
echo json_decode($rs_one_mer['mrz']) ->bls;
 

