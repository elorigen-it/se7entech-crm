<?php
    namespace Se7entech\Contractnew\Modules\Customers;
    
    require('../../config/config.php');
    require('../../connection.php');
?>
<html lang="en">
    <head>
        <?php include_once('../../layout/head.php');?>
        <style>
            .required{
                color:red;
            }
        </style>
    </head>
    <body class="">
        <?php include ('../../sidebar.php'); ?>
        <div class="main-content">
            <?php include ('../../nav.php'); ?>
            <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-6 col-7">
                                <h6 class="h2 text-white d-inline-block mb-0">Brand Personality</h6>
                                <!-- <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="#">Brand</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Personality</li>
                                    </ol>
                                </nav> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Top navbar -->
            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">Definición de Personalidad de Marca</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="brandPersonalityForm" action="<?php echo $this->base_url . '/modules/customers/index.php/'. $customerId .'/brand-rules/confirm';?>" method="POST">
                                    <!-- Sección 1: Identidad Básica -->
                                    <div class="xs-12">
                                        <div style="padding:5px;" name="brand_identity" id="brand_identity" contenteditable><?php echo $responseContent;?></div>
                                    </div>                                   

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary mt-4">Guardar Reglas de Marca</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
        </footer>
        <?php include '../../layout/footer_scripts.php';?>    
        <script>
        </script>
    </body>
</html>