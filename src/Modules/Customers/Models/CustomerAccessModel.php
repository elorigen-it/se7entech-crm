<?php
namespace Se7entech\Contractnew\Modules\Customers\Models;

use Se7entech\Contractnew\Helpers\EscapeString;
use Exception;

class CustomerAccessModel{
    private static $table = 'customer_access';
    protected static $fillable = [
        'customer_id', 'username', 'password', 'active'
    ];

    public static function getAccessByCustomerId($customer_id){
        include __DIR__ . '/../../../../config/connection.php';
        
        $sql = "SELECT * FROM ". self::$table ." WHERE customer_id='$customer_id'";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            $response = array();
            while($row = mysqli_fetch_assoc($res)){
                $response[] = $row;
            }
        }  
        return $response;
    }
    
    public static function getAll() {
        include __DIR__ . '/../../../../config/connection.php';

        $query = "SELECT customers.name, customers.business_name, customers.email as customer_email, " . self::$table . ".* FROM " . self::$table . " LEFT JOIN customers ON customers.id = " . self::$table . ".customer_id";
        $result = $con->query($query);
        
        $records = [];
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
        
        return $records;
    }

    public static function getById($id) {
        include __DIR__ . '/../../../../config/connection.php';
        $stmt = $con->prepare("SELECT * FROM " . self::$table . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }

    public static function update($id, array $data) {
        include __DIR__ . '/../../../../config/connection.php';
        
        // Filtrar solo los campos permitidos
        $filteredData = array_intersect_key($data, array_flip(self::$fillable));
        
        // Preparar consulta
        $setParts = [];
        $values = [];
        
        foreach ($filteredData as $column => $value) {
            $setParts[] = "$column = ?";
            $values[] = $value;
        }
        
        $values[] = $id; // Para el WHERE
        
        $query = "UPDATE " . self::$table . " SET " . implode(", ", $setParts) . " WHERE id = ?";
        $stmt = $con->prepare($query);
        
        $types = str_repeat('s', count($values)); // Todos como strings
        $stmt->bind_param($types, ...$values);
        
        return $stmt->execute();
    }
    

    public static function create(array $data) {
        include __DIR__ . '/../../../../config/connection.php';

        // Filtrar solo los campos permitidos
        $filteredData = array_intersect_key($data, array_flip(self::$fillable));
        
        if (isset($filteredData['password'])) {
            $filteredData['password'] = hash('sha256', $filteredData['password']);
        }
        
        // Preparar consulta
        $columns = implode(", ", array_keys($filteredData));
        $placeholders = implode(", ", array_fill(0, count($filteredData), "?"));
        $values = array_values($filteredData);
        
        $types = str_repeat('s', count($values)); // Todos como strings (MySQL convertirá según tipo de columna)
        
        $query = "INSERT INTO " . self::$table . " ($columns) VALUES ($placeholders)";
        $stmt = $con->prepare($query);
        $stmt->bind_param($types, ...$values);
        
        try {
            if ($stmt->execute()) {
            return array('record_id' => $con->insert_id);
            }
            if ($stmt->error) {
            return $stmt->error;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
        return false;
    }

    public static function delete($id) {
        include __DIR__ . '/../../../../config/connection.php';
        $stmt = $con->prepare("DELETE FROM " . self::$table . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }

    public static function deleteByCustomerID($customer_id) {
        include __DIR__ . '/../../../../config/connection.php';
        $stmt = $con->prepare("DELETE FROM " . self::$table . " WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);
        
        return $stmt->execute();
    }

    public static function getByUsername($username) {
        include __DIR__ . '/../../../../config/connection.php';
        $stmt = $con->prepare("SELECT * FROM " . self::$table . " WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }    
}