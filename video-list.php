<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Video Player</title>
  </head>
   <style>
        
.like-button {
  display: flex;
  align-items: left;
  justify-content: left;
}
.like-button.animated {
  -webkit-animation: pop 0.9s both;
  animation: pop 0.9s both;
}
.like-button svg {
  opacity: 1;
}
.like-button svg path {
  fill: #0ca0a3;
  transition: fill .4s ease-out;
}
.like-button.active svg path {   
  fill: #2196f3;
 }

@-webkit-keyframes pop {
  0% {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1);
  }
  30% {
    -webkit-transform: scale3d(1.25, 0.75, 1);
    transform: scale3d(1.25, 0.75, 1);
  }
  40% {
    -webkit-transform: scale3d(0.75, 1.25, 1);
    transform: scale3d(0.75, 1.25, 1);
  }
  50% {
    -webkit-transform: scale3d(1.15, 0.85, 1);
    transform: scale3d(1.15, 0.85, 1);
  }
  65% {
    -webkit-transform: scale3d(0.95, 1.05, 1);
    transform: scale3d(0.95, 1.05, 1);
  }
  75% {
    -webkit-transform: scale3d(1.05, 0.95, 1);
    transform: scale3d(1.05, 0.95, 1);
  }
  100% {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1);
  }
}

@keyframes pop {
  0% {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1);
  }
  30% {
    -webkit-transform: scale3d(1.25, 0.75, 1);
    transform: scale3d(1.25, 0.75, 1);
  }
  40% {
    -webkit-transform: scale3d(0.75, 1.25, 1);
    transform: scale3d(0.75, 1.25, 1);
  }
  50% {
    -webkit-transform: scale3d(1.15, 0.85, 1);
    transform: scale3d(1.15, 0.85, 1);
  }
  65% {
    -webkit-transform: scale3d(0.95, 1.05, 1);
    transform: scale3d(0.95, 1.05, 1);
  }
  75% {
    -webkit-transform: scale3d(1.05, 0.95, 1);
    transform: scale3d(1.05, 0.95, 1);
  }
  100% {
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1);
  }
} 

.grid-container {
  display: grid;
  grid-template-columns: auto auto;
}

 
.ex1
{
    overflow-y: scroll;
    height: 500px;
    width: 100%;
}
   </style>
  <body style="background:#eeeeee;">
 <div class="container-fuild">
  <h2 style="padding-top:10px;padding:40px"><img style="height:40px;width:40px" src="https://www.freeiconspng.com/thumbs/video-play-icon/video-play-icon-24.png"> Player</h2>

     <div class="row" style="padding:50px;padding-top:10px;">
        <div class="col-sm-7" style="">
            <?php
            include('connection.php');
            $sql="select * from video_content  order by id desc limit 1";
            $result11=mysqli_query($con,$sql);
            
            if(mysqli_num_rows($result11))
            {
            
            $i=1;
            while($rows11=mysqli_fetch_assoc($result11))
            {
            
            $randd = $rows11['rand'];
            $repo=mysqli_query($con,"select * from videos where rand='$randd'");
            $ress=mysqli_fetch_assoc($repo);
            $image =$ress['file'];  
            ?>
        <video style="width:100%;box-shadow: rgba(100, 100, 111, 0.8) 0px 7px 29px 0px;" controls>
        <source src="video/<?= $image;?>" type="video/mp4">
        <source src="mov_bbb.ogg" type="video/ogg">
        Your browser does not support HTML video.
        </video>
        
        <div class="grid-containerr">
        <div class="grid-item">
        <a href="#" class="like-button" style="padding-top:5px">
        <svg width="30" height="30" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M320 1344q0-26-19-45t-45-19q-27 0-45.5 19t-18.5 45q0 27 18.5 45.5t45.5 18.5q26 0 45-18.5t19-45.5zm160-512v640q0 26-19 45t-45 19h-288q-26 0-45-19t-19-45v-640q0-26 19-45t45-19h288q26 0 45 19t19 45zm1184 0q0 86-55 149 15 44 15 76 3 76-43 137 17 56 0 117-15 57-54 94 9 112-49 181-64 76-197 78h-129q-66 0-144-15.5t-121.5-29-120.5-39.5q-123-43-158-44-26-1-45-19.5t-19-44.5v-641q0-25 18-43.5t43-20.5q24-2 76-59t101-121q68-87 101-120 18-18 31-48t17.5-48.5 13.5-60.5q7-39 12.5-61t19.5-52 34-50q19-19 45-19 46 0 82.5 10.5t60 26 40 40.5 24 45 12 50 5 45 .5 39q0 38-9.5 76t-19 60-27.5 56q-3 6-10 18t-11 22-8 24h277q78 0 135 57t57 135z"/></svg>
        </a>
        </div>
         
 </div>
<div>
 <div style="padding-top:10px"><h6 style="font-size:21px"><?= $rows11['title'];?></h6></div>
  <div style="padding-top:10px"><b><h4>Description</h4></b></div>
  <p><?= $rows11['notes'];?></p>
<?php }}?>
<label>Comment:</label>
<textarea class="form-control"></textarea>
<p style="padding-top:10px;text-align:right">
    <button class="btn btn-danger">Comment</button>
