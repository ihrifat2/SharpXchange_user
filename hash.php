<?php 

function encryptTransID($string) {
    $randomNumber   = rand(10,99);
    $encoded        = base64_encode($string);
    $modencd        = substr($encoded, 0, -2);
    $hash           = "TransID" . $modencd . $randomNumber;
    return $hash;
}

function decrypt($value){
    $value = $value . "==";
    $key = "ImranNurRobin-1337";
    $c = base64_decode($value);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    if (hash_equals($hmac, $calcmac))//PHP 5.6+ timing attack safe comparison
    {
        return $original_plaintext."\n";
    }
}

function encode($data){
    $randomNumber = rand(10,99);
    $string     = $randomNumber . $data;
    $ciphertext = base64_encode($string);
    $ciphertext = str_replace("=","",$ciphertext);
    $ciphertext = $ciphertext .$randomNumber;
    return $ciphertext;
}

function decode($data){
    $ciphertext = substr($data, 0, -2);
    // $ciphertext = $data;
    $ciphertext = $ciphertext . "==";
    $ciphertext = base64_decode($ciphertext);
    $ciphertext = substr($ciphertext, 2); 
    return $ciphertext;
}

?>