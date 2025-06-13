<?php

namespace Se7entech\Contractnew\Modules\Invoices\Models;

class InvoiceModel{
    private static $table = 'invoice_order';

    public static function getAll($logid=null){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$table;
        if($logid){
            $sql .= " WHERE logid = $logid";
        }
        // echo var_dump($sql);
        
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
        $sql = "SELECT * FROM " . self::$table . " WHERE order_id = $id";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            $response = mysqli_fetch_assoc($res); 
        }
        
        return $response;
    }


}