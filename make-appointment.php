<?php
session_start();
include('./config/config.php');
include('./config/connection.php');

if(isset($_SESSION['email']))
{
	$logid=$_SESSION['email'];
	$res=mysqli_query($con,"select * from invoice_user where email='$logid'");
	$row=mysqli_fetch_assoc($res);
	$access = $row['status'];
	$name = $row['first_name'];
	$myemail = "info@se7entech.us"; //$row['email'];
	
	if($access=='0')
	{
	    
	}
	else
	{
	    $data = "where logid='$logid'";
	}
	
?>
<script>
if ( window.history.replaceState ) {
window.history.replaceState( null, null, window.location.href );
}
</script>
<?php
$id = $_GET['i'];
$imagesql = "select * from colleges where id='$id'";
$res = mysqli_query($con,$imagesql);
$datas = mysqli_fetch_assoc($res);
?>
<style>
 
/* 'Open Sans' font from Google Fonts */
@import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700');

body {
  background: #456;
  font-family: 'Open Sans', sans-serif;
}

.login {
  width: 600px;
  margin: 16px auto;
  font-size: 16px;
}

/* Reset top and bottom margins from certain elements */
.login-header,
.login p {
  margin-top: 0;
  margin-bottom: 0;
}

/* The triangle form is achieved by a CSS hack */
.login-triangle {
  width: 0;
  margin-right: auto;
  margin-left: auto;
  border: 12px solid transparent;
  border-bottom-color: #22d4dd;
}

.login-header {
  background: #22d4dd;
  padding: 20px;
  font-size: 1.4em;
  font-weight: normal;
  text-align: center;
  text-transform: uppercase;
  color: #fff;
}

.login-container {
  background: #ebebeb;
  padding: 12px;
}

/* Every row inside .login-container is defined with p tags */
.login p {
  padding: 12px;
}

.login input {
  box-sizing: border-box;
  display: block;
  width: 100%;
  border-width: 1px;
  border-style: solid;
  /*padding: 6px;*/
  outline: 0;
  font-family: inherit;
  font-size: 0.95em;
}

.login input[type="email"],
.login input[type="password"] {
  background: #fff;
  border-color: #bbb;
  color: #555;
}

/* Text fields' focus effect */
.login input[type="email"]:focus,
.login input[type="password"]:focus {
  border-color: #888;
}

.login input[type="submit"] {
  background: #22d4dd;
  border-color: transparent;
  color: #fff;
  cursor: pointer;
}

.login input[type="submit"]:hover {
  background: #17c;
}

/* Buttons' focus effect */
.login input[type="submit"]:focus {
  border-color: #05a;
}

    
a {
    color: #53bdff;
    text-decoration: none;
    outline: 0;
}
	a:hover {
		color: #06a0ff;
		text-decoration: none;
	}
p { margin: 10px 0; }

/* ==========================================================================
   WYSIWYG
   ========================================================================== */
#editor {
	resize: vertical;
	overflow: auto;
	line-height: 1.5;
	background-color: #fafafa;
  background-image: none;
	border: 0;
  border-bottom: 1px solid #3b8dbd;
	min-height: 150px;
	box-shadow: none;
	padding: 8px 16px;
	margin: 0 auto;
	font-size: 14px;
	transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
}
	#editor:focus {
		background-color: #f0f0f0;
		border-color: #38af5b;
		box-shadow: none;
		outline: 0 none;
	}

/* ==========================================================================
   Buttons
   ========================================================================== */
.btn {
  font-family:"Raleway", sans-serif;
  font-weight: 300;
  font-size: 1em;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  border: none;
  border-bottom: .15em solid black;
  padding: 0.65em 1.3em;
}
.btn-xs {
	font-size: .80em;
	padding: .25em .75em;
}

