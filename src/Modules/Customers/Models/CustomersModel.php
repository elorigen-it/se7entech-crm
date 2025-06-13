<?php
namespace Se7entech\Contractnew\Modules\Customers\Models;

use Se7entech\Contractnew\Helpers\EscapeString;
use Exception;

class CustomersModel{
    private static $newTable = 'customers';
    private static $tables = array('clients', 'colleges', 'lead');
    private static $mapfields = array(
        'clients' => array(
            'id' => 'id',
            'name' => 'name',
            'business_name' => 'businessname',
            'email' => 'email',
            'phone' => 'phone'
        ),
        'colleges' => array(
            'id' => 'id',
            'name' => 'client_name',
            'business_name' => 'client_name',
            'email' => 'email',
            'phone' => 'phone'
        ),
        'lead' => array(
            'id' => 'id',
            'name' => 'name',
            'business_name' => 'businessname',
            'email' => 'email',
            'phone' => 'phone'
        )
    );
    private static $finalfields = array(
        'id', 'name', 'business_name', 'email', 'phone'
    );

    public static function getCustomersFromAgent($email){
        include __DIR__ . '/../../../../config/connection.php';
        
        $sql = "SELECT * FROM ". self::$newTable ." WHERE agent_email='$email'";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            $response = array();
            while($row = mysqli_fetch_assoc($res)){
                $response[] = $row;
            }
        }  
        return $response;
    }
    public static function getAll(){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();

        foreach(self::$tables as $table){
            $response[$table] = array();
            $sql = "SELECT ";
            $iteration = 0;
            foreach(self::$mapfields[$table] as $field => $value){
                $sql .= $value;
                if($iteration < (count(self::$mapfields[$table]) - 1)){
                    $sql .= ', ';
                }
                $iteration++;
            }
            $sql .= " FROM " . $table;
            $res = mysqli_query($con, $sql);

            if(mysqli_num_rows($res)){
                while($row = mysqli_fetch_assoc($res)){
                    array_push($response[$table], self::normalizeFields($table, $row));
                }
            }          
        }
        
        return $response;
    }

    public static function getAllV2(){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();

        $sql = "SELECT * FROM ". self::$newTable;
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            $response = array();
            while($row = mysqli_fetch_assoc($res)){
                $response[] = $row;
            }
        }  
        return $response;
        
    }
    
    public static function getCustomer($table, $id){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM $table WHERE id='$id'";
        $res = mysqli_query($con, $sql);
        
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                $response = self::normalizeFields($table, $row);
            }
        }  
        return $response;
    }
    public static function getCustomerV2($id){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$newTable ." WHERE id='$id'";
        $res = mysqli_query($con, $sql);
        
        if(mysqli_num_rows($res)){
            $response = mysqli_fetch_assoc($res);
        }  
        return $response;
    }

    public static function getClients(){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$newTable ." WHERE type='customer'";
        $res = mysqli_query($con, $sql);
        
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($response, $row);
            }
        }
        
        return $response;
    }

    public static function mapFields($table, $field){
        return self::$mapfields[$table][$field];
    }

    public static function normalizeFields($table, $row){
        $res = array();
        foreach(self::$finalfields as $field ){
            $res[$field] = $row[self::mapFields($table, $field)];
        }
        return $res;
    }

    public static function createCustomer($data){
        include __DIR__ . '/../../../../config/connection.php';

        if (!$con) {
            throw new Exception("Error: Conexión a la base de datos no válida.");
        }
        
        $sql = "INSERT INTO clients (name, phone, address, email, notes, businessname, logid, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, 0)";

        //$sql = "INSERT INTO customers (type, name, phone, address, email, notes, business_name, status, agent_email)
                //VALUES ('customer', ?, ?, ?, ?, ?, ?, 0, ?)";
        
        $data = EscapeString::escapeArray($con, $data);
        
        $stmt = mysqli_prepare($con, $sql);
        
        if (!$stmt) {
            $errorMessage = "Error al preparar la consulta: " . mysqli_error($con);
            error_log($errorMessage, 3, "error_log.txt");
            throw new Exception($errorMessage);
        }
        
        mysqli_stmt_bind_param($stmt, "sssssss", $data['name'], $data['phone'], $data['address'], $data['email'], $data['notes'], $data['businessname'], $data['agent_email']);

        $success = mysqli_stmt_execute($stmt);
        
        if ($success) {
            $newCustomerId = $con->insert_id;
            self::createClient($con, $data);
            return $newCustomerId;
        } else {
            $errorMessage = "Error al crear el customer: " . mysqli_error($con);
            error_log($errorMessage, 3, "error_log.txt");
            throw new Exception($errorMessage);
        }
    }
    
    public static function createClient($con, $data){
        //$sql = "INSERT INTO clients (name, phone, address, email, notes, businessname, logid, status)
                //VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
        
        $sql = "INSERT INTO customers (type, name, phone, address, email, notes, business_name, status, agent_email)
            VALUES ('customer', ?, ?, ?, ?, ?, ?, 0, ?)";
        
        $data = EscapeString::escapeArray($con, $data);
        
        $stmt = mysqli_prepare($con, $sql);
        
        if (!$stmt) {
            $errorMessage = "Error al preparar la consulta: " . mysqli_error($con);
            error_log($errorMessage, 3, "error_log.txt");
            throw new Exception($errorMessage);
        }
        
        mysqli_stmt_bind_param($stmt, "sssssss", $data['name'], $data['phone'], $data['address'], $data['email'], $data['notes'], $data['businessname'], $data['agent_email']);
        
        $success = mysqli_stmt_execute($stmt);
        
        if (!$success) {
            $errorMessage = "Error al crear el cliente: " . mysqli_error($con);
            error_log($errorMessage, 3, "error_log.txt");
            throw new Exception($errorMessage);
        }
    }
}