<?php

require_once 'api_test_helper.php';

// 1. Get Token
$token = generate_token();
if (!$token) {
    die("Failed to generate token.\n");
}
echo "Token generated: " . substr($token, 0, 20) . "...\n";

// 2. Create Service
echo "\n--- Creating Service ---\n";
$createPayload = [
    'service-name' => 'API Test Service',
    'service-price' => 150.00,
    'service-description' => 'Created via API test',
    'department' => 7 // Using existing department "WEB DESIGN"
];

$response = make_request('http://localhost:8000/modules/services/index.php/api/create', 'POST', $createPayload, $token);
echo "Response: " . $response['body'] . "\n";
$json = json_decode($response['body'], true);

if (!$json || !$json['success']) {
    die("Create failed.\n");
}

// 3. Get All Services (to find the ID of the new service)
echo "\n--- Listing Services ---\n";
$response = make_request('http://localhost:8000/modules/services/index.php/api/all', 'GET', [], $token);
echo "List Response: " . $response['body'] . "\n";
$listJson = json_decode($response['body'], true);

$serviceId = null;
if ($listJson && $listJson['success']) {
    // Find our service (since create doesn't return ID yet, we have to search by name)
    // In a real API, create should return ID.
    // For this test, we scan the list.
    foreach ($listJson['data'] as $service) {
        if ($service['name'] === 'API Test Service') {
            $serviceId = $service['id'];
            break;
        }
    }
}

if (!$serviceId) {
    die("Could not find created service in list.\n");
}
echo "Found Service ID: $serviceId\n";


// 4. Update Service
echo "\n--- Updating Service ID $serviceId ---\n";
$updatePayload = [
    'service-name' => 'API Test Service Updated',
    'service-price' => 199.99,
    'service-description' => 'Updated via API test',
    'department' => 7
];
$response = make_request("http://localhost:8000/modules/services/index.php/api/update/$serviceId", 'POST', $updatePayload, $token);
echo "Response: " . $response['body'] . "\n";
$json = json_decode($response['body'], true);
if (!$json || !$json['success']) {
    die("Update failed.\n");
}


// 5. Delete Service
echo "\n--- Deleting Service ID $serviceId ---\n";
$response = make_request("http://localhost:8000/modules/services/index.php/api/delete/$serviceId", 'POST', [], $token);
echo "Response: " . $response['body'] . "\n";
$json = json_decode($response['body'], true);
if (!$json || !$json['success']) {
    die("Delete failed.\n");
}

echo "\nTest Passed Successfully!\n";
