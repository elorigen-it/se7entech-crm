<?php 
   session_start();
   require_once './config/config.php';
   require_once './config/connection.php';
   require_once './access.php';
   
$add = $_GET['address'];
if(isset($_POST['save']))
{
$name = $_POST['all'];
$a =    $_POST['a'];
$b =    $_POST['b'];
session_start();
$_SESSION=$name;

}
?>
 <form method="POST">  
<input hidden type="text" value="<?php 
$addressFrom = $add;
function getDistance($addressFrom){
// Google API key

$apiKey = 'AIzaSyCPuU44PV_rJh0QMPy32nk1aRiil-aGzgw';

// Change address format
$formattedAddrFrom    = str_replace(' ', '+', $addressFrom);

// Geocoding API request with start address
$geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
$outputFrom = json_decode($geocodeFrom);

// Get latitude and longitude from the geodata

echo  $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat,',',$outputFrom->results[0]->geometry->location->lng;
  
}
 
// Get distance in km
$distance = getDistance($addressFrom, "K");

?>" name="all">

<?php
$myString = $_SESSION;
$myArray = explode(',', $myString);
?>
<input hidden type="text" name="a" value="<?=   $myArray[0];?>">
<input hidden type="text" name="b" value="<?=   $myArray[1];?>">



 <?php
 if(($_POST['save']))
 {
 
    $all = $_GET['all'];
    $a = $myArray[0];
    $b = $myArray[1];
    $address = $_GET['address'];
    $notes = $_GET['notes'];
    $cname = $_GET['client_name'];
    $phone = $_GET['phone'];
    $email = $_GET['email'];
    $url=$_GET['url'];
    $direction_url ="https://www.google.com/maps/place/$address";
    
      $sql = "insert into colleges (name,address,lat,lng,client_name,phone,email,url,direction_link) value ('$notes','$address','$a','$b','$cname','$phone','$email','$url','$direction_url')";
     $res = mysqli_query($con,$sql);
     if(mysqli_affected_rows($con)==1)
     {
        //  echo "<script>alert('success');</script>";
         echo "<script>window.location.href='Pin-Location';</script>";
         
     }
 
     else
     {
         echo "<script>alert('FAILED');</script>";
                  echo "<script>window.location.href='Pin-Location';</script>";
     }
}
?>
 <input  style="display:none" type="submit" name="save"  id="linkid">
  </form>
   <script>
//  window.onload = function(){
//     var button = document.getElementById('clickButton');
//     setInterval(function(){
//         button.click();
//     },100);
//     // this will make it click again every 1000 miliseconds
// };

window.onload=function(){
  document.getElementById("linkid").click();
  
} 
</script>