<script>
if ( window.history.replaceState ) {
window.history.replaceState( null, null, window.location.href );
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<?php
include ('access.php');
include('connection.php');
 ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Se7entech Corporation</title>
      <!-- Favicon -->
      <link rel="apple-touch-icon" sizes="180x180" href="images/fav.png">
      <link rel="icon" type="image/png" sizes="32x32" href="images/fav.png">
      <link rel="icon" type="image/png" sizes="16x16" href="images/fav.png">
      <link rel="stylesheet"
         href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <!-- Fonts -->
      <link href="css/gfonts.css" rel="stylesheet">
      <!-- Icons -->
      <link href="css/nucleo.css" rel="stylesheet">
      <link href="css/all.min.css" rel="stylesheet">
      <!-- Argon CSS -->
      <link type="text/css" href="css/argon.css?i=<?php echo (rand(111,222))?>" rel="stylesheet">
      <!-- Argon CSS -->
      <link type="text/css" href="css/custom.css" rel="stylesheet">
      <!-- Select2 -->
      <link type="text/css" href="css/select2.min.css" rel="stylesheet">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="css/jasny-bootstrap.min.css">
      <!-- Flatpickr datepicker -->
      <link rel="stylesheet" href="css/flatpickr.min.css">
      <!-- Font Awesome Icons -->
      <link href="css/font-awesome.css" rel="stylesheet" />
      <!-- Lottie -->
       
      <!-- Range datepicker -->
      <link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
      <!-- Web Application Manifest -->
      <link rel="manifest" href="manifest.json">
      <!-- Chrome for Android theme color -->
      <meta name="theme-color" content="#000000">
      <!-- Add to homescreen for Chrome on Android -->
      <meta name="mobile-web-app-capable" content="yes">
       <link rel="icon" sizes="256x256" href="android-chrome-256x256.png">
      <!-- Add to homescreen for Safari on iOS -->
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
       <!-- Tile for Win8 -->
      <meta name="msapplication-TileColor" content="#ffffff">
      <meta name="msapplication-TileImage"
         content="android-chrome-256x256.png">
       
      <!-- CSS Files -->
      <link rel="stylesheet"
         href="vendor/intltelinput/build/css/intlTelInput.css">
      <style type="text/css">
         .iti__flag {background-image: url("/vendor/intltelinput/build/img/flags.png");}
         @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
         .iti__flag {background-image: url("/vendor/intltelinput/build/img/flags@2x.png");}
         }
      </style>
      <script src="vendor/intltelinput/build/js/intlTelInput.js"></script>
      <script src="vendor/intltelinput/build/js/utils.js"></script>
      <!-- Custom CSS defined by admin -->
      <link type="text/css" href="byadmin/back.css" rel="stylesheet">
   </head>
   <body class="">
      
      <?php   include ('sidebar.php'); ?>
      <div class="main-content">
         <?php  include ('nav.php'); ?>
 
         <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
   <div class="container-fluid">
      <div class="nav-wrapper">
         <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
            <li class="nav-item">
               <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Upload Video</a>
            </li>
             
            <li class="nav-item">
               <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-users mr-2"></i>Video List</a>
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
                                    <h3 class="mb-0">Video Management</h3>
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
                                 
                                 <form id="uploadForm" enctype="multipart/form-data">
                                     <div class="row">
                                       <!--<div class="col-md-6">-->
                                       <!--    <div id="form-group-name" class="form-group  ">-->
                                       <!--      <label class="form-control-label" for="name">Title</label>-->
                                       <!--      <input   type="text" name="title"  class="form-control" placeholder="Enter Title"  required >-->
                                       <!--   </div>-->
                                       <!--  </div>-->
                                          
                                         <div class="col-md-6">
                                           <div id="form-group-name" class="form-group  ">
                                             <label class="form-control-label" for="name">Upload File(Multiple)</label>
                                             <input type="file" name="images[]" id="fileInput" multiple  class="form-control"   accept="video/*">
                                          </div>
                                          <div id="uploadStatus"></div>
                                         </div>
                                         
                                         <!--<div class="col-md-12">-->
                                         <!-- <div id="form-group-name" class="form-group">-->
                                         <!--    <label class="form-control-label" for="name">Note</label>-->
                                         <!--    <textarea style="height:200px" name="notes"  class="form-control" placeholder="Note" ></textarea>-->
                                         <!-- </div>-->
                                         <!--</div>-->
                                    </div>
                                    <div class="text-center">
                                       <button type="submit" name="submit" class="btn btn-primary" value="UPLOAD">Upload</button>
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
                                    <th>File Name</th>
                                    <th>Video</th>
                                    <th>Setting</th>
                                </tr>
                                 </thead>
                                <?php
                                include('connection.php');
                                $sql="select * from videos order by id desc";
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
                                <td><?= $rows11['file'];?></td>
                                   <td><a target="blank" href="video-player?id=<?php echo $rows11['rand'];?>" title="Click to open"><i class="fa fa-eye btn btn-warning"></i></a></td>
                                <td><a href="Delete?t=videos&id=<?php echo $rows11['id'];?>&u=<?php echo $actual_link;?>"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a> 
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
      <script>
 $(document).ready(function(){
    // File upload via Ajax
    $("#uploadForm").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'upload.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#uploadStatus').html('<img src="uploading.gif"/>');
            },
            error:function(){
                $('#uploadStatus').html('<span style="color:#EA4335;">Video upload failed, please try again.<span>');
            },
            success: function(data){
                $('#uploadForm')[0].reset();
                $('#uploadStatus').html('<span style="color:#28A74B;">Video uploaded successfully.<span>');
                $('.gallery').html(data);
            }
        });
    });
    
    // File type validation
    $("#fileInput").change(function(){
        var fileLength = this.files.length;
        var match= ["video/mp4","image/jpg","image/gif"];
        var i;
        for(i = 0; i < fileLength; i++){ 
            var file = this.files[i];
            var imagefile = file.type;
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3]))){
                alert('Please select a valid image file (JPEG/JPG/PNG/GIF/MP4).');
                $("#fileInput").val('');
                return false;
            }
        }
    });
});
</script>
      
   </body>
</html>