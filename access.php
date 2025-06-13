<?php
@session_start();
include_once(__DIR__ . './envloader.php');
include_once(__DIR__ . './config/connection.php');

if(isset($_SESSION['email']))
{
	$logid=$_SESSION['email'];
	$res=mysqli_query($con,"select * from invoice_user where email='$logid'");
	$row=mysqli_fetch_assoc($res);
	$access = $row['status'];
	$name = $row['first_name'];
	$log= $row['id'];
	if($access=='0')
	{
	   $data ='';  
	}
	else
	{
	    $data = "where logid='$logid'";
	}
}
?>