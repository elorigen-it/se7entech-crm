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
    protected static $fillable = [
        'type', 'longitude', 'latitude', 'name', 'image', 
        'phone', 'email', 'address', 'map_link', 'business_name', 
        'notes', 'agent_email', 'status', 'created_at', 'updated_at',
        'old_refference_table', 'old_refference_id'
    ];

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
    // public static function getAll(){
    //     include __DIR__ . '/../../../../config/connection.php';
    //     $response = array();

    //     foreach(self::$tables as $table){
    //         $response[$table] = array();
    //         $sql = "SELECT ";
    //         $iteration = 0;
    //         foreach(self::$mapfields[$table] as $field => $value){
    //             $sql .= $value;
    //             if($iteration < (count(self::$mapfields[$table]) - 1)){
    //                 $sql .= ', ';
    //             }
    //             $iteration++;
    //         }
    //         $sql .= " FROM " . $table;
    //         $res = mysqli_query($con, $sql);

    //         if(mysqli_num_rows($res)){
    //             while($row = mysqli_fetch_assoc($res)){
    //                 array_push($response[$table], self::normalizeFields($table, $row));
    //             }
    //         }          
    //     }
        
    //     return $response;
    // }

    public static function getAll() {
        include __DIR__ . '/../../../../config/connection.php';

        $query = "SELECT * FROM " . self::$newTable;
        $result = $con->query($query);
        
        $records = [];
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
        
        return $records;
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

    public static function getById($id) {
        include __DIR__ . '/../../../../config/connection.php';
        $stmt = $con->prepare("SELECT * FROM " . self::$newTable . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }

    public static function update($id, array $data) {
        include __DIR__ . '/../../../../config/connection.php';
        
        // Filtrar solo los campos permitidos
        $filteredData = array_intersect_key($data, array_flip(self::$fillable));
        
        // Actualizar timestamp
        $filteredData['updated_at'] = date('Y-m-d H:i:s');
        
        // Preparar consulta
        $setParts = [];
        $values = [];
        
        foreach ($filteredData as $column => $value) {
            $setParts[] = "$column = ?";
            $values[] = $value;
        }
        
        $values[] = $id; // Para el WHERE
        
        $query = "UPDATE " . self::$newTable . " SET " . implode(", ", $setParts) . " WHERE id = ?";
        $stmt = $con->prepare($query);
        
        $types = str_repeat('s', count($values)); // Todos como strings
        $stmt->bind_param($types, ...$values);
        
        return $stmt->execute();
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

    public static function create(array $data) {
        include __DIR__ . '/../../../../config/connection.php';

        // Filtrar solo los campos permitidos
        $filteredData = array_intersect_key($data, array_flip(self::$fillable));
        
        // Agregar timestamps
        $now = date('Y-m-d H:i:s');
        $filteredData['created_at'] = $now;
        $filteredData['updated_at'] = $now;
        
        // Preparar consulta
        $columns = implode(", ", array_keys($filteredData));
        $placeholders = implode(", ", array_fill(0, count($filteredData), "?"));
        $values = array_values($filteredData);
        
        $types = str_repeat('s', count($values)); // Todos como strings (MySQL convertirá según tipo de columna)
        
        $query = "INSERT INTO " . self::$newTable . " ($columns) VALUES ($placeholders)";
        $stmt = $con->prepare($query);
        $stmt->bind_param($types, ...$values);
        
        if ($stmt->execute()) {
            return $con->insert_id;
        }
        
        return false;
    }

    public static function delete($id) {
        include __DIR__ . '/../../../../config/connection.php';
        $stmt = $con->prepare("DELETE FROM " . self::$newTable . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }

    public static function getByEmail($email) {
        include __DIR__ . '/../../../../config/connection.php';
        $stmt = $con->prepare("SELECT * FROM " . self::$newTable . " WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }    
}