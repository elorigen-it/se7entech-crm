<?php
    namespace Se7entech\Contractnew\Modules\Customers;
    
    require('../../config/config.php');
    require('../../connection.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('../../layout/head.php');?>
        <style>
            .required {
                color: red;
            }
            .switch {
                position: relative;
                display: inline-block;
                width: 38px;
                height: 20px;
            }
            .switch input { display: none; }
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0; left: 0; right: 0; bottom: 0;
                background-color: #ccc;
                transition: .4s;
                border-radius: 20px;
            }
            .slider:before {
                position: absolute;
                content: "";
                height: 14px;
                width: 14px;
                left: 3px;
                bottom: 3px;
                background-color: white;
                transition: .4s;
                border-radius: 50%;
            }
            input:checked + .slider {
                background-color: #2dce89;
            }
            input:checked + .slider:before {
                transform: translateX(18px);
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
                                <h6 class="h2 text-white d-inline-block mb-0">Customers Login Access</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container -->
            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">Customer Accounts access credentials</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="customer-access-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                        <thead style="background:#5e72e4;color:white;"> 
                                            <tr>
                                                <th>Customer</th>
                                                <th>Business Name</th>
                                                <th>Email</th>
                                                <th>Username</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($this->data['records'])):?>
                                                <?php foreach($this->data['records'] as $record):?>
                                                    <?php
                                                        // Look up if customer has login credentials
                                                        $hasLogin = false;
                                                        $loginData = null;
                                                        foreach ($this->data['loginAccess'] as $accessRec) {
                                                            if ($accessRec['customer_id'] == $record['id']) {
                                                                $hasLogin = true;
                                                                $loginData = $accessRec;
                                                                break;
                                                            }
                                                        }
                                                        $isActive = $hasLogin && $loginData['active'] == 1;
                                                        $switchId = 'access-switch-' . $record['id'];
                                                    ?>
                                                    <tr id="row-<?php echo $record['id'];?>">
                                                        <td><?php echo htmlspecialchars($record['name']);?></td>
                                                        <td><?php echo htmlspecialchars($record['business_name']);?></td>
                                                        <td><?php echo htmlspecialchars($record['email']);?></td>
                                                        <td>
                                                            <?php if ($hasLogin): ?>
                                                                <span class="badge badge-secondary" style="font-size:0.9em; text-transform:none;">
                                                                    <?php echo htmlspecialchars($loginData['username']);?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="text-muted" style="font-style:italic; font-size:0.85em;">No credentials</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($isActive): ?>
                                                                <span class="badge badge-success">Active</span>
                                                            <?php elseif ($hasLogin): ?>
                                                                <span class="badge badge-danger">Inactive</span>
                                                            <?php else: ?>
                                                                <span class="badge badge-warning">No login</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                                                <label class="switch" style="vertical-align:middle; margin-bottom: 0;" title="<?php echo $isActive ? 'Deactivate access' : 'Activate access';?>">
                                                                    <input type="checkbox" 
                                                                        data-defaultusername="<?php echo $record['email'];?>" 
                                                                        data-checkboxid="<?php echo $switchId;?>" 
                                                                        <?php echo $isActive ? 'checked' : '';?> 
                                                                        onchange="toggleLoginAccess(<?php echo $record['id'];?>, this.checked, this)">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                                <?php if ($hasLogin): ?>
                                                                    <button class="btn btn-primary btn-sm" onclick="resetCustomerPassword(<?php echo $record['id'];?>, '<?php echo htmlspecialchars(!empty($loginData['username']) ? $loginData['username'] : $record['email']);?>')">
                                                                        <i class="fa fa-key"></i> Reset Password
                                                                    </button>
                                                                <?php endif; ?>
                                                                
                                                                <!-- MEGA Upload Link Controls -->
                                                                <?php if (!empty($record['mega_upload_link'])): ?>
                                                                    <div class="btn-group btn-group-sm" role="group">
                                                                        <a href="<?php echo htmlspecialchars($record['mega_upload_link']);?>" target="_blank" class="btn btn-info btn-sm" title="Abrir carpeta de MEGA">
                                                                            <i class="fa fa-external-link"></i> MEGA Folder
                                                                        </a>
                                                                        <button type="button" class="btn btn-warning btn-sm" onclick="editMegaLink(<?php echo $record['id'];?>, '<?php echo htmlspecialchars($record['mega_upload_link']);?>')" title="Editar enlace de MEGA">
                                                                            <i class="fa fa-edit"></i> Edit Link
                                                                        </button>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <button type="button" class="btn btn-success btn-sm" onclick="editMegaLink(<?php echo $record['id'];?>, '')">
                                                                        <i class="fa fa-plus"></i> Add MEGA Link
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
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
            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between"></div>
            </footer>
        </div>
        
        <?php include '../../layout/footer_scripts.php';?>
        
        <script>
            $(document).ready(function(){
                $('#customer-access-table').DataTable({
                    responsive: true,
                    order: [[ 0, "asc" ]]
                });
            });

            function generatePassword() {
                var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
                var pass = "";
                for (var i = 0; i < 10; i++) {
                    pass += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                document.getElementById('password').value = pass;
            }

            function showAccessModal(customerId, defaultUsername, el) {
                bootbox.dialog({
                    title: "Access Credentials",
                    message: `
                        <form id="loginAccessForm">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control" value="${defaultUsername}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="text" id="password" name="password" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" onclick="generatePassword()">Generate</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    `,
                    buttons: {
                        cancel: {
                            label: "Cancel",
                            className: 'btn-secondary',
                            callback: function() {
                                if (el) el.checked = false;
                            }
                        },
                        confirm: {
                            label: "Save",
                            className: 'btn-primary',
                            callback: function() {
                                var username = document.getElementById('username').value.trim();
                                var password = document.getElementById('password').value.trim();
                                if (!username || !password) {
                                    $.notify('Username and password are required', 'danger');
                                    return false;
                                }
                                var data = new FormData();
                                data.append('customer_id', customerId);
                                data.append('username', username);
                                data.append('password', password);
                                var endpoint = "<?php echo $this->base_url;?>/modules/customers/index.php/login-access/activate";
                                fetch(endpoint, {
                                    method: 'POST',
                                    body: data
                                })
                                .then(res => res.json())
                                .then(res => {
                                    if (res.success) {
                                        $.notify('Access credentials updated successfully!', 'success');
                                        if (el) el.checked = true;
                                        setTimeout(() => window.location.reload(), 1000);
                                    } else {
                                        $.notify(res.msg || 'Failed to update access credentials', 'danger');
                                        if (el) el.checked = false;
                                    }
                                })
                                .catch(() => {
                                    $.notify('Request failed', 'danger');
                                    if (el) el.checked = false;
                                });
                            }
                        }
                    },
                    onEscape: () => {     
                        if (el) el.checked = false;
                    },
                    onHide: (e) => {
                        if (el && (!e || (e && e.currentTarget && e.currentTarget.classList && !e.currentTarget.classList.contains('btn-primary') && !e.currentTarget.classList.contains('btn-secondary')))) {
                            el.checked = false;
                        }
                    }
                });

                generatePassword();
            }

            function toggleLoginAccess(customerId, enabled, el) {   
                const defaultUsername = el.dataset.defaultusername || '';
                if (enabled) { 
                    showAccessModal(customerId, defaultUsername, el);
                } else {
                    bootbox.confirm({
                        message: 'Deactivate login access for this customer?',
                        callback: (confirmed) => {
                            if (confirmed) {
                                var data = new FormData();
                                data.append('customer_id', customerId);
                                var endpoint = "<?php echo $this->base_url;?>/modules/customers/index.php/login-access/deactivate";
                                fetch(endpoint, {
                                    method: 'POST',
                                    body: data
                                })
                                .then(res => res.json())
                                .then(res => {
                                    if (res.success) {
                                        $.notify('Login access deactivated!', 'success');  
                                        setTimeout(() => window.location.reload(), 1000);
                                    } else {
                                        $.notify(res.error || 'Failed to deactivate login access', 'danger');
                                        document.querySelectorAll("[data-checkboxid='"+el.dataset.checkboxid+"']").forEach((element) => {
                                            element.checked = true;
                                        });
                                    }
                                })
                                .catch(() => {
                                    $.notify('Request failed', 'danger');
                                    document.querySelectorAll("[data-checkboxid='"+el.dataset.checkboxid+"']").forEach((element) => {
                                        element.checked = true;
                                    });
                                });
                            } else {
                                document.querySelectorAll("[data-checkboxid='"+el.dataset.checkboxid+"']").forEach((element) => {
                                    element.checked = true;
                                });
                            }
                        },
                        onEscape: () => {     
                            el.checked = true;
                        },
                        onHide: (e) => {
                            if (!e || (e && e.currentTarget && e.currentTarget.classList && !e.currentTarget.classList.contains('btn-primary') && !e.currentTarget.classList.contains('btn-secondary'))) {
                                el.checked = true;
                            }
                        }        
                    });
                }
            }

            function resetCustomerPassword(customerId, currentUsername) {
                showAccessModal(customerId, currentUsername, null);
            }

            function editMegaLink(customerId, currentLink) {
                bootbox.dialog({
                    title: "MEGA Upload Link",
                    message: `
                        <form id="megaLinkForm">
                            <div class="form-group">
                                <label for="mega_upload_link_input">MEGA Folder / Upload Link</label>
                                <input type="url" id="mega_upload_link_input" name="mega_upload_link" class="form-control" value="${currentLink}" placeholder="https://mega.nz/folder/...">
                                <small class="form-text text-muted">Enter the folder URL where the customer can upload their materials.</small>
                            </div>
                        </form>
                    `,
                    buttons: {
                        cancel: {
                            label: "Cancel",
                            className: 'btn-secondary'
                        },
                        confirm: {
                            label: "Save",
                            className: 'btn-primary',
                            callback: function() {
                                var link = document.getElementById('mega_upload_link_input').value.trim();
                                var data = new FormData();
                                data.append('customer_id', customerId);
                                data.append('mega_upload_link', link);
                                var endpoint = "<?php echo $this->base_url;?>/modules/customers/index.php/login-access/mega-link";
                                fetch(endpoint, {
                                    method: 'POST',
                                    body: data
                                })
                                .then(res => res.json())
                                .then(res => {
                                    if (res.success) {
                                        $.notify('MEGA link updated successfully!', 'success');
                                        setTimeout(() => window.location.reload(), 1000);
                                    } else {
                                        $.notify(res.message || 'Failed to update MEGA link', 'danger');
                                    }
                                })
                                .catch(() => {
                                    $.notify('Request failed', 'danger');
                                });
                            }
                        }
                    }
                });
            }
        </script>
    </body>
</html>