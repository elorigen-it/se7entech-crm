<script>
if ( window.history.replaceState ) {
window.history.replaceState( null, null, window.location.href );
}
</script>
 
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
      <script
         src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
      <!-- Range datepicker -->
      <link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
      <!-- Web Application Manifest -->
      <link rel="manifest" href="manifest.json">
      <!-- Chrome for Android theme color -->
      <meta name="theme-color" content="#000000">
      <!-- Add to homescreen for Chrome on Android -->
      <meta name="mobile-web-app-capable" content="yes">
      <meta name="application-name" content="FeederQR Menu">
      <link rel="icon" sizes="256x256" href="android-chrome-256x256.png">
      <!-- Add to homescreen for Safari on iOS -->
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <meta name="apple-mobile-web-app-title" content="FeederQR Menu">
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
      
      <?php // include ('sidebar.php'); ?>
      <div class="main-content">
         <?php  // include ('nav.php'); ?>
 
         <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
   <div class="container-fluid">
      <div class="nav-wrapper">
         <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
            <li class="nav-item">
               <a class="nav-link mb-sm-3 mb-md-0 active " href="location/googleMapsMultiSelect" ><i class="fa fa-map-marker"></i> Pined Location</a>
            </li>
             
             <li class="nav-item">
               <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main2" data-toggle="tab" href="#locationn" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-download"></i> Download & View</a>
            </li>
            
            <li class="nav-item">
               <a class="nav-link mb-sm-3 mb-md-0" id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-plus"></i> Pin New Location</a>
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
                                    <h3 class="mb-0">Pin Location</h3>
                                 </div>
                                 <!--<div class="col-4 text-right">-->
                                 <!--   <a target="_blank" href="https://feeder.henkakoplus.in/restaurant/kundan"-->
                                 <!--      class="btn btn-sm btn-success">View it</a>-->
                                 <!--</div>-->
                              </div>
                           </div>
                           <div class="card-body">
                               <div class="pl-lg-4">
                                <!DOCTYPE html>
<html>
<head>
 	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	
	
	<style type="text/css">
		.container {
			height: 450px;
		}
		#map {
			width: 100%;
			height: 100%;
			border: 1px solid blue;
		}
		#data, #allData {
			display: none;
		}
	</style>
</head>
<body>
    
	<div class="container">
 		<?php 
			require 'education.php';
			$edu = new education;
			$coll = $edu->getCollegesBlankLatLng();
			$coll = json_encode($coll, true);
			echo '<div id="data">' . $coll . '</div>';

			$allData = $edu->getAllColleges();
			$allData = json_encode($allData, true);
			echo '<div id="allData">' . $allData . '</div>';
	 ?> 
		<div id="map"></div>
	</div>
	<script type="text/javascript">
	    var map;
var geocoder;

function loadMap() {
	var Se7etech = {lat: 41.9605625, lng: -87.9482674};
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: Se7etech,
    
    });

    var marker = new google.maps.Marker({
      position: Se7etech,
      map: map,
      icon: {
    url: "https://crm.se7entech.net/images/iconlocation.png"
    }
    });

    var cdata = JSON.parse(document.getElementById('data').innerHTML);
    geocoder = new google.maps.Geocoder();  
    codeAddress(cdata);

    var allData = JSON.parse(document.getElementById('allData').innerHTML);
    showAllColleges(allData);
  
}

function showAllColleges(allData) {
	var infoWind = new google.maps.InfoWindow;
	Array.prototype.forEach.call(allData, function(data){
	    var content = document.createElement('div');
	<?php
        include('connection.php');
        $sql="select * from colleges order by id desc";
        $result11=mysqli_query($con,$sql);
         
        while($rows11=mysqli_fetch_assoc($result11))
        {
        ?>
	
	  
		var img = document.createElement('img');
        img.src = 'images/store_image/<?= $rows11['image'];?>';
        img.style.width = '100px';
        content.appendChild(img);
         
	    
        var marker = new google.maps.Marker({
        position: new google.maps.LatLng(<?= $rows11['lat'];?>, <?= $rows11['lng'];?>),
        map: map,
        icon: {
        url: "images/store_image/<?= $rows11['icon'];?>"
        }
        });
        
  <?php }?>
	    marker.addListener('mouseover', function()
	         {
	    	infoWind.setContent(data.name);
	     	infoWind.open(map, marker);
	          });
	         
	    
	})
}

function codeAddress(cdata) {
   Array.prototype.forEach.call(cdata, function(data){
    	var address = data.name + ' ' + data.address;
	    geocoder.geocode( { 'address': address}, function(results, status) {
	      if (status == 'OK') {
	        map.setCenter(results[0].geometry.location);
	        var points = {};
	        points.id = data.id;
	        points.lat = map.getCenter().lat();
	        points.lng = map.getCenter().lng();
	        updateCollegeWithLatLng(points);
	      } else {
	        alert('Geocode was not successful for the following reason: ' + status);
	      }
	    });
	});
}

function updateCollegeWithLatLng(points) {
	$.ajax({
		url:"action.php",
		method:"post",
		data: points,
		success: function(res) {
			console.log(res)
		}
	})
	
}
	</script>
</body>
 
