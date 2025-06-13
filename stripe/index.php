<?php
 session_start();
if(isset($_SESSION['rand']))
{
	include('../connection.php');
	$logid=$_SESSION['rand'];
	$res=mysqli_query($con,"select * from payment where rand='$logid'");
	$row=mysqli_fetch_assoc($res);

$amount = $row['amount'];
$payfor = $row['payfor'];
?>
<?php
 // Include configuration file  
require_once 'config.php'; 
 ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
 <meta charset="utf-8">
<!-- Stylesheet file -->
<link href="css/style.css" rel="stylesheet">
<!-- Stripe JavaScript library -->
<script src="https://js.stripe.com/v3/"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Info | Se7entech</title>
<link rel="icon" type="image/x-icon" href="https://png.pngtree.com/png-vector/20190810/ourlarge/pngtree-app-development-arrows-div-mobile-abstract-flat-color-icon-te-png-image_1653523.jpg">

</head>

<body class="App">
 	<div class="wrapper">
        <!-- Display errors returned by checkout session -->
		<div id="paymentResponse"></div>
		 <?php
             
            $orderID=$_REQUEST['order_id'];
        ?>
      
			<div class="col__box">
			  <h5>Paymet For <?php echo $payfor;?></h5>
				<h6>Price: <span> $<?php echo $amount; ?> </span> </h6>
			
				<!-- Buy button -->
				<div id="buynow">
					<button class="btn__default" id="payButton"> Pay Now </button>
				</div>
			</div>
	</div>		
<script>
var buyBtn = document.getElementById('payButton');
var responseContainer = document.getElementById('paymentResponse');    
// Create a Checkout Session with the selected product
var createCheckoutSession = function (stripe) {
    return fetch("stripe_charge.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            checkoutSession: 1,
			Name:"<?php echo $row['name'];?>",
			OrderID:"<?php echo $orderID;?>",
			Price:"<?php echo $amount;?>",
			Currency:"usd",
        }),
    }).then(function (result) {
        return result.json();
    });
};

// Handle any errors returned from Checkout
var handleResult = function (result) {
    if (result.error) {
        responseContainer.innerHTML = '<p>'+result.error.message+'</p>';
    }
    buyBtn.disabled = false;
    buyBtn.textContent = 'Buy Now';
};

// Specify Stripe publishable key to initialize Stripe.js
var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

buyBtn.addEventListener("click", function (evt) {
    buyBtn.disabled = true;
    buyBtn.textContent = 'Please wait...';
    createCheckoutSession().then(function (data) {
        if(data.sessionId){
            stripe.redirectToCheckout({
                sessionId: data.sessionId,
            }).then(handleResult);
        }else{
            handleResult(data);
        }
    });
});
</script>
</body>
</html>
	<?php
}
else
{
    echo '<script>alert("Click on email link")</script>';
	header("location:https://se7entech.net/");
}
?>