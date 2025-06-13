<?php
require('./vendor/autoload.php');
require_once './envloader.php';

use Se7entech\Contractnew\Helpers\Mailer;
use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;

session_start(); //session start always on top.
require_once './config/config.php';
require_once './config/connection.php';
require_once 'access.php'; //inside access.php you already have $con variable without importing it there.

function extractRecipients($data){
   $recipients = array();
   $i=0;
   while(isset($data["name_".$i])){
      $recipients[] = array(
         "name" => $data['name_'.$i],
         "email" => $data['email_'.$i]
      );
      $i++;
   }
   return $recipients;
}

function extractCC($data){
   $recipients = array();
   $i=0;
   while($name = $data["ccname_".$i]){
      $recipients[] = array(
         "name" => $data['ccname_'.$i],
         "email" => $data['ccemail_'.$i]
      );
      $i++;
   }
   return $recipients;
}

function extractCCO($data){
   $recipients = array();
   $i=0;
   while($name = $data["cconame_".$i]){
      $recipients[] = array(
         "name" => $data['cconame_'.$i],
         "email" => $data['ccoemail_'.$i]
      );
      $i++;
   }
   return $recipients;
}

function extractSubject($data){
   return $data['subject'];
}

function extractMessage($data){
   $message = '<html>
      <head></head>
      <body>
         <p>
   ';
   $message .= $data['message'];
   $message .= '</p>';

   return $message;
}

