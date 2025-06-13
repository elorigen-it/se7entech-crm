<?php

namespace Se7entech\Contractnew\Modules\Tasks\Models;

use Se7entech\Contractnew\Helpers\EscapeString;

class TaskModel{
    private static $table = 'tasks';
    private static $taskLabelTable = 'task_labels';
    // This table is used to link tasks with labels
    private static $taskLablesTasks = 'task_labels_tasks';

    public static function getAll(){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT 
            tasks.id, 
            tasks.customer_tempname, 
            tasks.asigned_to, 
            tasks.name, 
            tasks.description, 
            tasks.status, 
            tasks.start_time, 
            tasks.end_time, 
            tasks.pause_intervals, 
            tasks.total_pauses, 
            tasks.total_time, 
            tasks.created_at, 
            invoice_user.email, 
            invoice_user.first_name, 
            invoice_user.last_name,
            GROUP_CONCAT(" . self::$taskLabelTable . ".id) AS labels
            FROM " . self::$table . "
            JOIN invoice_user ON tasks.asigned_to = invoice_user.id
            LEFT JOIN " . self::$taskLablesTasks . " ON tasks.id = " . self::$taskLablesTasks . ".id_task
            LEFT JOIN " . self::$taskLabelTable . " ON " . self::$taskLablesTasks . ".id_task_label = " . self::$taskLabelTable . ".id
            GROUP BY tasks.id
            ORDER BY tasks.id ASC";
        $res = mysqli_query($con, $sql);        
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($response, $row);
            }
        }
        
        return $response;
    } 

    public static function getById($id){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';

        $response = array();
        $sql = "SELECT 
                tasks.id, 
                tasks.customer_tempname, 
                tasks.customer_id, 
                tasks.asigned_to, 
                tasks.name, 
                tasks.description, 
                tasks.status, 
                tasks.start_time, 
                tasks.end_time, 
                tasks.pause_intervals, 
                tasks.pause_reasons, 
                tasks.total_pauses, 
                tasks.total_time, 
                tasks.created_at, 
                invoice_user.email, 
                invoice_user.first_name, 
                invoice_user.last_name, 
                customers.name as customer_name, 
                customers.business_name as customer_business_name,
                GROUP_CONCAT(" . self::$taskLabelTable . ".id) AS labels
            FROM " . self::$table . "
            JOIN invoice_user ON tasks.asigned_to = invoice_user.id
            JOIN customers ON tasks.customer_id = customers.id
            LEFT JOIN " . self::$taskLablesTasks . " ON tasks.id = " . self::$taskLablesTasks . ".id_task
            LEFT JOIN " . self::$taskLabelTable . " ON " . self::$taskLablesTasks . ".id_task_label = " . self::$taskLabelTable . ".id";
        $sql .= " WHERE tasks.id='" . $id . "' GROUP BY tasks.id ORDER BY tasks.created_at DESC";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($response, $row);
            }
        }
        
        return $response;
    } 

    public static function postTask($data){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "INSERT INTO " . self::$table ." (asigned_to, name, status, customer_id, description, customer_tempname ) VALUES ('".$data['task-user']."','".$data['task-name']."','created', '".$data['customer-id']."','".$data['task-description']."','". $data['customer-tempname'] ."')";
        
        $result = mysqli_query($con, $sql);

        if($result){
            $insertedTaskId = mysqli_insert_id($con);

            if( isset($data['task-labels']) && is_array($data['task-labels']) && (count($data['task-labels']) > 0)){
                // Ensure task labels are escaped and inserted
                $data['task-labels'] = $data['task-labels'];
            } else {
                $data['task-labels'] = array();
            }
            
            foreach($data['task-labels'] as $label){
                $sql = "INSERT INTO " . self::$taskLablesTasks . " (id_task, id_task_label) VALUES (".$insertedTaskId.", '$label')";
                mysqli_query($con, $sql);
            }
        }

        return array('success' => $result, 'id' => $insertedTaskId);
    }

    public static function updateTask($id, $data){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET name='" . $data['task-name'] . "', description='" . $data['task-description'] . "', asigned_to='" . $data['task-user'] . "', customer_id='".$data['customer-id']."', customer_tempname='".$data['customer-tempname']."' WHERE id=$id";
        $result = mysqli_query($con, $sql);
        if(!$result){
            return false; // If the update fails, return false
        }
        // If the update is successful, we proceed to handle labels
        // delete all labels for this task, then insert new ones
        $deleteLabelsSql = "DELETE FROM " . self::$taskLablesTasks . " WHERE id_task=$id";
        mysqli_query($con, $deleteLabelsSql);
        if(isset($data['task-labels']) && is_array($data['task-labels']) && (count($data['task-labels']) > 0)){
            // Ensure task labels are escaped and inserted
            $data['task-labels'] = $data['task-labels'];
        } else {
            $data['task-labels'] = array();
        }
        foreach($data['task-labels'] as $label){
            $sql = "INSERT INTO " . self::$taskLablesTasks . " (id_task, id_task_label) VALUES ($id, '$label')";
            mysqli_query($con, $sql);
        }
        
        return $result;
    }

    public static function pauseTask($id, $data){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET pause_intervals='".$data['pause_intervals']."', pause_reasons='".$data['pause_reasons']."', status='".$data['status']."' WHERE id=$id";
        
        return(mysqli_query($con, $sql));
    }

    public static function resumeTask($id, $data){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET pause_intervals='".$data['pause_intervals']."', status='".$data['status']."', total_pauses='".$data['total_pauses']."' WHERE id=$id";
        
        return(mysqli_query($con, $sql));
    }

    public static function startTask($id, $data){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET start_time='".$data['start_time']."', status='".$data['status']."' WHERE id=$id";
        
        return(mysqli_query($con, $sql));
    }

    public static function finishTask($id, $data){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET end_time='".$data['end_time']."', status='".$data['status']."', total_time='".$data['total_time']."', total_pauses='".$data['total_pauses']."' WHERE id=$id";
        
        return(mysqli_query($con, $sql));
    }

    public static function reopenTask($id, $data){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET status='".$data['status']."', total_time=".$data['total_time'].", end_time=".$data['end_time']." WHERE id=$id";
        
        return(mysqli_query($con, $sql));
    }

    public static function delete($id){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';

        // First, delete all label links for this task
        $deleteLabelsSql = "DELETE FROM " . self::$taskLablesTasks . " WHERE id_task=$id";
        mysqli_query($con, $deleteLabelsSql);

        // Then, delete the task itself
        $sql = "DELETE FROM " . self::$table . " WHERE id=$id";
        $res = mysqli_query($con, $sql);
        return $res;
    }
}