<?php
namespace Se7entech\Contractnew\Middlewares;

use Se7entech\Contractnew\Middleware;
class LoggingMiddleware implements Middleware {
    public function handle($request) {
        require('../../config/config.php');
        // Lógica de registro aquí
        // Ejemplo: Registrar la información de la solicitud en un archivo o base de datos
        $logMessage = sprintf(
            "Request received - URL: %s, Method: %s",
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD']
        );

        // Guardar el mensaje de registro en un archivo de registro
        file_put_contents('log.txt', $logMessage . PHP_EOL, FILE_APPEND);

        return $request;
    }
}