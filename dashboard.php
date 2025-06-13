<?php
session_start(); //session start always on top.
require('./vendor/autoload.php');
require_once './envloader.php';
require_once './config/config.php';
require_once './config/connection.php';
require_once 'access.php'; //inside access.php you already have $con variable without importing it there.
require_once 'Invoice.php';


use Se7entech\Contractnew\Middlewares\hasFilledRequirementForm;
$validate = new hasFilledRequirementForm();
$validate->handle(0);

$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_POST['companyName']) && $_POST['companyName']) 
{	
	$invoice->saveInvoice($_POST);
	header("Location:dashboard.php");	
}

    if($access<>'0')
    {
    $wh = "and  trashd<>'1'";
    }
    
    else
    {
        $wh = "where  trashd <>'1'";
    }
    
	$repo=mysqli_query($con,"select count(*) from contactnew $data $wh");
	$ress=mysqli_fetch_assoc($repo);
	$contract=$ress['count(*)'];
	
	$repo=mysqli_query($con,"select count(*) from invoice_order $data ");
	$ress=mysqli_fetch_assoc($repo);
	$invoicet=$ress['count(*)'];
	
	$repo=mysqli_query($con,"select count(*) from clients $data ");
	$ress=mysqli_fetch_assoc($repo);
	$client=$ress['count(*)'];
	
	$repo=mysqli_query($con,"select count(*) from web_info $data ");
	$ress=mysqli_fetch_assoc($repo);
	$web_info=$ress['count(*)'];
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include './layout/head.php';?>
      <title>Se7entech Corporation</title>
      
   </head>
    <body class="">
         
       <?php include('sidebar.php');?>

        <div class="main-content">
            <!-- Top navbar -->
             <?php include('nav.php');?>
            <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="header-body">
                        <!-- Card stats -->
                        <div class="row">
                            <div class="col-xl-3 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <a href="<?php echo $base_url;?>/Contract"><div class="row">
                                            <div class="col">
                                                <h5 class="card-title
                                                    text-uppercase text-muted
                                                    mb-0">Contract</h5>
                                                <span class="h2 font-weight-bold
                                                    mb-0"><?php echo $contract;?></span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape
                                                    bg-yellow text-white
                                                    rounded-circle shadow">
                                                    <i class="fa fa-book"></i>
                                                </div>
                                            </div>
                                        </div></a>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <a href="<?php echo $base_url;?>/inv"><div class="row">
                                            <div class="col">
                                                <h5 class="card-title
                                                    text-uppercase text-muted
                                                    mb-0">Invoice</h5>
                                                <span class="h2 font-weight-bold
                                                    mb-0"> <?php echo $invoicet;?></span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape
                                                    bg-success text-white
                                                    rounded-circle shadow">
                                                    <i class="fa fa-chart-line"></i>
                                                </div>
                                            </div>
                                        </div></a>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <a href="<?php echo $base_url;?>/Client"><div class="col">
                                                <h5 class="card-title
                                                    text-uppercase text-muted
                                                    mb-0">Client</h5>
                                                <span class="h2 font-weight-bold
                                                    mb-0"><?php echo $client;?></span>
                                            </div></a>
                                            <div class="col-auto">
                                                <div class="icon icon-shape
                                                    bg-warning text-white
                                                    rounded-circle shadow">
                                                    <i class="fa fa-users"></i>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <a href="<?php echo $base_url;?>/agentdata"><div class="col">
                                                <h5 class="card-title
                                                    text-uppercase text-muted
                                                    mb-0"> (Prospect)</h5>
                                                <span class="h2 font-weight-bold
                                                    mb-0"><?php echo  $web_info;?></span>
                                            </div></a>
                                            <div class="col-auto">
                                                <div class="icon icon-shape
                                                    bg-info text-white
                                                    rounded-circle shadow">
                                                    <i class="fa
                                                        fa-question-circle"></i>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <br/>
                        </div>
                    </div>
                </div>
 
                <div class="container-fluid mt--7">
                    <div class="row">
                        <div class="col-xl-8 mb-5 mb-xl-0">
                            <div class="card bg-gradient-default shadow">
                                <div class="card-header bg-transparent">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="text-uppercase text-light
                                                    ls-1 mb-1">Se7entech AI</h6>
                                                <div id="deployment-dbac26da-cbb4-49bc-9446-1aa0055d6ca6"></div>
                                                <script src="https://studio.pickaxe.co/api/embed/bundle.js" defer></script>
                                        </div>
                                    </div>
                                </div>
                               
                                	
                                	 
                                <div class="card-body">
                                    <!-- Chart -->
                                     	<div class="container-fluid" style="height:250px;width:100%">
                             		 
                            	</div>
                     
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card shadow">
                                <div class="card-header bg-transparent">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="text-uppercase text-muted
                                                ls-1 mb-1">Performance</h6>
                                            <h2 class="mb-0">Total Income</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM invoice_order $data";
                                $result11 = mysqli_query($con, $sql);
                                
                                if (mysqli_num_rows($result11)) {
                                
                                while ($rows11 = mysqli_fetch_assoc($result11)) {
                                $pp += $rows11['order_amount_paid']*1;
                                }}
                                ?>
                                
                                    <!-- Chart -->
                                    <p>$<?php echo $pp;?>.00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br /><br />

                    <footer class="footer">
                        <div class="row align-items-center
                            justify-content-xl-between">
                        </div></footer> </div>
            </div>


      <?php include './layout/footer_scripts.php';?>
    </body>
</html>
