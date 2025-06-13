<?php

namespace Se7entech\Contractnew\Modules\Contract\Models;
use Se7entech\Contractnew\Helpers\EscapeString;

class ContractModel{
    private static $table = 'contract';
    private static $tableitems = 'contractitem';
    private static $table_gracetime = 'contract_gracetime';

    public static function postContract($data){
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "INSERT INTO " . self::$table ." (agent_id, customer_id, agent_name_1, agent_name_2, customer_name_1, customer_name_2, customer_name_3, company_name_1, company_name_2, contract_date_start, contract_date_end, services, maintenance_period, shipping_handling, sale_tax, total_purchase, additional_deposit, payment_date, dues_after_deposit, contract_sign_date_agent, contract_sign_date_customer, customer_sign, agent_sign) VALUES ('".$data['agent_id']."','".$data['customer_id_input']."','".$data['agent_name_1']."','".$data['agent_name_2']."','".$data['customer_name_1']."','".$data['customer_name_2']."','".$data['customer_name_3']."','".$data['company_name_1']."','".$data['company_name_2']."','".$data['contract_date_start']."','".$data['contract_date_end']."','".$data['services']."','".$data['maintenance_period']."','".$data['shipping_handling']."','".$data['sale_tax']."','".$data['total_purchase']."','".$data['additional_deposit']."','".$data['payment_date']."','".$data['dues_after_deposit']."','".$data['contract_sign_date_agent']."','".$data['contract_sign_date_customer']."','".$data['customer_sign']."','".$data['agent_sign']."')";
        
        $result = mysqli_query($con, $sql);

        if($result) {
            $last_inserted_id = mysqli_insert_id($con);
            self::insertGraceTime($last_inserted_id, $data['maintenance_period']);
        }

        return $result;
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

    public static function getContractsFromAgent($agent_id){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$table . " WHERE agent_id=$agent_id";

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

    public static function getItems($rand){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$tableitems . " WHERE rand=$rand";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($response, $row);
            }
        }
        
        return $response;
    }

    public static function update($id, $data){
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET agent_id='" . $data['agent_id'] . "', customer_id='" . $data['customer_id_input'] . "', agent_name_1='" . $data['agent_name_1'] . "', agent_name_2='" . $data['agent_name_2'] . "', customer_name_1='" . $data['customer_name_1'] . "', customer_name_2='" . $data['customer_name_2'] . "', customer_name_3='" . $data['customer_name_3'] . "', company_name_1='" . $data['company_name_1'] . "', company_name_2='" . $data['company_name_2'] . "', contract_date_start='" . $data['contract_date_start'] . "', contract_date_end='" . $data['contract_date_end'] . "', services='" . $data['services'] . "', maintenance_period='" . $data['maintenance_period'] . "', shipping_handling='" . $data['shipping_handling'] . "', sale_tax='" . $data['sale_tax'] . "', total_purchase='" . $data['total_purchase'] . "', additional_deposit='" . $data['additional_deposit'] . "', payment_date='" . $data['payment_date'] . "', dues_after_deposit='" . $data['dues_after_deposit'] . "', contract_sign_date_agent='" . $data['contract_sign_date_agent'] . "', contract_sign_date_customer='" . $data['contract_sign_date_customer'] . "', customer_sign='" . $data['customer_sign'] . "', agent_sign='" . $data['agent_sign'] . "' WHERE id=$id";
        
        return(mysqli_query($con, $sql));
    }

    public static function delete($id){
        include __DIR__ . '/../../../../config/connection.php';

        $sql = "DELETE FROM " . self::$table . " WHERE id=$id";
        $res = mysqli_query($con, $sql);
        return $res;
    }

    public static function getAssociatedInvoices($id){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$table . " JOIN contract_invoices ON " . self::$table . ".id = contract_invoices.contract_id WHERE ".self::$table.".id=$id";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($response, $row);
            }
        }
        
        return $response;
    }

    public static function attachInvoices($contractid, $invoicesids){
        include __DIR__ . '/../../../../config/connection.php';
        $sql1 = "DELETE FROM contract_invoices WHERE contract_id = '$contractid'";
        $res1 = mysqli_query($con, $sql1);
        // echo var_dump($contractid);
        // echo var_dump($invoicesids);
        foreach($invoicesids as $invoiceid){
            $sql2 = "INSERT INTO contract_invoices (contract_id, invoice_id) VALUES ('$contractid', '$invoiceid')";
            $res2 = mysqli_query($con, $sql2);
        }
        return $res2;
    }

    public static function insertGraceTime($contractid, $gracetime){
        $days = convertGracetime($gracetime);
        
        $sql = "INSERT INTO " . self::$table_gracetime ." (contract_id, grace_time) VALUES ('".$contractid."','".$days."')";

        return mysqli_query($con, $sql);
    }
    
    public static function convertGracetime($gracetime) {
        $gracetime = strtolower($gracetime);

        // Definimos un array asociativo para mapear las unidades de tiempo a sus valores en días
        $units_time = [
            'día' => 1,
            'días' => 1,
            'dia' => 1,
            'dias' => 1,
            'd' => 1,
            'day' => 1,
            'days' => 1,
            'semana' => 7,
            'semanas' => 7,
            'week' => 7,
            'weeks' => 7,
            'mes' => 30,
            'meses' => 30,
            'month' => 30,
            'months' => 30,
            'año' => 365,
            'años' => 365,
            'year' => 365,
            'years' => 365,
        ];
    
        // Expresión regular para encontrar números y unidades de tiempo en el texto
        $regex = '/(\d+)\s*(' . implode('|', array_keys($units_time)) . ')/';
    
        $days = 0;
    
        preg_match_all($regex, $gracetime, $matches, PREG_SET_ORDER);
    
        foreach ($matches as $match) {
            // Obtenemos la cantidad y la unidad de tiempo
            $quantity = intval($match[1]);
            $unit = $match[2];
            
            // Sumamos al total de días la cantidad multiplicada por el valor en días de la unidad
            if (array_key_exists($unit, $units_time)) {
                $days += $quantity * $units_time[$unit];
            }
        }
        
        return $days;
    }
}