<?php
session_start(); //session start always on top.
require('./vendor/autoload.php');
require_once './envloader.php';
require_once './config/config.php';
require_once './config/connection.php';
// require_once 'access.php'; //inside access.php you already have $con variable without importing it there.
// require_once 'Invoice.php';
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include( __DIR__ .'/layout/head_customer.php');?>
      <title>Se7entech Corporation</title>
      
   </head>
    <body class="">
         
       <?php include( __DIR__ . '/layout/sidebar_customer.php');?>

        <div class="main-content">
            <!-- Top navbar -->
             <?php include(__DIR__ . '/layout/navbar_customer.php');?>
            <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="header-body">
                        <!-- Card stats -->
                        <div class="row">
                            <div class="col-xl-4 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <a href="<?php echo '#'/*$this->base_url;?>/modules/customer-portal/contracts*/;?>"><div class="row">
                                            <div class="col">
                                                <h5 class="card-title
                                                    text-uppercase text-muted
                                                    mb-0">Contracts</h5>
                                                <span class="h2 font-weight-bold
                                                    mb-0"><?php echo count($contracts);?></span>
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
                            <div class="col-xl-4 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <a href="<?php echo '#' /*$this->base_url;?>/modules/customer-portal/invoices*/?>"><div class="row">
                                            <div class="col">
                                                <h5 class="card-title
                                                    text-uppercase text-muted
                                                    mb-0">Invoices</h5>
                                                <span class="h2 font-weight-bold
                                                    mb-0"> <?php echo count($invoices);?></span>
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
                            <div class="col-xl-4 col-lg-6">
                                <div class="card card-stats mb-4 mb-xl-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <a href="<?php echo '#' /*$this->base_url;?>/modules/customer-portal/tasks*/;?>"><div class="col">
                                                <h5 class="card-title
                                                    text-uppercase text-muted
                                                    mb-0">Tasks</h5>
                                                <span class="h2 font-weight-bold
                                                    mb-0"><?php echo count($tasks);?></span>
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
                                            <h2 class="mb-0">Total hours invested</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">                                
                                    <!-- Chart -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <br /><br />

                    <footer class="footer">
                        <div class="row align-items-center
                            justify-content-xl-between">
                        </div>
                    </footer> 
                </div>
            </div>
      <?php include( __DIR__ . '/layout/footer_scripts_customer.php');?>
    </body>
</html>
