<?php
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
    <body>
        <?php include ('../../sidebar.php'); ?>
        <div class="main-content">
            <?php include ('../../nav.php'); ?>
            <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-menagment-main" data-toggle="tab" href="#editcategory" role="tab" aria-controls="tabs-menagment" aria-selected="true">
                                    <i class="fa fa-folder mr-2"></i>Editing Category <?php echo $this->data['current']['name'];?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col-12">
                        <br />
                        <div class="tab-content" id="tabs">
                            <div class="tab-pane fade show active" id="editcategory" role="tabpanel">
                                <div class="card bg-secondary shadow">
                                    <div class="card-header bg-white border-0">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h3 class="mb-0">Task Category Management</h3>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <?php if(count($this->data['session'])):?>
                                                    <?php foreach ($this->data['session'] as $msg) echo $msg;?>
                                                <?php endif;?>
                                            </div>
                                            <div>
                                                <?php if(isset($this->data['errors']) && count($this->data['errors'])):?>
                                                    <div class="alert alert-danger p-2" role="alert">
                                                        <?php foreach ($this->data['errors'] as $error) echo $error . '<br />';?>
                                                    </div>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="heading-small text-muted mb-4">Edit Task Category</h6>
                                        <div class="pl-lg-4">
                                            <form id="postcategory" method="POST">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="category-name">Category Name <span class="required">*</span></label>
                                                            <input value="<?php echo $this->data['current']['name'];?>" type="text" id="category-name" name="category-name" placeholder="Example: Development" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="category-description">Description <span class="required">*</span></label>
                                                            <textarea id="category-description" name="category-description" class="form-control" placeholder="Enter category description"><?php echo $this->data['current']['description'];?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" name="save" value="1" class="btn btn-success">Update Category</button>
                                                    <a href="/modules/tasks/index.php/categories#listcategories" class="btn btn-primary">Category list</a>
                                                </div>
                                            </form>
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
        </div>
        <?php include '../../layout/footer_scripts.php';?>
        <script></script>
    </body>
</html>
