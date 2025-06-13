<?php

namespace Se7entech\Contractnew\Modules\Departments\Models;
use Se7entech\Contractnew\Helpers\EscapeString;

class DepartmentsModel{
    private static $table = 'departments';

    public static function postDepartment($data){
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "INSERT INTO " . self::$table ." (name, responsible_id) VALUES ('".$data['department-name']."','".$data['department-responsible']."')";
        
        return(mysqli_query($con, $sql));
    }

    public static function getAll(){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT ".self::$table.".id, ".self::$table.".name, ".self::$table.".responsible_id, invoice_user.id as responsible_id, invoice_user.first_name, invoice_user.last_name, invoice_user.designation FROM " . self::$table . " JOIN invoice_user ON invoice_user.id=" . self::$table . ".responsible_id";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($response, $row);
            }
        }
        
        return $response;
    }

    public static function getUserDepartment($user_id){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT ".self::$table.".id, ".self::$table.".name, ".self::$table.".responsible_id, invoice_user.id as responsible_id, invoice_user.first_name, invoice_user.last_name, invoice_user.designation FROM " . self::$table . " JOIN invoice_user ON invoice_user.id=" . self::$table . ".responsible_id WHERE " . self::$table . ".responsible_id = $user_id";

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
        $sql = "UPDATE " . self::$table . " SET name='" . $data['department-name'] . "', responsible_id='" . $data['department-responsible'] . "' WHERE id=$id";
        return(mysqli_query($con, $sql));
    }

    public static function delete($id){
        include __DIR__ . '/../../../../config/connection.php';

        $sql = "DELETE FROM " . self::$table . " WHERE id=$id";
        $res = mysqli_query($con, $sql);
        return $res;
    }
}