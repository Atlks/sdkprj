<?php
$data="aaaaccc";
 $secret_key="abcdefgh";
//echo openssl_encrypt($data, $this->method, $this->secret_key, $this->options, $this->iv);
echo openssl_encrypt($data, 'AES-128-ECB', $secret_key,0, "");
echo "\r\n";
echo openssl_decrypt("qjuIItb9e3IuYk0hi8ZN4g==", 'AES-128-ECB', $secret_key+"a",0, "");

