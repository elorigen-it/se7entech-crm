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
                                <h6 class="h2 text-white d-inline-block mb-0">Brand rules definition</h6>
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
                                        <h3 class="mb-0">Reglas de Marca <?php echo $brandRule['rule_name'];?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div style="padding:5px;" name="brand_identity" id="brand_identity">
                                    <?php echo html_entity_decode($brandRule['rule_content']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-between">
                        <a href="<?php echo $this->base_url;?>/modules/customers/index.php/<?php echo $customerId;?>/brand-rules/manage" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to Rules List
                        </a>
                        <a href="<?php echo $this->base_url;?>/modules/customers/index.php/<?php echo $customerId;?>/brand-rules/edit/<?php echo $brandRule['id'];?>" class="btn btn-primary">
                            <i class="fa fa-edit"></i> Edit Rule
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
        </footer>
        <?php include '../../layout/footer_scripts.php';?>    
        <script></script>
    </body>
</html>