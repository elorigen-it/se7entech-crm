<?php
//insert.php
if(isset($_POST["subject"]))
{
 include("./config/connection.php");
 $subject = mysqli_real_escape_string($con, $_POST["subject"]);
 $comment = mysqli_real_escape_string($con, $_POST["comment"]);
 $query = "
 INSERT INTO messages(outgoing_msg_id, msg)
 VALUES ('$subject', '$comment')
 ";
 mysqli_query($con, $query);
}
?>