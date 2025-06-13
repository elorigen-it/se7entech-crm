<?php
session_start(); //session start always on top.
require_once './config/config.php';
require_once './config/connection.php';

if(isset($_SESSION['email']))
{
	$logid=$_SESSION['email'];
	$res=mysqli_query($con,"select * from invoice_user where email='$logid'");
	$row=mysqli_fetch_assoc($res);
	$access = $row['status'];
	$name = $row['first_name'];
	
	if($access=='0')
	{
	    
	}
	else
	{
	    $data = "where logid='$logid'";
	}
	
?>
<style>body {
	background-color: #FDF3E7;
}


/* entire container, keeps perspective */
#flip1 .flip-container {
	perspective: 1000px;
}
/* flip the pane when hovered */
#flip1 .flip-container:hover .flipper, #flip1 .flip-container.hover .flipper {
	transform: rotateY(180deg);
	-webkit-transform: rotateY(180deg);
	-moz-transform: rotateY(180deg);
	-ms-transform: rotateY(180deg);
	-o-transform: rotateY(180deg);
}

#flip1 .flip-container, #flip1 .front, .back {
	width: 100%;
	height: 300px;
}

/* flip speed goes here */
#flip1 .flipper {
	transition: 1s;
	-ms-transition: 1s;
	-webkit-transition: 1s;
	-moz-transition: 1s;
	-o-transition: 1s;
	transform-style: preserve-3d;
	position: relative;
}

/* hide back of pane during swap */
#flip1 .front, #flip1 .back {
	backface-visibility: hidden;
	position: absolute;
	top: 0;
	left: 0;
}

/* front pane, placed above back */


/* back, initially hidden pane */
 

/* CSS za Toggle flip */
#flip2 .flip-container:hover .flipper, #flip2 .flip-container.hover .flipper, #flip2 .flip-container.flip .flipper {
	transform: rotateY(180deg);
	-webkit-transform: rotateY(180deg);
	-moz-transform: rotateY(180deg);
	-ms-transform: rotateY(180deg);
	-o-transform: rotateY(180deg);
}
#flip2 .flip-container, .front, .back {
	width: 100%;
	height: 480px;
}

/* flip speed goes here */
#flip2 .flipper {
	transition: 1s;
	-ms-transition: 1s;
	-webkit-transition: 1s;
	-moz-transition: 1s;
	-o-transition: 1s;
	transform-style: preserve-3d;
	position: relative;
}

/* hide back of pane during swap */
#flip2 .front, #flip2 .back {
	backface-visibility: hidden;
	position: absolute;
	top: 0;
	left: 0;
}
 
/*CSS za onClick image flip*/
.flip-container {
    width: 100%;
    height: 480px;
    position: relative;
    -webkit-perspective: 1000px;
    -moz-perspective: 1000px;
    -o-perspective: 1000px;
    perspective: 1000px;
}
.card {
    width: 100%;
    height: 100%;
    position: absolute;
    -webkit-transition: -webkit-transform 1s;
    -moz-transition: -moz-transform 1s;
    -o-transition: -o-transform 1s;
    transition: transform 1s;
    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    -o-transform-style: preserve-3d;
    transform-style: preserve-3d;
    -webkit-transform-origin: 50% 50%;
}
.card div {
    display: block;
    height: 100%;
    width: 100%;
    position: absolute;
    -webkit-backface-visibility: hidden;
    -moz-backface-visibility: hidden;
    -o-backface-visibility: hidden;
    backface-visibility: hidden;
}
 
.card.flipped {
    -webkit-transform: rotateY( 180deg );
    -moz-transform: rotateY( 180deg );
    -o-transform: rotateY( 180deg );
    transform: rotateY( 180deg );
}
 

/*Vertical flip*/

/* entire container, keeps perspective */
#flip4 .flip-container {
	perspective: 1000px;
}
#flip4 .vertical .flip-container {
	position: relative;
}

#flip4 .vertical .back {
	transform: rotateX(180deg);
	-webkit-transform: rotateX(180deg);
	-moz-transform: rotateX(180deg);
	-ms-transform: rotateX(180deg);
	-o-transform: rotateX(180deg);
}

#flip4 .vertical.flip-container .flipper {
	transform-origin: 100% 240px; /* half of height */
}

