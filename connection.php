<?php
require __DIR__ . '/envloader.php';
// Load environment variables
$database_host = getenv('DATABASE_HOST');
$database = getenv('DATABASE_NAME');
$username = getenv('DATABASE_USER');
$password = getenv('DATABASE_PASSWORD');

$con = mysqli_connect($database_host, $username, $password, $database);

?>