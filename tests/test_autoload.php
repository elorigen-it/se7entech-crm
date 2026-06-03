<?php
require_once __DIR__ . '/vendor/autoload.php';

use Se7entech\Contractnew\Middlewares\JWTMiddleware;

echo "Testing Autoload...\n";
if (class_exists(JWTMiddleware::class)) {
    echo "Class exists!\n";
    try {
        $x = new JWTMiddleware();
        echo "Instantiated successfully (it might fail due to constructor logic check headers, but class is found)\n";
    } catch (Exception $e) {
        echo "Constructor threw exception (expected if default keys logic runs): " . $e->getMessage() . "\n";
    }
} else {
    echo "Class NOT found.\n";
}
