<?php
// (A) MAIL SETTINGS
$mailTo = "kundansingh754285@gmail.com";
$mailSubject = "Test Mail With Image";

// (B) MAIL MESSAGE
// HOST THE IMAGE ON YOUR OWN SERVER!
// ALSO REMEMBER TO PROVIDE THE DIRECT LINK JUST-IN-CASE
$img = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMma1RsDUuSNsB1CLxhrSbNJH9OApmgGQndQ&usqp=CAU";
$mailBody = "<img src='$img'/><br>";
$mailBody .= "<a href='$img'>Can't see the image? Click Here.</a>";

// (C) HEADER - HTML MAIL
$mailHead = implode("\r\n", [
  "MIME-Version: 1.0",
  "Content-type: text/html; charset=utf-8"
]);

// (D) SEND
  if(mail($mailTo, $mailSubject, $mailBody, $mailHead))
  {
      echo '<script>alert("Shared");</script>';
  }
  
  else{
      echo '<script>alert("Try Again");</script>';
  }
  
  ?>