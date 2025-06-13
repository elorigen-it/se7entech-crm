<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Se7entech Corporation</title>

<link rel="apple-touch-icon" sizes="180x180" href="images/fav.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/fav.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/fav.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"><style>
    /* Optional styles */
html {
	box-sizing: border-box;
	font-family: "YouTube Noto", Roboto, Arial, Helvetica, sans-serif;
	height: 100%;
}

*,
*::before,
*::after {
	box-sizing: inherit;
	margin: 0;
	padding: 0;
}

body {
	height: 100%;
	background-color: #f4eae1;
}
h1 {
	color: #00053b;
	text-align: center;
 }
/* END Optional styles */

.video-container {
	width: 100%;
	border-radius: 4px;
	margin: 0 auto;
	position: relative;
	display: flex;
	flex-direction: column;
	justify-content: center;
	box-shadow: 0px 8px 20px rgba(black, 0.4);
	padding:150px;
	padding-top:20px;

	.video-wrapper {
		width: 100%;
		height: 400px;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	video {
		width: 100%;
		height: 400px;
		border-radius: 4px;
		
	}
}

.play-button-wrapper {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	width: 100%;
	height: auto;
	pointer-events: none;
	#circle-play-b {
		cursor: pointer;
		pointer-events: auto;

		svg {
			width: 100px;
			height: 100px;
			fill: #fff;
			stroke: #fff;
			cursor: pointer;
			background-color: rgba(black, 0.2);
			border-radius: 50%;
			opacity: 0.9;
		}
	}
}

</style>
<?php
include('connection.php');
$randd= $_GET['id'];
    $repo=mysqli_query($con,"select * from videos where rand='$randd'");
    $ress=mysqli_fetch_assoc($repo);
    $image =$ress['file'];
    ?>
    <br>
<h1>Video Player</h1>
<div class="video-wrapper">
	<div class="video-container" id="video-container">
	    <br>
		<video style="height:450px" controls id="video" preload="metadata" poster="https://static.rfstat.com/renderforest/images/v2/landing-pics/intro-maker/push-button-logo-reveal.png">
			<source src="video/<?=$image?>" type="video/mp4">
		</video>

		<div class="play-button-wrapper">
			<div title="Play video" class="play-gif" id="circle-play-b">
				<!-- SVG Play Button -->
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
					<path d="M40 0a40 40 0 1040 40A40 40 0 0040 0zM26 61.56V18.44L64 40z" />
				</svg>
			</div>
		</div>
	</div>
</div>

<script>
    const video = document.getElementById("video");
const circlePlayButton = document.getElementById("circle-play-b");

function togglePlay() {
	if (video.paused || video.ended) {
		video.play();
	} else {
		video.pause();
	}
}

circlePlayButton.addEventListener("click", togglePlay);
video.addEventListener("playing", function () {
	circlePlayButton.style.opacity = 0;
});
video.addEventListener("pause", function () {
	circlePlayButton.style.opacity = 1;
});

</script>