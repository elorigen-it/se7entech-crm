<?php

namespace Se7entech\Contractnew\Modules\Roles\Models;
use Se7entech\Contractnew\Helpers\EscapeString;

class RolesModel{
    private static $table = 'roles';

    public static function postRole($data){
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "INSERT INTO " . self::$table ." (name, commission) VALUES ('".$data['role-name']."','".$data['role-commission']."')";
        
        return(mysqli_query($con, $sql));
    }

    public static function getAll(){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$table;

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
        $sql = "UPDATE " . self::$table . " SET name='" . $data['role-name'] . "', commission='" . $data['role-commission'] . "' WHERE id=$id";
        return(mysqli_query($con, $sql));
    }

    public static function delete($id){
        include __DIR__ . '/../../../../config/connection.php';

        $sql = "DELETE FROM " . self::$table . " WHERE id=$id";
        $res = mysqli_query($con, $sql);
        return $res;
    }

    public static function getRolesTaxRequired(){
        include __DIR__ . '/../../../../config/connection.php';

        $response = array();
        $sql = "SELECT * FROM " . self::$table . " WHERE tax_required = 1";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($response, $row);
            }
        }
        
        return $response;
    }
}