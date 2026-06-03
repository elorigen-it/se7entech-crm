<?php
require_once __DIR__ . '/tests/api_test_helper.php';

echo "=== Test: Contract Notification with Invoice ===\n\n";

// Step 1: Generate Token
echo "1. Generating JWT Token...\n";
$token = generate_token('EmailTest', 123456, '0');
if (!$token) {
    die("ERROR: Failed to generate token\n");
}
echo "✓ Token generated\n\n";

// Step 2: Get existing invoices to use one
echo "2. Getting existing invoices...\n";
$response = make_request('GET', 'http://localhost:8000/modules/invoices/index.php/api/all', $token);

if ($response && isset($response['success']) && $response['success'] && count($response['data']) > 0) {
    $invoiceId = $response['data'][0]['id'];
    echo "✓ Found existing invoice (ID: $invoiceId)\n\n";
} else {
    echo "⚠ No invoices found, creating test contract without invoice...\n\n";
    $invoiceId = null;
}

// Step 3: Create a test contract
echo "3. Creating test contract...\n";
$createPayload = [
    'customer_name' => 'Adonis Jose',
    'company_name' => 'Test Company',
    'contract_date_start' => '2024-01-01',
    'contract_date_end' => '2024-12-31',
    'services' => '<ul><li>Web Development - $2000</li><li>Maintenance - $500/year</li></ul>',
    'total_purchase' => 2500
];

$response = make_request('POST', 'http://localhost:8000/modules/contract/index.php/api/create', $token, $createPayload);

if ($response && isset($response['success']) && $response['success'] && isset($response['id'])) {
    $contractId = $response['id'];
    echo "✓ Contract created (ID: $contractId)\n\n";
} else {
    echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    die("✗ Contract creation failed\n");
}

// Step 4: Attach invoice to contract (if we have one)
if ($invoiceId) {
    echo "4. Attaching invoice to contract...\n";
    $attachPayload = [
        'contract_id' => $contractId,
        'invoice_ids' => [$invoiceId]
    ];

    $response = make_request('POST', 'http://localhost:8000/modules/contract/index.php/api/attach-invoices', $token, $attachPayload);

    if ($response && isset($response['success']) && $response['success']) {
        echo "✓ Invoice attached to contract\n\n";
    } else {
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
        echo "⚠ Invoice attachment failed (continuing anyway)\n\n";
    }

    // Step 5: Verify attached invoices
    echo "5. Verifying attached invoices...\n";
    $response = make_request('GET', "http://localhost:8000/modules/contract/index.php/api/invoices/{$contractId}", $token);

    if ($response && isset($response['success']) && $response['success']) {
        echo "✓ Found " . count($response['data']) . " attached invoice(s)\n";
        if (count($response['data']) > 0) {
            foreach ($response['data'] as $inv) {
                echo "  - Invoice ID: {$inv['id']}, Concept: " . ($inv['order_concept'] ?? 'N/A') . "\n";
            }
        }
        echo "\n";
    } else {
        echo "⚠ Could not retrieve attached invoices\n\n";
    }
} else {
    echo "4-5. Skipping invoice attachment (no invoices available)\n\n";
}

// Step 6: Send notification
echo "6. Sending notification email to adonisjose07@gmail.com...\n";
$notificationPayload = [
    'contract_id' => $contractId,
    'recipient_email' => 'adonisjose07@gmail.com'
];

$response = make_request('POST', 'http://localhost:8000/modules/contract/index.php/api/send-notification', $token, $notificationPayload);

echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";

if ($response && isset($response['success']) && $response['success']) {
    echo "\n✓ Notification sent successfully!\n";
    echo "  - PDF Generated: " . ($response['pdf_generated'] ? 'Yes' : 'No') . "\n";
    echo "  - Email Sent: " . ($response['email_sent'] ? 'Yes' : 'No') . "\n";
    if ($invoiceId) {
        echo "  - Email includes invoice payment link\n";
    }
} else {
    echo "\n✗ Notification failed\n";
    if (isset($response['message'])) {
        echo "  Error: " . $response['message'] . "\n";
    }
}

// Step 7: Cleanup - Delete test contract
echo "\n7. Cleaning up...\n";

$deleteResponse = make_request('POST', "http://localhost:8000/modules/contract/index.php/api/delete/{$contractId}", $token);
if ($deleteResponse && isset($deleteResponse['success']) && $deleteResponse['success']) {
    echo "✓ Test contract deleted (ID: $contractId)\n";
} else {
    echo "⚠ Could not delete test contract (ID: $contractId)\n";
}

echo "\n=== Test Complete ===\n";
