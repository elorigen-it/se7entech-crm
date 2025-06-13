<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

session_start(); //session start always on top.
require('./vendor/autoload.php');
require_once './envloader.php';
require_once './config/config.php';
require_once './config/connection.php';
require_once './access.php'; //inside access.php you already have $con variable without importing it there.
require_once './education.php';
use Se7entech\Contractnew\Middlewares\hasFilledRequirementForm;
    $validate = new hasFilledRequirementForm();
    $validate->handle(0);

mysqli_query($con,"SET NAMES 'utf8mb4' COLLATE 'utf8mb4_general_ci'");

if(isset($_SESSION['email']))	
{
	$logid=$_SESSION['email'];
	$res=mysqli_query($con,"select * from invoice_user where email='$logid'");
	$row=mysqli_fetch_assoc($res);
	$access = $row['status'];
	$name = $row['first_name'];
	
	if($access=='0')
	{}
	else
	{
	    $data = "where logid='$logid'";
	}	
?>
 
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include './layout/head.php';?>
      <title>Se7entech Corporation</title>
      <style>
         html, body {
         overflow-x: hidden;
         }
         .input-hidden {
         position: absolute;
         left: -9999px;
         }

         input[type=radio]:checked + label>img {
         border: 1px solid #fff;
         box-shadow: 0 0 3px 3px #090;
         }

         input[type=radio]:checked + label>img {
         transform: 
         rotateZ(-10deg) 
         rotateX(10deg);
         }



         .scrolls {
         overflow-x: scroll;
         overflow-y: hidden;
         height: 100px;
         white-space:nowrap;
         }
         .grid-container {
         display: grid;
         grid-template-columns: auto auto;
         }
      </style>
      <style type="text/css">
         /* .container {
            height: 450px;
         } */
         #map {
            width: 100%;
            height: 100%;
            border: 1px solid blue;
         }
         #data, #allData {
            display: none;
         }
      </style>
      <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
   </head>
   <body class="">      
      <?php include ('sidebar.php'); ?>
      <div class="main-content">
         <?php  include ('nav.php'); ?>
         <?php //  include ('access.php'); ?>
         <div class="header bg-gradient-info pb-6 pt-5 pt-md-8"> 
            <div class="container-fluid">
               <div class="nav-wrapper">
                  <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active " href="location/googleMapsMultiSelect" ><i class="fa fa-map-marker"></i> Pined Location</a>
                     </li>
                     
                     <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main2" data-toggle="tab" href="#locationn" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-download"></i> Download & View Data</a>
                     </li>
                     
                     <!--<li class="nav-item">-->
                     <!--   <a class="nav-link mb-sm-3 mb-md-0" id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-plus"></i> Pin New Location</a>-->
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
                                    <h3 class="mb-0">Pin Location</h3>
                                 </div>
                              </div>
                           </div>
                           <div class="card-body">
                              <div class="pl-lg-12"> 
                                 <div class="container-fluid" style="height:600px;width:100%">
                                    <?php 
                                       
                                       $edu = new education();
                                       $coll = $edu->getCollegesBlankLatLng();
                                       $coll = json_encode($coll, true);
                                       echo '<div id="data">' . $coll . '</div>';
                              
                                       $allData = $edu->getAllColleges();
                                       $allData = json_encode($allData, true);
                                       echo '<div id="allData">' . $allData . '</div>';
                                    ?> 
                                    <div id="map"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Tab Apps -->
                     <!-- Tab Location -->
                     <div class="tab-pane fade show" id="location" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card card-profile shadow">   
                           <div class="card-body" style="overflow-x:auto;">
                              <form id="restorant-form" method="GET" action="pininsert.php"   autocomplete="off" enctype="multipart/form-data">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div id="form-group-name" class="form-group">
                                          <label class="form-control-label" for="name">Client Name</label>
                                          <input id="cname" type="text" size="50" placeholder="Enter a Name" autocomplete="on" runat="server"  type="text" name="client_name"  class="form-control">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div id="form-group-name" class="form-group">
                                          <label class="form-control-label" for="name">Email</label>
                                          <input id="cemail" type="text" size="50" placeholder="Enter a Email" autocomplete="on" runat="server"  type="text" name="cemail"  class="form-control">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div id="form-group-name" class="form-group">
                                          <label class="form-control-label" for="name">Phone</label>
                                          <input id="phone" type="text" size="50" placeholder="Enter a Phone" autocomplete="on" runat="server"  type="text" name="phone"  class="form-control">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div id="form-group-name" class="form-group">
                                          <label class="form-control-label" for="name">Address</label>
                                          <input id="searchTextField" type="text" size="50" placeholder="Enter a Address" autocomplete="on" runat="server"  type="text" name="address"  class="form-control">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div id="form-group-name" class="form-group">
                                          <label class="form-control-label" for="name">Url</label>
                                          <input id="url" type="text" size="50" placeholder="Enter a Url" autocomplete="on" runat="server"  type="text" name="url"  class="form-control">
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div id="form-group-name" class="form-group">
                                          <label class="form-control-label" for="name">Note</label>
                                          <textarea style="height:200px" name="notes"  class="form-control" placeholder="Note" ></textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="text-center">
                                    <button type="submit" name="save" class="btn btn-success mt-4">Save
                                    </button>
                                 </div>
                              </form>   
                           </div>
                        </div>
                     </div>
                    <?php
                     if(isset($_POST['update'])){
                        $id = $_POST['id'];
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $phone = $_POST['phone'];
                        $url = $_POST['url'];
                        $notes = $_POST['notes'];
                        
                        // $imgvalue = $_POST['imgvalue'];
                        // $imgname = $_FILES['image']['name'];
                        
                        $imagesql = "select * from colleges where id='$id'";
                        $res = mysqli_query($con,$imagesql);
                        $datas = mysqli_fetch_assoc($res);
                        $imgvalue = $datas['image'];
                        $iconmap = $datas['icon'];
                    
                        if(empty($_FILES['image']['name'])){
                           $updatefile = "$imgvalue";
                        }else{
                           $updatefile = 'https://crm.se7entech.net/images/'.$_FILES['image']['name']; 
                        }
                     
                        // next
                        if(empty($_POST['icon'])){
                           $icons = "$iconmap";
                        }else{
                           $icons = 'https://crm.se7entech.net/images/'.$_POST['icon']; 
                        }
                        
                        $sql = "update colleges set client_name='$name',email='$email',phone='$phone',url='$url',name='$notes',image='$updatefile',icon='$icons' where id='$id'";
                        $result = mysqli_query($con,$sql);
                        if(move_uploaded_file( $_FILES['image']['tmp_name'], 'images/'.$imgname)){
                           if(mysqli_affected_rows($con)==1){
                                 echo "<script>window.location.href='https://crm.se7entech.net/Pin-Location'</script>";
                                 echo "<script>alert('Update Status: Success');</script>";
                           }else{
                                 echo "<script>alert('Update Status: Failed');</script>";
                           }
                        }
                     }
                    ?>
                     <div class="tab-pane fade show" id="locationn" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card card-profile shadow">
                           <?php
                              if (isset($_POST["but_delete"])) {
                                 if (isset($_POST["delete"])) {
                                       foreach ($_POST["delete"] as $deleteid) {
                                          $deleteUser = "DELETE FROM `colleges` WHERE id=" . $deleteid;
                                          mysqli_query($con, $deleteUser);
                                       }
                                 }
                              }
                              if (isset($_POST["assignbtn"])) {
                                 $id = $_POST["id"];
                                 $assignid = $_POST["logid"];
                                 $assign = "update colleges set logid='$assignid' WHERE id='$id'";
                                 mysqli_query($con, $assign);
                                 if (mysqli_affected_rows($con) == 1) {
                                       echo "<script>alert('This Lead Assign To $assignid');</script>";
                                 } else {
                                       echo "<script>alert('Try Again !');</script>";
                                 }
                              }
                           ?>
                           <div class="card-body" style="overflow-x:auto;">
                              <div class="row">
                                 <a href="export-data"><h4 class="btn btn-primary"><i class="fa fa-download"></i> Export</h4></a>
                                 <form method='post' action=''>
                                    <button type='submit' value='Delete' name='but_delete' class="btn btn-danger"><i class="fa fa-check"></i> Delete</button>
                                    <div class="card-header">
                                       <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" class="form-control">
                                    </div>
                                    <table class="table" id="myTable">
                                       <tr>
                                          <th>Check</th>
                                          <th>Client Name</th>
                                          <th>Email</th>
                                          <th>Phone</th>
                                          <th>Notes</th>
                                          <th>Date</th>
                                          <th style="<?=($access==0)?'':'display:none';?>">Assign To</th>
                                          <th>Action</th>
                                       </tr>
                                       <?php
                                          $sql="select * from colleges $data  order by id desc";
                                          $result11=mysqli_query($con,$sql);
      
                                          if(mysqli_num_rows($result11)){
                                          $i=1;
                                          while($data=mysqli_fetch_assoc($result11)){
                                          ?>

                                          <tr>
                                             <td><input type='checkbox' name='delete[]' value='<?= $data['id'] ?>' ></td>
                                             <td><?= $data['client_name'];?></td>
                                             <td><?= $data['email'];?></td>
                                             <td><?= $data['phone'];?></td>
                                             <td>
                                                <details>
                                                   <summary>View</summary>
                                                   <?= $data['name'];?>
                                                </details> | 
                                                <a target="_blank" href="<?= $data['image'];?>">img</a> | 
                                                <a target="blank" href="<?= $data['url'];?>" style="color:blue">Click</a> | 
                                                <a target="blank" href="<?= $data['direction_link'];?>" style="color:blue" target="blank">Direction</a>
                                             </td>
                                             <!--<td><details><summary>View</summary><? //= $data['address'];?></details></td>-->
                                              
                                             <td><?= date("d-m-Y", strtotime($data['date']));?></td>
                                             <td style="<?=($access==0)?'':'display:none';?>"><?= $data['logid'];?></td>
                                             <td style="<?=($access==0)?'':'display:none';?>">
                                                <form method="POST"> 
                                                   <input type="hidden" value="<?= $data['id'];?>" name="id">
                                                   <select class="d" name="logid" style="width:150px">
                                                      <option value="#">--Agent--</option>
                                                      <?php
                                                         $sql="select * from invoice_user  order by id desc";
                                                         $result110=mysqli_query($con,$sql);
                                                         
                                                         if(mysqli_num_rows($result11)){
                                                            while($agent=mysqli_fetch_assoc($result110)){
                                                         ?>
                                                               <option value="<?= $agent['email'];?>"><?php echo $agent['first_name'];?> <?php echo $agent['last_name'];?></option>
                                                      <?php }
                                                         }?>
                                                   </select>
                                                   <button name="assignbtn" type="submit" class="btn btn-success">Assign</button>
                                                </form>
                                             </td>
                                             <td> 
                                                <a target="blank" href="make-appointment?i=<?= $data['id'];?>" class="btn btn-dark">Appointment</a> 
                                                <a title="Update info"  data-toggle="modal" data-target="#myModal<?= $data['id'];?>" class="btn btn-primary" href="#">
                                                   <i class="fa fa-edit" style="color:white"></i>
                                                </a>
                                             </td>
                                             <div id="myModal<?= $data['id'];?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                             
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                   <div class="modal-header">
                                                   <h4 class="modal-title">Pinned Location</h4>
                                                </div>
                                                <div class="modal-body">
                                                   <h2>Update Clients Pin Information</h2>
                                                   <form method="POST" enctype="multipart/form-data">
                                                      <input type="hidden" name="id" value="<?= $data['id'];?>">
                                                      <input type="hidden"  name="imgvalue" value="<?= $data['image'];?>">
                                                      <div class="form-group"><input value="<?= $data['client_name'];?>" type="text" class="form-control" name="name" placeholder="Client's Name"></div>
                                                      <div class="form-group"><input value="<?= $data['email'];?>" type="email" class="form-control" name="email" placeholder="Email"></div>
                                                      <div class="form-group"><input value="<?= $data['phone'];?>" type="number" class="form-control" name="phone" placeholder="Phone"></div>
                                                      <div class="form-group"><input value="<?= $data['url'];?>" type="url" class="form-control" name="url" placeholder="Url"></div>
                                                      <div class="form-group"><input  type="file" accept="image/*" class="form-control" name="image" placeholder="image"></div>
                                                
                                                      <div class="form-group"><div class="col-sm-12 scrolls" style="padding-top:10px">
                                                         <!-- <audio id="myAudio">
                                                         <source src="mixkit-video-game-mystery-alert-234.wav.ogg" type="audio/ogg">
                                                         <source src="mixkit-video-game-mystery-alert-234.wav" type="audio/mpeg">
                                                         Your browser does not support the audio element.
                                                         </audio> -->
                                                         <!--<b>Choose Marker</b>-->
                                                         <?php
                                                            $sql="select * from icons order by id desc";
                                                            $result111=mysqli_query($con,$sql);
                                                            if(mysqli_num_rows($result111)){
                                                               while($rows11=mysqli_fetch_assoc($result111)){
                                                         ?> 
                                                               <input type="radio" name="icon" id="sad<?= $rows11['id'];?>" value="<?= $rows11['icon'];?>" class="input-hidden" />
                                                               <label for="sad<?= $rows11['id'];?>">
                                                                  <!-- <img onclick="playAudio()" style="height:50px;width:48px;border-style:solid;border-width:1px;border-radius:3px;padding:7px;" src="images/<?= $rows11['icon'];?>"> -->
                                                                  <img onclick="playAudio()" style="height:50px;width:48px;border-style:solid;border-width:1px;border-radius:3px;padding:7px;" src="images/<?= $rows11['icon'];?>">
                                                               </label> 
                                                            <?php }
                                                            }?>
                                                      </div>
                                                   </form>
                                                   <div class="form-group"><textarea  class="form-control" name="notes"><?= $data['name'];?></textarea></div>
                                                   <button class="btn btn-default" type="submit" name="update">Update</button>
                                                   <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                             </div>
                                         </tr>
                                       <?php }}?>  
                                    </table>   
                                 <form>
                              </div>
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
      <script>
         var x = document.getElementById("myAudio"); 
         
         function playAudio() { 
         x.play(); 
         } 
         
         function pauseAudio() { 
         x.pause(); 
         } 
      </script>
      <?php include './layout/footer_scripts.php';?>
      <!-- <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script> -->
      <script type="text/javascript" src="<?php echo $base_url;?>/js/googlemap.js?i=<?php echo (rand(111,999));?>"> 	</script>
                           
      <!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPuU44PV_rJh0QMPy32nk1aRiil-aGzgw&libraries=places&callback=loadMap"></script>-->
      <script type="text/javascript"   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPuU44PV_rJh0QMPy32nk1aRiil-aGzgw&callback=loadMap" async defer></script>    
   </body>
</html>
<?php
}
else
{
header("location:index.php");
}
?>