</html>
 <!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPuU44PV_rJh0QMPy32nk1aRiil-aGzgw&libraries=places&callback=loadMap"></script>-->
  <script type="text/javascript"   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPuU44PV_rJh0QMPy32nk1aRiil-aGzgw&callback=loadMap" async defer></script>    
       
                                 
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
                                       <button type="submit" name="save" class="btn btn-success mt-4">Save</button>
                                    </div>
                                 </form>   
                              
                           </div>
                        </div>
                     </div>
                    <?php
                    include('connection.php');
                    if(isset($_POST['update']))
                    
                    {
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $phone = $_POST['phone'];
                    $url = $_POST['url'];
                    $notes = $_POST['notes'];
                    
                    $sql = "update colleges set client_name='$name',email='$email',phone='$phone',url='$url',name='$notes' where id='$id'";
                    $result = mysqli_query($con,$sql);
                    
                    if(mysqli_affected_rows($con)==1)
                    
                    {
                        echo "<script>alert('Update Status: Success');</script>";
                    }
                    
                    else{
                        echo "<script>alert('Update Status: Failed');</script>";
                    }
                    }
                    ?>
                     <div class="tab-pane fade show" id="locationn" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card card-profile shadow">
                           
                           <div class="card-body" style="overflow-x:auto;">
                             
                                     <div class="row">
                                         <a href="export-data"<h4 class="btn btn-primary"><i class="fa fa-download"></i> Export</h4></a>
                                     <table class="table">
                                         <tr>
                                             <th>Client name</th>
                                             <th>Email</th>
                                             <th>Phone</th>
                                             <th>Address</th>
                                             <th>Lat</th>
                                             <th>Lang</th>
                                             <th>Url</th>
                                             <th>Map</th>
                                             <th>Date</th>
                                             <th>Action</th>
                                         </tr>
                                         
                                         <?php
                                include('connection.php');
                                $sql="select * from colleges where trashd<>'2' order by id desc";
                                $result11=mysqli_query($con,$sql);
                                
                                
                                if(mysqli_num_rows($result11))
                                {
                                
                                $i=1;
                                while($data=mysqli_fetch_assoc($result11))
                                {
                                    ?>
                                    <div id="myModal<?= $data['id'];?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                    
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                    <div class="modal-header">
                                     <h4 class="modal-title">Pinned Location</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h2>Update Clients Pin Information</h2>
                                     
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?= $data['id'];?>">
                                        <div class="form-group"><input value="<?= $data['client_name'];?>" type="text" class="form-control" name="name" placeholder="Client's Name"></div>
                                        <div class="form-group"><input value="<?= $data['email'];?>" type="email" class="form-control" name="email" placeholder="Email"></div>
                                        <div class="form-group"><input value="<?= $data['phone'];?>" type="number" class="form-control" name="phone" placeholder="Phone"></div>
                                        <div class="form-group"><input value="<?= $data['url'];?>" type="url" class="form-control" name="url" placeholder="Url"></div>
                                        <div class="form-group"><textarea  id="summernote" class="form-control" name="notes"><?= $data['name'];?></textarea></div>
                                        <button class="btn btn-prinary" type="submit" name="update">Update</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </form>
                                    </div>
                                     
                                    </div>
                                    
                                    </div>
                                    </div>
                                         <tr>
                                             <td><?= $data['client_name'];?></td>
                                             <td><?= $data['email'];?></td>
                                             <td><?= $data['phone'];?></td>
                                             <td><?= $data['address'];?></td>
                                             <td><?= $data['lat'];?></td>
                                             <td><?= $data['lng'];?></td>
                                             <td><?= $data['url'];?></td>
                                             <td><?= $data['direction_link'];?></td>
                                             <td><?= date("d-m-Y", strtotime($data['date']));?></td>
                                             <td><a class="btn btn-danger" href="otherdelete?u=Pin-Location&id=<?= $data['id'];?>&t=colleges"><i class="fa fa-trash" style="color:white"></i></a><a  data-toggle="modal" data-target="#myModal<?= $data['id'];?>" class="btn btn-primary" href="#"><i class="fa fa-edit" style="color:white"></i></a></td>
                                         </tr>
                                         <?php }}?>
                                     </table>
                                          
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
      </div>
      </div>
      <!-- Commented because navtabs includes same script -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js" type="text/javascript"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <!-- Navtabs -->
      <script src="js/jquery.min.js" type="text/javascript"></script>
      <script src="js/bootstrap-datepicker.min.js"></script>
      <!-- Nouslider -->
      <script src="js/nouislider.min.js" type="text/javascript"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="js/jasny-bootstrap.min.js"></script>
      <!-- Custom js -->
      <script src="js/orders.js"></script>
      <!-- Custom js -->
      <script src="js/mresto.js"></script>
      <!-- AJAX -->
      <!-- SELECT2 -->
      <script src="js/select2.js"></script>
      <script src="js/select2.min.js"></script>
      <!-- DATE RANGE PICKER -->
      <script type="text/javascript" src="js/moment.min.js"></script>
      <script type="text/javascript" src="js/daterangepicker.min.js"></script>
      <!-- All in one -->
      <script src="js/js.js?id=3.2.2"></script>
      <!-- Argon JS -->
      <script src="js/argon.js?v=1.0.0"></script>
      <!-- Import Vue -->
      <script src="js/vue/vue.js"></script>
      <!-- Import AXIOS --->
      <script src="js/axios.min.js"></script>
      <!-- Flatpickr datepicker -->
      <script src="js/flatpickr.js"></script>
      <!-- Notify JS -->
      <script src="js/notify.min.js"></script>
      <!-- Cart custom sidemenu -->
      <script src="js/cartSideMenu.js"></script>
      <!-- OneSignal -->
      <script src="js/rmap.js"></script>
      <!-- Pusher -->
      <!-- Custom JS defined by admin -->
   </body>
</html>