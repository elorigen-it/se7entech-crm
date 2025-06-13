 <script>
if ( window.history.replaceState ) {
window.history.replaceState( null, null, window.location.href );
}
</script>
 <?php
   session_start();
if(isset($_SESSION['rand']))
{
	include('../connection.php');
	$logid=$_SESSION['rand'];
	$res=mysqli_query($con,"select * from payment where rand='$logid'");
	$row=mysqli_fetch_assoc($res);
 	
}
   
    $sql="update payment set status='1'  where rand='$logid'";
	$result=mysqli_query($con,$sql);
 
	if($result=mysqli_query($con,$sql))
	{
	    echo "<script>alert('Payment Success');</script>";
		header("location:https://crm.se7entech.net/stripe/done.php");
	}
	else{
 		echo "<script>alert('Try Again');</script>";
	}

 ?> 