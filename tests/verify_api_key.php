<?php
require_once __DIR__ . '/api_test_helper.php';

$baseUrl = 'http://localhost:8000';
$jwt = generate_token('API Test', 123521); // Valid User ID 123521

echo "Testing API Key Management...\n";
if ($jwt) {
    echo "JWT Token generated successfully.\n";
    // echo "DEBUG Token: [$jwt]\n";
} else {
    echo "Failed to generate JWT Token.\n";
    exit(1);
}

// 1. Generate API Key
echo "\n1. Testing Generate API Key (POST /api/generate-key)...\n";
$response = make_request('POST', $baseUrl . '/modules/users/index.php/api/generate-key', $jwt, []);
echo "Response: " . json_encode($response) . "\n";

$data = $response;
if (isset($data['success']) && $data['success'] === true && isset($data['api_key'])) {
    echo "✅ Generate API Key Success! Key: " . substr($data['api_key'], 0, 10) . "...\n";
    $apiKey = $data['api_key'];
} else {
    echo "❌ Generate API Key Failed.\n";
    exit(1);
}

// 2. Revoke API Key
echo "\n2. Testing Revoke API Key (POST /api/revoke-key)...\n";
$response = make_request('POST', $baseUrl . '/modules/users/index.php/api/revoke-key', $jwt, []);
echo "Response: " . json_encode($response) . "\n";

$data = $response;
if (isset($data['success']) && $data['success'] === true) {
    echo "✅ Revoke API Key Success!\n";
} else {
    echo "❌ Revoke API Key Failed.\n";
    exit(1);
}

echo "\nALL API KEY TESTS PASSED!\n";
