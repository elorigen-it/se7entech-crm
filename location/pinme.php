<!DOCTYPE html>
<html>
<body>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<center><form method="GET" name="myForm" action="ok.php" onsubmit="return validateForm()" required style="margin-top:250px">
<textarea style="display:none" name="address" id="demo"  rows="3" cols="35"></textarea>
<div id="newpost">
    <a onclick="getLocation()"  class="btn btn-primary" style="color:white">Get Address</a>

    <button class="btn btn-danger" type="submit">Pin Now</button>
</div>
</form>
</center>
 
 
<script>
 function validateForm() {
  var x = document.forms["myForm"]["address"].value;
  if (x == "") {
    alert("Click On get address first");
    return false;
  }
}
var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } 
  
  else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  x.innerHTML = + position.coords.latitude +
  "," + position.coords.longitude;
}
</script>
 
</body>
</html>


