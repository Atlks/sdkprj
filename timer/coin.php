<?php


 $btcPrs=30000;
 $gldPrsPergram=63.43;  //x720   2023.7
 $weit= $btcPrs/ $gldPrsPergram;    //473g
echo "weight:". $weit."\r\n";
$midy=19.3;   // cm3

$siee_cm3= $weit/$midy;
echo "tiji:". $siee_cm3." cm3\r\n";

$size_mm3=$siee_cm3*1000;

 $heit=1.7;  // mm

//$size_mm3===(pai*r*r* $heit)*;

$r=   sqrt($size_mm3/ $heit/3.1415926) ;

echo 'rds:'.$r."mm\r\n";
echo  'calc weit:'. $r*$r*3.1415* $heit/1000*$midy;

