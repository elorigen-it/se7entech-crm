<?php
// helpers/api_test_helper.php

function generate_token($client = 'API Test Helper', $userid = null, $access = null)
{
    $output = [];
    // Build command with optional parameters
    $cmd = 'php issue_token.php --client="' . $client . '"';
    if ($userid !== null) {
        $cmd .= ' --userid=' . $userid;
    }
    if ($access !== null) {
        $cmd .= ' --access=' . $access;
    }

    // Executed from project root via 'php tests/verify_*_api.php'
    exec($cmd . ' 2>&1', $output);
    $fullOutput = implode("\n", $output);

    // Capture token more robustly
    if (preg_match('/(eyJ[a-zA-Z0-9\-_]+\.[a-zA-Z0-9\-_]+\.[a-zA-Z0-9\-_]+)/', $fullOutput, $matches)) {
        return trim($matches[1]);
    }
    echo "DEBUG: generate_token failed. Output:\n$fullOutput\n";
    return null;
}

function make_request($method, $url, $token, $data = null)
{
    $curl = curl_init();

    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    ];

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers,
    ];

    if (($method === 'POST' || $method === 'PUT') && $data !== null) {
        $options[CURLOPT_POSTFIELDS] = json_encode($data);
    }

    curl_setopt_array($curl, $options);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    curl_close($curl);

    // Debug output
    if ($curlError) {
        echo "CURL ERROR: $curlError\n";
        return null;
    }

    if ($httpCode !== 200) {
        echo "HTTP Code: $httpCode\n";
        echo "Raw Response: $response\n";
    }

    // Return decoded JSON directly for easier testing
    $decoded = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "JSON Decode Error: " . json_last_error_msg() . "\n";
        echo "Raw Response: $response\n";
        return null;
    }
    return $decoded;
}
