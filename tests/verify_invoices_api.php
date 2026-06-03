<?php

require_once 'vendor/autoload.php';

// Load keys
$keyPath = __DIR__ . '/config/keys/private.pem';
if (!file_exists($keyPath)) {
    die("Private key not found at $keyPath\n");
}

use Firebase\JWT\JWT;
putenv("OPENSSL_CONF=C:/xampp/apache/conf/openssl.cnf");

$privateKey = file_get_contents($keyPath);
$payload = [
    'iss' => 'se7entech-crm',
    'aud' => 'se7entech-crm',
    'iat' => time(),
    'exp' => time() + 3600,
    'sub' => 'VerificationScript',
    'role' => 'admin'
];

try {
    $token = JWT::encode($payload, $privateKey, 'RS256');
    echo "Token received.\n";
} catch (Exception $e) {
    die("Failed to issue token: " . $e->getMessage() . "\n");
}

$baseUrl = 'http://localhost:8000';

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

// TEST 1: Get All
echo "\nTEST 1: Get All Invoices\n";
$res = callApi('GET', $baseUrl . '/modules/invoices/routes.php/api/all', [], $token);
// Note: Route path depends on how `ModuleLoader` or `index.php` handles it. 
// Previously we accessed modules via `modules/{module}/index.php`. 
// But Invoices module had no `index.php`? I should check if I created one or if `routes.php` acts as entry point?
// The standard seems to be `modules/invoices/index.php`. I might have missed creating `index.php` for Invoices if it didn't exist!
// Let's assume I need to check/create `modules/invoices/index.php` first.
// For now, I'll try the standard path assuming `index.php` exists or I'll fix it.
$res = callApi('GET', $baseUrl . '/modules/invoices/index.php/api/all', [], $token);
echo "Code: " . $res['code'] . "\n";
echo "Body: " . substr($res['body'], 0, 100) . "...\n";

// TEST 2: Create Invoice
echo "\nTEST 2: Create Invoice\n";
$newInvoice = [
    'companyName' => 'API Test Corp',
    'address' => '123 Test St',
    'invoiceConcept' => 'API Testing Services',
    'subTotal' => 100,
    'taxAmount' => 10,
    'taxRate' => 10,
    'totalAftertax' => 110,
    'amountPaid' => 0,
    'amountDue' => 110,
    'duesdate' => date('Y-m-d', strtotime('+7 days')),
    'productCode' => ['ITM001', 'ITM002'],
    'productName' => ['Service A', 'Service B'],
    'quantity' => [1, 1],
    'price' => [50, 50],
    'total' => [50, 50]
];
$res = callApi('POST', $baseUrl . '/modules/invoices/index.php/api/create', $newInvoice, $token);
echo "Code: " . $res['code'] . "\n";
echo "Body: " . $res['body'] . "\n";

// Decode to find ID
$data = json_decode($res['body'], true);
$newId = $data['id'] ?? null;

if ($newId) {
    // TEST 3: Update Invoice
    echo "\nTEST 3: Update Invoice $newId\n";
    $newInvoice['invoiceConcept'] = 'API Testing Services UPDATED';
    $res = callApi('POST', $baseUrl . "/modules/invoices/index.php/api/update/$newId", $newInvoice, $token);
    echo "Code: " . $res['code'] . "\n";
    echo "Body: " . $res['body'] . "\n";

    // TEST 4: Delete Invoice
    echo "\nTEST 4: Delete Invoice $newId\n";
    $res = callApi('POST', $baseUrl . "/modules/invoices/index.php/api/delete/$newId", [], $token);
    echo "Code: " . $res['code'] . "\n";
    echo "Body: " . $res['body'] . "\n";
}
