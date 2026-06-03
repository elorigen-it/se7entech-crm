<?php
require_once __DIR__ . '/api_test_helper.php';

echo "=== Se7entech CRM - Tasks API Verification ===\n\n";

// 1. Generate Token
echo "1. Generating JWT Token...\n";
$token = generate_token('TasksAPITest', 123456, '0'); // User ID 123456 (Admin)
if (!$token) {
    echo "ERROR: Failed to generate token\n";
    exit(1);
}
echo "✓ Token generated successfully\n\n";

// Unique suffix for this run
$unique = time();

// 2. Create Label
echo "2. Testing POST /api/labels/create\n";
$labelName = 'API Test Label ' . $unique;
$labelPayload = [
    'label-name' => $labelName,
    'label-background-color' => '#ff0000',
    'label-text-color' => '#ffffff'
];
$response = make_request('POST', 'http://localhost:8000/modules/tasks/index.php/api/labels/create', $token, $labelPayload);
echo "Response: " . json_encode($response) . "\n";
$labelId = 0;
if ($response && isset($response['success']) && $response['success']) {
    echo "✓ Label created. Fetching ID...\n";
    $list = make_request('GET', 'http://localhost:8000/modules/tasks/index.php/api/labels', $token);
    foreach ($list['data'] as $lbl) {
        if ($lbl['name'] === $labelName) {
            $labelId = $lbl['id'];
            break;
        }
    }
}
if (!$labelId) {
    die("✗ Failed to get Label ID\n");
}
echo "✓ Label ID: $labelId\n\n";

// 3. Create Category
echo "3. Testing POST /api/categories/create\n";
$catName = 'API Test Cat ' . $unique;
$catPayload = [
    'category-name' => $catName,
    'category-description' => 'Test Description'
];
$response = make_request('POST', 'http://localhost:8000/modules/tasks/index.php/api/categories/create', $token, $catPayload);
echo "Response: " . json_encode($response) . "\n";
$catId = 0;
if ($response && isset($response['success']) && $response['success']) {
    echo "✓ Category created. Fetching ID...\n";
    $list = make_request('GET', 'http://localhost:8000/modules/tasks/index.php/api/categories', $token);
    foreach ($list['data'] as $c) {
        if ($c['name'] === $catName) {
            $catId = $c['id'];
            break;
        }
    }
}
if (!$catId) {
    die("✗ Failed to get Category ID\n");
}
echo "✓ Category ID: $catId\n\n";

// 4. Create Task
echo "4. Testing POST /api/create\n";
$taskName = 'API Test Task ' . $unique;
$taskPayload = [
    'task-user' => 123456,
    'task-name' => $taskName,
    'customer-id' => 1, // Assumptions: customer 1 exists
    'task-description' => 'Created via API',
    'customer-tempname' => 'Temp Cust',
    'task-project' => 0,
    'deadline' => '2024-12-31',
    'estimated_time' => '10',
    'task-description-for-customer' => 'Client view',
    'task-labels' => [$labelId],
    'task-categories' => [$catId]
];
$response = make_request('POST', 'http://localhost:8000/modules/tasks/index.php/api/create', $token, $taskPayload);
echo "Response: " . json_encode($response) . "\n";
$taskId = 0;
if ($response && isset($response['success']) && $response['success'] && isset($response['id'])) {
    $taskId = $response['id'];
    echo "✓ Task Created (ID: $taskId)\n\n";
} else {
    die("✗ Failed to create task\n");
}

// 5. Start Task
echo "5. Testing POST /api/start/$taskId\n";
$response = make_request('POST', "http://localhost:8000/modules/tasks/index.php/api/start/$taskId", $token, []);
echo "Response: " . json_encode($response) . "\n";
if ($response && isset($response['success']) && $response['success'])
    echo "✓ Task Started\n\n";
else
    die("✗ Failed to start\n");

sleep(1);

// 6. Pause Task
echo "6. Testing POST /api/pause/$taskId\n";
$response = make_request('POST', "http://localhost:8000/modules/tasks/index.php/api/pause/$taskId", $token, ['reason' => 'API Test Pause']);
echo "Response: " . json_encode($response) . "\n";
if ($response && isset($response['success']) && $response['success'])
    echo "✓ Task Paused\n\n";
else
    die("✗ Failed to pause\n");

sleep(1);

// 7. Resume Task
echo "7. Testing POST /api/resume/$taskId\n";
$response = make_request('POST', "http://localhost:8000/modules/tasks/index.php/api/resume/$taskId", $token, []);
echo "Response: " . json_encode($response) . "\n";
if ($response && isset($response['success']) && $response['success'])
    echo "✓ Task Resumed\n\n";
else
    die("✗ Failed to resume\n");

sleep(1);

// 8. Finish Task
echo "8. Testing POST /api/finish/$taskId\n";
$response = make_request('POST', "http://localhost:8000/modules/tasks/index.php/api/finish/$taskId", $token, ['resource' => 'http://example.com']);
echo "Response: " . json_encode($response) . "\n";
if ($response && isset($response['success']) && $response['success'])
    echo "✓ Task Finished\n\n";
else
    die("✗ Failed to finish\n");

// 9. Verify State & Filtering
echo "9. Verifying State & Filtering\n";
// Get By ID
$task = make_request('GET', "http://localhost:8000/modules/tasks/index.php/api/$taskId", $token);
if ($task && isset($task['data']) && $task['data']['status'] === 'finished' && $task['data']['final_resource'] === 'http://example.com') {
    echo "✓ Task state verified (finished, resource set)\n";
} else {
    echo "✗ Task state verification failed: " . json_encode($task['data'] ?? 'No Data') . "\n";
}

// Filter by Label
$filtered = make_request('GET', "http://localhost:8000/modules/tasks/index.php/api/all?label_id=$labelId", $token);
$found = false;
if (isset($filtered['data'])) {
    foreach ($filtered['data'] as $t) {
        if ($t['id'] == $taskId) {
            $found = true;
            break;
        }
    }
}
if ($found)
    echo "✓ Filter by Label successful\n";
else
    echo "✗ Filter by Label failed\n";

// Filter by Category
$filtered = make_request('GET', "http://localhost:8000/modules/tasks/index.php/api/all?category_id=$catId", $token);
$found = false;
if (isset($filtered['data'])) {
    foreach ($filtered['data'] as $t) {
        if ($t['id'] == $taskId) {
            $found = true;
            break;
        }
    }
}
if ($found)
    echo "✓ Filter by Category successful\n";
else
    echo "✗ Filter by Category failed\n";

// 10. Delete Task
echo "10. Deleting Task\n";
$response = make_request('POST', "http://localhost:8000/modules/tasks/index.php/api/delete/$taskId", $token, []);
if ($response && isset($response['success']) && $response['success'])
    echo "✓ Task Deleted\n";
else
    echo "✗ Task Deletion Failed\n";

// 11. Delete Label
echo "11. Deleting Label\n";
$response = make_request('POST', "http://localhost:8000/modules/tasks/index.php/api/labels/delete/$labelId", $token, []);
if ($response && isset($response['success']) && $response['success'])
    echo "✓ Label Deleted\n";
else
    echo "✗ Label Deletion Failed\n";

// 12. Delete Category
echo "12. Deleting Category\n";
$response = make_request('POST', "http://localhost:8000/modules/tasks/index.php/api/categories/delete/$catId", $token, []);
if ($response && isset($response['success']) && $response['success'])
    echo "✓ Category Deleted\n";
else
    echo "✗ Category Deletion Failed\n";


echo "\n=== Verification Complete ===\n";
