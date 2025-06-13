<?php
session_start(); //session start always on top.
require('./vendor/autoload.php');
require_once './config/config.php';
require_once './config/connection.php';
require_once 'access.php'; //inside access.php you already have $con variable without importing it there.

use Se7entech\Contractnew\Middlewares\hasFilledRequirementForm;
    $validate = new hasFilledRequirementForm();
    $validate->handle(0);
if(isset($_POST['save']))
{
$cemail=$_POST["cemail"];
$email=$_POST["email"];
$payfor=$_POST["payfor"];
$amount=$_POST["amount"];
$message=$_POST["message"];
$subject =$_POST['subject'];

$res=mysqli_query($con,"select * from payment where email='$cemail'");
$row=mysqli_fetch_assoc($res);
$name =$row['name'];
$rand= (rand(111111,999999));

$sql="insert into payment (name,email,payfor,amount,message,rand,logid)values('$name','$cemail','$payfor','$amount','$message','$rand','$logid')";

$result=mysqli_query($con,$sql);
 
if(mysqli_affected_rows($con)==1)
{
       
        $link = 'https://crm.se7entech.net/form.php?id='.$rand.'';
        $email_subject = $subject;
   
        $message =
        '<br>NAME: '.$name.'
        <br>Message: '.$message.'
        <br>Amount: '.$amount.'
        <br>Pay For: '.$payfor.'
        <br>Pay Now: '.$link.''; 
               
        $to =$cemail;
    
        $headers = "MIME-Version: 1.0" . "\r\n"; 
        $headers = "Content-type:text/html;charset=UTF-8" . "\r\n"; 
        
       $headers = 'From: Payment Reminder  <info@se7entech.us>' . PHP_EOL .
        'Reply-To: Payment Reminder  <info@se7entech.us>' . PHP_EOL .
                  'Content-type:text/html;charset=UTF-8' . "\r\n".
                  'X-Mailer: PHP/' . phpversion();

  if(mail($to, $email_subject, $message, $headers))
   { 
         echo '<script>alert("Sent");</script>'; 
   
   }
   
  else{ 
         echo '<script>alert("try again");</script>'; 
  }
}
else{
	echo "<script>alert('sorry! unable to insert..');</script>";
}

}
?>
 
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include './layout/head.php';?>
      <title>Se7entech Corporation - Payment Reminder</title>
      
   </head>
   <body class="">
      
      <?php include ('sidebar.php'); ?>
      <div class="main-content">
         <?php include ('nav.php'); ?>
 
         <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
            <div class="container-fluid">
               <div class="nav-wrapper">
                  <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-paper-plane"></i> Send Reminder</a>
                     </li>
                     
                     <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-users mr-2"></i>Paid Client</a>
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
                                    <h3 class="mb-0">Payment Management</h3>
                                 </div>
                                 <!--<div class="col-4 text-right">-->
                                 <!--   <a target="_blank" href="https://feeder.henkakoplus.in/restaurant/kundan"-->
                                 <!--      class="btn btn-sm btn-success">View it</a>-->
                                 <!--</div>-->
                              </div>
                           </div>
                           <div class="card-body">
                              <h6 class="heading-small text-muted mb-4">Add information</h6>
                              <div class="pl-lg-4">
                                 
                                 <form id="restorant-form" method="POST"   autocomplete="off" enctype="multipart/form-data">
                                     <div class="row">
                                       <div class="col-md-4">
                                           <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Select Client</label>
                                             <select name="cemail"  class="form-control" placeholder="Client's Email"  required >
                                             <option>---Select Client---</option>
                                              
                                             <?php
                                                $sql="select * from clients order by id desc";
                                                $result11=mysqli_query($con,$sql);
                                                
                                                if(mysqli_num_rows($result11))
                                                {
                                                
                                                $i=1;
                                                while($rows11=mysqli_fetch_assoc($result11))
                                                {
                                                 ?>
                                                <option value="<?php echo $rows11['email'];?>"><?php echo $rows11['name'];?></option>
                                             
                                             <?php $i++;}}?>
                                             </select>
                                          
                                          </div>
                                         </div>
                                         
                                          <div class="col-md-4">
                                           <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">From</label>
                                             <input   type="text" name="email"  class="form-control"  value="info@se7entech.net"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                           <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Subject</label>
                                             <input   type="text" name="subject"  class="form-control"     required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                           <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Pay For</label>
                                             <input   type="text" name="payfor"  class="form-control" required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                           <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Amount</label>
                                             <input   type="text" name="amount"  class="form-control" required >
                                          </div>
                                         </div>
                                        
                                         
                                         <div class="col-md-12">
                                           <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Message</label>
                                             <textarea style="height:200px" name="message"  class="form-control"    required ></textarea>
                                          </div>
                                         </div>
                                         
                                         
                                         
                                      </div>
                                    <div class="text-center">
                                       <input type="submit" name="save" style="background:blue;border:none;color:white;border-radius:2px"  value="Send"> 
                                    </div>
                                    
                                    
                                 </form>
                                 <div style="visibility: hidden;display: none;">
                                 <select   class=" " placeholder="Client's Email" >
                                      <option>---Select Client---</option>
                                    </select>
                                    </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Tab Apps -->
                     <!-- Tab Location -->
                     <div class="tab-pane fade show" id="location" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card card-profile shadow">
                           <!--<div class="card-header">-->
                           <!--   <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" class="form-control">-->
                           <!--</div>-->
                           <div class="card-body" style="overflow-x:auto;">
                             <table id="myTable" class="table table-bordered table-striped">
                               <thead style="background:#337ab7;color:white;"> 
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <!--<th>Phone</th>-->
                                    <!--<th>Pay For</th>-->
                                    <!--<th>Message</th>-->
                                    <!--<th>Amount</th>-->
                                    <th>Status</th>
                                    <th>Time</th>
                                 </tr>
                                 </thead>
                                <?php
                                $sql="select * from payment  where status='1' order by id desc";
                               
                                $result11=mysqli_query($con,$sql);
                                
                                if(mysqli_num_rows($result11))
                                {
                                
                                $i=1;
                                while($rows11=mysqli_fetch_assoc($result11))
                                {
                                $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
                                ?>
                                <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $rows11['name'];?></td>
                                <td><?php echo $rows11['email'];?></td>
                                 <!--<td><?php echo $rows11['payfor'];?></td>-->
                                <!--<td><?php echo $rows11['message'];?></td>-->
                                <!--<td><?php echo $rows11['amount'];?></td>-->
                                <td><?php echo $rows11['status']==0?'Not Paid':' <span style="color:green"><b><i class="fa fa-check"></i> Paid</b></span>';?></td>
                                <td><?php $date_variable= $rows11['creat_at'];  echo date('d-M-Y H:i:s',strtotime($date_variable));?></td>
                                </tr>
                                <?php $i++;}}?>
                            </table>   
                              
                           </div>
                        </div>
                     </div>
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
      <?php include './layout/footer_scripts.php';?>
   </body>
</html>