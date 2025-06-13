<?php

namespace Se7entech\Contractnew\Modules\Appointments\Models;
use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;
use Se7entech\Contractnew\Helpers\EscapeString;

class AppointmentsModel{
    private static $table = 'appointments';
    private static $table_reminders = 'appointments_reminders';

    public static function updateReminder($id, $val, $type){
        include __DIR__ . '/../../../../config/connection.php';
        $sql = "SELECT * FROM ".self::$table_reminders." WHERE id='$id'";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            $sql = "UPDATE ".self::$table_reminders." SET $type = '$val'";
            $res = mysqli_query($con, $sql);
            return $res;

        }else{
            $sql = "INSERT INTO ".self::$table_reminders." (appointment_id, alert_5, alert_30, alert_60) VALUES('$id', '0','0','0')";
            mysqli_query($con, $sql);

            self::updateReminder($id, $val, $type);

        }
    }

    public static function reminderMailed($id, $type){
        include __DIR__ . '/../../../../config/connection.php';

        $sql = "SELECT * FROM ".self::$table_reminders." WHERE id='$id'";
        $res = mysqli_query($con, $sql);
        $rows = mysqli_num_rows($res);
        if($rows){
            $row = mysqli_fetch_assoc($res);
            return (bool) $row[$type];
        }
        return false;
    }

     public static function postAppointment($data, $email = null){
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $data['customer_id'] = isset($data['customer_id']) ? "'".$data['customer_id']."'" : "NULL";
        $data['customer_table'] = isset($data['customer_table']) ? "'".$data['customer_table']."'" : "NULL";
        
        $insert_email = ($email) ? $email : $data['customer_email'];
        $sql = "INSERT INTO " . self::$table ." (subject, customer_email, customer_id, customer_table, date_start, date_end, agent_email, message, notes, status) VALUES ('".$data['subject']."','".$insert_email."', " . $data['customer_id'] . ", '" . $data['customer_table'] . "', STR_TO_DATE('" . $data['date_start'] . "', '%Y-%c-%e %h:%i %p'), STR_TO_DATE('" . $data['date_end'] . "', '%Y-%c-%e %h:%i %p'), '" . $data['agent_email'] . "', '" . $data['message'] . "', '" . $data['notes'] . "', '" . $data['status'] . "')";
        if(mysqli_query($con, $sql)){
            return mysqli_insert_id($con);
        }
        return false;
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

    public static function getAllByZone($zone_id){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT ".self::$table.".*, invoice_user.first_name, invoice_user.designation, invoice_user.zone_id, invoice_user.email FROM " . self::$table . " INNER JOIN invoice_user ON invoice_user.email = ".self::$table.".agent_email WHERE invoice_user.zone_id = '$zone_id' ";
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
        $sql = "UPDATE " . self::$table . " SET subject='" . $data['subject'] . "', customer_email='" . $data['customer_email'] . "',  customer_id='" . $data['customer_id'] . "', customer_table='none', date_start=STR_TO_DATE('" . $data['date_start'] . "', '%Y-%c-%e %h:%i %p'), date_end=STR_TO_DATE('" . $data['date_end'] . "', '%Y-%c-%e %h:%i %p'), agent_email='" . $data['agent_email'] . "', message='" . $data['message'] . "', notes='" . $data['notes'] . "', status='" . $data['status'] . "' WHERE id=$id";
        return(mysqli_query($con, $sql));
    }

    public static function insert_id(){
        include __DIR__ . '/../../../../config/connection.php';
        return mysqli_insert_id($con);
    }

    public static function accept($id){
        include __DIR__ . '/../../../../config/connection.php';
        $sql = "UPDATE appointments set `status`='accepted' WHERE id='$id'";
        return mysqli_query($con, $sql);
    }

    public static function reject($id){
        include __DIR__ . '/../../../../config/connection.php';
        $sql = "UPDATE appointments set `status`='rejected' WHERE id='$id'";
        return mysqli_query($con, $sql);
    }

    public static function getFutureValidAppointments(){
        include __DIR__ . '/../../../../config/connection.php';
        mysqli_query($con, 'set time_zone = "-5:00"');
        $time = time();
        $sql = "SELECT `appointments`.*, `invoice_user`.`designation`, `invoice_user`.`first_name`, `invoice_user`.`avatar` FROM appointments INNER JOIN invoice_user on invoice_user.email = appointments.agent_email WHERE UNIX_TIMESTAMP(appointments.date_start) > $time and appointments.status = 'accepted'";
        $res = mysqli_query($con, $sql);
        $response = array();
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                $customer = CustomersModel::getCustomerV2($row['customer_id']);
                $row['customer_details'] = $customer; 
                array_push($response, $row);
            }
        }

        return $response;
    }

    public static function delete($id){
        include __DIR__ . '/../../../../config/connection.php';

        $sql = "DELETE FROM " . self::$table . " WHERE id=$id";
        $res = mysqli_query($con, $sql);
        return $res;
    }
    
}