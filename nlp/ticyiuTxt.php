<?php
$f = "\ppl";
$con = file($f);
$data = array();
foreach ($con as $line) {
    $posStart = stripos($line, "——");
    if ($posStart) {
        // $line = trim($line);
        $name = substr($line, $posStart);
        echo $name;
    } else {

        echo $line;
    }

}
