<?php
require_once  './vendor/autoload.php';
require_once  './phpEther/Web3/Providers/Etherscan.php';
require_once  './phpEther/Web3/Providers/HttpProvider.php';
require_once  './phpEther/Web3/Providers/Provider.php';


$cls=new  Etherscan();

$balance_wei = $cls->balance('0x298d0042310dC1dC4ea30184fb61073776eB00eD');
echo $balance_wei /(1000*1000*1000*1000*1000*1000);


//echo json_encode($cls->transactionList('0x298d0042310dC1dC4ea30184fb61073776eB00eD'));



//echo   $cls->getBlockReward(17783310) ;
$blknum=17783310;
$HexNum=dechex($blknum);
$url="https://api.etherscan.io/api?module=proxy&action=eth_getBlockByNumber&tag=0x$HexNum&boolean=true&apikey=VASRGU6XT768WSKI2VME6Z8ZK3GK5E3UDT";


$t=http_get($url);

$json=json_decode($t,true);
echo $json['result']['hash'];




function http_get($url)
{
    echo "\r\n".$url."\r\n";
    $t=file_get_contents($url) ;
    echo  "\r\n".$t."\r\n";
    return $t;
}




