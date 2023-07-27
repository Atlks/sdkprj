<?php
require_once  './vendor/autoload.php';
require_once  './phpEther/Web3/Providers/Etherscan.php';
require_once  './phpEther/Web3/Providers/HttpProvider.php';
require_once  './phpEther/Web3/Providers/Provider.php';


$cls=new  Etherscan();

$balance_wei = $cls->balance('0x298d0042310dC1dC4ea30184fb61073776eB00eD');
echo $balance_wei /(1000*1000*1000*1000*1000*1000);




