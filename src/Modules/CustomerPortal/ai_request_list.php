<?php
    namespace Se7entech\Contractnew\Modules\CustomerPortal;

    require(__DIR__ . '/../../../config/config.php');
    require(__DIR__ . '/../../../connection.php');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include_once( __DIR__ . '/../Dashboard/layout/head_customer.php');?>
        <title>Mis Requerimientos IA - Customer Portal</title>
    </head>
    <body class="">
        <?php include ( __DIR__ . '/../Dashboard/layout/sidebar_customer.php'); ?>
        <div class="main-content">
            <?php include ( __DIR__ . '/../Dashboard/layout/navbar_customer.php'); ?>
            
            <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
                <div class="container-fluid">
                    <!-- Renders a placeholder space, the React application mounts below -->
                    <div style="height: 30px;"></div>
                </div>
            </div>

            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col-12">
                        <div id="ai-request-list-app"></div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between"></div>
            </footer>
        </div>

        <?php include __DIR__ . '/../Dashboard/layout/footer_scripts_customer.php';?>
        
        <script>
            $(document).ready(function(){
                window.SE7ENTECH = window.SE7ENTECH || {};
                window.SE7ENTECH.customer_id = "<?php echo $this->session->get('customer_id');?>";
                window.SE7ENTECH.requests = <?php echo json_encode($this->data['requests']);?>;
                window.SE7ENTECH.base_url = "<?php echo $this->base_url;?>";
            });
        </script>
    </body>
</html>
