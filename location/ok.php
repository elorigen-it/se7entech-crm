<?php
include('../connection.php');
$myArray  = $_GET['address'];
$myArrayr = explode(',', $myArray);
 
 $a =$myArrayr[0];
 $b =$myArrayr[1];
$sql = "insert into colleges (name,address,lat,lng,client_name,phone,email,url,direction_link) value ('$notes','$address','$a','$b','$cname','$phone','$email','$url','$direction_url')";
$res = mysqli_query($con,$sql);

if(mysqli_affected_rows($con)==1)
     {
          echo "<script>window.location.href='Pin-Location';</script>";
         
     }
 
     else
     {
         echo "<script>alert('FAILED');</script>";
                  echo "<script>window.location.href='Pin-Location';</script>";
     }
?>
 