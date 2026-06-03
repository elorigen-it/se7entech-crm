<?php
require_once __DIR__ . '/api_test_helper.php';

echo "=== Se7entech CRM - Invoice API Verification ===\n\n";

// Generate Token
echo "1. Generating JWT Token (userid=123456, access=0/Admin)...\n";
$token = generate_token('InvoiceAPITest', 123456, '0');
if (!$token) {
    echo "ERROR: Failed to generate token\n";
    exit(1);
}
echo "✓ Token generated successfully\n\n";

// Step 2: Get All Invoices
echo "2. Testing GET /modules/invoices/index.php/api/all\n";
$response = make_request('GET', 'http://localhost:8000/modules/invoices/index.php/api/all', $token);
echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
if ($response && isset($response['success']) && $response['success']) {
    echo "✓ GET all invoices successful\n";
    echo "   Found " . count($response['data']) . " invoice(s)\n\n";
} else {
    echo "✗ GET all invoices failed\n\n";
}

// Step 3: Create Invoice
echo "3. Testing POST /modules/invoices/index.php/api/create\n";
$createPayload = [
    'companyName' => 'API Test Company',
    'invoiceConcept' => 'API Test Invoice - Automated',
    'address' => '123 Test Boulevard',
    'subTotal' => 1000.00,
    'taxAmount' => 40.00,
    'taxRate' => 4.00,
    'totalAftertax' => 1040.00,
    'amountPaid' => 0.00,
    'amountDue' => 1040.00,
    'notes' => 'This is a test invoice created via API',
    'duesdate' => date('Y-m-d', strtotime('+30 days')),
    // Item arrays
    'productCode' => ['TEST-001', 'TEST-002'],
    'productName' => ['Web Development', 'SEO Services'],
    'quantity' => [1, 2],
    'price' => [700.00, 150.00],
    'total' => [700.00, 300.00]
];

$response = make_request('POST', 'http://localhost:8000/modules/invoices/index.php/api/create', $token, $createPayload);
echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";

if ($response && isset($response['success']) && $response['success'] && isset($response['id'])) {
    $invoiceId = $response['id'];
    echo "✓ Invoice created successfully (ID: $invoiceId)\n\n";
} else {
    echo "✗ Invoice creation failed\n\n";
    exit(1);
}

// Step 4: Verify Invoice in List
echo "4. Verifying created invoice appears in GET /api/all\n";
$response = make_request('GET', 'http://localhost:8000/modules/invoices/index.php/api/all', $token);
$found = false;
if ($response && isset($response['data'])) {
    foreach ($response['data'] as $invoice) {
        if (isset($invoice['id']) && $invoice['id'] == $invoiceId) {
            $found = true;
            echo "✓ Created invoice found in list\n";
            echo "   Company: " . ($invoice['order_receiver_name'] ?? 'N/A') . "\n";
            echo "   Concept: " . ($invoice['order_concept'] ?? 'N/A') . "\n";
            echo "   Total: $" . ($invoice['order_total_after_tax'] ?? '0.00') . "\n\n";
            break;
        }
    }
}
if (!$found) {
    echo "✗ Created invoice NOT found in list\n\n";
}

// Step 5: Update Invoice
echo "5. Testing POST /modules/invoices/index.php/api/update/{$invoiceId}\n";
$updatePayload = [
    'companyName' => 'API Test Company UPDATED',
    'invoiceConcept' => 'API Test Invoice - UPDATED',
    'address' => '456 Updated Street',
    'subTotal' => 1200.00,
    'taxAmount' => 48.00,
    'taxRate' => 4.00,
    'totalAftertax' => 1248.00,
    'amountPaid' => 500.00,
    'amountDue' => 748.00,
    'notes' => 'Invoice updated via API test',
    'duesdate' => date('Y-m-d', strtotime('+45 days')),
    'productCode' => ['TEST-001-UPD'],
    'productName' => ['Web Development Updated'],
    'quantity' => [1],
    'price' => [1200.00],
    'total' => [1200.00]
];

$response = make_request('POST', "http://localhost:8000/modules/invoices/index.php/api/update/{$invoiceId}", $token, $updatePayload);
echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";

if ($response && isset($response['success']) && $response['success']) {
    echo "✓ Invoice updated successfully\n\n";
} else {
    echo "✗ Invoice update failed\n\n";
}

// Step 6: Verify Update
echo "6. Verifying invoice was updated\n";
$response = make_request('GET', 'http://localhost:8000/modules/invoices/index.php/api/all', $token);
if ($response && isset($response['data'])) {
    foreach ($response['data'] as $invoice) {
        if (isset($invoice['id']) && $invoice['id'] == $invoiceId) {
            if (isset($invoice['order_receiver_name']) && $invoice['order_receiver_name'] == 'API Test Company UPDATED') {
                echo "✓ Invoice successfully updated\n";
                echo "   New Total: $" . ($invoice['order_total_after_tax'] ?? '0.00') . "\n\n";
            } else {
                echo "⚠ Invoice found but update not reflected\n\n";
            }
            break;
        }
    }
}

// Step 7: Delete Invoice
echo "7. Testing POST /modules/invoices/index.php/api/delete/{$invoiceId}\n";
$response = make_request('POST', "http://localhost:8000/modules/invoices/index.php/api/delete/{$invoiceId}", $token);
echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";

if ($response && isset($response['success']) && $response['success']) {
    echo "✓ Invoice deleted successfully\n\n";
} else {
    echo "✗ Invoice deletion failed\n\n";
}

// Step 8: Verify Deletion
echo "8. Verifying invoice is deleted\n";
$response = make_request('GET', 'http://localhost:8000/modules/invoices/index.php/api/all', $token);
$found = false;
if ($response && isset($response['data'])) {
    foreach ($response['data'] as $invoice) {
        if (isset($invoice['id']) && $invoice['id'] == $invoiceId) {
            $found = true;
            break;
        }
    }
}

if (!$found) {
    echo "✓ Invoice successfully deleted (not found in list)\n\n";
} else {
    echo "✗ Invoice still exists after deletion\n\n";
}

echo "=== Verification Complete ===\n";
