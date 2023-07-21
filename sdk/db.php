
<?php


function pdo_exec($sql, $pdo_conn_str )
{
    global $pdo;
    $pdo = new PDO($pdo_conn_str[0],  $pdo_conn_str[1],$pdo_conn_str[2] );
    echo "852\r\n";
    var_dump_local($pdo);
    echo "853\r\n";
    global $main;
    var_dump_local( PHP_EOL . $sql . PHP_EOL );
    //  $main->info($sql);
    global $glb;
    $glb['sql'] = $sql;
    var_dump_local($glb);
    global $pdo; //use global var
     $r=$pdo->exec($sql);
    var_dump_local($r);
   return    $r;




    // return array($pdo, $rows);
}


function fetchAll_queryRows_pdo($sql, $pdo_conn_str)
{
    var_dump_local( PHP_EOL ."---402". PHP_EOL );
    var_dump_local(  $pdo_conn_str );
    $pdo = new PDO($pdo_conn_str[0],  $pdo_conn_str[1],$pdo_conn_str[2] );
    var_dump_local( PHP_EOL ."---403". PHP_EOL );
    var_dump_local( $pdo  );
    var_dump_local( PHP_EOL . "---404" . PHP_EOL );

    global $main;
    var_dump_local( PHP_EOL . $sql . PHP_EOL );
    //  $main->info($sql);
    global $glb;
    $glb['sql'] = $sql;
    var_dump_local($glb);
 
    $stmt = $pdo->query($sql);
    var_dump_local( PHP_EOL . "---405" . PHP_EOL );
    var_dump_local(  $stmt );
    var_dump_local( PHP_EOL . "---406" . PHP_EOL );
  //  $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    var_dump_local( 'qury cnt:' . $stmt->rowCount() . PHP_EOL );
    return $rows;
    // return array($pdo, $rows);
}




 
  