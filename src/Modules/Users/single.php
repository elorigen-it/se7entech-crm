<?php
    namespace Se7entech\Contractnew\Modules\Zones;

    require('../../config/config.php');
    require_once('../../connection.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('../../layout/head.php');?>
        <style>
            .required{
                color:red;
            }
            .select2-container{
                width:100% !important;
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
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Updating User <?php echo $this->data['current']['first_name'] . ' ' . $this->data['current']['last_name'];?></a>
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
                                            <h3 class="mb-0">Users Management</h3>
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
                                        <form id="postUser" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="firstname">First Name</label>
                                                        <input type="text" name="firstname" value="<?php echo $this->data['current']['first_name'];?>" class="form-control form-control" placeholder="Agent's Name"  required >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="lastname">Last Name</label>
                                                        <input type="text" name="lastname" value="<?php echo $this->data['current']['last_name'];?>" class="form-control form-control" placeholder="Agent's Surname"  required >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="email">Email Address</label>
                                                    <input disabled type="text" name="email" value="<?php echo $this->data['current']['email'];?>" class="form-control form-control" placeholder="Email Address"  required >
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    
                                                    <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="phone">Phone</label>
                                                    <input type="text" name="phone" value="<?php echo $this->data['current']['mobile'];?>" class="form-control form-control" placeholder="Phone"  required >
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    
                                                    <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="address">Address</label>
                                                    <input type="text" name="address" value="<?php echo $this->data['current']['address'];?>" class="form-control form-control" placeholder="Address"  required >
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    
                                                    <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="designation">Designation</label>
                                                    <input type="text" name="designation" value="<?php echo $this->data['current']['designation'];?>" class="form-control form-control" placeholder="Designation"  required >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="role">Role</label>
                                                        <select name="role" class="form-control form-control" required >
                                                            <?php foreach($this->data['roles'] as $role):?>
                                                                <option value="<?php echo $role['id'];?>" <?php echo ($this->data['current']['role'] == $role['id']) ? 'selected' : '';?> ><?php echo $role['name'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="zone_id">Zone</label>
                                                        <select name="zone_id" class="form-control form-control" required >
                                                            <?php foreach($this->data['zones'] as $zone):?>
                                                                <option value="<?php echo $zone['id'];?>" <?php echo ($this->data['current']['zone_id'] == $zone['id']) ? 'selected' : '';?> ><?php echo $zone['name'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    
                                                    <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="smtp_user">Corporate Email</label>
                                                    <input type="text" name="smtp_user" value="<?php echo $this->data['current']['smtp_user'];?>" class="form-control form-control" placeholder="Corporate Email" >
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    
                                                    <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="smtp_pass">Corporate Password</label>
                                                    <input type="text" name="smtp_pass" value="<?php echo $this->data['current']['smtp_pass'];?>" class="form-control form-control" placeholder="Corporate Password" >
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="avatar">Avatar</label>
                                                        <img width="50" height="50" src="<?php echo $this->data['current']['avatar'];?>">
                                                        <input type="file" name="avatar">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group">
                                                        <label class="form-control-label" for="status">Is Admin</label>
                                                        <select name="status"  class="form-control form-control" required >
                                                            <option <?php echo ($this->data['current']['status'] == '1') ? 'selected' : '';?> value="1">No</option>
                                                            <option <?php echo ($this->data['current']['status'] == '0') ? 'selected' : '';?> value="0">Yes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <button type="submit" name="save" value="save" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
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