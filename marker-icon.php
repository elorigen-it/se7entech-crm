<?php
session_start(); //session start always on top.
require('./vendor/autoload.php');
require_once './envloader.php';
require_once './config/config.php';
require_once './config/connection.php';
require_once './access.php'; //inside access.php you already have $con variable without importing it there.
use Se7entech\Contractnew\Middlewares\hasFilledRequirementForm;
    $validate = new hasFilledRequirementForm();
    $validate->handle(0);
if(isset($_POST['save']))
{
$rand = (rand(11111111,99999999));	
$result=mysqli_query($con,$sql);
$extension=array('jpeg','jpg','png','gif');
foreach ($_FILES['image']['tmp_name'] as $key => $value) {
   $filename=$rand.$_FILES['image']['name'][$key];
   $filename_tmp=$_FILES['image']['tmp_name'][$key];
   echo '<br>';
   $ext=pathinfo($filename,PATHINFO_EXTENSION);

   $finalimg='';
   if(in_array($ext,$extension))
   {
      if(!file_exists('images/'.$filename))
      {
      move_uploaded_file($filename_tmp, 'images/'.$filename);
      $finalimg=$filename;
      }else
      {
            $filename=str_replace('.','-',basename($filename,$ext));
            $newfilename=$filename.time().".".$ext;
            move_uploaded_file($filename_tmp, 'images/'.$newfilename);
            $finalimg=$newfilename;
      }
      $creattime=date('Y-m-d h:i:s');
      //insert
      $insertqry="INSERT INTO `icons`( `icon`, `rand`) VALUES ('$finalimg','$rand')";
      mysqli_query($con,$insertqry);

echo "<script>alert('Added');</script>";
header("location:marker-icon");
}
   else
   {
echo "<script>alert('added');</script>";
   }
}

}
 
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include './layout/head.php';?>
      <title>Se7entech Corporation - Marker icon</title>
      
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
                        <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-users mr-2"></i>Icon List</a>
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
                                    <h3 class="mb-0">Icon Management</h3>
                                 </div>
                                 <!--<div class="col-4 text-right">-->
                                 <!--   <a target="_blank" href="https://feeder.henkakoplus.in/restaurant/kundan"-->
                                 <!--      class="btn btn-sm btn-success">View it</a>-->
                                 <!--</div>-->
                              </div>
                           </div>
                           <div class="card-body">
                              <h6 class="heading-small text-muted mb-4">Add Icons</h6>
                              <div class="pl-lg-4">
                                 
                                 <form id="restorant-form" method="POST"   autocomplete="off" enctype="multipart/form-data">
                                     <div class="row">
                                         <div class="col-md-4">
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">File(Multiple)<sup>size:48x48</sup></label>
                                             <input type="file" accept=".pdf,.doc,.png,.jpg,.jpeg,.xls,.docs"  name="image[]" class="form-control" multiple  class="form-control" placeholder="Note" >
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
                           <!--<div class="card-header">-->
                           <!--   <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" class="form-control">-->
                           <!--</div>-->
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
                                $sql="select * from icons order by id desc";
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
                                 
                                 <td><img style="height:48px;width:48px" src="images/<?= $rows11['icon'];?>" title="icons"></td>
                                <td><a href="Delete?t=icons&id=<?php echo $rows11['id'];?>&u=<?php echo $actual_link;?>"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
                                
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