if(isset($_SESSION['email']))
{
	$logid=$_SESSION['email'];
	$res=mysqli_query($con,"select * from invoice_user where email='$logid'");
	$row=mysqli_fetch_assoc($res);
	$access = $row['status'];

	$from = $row['email'];
	$fromName = $_SESSION['user'];
   $smtp_user = $row['smtp_user'];
   $smtp_pass = $row['smtp_pass'];

   if($access === '0' ) {
      $customers = CustomersModel::getAllV2();
   }else{
      $customers = CustomersModel::getCustomersFromAgent($logid);
   }


	
?>
   <script>
   if ( window.history.replaceState ) {
   window.history.replaceState( null, null, window.location.href );
   }
   </script> 
   <!--<link rel="stylesheet" href="editor/summernote-bs4.min.css?i=<? (rand(111,999))?>">-->
   <style>
      .note-group-select-from-files
      {
         display: none;
      }
      
      .note-modal
      {
         display: none; 
      }
   </style>
   <style>@import url('https://fonts.googleapis.com/css?family=Oxygen');</style>
  <?php
    // ini_set('display_errors', '1');
    // ini_set('display_startup_errors', '1');
    // error_reporting(E_ALL);
    
   if (isset($_POST['form-single'])){
      $recipients = extractRecipients($_POST);
      $toCC = extractCC($_POST);
      $toCCO= extractCCO($_POST);
      $subject = extractSubject($_POST);
      $message = extractMessage($_POST);

      // $rand= (rand(11111,99999));
      // $sender_name = $_POST['sender_name'];
      // $sender_email = $_POST['sender_email'];
      // $cc_email = ($_POST['cc_email']) != '' ? $_POST['cc_email'] : false;
      // $subject = str_replace("'", '_',$_POST['subject']);
      // $messages = str_replace("'", '_',$_POST['message']);
   
      $uploaded = array();
      foreach($_FILES as $key => $file){
         if($file['name'] != ''){
            $name = uniqid('file-').$file['name'];
            $filepath = 'mail/'.$name;
            if(move_uploaded_file( $_FILES[$key]['tmp_name'], $filepath )){
               $uploaded[] = $filepath;
            };
         }
      }

      
      // $ress=mysqli_query($con,"select * from invoice_user where email='$logid'");
      // $data=mysqli_fetch_assoc($ress);    
      // we'll begin by assigning the To address and message subject
      // $to="$sender_email";
      // $subject="$subject";
      // $senderemail =$myemail;
      // $sender_email .= ($cc_email) ? ', CC: ' . $cc_email : ''; 
      // $sql = "insert into inboxemail (sender_name,subject,message,sender_email,logid,rand,imagea,imageb,imagec,imaged,imagee,imagef,imageg,imageh) value ('$sender_name','$subject','$messages','$sender_email','$logid','$rand','$imgname','$imgname2','$imgname3','$imgname4','$imgname5','$imgname6','$imgname7','$imgname8')";
      // $result =mysqli_query($con,$sql);
         
      // get the sender's name and email address
      // we'll just plug them a variable to be used later
      // $from = stripslashes($_POST['sender_name'])."<".stripslashes($senderemail).">";

      // generate a random string to be used as the boundary marker
      // $mime_boundary="==Multipart_Boundary_x".md5(mt_rand())."x";
      //   $headers = 'From: '.$myemail.''. "\r\n";
      //   if($cc_email){
      //    $headers .= "CC: ".$cc_email."\r\n";
      //   }
      //   $headers .= "Reply-To: Se7entech <$logid>". "\r\n" .
      //   'Content-type:text/html;charset=UTF-8' . "\r\n".
      //   'X-Mailer: PHP/' . phpversion();
         
      // now we'll build the message headers
      // $headers = "From: $from\r\n";
      // if($cc_email){
      // $headers .= "CC: ".$cc_email."\r\n";
      // }
      // $headers .= "Reply-To: Se7entech  <$logid>" . PHP_EOL .
      // "MIME-Version: 1.0\r\n" .
      // "Content-Type: multipart/mixed;\r\n" .
      // " boundary=\"{$mime_boundary}\"";

      // // in the e-mail
      
      $message .='<br><br><table style="width:400px; height: 213px; padding-top:33px; padding-right:0; padding-bottom:38px; padding-left:10px; font-family:Oxygen, sans-serif; font-size: 12px">
         <tbody>
            <tr>
            <td style="width:110px; padding:0;">
               <img alt="Se7entech logo" src="https://se7entech.net/images/logo.png"   style="width:92px; padding-right: 20px; opacity: 0.8">
               <br>
               <br>
               <a href="https://www.facebook.com/SEVENTECHCORP/"><img alt="facebook logo" src="https://cdn3.iconfinder.com/data/icons/free-social-icons/67/facebook_circle_color-512.png" width=16px  style="padding-left:14px;"></a>
               <a href="https://www.instagram.com/se7entech_net/"><img alt="instagram logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/2048px-Instagram_icon.png" width=16px></a>
               <a href="https://www.tiktok.com/@se7entech"><img alt="tiktok logo" src="https://images.rawpixel.com/image_png_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDIyLTA1L2pvYjkwOC1jYS03Ml8xLnBuZw.png"  width=16px></a>
            </td>
            <td style="border-left: 2px solid #f1451e; width:22px; height:136px; padding: 0px; opacity:0.8"></td>
            <td style="padding:0px">
               <b>'.$fromName.'</b>
               <br>'.$row['designation'].'
               <br>
               <a href="tel:'.$row['mobile'].'" style="text-decoration:none; color:black;"><img alt="telephone logo" src="https://www.mleewise.com/assets/img/telephone32px.png"  height=10px > '.$row['mobile'].'</a>
               <br>
               <a href="mailto:'.$row['smtp_user'].'" style="text-decoration:none; color:black;"><img alt="email logo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcm25mFsqCVFPZ5EUFKOIJnPQTE6U4PEd2DQ&usqp=CAU"  height=10px > '.$row['smtp_user'].'</a>
               <br><a href="https://se7entech.net/" style="text-decoration:none; color:black;"><img alt="website logo" src="https://www.freepnglogos.com/uploads/logo-website-png/logo-website-website-icon-with-png-and-vector-format-for-unlimited-22.png"  height=10px > www.se7entech.net</a>

               <br>
               
               
            </td>
            </tr>
         </tbody>
         </table>
         </body>
         </html>
      ';
      // <br style="line-height:30px">
         // <a href="https://se7entech.net/"><img src="https://se7entech.net/images/logo.png" alt="The logo for company" style="width:158px;"></a>
         // <br>
      // when we use it
      // $message = "This is a multi-part message in MIME format.\n\n" .
      //    "--{$mime_boundary}\n" .
      // 'Content-type:text/html;charset=UTF-8' . "\r\n".
      //    "Content-Transfer-Encoding: 7bit\n\n" .
      // $message . "\n\n";
         
         
      // now we'll process our uploaded files
      // foreach($_FILES as $userfile){
      //    // store the file information to variables for easier access
      //    $tmp_name = $userfile['tmp_name'];
      //    $type = $userfile['type'];
      //    $name = $userfile['name'];
      //    $size = $userfile['size'];
         
   
      //    // if the upload succeded, the file will exist
      //    if (file_exists($tmp_name)){

      //       // check to make sure that it is an uploaded file and not a system file
      //       if(is_uploaded_file($tmp_name)){

      //          // open the file for a binary read
      //          $file = fopen($tmp_name,'rb');

      //          // read the file content into a variable
      //          $data = fread($file,filesize($tmp_name));

      //          // close the file
      //          fclose($file);

      //          // now we encode it and split it into acceptable length lines
      //          $data = chunk_split(base64_encode($data));
      //       }
   
      //       $message .= "--{$mime_boundary}\n" .
      //          "Content-Type: {$type};\n" .
      //          " name=\"{$name}\"\n" .
      //          "Content-Disposition: attachment;\n" .
      //          " filename=\"{$fileatt_name}\"\n" .
      //          "Content-Transfer-Encoding: base64\n\n" .
      //       $data . "\n\n";
      //    }
      // }
      // here's our closing mime boundary that indicates the last of the message
      // $message.="--{$mime_boundary}--\n";
      // now we just send the message
      
      $mailer = new Mailer($from, $fromName, $recipients, false, $subject, $message, $altMessage, $smtp_user, $smtp_pass, $toCC, $toCCO);
      if(count($uploaded)){
         foreach($uploaded as $path){
            $mailer->addAttachment($path);
         }
      }

      if ($mailer->send()){
         $sender_email = '';
         if(count($recipients)){
            foreach($recipients as $recipient){
               $sender_email.= $recipient['name'] . ':'.$recipient['email'] . ',';
            }
         }
         if(count($toCC)){
            foreach($toCC as $cc){
               $sender_email.= 'cc-'.$cc['name'] . ':'.$cc['email'] . ',';
            }
         }
         if(count($toCCO)){
            foreach($toCCO as $cco){
               $sender_email.= 'bcc-'.$cco['name'] . ':'.$cco['email'] . ',';
            }
         }
         $filesname='';
         $columns = array('imagea','imageb','imagec','imaged','imagee','imagef','imageg','imageh');
         foreach($columns as $index => $value){
            $filesname .= isset($uploaded[$index]) ? "'".$uploaded[$index]."'" : "''";
            if($value != 'imageh'){
               $filesname .= ',';
            }
         }
         $message = mysqli_real_escape_string($con, $message);
         $sql = "insert into inboxemail (sender_name,subject,message,sender_email,logid,imagea,imageb,imagec,imaged,imagee,imagef,imageg,imageh) values ('$from','$subject','$message','$sender_email','$logid',".$filesname.")";
         $result =mysqli_query($con,$sql);
         if($result){
            $printNotificationSuccess = true;
         }
      }
   }    
?>
<!DOCTYPE html>
<html lang="en">
   <head>
    <?php include './layout/head.php';?>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/vader/jquery-ui.css">

    <title>Se7entech Corporation - Email</title>
   </head>
   <body>
      <?php include ('sidebar.php'); ?>
      <div class="main-content">
         <?php include ('nav.php'); ?>
 
         <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
            <div class="container-fluid">
               <div class="nav-wrapper">
                  <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Individual</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#sent" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-share mr-2"></i>Sent</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <!-- Top navbar -->
         <div class="container-fluid mt--7">
            <div class="row">
               <div class="col-12">
                  <br />
                  <div class="tab-content" id="tabs">
                     <!-- Tab Managment -->
                     <div class="tab-pane fade show active" id="menagment" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card bg-secondary shadow">
                           <div class="card-header bg-white border-0">
                              <div class="row align-items-center">
                                 <div class="col-8">
                                    <h3 class="mb-0">Email Management</h3>
                                 </div>
                                 <!--<div class="col-4 text-right">-->
                                 <!--   <a target="_blank" href="https://feeder.henkakoplus.in/restaurant/kundan"-->
                                 <!--      class="btn btn-sm btn-success">View it</a>-->
                                 <!--</div>-->
                              </div>
                           </div>
                           <div class="card-body">
                              <div class="pull-right">
                                 <label class="control-label" for="customer_id">Populate With:</label>
                                 <br>
                                 <select class="form-control select2" id="customer_id">
                                       <option>SELECT A CUSTOMER</option>
                                       <?php foreach($customers as $customer):?>
                                          <option value="<?php echo $customer['id'];?>"><?php echo $customer['type'] . ' - ' .$customer['business_name'] . ' - ' . $customer['name'];;?></option>
                                       <?php endforeach;?>
                                 </select>
                              </div>
                              <h6 class="heading-small text-muted mb-4">Add information</h6>
                              <div class="pl-lg-4">
                                 <form enctype="multipart/form-data" method="POST" action="" style="width: 100%;" class="container" id="form-single">
                                 <input type="hidden" name="form-single" value="form-single">
                                    <div class="form-group">
                                       <h4>Recipient's info</h4>
                                       <div id="list">
                                          <div class="list_var container">
                                             <div class="row mt-2">
                                                <input type="text" class="form-control col-12 col-md-5" size="40" name="name_0" id="name_0" placeholder="Recipient's Name">
                                                <input type="text" class="form-control col-12 col-md-5" size="40" name="email_0" id="email_0" placeholder="Recipient's Email Address">
                                                <span class="col-12 col-md-2">
                                                   <button class="btn btn-danger list_del"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                                </span>
                                             </div>
                                          </div>
                                       </div>
                                       <input type="button" value="Add Recipient" class="list_add btn btn-primary btn-sm mt-2">
                                    </div>
                                    <div class="form-group mb-2">
                                       <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseCC" aria-expanded="false" aria-controls="collapseCC"><i class="fa fa-plus" aria-hidden="true"></i> Add CC</button>
                                       <div class="row">
                                          <div class="col-12">
                                             <div class="collapse multi-collapse" id="collapseCC">
                                                <div class="card card-body">
                                                   <div class="form-group">
                                                      <h4>CC's info</h4>
                                                      <div id="list2">
                                                         <div class="list_var02 container">
                                                            <div class="row mt-2">
                                                               <input data-id-format="ccname_%d" data-name-format="ccname_%d" type="text" class="form-control col-12 col-md-5" size="40" name="ccname_0" id="ccname_0" placeholder="CC's Name">
                                                               <input data-id-format="ccemail_%d" data-name-format="ccemail_%d" type="text" class="form-control col-12 col-md-5" size="40" name="ccemail_0" id="ccemail_0" placeholder="CC's Email Address">
                                                               <span class="col-12 col-md-2">
                                                                  <button class="btn btn-danger list_del02"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                                               </span>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <input type="button" value="Add CC Recipient" class="list_add02 btn btn-primary btn-sm mt-2">
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseCCO" aria-expanded="false" aria-controls="collapseCCO"><i class="fa fa-plus" aria-hidden="true"></i> Add BCC</button>
                                    </div>
                                    <div class="row">
                                       <div class="col-12">
                                          <div class="collapse multi-collapse" id="collapseCCO">
                                             <div class="card card-body">
                                                <div class="form-group">
                                                   <h4>BCC's info</h4>
                                                   <div id="list3">
                                                      <div class="list_var03 container">
                                                         <div class="row mt-2">
                                                            <input type="text" class="form-control col-12 col-md-5" size="40" name="cconame_0" id="cconame_0" placeholder="CCO's Name">
                                                            <input type="text" class="form-control col-12 col-md-5" size="40" name="ccoemail_0" id="ccoemail_0" placeholder="CCO's Email Address">
                                                            <span class="col-12 col-md-2">
                                                               <button class="btn btn-danger list_del03"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                                            </span>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <input type="button" value="Add BCC Recipient" class="list_add03 btn btn-primary btn-sm mt-2">
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       <input class="form-control" type="text" name="subject" placeholder="Subject"/>
                                    </div>
                                    <div class="form-group">
                                       <!--<lavel style="color:red">Note: video & image file will not work in editor<sup style="color:red">*</sup></lavel>-->
                                       <textarea class="form-control" id="summernote" name="message" placeholder="Message"></textarea>
                                    </div>
                                    <div class="form-group">
                                       <p>File: <input type="file" name="file1"></p>
                                       </div>
                                       <details>
                                       <summary class="badg badge-warning" style="padding:7px;border-radius:3px">Add More</summary>
                                       <br>
                                       <div class="form-group">
                                       <p>File: <input type="file" name="file2"></p>
                                       </div>
                                       <div class="form-group">
                                       <p>File: <input type="file" name="file3"></p>
                                       </div>
                                       <div class="form-group">
                                       <p>File: <input type="file" name="file4"></p>
                                       </div>
                                       <div class="form-group">
                                       <p>File: <input type="file" name="file5"></p>
                                       </div>
                                       <div class="form-group">
                                       <p>File: <input type="file" name="file6"></p>
                                       </div>
                                       <div class="form-group">
                                       <p>File: <input type="file" name="file7"></p>
                                       </div>
                                       <div class="form-group">
                                       <p>File: <input type="file" name="file8"></p>
                                    </div>
                                    </details>
                                       
                                    <br>
                                    <div class="form-group">
                                       <button type="submit" id="submit-single" name="send" class="btn btn-success">Send <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                       <!-- <input type="submit" name="button" style="background:blue;border:none;color:white;border-radius:2px"  value="save">  -->
                                    </div>		
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     
                     <!--start sent tab-->
                     <div class="tab-pane fade show" id="sent" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card card-profile shadow">
                           <div class="card-header">
                              <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" class="form-control">
                           </div>
                           <div class="card-body" style="overflow-x:auto;">
                              
                              <table class="table table-bordered table-striped display responsive" id="myTable" style="width:100%">
                                 <thead>
                                    <tr>
                                       <th>ID</th>
                                       <th>Formats</th>
                                       <th>Sender Name</th>
                                       <th>Subject</th>
                                       <th>Message</th>
                                       <th>Email</th>
                                       <th>File</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php
                                    if($access === '0'){
                                       $sql="select * from inboxemail order by id desc";
                                    }else{
                                       $sql="select * from inboxemail where logid='$logid' order by id desc";
                                    }
                                    $result11=mysqli_query($con,$sql);
                                    
                                    if(mysqli_num_rows($result11))
                                    {
                                    $i=1;
                                    while($rows11=mysqli_fetch_assoc($result11)){
                                       $files = array('imagea', 'imageb', 'imagec', 'imaged', 'imagee', 'imagef', 'imageg', 'imageh');
                                       $sn = '';
                                       $links = array();
                                       foreach($files as $file){
                                          if($rows11[$file] != ''){
                                             $sn .= pathinfo($rows11[$file], PATHINFO_EXTENSION) . ' ';
                                             $links[] = $base_url . '/' . $rows11[$file]; 
                                          }
                                       }
                                    ?>
                                    <tr>
                                      <td><?php echo $rows11['id'];?></td>
                                      <td><?php echo $sn;?></td>
                                      <td><?php echo $rows11['sender_name'];?></td>
                                      <td><?php echo $rows11['subject'];?></td>
                                      <td><?php echo "<div style='max-width:200px;overflow:auto;'>".$rows11['message']."</div>";?></td>
                                      <td><?php echo $rows11['sender_email'];?></td>
                                      <td style="color:red">
                                          <details>
                                             <summary>View File</summary>
                                             <?php foreach($links as $link):?>
                                                <a 
                                                   style="background:green;padding:7px;color:white;border-radius:3px;" 
                                                   target="blank"    
                                                   href="<?php echo $link;?>">
                                                      <i class="fa fa-file-text-o" title="<?php echo $link;?>"></i>
                                                </a>
                                                <?php
                                                   //  <!-- <a style="background:green;padding:7px;color:white;border-radius:3px;<?php if(empty($rows11['imageg'])){echo "display:none";} else{}" target="blank"    href="images/email_image/<?= $rows11['imageg'];"><i class="fa fa-<?php if($ext7=='png'){echo 'image';} else if($ext7=='mp4'){echo 'video';} else if($ext7=='jpg'){echo 'image';}else if($ext7=='jpeg'){echo 'image';}else if($ext7=='pdf'){echo 'file-pdf-o';}else if($ext7=='xls'){echo 'file-excel-o';}else if($ext7=='xlsx'){echo 'file-excel-o';}else if($ext7=='docs'){echo 'file-text-o';}else if($ext7=='doc'){echo 'file-text-o';} else{echo 'book';}" title=" $rows11['imageg'];"></i></a> -->
                                                ?>
                                                <?php endforeach;?>
                                          </details>
                                       </td>
                                      <td><a style="background:green;padding:10px;color:white;border-radius:3px;" href="Delete?t=inboxemail&id=<?php echo $rows11['id'];?>&u=<?php echo $base_url;?>/Email"> <i class="fa fa-trash"></i></a> </td>
                                  </tr>
                                  <?php $i++;}}?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <!--end-->
                  </div>
               </div>
            </div>
         </div>
         <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
         </footer>
      </div>
      </div>
      </div>
      <?php include './layout/footer_scripts.php'; ?>
      
      <script src="<?php echo $base_url;?>/js/add-input-area.js"></script>
      <!--<script src="editor/summernote-bs4.min.js"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
      <script>
         var customers = <?php echo json_encode($customers);?>;
         $(function () {
            $(document).ready(() => {
               
               $('#myTable').DataTable({
                  responsive:true,
                  order: [[0, 'desc']]
               })
               // Summernote
               $('#summernote').summernote()

               $('#list').addInputArea();
               $('#list2').addInputArea({
                  area_var: '.list_var02',
                  btn_add: '.list_add02',
                  btn_del: '.list_del02'
               })
               $('#list3').addInputArea({
                  area_var: '.list_var03',
                  btn_add: '.list_add03',
                  btn_del: '.list_del03'
               })

               let submitSingle = document.querySelector('#submit-single');
               submitSingle.addEventListener('click', (e) => {
                  // e.preventDefault();
                  console.log($('#form-single').serializeArray())
               }, false)

               $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                  var target = $(e.target).attr("href") // activated tab
                  console.log(target)
                  if(target === '#sent'){
                     $($.fn.dataTable.tables(true)).DataTable()
                     .columns.adjust()
                     .responsive.recalc(); 
                     
                     // $('#video-list-tbody').html("<img src='<?php echo $base_url;?>/modules/videos/images/uploading.gif' >")
                     // updateMediaListTable()                      
                  }
               });
            })
         })

         $('#customer_id').on('change', (e) => {
            let selectedCustomer = customers.filter((el) => Number(el.id) === Number(e.target.value))[0]

            document.querySelector('#email_0').value=selectedCustomer.email;

         })
         
      </script>
      <?php if(isset($printNotificationSuccess)):?>
         <script>
            $.notify('Email successfully sent', 'success');
         </script>
      <?php endif;?>
      <!-- Pusher -->
      <!-- Custom JS defined by admin -->
   </body>
</html>
<?php
}
else
{
header("location:index.php");
}
?>