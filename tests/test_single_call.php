<?php
// tests/test_single_call.php

// 1. Generate Token
$output = [];
exec('php issue_token.php --client="SingleTest" --userid=123456 --access=0 2>&1', $output);
$fullOutput = implode("\n", $output);
preg_match('/(eyJ[a-zA-Z0-9\-_]+\.[a-zA-Z0-9\-_]+\.[a-zA-Z0-9\-_]+)/', $fullOutput, $matches);
$token = $matches[1] ?? '';

if (!$token) {
    file_put_contents('response_dump.txt', "Failed to get token. Output: $fullOutput");
    exit;
}

// 2. Make Request
$url = 'http://localhost:8000/modules/tasks/index.php/api/labels/create';
$data = [
    'label-name' => 'API Test Label Manual',
    'label-background-color' => '#00ff00',
    'label-text-color' => '#000000'
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
]);
curl_setopt($ch, CURLOPT_VERBOSE, true);

$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

rewind($verbose);
$verboseLog = stream_get_contents($verbose);

$log = "HTTP Code: $httpCode\n";
$log .= "Response Body:\n$response\n";
$log .= "Verbose Log:\n$verboseLog\n";

file_put_contents('response_dump.txt', $log);
echo "Done. Check response_dump.txt\n";
