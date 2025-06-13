<?php
require './config/connection.php';
$id=$_GET['id'];
$table = $_GET['t'];
$url = $_GET['u'];
$del=mysqli_query($con,"delete from $table  WHERE id='$id'"); 
echo '<script>
    alert("Deleted")
    window.location.href="'.$url.'"
</script>';
