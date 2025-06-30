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
                                <h6 class="h2 text-white d-inline-block mb-0">Brand content definition</h6>
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
                                        <h3 class="mb-0">Contenido de Marca <?php echo $brandContent['name'];?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="brandPersonalityForm" action="<?php echo $this->base_url . '/modules/customers/index.php/'. $customerId .'/brand-content/edit/' . $brandContent['id'];?>" method="POST">
                                    <input type="hidden" name="customerId" id="customerId" value="<?php echo $customerId;?>">
                                    <input type="hidden" name="contentId" id="contentId" value="<?php echo $brandContent['id'];?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-control-label" for="uniqueValue">Nombre para plan de contenido<span class="required">*</span></label>
                                            <input type="text" name="content_name" id="content_name" value="<?php echo $brandContent['name'];?>" class="form-control" placeholder="Plan 1 quarter 2020" required>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label class="form-control-label" for="content">Contenido de la regla de marca</label>
                                            <textarea style="display:none;" name="_content" id="_content"><?php echo $brandContent['content']; ?></textarea>
                                            <div style="padding:5px;" name="content" id="content" contenteditable></div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12 d-flex justify-content-between">
                                            <a href="<?php echo $this->base_url;?>/modules/customers/index.php/<?php echo $customerId;?>/brand-content/manage" class="btn btn-secondary">
                                                <i class="fa fa-arrow-left"></i> Back to Content List
                                            </a>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-save"></i> Update Content
                                            </button>
                                        </div>
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
            //implementado en app/src/routes/edit-brand-content.js
        </script>
    </body>
</html>