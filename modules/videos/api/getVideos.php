<?php
    require_once('../../../connection.php');

    $sql = 'SELECT `videos`.`id` as video_id, `videos`.`customer_table`, `videos`.`customer_id`, `videos`.`name` as video_name, `videos`.`path`, `videos`.`mime`, `videos`.`original_name`, `videos`.`size`, `videos`.`logid`, `videos`.`status`, `videos`.`created_at`, `projects`.`id` as project_id, `projects`.`customer_table` as project_customer_table, `projects`.`customer_id` as project_customer_id, `projects`.`name` as `project_name`, `projects`.`logid` as project_logid, `projects`.`created_at` as project_created_at, `projects`.`updated_at` as project_updated_at FROM videos LEFT OUTER JOIN projects ON projects.id = videos.project_id order by `videos`.`id` desc';

    $query = mysqli_query($con, $sql);
    $response = array('success' => false, 'num_rows' => mysqli_num_rows($query), 'data' => array());
    if($response['num_rows'] > 0){
        while($row = mysqli_fetch_assoc($query)){
            array_push($response['data'], $row);
        }
        foreach($response['data'] as $key => $value){
            //take customer from project first
            if($value['project_customer_table'] && $value['project_customer_id']){
                $sql = "SELECT * FROM " . $value['project_customer_table'] . " WHERE id ='" . $value['project_customer_id'] . "'";
                $query = mysqli_query($con, $sql);
                if(mysqli_num_rows($query)){
                    $customer_info = mysqli_fetch_assoc($query);
                    $customer_info['table'] = $value['project_customer_table'];
                    $response['data'][$key]['project_customer_info'] = $customer_info;
                }
            }
            //if not, take the customer from videos. this means that video does not belong to a project
            else if($value['customer_table'] && $value['customer_id']){
                $sql = "SELECT * FROM " . $value['customer_table'] . " WHERE id ='" . $value['customer_id'] . "'";
                $query = mysqli_query($con, $sql);
                if(mysqli_num_rows($query)){
                    $customer_info = mysqli_fetch_assoc($query);
                    $customer_info['table'] = $value['customer_table'];
                    $response['data'][$key]['customer_info'] = $customer_info;
                }
            }
        }
        $response['success'] = true;
        
    }

    echo json_encode($response);