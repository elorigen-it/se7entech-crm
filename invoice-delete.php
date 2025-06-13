<?php 
	require_once './envloader.php';
 	$id=$_REQUEST['id'];
	include('./config/connection.php');
	mysqli_query($con,"delete from invoice_order where order_id='$id' ");
 	if(mysqli_affected_rows($con)==1)
	{
	    echo '<script>alert("Deleted")</script>';
 		header("location:inv");
	}
?>