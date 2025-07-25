<?php
    namespace Se7entech\Contractnew\Modules\Projects;

    require('../../envloader.php');
    require('../../config/config.php');
    require('../../config/connection.php');

?>

<!DOCTYPE html>
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
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Add new Project</a>
                            </li>    
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-media-list" data-toggle="tab" href="#listzones" role="tab" aria-controls="tabs-menagment" aria-selected="false"><i class="fa fa-users mr-2"></i>Projects List</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Top navbar -->
            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col-12">
                        <br />
                        <div class="tab-content" id="tabs">
                            <!-- Tab Managment -->
                            <div class="tab-pane fade show active" id="addzone" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" >
                                <div class="card bg-secondary shadow">
                                    <div class="card-header bg-white border-0">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h3 class="mb-0">Projects Management</h3>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <?php if(count($this->data['session'])):?>
                                                    <?php foreach ($this->data['session'] as $msg)
                                                        echo $msg;    
                                                    ?>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="heading-small text-muted mb-4">Add information</h6>
                                        <div class="pl-lg-4">       
                                            <form id="postzone" method="POST">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="customer">Customer <span class="required">*</span></label>
                                                            <select id="customer" name="customer" class="form-control">
                                                                <option value="">SELECT A CUSTOMER</option>
                                                                <?php foreach($this->data['customers'] as $customer):?>
                                                                    <option value="<?php echo $customer['id'];?>"><?php echo $customer['name'] . ' - ' . $customer['business_name']; ?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="project-name">Project Name <span class="required">*</span></label>
                                                            <input value="<?php echo isset($this->data['last_data']['project-name']) ? $this->data['last_data']['project-name'] : '';?>" type="text" id="project-name" name="project-name" placeholder="Example: Marketing 360 November" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group  ">
                                                            <label class="form-control-label" for="project-description">Description<span class="required">*</span></label>
                                                            <textarea name="project-description" class="form-control"><?php echo isset($this->data['last_data']['project-description']) ? $this->data['last_data']['project-description'] : '';?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="project-status">Project Status <span class="required">*</span></label>
                                                            <select id="project-status" name="project-status" class="form-control">
                                                                <option value="">SELECT A STATUS</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="started">Started</option>
                                                                <option value="cancelled">Cancelled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" name="save" value="1" class="btn btn-primary">Add New Project</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab Apps -->
                            <!-- Tab Media List -->
                            <div class="tab-pane fade show" id="listzones" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <div class="card card-profile shadow">
                                    <div class="card-body" style="overflow-x:hidden;">
                                        <table id="roles-list-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                            <thead style="background:#337ab7;color:white;"> 
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Customer</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="roles-list-tbody">
                                                <?php if(count($this->data['projects'])):?>
                                                    <?php foreach($this->data['projects'] as $project):?>
                                                        <tr>
                                                            <td><?php echo $project['id'];?></td>
                                                            <td><?php echo $project['name'];?></td>
                                                            <td><?php echo $project['customer_data']['name'] . " - " . $project['customer_data']['business_name'];?></td>
                                                            <td><?php echo $project['status'];?></td>
                                                            <td>
                                                                <a href="<?php echo $base_url;?>/modules/projects/index.php/<?php echo $project['id'];?>" class="btn btn-primary btn-sm">Edit</a>
                                                                <a href="#" class="btn btn-sm btn-danger" data-id="<?php echo $project['id'];?>" onclick="showModal(this)">Delete</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </tbody>
                                        </table>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
         <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
         </footer>
        <!-- Commented because navtabs includes same script -->
        <?php include '../../layout/footer_scripts.php';?>
        <script>
            
            $(document).ready(function(){
                $('#roles-list-table').DataTable({
                    responsive:true
                })
            });
            
            function showModal(button){
                let id = button.dataset.id;
                let row = button.parentElement.parentElement;    

                bootbox.confirm('Are you sure of this action?', function(confirmed) {
                    console.log(confirmed)
                    if(confirmed){
                        let data = new FormData;
                        data.set('id', id);
                        let endpoint = "<?php echo $base_url;?>/modules/projects/index.php/delete/"
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                $("#roles-list-table").dataTable().fnDeleteRow(row)
                                $.notify('Project deleted!', 'success')
                                //TODO: delete row from datatable
                            }
                        })
                        xhr.send(data)
                    }
                });
            }
        </script>        
    </body>
</html>