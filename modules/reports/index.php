<?php
require_once '../ModuleLoader.php';

if (isset($_GET['debug_env'])) {
    header('Content-Type: text/plain');
    echo "=== ENV DEBUG ===\n";
    echo "RESEND_API_KEY: " . (getenv('RESEND_API_KEY') ?: ($_ENV['RESEND_API_KEY'] ?? ($_SERVER['RESEND_API_KEY'] ?? 'NOT FOUND'))) . "\n";
    echo "RESEND_FROM_EMAIL: " . (getenv('RESEND_FROM_EMAIL') ?: ($_ENV['RESEND_FROM_EMAIL'] ?? ($_SERVER['RESEND_FROM_EMAIL'] ?? 'NOT FOUND'))) . "\n";
    echo "RESEND_FROM_NAME: " . (getenv('RESEND_FROM_NAME') ?: ($_ENV['RESEND_FROM_NAME'] ?? ($_SERVER['RESEND_FROM_NAME'] ?? 'NOT FOUND'))) . "\n";
    echo "SMTP_DEFAULT_USERNAME: " . (getenv('SMTP_DEFAULT_USERNAME') ?: ($_ENV['SMTP_DEFAULT_USERNAME'] ?? ($_SERVER['SMTP_DEFAULT_USERNAME'] ?? 'NOT FOUND'))) . "\n";
    echo "ENVIRONMENT: " . (getenv('ENVIRONMENT') ?: ($_ENV['ENVIRONMENT'] ?? ($_SERVER['ENVIRONMENT'] ?? 'NOT FOUND'))) . "\n";
    echo "=== FILES CHECK ===\n";
    echo "envloader.php path: " . realpath(__DIR__ . '/../envloader.php') . " (Exists: " . (file_exists(__DIR__ . '/../envloader.php') ? 'YES' : 'NO') . ")\n";
    echo ".env path: " . realpath(__DIR__ . '/../../.env') . " (Exists: " . (file_exists(__DIR__ . '/../../.env') ? 'YES' : 'NO') . ")\n";
    exit;
}

require_once './routes.php';

$module = new ModuleLoader($routes);
$module->run();
