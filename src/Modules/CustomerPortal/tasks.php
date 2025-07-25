<?php
    namespace Se7entech\Contractnew\Modules\CustomerPortal;

    require(__DIR__ . '/../../../config/config.php');
    require(__DIR__ . '/../../../connection.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once( __DIR__ . '/../Dashboard/layout/head_customer.php');?>
        <style>
            .required{
                color:red;
            }
        </style>
    </head>
    <body class="">
        <?php include ( __DIR__ . '/../Dashboard/layout/sidebar_customer.php'); ?>
        <div class="main-content">
            <?php include ( __DIR__ . '/../Dashboard/layout/navbar_customer.php'); ?>
            <div class="header bg-gradient-info pb-3 pt-2 pt-md-8">
                <div class="container-fluid">
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist"> 
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-media-list" data-toggle="tab" href="#listzones" role="tab" aria-controls="tabs-menagment" aria-selected="false"><i class="fa fa-users mr-2"></i>Tasks list</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Top navbar -->
            <div class="container-fluid mt--3">
                <div class="card card-profile shadow">
                    <div class="card-body" style="overflow-x:hidden;">
                        <!-- managed by /app/routes/user-tasks.js -->
                        <div id="tasks-app"></div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between"></div>
            </footer>
        </div>
        <!-- Commented because navtabs includes same script -->
        <?php include __DIR__ . '/../Dashboard/layout/footer_scripts_customer.php';?>
        <script>        
             $(document).ready(function(){
                window.SE7ENTECH.customer_id = "<?php echo $customer_id;?>";
                window.SE7ENTECH.projects = <?php echo json_encode($this->data['projects']);?>;
            });
        </script>        
    </body>
</html>