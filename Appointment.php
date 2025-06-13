<?php
session_start(); //session start always on top.
require_once './config/config.php';
require_once './config/connection.php';
require_once './access.php'; //inside access.php you already have $con variable without importing it there.

if(isset($_POST['save']))
{
$cemail=$_POST["cemail"];
$message=$_POST["notes"];
$date=$_POST["date"];
$subject=$_POST['subject'];

$res=mysqli_query($con,"select * from clients where email='$cemail'");
$row=mysqli_fetch_assoc($res);
$namee =$row['name'];
 
$sql="insert into appointment (clientname,email,notes,logid,date,agentname)values('$namee','$cemail','$message','$logid','$date','$name')";
$result=mysqli_query($con,$sql);
 
if(mysqli_affected_rows($con)==1)
{
    
         $email_subject = $subject;
   
        $message =
        '<br>Agent name: '.$name.'
        <br>Appointment Date: '.$date.'
        <br>Message: '.$message.''; 

   	                 
     $to = $cemail;
  
    $headers = "MIME-Version: 1.0" . "\r\n"; 
    $headers = "Content-type:text/html;charset=UTF-8" . "\r\n"; 
    $headers = 'From: Appointment  <info@se7entech.us>' . PHP_EOL .
    'Reply-To: Appointment  <info@se7entech.us>' . PHP_EOL .
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
      <title>Se7entech Corporation - Appointment</title>
      
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
                        <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Add New</a>
                     </li>
                     
                     <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-users mr-2"></i>Appointment List</a>
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
                                    <h3 class="mb-0">Appointment Management</h3>
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
                                             <label class="form-control-label" for="name">Client To-------------- <span style="color:#f7fafc !important">-----</span></label>
                                             <select style="width:100%" name="cemail"  class="form-control" placeholder="Client's Email"  required >
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
                                             <label class="form-control-label" for="name">Subject</label>
                                             <input  type="text" name="subject"  class="form-control"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Date/Time</label>
                                             <input  type="datetime-local" name="date"  class="form-control"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Notes</label>
                                             <textarea name="notes"  class="form-control" placeholder="Enter Message"  ></textarea>
                                          </div>
                                         </div>
                                       
                                       <div style="visibility: hidden;">
                                    <select class="form-control">
                                    <option></option>
                                    </select>
                                    </div>
                                    </div>
                                    <div class="text-center">
                                       <input type="submit" name="save" style="background:blue;border:none;color:white;border-radius:2px"  value="save"> 

                                    </div>
                                    
                                 </form>
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Tab Apps -->
                     <!-- Tab Location -->
                     <div class="tab-pane fade show" id="location" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card card-profile shadow">
                           <div class="card-header">
                              <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" class="form-control">
                           </div>
                           <div class="card-body" style="overflow-x:auto;">
                             <table id="myTable" class="table table-bordered table-striped">
                               <thead style="background:#337ab7;color:white;"> 
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Client Name</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                    <th>Notes</th>
                                    <th>Appointment sent time</th>
                                    <th>Setting</th>
                                </tr>
                                 </thead>
                                <?php
                                $sql="select * from appointment order by id desc";
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
                                <td><?php echo $rows11['clientname'];?></td>
                                <td><?php echo $rows11['email'];?></td>
                                <td><?php echo $rows11['date'];?></td>
                                <td><?php echo $rows11['notes'];?></td>
                                <td><?php $datetet = $rows11['creat'];  echo date('d-M-Y H:i:s',strtotime($datetet));?></td>
                                <td><a style="background:red;padding:7px;color:white;border-radius:3px;" href="Delete?t=appointment&id=<?php echo $rows11['id'];?>&u=<?php echo $actual_link;?>"><i class="fa fa-trash"></i></a></td>
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