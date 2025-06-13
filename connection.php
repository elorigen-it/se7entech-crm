<?php
require './envloader.php';
// Load environment variables
$database = getenv('DATABASE');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');

$con = mysqli_connect('localhost', $username, $password, $database);
?>