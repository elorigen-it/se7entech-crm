<?php 
         include('../connection.php');
         $email=$_GET['e'];
         $id = $_GET['id'];
         $name ='<a href="https://crm.se7entech.net/">Login On Your Dashboard</a>';
     
         $email_subject = 'Se7entech Admin Call To Chat Now';
   
        $message =
        '<br>Chat Now: '.$name.''; 
   	                 
   $to =$email;
   
   
   $headers = "MIME-Version: 1.0" . "\r\n"; 
   $headers = "Content-type:text/html;charset=UTF-8" . "\r\n"; 
   
   
    $headers = 'From: Message from admin  <info@se7entech.us>' . PHP_EOL .
        'Reply-To: Message from admin  <info@se7entech.us>' . PHP_EOL .
                  'Content-type:text/html;charset=UTF-8' . "\r\n".
                  'X-Mailer: PHP/' . phpversion();
                    
   
   if(mail($to, $email_subject, $message, $headers))
   { 
        $sql="update messages set  unread='1' where outgoing_msg_id='$id' and unread='0'";
        mysqli_query($con,$sql);
     echo "<script>window.location.href='chat.php?id=$id';</script>"; 
   }
   
   else{ 
         echo '<script>alert("try again");</script>'; 
   }
   
   ?>