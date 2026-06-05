<?php
namespace Se7entech\Contractnew\Helpers;

class OpenAIHelper {
    public static function generateCompletion($systemPrompt, $userPrompt) {
        $apiKey = getenv('OPENAI_API_KEY');
        if (!$apiKey) {
            return ['success' => false, 'error' => 'OpenAI API Key not configured in .env'];
        }

        $url = 'https://api.openai.com/v1/chat/completions';
        
        $body = [
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt]
            ],
            'response_format' => ['type' => 'json_object'],
            'temperature' => 0.7
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $env = getenv('ENVIRONMENT') ?: ($_ENV['ENVIRONMENT'] ?? 'production');
        if ($env !== 'production') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return ['success' => false, 'error' => 'cURL Error: ' . $err];
        }

        $result = json_decode($response, true);
        if (isset($result['error'])) {
            return ['success' => false, 'error' => 'OpenAI API Error: ' . $result['error']['message']];
        }

        if (isset($result['choices'][0]['message']['content'])) {
            $content = json_decode($result['choices'][0]['message']['content'], true);
            return ['success' => true, 'data' => $content];
        }

        return ['success' => false, 'error' => 'Unexpected OpenAI API response.'];
    }

    public static function transcribeAudio($filePath) {
        $apiKey = getenv('OPENAI_API_KEY');
        if (!$apiKey) {
            return ['success' => false, 'error' => 'OpenAI API Key not configured in .env'];
        }

        $url = 'https://api.openai.com/v1/audio/transcriptions';
        
        $cFile = curl_file_create($filePath);
        $postData = [
            'file' => $cFile,
            'model' => 'whisper-1'
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: multipart/form-data'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $env = getenv('ENVIRONMENT') ?: ($_ENV['ENVIRONMENT'] ?? 'production');
        if ($env !== 'production') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return ['success' => false, 'error' => 'cURL Error: ' . $err];
        }

        $result = json_decode($response, true);
        if (isset($result['error'])) {
            return ['success' => false, 'error' => 'OpenAI Whisper Error: ' . $result['error']['message']];
        }

        if (isset($result['text'])) {
            return ['success' => true, 'text' => $result['text']];
        }

        return ['success' => false, 'error' => 'Unexpected Whisper API response.'];
    }
}