#flip4 .vertical.flip-container:hover .flipper {
	transform: rotateX(-180deg);
}
#flip4 .flip-container, #flip4 .front, .back {
	width: 100%;
	height: 480px;
}
/* flip speed goes here */
#flip4 .flipper {
	transition: 1s;
	-ms-transition: 1s;
	-webkit-transition: 1s;
	-moz-transition: 1s;
	-o-transition: 1s;
	transform-style: preserve-3d;
	position: relative;
}

/* hide back of pane during swap */
#flip4 .front, #flip4 .back {
	backface-visibility: hidden;
	position: absolute;
	top: 0;
	left: 0;
}
 
/* VERTIKALAN ONCLICK*/
/*CSS za onClick image flip*/
.flip-containerV {
    width: 100%;
    height: 480px;
    position: relative;
    -webkit-perspective: 1000px;
    -moz-perspective: 1000px;
    -o-perspective: 1000px;
    perspective: 1000px;
}
.cardV {
    width: 100%;
    height: 100%;
    position: absolute;
    -webkit-transition: -webkit-transform 1s;
    -moz-transition: -moz-transform 1s;
    -o-transition: -o-transform 1s;
    transition: transform 1s;
    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    -o-transform-style: preserve-3d;
    transform-style: preserve-3d;
    -webkit-transform-origin: 50% 50%;
}
.cardV div {
    display: block;
    height: 100%;
    width: 100%;
    position: absolute;
    -webkit-backface-visibility: hidden;
    -moz-backface-visibility: hidden;
    -o-backface-visibility: hidden;
    backface-visibility: hidden;
}
 
 
.cardV.flipped {
    -webkit-transform: rotateX( -180deg );
    -moz-transform: rotateX( -180deg );
    -o-transform: rotateX( -180deg );
    transform: rotateX( -180deg );
}
 
/* vertical section USED FLEX */
.flextest {
	display: flex;
	justify-content: space-around;
}</style>

<body>
 
<script>
if ( window.history.replaceState ) {
window.history.replaceState( null, null, window.location.href );
}
</script>
               <button id="flipButton">Click me</button>

<section class="container test1">
    <h1 class="text-center">Horizontal flip</h1>
    <div class="row">
        
        
        <div class="col-md-4" id="flip3">
            <h3>Click image or button to flip</h3>
            <div class="flip-container">
                <div class="card">
                    <div class="front">
                        <div class="card-body">
                               <div class="pl-lg-12">
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
                                
                            	<div class="container-fluid" style="height:600px;width:100%">
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
                            	<script type="text/javascript" src="js/googlemap.js?i=<?php echo (rand(111,999));?>"> 	</script>
                            </body>
                             
                            </html>
                             <!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPuU44PV_rJh0QMPy32nk1aRiil-aGzgw&libraries=places&callback=loadMap"></script>-->
                              <script type="text/javascript"   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPuU44PV_rJh0QMPy32nk1aRiil-aGzgw&callback=loadMap" async defer></script>    
                                   
                                 
                              </div>
                           </div>
                    </div>
                    <div class="back">
                        back
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>   


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
 <script>
      

$(document).ready(function(){


    // $('.card').on('click', function() {
    //     $('.card').toggleClass('flipped');
    // });
    
    $('#flipButton').on('click', function() {
        $('.card').toggleClass('flipped');
    });




    // For verical flip
    $('.cardV').on('click', function() {
        $('.cardV').toggleClass('flipped');
    });
    $('#flipButtonV').on('click', function() {
        $('.cardV').toggleClass('flipped');
    });


    // Works but it is not a good solution
    // $(window).scroll(function(){
    //     $(".fader").css("opacity", 1 - $(window).scrollTop() / 1500);
    // });


    // Good solution uses math > (height - scrollTop) / height > gives value set which is linear form 1 to 0.
    // $(window).scroll(function () {
    //     var scrollTop = $(window).scrollTop();
    //     var height = $(window).height();

    //     $('.test, .slogan').css({
    //         'opacity': ((height - scrollTop) / height)
    //     }); 
    // });

    // Similiar to above solution also uses math change the number 1100 to adjust to your need
    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();
        $('.fader, .slogan').stop().animate(
            {opacity: (( 1140-scroll )/100)+0.1},
            "slow"
        );
    });

    // For toggle
    document.querySelector("#myCard").classList.toggle("flip");

});


 </script>    
  </body>
  <?php
}
else
{
header("location:index.php");
}
?>