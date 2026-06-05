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
                    <!-- Quick AI Requests Buttons Card -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow border-0" style="background: linear-gradient(135deg, #ffffff 0%, #f6f9fc 100%);">
                                <div class="card-body p-4">
                                    <h4 class="mb-3 text-primary font-weight-bold" style="color: #5e72e4;"><i class="fa fa-magic mr-2"></i>Solicitudes Rápidas con IA</h4>
                                    <p class="text-muted small mb-4">Elige una de las siguientes opciones para iniciar una conversación asistida por IA y estructurar tu requerimiento:</p>
                                    <div class="d-flex flex-wrap" style="gap: 15px; display: flex; flex-wrap: wrap;">
                                        <a href="<?php echo $this->base_url; ?>/modules/customer-portal/index.php/ai-request/new?type=flyer" class="btn btn-outline-success btn-sm rounded-pill font-weight-bold" style="background: white; border: 1px solid #2dce89; color: #2dce89; padding: 8px 16px; text-transform: none; border-radius: 20px;"><span style="color:#2dce89;margin-right:5px">🟢</span> Solicitar Flyer</a>
                                        <a href="<?php echo $this->base_url; ?>/modules/customer-portal/index.php/ai-request/new?type=reel" class="btn btn-outline-success btn-sm rounded-pill font-weight-bold" style="background: white; border: 1px solid #2dce89; color: #2dce89; padding: 8px 16px; text-transform: none; border-radius: 20px;"><span style="color:#2dce89;margin-right:5px">🟢</span> Solicitar Reel</a>
                                        <a href="<?php echo $this->base_url; ?>/modules/customer-portal/index.php/ai-request/new?type=commercial" class="btn btn-outline-success btn-sm rounded-pill font-weight-bold" style="background: white; border: 1px solid #2dce89; color: #2dce89; padding: 8px 16px; text-transform: none; border-radius: 20px;"><span style="color:#2dce89;margin-right:5px">🟢</span> Solicitar Comercial</a>
                                        <a href="<?php echo $this->base_url; ?>/modules/customer-portal/index.php/ai-request/new?type=design" class="btn btn-outline-success btn-sm rounded-pill font-weight-bold" style="background: white; border: 1px solid #2dce89; color: #2dce89; padding: 8px 16px; text-transform: none; border-radius: 20px;"><span style="color:#2dce89;margin-right:5px">🟢</span> Solicitar Diseño</a>
                                        <a href="<?php echo $this->base_url; ?>/modules/customer-portal/index.php/ai-request/new?type=menu" class="btn btn-outline-success btn-sm rounded-pill font-weight-bold" style="background: white; border: 1px solid #2dce89; color: #2dce89; padding: 8px 16px; text-transform: none; border-radius: 20px;"><span style="color:#2dce89;margin-right:5px">🟢</span> Solicitar Menú</a>
                                        <a href="<?php echo $this->base_url; ?>/modules/customer-portal/index.php/ai-request/new?type=website" class="btn btn-outline-success btn-sm rounded-pill font-weight-bold" style="background: white; border: 1px solid #2dce89; color: #2dce89; padding: 8px 16px; text-transform: none; border-radius: 20px;"><span style="color:#2dce89;margin-right:5px">🟢</span> Solicitar Website</a>
                                        <a href="<?php echo $this->base_url; ?>/modules/customer-portal/index.php/ai-request/new?type=campaign" class="btn btn-outline-success btn-sm rounded-pill font-weight-bold" style="background: white; border: 1px solid #2dce89; color: #2dce89; padding: 8px 16px; text-transform: none; border-radius: 20px;"><span style="color:#2dce89;margin-right:5px">🟢</span> Solicitar Campaña Publicitaria</a>
                                        <a href="<?php echo $this->base_url; ?>/modules/customer-portal/index.php/ai-request/new?type=prices" class="btn btn-outline-success btn-sm rounded-pill font-weight-bold" style="background: white; border: 1px solid #2dce89; color: #2dce89; padding: 8px 16px; text-transform: none; border-radius: 20px;"><span style="color:#2dce89;margin-right:5px">🟢</span> Solicitar Actualización de Precios</a>
                                        <a href="<?php echo $this->base_url; ?>/modules/customer-portal/index.php/ai-request/new?type=photo_video" class="btn btn-outline-success btn-sm rounded-pill font-weight-bold" style="background: white; border: 1px solid #2dce89; color: #2dce89; padding: 8px 16px; text-transform: none; border-radius: 20px;"><span style="color:#2dce89;margin-right:5px">🟢</span> Solicitar Sesión de Foto y Video</a>
                                        <a href="<?php echo $this->base_url; ?>/modules/customer-portal/index.php/ai-request/new?type=support" class="btn btn-outline-success btn-sm rounded-pill font-weight-bold" style="background: white; border: 1px solid #2dce89; color: #2dce89; padding: 8px 16px; text-transform: none; border-radius: 20px;"><span style="color:#2dce89;margin-right:5px">🟢</span> Solicitar Soporte Técnico</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <div class="card-body text-center py-4">                                
                                    <div style="display: inline-flex; position: relative; justify-content: center; align-items: center; width: 130px; height: 130px; border-radius: 50%; background: radial-gradient(circle, #ffffff 60%, #e8ecfa 100%); box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 4px solid #5e72e4; margin: 10px 0;">
                                        <div style="text-align: center;">
                                            <span style="font-size: 2rem; font-weight: 800; color: #5e72e4; display: block; line-height: 1;">
                                                <?php echo isset($this->data['total_hours_invested']) ? $this->data['total_hours_invested'] : '0'; ?>
                                            </span>
                                            <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: #8898aa; letter-spacing: 0.5px;">
                                                Horas
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-muted small mt-3 mb-0">Total acumulado de tiempo dedicado a tus tareas y soporte.</p>
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
