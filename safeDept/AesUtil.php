<?php
$js="{\"bls_4human\":\"3008.000000\",\"bls\":\"+knW7qQoF\\\/xbFEioc+2KnA==\"}";
$jsob=json_decode($js);
print_r($jsob);
$mrz_JsonObj=$jsob;
$secret_key_cash = 'cashMrzKey';
$mrz_bls_decry = openssl_decrypt($mrz_JsonObj->bls, 'AES-128-ECB', $secret_key_cash, 0, "");
//echo $mrz_bls_decry;
echo "\r\n";
echo openssl_encrypt("txmm2020", 'AES-128-ECB',"txmmKey2020", 0, "");

