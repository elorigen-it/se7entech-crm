<?php
    namespace Se7entech\Contractnew\Modules\Customers;
    
    require('../../config/config.php');
    require('../../connection.php');
?>
<html lang="en">
    <head>
        <?php include_once('../../layout/head.php');?>
        <style>
            .required {
                color: red;
            }
            .content-plan-container {
                padding: 20px;
                border: 1px solid #eee;
                border-radius: 5px;
                background-color: #f9f9f9;
                margin-bottom: 20px;
            }
            .content-plan-container h2, 
            .content-plan-container h3, 
            .content-plan-container h4 {
                color: #2dce89;
                margin-top: 20px;
            }
            .content-plan-container ul, 
            .content-plan-container ol {
                padding-left: 20px;
            }
            .content-plan-container table {
                width: 100%;
                margin: 15px 0;
                border-collapse: collapse;
            }
            .content-plan-container table, 
            .content-plan-container th, 
            .content-plan-container td {
                border: 1px solid #ddd;
            }
            .content-plan-container th, 
            .content-plan-container td {
                padding: 8px;
                text-align: left;
            }
            .content-plan-container th {
                background-color: #f2f2f2;
            }
            .content-plan-container tr:nth-child(even) {
                background-color: #f9f9f9;
            }
        </style>  
    </head>
    <body class="content-creator-results">
        <?php include ('../../sidebar.php'); ?>
        <div class="main-content">
            <?php include ('../../nav.php'); ?>
            <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-6 col-7">
                                <h6 class="h2 text-white d-inline-block mb-0">Plan de Contenido</h6>
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
                                        <h3 class="mb-0">Plan de Contenido Generado</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="contentPlanForm" action="<?php echo $this->base_url . '/modules/customers/index.php/'. $customerId .'/brand-content/confirm';?>" method="POST">
                                    <input type="hidden" name="customerId" id="customerId" value="<?php echo $customerId;?>">
                                    <div class="xs-12">
                                        <label class="form-control-label" for="plan_name">Nombre para el plan de contenido<span class="required">*</span></label>
                                        <input type="text" name="plan_name" id="plan_name" class="form-control" placeholder="Plan de Contenido Q3 2023" required>
                                    </div> 
                                    <div class="xs-12 mt-4">
                                        <label class="form-control-label">Plan generado:</label>
                                        <textarea style="display:none" id="content"><?php echo $responseContent;?></textarea>
                                        <div class="content-plan-container" name="generated_content" id="generated_content"></div>
                                    </div>                                   

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary mt-4">Guardar Plan de Contenido</button>
                                        <a href="<?php echo $this->base_url . '/modules/customers/'; ?>" class="btn btn-secondary mt-4">Cancelar</a>
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
            base_url = "<?php echo $this->base_url;?>";
            //managed in /app/src/routes/content-creator.js
        </script>
    </body>
</html>