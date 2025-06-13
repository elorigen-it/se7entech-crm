<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../ModuleLoader.php';
require_once './routes.php';

$module = new ModuleLoader($routes);
$module->run();