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
            .current-image {
                max-width: 200px;
                max-height: 200px;
                margin-top: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 5px;
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
                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true">
                                    <i class="fa fa-edit mr-2"></i>Editing Customer <?php echo htmlspecialchars($this->data['current']['name']); ?>
                                </a>
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
                            <div class="tab-pane fade show active" id="addzone" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <div class="card bg-secondary shadow">
                                    <div class="card-header bg-white border-0">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h3 class="mb-0">Customer Management</h3>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <?php if(count($this->data['session'])): ?>
                                                    <?php foreach ($this->data['session'] as $msg): ?>
                                                        <?php echo $msg; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="heading-small text-muted mb-4">Edit information</h6>
                                        <div class="pl-lg-4">       
                                            <form id="postzone" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="<?php echo $this->data['current']['id']; ?>">
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="type">Type <span class="required">*</span></label>
                                                            <select id="type" name="type" class="form-control" required>
                                                                <option value="">Select Type</option>
                                                                <option value="customer" <?php echo ($this->data['current']['type'] === 'customer') ? 'selected' : ''; ?>>Customer</option>
                                                                <option value="lead" <?php echo ($this->data['current']['type'] === 'lead') ? 'selected' : ''; ?>>Lead</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="name">Name <span class="required">*</span></label>
                                                            <input value="<?php echo htmlspecialchars($this->data['current']['name']); ?>" type="text" id="name" name="name" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="business_name">Business Name</label>
                                                            <input value="<?php echo htmlspecialchars($this->data['current']['business_name']); ?>" type="text" id="business_name" name="business_name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="status">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option value="active" <?php echo ($this->data['current']['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                                                                <option value="inactive" <?php echo ($this->data['current']['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="phone">Phone</label>
                                                            <input value="<?php echo htmlspecialchars($this->data['current']['phone']); ?>" type="text" id="phone" name="phone" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="email">Email</label>
                                                            <input value="<?php echo htmlspecialchars($this->data['current']['email']); ?>" type="email" id="email" name="email" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="map">Select Location on Map</label>
                                                            <div id="map" style="height: 300px; width: 100%;"></div>
                                                            <input type="hidden" id="longitude" name="longitude" value="<?php echo htmlspecialchars($this->data['current']['longitude']); ?>">
                                                            <input type="hidden" id="latitude" name="latitude" value="<?php echo htmlspecialchars($this->data['current']['latitude']); ?>">
                                                            <small class="form-text text-muted">Click on the map to update location. Address and map link will be autofilled.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Map Link: <span style="color: red;">(Auto-filled after selecting location)<br>
                                                                <a id="map_link_a" style="font-weight:normal;text-decoration:underline" href="<?php echo htmlspecialchars($this->data['current']['map_link']); ?>" target="_blank" style="display:<?php echo !empty($this->data['current']['map_link']) ? 'inline' : 'none'; ?>;">
                                                                    <?php echo htmlspecialchars($this->data['current']['map_link']); ?>
                                                                </a>
                                                            </span></label>
                                                            <input type="hidden" value="<?php echo htmlspecialchars($this->data['current']['map_link']); ?>" id="map_link" name="map_link" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="address">Address</label>
                                                            <textarea id="address" name="address" class="form-control"><?php echo htmlspecialchars($this->data['current']['address']); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="notes">Notes</label>
                                                            <textarea id="notes" name="notes" class="form-control"><?php echo htmlspecialchars($this->data['current']['notes']); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-control-label" for="image">Image</label>
                                                            <input type="file" id="image" name="image" class="form-control">
                                                            <?php if (!empty($this->data['current']['image'])): ?>
                                                                <div>Current Image:</div>
                                                                <img src="<?php echo htmlspecialchars($this->data['current']['image']); ?>" class="current-image" alt="Current Customer Image">
                                                                <div class="form-check mt-2">
                                                                    <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                                                    <label class="form-check-label" for="remove_image">Remove current image</label>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Registered by</label>
                                                            <div class="form-control-plaintext">
                                                                <?php echo htmlspecialchars($this->data['current']['agent_email']); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-center">
                                                    <button type="submit" name="save" value="1" class="btn btn-primary">Update Customer</button>
                                                    <a href="<?php echo $base_url; ?>/modules/customers/" class="btn btn-secondary">Cancel</a>
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
        
        <?php include '../../layout/footer_scripts.php'; ?>
        
        <script>
            // Initialize Google Maps with current location
            let map, marker, geocoder;
            
            function initMap() {
                geocoder = new google.maps.Geocoder();
                
                // Use current customer coordinates or default
                let lat = parseFloat(document.getElementById('latitude').value) || 0;
                let lng = parseFloat(document.getElementById('longitude').value) || 0;
                
                // If no coordinates but have address, try to geocode it
                if ((lat === 0 || lng === 0) && document.getElementById('address').value) {
                    geocodeAddress(geocoder, document.getElementById('address').value);
                    return;
                }
                
                let center = { lat: lat || 0, lng: lng || 0 };
                map = new google.maps.Map(document.getElementById('map'), {
                    center: center,
                    zoom: (lat !== 0 || lng !== 0) ? 15 : 2
                });

                if (lat !== 0 || lng !== 0) {
                    marker = new google.maps.Marker({
                        position: center,
                        map: map,
                        draggable: true
                    });
                    
                    // Update fields when marker is dragged
                    marker.addListener('dragend', function() {
                        updateLocationFields(marker.getPosition());
                    });
                }

                // Add click listener to place/update marker
                map.addListener('click', function(e) {
                    updateLocationFields(e.latLng);
                });
            }
            
            function updateLocationFields(location) {
                if (!marker) {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        draggable: true
                    });
                    
                    // Add drag listener for new marker
                    marker.addListener('dragend', function() {
                        updateLocationFields(marker.getPosition());
                    });
                } else {
                    marker.setPosition(location);
                }
                
                document.getElementById('latitude').value = location.lat();
                document.getElementById('longitude').value = location.lng();
                
                // Update address and map link
                geocodeLatLng(location.lat(), location.lng());
                updateMapLink(location.lat(), location.lng());
            }
            
            function geocodeLatLng(lat, lng) {
                let latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };
                geocoder.geocode({ location: latlng }, function(results, status) {
                    if (status === 'OK' && results[0]) {
                        document.getElementById('address').value = results[0].formatted_address;
                    }
                });
            }
            
            function geocodeAddress(geocoder, address) {
                geocoder.geocode({ 'address': address }, function(results, status) {
                    if (status === 'OK') {
                        let location = results[0].geometry.location;
                        document.getElementById('latitude').value = location.lat();
                        document.getElementById('longitude').value = location.lng();
                        
                        // Initialize map with found location
                        initMapWithLocation(location);
                    } else {
                        // Fallback to default map if geocoding fails
                        initMapWithLocation({ lat: 0, lng: 0 });
                    }
                });
            }
            
            function initMapWithLocation(location) {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: location,
                    zoom: 15
                });

                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    draggable: true
                });
                
                // Update fields when marker is dragged
                marker.addListener('dragend', function() {
                    updateLocationFields(marker.getPosition());
                });

                // Add click listener to place/update marker
                map.addListener('click', function(e) {
                    updateLocationFields(e.latLng);
                });
            }
            
            function updateMapLink(lat, lng) {
                let link = `https://www.google.com/maps?q=${lat},${lng}`;
                let mapLinkInput = document.getElementById('map_link');
                let mapLinkA = document.getElementById('map_link_a');
                
                if (mapLinkInput) mapLinkInput.value = link;
                if (mapLinkA) {
                    mapLinkA.href = link;
                    mapLinkA.textContent = link;
                    mapLinkA.style.display = 'inline';
                }
            }
            
            // Load Google Maps API
            function loadGoogleMaps() {
                const script = document.createElement('script');
                script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyCJo7h6oXFV2UBxPAp2YfZFeETU-PslP-Q&callback=initMap`;
                script.async = true;
                script.defer = true;
                document.head.appendChild(script);
            }
            
            // Initialize when DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                loadGoogleMaps();
                
                // If we have address but no coordinates, try to geocode it first
                if ((!document.getElementById('latitude').value || !document.getElementById('longitude').value) && 
                    document.getElementById('address').value) {
                    geocodeAddress(new google.maps.Geocoder(), document.getElementById('address').value);
                }
            });
        </script>
    </body>
</html>