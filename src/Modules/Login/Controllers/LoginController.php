<?php

namespace Se7entech\Contractnew\Modules\Login\Controllers;

use Se7entech\Contractnew\Modules\Login\Models\LoginModel;
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

    public function indexCustomer(){
        $loginError = '';
        include __DIR__ . '/../customer_login.php';
    }

    public function loginCustomer(){
        // Logica para login
        $request = Request::createFromGlobals();
        $data = $request->request->all();
        $data['password'] = hash('sha256', $data['password']);

        if (!empty($data['username']) && !empty($data['password'])) {
            
            $login = LoginModel::loginCustomer($data);

            if($login) {
                $_SESSION['customer'] = $login['name']." - ".$login['business_name'];
                $_SESSION['customer_id'] = $login['customer_id'];
                $_SESSION['username'] = $login['username'];        
                $_SESSION['type'] = $login['type'];
                $_SESSION['active'] = $login['active'];
                $_SESSION['image'] = $login['image'];
                
                header('Location: ' . $this->base_url . '/modules/dashboard/index.php/customer');
                exit();
                // header("Location:dashboard.php");
            } else {
                $this->session->getFlashBag()->add('error', 'Invalid email or password!');
            }
        }

        header('Location: ' . $this->base_url . '/modules/login/index.php/customer');
    }
}