</p>
</div>
         </div>
             <div class="col-sm-5 ex1">
              <h2>Next:</h2>
            <?php
            include('connection.php');
            $sql="select * from video_content  order by rand()";
            $result11=mysqli_query($con,$sql);
            
            if(mysqli_num_rows($result11))
            {
            
            $i=1;
            while($rows11=mysqli_fetch_assoc($result11))
            {
            
            $randd = $rows11['rand'];
            $repo=mysqli_query($con,"select * from videos where rand='$randd'");
            $ress=mysqli_fetch_assoc($repo);
            $image =$ress['file'];  
            ?>
            <video style="width:100%;border-radius:5px" controls>
            <source src="video/<?= $image;?>" type="video/mp4">
            <source src="mov_bbb.ogg" type="video/ogg">
            Your browser does not support HTML video.
            </video>
             
            <div class="grid-item" style="padding:10px"><h6 style="font-size:21px"><?= $rows11['title'];?></h6>
            <p><?= $rows11['notes'];?></p>
             </div>
             <?php }}?>
                 
          </div>  
     </div>
 </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
<script>
    let button = document.querySelector(".like-button");

button.addEventListener("click", function(e) {
  e.preventDefault();
  this.classList.toggle("active");
  this.classList.add("animated");
  generateClones(this);
});


function generateClones(button) {
  let clones = randomInt(2, 4);
  for (let it = 1; it <= clones; it++) {
    let clone = button.querySelector("svg").cloneNode(true),
      size = randomInt(5, 16);
    button.appendChild(clone);
    clone.setAttribute("width", size);
    clone.setAttribute("height", size);
    clone.style.position = "absolute";
    clone.style.transition =
      "transform 0.5s cubic-bezier(0.12, 0.74, 0.58, 0.99) 0.3s, opacity 1s ease-out .5s";
    let animTimeout = setTimeout(function() {
      clearTimeout(animTimeout);
      clone.style.transform =
        "translate3d(" +
        (plusOrMinus() * randomInt(10, 25)) +
        "px," +
        (plusOrMinus() * randomInt(10, 25)) +
        "px,0)";
      clone.style.opacity = 0;
    }, 1);
    let removeNodeTimeout = setTimeout(function() {
      clone.parentNode.removeChild(clone);
      clearTimeout(removeNodeTimeout);
    }, 900);
    let removeClassTimeout = setTimeout( function() {
      button.classList.remove("animated")
    }, 600);
  }
}


function plusOrMinus() {
  return Math.random() < 0.5 ? -1 : 1;
}

function randomInt(min, max) {
  return Math.floor(Math.random() * (max - min + 1) + min);
}

</script>