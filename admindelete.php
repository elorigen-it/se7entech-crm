<?php
include "./config/connection.php";
$id=$_GET['id'];
$table = $_GET['t'];
$url = $_GET['u'];
$del=mysqli_query($con,"update  `$table` set trashd='1' WHERE id='$id'");
if(mysqli_affected_rows($con)==1)
{
echo '<script>alert("Deleted")</script>';
header("location:$url");
}

else
{
 echo '<script>alert("Failed")</script>';
header("location:$url");   
}
 ?>
 