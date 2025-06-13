<?php
session_start(); //session start always on top.
require_once './config/config.php';
require_once './config/connection.php';

if(isset($_SESSION['email']))
{
 	$logid=$_SESSION['email'];
	$res=mysqli_query($con,"select * from invoice_user where email='$logid'");
	$row=mysqli_fetch_assoc($res);
	$idd = $row['id'];
	 
}
 

if(isset($_POST['view'])){

// $con = mysqli_connect("localhost", "root", "", "notif");

if($_POST["view"] != '')
{
    $update_query = "UPDATE messages SET comment_status = 1 WHERE comment_status=0";
    mysqli_query($con, $update_query);
}
$query = "SELECT * FROM messages ORDER BY msg_id DESC LIMIT 5";
$result = mysqli_query($con, $query);
$output = '';
if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_array($result))
 {
   $output .= '
   <li>
   <a href="#">
   <strong>'.$row["msg"].'</strong><br />
   <small><em>'.$row["msg_id"].'</em></small>
   </a>
   </li>
   ';

 }
}
else{
     $output .= '
     <li><a href="#" class="text-bold text-italic">No Noti Found</a></li>';
}



$status_query = "SELECT * FROM messages WHERE comment_status=0 and incoming_msg_id='$idd'";
$result_query = mysqli_query($con, $status_query);
$count = mysqli_num_rows($result_query);
$data = array(
    'notification' => $output,
    'unseen_notification'  => $count
);

echo json_encode($data);

}

?>