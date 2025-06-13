 <script>
if ( window.history.replaceState ) {
window.history.replaceState( null, null, window.location.href );
}
</script>
 <?php
 
	include('../connection.php');
	$logid=$_GET['id'];
	
	$res=mysqli_query($con,"select * from invoice_order where order_id='$logid'");
	$row=mysqli_fetch_assoc($res);
	
	$amount = $row['order_total_amount_due'];
 	 
    $sql="update invoice_order set paid='Paid',order_amount_paid='$amount',order_total_amount_due='0'  where order_id='$logid'";
	$result=mysqli_query($con,$sql);
 
	if($result=mysqli_query($con,$sql))
	{
	    echo "<script>alert('Payment Success');</script>";
		header("location:https://crm.se7entech.net/invoicepay/done.php");
	}
	else{
 		echo "<script>alert('Try Again');</script>";
	}

 ?> 