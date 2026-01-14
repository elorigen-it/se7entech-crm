<?php

namespace Se7entech\Contractnew\Middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTMiddleware
{
    private $publicKey;

    public function __construct()
    {
        $keyPath = __DIR__ . '/../../config/keys/public.pem';
        if (!file_exists($keyPath)) {
            throw new Exception("Public key not found.");
        }
        $this->publicKey = file_get_contents($keyPath);
    }

    public function handle($request)
    {
        $headers = getallheaders();
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

        if (!$authHeader && isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        }


        if (!$authHeader) {
            $this->unauthorized("Authorization header validation failed.");
        }

        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $jwt = $matches[1];
            try {
                $decoded = JWT::decode($jwt, new Key($this->publicKey, 'RS256'));

                // Populate Session for Legacy Controllers
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                if (isset($decoded->data)) {
                    $userid = $decoded->data->userid ?? null;

                    if ($userid) {
                        // Fetch user data from database (source of truth)
                        require_once __DIR__ . '/../Modules/Users/Models/UserModel.php';
                        $userData = \Se7entech\Contractnew\Modules\Users\Models\UserModel::getById($userid);

                        if ($userData) {
                            $_SESSION['userid'] = $userid;
                            $_SESSION['access'] = $userData['access'] ?? '0'; // From DB
                            $_SESSION['user'] = $userData['username'] ?? ($decoded->data->user ?? 'API User');
                        } else {
                            // User not found in DB
                            $this->unauthorized("User ID $userid not found in database");
                        }
                    } else {
                        // No userid in token, fallback to token data (for backward compatibility)
                        $_SESSION['access'] = $decoded->data->access ?? '0';
                        $_SESSION['userid'] = 1;
                        $_SESSION['user'] = $decoded->data->user ?? 'API User';
                    }
                }

                return $request;
            } catch (Exception $e) {
                $this->unauthorized("Token invalid: " . $e->getMessage());
            }
        } else {
            $this->unauthorized("Token not found in request.");
        }

        return $request;
    }

    private function unauthorized($message)
    {
        header('HTTP/1.0 401 Unauthorized');
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Unauthorized', 'message' => $message]);
        exit;
    }
}
