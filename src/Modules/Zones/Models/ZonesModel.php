<?php

namespace Se7entech\Contractnew\Modules\Zones\Models;
use Se7entech\Contractnew\Helpers\EscapeString;

class ZonesModel{
    private static $table = 'zones';

    public static function postZone($data){
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "INSERT INTO " . self::$table ." (name, code) VALUES ('".$data['zone-name']."','".$data['zone-code']."')";
        
        return(mysqli_query($con, $sql));
    }

    public static function getAll(){
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
        $sql = "UPDATE " . self::$table . " SET name='" . $data['zone-name'] . "', code='" . $data['zone-code'] . "' WHERE id=$id";
        return(mysqli_query($con, $sql));
    }

    public static function delete($id){
        include __DIR__ . '/../../../../config/connection.php';

        $sql = "DELETE FROM " . self::$table . " WHERE id=$id";
        $res = mysqli_query($con, $sql);
        return $res;
    }
}