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
                                                    <tr>
                                                        <td><?php echo $record['id'];?></td>
                                                        <td><?php echo $record['type'];?></td>
                                                        <td><?php echo $record['name'];?></td>
                                                        <td><?php echo $record['business_name'];?></td>
                                                        <td><?php echo $record['phone'];?></td>
                                                        <td><?php echo $record['email'];?></td>
                                                        <td><?php echo ucfirst($record['status']);?></td>
                                                        <td>
                                                            <a href="<?php echo $base_url;?>/modules/customers/index.php/<?php echo $record['id'];?>" class="btn btn-primary">Edit</a>
                                                            <a href="#" class="btn btn-danger" data-id="<?php echo $record['id'];?>" onclick="showModal(this)">Delete</a>
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
                    if(target === '#media-list'){
                        $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust()
                        .responsive.recalc(); 
                    }
                });

                $('#zones-list-table').DataTable({
                    responsive:true,
                    order: [[ 0, "desc" ]], // Order by ID descending
                })

                //force datatable refresh to apply responsive styles
                $('#zones-list-table').DataTable().columns.adjust().responsive.recalc();

                //check if there is #listzones in the URL
                if(window.location.hash === '#listzones'){
                    $('#tabs-media-list').addClass('show active');
                    $('#tabs-menagment-main').removeClass('show active');
                    $('#listzones').addClass('show active');
                    $('#addzone').removeClass('show active');
                    // Refresh DataTable after tab change
                    $('#zones-list-table').DataTable().columns.adjust().responsive.recalc();
                }

                // Also refresh DataTable when tab is changed by clicking
                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    if ($(e.target).attr('href') === '#listzones') {
                        $('#zones-list-table').DataTable().columns.adjust().responsive.recalc();
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
        </script>        
    </body>
</html>