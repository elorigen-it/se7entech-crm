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
                                <form id="brandPersonalityForm" action="<?php echo $this->base_url . '/modules/customers/index.php/'. $customerId .'/brand-rules/edit/' . $brandRule['id'];?>" method="POST">
                                    <input type="hidden" name="customerId" id="customerId" value="<?php echo $customerId;?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-control-label" for="uniqueValue">Nombre para la regla de marca<span class="required">*</span></label>
                                            <input type="text" name="rule_name" id="rule_name" value="<?php echo $brandRule['rule_name'];?>" class="form-control" placeholder="Reglas para creacion de contenido 1" required>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label class="form-control-label" for="brand_identity">Contenido de la regla de marca</label>
                                            <div style="padding:5px;" name="brand_identity" id="brand_identity" contenteditable>
                                                <?php echo html_entity_decode($brandRule['rule_content']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12 d-flex justify-content-between">
                                            <a href="<?php echo $this->base_url;?>/modules/customers/index.php/<?php echo $customerId;?>/brand-rules/manage" class="btn btn-secondary">
                                                <i class="fa fa-arrow-left"></i> Back to Rules List
                                            </a>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-save"></i> Update Rule
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
            window.addEventListener('DOMContentLoaded', function() {
                // Initialize the contenteditable div
                const brandIdentityDiv = document.getElementById('brand_identity').innerHTML;
                const ruleNameInput = document.getElementById('rule_name');
                const customerId = document.getElementById('customerId').value;

                document.getElementById('brandPersonalityForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    e.target.disabled = true; // Disable the form to prevent multiple submissions

                    if (!ruleNameInput.value.trim()) {
                        alert('Por favor, ingrese el nombre para la regla de marca.');
                        ruleNameInput.focus();
                        e.target.disabled = false;
                        return;
                    }                    

                    const actionUrl = this.action;
                    const data = new FormData();
                    data.append('brand_identity', document.getElementById('brand_identity').innerHTML);
                    data.append('rule_name', ruleNameInput.value);
                    data.append('customerId', customerId);

                    
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', actionUrl, true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4) {
                            // Optionally handle response here
                            console.log(xhr);
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    bootbox.alert({
                                        message: response.message,
                                        callback: function () {
                                            window.location.href = `<?php echo $base_url;?>/modules/customers/<?php echo $customerId;?>/brand-rules/view/<?php echo $brandRule['id'];?>`;
                                        }
                                    });
                                } else {
                                    bootbox.alert(response.message || 'Error al guardar las reglas de marca.');
                                }
                            } catch (err) {
                                bootbox.alert('Respuesta inesperada del servidor.');
                            }
                        }
                    };
                    xhr.send(data);
                });
            });
        </script>
    </body>
</html>