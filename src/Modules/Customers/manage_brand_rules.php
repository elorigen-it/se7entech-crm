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
                                <h6 class="h2 text-white d-inline-block mb-0">Manage brand rules</h6>
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
                                <?php if (!empty($brandRules)): ?>
                                    <ul class="list-group mb-4">
                                        <?php foreach ($brandRules as $brandRule): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-grow-1 flex-wrap" id="brand-rule-<?php echo $brandRule['id'];?>">
                                                <div class="d-flex flex-column flex-grow-1 flex-shrink-1 min-width-0">
                                                    <span class="font-weight-bold text-truncate" style="max-width: 100%;">
                                                        <?php echo htmlspecialchars($brandRule['rule_name']); ?>
                                                    </span>
                                                    <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Basic example">
                                                        <a href="<?php echo $this->base_url;?>/modules/customers/index.php/<?php echo $customerId;?>/brand-rules/view/<?php echo $brandRule['id'];?>" class="btn btn-sm btn-info" title="Ver">
                                                            <i class="fa fa-eye"> View</i>
                                                        </a>
                                                        <a href="<?php echo $this->base_url;?>/modules/customers/index.php/<?php echo $customerId;?>/brand-rules/edit/<?php echo $brandRule['id'];?>" class="btn btn-sm btn-warning" title="Editar">
                                                            <i class="fa fa-edit"> Edit</i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger" title="Eliminar" data-id="<?php echo $brandRule['id'];?>" onclick="showModal(this)"><i class="fa fa-trash"> Delete</i></button>
                                                    </div>
                                                </div>
                                                <small class="text-muted text-right ml-3 flex-shrink-0">
                                                    Creado: <?php echo htmlspecialchars($brandRule['created_at']); ?> |
                                                    Actualizado: <?php echo htmlspecialchars($brandRule['updated_at']); ?>
                                                </small>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p>No hay reglas de marca definidas.</p>
                                <?php endif; ?>
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
            function showModal(button){
                let id = button.dataset.id;
                let container = document.querySelector('#brand-rule-'+id);

                bootbox.confirm('Are you sure of this action?', function(confirmed) {
                    console.log(confirmed)
                    if(confirmed){
                        let data = new FormData;
                        data.set('id', id);
                        let endpoint = "<?php echo $this->base_url;?>/modules/customers/index.php/<?php echo $customerId;?>/brand-rules/delete/" + id;
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                container.remove();
                                $.notify('Record deleted!', 'success')
                            }
                        })
                        xhr.send(data)
                    }
                });
            }
        </script>
    </body>
</html>