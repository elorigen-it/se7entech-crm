<?php

namespace Se7entech\Contractnew\Modules\Services\Models;
use Se7entech\Contractnew\Helpers\EscapeString;

class ServicesModel{
    private static $table = 'services';

    public static function postService($data){
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "INSERT INTO " . self::$table ." (name, price, description, department_id) VALUES ('".$data['service-name']."','".$data['service-price']."','".$data['service-description']."','".$data['department']."')";
        
        return(mysqli_query($con, $sql));
    }

    public static function getAll(){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT " . self::$table . ".id, " . self::$table . ".name, " . self::$table . ".price, "  . self::$table . ".description, " . self::$table . ".department_id, departments.name as department_name FROM " . self::$table . " JOIN departments ON departments.id = " . self::$table . ".department_id";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($response, $row);
            }
        }
        
        return $response;
    }
    public static function getUserServices($user_id){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT " . self::$table . ".id, " . self::$table . ".name, " . self::$table . ".price, "  . self::$table . ".description, " . self::$table . ".department_id, departments.name as department_name FROM " . self::$table . " JOIN departments ON departments.id = " . self::$table . ".department_id JOIN invoice_user ON invoice_user.id = departments.responsible_id WHERE departments.responsible_id = $user_id";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($response, $row);
            }
        }
        
        return $response;
    }

    public static function getById($id){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$table . " WHERE id=$id";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            return mysqli_fetch_assoc($res);
        }
        
        return false;
    }

    public static function update($id, $data){
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        
        $sql = "UPDATE " . self::$table . " SET name='" . $data['service-name'] . "', price='" . $data['service-price'] . "', description='" . $data['service-description']. "', department_id='" . $data['department'] . "' WHERE id=$id";
        return(mysqli_query($con, $sql));
    }

    public static function delete($id){
        include __DIR__ . '/../../../../config/connection.php';

        $sql = "DELETE FROM " . self::$table . " WHERE id=$id";
        $res = mysqli_query($con, $sql);
        return $res;
    }
}