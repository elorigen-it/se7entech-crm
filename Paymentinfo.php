<?php 
   session_start();
   require_once './config/config.php';
   require_once './config/connection.php';
   require_once './access.php';

if(isset($_POST['save']))
{
$secretkey=$_POST["secretkey"];
$publickey=$_POST["publickey"];
 
$sql="insert into paymentinfo (secretkey,publickey)values('$secretkey','$publickey')";

$result=mysqli_query($con,$sql);
 
if(mysqli_affected_rows($con)==1)
{
    echo "<script>alert('Added');</script>";
	header("location:Paymentinfo");
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
      <title>Se7entech Corporation</title>
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
               <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Add Client</a>
            </li>
             
            <li class="nav-item">
               <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-users mr-2"></i>Client List</a>
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
                                    <h3 class="mb-0">Client Management</h3>
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
                                             <label class="form-control-label" for="name">Client Name</label>
                                             <input   type="text" name="name"  class="form-control form-control" placeholder="Client's Name"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Email Address</label>
                                             <input  type="text" name="email"  class="form-control form-control" placeholder="Email Address"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Phone</label>
                                             <input  type="text" name="phone"  class="form-control form-control" placeholder="Phone"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Address</label>
                                             <input  type="text" name="address"  class="form-control form-control" placeholder="Address"    >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Business Name</label>
                                             <input   type="text" name="businessname"  class="form-control form-control" placeholder="Business Name"    >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Note</label>
                                             <input  type="text" name="notes"  class="form-control form-control" placeholder="Note" >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">File <sup>Optional</sup></label>
                                             <input  type="file" name="file"  class="form-control form-control" placeholder="Note" >
                                          </div>
                                         </div>
                                    </div>
                                    <div class="text-center">
                                       <button type="submit" name="save" class="btn btn-success mt-4">Save</button>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Business Name</th>
                                    <th>Notes</th>
                                    <th>Images</th>
                                    <th>Setting</th>
                                </tr>
                                 </thead>
                                <?php
                                $sql="select * from clients order by id desc";
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
                                <td><?php echo $rows11['phone'];?></td>
                                <td><?php echo $rows11['address'];?></td>
                                <td><?php echo $rows11['businessname'];?></td>
                                <td><?php echo $rows11['notes'];?></td>
                                <td><img style="height:100px;width:100px" src="images/Clients/<?php echo $rows11['file'];?>"></td>
                                <td><a href="Delete?t=clients&id=<?php echo $rows11['id'];?>&u=<?php echo $actual_link;?>"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a> <button class="btn btn-success"><i class="fa fa-pencil"></i></button></td>
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