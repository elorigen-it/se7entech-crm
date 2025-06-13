<?php 
   session_start();
   require_once './config/config.php';
   require_once './config/connection.php';
   require_once './access.php';
   ?>

<html lang="en">
<head>
  <title>Signature Of Company</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
  <style>
        body, html, *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }
        h6{
            display: block;
            text-align:center;
        }
        .wrapper {
            position: relative;
            width: 350px;
            height: 320px;
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
            margin:0 auto;
            background-color: black;
        }
        .signature-pad {
            position: absolute;
            left: 9px;
            top: 25px;
             width:87%;
            /*height:90%; */
            border:1px dotted white;
            cursor:crosshair;
            /*padding-bottom:10px;*/
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<body scroll="no" style="overflow: hidden;" class="lock-screen"> 

   
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
    $id=$_REQUEST['x'];
    if(!$id){
      echo 'Link invalid please request a new one';
      exit;
    }
    
     
    if(isset($_POST['save']))
    {

   $thirty=$_POST['thirty'];
   	
    $sql="update contract set agent_sign='$thirty', contract_sign_date_agent='".date("Y-m-d")."' where id='$id'";
	$result=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con)==1)
	{
	 echo "<script>alert('sign submited success');</script>";
     echo ".'<script>window.location.href='sign2?x=$id';</script>.'";
	}
	else{
 		echo "<script>alert('Try Again');</script>";
	}
	
}

?>
  <form method="POST">
    <h6>Signature test</h6>
      <div class="wrapper">
          
        <canvas id="signature-pad" class="signature-pad" width=300 height=250>
         </canvas>
       <textarea style="display:none;width:100%;height:100%;" id="sig-dataUrll" name="thirty"  class="form-control" rows="5"></textarea>
      </div>
      <div style="text-align:center">
          <br>
         <button class="btn btn-success" id="sig-clearBtnn">Clear Signature</button>
        <button  type="submit" name="save" id="sig-subbbb" class="btn btn-warning">Save</button>

<br><br>
        <span class="btn btn-danger" onclick="GeeksForGeeks()"><l class="fa fa-share"></l>Copy To Share</span>
        <a href="sign2?x=<?php echo $_GET['x'];?>"><button   type="button"  class="btn btn-warning">Skip</button></a>
        Url: <input type="text" readonly value="https://se7entech.net/sign1?x=<?php echo $_GET['x'];?>" id="GfGInput">
         
      </div>
</form>

 
 <script>
        window.addEventListener('DOMContentLoaded', () => {
            var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
                backgroundColor: 'white',
                penColor: 'black'
            });
            // var saveButton = document.getElementById('save');
            var cancelButton = document.getElementById('clear');
    
            // saveButton.addEventListener('click', function (event) {
            // var data = signaturePad.toDataURL('image/png');
    
            // // Send data to server instead...
            // console.log(data)
            // });
    
            cancelButton.addEventListener('click', function (event) {
            signaturePad.clear();
            });
        }, false)
      </script>
<style>
.grid-container {
  display: grid;
  grid-template-columns: auto auto;
  padding-right:35px;
 }
 </style>
 

 
    <style>
    
    #sig-canvass {
  border: 2px dotted #CCCCCC;
  border-radius: 15px;
  cursor: crosshair;
   /*height:100%;*/
}

html, body {
   margin: 10px;
   /*margin-right: 0px;*/
   height: 100%;
   overflow: hidden
}


</style>
<script>
    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
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

(function() {
  window.requestAnimFrame = (function(callback) {
    return window.requestAnimationFrame ||
      window.webkitRequestAnimationFrame ||
      window.mozRequestAnimationFrame ||
      window.oRequestAnimationFrame ||
      window.msRequestAnimaitonFrame ||
      function(callback) {
        window.setTimeout(callback, 1000 / 60);
      };
  })();

  var canvas = document.getElementById("signature-pad");
  var ctx = canvas.getContext("2d");
  ctx.strokeStyle = "#222222";
  ctx.lineWidth = 4;

  var drawing = false;
  var mousePos = {
    x: 0,
    y: 0
  };
  var lastPos = mousePos;

  canvas.addEventListener("mousedown", function(e) {
    drawing = true;
    lastPos = getMousePos(canvas, e);
  }, false);

  canvas.addEventListener("mouseup", function(e) {
    drawing = false;
  }, false);

  canvas.addEventListener("mousemove", function(e) {
    mousePos = getMousePos(canvas, e);
  }, false);

  // Add touch event support for mobile
  canvas.addEventListener("touchstart", function(e) {

  }, false);

  canvas.addEventListener("touchmove", function(e) {
    var touch = e.touches[0];
    var me = new MouseEvent("mousemove", {
      clientX: touch.clientX,
      clientY: touch.clientY
    });
    canvas.dispatchEvent(me);
  }, false);

  canvas.addEventListener("touchstart", function(e) {
    mousePos = getTouchPos(canvas, e);
    var touch = e.touches[0];
    var me = new MouseEvent("mousedown", {
      clientX: touch.clientX,
      clientY: touch.clientY
    });
    canvas.dispatchEvent(me);
  }, false);

  canvas.addEventListener("touchend", function(e) {
    var me = new MouseEvent("mouseup", {});
    canvas.dispatchEvent(me);
  }, false);

  function getMousePos(canvasDom, mouseEvent) {
    var rect = canvasDom.getBoundingClientRect();
    return {
      x: mouseEvent.clientX - rect.left,
      y: mouseEvent.clientY - rect.top
    }
  }

  function getTouchPos(canvasDom, touchEvent) {
    var rect = canvasDom.getBoundingClientRect();
    return {
      x: touchEvent.touches[0].clientX - rect.left,
      y: touchEvent.touches[0].clientY - rect.top
    }
  }

  function renderCanvas() {
    if (drawing) {
      ctx.moveTo(lastPos.x, lastPos.y);
      ctx.lineTo(mousePos.x, mousePos.y);
      ctx.stroke();
      lastPos = mousePos;
    }
  }

  // Prevent scrolling when touching the canvas
  document.body.addEventListener("touchstart", function(e) {
    if (e.target == canvas) {
      e.preventDefault();
    }
  }, false);
  document.body.addEventListener("touchend", function(e) {
    if (e.target == canvas) {
      e.preventDefault();
    }
  }, false);
  document.body.addEventListener("touchmove", function(e) {
    if (e.target == canvas) {
      e.preventDefault();
    }
  }, false);

  (function drawLoop() {
    requestAnimFrame(drawLoop);
    renderCanvas();
  })();

  function clearCanvas() {
    canvas.width = canvas.width;
  }

  // Set up the UI
  var sigText = document.getElementById("sig-dataUrll");
  var sigImage = document.getElementById("sig-imagee");
  var clearBtn = document.getElementById("sig-clearBtnn");
  var subbb = document.getElementById("sig-subbbb");
  clearBtn.addEventListener("click", function(e) {
    clearCanvas();
    sigText.innerHTML = "Data URL for your signature will go here!";
    sigImage.setAttribute("src", "");
  }, false);
  subbb.addEventListener("click", function(e) {
    var dataUrl = canvas.toDataURL();
    sigText.innerHTML = dataUrl;
    sigImage.setAttribute("src", dataUrl);
  }, false);

})();</script>
      <script>
    $('#myDatepicker2').datetimepicker({
        format: 'DD-MM-YYYY'
    });
    function isNumberKey(evt)
    {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
      return true;
    }
     </script>
     
     </body>
     