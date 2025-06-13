<?php
session_start(); //session start always on top.
require_once './config/config.php';
require_once './config/connection.php';
require_once './access.php'; //inside access.php you already have $con variable without importing it there.

$id = $_GET['id'];
$ress=mysqli_query($con,"select * from clients where id='$id'");
$rowclientclient=mysqli_fetch_assoc($ress);
$random = $rowclientclient['rand'];
if(isset($_POST['save']))
{
$rand = (rand(11111111,99999999));	
$name=$_POST["name"];
$email=$_POST["email"];
$phone=$_POST["phone"];
$address=$_POST["address"];
$businessname=$_POST["businessname"];
$notes=$_POST["notes"];

$sql="update clients set  name='$name',email='$email',phone='$phone',address='$address',businessname='$businessname',notes='$notes'  where id='$id'";
$result=mysqli_query($con,$sql);

if($result=mysqli_query($con,$sql)==1)
{
    echo "<script>alert('Updated');</script>";
    echo "<script>window.location.href='Client';</script>";
    
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
      <title>Se7entech Corporation - Update Client</title>

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
                        <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-pencil"></i> Basic Info</a>
                     </li>
                     
                     <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-image"></i> Image/Docs Update</a>
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
                              <h6 class="heading-small text-muted mb-4">Update information</h6>
                              <div class="pl-lg-4">
                                 
                                 <form id="restorant-form" method="POST"  autocomplete="off" enctype="multipart/form-data">
                                     <div class="row">
                                       <div class="col-md-4">
                                           <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Client Name</label>
                                             <input   type="text" name="name" value="<?php echo $rowclientclient['name'];?>"  class="form-control form-control" placeholder="Client's Name"  required >
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
                                             <input  type="text" name="phone" value="<?php echo $rowclientclient['phone'];?>"  class="form-control form-control" placeholder="Phone"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Address</label>
                                             <input  type="text" name="address" value="<?php echo $rowclientclient['address'];?>"  class="form-control form-control" placeholder="Address"    >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Business Name</label>
                                             <input   type="text" name="businessname" value="<?php echo $rowclientclient['businessname'];?>"  class="form-control form-control" placeholder="Business Name"    >
                                          </div>
                                         </div>
                                            
                                         <!--<div class="col-md-4">-->
                                          
                                         <!-- <div id="form-group-name" class="form-group  ">-->
                                         <!--    <label class="form-control-label" for="name">File <sup>Optional</sup></label>-->
                                         <!--    <input  type="file" name="file"  class="form-control form-control" placeholder="Note" >-->
                                         <!-- </div>-->
                                         <!--</div>-->
                                         
                                         <div class="col-md-12">
                                          
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Note</label>
                                             <textarea name="notes" value="<?php echo $rowclientclient['notes'];?>"  class="form-control form-control" placeholder="Note" style="height:200px"></textarea>
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
                                    <th>Images</th>
                                    <th>Setting</th>
                                </tr>
                                 </thead>
                                
                               <?php
                                 if(isset($_POST['filesave']))
                                {
                                    $rand = (rand(11111,99999));
                                    $imagefile = $rand.$_FILES['file']['name'];                      
                                    $fileid = $_POST['id'];
                                    
                                    $sqll="update  clientfile set file='$imagefile' where id='$fileid'";
                                    $resulte=mysqli_query($con,$sqll);
                                    
                                    if(move_uploaded_file( $_FILES['file']['tmp_name'], 'images/Clients/'.$imagefile))
                                     
                                    if(mysqli_affected_rows($con)==1)
                                    
                                     {
                                        echo "<script>alert('Updated');</script>";
                                        echo "<script>window.location.href='Client';</script>";
                                      }
                                      
                                    else
                                    {
                                    echo "<script>alert('sorry! unable to insert..');</script>";
                                    }
                                }
                                $id = $_GET['id'];
                                $sql="select * from clientfile where rand ='$random'  order by id desc";
                                $result11=mysqli_query($con,$sql);
                                
                                if(mysqli_num_rows($result11))
                                {
                                
                                $i=1;
                                while($rows11=mysqli_fetch_assoc($result11))
                                {
                                $actual_link = 'Client';
                               
                                 ?>
                                
                                <tr>
                                <td><?php echo $i;?></td>
                                <td><embed style="height:120px;width:120px;" src="images/Clients/<?php echo $rows11['file'];?>" title="Update"></embed>
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="file"  accept=".doc, .docx, .xlx, .png, .jpg, .jpeg, .pdf" name="file">
                                    <input type="hidden" name="id" value="<?php echo $rows11['id'];?>">
                                </td>
                                <td> 
                                <button type="submit" name="filesave" class="btn btn-success"><i class="fa fa-pencil"></i> Update</button> 
                                </form>
                                <a href="images/Clients/<?php echo $rows11['file'];?>"><button class="btn btn-warning"><i class="fa fa-eye"></i></button></a>
                                <a href="Delete?t=clientfile&id=<?php echo $rows11['id'];?>&u=<?php echo $actual_link;?>"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
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