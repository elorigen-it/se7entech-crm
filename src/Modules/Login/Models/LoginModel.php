<?php
namespace Se7entech\Contractnew\Modules\Login\Models;

use Se7entech\Contractnew\Helpers\EscapeString;
use Exception;

class LoginModel{
    private static $customerAccess = 'customer_access';
    private static $customerTable = 'customers';
    private static $userTable = 'invoice_user';

    public static function loginCustomer($data){
        include __DIR__ . '/../../../../config/connection.php';
        $response = false;

        $sql = "SELECT " . self::$customerTable.".type, ".
            self::$customerTable.".name, ".
            self::$customerTable.".business_name, ".
            self::$customerTable.".image, ".
            self::$customerAccess .".* FROM ". 
            self::$customerAccess .
            " JOIN ".
            self::$customerTable . " ON " . self::$customerTable . ".id = " . self::$customerAccess . ".customer_id".
            " WHERE username='". 
            $data['username']. 
            "' AND `password` = '" .
            $data['password'] . "'";
                    
        $res = mysqli_query($con, $sql);

        if(mysqli_num_rows($res)){
            $row = mysqli_fetch_assoc($res);
            $response = $row;
        }

        return $response;
    }
}