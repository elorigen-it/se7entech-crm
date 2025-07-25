<?php
    namespace Se7entech\Contractnew\Modules\Projects;

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
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Updating Project <?php echo $this->data['current']['name'];?></a>
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
                                            <h3 class="mb-0">Project Management</h3>
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
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="customer">Customer <span class="required">*</span></label>
                                                        <select id="customer" name="customer" class="form-control">
                                                            <option value="">SELECT A CUSTOMER</option>
                                                            <?php foreach($this->data['customers'] as $customer):?>
                                                                <option <?php echo ($this->data['current']['customer_id'] == $customer['id']) ? 'selected' : '';?> value="<?php echo $customer['id'];?>"><?php echo $customer['name'] . ' - ' . $customer['business_name']; ?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="project-name">Project Name <span class="required">*</span></label>
                                                        <input value="<?php echo isset($this->data['current']['name']) ? $this->data['current']['name'] : '';?>" type="text" id="project-name" name="project-name" placeholder="Example: Marketing 360 November" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group  ">
                                                        <label class="form-control-label" for="project-description">Description<span class="required">*</span></label>
                                                        <textarea name="project-description" class="form-control"><?php echo isset($this->data['current']['description']) ? $this->data['current']['description'] : '';?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="project-status">Project Status <span class="required">*</span></label>
                                                        <select id="project-status" name="project-status" class="form-control">
                                                            <option value="">SELECT A STATUS</option>
                                                            <option <?php echo ($this->data['current']['status']) == 'pending' ? 'selected ' : ' '; ?> value="pending">Pending</option>
                                                            <option <?php echo ($this->data['current']['status']) == 'started' ? 'selected ' : ' '; ?> value="started">Started</option>
                                                            <option <?php echo ($this->data['current']['status']) == 'cancelled' ? 'selected ' : ' '; ?> value="cancelled">Cancelled</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" name="save" value="1" class="btn btn-primary">Update Project</button>
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
    </body>
</html>