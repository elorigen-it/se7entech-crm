<?php
    namespace Se7entech\Contractnew\Modules\Tasks;
    // Adjust paths if necessary based on file location
    require(__DIR__ . '/../../../envloader.php');
    require(__DIR__ . '/../../../config/config.php');
    require(__DIR__ . '/../../../config/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('../../layout/head.php');?>
        <style>
            .required{ color:red; }
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
                                <h6 class="h2 text-white d-inline-block mb-0">Admin Task Dashboard</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page content -->
            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col-xl-12 order-xl-1">
                        <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">Worker Performance & Tasks</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- React App Host -->
                                <div id="admin-tasks-app"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <footer class="footer">
                    <div class="row align-items-center justify-content-xl-between"></div>
                </footer>
            </div>
        </div>
        
        <?php include '../../layout/footer_scripts.php';?>
        
        <!-- Pass Base URL to JS -->
        <script>
            window.SE7ENTECH = window.SE7ENTECH || {};
            window.SE7ENTECH.base_url = "<?php echo $this->base_url;?>";
        </script>
    </body>
</html>