.btn-default {
  border-color: #d9d9d9;
  background-image: linear-gradient(#ffffff, #f2f2f2);
}
	.btn-default:hover { background: linear-gradient(#f2f2f2, #e6e6e6); }
</style>
<!--<link rel="stylesheet" href="editor/summernote-bs4.min.css?i=<?  // (rand(111,999))?>">-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Se7entech Corporation</title>

<link rel="apple-touch-icon" sizes="180x180" href="images/fav.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/fav.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/fav.png">
          <script src="vendor/intltelinput/build/js/intlTelInput.js"></script>
      <script src="vendor/intltelinput/build/js/utils.js"></script>
      <!-- Custom CSS defined by admin -->
      <link type="text/css" href="byadmin/back.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   </head>
<div class="login">
  <div class="login-triangle"></div>
  
  <h2 class="login-header">Appointment</h2>
<?php
if(isset($_POST['save']))
{

if($datas['email']=='N/A')
{
    echo "<script>alert('update client email first');</script>";
}

else{
date_default_timezone_set("America/New_York");
$day = date('d');    
$cemail=$datas['email'];
$message=$_POST["notes"];
$date=  date('F d, Y h:mA', strtotime($_POST["date"]));
$namee=$_POST['name'];
$agentname = $_POST['agentname'];
$reminder = $_POST['reminder'];
$mobile = $_POST['mobile'];
  
  $sql="insert into appointment (clientname,email,notes,date,agentname,reminder,d)values('$namee','$cemail','$message','$date','$agentname','$reminder','$day')";
$result=mysqli_query($con,$sql);
 
if(mysqli_affected_rows($con)==1)
{
    
        $email_subject = "Appointment";
   
        $message ='Appointment Time: <b style="color:red">'.$date.'</b><br><br>'.$message.' <br><br><table style="width:400px; height: 213px; padding-top:33px; padding-right:0; padding-bottom:38px; padding-left:10px; font-family:Oxygen, sans-serif; font-size: 12px">
  <tbody>
    <tr>
      <td style="width:110px; padding:0;">
        <img src="https://se7entech.net/images/logo.png" alt="'.$agentname.'" style="width:92px; padding-right: 20px; opacity: 0.8">
        <br>
         <br>
        <a href="https://www.facebook.com/SEVENTECHCORP/"><img src="https://cdn3.iconfinder.com/data/icons/free-social-icons/67/facebook_circle_color-512.png" width=16px  style="padding-left:14px;"></a>
        <a href="https://www.instagram.com/se7entech_net/"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/2048px-Instagram_icon.png" width=16px></a>
        <a href="https://www.tiktok.com/@se7entech"><img src="https://images.rawpixel.com/image_png_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDIyLTA1L2pvYjkwOC1jYS03Ml8xLnBuZw.png"  width=16px></a>
      </td>
      <td style="border-left: 2px solid #f1451e; width:22px; height:136px; padding: 0px; opacity:0.8"></td>
      <td style="padding:0px">
        <b>'.$agentname.'</b>
         
         <br><a href="https://se7entech.net/" style="text-decoration:none; color:black;"><img src="https://www.freepnglogos.com/uploads/logo-website-png/logo-website-website-icon-with-png-and-vector-format-for-unlimited-22.png"  height=10px alt="Orange Link Icon"> www.se7entech.net</a>

        <br>
        
        
      </td>
    </tr>
  </tbody>
</table>
 '; 
    	                 
        $to = $cemail;
  
        $headers = "From: Your Appointment <info@se7entech.us>\r\n" .
        "Reply-To: Your Appointment  <$logid>" . PHP_EOL .
        'Content-type:text/html;charset=UTF-8' . "\r\n".
         "MIME-Version: 1.0\r\n" .
         'X-Mailer: PHP/' . phpversion();
   
  if(mail($to, $email_subject, $message, $headers))
  { 
         echo '<script>alert("Appointment Booked");</script>'; 
   
   }
   
  else{ 
         echo '<script>alert("try again");</script>'; 
  }
    
}
else{
	echo "<script>alert('sorry! unable to insert..');</script>";
}
}
}
?>
  <form class="login-container" method="POST">
    <p><label>Agent's Name</label><input class="form-control" name="agentname"  required placeholder="Agent Name"></p>
    <p><label>Client's Name</label><input class="form-control" name="name" readonly  required value="<?= $datas['client_name'];?>" placeholder="Customer Name"></p>
    <p><label>Appointment Time</label><input required class="form-control" name="date" type="datetime-local" placeholder=""></p>
     
   <label>Message/Notes</label>
	<div id="editparent">
		<div id="editControls">
			<div class="btn-group">
				<a class="btn btn-xs btn-default" data-role="undo" href="#" title="Undo"><i class="fa fa-undo"></i></a>
				<a class="btn btn-xs btn-default" data-role="redo" href="#" title="Redo"><i class="fa fa-repeat"></i></a>
			</div>
			<div class="btn-group">
				<a class="btn btn-xs btn-default" data-role="bold" href="#" title="Bold"><i class="fa fa-bold"></i></a>
				<a class="btn btn-xs btn-default" data-role="italic" href="#" title="Italic"><i class="fa fa-italic"></i></a>
				<a class="btn btn-xs btn-default" data-role="underline" href="#" title="Underline"><i class="fa fa-underline"></i></a>
				<a class="btn btn-xs btn-default" data-role="strikeThrough" href="#" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
			</div>
			<div class="btn-group">
				<a class="btn btn-xs btn-default" data-role="indent" href="#" title="Blockquote"><i class="fa fa-indent"></i></a>
				<a class="btn btn-xs btn-default" data-role="insertUnorderedList" href="#" title="Unordered List"><i class="fa fa-list-ul"></i></a>
				<a class="btn btn-xs btn-default" data-role="insertOrderedList" href="#" title="Ordered List"><i class="fa fa-list-ol"></i></a>
			</div>
			<div class="btn-group">
				<a class="btn btn-xs btn-default" data-role="h1" href="#" title="Heading 1"><i class="fa fa-header"></i><sup>1</sup></a>
				<a class="btn btn-xs btn-default" data-role="h2" href="#" title="Heading 2"><i class="fa fa-header"></i><sup>2</sup></a>
				<a class="btn btn-xs btn-default" data-role="h3" href="#" title="Heading 3"><i class="fa fa-header"></i><sup>3</sup></a>
				<a class="btn btn-xs btn-default" data-role="p" href="#" title="Paragraph"><i class="fa fa-paragraph"></i></a>
			</div>
		</div>
		<div id="editor" contenteditable></div>
		<textarea name="notes" id="editorCopy" required="required" style="display:none;"></textarea>
	</div>
	
	 
 
    <!--<p>Message <label style="color:red">Note: video & image file not allow in editor<sup style="color:red">*</sup></label><textarea name="notes" class="form-control"  id="editor" placeholder="Message"></textarea></p>-->
    
    <!--<p><label><i title="Reminder for agent" class="fa fa-question-circle"></i> Reminder <sup style="color:green">(optional)</sup> </label>-->
    <!--<input  name="reminder" class="form-control" type="datetime-local" placeholder="Reminder"></p> -->
    <p><input type="submit" value="Submit" name="save"></p>
  </form>
</div>
 <script>
     jQuery(document).ready(function($) {
	/** ******************************
		* Simple WYSIWYG
		****************************** **/
	$('#editControls a').click(function(e) {
		e.preventDefault();
		switch($(this).data('role')) {
			case 'h1':
			case 'h2':
			case 'h3':
			case 'p':
				document.execCommand('formatBlock', false, $(this).data('role'));
				break;
			default:
				document.execCommand($(this).data('role'), false, null);
				break;
		}

		var textval = $("#editor").html();
		$("#editorCopy").val(textval);
	});

	$("#editor").keyup(function() {
		var value = $(this).html();
		$("#editorCopy").val(value);
	}).keyup();
	
	$('#checkIt').click(function(e) {
		e.preventDefault();
		alert($("#editorCopy").val());
	});
});
</script>
 <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js" type="text/javascript"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
       <!--Navtabs -->
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
      <?php
}
else
{
header("location:index.php");
}
?>