<?php 
session_start();
require_once('./envloader.php');
require_once('./config/config.php');

if(isset($_SESSION['customer']) && isset($_SESSION['customer_username'])){
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

    header('Location: ' . $this->base_url . '/modules/dashboard/customer');
    exit();
}
?>

<?php include('inc/header.php');?>
<style>
    .logoimg {
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
            <div class="col-12" style="display:flex;justify-content:center;">
                <div class="col-sm-4" style="padding:20px;background-color:#e1e6e5;border-radius:5px;">
                    <div class="demo-heading">
                        <h2 style="text-align:center">Customer Log in Dashboard</h2>
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
                                <input name="username" id="username" type="email" class="form-control" placeholder="username" autofocus="" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>  
                            <div class="form-group">
                                <button type="submit" name="login" class="btn btn-info">Login</button>
                            </div>
                        </form> 
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include('inc/footer.php');?>
