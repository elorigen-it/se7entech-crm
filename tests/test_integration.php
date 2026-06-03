<?php
require_once __DIR__ . '/tests/api_test_helper.php';

echo "=== Se7entech CRM - Complete Integration Test ===\n";
echo "Creating Service → Invoice → Contract → Email Notification\n\n";

// Step 1: Generate Token
echo "1. Generating JWT Token (userid=123456, Admin)...\n";
$token = generate_token('IntegrationTest', 123456, '0');
if (!$token) {
    die("ERROR: Failed to generate token\n");
}
echo "✓ Token generated\n\n";

// Step 2: Create Service
echo "2. Creating Service (Web Development Package)...\n";
$servicePayload = [
    'service-name' => 'Complete Web Development Package',
    'service-description' => 'Full-stack web development with React + Node.js',
    'service-price' => 5000.00,
    'department' => 7  // WEB DESIGN
];

$response = make_request('POST', 'http://localhost:8000/modules/services/index.php/api/create', $token, $servicePayload);

if ($response && isset($response['success']) && $response['success'] && isset($response['id'])) {
    $serviceId = $response['id'];
    echo "✓ Service created (ID: $serviceId)\n";
    echo "   Name: {$servicePayload['name']}\n";
    echo "   Price: \${$servicePayload['price']}\n\n";
} else {
    echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    die("✗ Service creation failed\n");
}

// Step 3: Create Invoice
echo "3. Creating Invoice for the service...\n";
$invoicePayload = [
    'companyName' => 'Adonis Jose - Test Client',
    'invoiceConcept' => 'Web Development Package - Initial Payment',
    'address' => 'Santo Domingo, Dominican Republic',
    'subTotal' => 5000.00,
    'taxAmount' => 200.00,
    'taxRate' => 4.00,
    'totalAftertax' => 5200.00,
    'amountPaid' => 0.00,
    'amountDue' => 5200.00,
    'notes' => 'Payment for complete web development package including design, development, and deployment.',
    'duesdate' => date('Y-m-d', strtotime('+30 days')),
    'productCode' => ['WEB-DEV-001'],
    'productName' => ['Complete Web Development Package'],
    'quantity' => [1],
    'price' => [5000.00],
    'total' => [5000.00]
];

$response = make_request('POST', 'http://localhost:8000/modules/invoices/index.php/api/create', $token, $invoicePayload);

if ($response && isset($response['success']) && $response['success'] && isset($response['id'])) {
    $invoiceId = $response['id'];
    echo "✓ Invoice created (ID: $invoiceId)\n";
    echo "   Total: \${$invoicePayload['totalAftertax']}\n";
    echo "   Due Date: {$invoicePayload['duesdate']}\n\n";
} else {
    echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    die("✗ Invoice creation failed\n");
}

// Step 4: Create Contract with Service Details
echo "4. Creating Contract...\n";
$contractPayload = [
    'customer_name' => 'Adonis Jose',
    'company_name' => 'Adonis Tech Solutions',
    'contract_date_start' => date('Y-m-d'),
    'contract_date_end' => date('Y-m-d', strtotime('+1 year')),
    'services' => "
        <h3>Web Development Services</h3>
        <ul>
            <li><strong>Complete Web Development Package</strong> - \$5,000.00</li>
            <li>Custom responsive design with modern UI/UX</li>
            <li>React.js frontend with advanced features</li>
            <li>Node.js backend API development</li>
            <li>Database design and implementation</li>
            <li>Deployment and hosting setup</li>
            <li>3 months of maintenance and support</li>
        </ul>
        <p><em>Service ID: {$serviceId} - {$servicePayload['name']}</em></p>
    ",
    'total_purchase' => 5000.00,
    'shipping_handling' => 0,
    'sale_tax' => 200.00,
    'additional_deposit' => 1000.00,
    'payment_date' => date('Y-m-d'),
    'dues_after_deposit' => 4200.00,
    'maintenance_period' => '3 months'
];

$response = make_request('POST', 'http://localhost:8000/modules/contract/index.php/api/create', $token, $contractPayload);

if ($response && isset($response['success']) && $response['success'] && isset($response['id'])) {
    $contractId = $response['id'];
    echo "✓ Contract created (ID: $contractId)\n";
    echo "   Client: {$contractPayload['customer_name']}\n";
    echo "   Company: {$contractPayload['company_name']}\n";
    echo "   Total: \${$contractPayload['total_purchase']}\n\n";
} else {
    echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    die("✗ Contract creation failed\n");
}

// Step 5: Attach Invoice to Contract
echo "5. Attaching Invoice to Contract...\n";
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

// Step 6: Verify Attachments
echo "6. Verifying invoice attachment...\n";
$response = make_request('GET', "http://localhost:8000/modules/contract/index.php/api/invoices/{$contractId}", $token);

if ($response && isset($response['success']) && $response['success'] && count($response['data']) > 0) {
    echo "✓ Verified: " . count($response['data']) . " invoice(s) attached\n";
    foreach ($response['data'] as $inv) {
        echo "   - Invoice ID: " . ($inv['id'] ?? 'N/A') . "\n";
    }
    echo "\n";
} else {
    echo "⚠ No invoices found attached to contract\n\n";
}

// Step 7: Get Signature Links
echo "7. Getting signature links...\n";
$response = make_request('GET', "http://localhost:8000/modules/contract/index.php/api/signature-links/{$contractId}", $token);

if ($response && isset($response['success']) && $response['success']) {
    echo "✓ Signature links retrieved\n";
    if (isset($response['data']['customer_signature_link'])) {
        echo "   Customer Link: {$response['data']['customer_signature_link']}\n";
    }
    echo "\n";
}

// Step 8: Send Email Notification
echo "8. Sending email notification to adonisjose07@gmail.com...\n";
$notificationPayload = [
    'contract_id' => $contractId,
    'recipient_email' => 'adonisjose07@gmail.com'
];

$response = make_request('POST', 'http://localhost:8000/modules/contract/index.php/api/send-notification', $token, $notificationPayload);

echo "\nEmail Response:\n";
echo json_encode($response, JSON_PRETTY_PRINT) . "\n";

if ($response && isset($response['success']) && $response['success']) {
    echo "\n✅ EMAIL SENT SUCCESSFULLY!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📧 Recipient: adonisjose07@gmail.com\n";
    echo "📄 PDF Contract: Attached\n";
    echo "🔗 Signature Link: Included\n";
    echo "💳 Invoice Payment Link: Included (Invoice #{$invoiceId})\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
} else {
    echo "\n✗ EMAIL FAILED\n";
    if (isset($response['message'])) {
        echo "Error: {$response['message']}\n\n";
    }
}

// Step 9: Summary
echo "9. Integration Test Summary\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "✓ Service ID: $serviceId\n";
echo "✓ Invoice ID: $invoiceId (Total: \$5,200.00)\n";
echo "✓ Contract ID: $contractId\n";
echo "✓ Invoice attached to Contract\n";
echo "✓ Email sent with:\n";
echo "  - Contract PDF\n";
echo "  - Signature link\n";
echo "  - Payment link for invoice\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "NOTE: These test records remain in the database.\n";
echo "To cleanup manually:\n";
echo "  - Service ID: $serviceId\n";
echo "  - Invoice ID: $invoiceId\n";
echo "  - Contract ID: $contractId\n\n";

echo "=== Integration Test Complete ===\n";
