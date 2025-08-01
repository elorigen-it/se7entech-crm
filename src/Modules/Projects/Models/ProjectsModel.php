<?php

namespace Se7entech\Contractnew\Modules\Projects\Models;
use Se7entech\Contractnew\Helpers\EscapeString;

class ProjectsModel{
    private static $table = 'projects_v2';

    public static function postProject($data){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        
        $data = EscapeString::escapeArray($con, $data);
        $sql = "INSERT INTO " . self::$table ." (name, customer_id, description, status) VALUES ('".$data['project-name']."','".$data['customer']."', '" . $data['project-description'] . "', '" . $data['project-status']. "')";
        
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
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$table . " WHERE id=$id";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            return mysqli_fetch_assoc($res);
        }
        
        return false;
    }

    public static function getByCustomerId($customer_id){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';

        $response = array();
        $sql = "SELECT * FROM " . self::$table . " WHERE customer_id='$customer_id'";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                $response[] = $row;
            }
        }
        
        return $response;
    }

    public static function update($id, $data){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        $sql = "UPDATE " . self::$table . " SET name='" . $data['project-name'] . "', customer_id='" . $data['customer'] . "', description='" . $data['project-description'] . "', status='" . $data['project-status'] . "' WHERE id=$id";
        return(mysqli_query($con, $sql));
    }

    public static function delete($id){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';

        $sql = "DELETE FROM " . self::$table . " WHERE id=$id";
        $res = mysqli_query($con, $sql);
        return $res;
    }

    public static function getCustomerProjectsWithTasks($id){
        include __DIR__ . '/../../../../envloader.php';
        include __DIR__ . '/../../../../config/connection.php';

        $response = array();
        $sql = "
        SELECT 
            p.id project_id,
            p.name project_name,
            p.description project_description,
            p.status project_status,
            p.created_at project_created_at,
            p.updated_at project_updated_at,
            t.id task_id,
            t.name task_name,
            t.description task_description,
            t.customer_tempname task_customer_tempname,
            t.status task_status,
            t.total_time task_total_time,
            t.start_time start_time,
            t.pause_intervals pause_intervals,
            t.deadline task_deadline,
            t.estimated_time task_estimated_time,
            t.custom_total_time,
            t.task_description_for_customer,
            tc.name category_name,
            GROUP_CONCAT(tc.name) AS task_categories
        FROM " . self::$table . " p
        LEFT JOIN tasks t ON p.id = t.project_id
        LEFT JOIN task_categories_tasks tct ON t.id = tct.task_id
        LEFT JOIN task_categories tc ON tct.category_id = tc.id
        WHERE p.customer_id='$id'
        GROUP BY p.id, t.id
        ";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            $projects = [];
            while($row = mysqli_fetch_assoc($res)){
                $project_id = $row['project_id'];
                if (!isset($projects[$project_id])) {
                    // Initialize project data
                    $projects[$project_id] = [
                        'id' => $row['project_id'],
                        'name' => $row['project_name'],
                        'description' => $row['project_description'],
                        'status' => $row['project_status'],
                        'created_at' => $row['project_created_at'],
                        'updated_at' => $row['project_updated_at'],
                        'tasks' => []
                    ];
                }
                // If there is a task, add it to the tasks array
                if (!empty($row['task_id'])) {
                    $task = [
                        'id' => $row['task_id'],
                        'name' => $row['task_name'],
                        'description' => $row['task_description'],
                        'customer_tempname' => $row['task_customer_tempname'],
                        'status' => $row['task_status'],
                        'total_time' => $row['task_total_time'],
                        'deadline' => $row['task_deadline'],
                        'start_time' => $row['start_time'],
                        'pause_intervals' => $row['pause_intervals'],
                        'estimated_time' => $row['task_estimated_time'],
                        'category_name' => $row['category_name'],
                        'task_categories' => $row['task_categories'],
                        'custom_total_time' => $row['custom_total_time'],
                        'task_description_for_customer' => $row['task_description_for_customer']
                    ];
                    $projects[$project_id]['tasks'][] = $task;
                }
            }
            $response = array_values($projects);
        }
        
        return $response;
    }
}