<?php
namespace Se7entech\Contractnew\Middlewares;

use Se7entech\Contractnew\Middlewares\Middleware;

class AuthenticationMiddleware implements Middleware {
    public function handle($request) {
        require('../../config/config.php');
        // Authentication logic here
        if (!isset($_SESSION['user'])) {
            //redirect to login
            header( 'Location: ' . $base_url );
            exit;
        }

        return $request;
    }
}
