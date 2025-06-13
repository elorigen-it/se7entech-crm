<?php
// echo var_dump($_POST);
// exit;
require_once '../ModuleLoader.php';
require_once './routes.php';

$module = new ModuleLoader($routes);
$module->run();
