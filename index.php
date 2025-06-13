<?php 
session_start();
require_once('./envloader.php');
require_once('./config/config.php');

if(isset($_SESSION['user']) && isset($_SESSION['email'])){
	// Obtener la ruta solicitada (sin parámetros de query)
    $request = strtok($_SERVER['REQUEST_URI'], '?');
    
    // Si no es la raíz, procesar la ruta
    if($request !== '/') {
        // Eliminar la barra inicial
        $route = ltrim($request, '/');
        
        // Verificar si la ruta ya tiene extensión .php
        if(pathinfo($route, PATHINFO_EXTENSION) !== 'php') {
            $route .= '.php';
        }
        
        // Si el archivo existe, redirigir a él
        if(file_exists($route)) {
            header("Location: $route");
            exit();
        }
    }
    header("Location:dashboard.php");
	exit();
}

$loginError = '';
if (!empty($_POST['email']) && !empty($_POST['pwd'])) {
	include 'Invoice.php';
	$invoice = new Invoice();
	$user = $invoice->loginUsers($_POST['email'], $_POST['pwd']); 
	if(!empty($user)) {
		$_SESSION['user'] = $user[0]['first_name']." ".$user[0]['last_name'];
		$_SESSION['userid'] = $user[0]['id'];
		$_SESSION['email'] = $user[0]['email'];		
		$_SESSION['address'] = $user[0]['address'];
		$_SESSION['mobile'] = $user[0]['mobile'];
		$_SESSION['id'] = $user[0]['id'];
		$_SESSION['access'] = $user[0]['status'];
		$_SESSION['designation'] = $user[0]['designation'];
		$_SESSION['zone_id'] = $user[0]['zone_id'];
		$_SESSION['avatar'] = $user[0]['avatar'];
		$_SESSION['role'] = $user[0]['role'];
		$_SESSION['is_department_responsible'] = $invoice->isDepartmentResponsible($user[0]['id']);
		$_SESSION['is_user_fully_registered'] = $user[0]['user_fully_registered']; 
		
		header('Location: ' . $base_url . '/modules/login/');
		// header("Location:dashboard.php");
	} else {
		$loginError = "Invalid email or password!";
	}
}
?>
<?php include('inc/header.php');?>
<style>
    .logoimg
    {
        height:95px;
        width:100%;
    }
    
    @media only screen and (max-width: 600px) {
  .logoimg {
    height:79px;
  }
}
</style>
<title>Se7entech Corporation</title>
<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="images/fav.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/fav.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/fav.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <script src="js/invoice.js"></script>
 <?php include('inc/container.php');?>
 <body style="background-color:#3c949c">
 <div class="container">
     <div class="row" style="padding-top:150px">
         <div class="col-sm-4">
             
         </div>
         
         <div class="col-sm-4" style="padding:20px;background-color:#e1e6e5;border-radius:5px">
 	<div class="demo-heading">
		<h2 style="text-align:center">Agent Log in Dashboard</h2>
	</div>
 	<div class="login-form">		
		<img class="logoimg" src="https://se7entech.net/images/logo.png">		
		<form method="post" action="">
			<div class="form-group">
			<?php if ($loginError ) { ?>
				<div class="alert alert-warning"><?php echo $loginError; ?></div>
			<?php } ?>
			</div>
			<div class="form-group">
				<input name="email" id="email" type="email" class="form-control" placeholder="Email address" autofocus="" required>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="pwd" placeholder="Password, (if agent put OTP)" required>
			</div>  
			<div class="form-group">
				<button type="submit" name="login" class="btn btn-info">Login</button>
			</div>
		</form> 
		<br>
		<a href="https://se7entech.net/Agent.php">Click here for send otp.(Agent)</a>
         </div>	
         </div>
         
         <div class="col-sm-4">
             
         </div>
     </div>
     
 </div>
	
</div>
</body>
<?php include('inc/footer.php');?>