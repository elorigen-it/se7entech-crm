<?php

namespace Se7entech\Contractnew\Providers;

use Dotenv\Dotenv;
use Exception;

class OpenAIProvider
{
    private string $apiKey;
    private string $apiBase;
    private int $timeout;
    private string $defaultModel;

    // Definir los límites de tokens máximos por modelo
    public static $modelMaxTokens = [
        'gpt-3.5-turbo' => 4096,
        'gpt-4' => 8192,
        'gpt-4.1' => 32768,
        'gpt-4o' => 16384,
        'gpt-4o-mini' => 16384,
        'o1' => 100000,
        'o3' => 100000,
        'o4-mini' => 100000,
    ];
    public static $modelCostsPerMillionTokens = [
        'gpt-3.5-turbo' => 1.50,
        'gpt-4' => 60.00,
        'gpt-4.1' => 8.00,
        'gpt-4o' => 10.00,
        'gpt-4o-mini' => 0.60,
        'o1' => 60.00,
        'o3' => 8.00,
        'o4-mini' => 4.40,
    ];

    public function __construct(
        $apiModel = null, $apiTemperature = null, 
        $apiTopP = null, $apiMaxTokens = null, 
        $apiFrequencyPenalty = null, $apiPresencePenalty = null,
        $apiTimeout = null,
        $reasoningEffort = null)
    {       // Cargar variables de entorno (ajustada la ruta para tu estructura)
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->apiKey = $_ENV['OPENAI_API_KEY'];
        $this->apiBase = $_ENV['OPENAI_API_BASE'] ?? 'https://api.openai.com/v1';
        $this->timeout = (int)($_ENV['OPENAI_TIMEOUT'] ?? 30);
        $this->defaultModel = $apiModel ?? ($_ENV['OPENAI_MODEL'] ?? 'gpt-3.5-turbo');
        $this->defaultTemperature = $apiTemperature ?? ($_ENV['OPENAI_TEMPERATURE'] ?? 0.7);
        $this->defaultTopP = $apiTopP ?? ($_ENV['OPENAI_TOP_P'] ?? 1.0);
        $this->defaultMaxTokens = $apiMaxTokens ?? ($_ENV['OPENAI_MAX_TOKENS'] ?? 20000);
        $this->defaultFrequencyPenalty = $apiFrequencyPenalty ?? ($_ENV['OPENAI_FREQUENCY_PENALTY'] ?? 0.0);
        $this->defaultPresencePenalty = $apiPresencePenalty ?? ($_ENV['OPENAI_PRESENCE_PENALTY'] ?? 0.0);
        $this->defaultReasoningEffort = $reasoningEffort ?? ($_ENV['OPENAI_REASONING_EFFORT'] ?? 'medium');

        if (empty($this->apiKey)) {
            throw new Exception('API key is required for OpenAI');
        }
    }

    /**
     * Realiza una consulta al chat completions de OpenAI
     * 
     * @param array $messages Array de mensajes en el formato de OpenAI
     * @param string|null $model Modelo a usar (opcional)
     * @param float $temperature Temperatura para la generación (0-2)
     * @return array Respuesta de la API
     * @throws Exception Si ocurre un error
     */
    public function chatCompletion(array $messages): array
    {
        $model = $this->defaultModel;
        $temperature = $this->defaultTemperature;
        $topP = $this->defaultTopP;
        $maxTokens = $this->defaultMaxTokens;
        $frequencePenalty = $this->defaultFrequencyPenalty;
        $presencePenalty = $this->defaultPresencePenalty;
        $reasoningEffort =  $this->defaultReasoningEffort;
        
        $url = $this->apiBase . '/chat/completions';

        $data = [
            'model' => $model,
            'messages' => $messages,
            'temperature' =>  (float) $temperature,
            'top_p' =>  (float) $topP,
            'frequency_penalty' => (float) $frequencePenalty,
            'presence_penalty' => (float) $presencePenalty,
            (str_starts_with($model, 'gpt-4o') ? 'max_completion_tokens' : 'max_tokens') => (float) $maxTokens,

        ];        
        if (str_starts_with($model, 'o')) {
            unset($data['max_tokens']);
            $data['reasoning_effort'] = $reasoningEffort;
        }

        return $this->makeRequest($url, $data);
    }

    /**
     * Genera embeddings usando la API de OpenAI
     * 
     * @param string $text Texto para generar embeddings
     * @param string|null $model Modelo a usar (opcional)
     * @return array Respuesta de la API
     * @throws Exception Si ocurre un error
     */
    public function createEmbedding(string $text, ?string $model = null): array
    {
        $model = $model ?? 'text-embedding-ada-002';
        $url = $this->apiBase . '/embeddings';

        $data = [
            'input' => $text,
            'model' => $model
        ];

        return $this->makeRequest($url, $data);
    }

    /**
     * Realiza una petición a la API de OpenAI
     * 
     * @param string $url URL del endpoint
     * @param array $data Datos a enviar
     * @return array Respuesta de la API
     * @throws Exception Si ocurre un error
     */
    private function makeRequest(string $url, array $data): array
    {
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        $env = $_ENV['ENVIRONMENT'] ?? getenv('ENVIRONMENT') ?? 'production';
        if ($env === 'production') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }

        curl_close($ch);

        $decodedResponse = json_decode($response, true);

        if ($httpCode >= 400) {
            $errorMessage = $decodedResponse['error']['message'] ?? 'Unknown error';
            throw new Exception("OpenAI API error ($httpCode): $errorMessage");
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response from OpenAI API');
        }

        return $decodedResponse;
    }

    public function makeGetRequest(string $url, array $params = []): array
    {
        $queryString = http_build_query($params);
        $fullUrl = $url . '?' . $queryString;

        $headers = [];
        $headers[] = 'Authorization: Bearer ' . $this->apiKey;
        $headers[] = 'Content-Type: application/json';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        $env = $_ENV['ENVIRONMENT'] ?? getenv('ENVIRONMENT') ?? 'production';
        if ($env === 'production') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
        $decodedResponse = json_decode($response, true);
        if ($httpCode >= 400) {
            $errorMessage = $decodedResponse['error']['message'] ?? 'Unknown error';
            throw new Exception("OpenAI API error ($httpCode): $errorMessage");
        }
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response from OpenAI API');
        }
        return $decodedResponse;

    }
    public function getAvailableModels()
    {
        $url = $this->apiBase . '/models';
        
        $response = $this->makeGetRequest($url, []);

        echo var_dump($response);
    }
}