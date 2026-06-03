<?php

require_once 'vendor/autoload.php';

// Load keys (not strictly needed for curl but good for debug)
$keyPath = __DIR__ . '/config/keys/private.pem';
if (!file_exists($keyPath)) {
    die("Private key not found at $keyPath\n");
}

// 1. Issue a Token
// We can use the issue_token.php script or do it inline.
// Let's do it inline to avoid dependency on the other script's output format.
use Firebase\JWT\JWT;
putenv("OPENSSL_CONF=C:/xampp/apache/conf/openssl.cnf"); // Ensure this matches your env

$privateKey = file_get_contents($keyPath);
$payload = [
    'iss' => 'se7entech-crm',
    'aud' => 'se7entech-crm',
    'iat' => time(),
    'exp' => time() + 3600, // 1 hour
    'sub' => 'VerificationScript',
    'role' => 'admin'
];

try {
    $token = JWT::encode($payload, $privateKey, 'RS256');
    echo "Token received: " . substr($token, 0, 20) . "...\n";
} catch (Exception $e) {
    die("Failed to issue token: " . $e->getMessage() . "\n");
}

$baseUrl = 'http://localhost:8000'; // Using PHP built-in server

function callApi($method, $url, $data = [], $token = '')
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    $headers = ['Content-Type: application/json'];
    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if (!empty($data)) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ['code' => $httpCode, 'body' => $result];
}


// TEST 1: Get All (should be empty or list)
echo "\nTEST 1: Get All Customers\n";
$res = callApi('GET', $baseUrl . '/modules/customers/index.php/api/all', [], $token);
echo "Code: " . $res['code'] . "\n";
echo "Body: " . substr($res['body'], 0, 100) . "...\n";

// TEST 2: Create Customer
echo "\nTEST 2: Create Customer\n";
$newCustomer = [
    'type' => 'customer',
    'name' => 'API Test Customer ' . time(),
    'email' => 'api' . time() . '@example.com',
    'phone' => '12345678',
    'status' => 'active'
];
$res = callApi('POST', $baseUrl . '/modules/customers/index.php/api/create', $newCustomer, $token);
echo "Code: " . $res['code'] . "\n";
echo "Body: " . $res['body'] . "\n";

// TEST 3: Get All Again to see new customer
echo "\nTEST 3: Get All Customers Again\n";
$res = callApi('GET', $baseUrl . '/modules/customers/index.php/api/all', [], $token);
echo "Code: " . $res['code'] . "\n";
// Decode to find ID
$data = json_decode($res['body'], true);
$customers = $data['data'] ?? [];
$lastCustomer = end($customers);
$newId = $lastCustomer['id'] ?? null;
echo "New Customer ID: $newId\n";

if ($newId) {
    // TEST 4: Update Customer
    echo "\nTEST 4: Update Customer $newId\n";
    $updateData = [
        'type' => 'customer',
        'name' => 'API Updated Customer',
        'email' => 'updated' . time() . '@example.com',
        'phone' => '87654321',
        'status' => 'active'
    ];
    $res = callApi('POST', $baseUrl . "/modules/customers/index.php/api/update/$newId", $updateData, $token);
    echo "Code: " . $res['code'] . "\n";
    echo "Body: " . $res['body'] . "\n";

    // TEST 5: Delete Customer
    echo "\nTEST 5: Delete Customer $newId\n";
    $res = callApi('POST', $baseUrl . "/modules/customers/index.php/api/delete/$newId", [], $token);
    echo "Code: " . $res['code'] . "\n";
    echo "Body: " . $res['body'] . "\n";
}
