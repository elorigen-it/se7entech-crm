<?php
namespace Se7entech\Contractnew\Middlewares;

use Se7entech\Contractnew\Middlewares\Middleware;

class CustomerAuthenticationMiddleware implements Middleware {
    public function handle($request) {
        require('../../config/config.php');
        // Authentication logic here
        if (!isset($_SESSION['customer'])) {
            //redirect to login
            header( 'Location: ' . $base_url . '/modules/login/index.php/customer' );
            exit;
        }

        return $request;
    }
}
