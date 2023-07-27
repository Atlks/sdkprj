<?php
$txt=strip_tags(file_get_contents('https://etherscan.io/block/17783310'))  ;
echo $txt;


function odd($var)
{

    $var=trim( $var) ;
    if(empty($var))
        return false;
    return true;
    //  return  trim() ;
}

$arr = explode("\n",$txt);
//$arr = array_filter($arr,"odd");    //去除数组中的空元素
$arr = array_filter($arr);

file_put_contents("6422.json",json_encode($arr ));
$line=array_search(" Parent Hash:",$arr);;
echo $line;  //line idx

function array_findByIdx($arr,$idx)
{
    foreach ($arr as $key => $value){
        echo $key."\r\n";
        if($idx==$key)
            return $value;
    }
}

echo     array_findByIdx($arr,$line-1);
//array_values($arr)[ $line-1];
