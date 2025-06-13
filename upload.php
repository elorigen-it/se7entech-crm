<?php
include ('access.php');
include('connection.php');
if(!empty($_FILES['images'])){
    // File upload configuration
    $targetDir = "video/";
    $allowTypes = array('mp4');
    $rand = (rand(1111,999));
    $images_arr = array();
    foreach($_FILES['images']['name'] as $key=>$val){
        $image_name = $_FILES['images']['name'][$key];
        $tmp_name   = $_FILES['images']['tmp_name'][$key];
        $size       = $_FILES['images']['size'][$key];
        $type       = $_FILES['images']['type'][$key];
        $error      = $_FILES['images']['error'][$key];
        
        // File upload path
        $fileName = basename($_FILES['images']['name'][$key]);
        $targetFilePath = $targetDir . $fileName;
          
        $insertqry="INSERT INTO `videos`( `file`,`logid`, `rand`) VALUES ('$fileName','$logid','$rand')";
		mysqli_query($con,$insertqry);
        
        // Check whether file type is valid
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        if(in_array($fileType, $allowTypes)){    
            // Store images on the server
            if(move_uploaded_file($_FILES['images']['tmp_name'][$key],$targetFilePath)){
                $images_arr[] = $targetFilePath;
            }
        }
    }
    
    // Generate gallery view of the images
    if(!empty($images_arr)){ ?>
        <ul>
        <?php foreach($images_arr as $image_src){ ?>
            <li><video controls src="<?php echo $image_src; ?>" alt=""></video></li>
        <?php } ?>
        </ul>
    <?php }
    
$email_subject = 'Proposal Se7entech';
 // message variable here

$message='
<br>Hey i am, '.$name.'
<br>'."Dear,<br> Manual i want a proposal <br>Send me here $logid.".'';
 
//  RECEIVE EMAIL
// here put your email where u want to receive data
$to = 'ingeniocreativovenezuela@gmail.com';
// $to = 'kundansingh754285@gmail.com';
 

$headers = "MIME-Version: 1.0" . "\r\n"; 
   $headers = "Content-type:text/html;charset=UTF-8" . "\r\n"; 
   
//   here your sender email
    $headers = 'From:Proposal Request <info@se7entech.us>'. "\r\n" .
                  'Reply-To: Proposal Request <info@se7entech.us>'. "\r\n" .
                   'Content-type:text/html;charset=UTF-8' . "\r\n".
                  'X-Mailer: PHP/' . phpversion();
                    
   
   if(mail($to, $email_subject, $message, $headers))
   { 
         echo '<script>alert("Thank You! For Enquiry");</script>'; 
   
    }
   
   else{ 
         echo '<script>alert("Try again");</script>'; 
   }
}
?>