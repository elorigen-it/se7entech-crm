<?php
session_start(); //session start always on top.
require_once './config/config.php';
require_once './config/connection.php';
require_once './access.php'; //inside access.php you already have $con variable without importing it there.

$id = $_GET['i'];
$ress=mysqli_query($con,"select * from invoice_user where id='$id'");
$rowclientclient=mysqli_fetch_assoc($ress);
$random = $rowclientclient['rand'];
if(isset($_POST['save']))
{
$name=$_POST["name"];
$email=$_POST["email"];
$phone=$_POST["mobile"];
$designation=$_POST['designation'];


$sql="update invoice_user set  first_name='$name',email='$email',mobile='$phone',designation='$designation' where id='$id'";
$result=mysqli_query($con,$sql);

if($result=mysqli_query($con,$sql)==1)
{
    echo "<script>alert('Updated');</script>";
    echo "<script>window.location.href='agentdata';</script>";
    
 }
else{
	echo "<script>alert('No changes you did');</script>";
}

}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include './layout/head.php';?>
      <title>Se7entech Corporation - Edit agent</title>
      
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
                        <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-pencil"></i> Update Info</a>
                     </li>
                     
                     <!--<li class="nav-item">-->
                     <!--   <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-image"></i> Image/Docs Update</a>-->
                     <!--</li>-->
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
                                    <h3 class="mb-0">Agent Management</h3>
                                 </div>
                                 <!--<div class="col-4 text-right">-->
                                 <!--   <a target="_blank" href="https://feeder.henkakoplus.in/restaurant/kundan"-->
                                 <!--      class="btn btn-sm btn-success">View it</a>-->
                                 <!--</div>-->
                              </div>
                           </div>
                            
                           <div class="card-body">
                              <h6 class="heading-small text-muted mb-4">Update information</h6>
                              <div class="pl-lg-4">
                                 
                                 <form id="restorant-form" method="POST"  autocomplete="off" enctype="multipart/form-data">
                                     <div class="row">
                                       <div class="col-md-4">
                                           <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Client Name</label>
                                             <input   type="text" name="name" value="<?php echo $rowclientclient['first_name']; echo $rowclientclient['last_name'];?>"  class="form-control form-control" placeholder="Client's Name"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Email Address</label>
                                             <input  type="text" name="email" value="<?php echo $rowclientclient['email'];?>"  class="form-control form-control" placeholder="Email Address"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                           <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Phone</label>
                                             <input  type="text" name="mobile" value="<?php echo $rowclientclient['mobile'];?>"  class="form-control form-control" placeholder="Phone"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                           <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Designation</label>
                                             <input  type="text" name="designation" value="<?php echo $rowclientclient['designation'];?>"  class="form-control form-control" placeholder="Designation"  required >
                                          </div>
                                         </div>
                                         
                                         
                                    </div>
                                      
                                    <div class="text-center">
                                       <button type="submit"  name="save" class="btn btn-success mt-4">Save</button>
                                    </div>
                                 </form>
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Tab Apps -->
                     <!-- Tab Location -->
                     
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