<?php
session_start(); //session start always on top.
require_once './envloader.php';
require_once './config/config.php';
require_once './config/connection.php';
require_once './access.php'; //inside access.php you already have $con variable without importing it there.
 
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include './layout/head.php';?>
      <title>Se7entech Corporation - Model</title>
     
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
                     <a target="blank" class="nav-link mb-sm-3 mb-md-0 active"   href="../Model"     aria-selected="true"><i class="fa fa-female"></i> Add New</a>
                  </li>
                  
                  <!--<li class="nav-item">-->
                  <!--   <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-users mr-2"></i>Client List</a>-->
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
                      
                     <!-- Tab Apps -->
                     <!-- Tab Location -->
                     <div class="tab-pane fade show active" id="location" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card card-profile shadow">
                           <div class="card-header">
                              <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" class="form-control">
                           </div>
                           <div class="card-body" style="overflow-x:auto;">
                <table id="myTable" class="table table-bordered table-striped">
                <thead style="background:#337ab7;color:white;"> 
                <tr>
				  <th>Sno.</th>
				  <th>Name</th>
				  <th>View</th>
				  <th>Action</th>
				  </tr>
                </thead>
                    <tbody>
                    <?php
                    if($where=='Model')
                    {
                        $wh = "where  trashd<>'1'";
                    }
                    
                    else{}
                    $sql="select * from model $wh  ORDER BY id DESC";
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
                    <td>
                    <a  class="btn btn-success"  target="blank" href="../Model/modelcontractprint?id=<?php echo $rows11['rand'];?>"> <i class="fa fa-print"></i> Print Document</a>
                     <span class="btn btn-dark" onclick="GeeksForGeeks()" title="Click To Copy Url"><l class="fa fa-share"></l> Model Signature</span>
                    <input type="text" readonly value="<?php echo $base_url;?>/Model/sign1?id=<?php echo $rows11['rand'];?>" id="GfGInput" style="width:10px">
                    
                    <span class="btn btn-dark" onclick="GeeksForGeekss()" title="Click To Copy Url"><l class="fa fa-share"></l> Representative Signature</span>
                    <input type="text" readonly value="<?php echo $base_url;?>/Model/sign2?id=<?php echo $rows11['rand'];?>" id="GfGInputt" style="width:10px">
                    
                    <!--<a  target="blank" class="btn btn-warning"  href="update.php?rand=<?php echo $rows11['rand'];?>"><i class="fa fa-pencil"></i> Update Contract</a>-->
                    </td> 
                    
                    <td>
                    
                    <a  class="btn btn-danger" href="<?php echo $access=='0'?'admindelete':'otherdelete'?>?t=model&id=<?php echo $rows11['id'];?>&u=<?php echo $actual_link;?>" title="You want to delete permanently?"> <i class="fa fa-trash"></i> <?php echo $rows11['trashd']==2?'Deleted by agent':'Delete permanently'?></a>
                    </td> 
                    </tr>
                    <?php
                    $i++;
                    
                    }
                    ?>
                    
                    <?php
                    
                    }
                    else
                    {
                    ?>
                    <div style=" padding:15px; margin-top:10px;">
                    
                    <h4 style="text-align:center;color:red;"><b>Sorry ! No result found..!</b></h4>
                    </div>
                    <?php
                    }
                    ?>
                    
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
         function GeeksForGeeks() {
         /* Get the text field */
         var copyGfGText = document.getElementById("GfGInput");
         
         /* Select the text field */
         copyGfGText.select();
         
         /* Copy the text inside the text field */
         document.execCommand("copy");
         
         /* Alert the copied text */
         alert("Copied the text: " + copyGfGText.value);
         }
         
         function GeeksForGeekss() {
         /* Get the text field */
         var copyGfGText = document.getElementById("GfGInputt");
         
         /* Select the text field */
         copyGfGText.select();
         
         /* Copy the text inside the text field */
         document.execCommand("copy");
         
         /* Alert the copied text */
         alert("Copied the text: " + copyGfGText.value);
         }
      </script> 
      
   </body>
</html>