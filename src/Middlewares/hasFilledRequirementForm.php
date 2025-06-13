<?php
namespace Se7entech\Contractnew\Middlewares;

use Se7entech\Contractnew\Middlewares\Middleware;
use Se7entech\Contractnew\Modules\Roles\Models\RolesModel;

class hasFilledRequirementForm implements Middleware {
    public function handle($request) {
        require_once(__DIR__ . '/../../config/config.php');
        require_once(__DIR__ . '/../../config/connection.php');
    
        global $base_url;
        $roles = RolesModel::getRolesTaxRequired();
        $user_role = $_SESSION['role'];
        $role_applicable = false;
        
        // echo var_dump($_SESSION['is_user_fully_registered']);
        // exit;

        // Logic here
        if (!isset($_SESSION['user'])) {
            //redirect to login
            header('Location: ' . $base_url );
            exit;
        }
        //is admin
        if($_SESSION['access'] === '0'){
            return $request;
        }

        if(count($roles) && $user_role){
            $role_applicable = false;
            foreach($roles as $role){
                if($role['id'] == $user_role){
                    $role_applicable = true;
                }
           }
        }

        if($role_applicable == true && $_SESSION['is_user_fully_registered'] == false){

            header('Location: ' . $base_url . '/modules/users/index.php/taxes/');
            exit;
        }

        return $request;
    }
}