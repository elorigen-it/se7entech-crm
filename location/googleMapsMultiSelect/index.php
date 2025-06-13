<?php
session_start();
include('../../config/config.php');
if(!isset($_SESSION['email']))
{
    echo "<script>window.location.href='https://crm.se7entech.net/'</script>";
 }

else
{
   include('../../connection.php');
    $logid=$_SESSION['email'];
 	$sql = "select * from invoice_user where email='admin@se7entech.net'";
	$res = mysqli_query($con,$sql);
	$firstnameme=mysqli_fetch_assoc($res);
    $agent_name = $firstnameme['first_name'];  
 }	
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>best software Company in bensenville, il</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<link rel="shortcut icon" href="../../images/fav.png" type="image/x-icon" />
<link rel="apple-touch-icon" href="../../images/logo.png" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:title" content="Se7entech Corporation" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://se7entech.net/" />
<meta property="og:image" content="https://se7entech.net/images/fav.png" />

 </head>
<style>

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
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <style>
        .input-icons i {
            position: absolute;
        }
     </style>
    <body onLoad="initGeolocation();">
        <a class="btn btn-primary" href="<?php echo $base_url;?>/Pin-Location"><i class="fa fa-arrow-left" aria-hidden="true"></i> Go back</a>
    <?php
    include('../../connection.php');
    if(isset($_POST['save']))
    
    {
        $rand = (rand(1111,9999));
        $address = $_POST['address'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $name = $_POST['city'];
        $direction_link = "http://maps.google.com/maps?f=q&source=s_q&hl=en&q=$address";
        $icons = $_POST['icon'];
        $icon = "https://crm.se7entech.net/images/$icons";
        $imgname = $rand.$_FILES['image']['name'];
        // $imgurl ="https://crm.se7entech.net/images/$imgname";
        $notes = $_POST['name'];
        $client_name = $_POST['client_name'];
        $lead = $_GET['lead'];
        
        if(empty($_FILES['image']['name']))
                    {
                      $updatefile = "https://asvs.in/wp-content/uploads/2017/08/dummy.png";
                    }
                    
                    else
                    {
                       $updatefile = "https://crm.se7entech.net/images/$imgname"; 
                       if(move_uploaded_file( $_FILES['image']['tmp_name'], '../../images/'.$imgname));
                    }
        
        $sql = "insert into colleges (address,lat,lng,city,direction_link,icon,image,name,client_name,logid,agent_name) value ('$address','$lat','$lng','$name','$direction_link','$icon','$updatefile','$notes','$client_name','$logid','$agent_name')";
        $date = mysqli_query($con,$sql);
        
        if($lead='Yes')
        {
            $sql="insert into lead (name,address,notes,logid)values('$client_name','$address','$notes','$logid')";
            $result=mysqli_query($con,$sql);
        }
           
        if(mysqli_affected_rows($con)==1)
        {
            echo "<script>alert(Added)</script>";
            echo "<script>window.location.href='../../Pin-Location'</script>";
        }
        
        else
        {
            echo "<script>alert(Failed)</script>";
        }
    }
    ?>
<div class="col-sm-12 input-icons" style="padding-top:5px">
<form method="POST" class="form" enctype="multipart/form-data">
<i style="padding-top: 14px;" class="fa fa-map-marker"></i>
 <input style="height:40px;border-style:solid;border-color:white"  name="address" id="map-search" class="input-field controls form-control" type="text" placeholder="Search Address">
</div>
           
<div style="width:100%;height:100%;overflow:hidden" id="map-canvas"></div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
     <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filled Automatically When you drag marker</h4>
      </div>
      <div class="modal-body">
       <div class="row">
           
           <!--<div class="col-sm-12" style="padding-top:5px">-->
           <!--    <input  name="address" id="map-search" class="controls form-control" type="text" placeholder="Address">-->
           <!--</div>-->
           
           <div class="col-sm-12" style="padding-top:5px">
               <input placeholder="Latitude"  name="lat" type="text" class="latitude form-control">
           </div>
           
           <div class="col-sm-12" style="padding-top:5px">
              <input placeholder="Longitite"  name="lng" type="text" class="longitude form-control"> 
           </div>
           
           <div class="col-sm-12" style="padding-top:5px">
               <input placeholder="City"  name="city" type="text" class="reg-input-city form-control" placeholder="City">
           </div>
           
           <div class="col-sm-12" style="padding-top:5px">
               <input placeholder="Customer Name" required  name="client_name" type="text" class="reg-input-city form-control">
           </div>
           
           <div class="col-sm-12" style="padding-top:5px">
               <input  name="image" type="file" class="reg-input-city form-control">
           </div>
           
           <div class="col-sm-12" style="padding-top:5px">
               <textarea  name="name" type="text" class="reg-input-city form-control" placeholder="Notes"></textarea>
           </div>
           
           <div class="col-sm-12" style="padding-top:5px">
              <p>Convert in lead/client....?</p>
              
              <select name="lead" class="form-control">
                  <option value="No">---Choose---</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
              </select>
              
            </div>
                      
                        <div class="col-sm-12 scrolls" style="padding-top:10px">
                        <audio id="myAudio">
                        <source src="mixkit-video-game-mystery-alert-234.wav.ogg" type="audio/ogg">
                        <source src="mixkit-video-game-mystery-alert-234.wav" type="audio/mpeg">
                        Your browser does not support the audio element.
                        </audio>
                       <b>Choose Marker</b>
                          <?php
                        include('../../connection.php');
                        $sql="select * from icons order by id desc";
                        $result11=mysqli_query($con,$sql);
                        
                        
                        if(mysqli_num_rows($result11))
                        {
                        
                        while($rows11=mysqli_fetch_assoc($result11))
                        {
                        ?> 
                            <input 
                            type="radio" name="icon" 
                            id="sad<?= $rows11['id'];?>" value="<?= $rows11['icon'];?>" class="input-hidden" />
                            <label for="sad<?= $rows11['id'];?>">
                            <img onclick="playAudio()" style="height:50px;width:48px;border-style:solid;border-width:1px;border-radius:3px;padding:7px;" src="../../images/<?= $rows11['icon'];?>">
                             
                            </label> 
                        <?php }}?>
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
                        </div>
                        </div>
                        <center><button style="width:100%;border-radius:0px" type="submit" name="save" class="btn btn-danger"><i class="fa fa-map-pin"></i> Save</button></center>
                       
                       </form>
       
    </div>

  </div>
</div>
<div class="grid-container">
<div class="grid-item"><form action="index.php">
<INPUT TYPE="hidden" NAME="long" ID="long" VALUE="" onblur="getVal()">
<INPUT TYPE="hidden" NAME="lat" ID="lat" VALUE="">
<center style="padding-top:5px;padding-bottom:5px"><button class="btn btn-success" type="submit" placeholder="Enter text"><i class="fa fa-map-marker"></i> Update Your Location</button></center>
</form></div>
<div class="grid-item"> 
 <center style="padding-top:5px"><button class="btn btn-danger" data-toggle="modal" data-target="#myModal"><i class="fa fa-map-pin"></i> <?=  $firstnameme['id'];?> f Save Now</button></center>
</div>
</div>
<hr>
<br>
 <?php
 if(empty($_GET['long']))
 {
     echo "<script>window.location.href='https://crm.se7entech.net/location/googleMapsMultiSelect/index.php?long=-87.9473532&lat=41.9605386'</script>";
 }
 
 else {
          echo "";

 }
 ?>
<script>

function getVal() {
  const val = document.querySelector('input').value;
  console.log(val);
}
function initGeolocation()
     {
        if(navigator.geolocation)
        {
           // Call getCurrentPosition with success and failure callbacks
           navigator.geolocation.getCurrentPosition( success, fail );
        }
        else
        {
           alert("Sorry, your browser does not support geolocation services.");
        }
     }

     function success(position)
     {

         document.getElementById('long').value = position.coords.longitude;
         document.getElementById('lat').value = position.coords.latitude
         
      }

     function fail()
     {
        // Could not obtain location
     }

    function initialize() {

	var mapOptions, map, marker, searchBox, city,
		infoWindow = '',
		addressEl = document.querySelector( '#map-search' ),
		latEl = document.querySelector( '.latitude' ),
		longEl = document.querySelector( '.longitude' ),
		element = document.getElementById( 'map-canvas' );
	city = document.querySelector( '.reg-input-city' );

	mapOptions = {
		// How far the maps zooms in.
		zoom: 18,
		// Current Lat and Long position of the pin/
// 		center: new google.maps.LatLng(43.12594948882426, -89.40703074062499),
		center : {
			lat: <?= $_GET['lat'];?>,
			lng: <?= $_GET['long'];?>
			
		},
		disableDefaultUI: false, // Disables the controls like zoom control on the map if set to true
		scrollWheel: true, // If set to false disables the scrolling on the map.
		draggable: true, // If set to false , you cannot move the map around.
	 };
 
	// Create an object map with the constructor function Map()
	map = new google.maps.Map( element, mapOptions ); // Till this like of code it loads up the map.

	/**
	 * Creates the marker on the map
	 *
	 */
	marker = new google.maps.Marker({
		position: mapOptions.center,
		map: map,
		icon: 'icon.png',
		draggable: true,
 	 	});

	/**
	 * Creates a search box
	 */
	searchBox = new google.maps.places.SearchBox( addressEl );

	/**
	 * When the place is changed on search box, it takes the marker to the searched location.
	 */
	google.maps.event.addListener( searchBox, 'places_changed', function () {
		var places = searchBox.getPlaces(),
			bounds = new google.maps.LatLngBounds(),
			i, place, lat, long, resultArray,
			addresss = places[0].formatted_address;

		for( i = 0; place = places[i]; i++ ) {
			bounds.extend( place.geometry.location );
			marker.setPosition( place.geometry.location );  // Set marker position new.
		}

		map.fitBounds( bounds );  // Fit to the bound
		map.setZoom( 15 ); // This function sets the zoom to 15, meaning zooms to level 15.
		// console.log( map.getZoom() );

		lat = marker.getPosition().lat();
		long = marker.getPosition().lng();
		latEl.value = lat;
		longEl.value = long;

		resultArray =  places[0].address_components;

		// Get the city and set the city input value to the one selected
		for( var i = 0; i < resultArray.length; i++ ) {
			if ( resultArray[ i ].types[0] && 'administrative_area_level_2' === resultArray[ i ].types[0] ) {
				citi = resultArray[ i ].long_name;
				city.value = citi;
			}
		}

		// Closes the previous info window if it already exists
		if ( infoWindow ) {
			infoWindow.close();
		}
		/**
		 * Creates the info Window at the top of the marker
		 */
		infoWindow = new google.maps.InfoWindow({
			content: addresss
		});

		infoWindow.open( map, marker );
	} );


	/**
	 * Finds the new position of the marker when the marker is dragged.
	 */
	google.maps.event.addListener( marker, "dragend", function ( event ) {
		var lat, long, address, resultArray, citi;

		console.log( 'i am dragged' );
		lat = marker.getPosition().lat();
		long = marker.getPosition().lng();

		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { latLng: marker.getPosition() }, function ( result, status ) {
			if ( 'OK' === status ) {  // This line can also be written like if ( status == google.maps.GeocoderStatus.OK ) {
				address = result[0].formatted_address;
				resultArray =  result[0].address_components;

				// Get the city and set the city input value to the one selected
				for( var i = 0; i < resultArray.length; i++ ) {
					if ( resultArray[ i ].types[0] && 'administrative_area_level_2' === resultArray[ i ].types[0] ) {
						citi = resultArray[ i ].long_name;
						console.log( citi );
						city.value = citi;
					}
				}
				addressEl.value = address;
				latEl.value = lat;
				longEl.value = long;

			} else {
				console.log( 'Geocode was not successful for the following reason: ' + status );
			}

			// Closes the previous info window if it already exists
			if ( infoWindow ) {
				infoWindow.close();
			}

			/**
			 * Creates the info Window at the top of the marker
			 */
			infoWindow = new google.maps.InfoWindow({
				content: address
			});

			infoWindow.open( map, marker );
		} );
	});


}
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPuU44PV_rJh0QMPy32nk1aRiil-aGzgw&libraries=places&callback=initialize"></script>
</body>
</html>
 