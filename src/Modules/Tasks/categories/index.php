<?php
    namespace Se7entech\Contractnew\Modules\Zones;
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
                            <?php if($this->session->get('access') == '0'):?>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addcategory" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-folder-plus mr-2"></i>Add new Category</a>
                                </li>
                            <?php endif;?>
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 <?php echo $this->session->get('access') == '0' ? '': 'active';?>" id="tabs-media-list" data-toggle="tab" href="#listcategories" role="tab" aria-controls="tabs-menagment" aria-selected="false"><i class="fa fa-folder mr-2"></i>Categories List</a>
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
                            <!-- Tab Management -->
                            <?php if($this->session->get('access') == '0'):?>
                                <div class="tab-pane fade show active" id="addcategory" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" >
                                    <div class="card bg-secondary shadow">
                                        <div class="card-header bg-white border-0">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h3 class="mb-0">Task Categories Management</h3>
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
                                            <h6 class="heading-small text-muted mb-4">Add Category</h6>
                                            <div class="pl-lg-4">       
                                                <form id="postcategory" method="POST" >
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="category-name">Category Name <span class="required">*</span></label>
                                                                <input value="<?php echo isset($this->data['last_data']['category-name']) ? $this->data['last_data']['category-name'] : '';?>" type="text" id="category-name" name="category-name" placeholder="Example: Bug" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="category-description">Category Description <span class="required">*</span></label>
                                                                <textarea id="category-description" name="category-description" class="form-control" placeholder="Enter category description"><?php echo isset($this->data['last_data']['category-description']) ? htmlspecialchars($this->data['last_data']['category-description']) : '';?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="submit" name="save" value="1" class="btn btn-primary">Add New Category</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;?>
                            <!-- Tab Management -->

                            <!-- Tab Categories List -->
                            <div class="tab-pane fade show <?php echo $this->session->get('access') == '0' ? '': 'active';?>" id="listcategories" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <div class="card card-profile shadow">
                                    <div class="card-body" style="overflow-x:hidden;">
                                        <table id="categories-list-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                            <thead style="background:#337ab7;color:white;"> 
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Category</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="categories-list-tbody">
                                                <?php if(count($this->data['categories'])):?>
                                                    <?php foreach($this->data['categories'] as $category):?>
                                                        <tr>
                                                            <td><?php echo $category['id'];?></td>
                                                            <td style="text-align:center;">
                                                                <div style="display:flex;justify-content:center;align-items:center;">
                                                                    <div style="text-align:center; display:inline;padding:8px;border-radius:4px;">
                                                                        <?php echo htmlspecialchars($category['name']);?>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php if($this->session->get('access') == '0'):?>
                                                                    <a href="<?php echo $base_url;?>/modules/tasks/index.php/categories/<?php echo $category['id'];?>" class="btn btn-primary btn-sm">Edit</a>
                                                                    <a href="#" class="btn btn-danger btn-sm" data-id="<?php echo $category['id'];?>" onclick="showModal(this)">Delete</a>
                                                                <?php endif;?>
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
            <?php require '../../layout/footer_scripts.php';?>
         </div>
         <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
         </footer>
        <script>
            $(document).ready(function(){
                console.log('loader')
                $('#categories-list-table').DataTable({
                    responsive: true,
                    order: [[0, 'desc']]
                });

                //check if there is #listcategories in the URL
                if(window.location.hash === '#listcategories'){
                    $('#tabs-media-list').addClass('show active');
                    $('#tabs-menagment-main').removeClass('show active');
                    $('#listcategories').addClass('show active');
                    $('#addcategory').removeClass('show active');
                }
            });
            
            function showModal(button){
                let id = button.dataset.id;
                let row = button.parentElement.parentElement;    

                bootbox.confirm('Are you sure of this action?', function(confirmed) {
                    if(confirmed){
                        let data = new FormData;
                        data.set('id', id);
                        let endpoint = "<?php echo $base_url;?>/modules/tasks/index.php/categories/"+id+"/delete"
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                $("#categories-list-table").dataTable().fnDeleteRow(row)
                                $.notify('Category deleted!', 'success')
                            }
                        })
                        xhr.send(data)
                    }
                });
            }
        </script>        
    </body>
</html>
