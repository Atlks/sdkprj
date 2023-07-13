<?php

require_once "../conn.php";

$sql =<<<EOF
select * from tisye提现表 where 1=1 order by id desc limit 200;
EOF;

$glb['sql']=$sql;
//print_r($glb);
$sth = $pdo->query($sql);
$rows = $sth->fetchAll();

echo json_encode($rows);
