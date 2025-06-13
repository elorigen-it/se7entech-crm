<?php
include "./config/connection.php";
$id=$_GET['id'];
$table = $_GET['t'];
$url = $_GET['u'];
$del=mysqli_query($con,"update  `$table` set trashd='2' WHERE id='$id'"); 
echo '<script>alert("Deleted")</script>';
header("location:$url");
 ?>