<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['id'];
    if($outgoing_id=='123456')
    {
        $sql = "SELECT * FROM invoice_user WHERE NOT id = {$outgoing_id} ORDER BY id DESC";
    }
    
    else
    {
        $sql = "SELECT * FROM invoice_user WHERE   id = '123456' ORDER BY id DESC";
    }
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No Agent are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>

