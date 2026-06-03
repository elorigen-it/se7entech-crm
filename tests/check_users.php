<?php
// tests/check_users.php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Modules/Users/Models/UserModel.php';
use Se7entech\Contractnew\Modules\Users\Models\UserModel;

$users = UserModel::getAll();
echo "Found " . count($users) . " users.\n";
foreach ($users as $u) {
    echo "ID: " . $u['id'] . " | Name: " . $u['username'] . " (" . $u['email'] . ")\n";
}
