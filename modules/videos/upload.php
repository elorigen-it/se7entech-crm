<?php
set_time_limit(2000);

include ('../../access.php');
include ('../../config/config.php');
//logid comming from access.php

include('../../connection.php');

$customer = isset($_POST['leads-clients']) ? $_POST['leads-clients'] : false;
$withoutProject = isset($_POST['with-or-without-project']) ? true : false;
$projectName = isset($_POST['project-name']) ? $_POST['project-name'] : false;
$projectId = isset($_POST['existing-project-id']) ? $_POST['existing-project-id'] : false;
$existingProject = isset($_POST['new-or-existing-project']) ? true : false;

//Posibilities
// Not customer and not new project
// --->save path: /video/video-name.xxx
if(($customer === 'no-lead-client' || $customer === false) && $withoutProject === true){
    $path = 'video/';
    echo uploadVideoTo($path);
    // echo 'no customer and not project';
}
// Not customer and new project
// --->save path /video/projects/project-id/video-name.xxx
else if(($customer === 'no-lead-client' || $customer === false) && $existingProject === false){
    $path = 'video/projects/{project-id}/';
    $response = array('success' => false, 'message' => 'Invalid Project Name');
   
    //TODO: review validations
    if($projectName != ''){
        $sql = "INSERT INTO projects (`customer_table`, `customer_id`, `name`, `logid`) VALUES (null, null, '" . $projectName . "', '$logid' )";
        mysqli_query($con, $sql);
        $insertedId = mysqli_insert_id($con);

        if($insertedId){
            $path = str_replace('{project-id}', $insertedId, $path);
            echo uploadVideoTo($path, $insertedId);
        }
    }else{
        echo json_encode($response);
    }

    // echo 'no customer and new project with name: ' . $projectName;
}
// Not customer and existing project
// --->save path /video/projects/project-id/video-name.xxx
else if(($customer === 'no-lead-client' || $customer === false) && $existingProject !== false){
    $path = "video/projects/$projectId/";
    
    //TODO: check if project id exists
    echo uploadVideoTo($path, $projectId);
    // echo 'no customer but existing project id: ' . $projectId;
}
// With customer and not new project
// --->save path /video/customers/{table}/{customer-id}/video-name.xx
else if(($customer !== 'no-lead-client' && $customer !== false) && $withoutProject === true){
    $path = "video/customers/{table}/{customer-id}/";
    $customer = explode('_', $customer);
    $path = str_replace(array('{table}', '{customer-id}'), array($customer[0], $customer[1]), $path);
   
    echo uploadVideoTo($path, null, $customer[0], $customer[1]);
    // echo 'with customer: ' . $customer . ' and without project';

}
// With customer and new project
// --->save path /video/customers/{table}/{customer-id}/projects/{project-id}/video-name.xx
else if(($customer !== 'no-lead-client' && $customer !== false) && $existingProject === false){
    $path = 'video/customers/{table}/{customer-id}/projects/{project-id}/';
    $customer = explode('_', $customer);
    $sql = "INSERT INTO projects (`customer_table`, `customer_id`, `name`, `logid`) VALUES ('" . $customer[0] . "', '" . $customer[1] . "', '" . $projectName . "', '$logid' )";
    mysqli_query($con, $sql);
    $insertedId = mysqli_insert_id($con);
    if($insertedId){
        $path = str_replace(array('{table}', '{customer-id}', '{project-id}'), array($customer[0], $customer[1], $insertedId), $path);
    }
    echo uploadVideoTo($path, $insertedId);
    // echo 'with customer: ' . $customer . ' and with new project named: ' . $projectName;
}
// With customer and existing project
// --->save path /videos/customers/{table}/{customer-id}/projects/{project-id}/video-name.xx
else if(($customer !== 'no-lead-client' && $customer !== false) && $existingProject === true){
    $path = 'video/customers/{table}/{customer-id}/projects/{project-id}/';
    $customer = explode('_', $customer);
    //TODO: validate project id
    $path = str_replace(array('{table}', '{customer-id}', '{project-id}'), array($customer[0], $customer[1], $projectId), $path);
    echo uploadVideoTo($path, $projectId);
    // echo 'with customer: ' . $customer . ' and existing project id: ' . $projectId;
}else{
    echo 'invalid request';
}

function uploadVideoTo($path='video/', $projectId=null, $customerTable=null, $customerId=null){
    global $logid, $con, $base_path;
    $uploadPath = $base_path . DIRECTORY_SEPARATOR . $path;

    if(!empty($_FILES['media'])){
        // File upload configuration
        $allowTypes = array('mp4', 'mpeg', 'mpg', 'avi', 'ogg', 'mov', 'movie','wmv','avi','avchd','flv','f4v','swf','mkv','webm','html5');
        $response = array('success' => false, 'message' => '', 'data' => array());

        foreach($_FILES['media']['name'] as $key=>$val){
            $error      = $_FILES['media']['error'][$key];
            
            // Prepare fields
            $data['originalName'] = basename($_FILES['media']['name'][$key]);
            $extension = pathinfo($data['originalName'],PATHINFO_EXTENSION);
            $filename_parts = explode('.', $data['originalName']);
            
            $data['mime'] = $_FILES['media']['type'][$key];
            $data['size'] = $_FILES['media']['size'][$key];
            $data['fileName'] = createSlug($filename_parts[0]) . '.' . $extension;
            $data['path'] = $path;
            $data['targetFilePath'] = $uploadPath . $data['fileName'];
            $data['status'] = 'active';
            $data['logid'] = $logid;

            // Check whether file type is valid
            if(in_array($extension, $allowTypes)){    
                $insertqry="INSERT INTO `videos` ( `project_id`, `customer_table`, `customer_id`, `name`, `path`, `mime`, `original_name`, `size`, `status`, `logid`) VALUES (";
                $insertqry .= ($projectId) ? " '$projectId', " : " NULL, ";
                $insertqry .= ($customerTable) ? " '$customerTable', " : " NULL, ";
                $insertqry .= ($customerId) ? " '$customerId' " : " NULL ";
                $insertqry .= ", '" . 
                    $data['fileName'] . "', '" . 
                    $data['path'] . "', '" . 
                    $data['mime'] . "', '" . 
                    $data['originalName'] . "', '" .
                    $data['size'] . "', '" . 
                    $data['status'] . "', '" . 
                    $data['logid'] . "')";
                mysqli_query($con,$insertqry);
                $insertedId = mysqli_insert_id($con);

                // Store media on the server
                if($insertedId){
                    if(!is_dir($uploadPath)){
                        mkdir($uploadPath, 0755, true); 
                    }
                    if(!is_file($data['targetFilePath'])){
                        $response['success'] = true;
                        if(move_uploaded_file($_FILES['media']['tmp_name'][$key], $data['targetFilePath'])){
                            $data['fileUploaded'] = true;
                            array_push($response['data'], $data);
                            $response['success'] = true;
                        }
                    }else{
                        $response['message'] = 'File already exists, use a better name before upload it.';
                    }
                }
            }
        }  
    }
    return json_encode($response);
}

function createSlug($str, $delimiter = '-'){
    $unwanted_array = ['ś'=>'s', 'ą' => 'a', 'ć' => 'c', 'ç' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ź' => 'z', 'ż' => 'z',
        'Ś'=>'s', 'Ą' => 'a', 'Ć' => 'c', 'Ç' => 'c', 'Ę' => 'e', 'Ł' => 'l', 'Ń' => 'n', 'Ó' => 'o', 'Ź' => 'z', 'Ż' => 'z']; // Polish letters for example
    $str = strtr( $str, $unwanted_array );

    $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
    return $slug;
}