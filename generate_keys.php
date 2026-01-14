<?php
// Generar par de claves
$config = array(
    "digest_alg" => "sha256",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
    "config" => "C:/xampp/apache/conf/openssl.cnf"
);

// Create the private and public key
$res = openssl_pkey_new($config);

// Extract the private key from $res to $privKey
openssl_pkey_export($res, $privKey, null, $config);

// Extract the public key from $res to $pubKey
$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];

// Save to files
$keyPath = __DIR__ . '/config/keys';
if (!file_exists($keyPath)) {
    mkdir($keyPath, 0777, true);
}

file_put_contents($keyPath . '/private.pem', $privKey);
file_put_contents($keyPath . '/public.pem', $pubKey);

echo "Keys generated successfully in $keyPath\n";
?>