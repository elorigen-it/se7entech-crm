<?php
session_start(); //session start always on top.
require_once './config/config.php';
require_once './config/connection.php';

   $idd = $_GET['id'];
   if(empty($idd))
{
    echo '<script>alert("Wrong Url, Again Click On Email url")</script>';
    echo '<script>window.location.href="https://se7entech.net/"</script>';
}
else
{
if(isset($_POST['save']))
{
$name=$_POST["name"];
$email=$_POST["email"];
$phone=$_POST["phone"];
$rand=$_POST["rand"];

 
$sql="insert into clientpay (name,email,phone,rand)values('$name','$email','$phone','$rand')";

$result=mysqli_query($con,$sql);
 
if(mysqli_affected_rows($con)==1)
{
    $_SESSION['rand']=$_POST['rand'];
    echo '<script>window.location.href="stripe/index.php"</script>';
}

else

{
    echo '<script>alert("try again")</script>';
}
}
}
    ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="container" style="padding-top:50px">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <form method="POST">
            <input type="hidden" name="rand" value="<?php echo  $_GET['id'];?>">
            <center><img style="height:70px;width:200px" src="https://se7entech.net/images/logo.png"></center>
            <center><h2>Pay Now</h2></center>
            <label>Name</label>
            <input type="text" class="form-control" name="name">
            
            <label>Phone</label>
            <input type="text" class="form-control" name="phone">
            
            <label>Email</label>
            <input type="text" class="form-control" name="email">
            
             <br><button class="btn btn-success" type="submit" name="save" style="width:100%">Pay Now</button>
             </form>
        </div>
        <div class="col-sm-3"></div>
    </div>
    
</div>