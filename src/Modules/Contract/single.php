<?php
    namespace Se7entech\Contractnew\Modules\Contracts;

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
            .se7entech-input, .se7entech-input-number{
                height: 28px;
                padding: 3px;
                border: 1px solid transparent;
                margin:3px .5em;
                border-bottom-color: black;
                outline:none;
                width: 250px;
                background:transparent;
            }
            .se7entech-input-number{
                width:50px;
            }
            /* .se7entech-input:focus{
                border: 1px solid transparent;
                border-bottom-color: black;
                outline:none;
            } */
            .se7entech-paragraph{
                line-height:2.5;
                text-align:justify;
                color:#000;
            }
            .se7entech-bordered-paragraph{
                border-style: solid;
                border-radius:3px;
                border-width:1px;
                padding: 1em;
                border-color:#5f908e;
            }
            .bolder{
                font-weight:bolder;
                /* color:#256361; */
            }
            .mt-2{
                margin-top:2em;
            }
            .mb-2{
                margin-bottom:2em !important;
            }
            .signature-pad{
                border: 2px solid #00918a;
                border-radius: 3%;
                margin: 0 auto;
                display: block;
            }
            .sign-labels{
                display:block;
                text-align:center;
            }
            .button_sign_clear{
                margin: 0 auto;
                display: block;
                margin-top: 2em;
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
                                <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#addzone" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-user mr-2"></i>Updating contract <?php echo $this->data['current']['company_name_1'];?></a>
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
                                            <h3 class="mb-0">Contract Management</h3>
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
                                        <div class="container mb-2">
                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-1">
                                                    <label for="customer_id" class="bolder">Populate with:</label><br>
                                                    <input type="hidden" class="customer_id_input" id="customer_id_input" name="customer_id_input">
                                                    <select name="customer_id" id="customer_id" class="form-control select2">
                                                        <option>SELECT A CUSTOMER</option>
                                                        <?php foreach($this->data['customers'] as $customer):?>
                                                            <option value="<?php echo $customer['id'];?>"><?php echo $customer['type'] . ' - ' .$customer['business_name'] . ' - ' . $customer['name'];;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6 mb-1">
                                                    <label for="services_control" class="bolder">Services:</label><br>
                                                    <select name="services_control[]" id="services_control" multiple class="form-control select2">
                                                        <option>SELECT A SERVICE</option>
                                                        <?php if(count($this->data['groups'])): ?>
                                                            <?php foreach($this->data['groups'] as $group => $val):?>
                                                                <optgroup label="<?php echo $val[0];?>">
                                                                    <?php foreach($this->data['services'] as $service):?>
                                                                        <?php if($service['department_id'] === $val[1]):?>
                                                                            <option value="<?php echo $service['id'];?>"><?php echo $service['name'];?></option>
                                                                        <?php endif;?>
                                                                    <?php endforeach;?>
                                                                </optgroup>
                                                            <?php endforeach;?>
                                                        <?php endif;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label for="company_name_control" class="bolder">Customer Company</label>
                                                    <input type="text" name="company_name_control" id="company_name_control" class="form-control company_name_control">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="customer_name_control" class="bolder">Customer Name</label>
                                                    <input type="text" name="customer_name_control" id="customer_name_control" class="form-control customer_name_control">
                                                </div>
                                            </div>
                                        </div>    
                                        <form id="postcontract" method="POST">
                                            <!-- Form Name -->
                                            <legend>
                                                <center>
                                                    <img style="height:50px;width:150px" src="https://se7entech.net/images/logo.png">
                                                    <h1 style="color:#000080;"><b>Sales Contract<br>
                                                        <U>SE7ENTECH</u></b>
                                                    </h1>
                                                    <BR>
                                                    <P>460 Irving park rd Suite C123, Bensenville, IL 60106<br>
                                                        (773)-666-2021
                                                    </P>
                                                </center>
                                                <div id="google_translate_element"></div>
                                            </legend>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-12"> 
                                                    <p class="se7entech-paragraph">
                                                        <span>I</span>
                                                        <input type="text" <?php echo ($this->session->get('access') != '0') ? 'disabled' : '';?>  placeholder="Se7entech RP" value="<?php echo $this->data['current']['agent_name_1'];?>" name="agent_name_1" class="se7entech-input no-outline" >
                                                        <span> the Representative of SE7ENTECH hereby enter into a Sales Agreement with </span>
                                                        <input type="text" value="<?php echo $this->data['current']['customer_name_1'];?>" name="customer_name_1" class="se7entech-input no-outline mirror_customer_name" placeholder="Company Representative Name">
                                                        <span> who is the owner/Representative of &nbsp;</span>
                                                        <input type="text" value="<?php echo $this->data['current']['company_name_1'];?>" name="company_name_1" class="se7entech-input no-outline mirror_company_name" placeholder="Company Name">
                                                        <span>for a term of business to be enacted on this </span>
                                                        <input type="date" value="<?php echo $this->data['current']['contract_date_start'];?>" required name="contract_date_start" class="se7entech-input no-outline" placeholder="">
                                                        <span>And shall automatically end on </span>
                                                        <input type="date" value="<?php echo $this->data['current']['contract_date_end'];?>" required  name="contract_date_end" class="se7entech-input no-outline" placeholder=""> 
                                                        <span>unless further contractual terms are added within this Sales Agreement. </span>
                                                    </p>
                                                    <p class="se7entech-paragraph">
                                                        <span>This Sales Agreement shall include the following services offered to </span>
                                                        <input type="text" value="<?php echo $this->data['current']['customer_name_2'];?>" name="customer_name_2" class="se7entech-input no-outline mirror_customer_name" placeholder="">
                                                        <span>at the rates so listed there in beside each service offered: </span>
                                                    </p>
                                                    <textarea id="services" name="services"><?php echo $this->data['current']['services'];?></textarea>
                                                    <p class="se7entech-paragraph">
                                                        <span>*Our company shall provide</span>
                                                        <input name="maintenance_period" type="text" value="<?php echo $this->data['current']['maintenance_period'];?>" class="se7entech-input no-outline" placeholder="Maintenance Period">
                                                        <span>days of support at no additional cost after project gets online.</span>
                                                        <span>We shall take care of any bugs or issues caused during that period.</span>
                                                    </p>
                                                    <p class="se7entech-paragraph"> 
                                                        <span><b>SE7ENTECH</b> agree to provide above listed services and sales to the Owner/Representative  of </span>
                                                        <input type="text"  value="<?php echo $this->data['current']['company_name_2'];?>" name="company_name_2" class="se7entech-input no-outline mirror_company_name" placeholder="Client's Company Name">  
                                                        <span>on a per needed basis and shall remain at their service until they require.</span>
                                                    </p>
                                                                                                                
                                                </div>                                                        
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-sm-12" >
                                                    <div class="row se7entech-bordered-paragraph">
                                                        <div class="col-sm-4"> 
                                                            <label class="bolder">Shipping cost & handling:</label>
                                                            <input name="shipping_handling" value="<?php echo $this->data['current']['shipping_handling'];?>" type="number" class="form-control">
                                                        </div>
                                                    
                                                        <div class="col-sm-4">
                                                            <label class="bolder">Sale tax:</label>
                                                            <input name="sale_tax" type="number" value="<?php echo $this->data['current']['sale_tax'];?>" class="form-control">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label class="bolder">Total purchase value:</label>
                                                            <input name="total_purchase" type="number" value="<?php echo $this->data['current']['total_purchase'];?>" class="form-control">
                                                        </div>
                                                        
                                                        <div class="col-sm-4"> 
                                                            <label class="bolder">Additional Deposit:</label>
                                                            <input name="additional_deposit" type="number" value="<?php echo $this->data['current']['additional_deposit'];?>" class="form-control">
                                                        </div>
                                                        
                                                        <div class="col-sm-4"> 
                                                            <label class="bolder">Payment date:</label>
                                                            <input name="payment_date" type="date" value="<?php echo $this->data['current']['payment_date'];?>" class="form-control">
                                                        </div>
                                                        
                                                        <div class="col-sm-4"> 
                                                            <label class="bolder">Balance dues after additional Deposit:</label>
                                                            <input name="dues_after_deposit" type="number" value="<?php echo $this->data['current']['dues_after_deposit'];?>" class="form-control">
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <p class="se7entech-paragraph"> 
                                                                As use Our products and services remains in effect, the following terms and conditions will apply in all matters concerning this Sales Agreement.
                                                            </p>
                                                            <p class="se7entech-paragraph">
                                                                Terms & Conditions* (www.se7entech.net/contract/term.php)
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-6"> 
                                                            <label class="bolder">Company representative Name:</label>
                                                            <input name="agent_name_2" type="text" value="<?php echo $this->data['current']['agent_name_2'];?>" <?php echo ($this->session->get('access') != '0') ? 'disabled' : '';?> class="form-control">
                                                        </div>
                                                        
                                                        <div class="col-sm-6"> 
                                                            <label class="bolder">Enter Date:</label>
                                                            <input name="contract_sign_date_agent" type="date" value="<?php echo $this->data['current']['contract_sign_date_agent'];?>" class="form-control">
                                                        </div>
                                                        
                                                        <div class="col-sm-6"> 
                                                            <label class="bolder">Client representative Name:</label>
                                                            <input name="customer_name_3" type="text" value="<?php echo $this->data['current']['customer_name_3'];?>" class="form-control mirror_customer_name">
                                                        </div>
                                                        
                                                        <div class="col-sm-6"> 
                                                            <label class="bolder">Enter Date:</label>
                                                            <input name="contract_sign_date_customer" value="<?php echo $this->data['current']['contract_sign_date_customer'];?>" type="date" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-sm-6"> 
                                                            <label class="bolder sign-labels">Agent Signature:</label>
                                                            <canvas id="canvas-signature-agent" class="signature-pad" width="400px" height="300px" >Canvas not supported!</canvas>
                                                            <input name="agent_sign" type="hidden" value="<?php echo $this->data['current']['agent_sign'];?>" id="agent_sign">
                                                            <button class="button_sign_clear btn btn-danger btn-sm" id="clear_agent_sign"><i class="fa fa-eraser" aria-hidden="true"></i>clear</button>
                                                        </div>
                                                            
                                                        <div class="col-sm-6"> 
                                                            <label class="bolder sign-labels">Client Signature:</label>
                                                            <canvas id="canvas-signature-customer" class="signature-pad" width="400px" height="300px" >Canvas not supported!</canvas>
                                                            <input name="customer_sign" type="hidden" value="<?php echo $this->data['current']['customer_sign'];?>" id="customer_sign">
                                                            <button class="button_sign_clear btn btn-danger btn-sm" id="clear_customer_sign"><i class="fa fa-eraser" aria-hidden="true"></i>clear</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                                  
                                            <div class="text-center">
                                                <button type="submit" name="save" value="1" class="btn btn-primary mt-2">Submit</button>
                                            </div>
                                        </form>
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
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
        <script>
            var customers = <?php echo json_encode($this->data['customers']);?>;
            var services = <?php echo json_encode($this->data['services']);?>

            window.addEventListener('DOMContentLoaded', () => {
                const customer_selection = document.querySelector('#customer_id');
                const company_name_control = document.querySelector('#company_name_control');
                const customer_name_control = document.querySelector('#customer_name_control');
                const services_textarea = `<?php echo addslashes($this->data['current']['services']);?>`
                const removeTags = (str) => {
                    if ((str===null) || (str==='')) 
                        return false; 
                    else
                        str = str.toString(); 
                          
                    // Regular expression to identify HTML tags in 
                    // the input string. Replacing the identified 
                    // HTML tag with a null string. 
                    return str.replace( /(<([^>]+)>)/ig, '');
                }
                
                //let services_split = services_textarea.split('::');
                let services_split = services_textarea.match("<li>(.*)::");
                window.ss = services_split
                window.services_textarea = services_textarea;
                
                let defaultSelected = [];
                if(services_split.length){
                    services_split.forEach((_el) => {
                        $('#services_control option').each((i, _opt) => {
                            // console.log(removeTags(_el)
                            if(_opt.textContent == removeTags(_el) ){
                                defaultSelected.push(_opt.value);
                            }
                        })
                    })
                }
                $('#services_control').val(defaultSelected);
                
                
                $('#customer_id').on('change', (e) => {
                    let selectedCustomer = customers.filter((el) => Number(el.id) === Number(customer_selection.value))[0]

                    company_name_control.value = selectedCustomer.business_name;
                    company_name_control.dispatchEvent(new Event('change', {bubbles:true}));

                    customer_name_control.value = selectedCustomer.name;
                    customer_name_control.dispatchEvent(new Event('change', {bubbles:true}));

                    document.querySelector('customer_id_input').value=customerSelection.value;

                })

                company_name_control.addEventListener('change', (e) => {
                    document.querySelectorAll('.mirror_company_name').forEach((el) => {
                        el.value = e.target.value;
                    })
                }, false)

                customer_name_control.addEventListener('change', (e) => {
                    document.querySelectorAll('.mirror_customer_name').forEach((el) => {
                        el.value = e.target.value;
                    })
                }, false)


                $('#services_control').on('change', (e) => {
                    let vals = $(e.target).val()
                    let services_str = '<ul>';
                    vals.forEach((el) => {
                        let selectedService = services.filter((_) => _.id == el )
                        selectedService.map((__) => {
                            services_str += '<li>' + __.name + ':: ' + __.price + '$'+'<br>&nbsp;&nbsp;&nbsp;'+__.description+'</li>'
                        })
                    })
                    services_str += '</ul>'
                    $('#services').summernote('code', services_str)
                })

                //signatures
                var signature_agent = new SignaturePad(document.getElementById('canvas-signature-agent'), {
                    backgroundColor: 'white',
                    penColor: 'black'
                });
                signature_agent.fromDataURL("<?php echo $this->data['current']['agent_sign'];?>");

                signature_agent.addEventListener('endStroke', (e) => {
                    document.querySelector('#agent_sign').value = e.target.toDataURL();
                })
                document.querySelector('#clear_agent_sign').addEventListener('click', (e) => {
                    e.preventDefault();
                    signature_agent.clear();
                    document.querySelector('#agent_sign').value = signature_agent.toDataURL();
                })

                var signature_acustomer = new SignaturePad(document.getElementById('canvas-signature-customer'), {
                    backgroundColor: 'white',
                    penColor: 'black'
                });
                signature_acustomer.fromDataURL("<?php echo $this->data['current']['customer_sign'];?>")

                signature_acustomer.addEventListener('endStroke', (e) => {
                    document.querySelector('#customer_sign').value = e.target.toDataURL();
                })
                document.querySelector('#clear_customer_sign').addEventListener('click', (e) => {
                    e.preventDefault();
                    signature_acustomer.clear();
                    document.querySelector('#customer_sign').value = signature_acustomer.toDataURL();
                })
                // var saveButton = document.getElementById('save');
                // var cancelButton = document.getElementById('clear');
        
                // saveButton.addEventListener('click', function (event) {
                // var data = signaturePad.toDataURL('image/png');
        
                // // Send data to server instead...
                // console.log(data)
                // });
        
                // cancelButton.addEventListener('click', function (event) {
                //     signaturePad.clear();
                // });

                

            }, false)

            $(document).ready(function(){
                $('#contract-list-table').DataTable({
                    responsive:true
                })

                $('#services').summernote();

                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var target = $(e.target).attr("href") // activated tab
                    if(target === '#listcontracts'){
                        $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust()
                        .responsive.recalc(); 
                       
                        // $('#video-list-tbody').html("<img src='<?php echo $base_url;?>/modules/videos/images/uploading.gif' >")
                        // updateMediaListTable()                      
                    }
                });

               
            });

            function filterTable() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("contract-list-table");
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
                        let endpoint = "<?php echo $base_url;?>/modules/roles/index.php/delete/"
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', endpoint, true)
                        xhr.addEventListener('load', (e) => {
                            let res = JSON.parse(e.target.response);
                            if(res.success){
                                $("#contract-list-table").dataTable().fnDeleteRow(row)
                                $.notify('Role deleted!', 'success')
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