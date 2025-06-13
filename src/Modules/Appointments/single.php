<?php
    namespace Se7entech\Contractnew\Modules\Appointments;

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
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Updating Appointment <?php echo $this->data['current']['subject'] . ' ' . $this->data['current']['customer_email'];?></a>
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
                                    <h6 class="heading-small text-muted mb-4">Edit information</h6>
                                    <div class="pl-lg-4">       
                                        <form id="updateappointment" method="POST">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="subject">Subject</label>
                                                        <input <?php echo ( $this->data['access'] == '0' || $this->data['current']['agent_email'] == $this->session->get('email')) ? '' : 'disabled';?> type="text" id="subject" name="subject" value="<?php echo $this->data['current']['subject'];?>" class="form-control" placeholder="Type a subject">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="customer">Customer</label>
                                                        <select name="customer" id="customer" class="form-control select2" required <?php echo ($this->data['access'] == '0' || $this->data['current']['agent_email'] == $this->session->get('email')) ? '' : 'disabled';?> >
                                                            <option value="">SELECT CUSTOMER</option>
                                                            <?php foreach($this->data['customers'] as $customer):?>
                                                                    <?php 
                                                                        $custom_id = $customer['id'];
                                                                        $current_id = $this->data['current']['customer_id'];    
                                                                    ?>
                                                                    <option 
                                                                        value="<?php echo $custom_id;?>" 
                                                                        <?php echo ($current_id == $custom_id) ? 'selected' : '';?> >
                                                                            <?php echo $customer['type'] . '-' . $customer['name'];?></option>
                                                            
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="customer_email">Recipient(s) email</label>
                                                        <input type="text" <?php echo ($this->data['access'] == '0' || $this->data['current']['agent_email'] == $this->session->get('email')) ? '' : 'disabled';?> id="customer_email" name="customer_email" value="<?php echo isset($this->data['current']['customer_email']) ? $this->data['current']['customer_email'] : ''?>" class="form-control" placeholder="Type an email or select a customer">
                                                        <input type="hidden" <?php echo ($this->data['access'] == '0' || $this->data['current']['agent_email'] == $this->session->get('email')) ? '' : 'disabled';?> id="customer_id" name="customer_id" value="<?php echo isset($this->data['current']['customer_id']) ? $this->data['current']['customer_id'] : ''?> ">
                                                        <input type="hidden" <?php echo ($this->data['access'] == '0' || $this->data['current']['agent_email'] == $this->session->get('email')) ? '' : 'disabled';?> id="customer_table" name="customer_table" value="<?php echo isset($this->data['current']['customer_table']) ? $this->data['current']['customer_table'] : ''?>">
                                                    </div>
                                                </div>
                                                <?php if($this->data['access'] == '0' || $this->data['email'] == $this->data['current']['agent_email']):?>
                                                    <div class="col-md-4">
                                                        <div id="form-group-name" class="form-group  ">
                                                            <label class="form-control-label" for="agent_email">Agent</label>
                                                            <select name="agent_email" id="agent_email" class="form-control select2" required >
                                                                <option value="">SELECT AGENT</option>
                                                                <?php foreach($this->data['users'] as $user):?>
                                                                    <option 
                                                                        value="<?php echo $user['email'];?>" 
                                                                        <?php echo ($this->data['current']['agent_email'] == $user['email']) ? 'selected' : '';?> >
                                                                            <?php echo $user['email'];?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php endif;?>
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="date_start">Date Start</label>
                                                        <input id="date_start" type="text" name="date_start" value="<?php echo $this->data['current']['date_start'];?>" class="form-control form-control" placeholder="Date Start"  required >
                                                        <br>
                                                        <span class="date_start_hour" id="date_start_hour"></span>
                                                        <span class="date_start_hour_m" id="date_start_hour_m"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="date_end">Date End</label>
                                                        <input id="date_end" type="text" name="date_end" value="<?php echo $this->data['current']['date_end'];?>" class="form-control form-control" placeholder="Date End"  required >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="message">Message in email</label>
                                                        <textarea <?php echo ( $this->data['access'] == '0' || $this->data['current']['agent_email'] == $this->session->get('email')) ? '' : 'disabled';?> name="message" class="form-control"><?php echo $this->data['current']['message'];?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="notes">Notes</label>
                                                        <textarea <?php echo ( $this->data['access'] == '0' || $this->data['current']['agent_email'] == $this->session->get('email')) ? '' : 'disabled';?> name="notes" class="form-control"><?php echo $this->data['current']['notes'];?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="form-group-name" class="form-group  ">
                                                        <label class="form-control-label" for="status">Status</label>
                                                        <select <?php echo ($this->data['access'] == '0' || $this->data['current']['agent_email'] == $this->session->get('email')) ? '' : 'disabled';?> name="status" id="status" class="form-control select2" required >
                                                            <option value="created" 
                                                                <?php echo ($this->data['current']['status'] == 'created') ? 'selected' : '';?> >
                                                                Created
                                                            </option>
                                                            <option value="accepted" 
                                                                <?php echo ($this->data['current']['status'] == 'accepted') ? 'selected' : '';?> >
                                                                Accepted
                                                            </option>
                                                            <option value="rejected" 
                                                                <?php echo ($this->data['current']['status'] == 'rejected') ? 'selected' : '';?> >
                                                                Rejected
                                                            </option>
                                                            <option value="expired" 
                                                                <?php echo ($this->data['current']['status'] == 'expired') ? 'selected' : '';?> >
                                                                Expired
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <?php if( $this->data['access'] == '0' ||  $this->data['current']['agent_email'] == $this->session->get('email')):?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="form-group-name" class="form-group  ">
                                                            <button type="submit" name="save" value="save" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif;?>
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

        <script>
            const CUSTOMERMAP = <?php echo json_encode($this->data['customers']);?>;
            
            $('#date_start').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                startDate: "<?php echo $this->data['current']['date_start'];?>",
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
                startDate: "<?php echo $this->data['current']['date_end'];?>",
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
        </script>
    </body>
</html>