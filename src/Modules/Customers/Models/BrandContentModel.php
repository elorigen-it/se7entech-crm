<?php
namespace Se7entech\Contractnew\Modules\Customers\Models;

use Se7entech\Contractnew\Helpers\EscapeString;
use Exception;

class BrandContentModel{
    private static $table = 'brand_content';    
    protected static $fillable = [
        'customer_id', 'name', 'content'
    ];

    public static function getBrandContentByCustomerId($customerId){
        include __DIR__ . '/../../../../config/connection.php';
        
        $customerId = EscapeString::escapeValue($con, $customerId);
        $sql = "SELECT * FROM ". self::$table ." WHERE customer_id='$customerId'";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            $response = array();
            while($row = mysqli_fetch_assoc($res)){
                $response[] = $row;
            }
            return $response;
        }  
        return [];
    }

    public static function getById($id){
        include __DIR__ . '/../../../../config/connection.php';

        $id = EscapeString::escapeValue($con, $id);
        $sql = "SELECT * FROM ". self::$table ." WHERE id='$id'";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            return mysqli_fetch_assoc($res);
        }
        return null;
    }

    public static function addBrandContentToCustomer($customerId, $ruleName, $ruleContent){
        include __DIR__ . '/../../../../config/connection.php';

        $customerId = EscapeString::escapeValue($con, $customerId);
        $ruleName = EscapeString::escapeValue($con, $ruleName);
        $ruleContent = EscapeString::escapeValue($con, $ruleContent);

        $sql = "INSERT INTO " . self::$table . " (customer_id, name, content) VALUES ('$customerId', '$ruleName', '$ruleContent')";
        if(mysqli_query($con, $sql)){
            return true;
        }
        return false;
    }

    public static function updateBrandContent($id, $name, $content){
        include __DIR__ . '/../../../../config/connection.php';

        $id = EscapeString::escapeValue($con, $id);
        $name = EscapeString::escapeValue($con, $name);
        $content = EscapeString::escapeValue($con, $content);

        $sql = "UPDATE " . self::$table . " SET name='$name', content='$content' WHERE id='$id'";
        if(mysqli_query($con, $sql)){
            return true;
        }
        return false;
    }

    public static function deleteBrandContent($id){
        include __DIR__ . '/../../../../config/connection.php';

        $id = EscapeString::escapeValue($con, $id);
        $sql = "DELETE FROM " . self::$table . " WHERE id='$id'";
        if(mysqli_query($con, $sql)){
            return true;
        }
        return false;
    }
}
