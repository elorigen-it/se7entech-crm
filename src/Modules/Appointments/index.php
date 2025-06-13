<?php
    require('../../config/config.php');
    require('../../config/connection.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('../../layout/head.php');?>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

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
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addAppointment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Add new Appointment</a>
                            </li>    
                            <li class="nav-item">
                                <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-media-list" data-toggle="tab" href="#listAppointments" role="tab" aria-controls="tabs-menagment" aria-selected="false"><i class="fa fa-users mr-2"></i>Appointment List</a>
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
                            <div class="tab-pane fade show active" id="addAppointment" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" >
                                <div class="card bg-secondary shadow">
                                    <div class="card-header bg-white border-0">
                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h3 class="mb-0">Appointment Management</h3>
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
                                            <form id="newappointment" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div id="form-group-name" class="form-group  ">
                                                            <label class="form-control-label" for="subject">Subject</label>
                                                            <input type="text" id="subject" name="subject" value="" class="form-control" placeholder="Type a subject">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div id="form-group-name" class="form-group  ">
                                                            <label class="form-control-label" for="customer">Customer</label>
                                                            <select name="customer" id="customer" class="form-control select2">
                                                                <option value="">SELECT CUSTOMER</option>
                                                                <?php foreach($this->data['customers'] as $customer):?>
                                                                    <?php $custom_id = $customer['id'];?>
                                                                        <option 
                                                                            value="<?php echo $custom_id;?>" 
                                                                            <?php echo isset($this->data['last_data']['customer']) ? (($this->data['last_data']['customer'] == $custom_id) ? 'selected' : '') : '';?> >
                                                                                <?php echo $customer['type'] . '-' . $customer['name'];?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                            <div class="form-group">
                                                                <label><small>No Customer</small></label>
                                                                <input type="checkbox" name="no_customer" id="no_customer">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div id="form-group-name" class="form-group  ">
                                                            <label class="form-control-label" for="customer_email">Recipient(s) email</label>
                                                            <input type="text" id="customer_email" name="customer_email" value="<?php echo isset($this->data['last_data']['customer_email']) ? $this->data['last_data']['customer_email'] : ''?>" class="form-control" placeholder="Type an email or select a customer">
                                                            <input type="hidden" id="customer_id" name="customer_id" value="<?php echo isset($this->data['last_data']['customer_id']) ? $this->data['last_data']['customer_id'] : ''?> ">
                                                            <input type="hidden" id="customer_table" name="customer_table" value="<?php echo isset($this->data['last_data']['customer_table']) ? $this->data['last_data']['customer_table'] : ''?>">
                                                        </div>
                                                    </div>
                                                    <?php if($this->data['access'] == '0'):?>
                                                        <div class="col-md-4">
                                                            <div id="form-group-name" class="form-group  ">
                                                                <label class="form-control-label" for="agent_email">Agent</label>
                                                                <select name="agent_email" id="agent_email" class="form-control select2" required >
                                                                    <option value="">SELECT AGENT</option>
                                                                    <?php foreach($this->data['users'] as $user):?>
                                                                        <option 
                                                                            value="<?php echo $user['email'];?>" 
                                                                            <?php echo isset($this->data['last_data']['agent_email']) ? (($this->data['last_data']['agent_email'] == $user['email']) ? 'selected' : '') : '';?> >
                                                                                <?php echo $user['email'];?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php endif;?>
                                                    <div class="col-md-4">
                                                        <div id="form-group-name" class="form-group  ">
                                                            <label class="form-control-label" for="date_start">Date Start</label>
                                                            <input id="date_start" type="text" name="date_start" value="<?php echo isset($this->data['last_data']['date_start']) ? $this->data['last_data']['date_start'] : '';?>" class="form-control form-control" placeholder="Date Start"  required >
                                                            <br>
                                                            <span class="date_start_hour" id="date_start_hour"></span>
                                                            <span class="date_start_hour_m" id="date_start_hour_m"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div id="form-group-name" class="form-group  ">
                                                            <label class="form-control-label" for="date_end">Date End</label>
                                                            <input id="date_end" type="text" name="date_end" value="<?php echo isset($this->data['last_data']['date_end']) ? $this->data['last_data']['date_end'] : '';?>" class="form-control form-control" placeholder="Date End"  required >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="form-group-name" class="form-group  ">
                                                            <label class="form-control-label" for="message">Message in email</label>
                                                            <textarea name="message" class="form-control summernote" id="summernote"><?php echo isset($this->data['last_data']['message']) ? $this->data['last_data']['message'] : '';?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="form-group-name" class="form-group  ">
                                                            <label class="form-control-label" for="notes">Notes</label>
                                                            <textarea name="notes" class="form-control"><?php echo isset($this->data['last_data']['notes']) ? $this->data['last_data']['notes'] : '';?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="form-group-name" class="form-group  ">
                                                            <label class="form-control-label" for="banner">Banner</label>
                                                            <input type="file" accept=".jpg,.jpeg,.png"id="banner" name="banner">
                                                        </div>
                                                        <div id="form-group-name" class="form-group  ">
                                                            <label class="form-control-label" for="banner2">Banner 2</label>
                                                            <input type="file" accept=".jpg,.jpeg,.png" id="banner2" name="banner2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="form-group-name" class="form-group  ">
                                                            <label class="form-control-label" for="attachment1">Attachment</label>
                                                            <input type="file" id="attachment1" name="attachment1">
                                                        </div>
                                                        <div id="form-group-name" class="form-group  ">
                                                            <label class="form-control-label" for="attachment2">Attachment 2</label>
                                                            <input type="file" id="attachment2" name="attachment2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="form-group-name" class="form-group  ">
                                                            <button type="submit" name="save" value="save" class="btn btn-primary">Add new</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="listAppointments" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <div class="card card-profile shadow">
                                    <!--<div class="card-header">-->
                                    <!--    <input type="text" id="myInput" onkeyup="filterTable()" placeholder="Search for names.." title="Type in a name" class="form-control">-->
                                    <!--</div>-->
                                    <div class="card-body" style="overflow-x:hidden;">
                                        <table id="appointments-list-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                            <thead style="background:#337ab7;color:white;"> 
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Subject</th>
                                                    <th>Customer Email</th>
                                                    <th>Status</th>
                                                    <th>Customer</th>
                                                    <th>Date Start</th>
                                                    <th>Date End</th>
                                                    <th>Message</th>
                                                    <th>Notes</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="appointments-list-tbody">
                                                <?php if(count($this->data['appointments'])):?>
                                                    <?php foreach($this->data['appointments'] as $appointment):?>
                                                        <tr>
                                                            <td><?php echo $appointment['id'];?></td>
                                                            <td title="<?php echo $appointment['subject'];?>"><?php echo substr($appointment['subject'], 0, 50);?>...</td>
                                                            <td><?php echo $appointment['customer_email'];?></td>
                                                            <td>
                                                                <?php 
                                                                    $status_class = ' bg-info ';
                                                                    if($appointment['status'] == 'rejected'){
                                                                        $status_class = ' bg-danger ';
                                                                    }else if($appointment['status'] == 'accepted'){
                                                                        $status_class = ' bg-success ';
                                                                    }
                                                                ?>
                                                                <span class="badge rounded-pill bg-success p-2 text-white <?php echo $status_class;?>">
                                                                    <?php echo $appointment['status'];?>
                                                                </span> 
                                                            </td>
                                                            <td><?php echo isset($appointment['customer_name']) ? $appointment['customer_name'] : 'N/A';?></td>
                                                            <td><?php echo $appointment['date_start'];?></td>
                                                            <td><?php echo $appointment['date_end'];?></td>
                                                            <td><?php echo htmlspecialchars($appointment['message']);?></td>
                                                            <td><?php echo $appointment['notes'];?></td>
                                                            <td>
                                                                <?php if($this->data['access'] === '0' || $this->data['email'] == $appointment['agent_email']):?>
                                                                    <a href="<?php echo $base_url;?>/modules/appointments/index.php/<?php echo $appointment['id'];?>" class="btn btn-primary">Edit</a>
                                                                    <a href="#" data-id="<?php echo $appointment['id'];?>" onclick="showModal(this)" class="btn btn-danger">Delete</a>
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
        </div>
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
        </footer>
        <!-- Commented because navtabs includes same script -->
        <?php include '../../layout/footer_scripts.php';?>

        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

        <script>
            const CUSTOMERMAP = <?php echo json_encode($this->data['customers']);?>;

            $(document).ready(function(){
                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var target = $(e.target).attr("href") // activated tab
                    if(target === '#listAppointments'){
                        $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust()
                        .responsive.recalc(); 
                       
                        // $('#video-list-tbody').html("<img src='<?php echo $base_url;?>/modules/videos/images/uploading.gif' >")
                        // updateMediaListTable()                      
                    }
                });

                $('#appointments-list-table').DataTable({
                    responsive:true
                })

                $('#date_start').daterangepicker({
                    singleDatePicker: true,
                    timePicker: true,
                    startDate: moment().startOf('hour'),
                    endDate: moment().startOf('hour').add(32, 'hour'),
                    locale: {
                    format: 'YYYY-M-DD hh:mm A'
                    }
                });
                //on update value
                $('#date_start').on('apply.daterangepicker', function(ev, picker) {});


                $('#date_end').daterangepicker({
                    singleDatePicker: true,
                    timePicker: true,
                    startDate: moment().startOf('hour'),
                    endDate: moment().startOf('hour').add(32, 'hour'),
                    locale: {
                    format: 'YYYY-M-DD hh:mm A'
                    }
                })
                //on update value
                $('#date_end').on('apply.daterangepicker', function(ev, picker) {});

                $('#customer').on('change', (e) => {
                    let val = e.target.value;
                    let customer_selected = CUSTOMERMAP.filter((customer) => customer.id === val);
                    $('#customer_email').val(customer_selected[0].email);
                    // $('#customer_table').val(vals[0]);
                    $('#customer_id').val(val);
                })

                document.querySelector('#no_customer').addEventListener('click', (e) => {
                    console.log(e.target.checked)
                    if(e.target.checked){
                        document.querySelector('#customer').style.display='none';
                        document.querySelector('#customer + .select2').style.display='none';

                    }else{
                        document.querySelector('#customer').style.display='block';
                        document.querySelector('#customer + .select2').style.display='block';
                    }
                }, false)

                $('#summernote').summernote();
                
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
                        let endpoint = "<?php echo $base_url;?>/modules/appointments/index.php/delete/"
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                $("#appointments-list-table").dataTable().fnDeleteRow(row)
                                $.notify('Appointment deleted!', 'success')
                                //TODO: delete row from datatable
                            }
                        })
                        xhr.send(data)
                    }
                });
            }
        </script>        
    </body>
</html>