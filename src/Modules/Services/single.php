<?php
    namespace Se7entech\Contractnew\Modules\Services;

    require('../../config/config.php');
    require('../../connection.php');

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
        <link rel="stylesheet" href="<?php echo $base_url;?>/editor/summernote-bs4.min.css">
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
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Updating Service <?php echo $this->data['current']['name'];?></a>
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
                                            <h3 class="mb-0">Services Management</h3>
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
                                    <h6 class="heading-small text-muted mb-4">Edit information</h6>
                                    <div class="pl-lg-4">       
                                        <form id="postzone" method="POST">
                                            <div class="row">
                                                <div class="col-md-6">
                                                   <div class="form-group  ">
                                                        <label class="form-control-label" for="service-name">Service Name <span class="required">*</span></label>
                                                        <input value="<?php echo $this->data['current']['name'];?>" type="text" id="service-name" name="service-name" placeholder="Example: Website Development" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                   <div class="form-group  ">
                                                        <label class="form-control-label" for="service-price">Service Price<span class="required">*</span></label>
                                                        <input value="<?php echo $this->data['current']['price'];?>" type="text" id="service-price" name="service-price" placeholder="Example: 5" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group  ">
                                                            <label class="form-control-label" for="service-description">Service Description<span class="required">*</span></label>
                                                            <textarea id="service-description" name="service-description" class="form-control"><?php echo $this->data['current']['description'];?></textarea>
                                                        </div>
                                                    </div>
                                                <div class="col-md-6">
                                                    <div class="form-group  ">
                                                        <label class="form-control-label" for="department">Department<span class="required">*</span></label>
                                                        <select class="form-control" id="department" name="department">
                                                            <option value="">SELECT DEPARTMENT</option>
                                                            <?php foreach($this->data['departments'] as $department):?>
                                                                <option value="<?php echo $department['id'];?>" <?php echo ($this->data['current']['department_id'] == $department['id']) ? 'selected' : '';?>> 
                                                                    <?php echo $department['name'];?>
                                                                </option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" name="save" value="1" class="btn btn-primary">Update Service</button>
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
        <!-- Commented because navtabs includes same script -->
        <?php include '../../layout/footer_scripts.php';?>  
        <script src="<?php echo $base_url;?>/editor/summernote-bs4.min.js"></script>
        <script>
            $(document).ready(function(){
                $('#service-description').summernote();
            })
        </script>
    </body>
</html>