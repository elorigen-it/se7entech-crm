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
$name=$_POST["name"];
$email=$_POST["email"];
$phone=$_POST["phone"];
$designation = $_POST['designation'];
 
  $sql="insert into invoice_user (first_name,email,mobile,designation)values('$name','$email','$phone','$designation')";

$result=mysqli_query($con,$sql);
 
if(mysqli_affected_rows($con)==1)
{
    echo "<script>alert('Added');</script>";
	header("location:agentdata");
}
else{
	echo "<script>alert('Already Added');</script>";
}

}
?> 
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include './layout/head.php';?>
      <title>Se7entech Corporation - Agent data</title>
      <style>
         .shared-links:hover{
            cursor:pointer;
         }
      </style>
   </head>
   
   <body class="">
      
      <?php include ('sidebar.php'); ?>
      <div class="main-content">
      <?php include ('nav.php'); ?>
 
         <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
            <div class="container-fluid">
               <div class="nav-wrapper">
                  <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
                     <li class="nav-item" style="<?php  if($access=='1'){echo 'visibility:hidden';}else{}?>">
                        <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment"  role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Add Agent</a>
                     </li>
                     
                     <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-list"></i> Data List</a>
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
                      <div class="tab-pane fade show <?php  if($access=='0'){echo 'active';}else{}?>" id="menagment" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="<?php  if($access=='1'){echo 'visibility:hidden';}else{}?>">
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
                              <h6 class="heading-small text-muted mb-4">Add information</h6>
                              <div class="pl-lg-4">
                                 
                                 <form id="restorant-form" method="POST"   autocomplete="off" enctype="multipart/form-data">
                                     <div class="row">
                                       <div class="col-md-4">
                                           <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Agent Name</label>
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
                                             <label class="form-control-label" for="name">Designation</label>
                                             <input  type="text" name="designation"  class="form-control form-control" placeholder="Designation"  required >
                                          </div>
                                         </div>
                                          
                                    </div>
                                    <div class="text-center">
                                      <input type="submit" name="save" style="background:blue;border:none;color:white;border-radius:2px"  value="save"> 
                                    </div>
                                 </form>
                                 <br>
                                 <div class="card card-profile shadow">
                           <div class="card-header">
                              <input type="text" id="myInputt" onkeyup="myFunctionn()" placeholder="Search for names.." title="Type in a name" class="form-control">
                           </div>
                           <div class="card-body" style="overflow-x:auto;">
                             <table class="table" id="myTablee">
                        <thead class="thead-dark" >
                        <tr>
                          <th style="color:white">#</th>
                          <th style="color:white">Agent Name</th>
                          <th style="color:white">Email</th>
                          <th style="color:white">Phone</th>
                          <th style="color:white">Otp <des title="use for login"><i class="fa fa-question-circle"></i></des></th>
                           
                          <th style="color:white">Action</th>
                          
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql="select * from invoice_user  order by id desc";
                            $result11=mysqli_query($con,$sql);
                            
                            if(mysqli_num_rows($result11))
                            {
                            
                            $i=1;
                            while($rows11=mysqli_fetch_assoc($result11))
                            {
                            
                            ?>
                        <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $rows11['first_name'];?> <?php echo $rows11['last_name'];?></td>
                        <td><?php echo $rows11['email'];?></td>
                        <td><?php echo $rows11['mobile'];?></td>
                        <td><?php echo $rows11['password'];?></td>
                        
                        <td><a style="background:green;padding:7px;color:white;border-radius:3px;" href="Delete?t=invoice_user&id=<?php echo $rows11['id'];?>&u=<?php echo $actual_link;?>"><i class="fa fa-trash"></i></a>
                        <a style="background:green;padding:7px;color:white;border-radius:3px;" href="agent-edit?i=<?= $rows11['id'];?>" ><i class="fa fa-edit"></i> </a></td>
                        

                            </tr>
                             <?php $i++;}}?>
                          </tbody>
                        </table>  
                                                      
                           </div>
                        </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Tab Apps -->
                     
                     <!-- Tab Location -->
                     <div class="tab-pane fade tab-pane fade show <?php  if($access=='1'){echo 'active';}else{}?>" id="location" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card card-profile shadow">
                           <div class="card-header">
                              <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" class="form-control">
                           </div>
                           <div class="card-body" style="overflow-x:auto;">
                              <table class="table" id="myTable">
                                 <thead class="thead-dark" >
                                    <tr>
                                       <th style="color:white">#</th>
                                       <th style="color:white">Your Name</th>
                                       <th style="color:white">Your business name here</th>
                                       <th style="color:white">Your phone number goes here</th>
                                       <th style="color:white">Best email here </th>
                                       <th style="color:white">Address, City & State </th>
                                       <th style="color:white">If so, please provide the URL (Example: www.applestore.com): </th>
                                       <th style="color:white"> Your industry here</th>
                                       <th style="color:white">What makes your business unique? </th>
                                       <th style="color:white">URL's (or at least names) of your top 3 competitors. </th>
                                       <th style="color:white">What are the greatest strengths of your business? </th>
                                       <th style="color:white">Will you sell goods directly online? </th>
                                       <th style="color:white">Is you business register or you want to register? </th>
                                       <th style="color:white">Would you like a new logo? </th>
                                       <th style="color:white">Do you want help with print materials such as business cards or brochures? </th>
                                       <th style="color:white">How many pages do you estimate your website will need? </th>
                                       <th style="color:white">What is your budget? </th>
                                       <th style="color:white">Appointment booking, blog, event calendar….more </th>
                                       <th style="color:white">Love blue but hate green? Let me know here... </th>
                                       <th style="color:white">Your launch date here </th>
                                       <th style="color:white">Do you want to monetize your website or blog with AdSense or affiliate programs? </th>
                                       <th style="color:white">Would you like new photos for your website? </th>
                                       <th style="color:white">Do you want a photo gallery on your website? (Typically included) </th>
                                       <th style="color:white">How much content writing do you need for your website? </th>
                                       <th style="color:white">Do you want help with Video production or edit? (This is a separate service) </th>
                                       <th style="color:white">Do you need help setting up social media? </th>
                                       <th style="color:white">What kind of personality do you want your website to have? (Check all that apply) </th>
                                       <th style="color:white">What are the main reasons for having a new website? </th>
                                       <th style="color:white">What conundrum can we help solve? </th>
                                       <th style="color:white">Website URL's that you like go here. Why? </th>
                                       <th style="color:white">Share your vision </th>
                                       <th style="color:white">Would you like to obtain marketing advice? </th>
                                       <th style="color:white">Action</th>
                                       
                                    </tr>
                                 </thead>
                                 <tbody>
                                       <?php
                                       $sql="select * from web_info $data   order by id desc";
                                       $result11=mysqli_query($con,$sql);
                                       
                                       if(mysqli_num_rows($result11))
                                       {
                                       
                                       $i=1;
                                       while($rows11=mysqli_fetch_assoc($result11))
                                       {
                                       
                                       ?>
                                       <tr>
                                          <td><?php echo $i;?></td>
                                          <td><?php echo $rows11['a'];?></td>
                                          <td><?php echo $rows11['b'];?></td>
                                          <td><?php echo $rows11['c'];?></td>
                                          <td><?php echo $rows11['d'];?></td>
                                          <td><?php echo $rows11['e'];?></td>
                                          <td><?php echo $rows11['f'];?></td>
                                          <td><?php echo $rows11['g'];?></td>
                                          <td><?php echo $rows11['h'];?></td>
                                          <td><?php echo $rows11['i'];?></td>
                                          <td><?php echo $rows11['j'];?></td>
                                          <td><?php echo $rows11['k'];?></td>
                                          <td><?php echo $rows11['l'];?></td>
                                          <td><?php echo $rows11['m'];?></td>
                                          <td><?php echo $rows11['n'];?></td>
                                          <td><?php echo $rows11['currency'];?><?php echo $rows11['o'];?></td>
                                          <td><?php echo $rows11['p'];?></td>
                                          <td><?php echo $rows11['q'];?></td>
                                          <td><?php echo $rows11['r'];?></td>
                                          <td><?php echo $rows11['s'];?></td>
                                          <td><?php echo $rows11['t'];?>, <?php echo $rows11['u'];?>, <?php echo $rows11['u'];?>, <?php echo $rows11['v'];?>,<?php echo $rows11['w'];?></td>
                                          
                                          <td><?php echo $rows11['x'];?></td>
                                          <td><?php echo $rows11['y'];?></td>
                                          <td><?php echo $rows11['z'];?></td>
                                          <td><?php echo $rows11['aa'];?>, <?php echo $rows11['bb'];?>, <?php echo $rows11['cc'];?>,<?php echo $rows11['dd'];?>, <?php echo $rows11['ee'];?></td>
                                          
                                          <td><?php echo $rows11['ff'];?></td>
                                          <td><?php echo $rows11['vv'];?>,<?php echo $rows11['uu'];?>,<?php echo $rows11['tt'];?>,<?php echo $rows11['ss'];?>,<?php echo $rows11['rr'];?>,<?php echo $rows11['qq'];?>,<?php echo $rows11['pp'];?>,<?php echo $rows11['oo'];?>,<?php echo $rows11['nn'];?>,<?php echo $rows11['mm'];?>,<?php echo $rows11['gg'];?>, <?php echo $rows11['hh'];?>,<?php echo $rows11['ii'];?>,<?php echo $rows11['jj'];?>,<?php echo $rows11['kk'];?>,<?php echo $rows11['ll'];?></td>
                                          
                                          <td><?php echo $rows11['ww'];?></td>
                                          <td><?php echo $rows11['xx'];?></td>
                                          <td><?php echo $rows11['yy'];?></td>
                                          <td><?php echo $rows11['zz'];?></td>
                                          <td><?php echo $rows11['marketing_advice'];?></td>
                                          <td><a style="background:red;padding:7px;color:white;border-radius:3px;" href="Delete?t=web_info&id=<?php echo $rows11['id'];?>&u=<?php echo $actual_link;?>"><i class="fa fa-trash"></i></a>
                                          <!--<span class="btn btn-dark" onclick="kun()" title="Click To Copy Url"><l class="fa fa-share"></l></span>-->
                                          
                                          <span style="color:red">copy link to share:</span><br><p class="shared-links" onclick="GeeksForGeeks(this)"><?php $lin=$rows11['id']; echo "se7entech.net/shared-data?id=$lin";?></p>
                                          </td>                    
                                       </tr>
                                    <?php $i++;}}?>
                                 </tbody>
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
      <script>
         function selectElementText(el, win) {
            win = win || window;
            var doc = win.document, sel, range;
            if (win.getSelection && doc.createRange) {
               sel = win.getSelection();
               range = doc.createRange();
               range.selectNodeContents(el);
               sel.removeAllRanges();
               sel.addRange(range);
               return sel;

            }
            return false;
         }
         function GeeksForGeeks(el) {
            /* Get the text field */
            let sel = selectElementText(el)
            if(sel){
               /* Select the text field */         
               /* Copy the text inside the text field */
               document.execCommand("copy");
               
               /* Alert the copied text */
               alert("Copied the text: " + sel.toString());

            }
         }
         
      </script> 
      
   </body>
</html>