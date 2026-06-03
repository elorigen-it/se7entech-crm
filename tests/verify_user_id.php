<?php
// tests/verify_user_1.php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Modules/Users/Models/UserModel.php';
use Se7entech\Contractnew\Modules\Users\Models\UserModel;

$user = UserModel::getById(1);
var_dump($user);

if ($user) {
    echo "User 1 Found. ID: " . $user['id'] . "\n";
} else {
    echo "User 1 NOT Found\n";
    // Check first available
    $all = UserModel::getAll();
    if (count($all) > 0) {
        echo "First available user ID: " . $all[0]['id'] . "\n";
    }
}
