<?php

namespace Se7entech\Contractnew\Modules\Login\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController{
    public function __construct(Session $session){
        global $base_url, $base_path;
        $this->base_url = $base_url;
        $this->base_path = $base_path;
        $this->session = $session;
        chdir($this->base_path);
    }

    public function index(){
        header('Location: ../../dashboard.php');
    }
}