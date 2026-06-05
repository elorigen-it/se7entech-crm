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
            .required{
                color:red;
            }
            table.dataTable>tbody>tr.child ul.dtr-details>li:last-child{
                white-space: normal !important;
            }
            .switch {
                position: relative;
                display: inline-block;
                width: 38px;
                height: 20px;
            }
            .switch input {display:none;}
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
                background-color: #2196F3;
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
                    <div class="nav-wrapper">
                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-plus mr-2"></i>Add New Record</a>
                            </li>    
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-media-list" data-toggle="tab" href="#listzones" role="tab" aria-controls="tabs-menagment" aria-selected="false"><i class="fa fa-list mr-2"></i>Customers List</a>
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
                                            <h3 class="mb-0">Customers Management</h3>
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
                                        <form id="postzone" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="type">Type <span class="required">*</span></label>
                                                        <select id="type" name="type" class="form-control" required>
                                                            <option value="">Select Type</option>
                                                            <option value="customer" <?php echo (isset($this->data['last_data']['type']) && $this->data['last_data']['type'] === 'customer') ? 'selected' : ''; ?>>Customer</option>
                                                            <option value="lead" <?php echo (isset($this->data['last_data']['type']) && $this->data['last_data']['type'] === 'lead') ? 'selected' : ''; ?>>Lead</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="name">Name <span class="required">*</span></label>
                                                        <input value="<?php echo isset($this->data['last_data']['name']) ? $this->data['last_data']['name'] : '';?>" type="text" id="name" name="name" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="business_name">Business Name</label>
                                                        <input value="<?php echo isset($this->data['last_data']['business_name']) ? $this->data['last_data']['business_name'] : '';?>" type="text" id="business_name" name="business_name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="status">Status</label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="active" <?php echo isset($this->data['last_data']['status']) && $this->data['last_data']['status'] === 'active' ? 'selected' : '';?>>Active</option>
                                                            <option value="inactive" <?php echo isset($this->data['last_data']['status']) && $this->data['last_data']['status'] === 'inactive' ? 'selected' : '';?>>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>   
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="phone">Phone</label>
                                                        <input value="<?php echo isset($this->data['last_data']['phone']) ? $this->data['last_data']['phone'] : '';?>" type="text" id="phone" name="phone" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="email">Email</label>
                                                        <input value="<?php echo isset($this->data['last_data']['email']) ? $this->data['last_data']['email'] : '';?>" type="email" id="email" name="email" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="map">Select Location on Map</label>
                                                        <div id="map" style="height: 300px; width: 100%;"></div>
                                                        <input type="hidden" id="longitude" name="longitude" value="<?php echo isset($this->data['last_data']['longitude']) ? $this->data['last_data']['longitude'] : '';?>">
                                                        <input type="hidden" id="latitude" name="latitude" value="<?php echo isset($this->data['last_data']['latitude']) ? $this->data['last_data']['latitude'] : '';?>">
                                                        <small class="form-text text-muted">Click on the map to select a location. Address and map link will be autofilled.</small>
                                                    </div>
                                                </div>
                                                <script>
                                                    let map, marker, geocoder;
                                                    function initMap() {
                                                        geocoder = new google.maps.Geocoder();
                                                        // Try to get device location first
                                                        if (navigator.geolocation) {
                                                            navigator.geolocation.getCurrentPosition(function(position) {
                                                                let lat = parseFloat(document.getElementById('latitude').value) || position.coords.latitude;
                                                                let lng = parseFloat(document.getElementById('longitude').value) || position.coords.longitude;
                                                                let center = { lat: lat, lng: lng };
                                                                map = new google.maps.Map(document.getElementById('map'), {
                                                                    center: center,
                                                                    zoom: 18
                                                                });

                                                                if (document.getElementById('latitude').value && document.getElementById('longitude').value) {
                                                                    marker = new google.maps.Marker({
                                                                        position: center,
                                                                        map: map
                                                                    });
                                                                    // Autofill address and map link if lat/lng already set
                                                                    geocodeLatLng(lat, lng);
                                                                    autofillMapLink(lat, lng);
                                                                }

                                                                map.addListener('click', function(e) {
                                                                    placeMarker(e.latLng, map);
                                                                });
                                                            }, function() {
                                                                // Fallback if user denies geolocation
                                                                initMapFallback();
                                                            });
                                                        } else {
                                                            // Browser doesn't support Geolocation
                                                            initMapFallback();
                                                        }
                                                    }

                                                    function initMapFallback() {
                                                        let lat = parseFloat(document.getElementById('latitude').value) || 0;
                                                        let lng = parseFloat(document.getElementById('longitude').value) || 0;
                                                        let center = { lat: lat, lng: lng };
                                                        map = new google.maps.Map(document.getElementById('map'), {
                                                            center: center,
                                                            zoom: (lat !== 0 || lng !== 0) ? 12 : 2
                                                        });

                                                        if (lat !== 0 || lng !== 0) {
                                                            marker = new google.maps.Marker({
                                                                position: center,
                                                                map: map
                                                            });
                                                            // Autofill address and map link if lat/lng already set
                                                            geocodeLatLng(lat, lng);
                                                            autofillMapLink(lat, lng);
                                                        }

                                                        map.addListener('click', function(e) {
                                                            placeMarker(e.latLng, map);
                                                        });
                                                    }

                                                    function placeMarker(location, map) {
                                                        if (marker) {
                                                            marker.setPosition(location);
                                                        } else {
                                                            marker = new google.maps.Marker({
                                                                position: location,
                                                                map: map
                                                            });
                                                        }
                                                        document.getElementById('latitude').value = location.lat();
                                                        document.getElementById('longitude').value = location.lng();
                                                        geocodeLatLng(location.lat(), location.lng());
                                                        autofillMapLink(location.lat(), location.lng());
                                                    }

                                                    function geocodeLatLng(lat, lng) {
                                                        if (!geocoder) return;
                                                        let latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };
                                                        geocoder.geocode({ location: latlng }, function(results, status) {
                                                            if (status === 'OK') {
                                                                if (results[0]) {
                                                                    document.getElementById('address').value = results[0].formatted_address;
                                                                }
                                                            }
                                                        });
                                                    }

                                                    function autofillMapLink(lat, lng) {
                                                        let link = `https://www.google.com/maps?q=${lat},${lng}`;
                                                        let mapLinkInput = document.getElementById('map_link');
                                                        let mapLinkA = document.getElementById('map_link_a');
                                                        if (mapLinkInput) {
                                                            mapLinkInput.value = link;
                                                        }
                                                        if (mapLinkA) {
                                                            mapLinkA.href = link;
                                                            mapLinkA.textContent = link;
                                                            mapLinkA.style.display = 'inline';
                                                        }
                                                    }

                                                    // On page load, if map_link exists, set the A element
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        let lat = document.getElementById('latitude').value;
                                                        let lng = document.getElementById('longitude').value;
                                                        if (lat && lng) {
                                                            autofillMapLink(lat, lng);
                                                        } else {
                                                            // If map_link is set but lat/lng is not, fallback to map_link value
                                                            let mapLinkInput = document.getElementById('map_link');
                                                            let mapLinkA = document.getElementById('map_link_a');
                                                            if (mapLinkInput && mapLinkInput.value && mapLinkA) {
                                                                mapLinkA.href = mapLinkInput.value;
                                                                mapLinkA.textContent = mapLinkInput.value;
                                                                mapLinkA.style.display = 'inline';
                                                            }
                                                        }
                                                    });
                                                </script>
                                                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJo7h6oXFV2UBxPAp2YfZFeETU-PslP-Q&callback=initMap" async defer></script>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Map Link: <span style="color: red;">(Auto-filled after selecting location)<br>
                                                            <a id="map_link_a" style="font-weight:normal;text-decoration:underline" href="<?php echo isset($this->data['last_data']['map_link']) ? htmlspecialchars($this->data['last_data']['map_link']) : '#';?>" target="_blank" style="display:<?php echo isset($this->data['last_data']['map_link']) && $this->data['last_data']['map_link'] ? 'inline' : 'none';?>;">
                                                                <?php echo isset($this->data['last_data']['map_link']) ? htmlspecialchars($this->data['last_data']['map_link']) : '';?>
                                                            </a>
                                                        </span></label>
                                                        <input type="hidden" value="<?php echo isset($this->data['last_data']['map_link']) ? htmlspecialchars($this->data['last_data']['map_link']) : '';?>" id="map_link" name="map_link" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="address">Address</label>
                                                        <textarea id="address" name="address" class="form-control"><?php echo isset($this->data['last_data']['address']) ? $this->data['last_data']['address'] : '';?></textarea>
                                                    </div>
                                                </div>
                                            </div>                                   
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="notes">Notes</label>
                                                        <textarea id="notes" name="notes" class="form-control"><?php echo isset($this->data['last_data']['notes']) ? $this->data['last_data']['notes'] : '';?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="mega_upload_link">Enlace de Mega para subir archivos</label>
                                                        <input value="<?php echo isset($this->data['last_data']['mega_upload_link']) ? htmlspecialchars($this->data['last_data']['mega_upload_link']) : '';?>" type="url" id="mega_upload_link" name="mega_upload_link" class="form-control" placeholder="https://mega.nz/...">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="image">Image</label>
                                                        <input type="file" id="image" name="image" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="text-center">
                                                <button type="submit" name="save" value="1" class="btn btn-primary">Save Record</button>
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
                                    <table id="zones-list-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                        <thead style="background:#337ab7;color:white;"> 
                                            <tr>
                                                <th>ID</th>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Business Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="zones-list-tbody">
                                            <?php if(count($this->data['records'])):?>
                                                <?php foreach($this->data['records'] as $record):?>
                                                    <tr id="<?php echo 'row-'.$record['id'];?>">
                                                        <td><?php echo $record['id'];?></td>
                                                        <td><?php echo $record['type'];?></td>
                                                        <td><?php echo $record['name'];?></td>
                                                        <td><?php echo $record['business_name'];?></td>
                                                        <td><?php echo $record['phone'];?></td>
                                                        <td><?php echo $record['email'];?></td>
                                                        <td><?php echo ucfirst($record['status']);?></td>
                                                        <td>

                                                            <!-- Actions: Edit & Delete -->
                                                            <h5>Edit and Delete</h5>
                                                            <div class="btn-group mb-1" role="group" aria-label="Edit and Delete">
                                                                <a href="<?php echo $base_url;?>/modules/customers/index.php/<?php echo $record['id'];?>" class="btn btn-primary btn-sm" style="margin-right:5px;">Edit</a>
                                                                <a href="#" class="btn btn-danger btn-sm" data-id="<?php echo $record['id'];?>" onclick="showModal(this)">Delete</a>
                                                            </div>
                                                            <hr style="margin:.5em 0"/>
                                                            <!-- Actions: AI Generation -->
                                                            <h5>AI Generation</h5>
                                                            <div class="btn-group mb-1" role="group" aria-label="AI Generation">
                                                                <a href="<?php echo $base_url;?>/modules/customers/index.php/<?php echo $record['id'];?>/brand-rules/generate" class="btn btn-info btn-sm" style="margin-right:5px;">
                                                                    <i class="fa fa-magic" aria-hidden="true"></i> AI Rules
                                                                </a>
                                                                <a href="<?php echo $base_url;?>/modules/customers/index.php/<?php echo $record['id'];?>/content-creator/generate" class="btn btn-success btn-sm" style="margin-right:5px;">
                                                                    <i class="fa fa-magic" aria-hidden="true"></i> AI Create Content
                                                                </a>
                                                            </div>
                                                            <hr style="margin:.5em 0"/>

                                                            <!-- Actions: AI Management -->
                                                            <h5>AI Management</h5>
                                                            <div class="btn-group mb-1" role="group" aria-label="AI Management">
                                                                <a href="<?php echo $base_url;?>/modules/customers/index.php/<?php echo $record['id'];?>/brand-rules/manage" class="btn btn-warning btn-sm" style="margin-right:5px;">
                                                                    <i class="fa fa-magic" aria-hidden="true"></i> Manage AI Rules
                                                                </a>
                                                                <a href="<?php echo $base_url;?>/modules/customers/index.php/<?php echo $record['id'];?>/brand-content/manage" class="btn btn-warning btn-sm" style="margin-right:5px;">
                                                                    <i class="fa fa-magic" aria-hidden="true"></i> Manage AI Content
                                                                </a>
                                                            </div>
                                                            <hr style="margin:.5em 0"/>

                                                            <!-- Login Access Switch -->
                                                            <h5>Access Activation</h5>
                                                            <?php
                                                                $hasLogin = !empty($record['access_id']);
                                                                $isActive = $hasLogin && $record['active_access'] == 1;
                                                                $switchId = 'login-switch-' . $record['id'];
                                                            ?>
                                                            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                                                <label class="switch" style="vertical-align:middle; margin-bottom: 0;">
                                                                    <input type="checkbox" 
                                                                        data-defaultusername="<?php echo $record['email'];?>" 
                                                                        data-checkboxid="<?php echo $switchId;?>" 
                                                                        <?php echo $isActive ? 'checked' : '';?> 
                                                                        onchange="toggleLoginAccess(<?php echo $record['id'];?>, this.checked, this)">
                                                                    <span class="slider round"></span>
                                                                </label>                                                                                                                                                                               
                                                                <?php if ($hasLogin): ?>
                                                                    <button class="btn btn-secondary btn-sm" onclick="resetCustomerPassword(<?php echo $record['id'];?>, '<?php echo htmlspecialchars(!empty($record['username']) ? $record['username'] : $record['email']);?>')">
                                                                        <i class="fa fa-key"></i> Reset Password
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
         </div>
         <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
         </footer>
        </div>
        <!-- Commented because navtabs includes same script -->
        <?php include '../../layout/footer_scripts.php';?>
        <script>
            
            $(document).ready(function(){
                $table = $('#zones-list-table').DataTable({
                    responsive:true,
                    order: [[ 0, "desc" ]], // Order by ID descending
                })

                $table.on('responsive-resize', function (e, datatable, columns) {
                    var count = columns.reduce(function (a, b) {
                        return b === false ? a + 1 : a;
                    }, 0);
                
                    console.log(count + ' column(s) are hidden');
                });

                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var target = $(e.target).attr("href") // activated tab
                    if(target === '#media-list'){
                        $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust()
                        .responsive.recalc(); 
                    }
                });

                //force datatable refresh to apply responsive styles
                $('#zones-list-table').DataTable().draw().columns.adjust().responsive.recalc();

                //check if there is #listzones in the URL
                if(window.location.hash === '#listzones'){
                    $('#tabs-media-list').addClass('show active');
                    $('#tabs-menagment-main').removeClass('show active');
                    $('#listzones').addClass('show active');
                    $('#addzone').removeClass('show active');
                    // Refresh DataTable after tab change
                    $('#zones-list-table').DataTable().columns.adjust().draw().responsive.recalc();
                }

                // Also refresh DataTable when tab is changed by clicking
                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    if ($(e.target).attr('href') === '#listzones') {
                        $('#zones-list-table').DataTable().columns.adjust().draw().responsive.recalc();
                    }
                });
            });
            
            function showModal(button){
                let id = button.dataset.id;
                let row = button.parentElement.parentElement;    

                bootbox.confirm('Are you sure of this action?', function(confirmed) {
                    console.log(confirmed)
                    if(confirmed){
                        let data = new FormData;
                        data.set('id', id);
                        let endpoint = "<?php echo $base_url;?>/modules/customers/index.php/delete/"
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                $("#zones-list-table").dataTable().fnDeleteRow(row)
                                $.notify('Record deleted!', 'success')
                            }
                        })
                        xhr.send(data)
                    }
                });
            }

            function showAccessModal(customerId, defaultUsername, el) {
                // Show modal to enter username and generate password
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
                                var endpoint = "<?php echo $base_url;?>/modules/customers/index.php/login-access/activate";
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

                // Auto-generate password on popup load
                generatePassword();
            }

            function toggleLoginAccess(customerId, enabled, el) {   
                const defaultUsername = el.dataset.defaultusername || '';
                if (enabled) { 
                    showAccessModal(customerId, defaultUsername, el);
                } else {
                    // Confirm deactivation
                    bootbox.confirm({
                        message: 'Deactivate login access for this customer?',
                        callback: (confirmed) => {
                            if (confirmed) {
                                var data = new FormData();
                                data.append('customer_id', customerId);
                                var endpoint = "<?php echo $base_url;?>/modules/customers/index.php/login-access/deactivate";
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

            function generatePassword() {
                var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
                var pass = "";
                for (var i = 0; i < 10; i++) {
                    pass += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                document.getElementById('password').value = pass;
            }
        </script>        
    </body>
</html>