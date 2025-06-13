<?php
require_once('../../../connection.php');
require_once ('../../../config/config.php');

if($_POST['id']){
    $response = array('success' => false);

    $sql = "SELECT * FROM videos WHERE id='".$_POST['id']."'";
    $query = mysqli_query($con, $sql);
    $rows = mysqli_num_rows($query);
    if($rows){
        $video = mysqli_fetch_assoc($query);
        $videoPath = $base_path . DIRECTORY_SEPARATOR . $video['path'] . DIRECTORY_SEPARATOR . $video['name'];
        if(file_exists($videoPath)){
            unlink($videoPath);
        }
        $sql = "DELETE FROM videos WHERE id = '" . $_POST['id'] . "'";
        mysqli_query($con, $sql);

        $response['success'] = true;
    }
    echo json_encode($response);
}