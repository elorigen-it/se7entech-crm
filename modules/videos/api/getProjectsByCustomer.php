<?php
    require_once('../../../connection.php');

    $customer_id = (isset($_POST['customer_id'])) ? $_POST['customer_id'] : false;
    $customer_table = (isset($_POST['customer_table'])) ? $_POST['customer_table'] : false;
    $results = array();

    if(false == $customer_id && false == $customer_table ){
        $sql = "SELECT * FROM projects WHERE customer_table IS NULL AND customer_id IS NULL";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($results, $row);
            }
        }   
    }else{
        $sql = "SELECT * FROM projects WHERE customer_table = '$customer_table' AND customer_id = '$customer_id'";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($results, $row);
            }
        }   
    }
    echo json_encode(array('success' => true, 'results' => $results));