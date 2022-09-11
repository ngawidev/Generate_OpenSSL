<?php
$config = array(
    "config" => "openssl.cnf",
    "digest_alg" => "sha512",
    "private_key_bits" => 1024, //4096
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
    "encrypt_key" => TRUE,
);
$res = openssl_pkey_new($config);
openssl_pkey_export($res, $privKey, NULL, $config);
if(!file_exists(__DIR__ . '/keys')){
    mkdir(__DIR__.'/keys', 0777, true);
}
file_put_contents(__DIR__.'/keys/private.key', $privKey);
$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];
file_put_contents(__DIR__.'/keys/public.key',$pubKey);
$data = "YOUR STRING DATA TO ENCRYPTED";

echo "Data: ".$data . "\n";
openssl_public_encrypt($data, $encrypted, $pubKey);
echo "Encrypted: ".base64_encode($encrypted) . "\n";
openssl_private_decrypt($encrypted, $decrypted, $privKey);
echo "Decrypted: ".$decrypted . "\n";
?>
