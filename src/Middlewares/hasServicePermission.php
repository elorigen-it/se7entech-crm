<?php
namespace Se7entech\Contractnew\Middlewares;

use Se7entech\Contractnew\Middlewares\Middleware;

class hasServicePermission implements Middleware {
    public function handle($request) {
        require('../../config/config.php');
        // Logic here
        if (!isset($_SESSION['user'])) {
            //redirect to login
            header('Location: ' . $base_url );
            exit;
        }
        if($_SESSION['access'] === '0'){
            return $request;
        }

        if($_SESSION['access'] !== '0' && $_SESSION['is_department_responsible'] == false){
            header('Location: ' . $base_url);
            exit;
        }

        return $request;
    }
}