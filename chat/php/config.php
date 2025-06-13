<?php
  $hostname = "localhost";
  $username = "se7entechnet_kundan";
  $password = "Kundan@7542";
  $dbname = "se7entechnet_contractnew";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
?>
