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
 ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include './layout/head.php';?>
      <title>Se7entech Corporation - Questionair list</title>
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
                        <span style="color:white">Copy Url To Share:</span> <span style="color:yellow">https://se7entech.net/questionair?i=<?= $log?></span>
                     </li>
                     
                     <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-users mr-2"></i>Data List</a>
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
                      
                     <!-- Tab Apps -->
                     <!-- Tab Location -->
                     <div class="tab-pane fade active show" id="menagment" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card card-profile shadow">
                           <div class="card-header">
                              <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" class="form-control">
                           </div>
                           <div class="card-body" style="overflow-x:auto;">
                             <table id="myTable" class="table table-bordered table-striped">
                               <thead style="background:#337ab7;color:white;"> 
                                <tr>
                                     <th>Sr No.</th>
                                     <th>Brand name</th>
                                     <th>Service or Product</th>
                                      <th>View</th>
                                    <th>Setting</th>
                                </tr>
                                 </thead>
                                <?php
                                if($log==123456)
                                {
                                    $select = "";
                                    
                                }
                                
                                else
                                {
                                    $select = "where logid='$log'";
                                }
                                $sql="select * from questioner $select order by id desc";
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
                                <td><?php echo $name= $rows11['a'];?></td>
                                <td><?php echo $phone= $rows11['b'];?></td>
                                <td><a target="_blank" href="questionair?id=<?= $rows11['id'];?>">View</a></td>
                                <td><a style="background:black;padding:10px;color:white;border-radius:3px;" href="Delete?t=questioner&id=<?php echo $rows11['id'];?>&u=<?php echo $actual_link;?>"><i class="fa fa-trash"></i></a> 

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