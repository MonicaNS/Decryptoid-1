<?php

class RC4 {

//     //use this function to encrypt and decrypt
//     function rc4Cipher($key, $plainText) {
//         $s = array();
//         //Initialize array of 256 bytes
//         for ($i = 0; $i < 256; $i++) {
//             $s[$i] = $i;
//         }

//         //Secret key array
//         $t = array();
//         for ($i = 0; $i < 256; $i++) {
//             $t[$i] = ord($key[$i % strlen($key)]);
//         }

//         $j = 0;
//         for ($i = 0; $i < 256; $i++) {
//             $j = ($j + $s[$i] + $t[$i]) % 256;
//             //Swap value of s[i] and s[j]
//             $temp = $s[$i];
//             $s[$i] = $s[$j];
//             $s[$j] = $temp;
//         }

//         //Generate key stream
//         $i = 0;
//         $j = 0;
//         $cipherText = '';
//         for ($y = 0; $y < strlen($plainText); $y++) {
//             $i = ($i + 1) % 256;
//             $j = ($j + $s[$i]) % 256;
//             $x = $s[$i];
//             $s[$i] = $s[$j];
//             $s[$j] = $x;
//             $cipherText .= $plainText[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
//         }
//         return $cipherText;
//     }

// }

function mb_chr($char) {
    return mb_convert_encoding('&#'.intval($char).';', 'UTF-8', 'HTML-ENTITIES');
    }
    
    function mb_ord($char) {
    $result = unpack('N', mb_convert_encoding($char, 'UCS-4BE', 'UTF-8'));
    
    if (is_array($result) === true) {
    return $result[1];
    }
    return ord($char);
    }
    
    function rc4Cipher($key, $str) {
    if (extension_loaded('mbstring') === true) {
    mb_language('Neutral');
    mb_internal_encoding('UTF-8');
    mb_detect_order(array('UTF-8', 'ISO-8859-15', 'ISO-8859-1', 'ASCII'));
    }
    
    $s = array();
    for ($i = 0; $i < 256; $i++) {
    $s[$i] = $i;
    }
    $j = 0;
    for ($i = 0; $i < 256; $i++) {
    $j = ($j + $s[$i] + mb_ord(mb_substr($key, $i % mb_strlen($key), 1))) % 256;
    $x = $s[$i];
    $s[$i] = $s[$j];
    $s[$j] = $x;
    }
    $i = 0;
    $j = 0;
    $res = '';
    for ($y = 0; $y < mb_strlen($str); $y++) {
    $i = ($i + 1) % 256;
    $j = ($j + $s[$i]) % 256;
    $x = $s[$i];
    $s[$i] = $s[$j];
    $s[$j] = $x;
    
    $res .= mb_chr(mb_ord(mb_substr($str, $y, 1)) ^ $s[($s[$i] + $s[$j]) % 256]);
    }
    return $res;
    }
}
?>