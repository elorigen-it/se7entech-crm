<?php 
   session_start();
   require('./vendor/autoload.php');
   require_once('./envloader.php');
   require_once './config/config.php';
   require_once './config/connection.php';
   require_once './access.php';
   
    use Se7entech\Contractnew\Middlewares\hasFilledRequirementForm;
    $validate = new hasFilledRequirementForm();
    $validate->handle(0);
?>
<script>
if ( window.history.replaceState ) {
window.history.replaceState( null, null, window.location.href );
}
</script>
<?php
if (isset($_POST["save"])) {
    $rand = rand(11111111, 99999999);
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $businessname = $_POST["businessname"];
    $notes = $_POST["notes"];
    $sql = "insert into clients (name,email,phone,address,businessname,notes,logid,rand)values('$name','$email','$phone','$address','$businessname','$notes','$logid','$rand')";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $insert_id = mysqli_insert_id($con);
    }

    $sql = "INSERT INTO customers (type, name, phone, address, email, notes, business_name, status, agent_email, old_refference_table, old_refference_id)
            VALUES ('customer', ?, ?, ?, ?, ?, ?, 0, ?, 'clients', ?)";
    $stmt = mysqli_prepare($con, $sql);
    
    if (!$stmt) {
        $errorMessage = "Error al preparar la consulta: " . mysqli_error($con);
        error_log($errorMessage, 3, "error_log.txt");
        throw new Exception($errorMessage);
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssi",
        $name,
        $phone,
        $address,
        $email,
        $notes,
        $businessname,
        $logid,
        $insert_id
    );

    $success = mysqli_stmt_execute($stmt);

    if (!$success) {
        $errorMessage = "Error al crear el cliente: " . mysqli_error($con);
        error_log($errorMessage, 3, "error_log.txt");
        throw new Exception($errorMessage);
    }
    $extension = ["jpeg", "jpg", "png", "gif", "pdf", "xls", "csv"];
    foreach ($_FILES["image"]["tmp_name"] as $key => $value) {
        $filename = $rand . $_FILES["image"]["name"][$key];
        $filename_tmp = $_FILES["image"]["tmp_name"][$key];
        "<br>";
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        $finalimg = "";
        if (in_array($ext, $extension)) {
            if (!file_exists("images/Clients/" . $filename)) {
                move_uploaded_file(
                    $filename_tmp,
                    "images/Clients/" . $filename
                );
                $finalimg = $filename;
            } else {
                $filename = str_replace(".", "-", basename($filename, $ext));
                $newfilename = $filename . time() . "." . $ext;
                move_uploaded_file(
                    $filename_tmp,
                    "images/Clients/" . $newfilename
                );
                $finalimg = $newfilename;
            }
            $creattime = date("Y-m-d h:i:s");
            //insert
            $insertqry = "INSERT INTO `clientfile`( `file`, `rand`) VALUES ('$finalimg','$rand')";
            mysqli_query($con, $insertqry);

            echo "<script>alert('Added');</script>";
            header("location:Client");
        } else {
            echo "<script>alert('Added');</script>";
        }
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
      
      <?php include ('./sidebar.php'); ?>
      <div class="main-content">
         <?php include ('./nav.php'); ?>
 
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
                                             <input   type="text" name="name"  class="form-control" placeholder="Client's Name"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Email Address</label>
                                             <input  type="text" name="email"  class="form-control" placeholder="Email Address"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Phone</label>
                                             <input  type="text" name="phone"  class="form-control" placeholder="Phone"  required >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Address</label>
                                             <input  type="text" name="address"  class="form-control" placeholder="Address"    >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Business Name</label>
                                             <input   type="text" name="businessname"  class="form-control" placeholder="Business Name"    >
                                          </div>
                                         </div>
                                         
                                         <div class="col-md-4">
                                          
                                          <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">File(Multiple) <sup>Optional</sup></label>
                                             <input type="file" accept=".pdf,.doc,.png,.jpg,.jpeg,.xls,.docs"  name="image[]" class="form-control" multiple  class="form-control" placeholder="Note" >
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
                                       <input type="submit" name="save"style="background:blue;border:none;color:white;border-radius:2px"  value="save"> 
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
                                $sql="select * from clients $data order by id desc";
                                $result11=mysqli_query($con,$sql);
                                
                                
                                if(mysqli_num_rows($result11))
                                {
                                
                                $i=1;
                                while($rows11=mysqli_fetch_assoc($result11))
                                {
                                $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
                                $randd = $rows11['rand'];
                                $repo=mysqli_query($con,"select * from clientfile where rand='$randd'");
	                            $ress=mysqli_fetch_assoc($repo);
                                $image =$ress['file'];  
                                ?>
                                <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $name= $rows11['name'];?></td>
                                <td><?php echo $cemail= $rows11['email'];?></td>
                                <td><?php echo $phone= $rows11['phone'];?></td>
                                <td><?php echo $address =$rows11['address'];?></td>
                                <td><?php echo $bname = $rows11['businessname'];?></td>
                                <td><?php echo $notes = $rows11['notes'];?></td>
                                <td><a target="blank" style="background:black;padding:10px;color:white;border-radius:3px;" href="image?id=<?php echo $randd;?>" title="Click to open"><i class="fa fa-eye"></i></a></td>
                                <td><a style="background:red;padding:10px;color:white;border-radius:3px;" href="Delete?t=clients&id=<?php echo $rows11['id'];?>&u=<?php echo $actual_link;?>"><i class="fa fa-trash"></i></a>
                                <a style="background:green;padding:10px;color:white;border-radius:3px;" href="Client-Update.php?id=<?php echo $rows11['id'];?>"><i class="fa fa-pencil"></i>
                                <a>
                                <?php
                                if(isset($_POST['share'.$i.'']))
                                {
                                // (A) MAIL SETTINGS
                                $mailTo = $cemail;
                                $mailSubject = "Profile Details From Se7entech";
                                
                                // (B) MAIL MESSAGE
                                // HOST THE IMAGE ON YOUR OWN SERVER!
                                // ALSO REMEMBER TO PROVIDE THE DIRECT LINK JUST-IN-CASE
                                $img = "https://crm.se7entech.net/images/Clients/$image";
                                $mailBody = "<img style='height:200px;width:200px' src='$img'/><br>";
                                $mailBody .= "<p>Name=$name</p> 
                                <p>Phone=$phone</p> <p>Address=$address</p>
                                <p>Business Name=$bname</p> <p>Notes=$notes</p><a href='https://crm.se7entech.net/image?id=$randd'>Can't see the image? Click Here.</a>";
                                
                                // (C) HEADER - HTML MAIL
                                $mailHead = "MIME-Version: 1.0" . "\r\n"; 
                                $mailHead = "Content-type:text/html;charset=UTF-8" . "\r\n"; 
                                
                                //   here your sender email
                                $mailHead = 'From: Se7entech <info@se7entech.us>'. "\r\n" .
                                'Reply-To:Se7entech <info@se7entech.us>'. "\r\n" .
                                'Content-type:text/html;charset=UTF-8' . "\r\n".
                                'X-Mailer: PHP/' . phpversion();
                                
                                // (D) SEND
                                if(mail($mailTo, $mailSubject, $mailBody, $mailHead))
                                {
                                echo '<script>alert("Shared");</script>';
                                echo '<script>window.location.href="Client"</script>';
                                }
                                
                                else{
                                echo '<script>alert("Try Again");</script>';
                                }
                                }
                                ?>
                                 <form style="padding-top:5px" method="POST" enctype="multipart/form-data">
                                     <button title="forward to client" type="submit" name="share<?php echo $i;?>" class="btn btn-primary"><i class="fa fa-share"></i></button></form></td>
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