<?php

    namespace Se7entech\Contractnew\Modules\Users;
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
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#adduser" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Add new User</a>
                            </li>    
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-media-list" data-toggle="tab" href="#listusers" role="tab" aria-controls="tabs-menagment" aria-selected="false"><i class="fa fa-users mr-2"></i>User List</a>
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
                        <div class="tab-pane fade show active" id="adduser" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" >
                            <div class="card bg-secondary shadow">
                                <div class="card-header bg-white border-0">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <h3 class="mb-0">Agent Management</h3>
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
                                        <form id="newuser" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="firstname">First Name</label>
                                                        <input type="text" name="firstname" value="<?php echo isset($this->data['last_data']['firstname']) ? $this->data['last_data']['firstname'] : '';?>" class="form-control form-control" placeholder="Agent's Name"  required >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="lastname">Last Name</label>
                                                        <input type="text" name="lastname" value="<?php echo isset($this->data['last_data']['lastname']) ? $this->data['last_data']['lastname'] : '';?>" class="form-control form-control" placeholder="Agent's Surname"  required >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="email">Email Address</label>
                                                    <input type="text" name="email" value="<?php echo isset($this->data['last_data']['email']) ? $this->data['last_data']['email'] : '';?>" class="form-control form-control" placeholder="Email Address"  required >
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    
                                                    <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="phone">Phone</label>
                                                    <input type="text" name="phone" value="<?php echo isset($this->data['last_data']['phone']) ? $this->data['last_data']['phone'] : '';?>" class="form-control form-control" placeholder="Phone"  required >
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    
                                                    <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="address">Address</label>
                                                    <input type="text" name="address" value="<?php echo isset($this->data['last_data']['address']) ? $this->data['last_data']['address'] : '';?>" class="form-control form-control" placeholder="Address"  required >
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    
                                                    <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="designation">Designation</label>
                                                    <input type="text" name="designation" value="<?php echo isset($this->data['last_data']['designation']) ? $this->data['last_data']['designation'] : '';?>" class="form-control form-control" placeholder="Designation"  required >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="role">Role</label>
                                                        <select name="role" class="form-control form-control" required >
                                                            <?php foreach($this->data['roles'] as $role):?>
                                                                <option value="<?php echo $role['id'];?>" <?php echo isset($this->data['last_data']['role']) ? (($this->data['last_data']['role'] == $role['id']) ? 'selected' : '') : '';?> ><?php echo $role['name'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="zone_id">Zone</label>
                                                        <select name="zone_id" class="form-control form-control" required >
                                                            <?php foreach($this->data['zones'] as $zone):?>
                                                                <option value="<?php echo $zone['id'];?>" <?php echo isset($this->data['last_data']['zone_id']) ? (($this->data['last_data']['zone_id'] == $zone['id']) ? 'selected' : '') : '';?> ><?php echo $zone['name'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group">
                                                    <label class="form-control-label" for="smtp_user">Corporate Email</label>
                                                    <input type="text" name="smtp_user" value="<?php echo isset($this->data['last_data']['smtp_user']) ? $this->data['last_data']['smtp_user'] : '';?>" class="form-control form-control" placeholder="Corporate Email"  >
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                    <label class="form-control-label" for="smtp_pass">Corporate Password</label>
                                                    <input type="text" name="smtp_pass" value="<?php echo isset($this->data['last_data']['smtp_pass']) ? $this->data['last_data']['smtp_pass'] : '';?>" class="form-control form-control" placeholder="Corporate Password"  >
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="avatar">Avatar</label>
                                                        <input type="file" name="avatar">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group">
                                                        <label class="form-control-label" for="status">IsAdmin</label>
                                                        <select name="status"  class="form-control form-control" required >
                                                            <option <?php echo isset($this->data['last_data']['status']) ? (($this->data['last_data']['status'] == '1') ? 'selected' : '') : '';?> value="1">No</option>
                                                            <option <?php echo isset($this->data['last_data']['status']) ? (($this->data['last_data']['status'] == '0') ? 'selected' : '') : '';?> value="0">Yes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <input type="submit" name="save" value="save" class="btn btn-primary" />
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tab Apps -->
                        <!-- Tab Media List -->
                        <div class="tab-pane fade show" id="listusers" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                            <div class="card card-profile shadow">
                                <div class="card-header">
                                    <input type="text" id="myInput" onkeyup="filterTable()" placeholder="Search for names.." title="Type in a name" class="form-control">
                                </div>
                                <div class="card-body" style="overflow-x:hidden;">
                                    <table id="users-list-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                        <thead style="background:#337ab7;color:white;"> 
                                            <tr>
                                                <th>ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Designation</th>
                                                <th>Role</th>
                                                <th>Zone</th>
                                                <th>Corporate Email</th>
                                                <th>IsAdmin</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="users-list-tbody">
                                            <?php if(count($this->data['users'])):?>
                                                <?php foreach($this->data['users'] as $user):?>
                                                    <tr>
                                                        <td><?php echo $user['id'];?></td>
                                                        <td><?php echo $user['first_name'];?></td>
                                                        <td><?php echo $user['last_name'];?></td>
                                                        <td><?php echo $user['email'];?></td>
                                                        <td><?php echo $user['mobile'];?></td>
                                                        <td><?php echo $user['address'];?></td>
                                                        <td><?php echo $user['designation'];?></td>
                                                        <td>
                                                            <?php foreach($this->data['roles'] as $role):?>
                                                                <?php if($user['role'] == $role['id']):?>
                                                                    <?php echo $role['name']; ?>
                                                                <?php endif;?>
                                                            <?php endforeach;?>
                                                        </td>
                                                        <td>
                                                            <?php foreach($this->data['zones'] as $zone):?>
                                                                <?php if($user['zone_id'] == $zone['id']):?>
                                                                    <?php echo $zone['name']; ?>
                                                                <?php endif;?>
                                                            <?php endforeach;?>
                                                        </td>
                                                        <td><?php echo $user['smtp_user'];?></td>
                                                        <td><?php echo $user['status'] === '0' ? 'yes' : 'No';?></td>

                                                        <td>
                                                            <a href="<?php echo $base_url;?>/modules/users/index.php/<?php echo $user['id'];?>" class="btn btn-primary">Edit</a>
                                                            <a href="#" data-id="<?php echo $user['id'];?>" onclick="showModal(this)" class="btn btn-danger">Delete</a>
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
         <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
         </footer>
        </div>
        <!-- Commented because navtabs includes same script -->
        <?php include '../../layout/footer_scripts.php';?>
        <script>
            
            $(document).ready(function(){
                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var target = $(e.target).attr("href") // activated tab
                    if(target === '#listusers'){
                        $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust()
                        .responsive.recalc(); 
                       
                        // $('#video-list-tbody').html("<img src='<?php echo $base_url;?>/modules/videos/images/uploading.gif' >")
                        // updateMediaListTable()                      
                    }
                });

                $('#users-list-table').DataTable({
                    responsive:true
                })
                
            });

            function filterTable() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("video-list-table");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                    }       
                }
            }
            
            function showModal(button){
                let id = button.dataset.id;
                let row = button.parentElement.parentElement;   

                bootbox.confirm('Are you sure of this action?', function(confirmed) {
                    console.log(confirmed)
                    if(confirmed){
                        let data = new FormData;
                        data.set('id', id);
                        let endpoint = "<?php echo $base_url;?>/modules/users/index.php/delete/"
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                $("#users-list-table").dataTable().fnDeleteRow(row)
                                $.notify('User deleted!', 'success')
                                //TODO: delete row from datatable
                            }
                        })
                        xhr.send(data)
                    }
                });
            }

            // $('form').submit(function(e) {
            //     console.log('submit');
            //     e.preventDefault();
            //     var formData = $(this).serializeArray();
            //     var data = {};
            //     $(formData).each(function(index, obj){
            //         data[obj.name] = obj.value;
            //     });
                
            //     $.post('', data, function(response) {
            //         // Handle the response here
            //         console.log(response);
            //     });
            // });
        </script>        
    </body>
</html>