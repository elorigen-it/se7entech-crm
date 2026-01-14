<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;

if (php_sapi_name() !== 'cli') {
    die("This script can only be run from the command line.");
}

// Ensure OpenSSL config is loaded for Windows
putenv("OPENSSL_CONF=C:/xampp/apache/conf/openssl.cnf");

$shortopts = "c:";  // Client name
$longopts = array(
    "client:",     // Required value
    "exp::",       // Optional value
    "userid::",    // Optional value (new)
    "access::",    // Optional value (new)
);
$options = getopt($shortopts, $longopts);

$client = isset($options['client']) ? $options['client'] : (isset($options['c']) ? $options['c'] : null);
$expirationInHour = isset($options['exp']) ? (int) $options['exp'] : 8760; // Default 1 year
$userid = isset($options['userid']) ? (int) $options['userid'] : 1; // Default to ID 1
$access = isset($options['access']) ? (string) $options['access'] : '0'; // Default to Access 0 (Admin)

if (!$client) {
    echo "Usage: php issue_token.php --client=\"ClientName\" [--exp=HOURS] [--userid=ID] [--access=LEVEL]\n";
    echo "\nNote: If --userid is provided, 'access' level will be fetched from the database.\n";
    echo "      The --access flag is optional and primarily for testing/override purposes.\n";
    exit(1);
}

$keyPath = __DIR__ . '/config/keys/private.pem';
if (!file_exists($keyPath)) {
    die("Private key not found. Run generate_keys.php first.\n");
}
$privateKey = file_get_contents($keyPath);

$issuedAt = time();
$expirationTime = $issuedAt + ($expirationInHour * 3600);
$payload = [
    'iss' => 'se7entech-crm',
    'aud' => 'se7entech-api',
    'iat' => $issuedAt,
    'exp' => $expirationTime,
    'data' => [
        'client' => $client,
        'access' => $access,
        'userid' => $userid,
        'user' => $client
    ]
];

// OpenSSL config for RSA signing
// Ensuring openssl.cnf is found if needed, though php-jwt uses openssl_sign which might need it? 
// No, php-jwt handles it, but just in case we load the key.

try {
    $jwt = JWT::encode($payload, $privateKey, 'RS256');
    echo "----------------------------------------------------------------\n";
    echo "Token issued for client: $client\n";
    echo "Expires in: $expirationInHour hours\n";
    echo "----------------------------------------------------------------\n";
    echo $jwt . "\n";
    echo "----------------------------------------------------------------\n";
} catch (Exception $e) {
    echo "Error generating token: " . $e->getMessage() . "\n";
}
?>