<?php
// Verify Projects API

// 1. Issue Token
$cmd = 'php issue_token.php --client="TestScript"';
$output = shell_exec($cmd);
// Parse token between dashed lines
preg_match('/-{64}\s+([A-Za-z0-9\-\._~+\/]+)\s+-{64}/s', $output, $matches);
if (isset($matches[1])) {
    $token = trim($matches[1]);
    echo "Token received: " . substr($token, 0, 20) . "...\n";
} else {
    die("Failed to issue token. Output:\n$output\n");
}

$baseUrl = 'http://localhost:8000'; // Using PHP built-in server
// I will try http://localhost/se7entech-crm since the path is c:\Users\PC\Documents\se7entech-crm.
// Actually, usually headers are checked via cURL.

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
echo "\nTEST 1: Get All Projects\n";
$res = callApi('GET', $baseUrl . '/modules/projects/index.php/api/all', [], $token);
echo "Code: " . $res['code'] . "\n";
echo "Body: " . substr($res['body'], 0, 100) . "...\n";

// TEST 2: Create Project
echo "\nTEST 2: Create Project\n";
$newProject = [
    'project-name' => 'API Test Project ' . time(),
    'project-description' => 'Created via API',
    'project-status' => 'Pending',
    'customer' => 1 // assuming customer 1 exists
];
$res = callApi('POST', $baseUrl . '/modules/projects/index.php/api/create', $newProject, $token);
echo "Code: " . $res['code'] . "\n";
echo "Body: " . $res['body'] . "\n";

// TEST 3: Get All Again to see new project
echo "\nTEST 3: Get All Projects Again\n";
$res = callApi('GET', $baseUrl . '/modules/projects/index.php/api/all', [], $token);
echo "Code: " . $res['code'] . "\n";
// Decode to find ID
$data = json_decode($res['body'], true);
$projects = $data['data'] ?? [];
$lastProject = end($projects);
$newId = $lastProject['id'] ?? null;
echo "New Project ID: $newId\n";

if ($newId) {
    // TEST 4: Update Project
    echo "\nTEST 4: Update Project $newId\n";
    $updateData = [
        'project-name' => 'API Updated Project',
        'project-description' => 'Updated Description',
        'project-status' => 'Active',
        'customer' => 1
    ];
    $res = callApi('POST', $baseUrl . "/modules/projects/index.php/api/update/$newId", $updateData, $token);
    echo "Code: " . $res['code'] . "\n";
    echo "Body: " . $res['body'] . "\n";

    // TEST 5: Delete Project
    echo "\nTEST 5: Delete Project $newId\n";
    $res = callApi('POST', $baseUrl . "/modules/projects/index.php/api/delete/$newId", [], $token);
    echo "Code: " . $res['code'] . "\n";
    echo "Body: " . $res['body'] . "\n";
}
?>