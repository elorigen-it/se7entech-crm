<?php


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// DEBUG
// echo "Users Module Index Reached\n";
// var_dump($_SERVER['REQUEST_URI']);
// var_dump($_SERVER['PATH_INFO'] ?? 'NO PATH INFO');
// exit;

require_once '../ModuleLoader.php';
require_once './routes.php';


$module = new ModuleLoader($routes);
$module->run();