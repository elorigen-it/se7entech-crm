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

    public function __construct()
    {
        // Cargar variables de entorno (ajustada la ruta para tu estructura)
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->apiKey = $_ENV['OPENAI_API_KEY'];
        $this->apiBase = $_ENV['OPENAI_API_BASE'] ?? 'https://api.openai.com/v1';
        $this->timeout = (int)($_ENV['OPENAI_TIMEOUT'] ?? 30);
        $this->defaultModel = $_ENV['OPENAI_MODEL'] ?? 'gpt-3.5-turbo';
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
    public function chatCompletion(array $messages, ?string $model = null, float $temperature = 0.7): array
    {
        $model = $model ?? $this->defaultModel;
        $url = $this->apiBase . '/chat/completions';

        $data = [
            'model' => $model,
            'messages' => $messages,
            'temperature' => $temperature,
        ];
        if($model === 'o3-mini'){
            unset($data['temperature']);
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Verificar certificado SSL
        if( $_ENV['ENVIRONMENT'] === 'production' ) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // Verificar el nombre del host
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Desactivar verificación en desarrollo
            curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/cert/cacert.pem'); // Ruta al certificado CA si es necesario
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Verificar certificado SSL
        if( $_ENV['ENVIRONMENT'] === 'production' ) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // Verificar el nombre del host
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Desactivar verificación en desarrollo
            curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . '/cert/cacert.pem'); // Ruta al certificado CA si es necesario
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