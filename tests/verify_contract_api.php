<?php
require_once __DIR__ . '/api_test_helper.php';

echo "=== Se7entech CRM - Contract API Verification ===\n\n";

// Generate Token
echo "1. Generating JWT Token (userid=123456, access=0/Admin)...\n";
$token = generate_token('ContractAPITest', 123456, '0');
if (!$token) {
    echo "ERROR: Failed to generate token\n";
    exit(1);
}
echo "✓ Token generated successfully\n\n";

// Step 2: Get All Contracts
echo "2. Testing GET /modules/contract/index.php/api/all\n";
$response = make_request('GET', 'http://localhost:8000/modules/contract/index.php/api/all', $token);
echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
if ($response && isset($response['success']) && $response['success']) {
    echo "✓ GET all contracts successful\n\n";
} else {
    echo "✗ GET all contracts failed\n\n";
}

// Step 3: Create Contract
echo "3. Testing POST /modules/contract/index.php/api/create\n";
$createPayload = [
    'customer_name' => 'Test Client API',
    'company_name' => 'API Test Corp',
    'contract_date_start' => '2024-01-01',
    'contract_date_end' => '2024-12-31',
    'services' => '<ul><li>Web Design - $3000</li><li>SEO Services - $500/month</li></ul>',
    'total_purchase' => 5000,
    'shipping_handling' => 100,
    'sale_tax' => 200,
    'additional_deposit' => 1000,
    'payment_date' => '2024-01-15'
];

$response = make_request('POST', 'http://localhost:8000/modules/contract/index.php/api/create', $token, $createPayload);
echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";

if ($response && isset($response['success']) && $response['success'] && isset($response['id'])) {
    $contractId = $response['id'];
    echo "✓ Contract created successfully (ID: $contractId)\n\n";
} else {
    echo "✗ Contract creation failed\n\n";
    exit(1);
}

// Step 4: Verify Contract in List
echo "4. Verifying created contract appears in GET /api/all\n";
$response = make_request('GET', 'http://localhost:8000/modules/contract/index.php/api/all', $token);
$found = false;
if ($response && isset($response['data'])) {
    foreach ($response['data'] as $contract) {
        if ($contract['id'] == $contractId) {
            $found = true;
            echo "✓ Created contract found in list\n";
            echo "   Company: {$contract['company_name_1']}\n";
            echo "   Customer: {$contract['customer_name_1']}\n\n";
            break;
        }
    }
}
if (!$found) {
    echo "✗ Created contract NOT found in list\n\n";
}

// Step 5: Update Contract
echo "5. Testing POST /modules/contract/index.php/api/update/{$contractId}\n";
$updatePayload = [
    'customer_name' => 'Test Client API UPDATED',
    'company_name' => 'API Test Corp UPDATED',
    'total_purchase' => 6000
];
$response = make_request('POST', "http://localhost:8000/modules/contract/index.php/api/update/{$contractId}", $token, $updatePayload);
echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";

if ($response && isset($response['success']) && $response['success']) {
    echo "✓ Contract updated successfully\n\n";
} else {
    echo "✗ Contract update failed\n\n";
}

// Step 6: Attach Invoices (if available)
echo "6. Testing POST /modules/contract/index.php/api/attach-invoices\n";
// First, get available invoices
$invoicesResponse = make_request('GET', 'http://localhost:8000/invoices/index.php/api/all', $token);
if ($invoicesResponse && isset($invoicesResponse['data']) && count($invoicesResponse['data']) > 0) {
    $invoiceIds = array_slice(array_map(fn($inv) => $inv['id'], $invoicesResponse['data']), 0, 2);
    $attachPayload = [
        'contract_id' => $contractId,
        'invoice_ids' => $invoiceIds
    ];
    $response = make_request('POST', 'http://localhost:8000/modules/contract/index.php/api/attach-invoices', $token, $attachPayload);
    echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    if ($response && isset($response['success']) && $response['success']) {
        echo "✓ Invoices attached successfully\n\n";
    } else {
        echo "✗ Invoice attachment failed\n\n";
    }
} else {
    echo "⊘ No invoices available to attach (skipping)\n\n";
}

// Step 7: Get Associated Invoices
echo "7. Testing GET /modules/contract/index.php/api/invoices/{$contractId}\n";
$response = make_request('GET', "http://localhost:8000/modules/contract/index.php/api/invoices/{$contractId}", $token);
echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
if ($response && isset($response['success']) && $response['success']) {
    echo "✓ Get associated invoices successful\n";
    echo "   Found " . count($response['data']) . " invoice(s)\n\n";
} else {
    echo "✗ Get associated invoices failed\n\n";
}

// Step 8: Get Signature Links
echo "8. Testing GET /modules/contract/index.php/api/signature-links/{$contractId}\n";
$response = make_request('GET', "http://localhost:8000/modules/contract/index.php/api/signature-links/{$contractId}", $token);
echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
if ($response && isset($response['success']) && $response['success']) {
    echo "✓ Get signature links successful\n";
    if (isset($response['data']['client_signature_link'])) {
        echo "   Client Link: {$response['data']['client_signature_link']}\n";
    }
    echo "\n";
} else {
    echo "✗ Get signature links failed\n\n";
}

// Step 9: Send Notification (Optional - requires valid email config)
echo "9. Testing POST /modules/contract/index.php/api/send-notification (OPTIONAL)\n";
echo "⊘ Skipping notification test (requires SMTP configuration)\n";
echo "   To test manually:\n";
echo "   POST /api/send-notification\n";
echo "   Body: {\"contract_id\": $contractId, \"recipient_email\": \"test@example.com\"}\n\n";

// Step 10: Delete Contract
echo "10. Testing POST /modules/contract/index.php/api/delete/{$contractId}\n";
$response = make_request('POST', "http://localhost:8000/modules/contract/index.php/api/delete/{$contractId}", $token);
echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";

if ($response && isset($response['success']) && $response['success']) {
    echo "✓ Contract deleted successfully\n\n";
} else {
    echo "✗ Contract deletion failed\n\n";
}

// Step 11: Verify Deletion
echo "11. Verifying contract is deleted\n";
$response = make_request('GET', 'http://localhost:8000/modules/contract/index.php/api/all', $token);
$found = false;
if ($response && isset($response['data'])) {
    foreach ($response['data'] as $contract) {
        if ($contract['id'] == $contractId) {
            $found = true;
            break;
        }
    }
}

if (!$found) {
    echo "✓ Contract successfully deleted (not found in list)\n\n";
} else {
    echo "✗ Contract still exists after deletion\n\n";
}

echo "=== Verification Complete ===\n";
