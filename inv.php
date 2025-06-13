<?php
session_start(); //session start always on top.
require('./vendor/autoload.php');
require_once './envloader.php';
require_once './config/config.php';
require_once './config/connection.php';
require_once 'access.php'; //inside access.php you already have $con variable without importing it there.
require_once 'Invoice.php';

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
use Se7entech\Contractnew\Middlewares\hasFilledRequirementForm;
use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;

$validate = new hasFilledRequirementForm();
$validate->handle(0);

$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_POST['companyName']) && $_POST['companyName']) {	
$invoice->saveInvoice($_POST);
header("Location:inv");	
}

$customers = $_SESSION['access'] === '0' ? CustomersModel::getAllV2() : CustomersModel::getCustomersFromAgent($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include './layout/head.php';?>
      <title>Se7entech - Invoice</title>
    <link rel="stylesheet" href="editor/summernote-bs4.min.css">
   </head>
   <body class="">
      
      <?php  include ('sidebar.php'); ?>
      <div class="main-content">
         <?php include ('nav.php'); ?>
         <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
            <div class="container-fluid">
               <div class="nav-wrapper">
                  <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 active " id="tabs-menagment-main" data-toggle="tab" href="#menagment" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-plus"></i> Add Invoice</a>
                     </li>
                     
                     <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-list"></i> Invoice List</a>
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
                     <div class="tab-pane fade show active" id="menagment" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card bg-secondary shadow">
                           <div class="card-header bg-white border-0">
                              <div class="row align-items-center">
                                 <div class="col-8">
                                    <h3 class="mb-0">Invoice Management <span style="color:red">(Client will pay dues amount on invoice link)</span></h3>
                                 </div>
                                 <!--<div class="col-4 text-right">-->
                                 <!--   <a target="_blank" href="https://feeder.henkakoplus.in/restaurant/kundan"-->
                                 <!--      class="btn btn-sm btn-success">View it</a>-->
                                 <!--</div>-->
                              </div>
                           </div>
                           <div class="card-body">
                              <div class="container content-invoice">
                                 <form   id="invoice-form" method="post"  > 
                                    <div class="load-animate animated fadeInUp">
                                    <input type="hidden" name="logid" value="<?php echo $logid?>">
                                       <input id="currency" type="hidden" value="$">
                                       <div class="form-group" style="display:flex;">
                                          <label class="col-xs-12 col-md-4" for="invoiceConcept"><b>Invoice Concept</b></label>
                                          <input class="col-xs-12 col-md-8 form-control" type="text" name="invoiceConcept" id="invoiceConcept" placeholder="Marketing service - period I" autocomplete="off">
                                       </div>
                                       <div class="row">
                                          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                             <h3>From,</h3>
                                             <?php echo $_SESSION['user']; ?><br>	
                                             <?php echo $_SESSION['address']; ?><br>	
                                             <?php echo $_SESSION['mobile']; ?><br>
                                          </div>      		
                                          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
                                             <h3>To,</h3>
                                             <select name="customer_id" id="customer_id" class="form-control select2">
                                                <option>SELECT A CUSTOMER</option>
                                                <?php foreach($customers as $customer):?>
                                                    <option data-address="<?php echo $customer['address'];?>" value="<?php echo $customer['business_name'] . ' - ' . $customer['name'];?>"><?php echo $customer['type'] . ' - ' .$customer['business_name'] . ' - ' . $customer['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                             <div class="form-group">
                                                <input type="text" class="form-control" name="companyName" id="companyName" placeholder="Company Name" autocomplete="off">
                                             </div>
                                             <div class="form-group">
                                                <textarea class="form-control" rows="3" name="address" id="address" placeholder="Your Address"></textarea>
                                             </div>
                                             
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow-x:auto;">
                                             <table class="table table-bordered table-hover" id="invoiceItem">	
                                                <tr>
                                                   <th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
                                                   <th width="100%">Item No</th>
                                                   <th width="100%">Item Name<span style="color:#f7fafc">-------------------------------</span></th>
                                                   <th width="100%">Quantity<span style="color:#f7fafc">-------------------------------</span></th>
                                                   <th width="100%">Price<span style="color:#f7fafc">-------------------------------</span></th>								
                                                   <th width="100%">Total<span style="color:#f7fafc">-------------------------------</span></th>
                                                </tr>							
                                                <tr>
                                                   <td><input class="itemRow" type="checkbox"></td>
                                                   <td><input type="text" name="productCode[]" id="productCode_1" class="form-control" autocomplete="off"></td>
                                                   <td><input type="text" name="productName[]" id="productName_1" class="form-control" autocomplete="off"></td>			
                                                   <td><input type="number" min="1" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off"></td>
                                                   <td><input type="number" min="1" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
                                                   <td><input type="number" min="1" name="total[]" id="total_1" class="form-control total" autocomplete="off"></td>
                                                </tr>						
                                             </table>
                                          </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                          <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                             <span style="border:none" class="badge badge-danger delete" id="removeRows">- Delete</span>
                                             <span style="border:none" class="badge badge-success" id="addRows">+ Add More</span>
                                          </div>
                                       </div>
                                       <div class="row">	
                                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:7px">
                                             <h3>Notes: </h3>
                                             <div class="form-group">
                                                <textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="Your Notes"></textarea>
                                             </div>
                                             <br>
                                          </div>
                                          
                                          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                             <label>Date of due: </label>
                                             <div class="form-group">
                                                <input type="date" class="form-control txt"  required name="duesdate" id="duesdate" placeholder="Date of due">
                                             </div>
                                             <br>
                                          </div>
                                          
                                          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label>Subtotal: </label>
                                                <div class="form-group">
                                                   <input step=".01" value="" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal ($)">
                                                   
                                          </div>
                                          </div>
                                             <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">	
                                                <div class="form-group">
                                                   <label>Tax Rate: &nbsp;</label>
                                                   <div class="input-group">
                                                      <input value="4" type="number" class="form-control" name="taxRate" id="taxRate" placeholder="Tax Rate (%)">
                                                   </div>
                                                </div></div>
                                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                   <label>Tax Amount: &nbsp;</label>
                                                   <div class="input-group">
                                                      <input value="" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount ($)">
                                                   </div>
                                                </div>	</div>						
                                                
                                                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                      <label>Amount Paid:&nbsp; </label>
                                                      <div class="input-group">
                                                      <input step=".01" value="" type="number" class="form-control" name="amountPaid" id="amountPaid" placeholder="Amount Paid ($)">
                                                      
                                                      </div></div>

                                                
                                                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                      <label>Amount Due:</label>
                                                      <div class="form-group">
                                                      <input step=".01" value="" type="number" class="form-control" name="amountDue" id="amountDue" placeholder="Amount Due ($)">
                                                      </div>
                                                      </div>
                                             
                                             <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                   <label>Total: &nbsp;</label>
                                                   <div class="input-group">
                                                      <input step=".01" value="" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total ($)">
                                                   </div>
                                                </div></div>
                                                
                                          
                                          <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                          <div class="form-group" style="padding-top:33px">
                                             <input style="width:100%" type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
                                             <input style="background:blue;border:none;color:white;border-radius:5px;padding:10px;" data-loading-text="Saving Invoice..." type="submit" name="invoice_btn" value="Save Invoice">						
                                          </div>
                                          </div>
                                       </div>
                                       <div class="clearfix"></div>		      	
                                    </div>
                                 </form>			
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Tab Apps -->
                     <!-- Tab Location -->
                     <div class="tab-pane fade show" id="location" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card card-profile shadow">
                           <div class="card-header">
                              <input type="text" id="myInput" onkeyup="myFunction_invoice()" placeholder="Search for names.." title="Type in a name" class="form-control">
                           </div>
                           <div class="card-body" style="overflow-x:auto;">
                             <table id="myTable" class="table table-bordered table-striped">
                               <thead style="background:#337ab7;color:white;"> 
                                <tr>
                                <th>Invoice No.</th>
                                <th>Create Date</th>
                                <th>Customer Name</th>
                                <th>Invoice Due</th>
                                <th>Print</th>
                                <th>PaymentLink</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                </tr>
                                 </thead>
                                <?php
                                    $invoiceList = $invoice->getInvoiceList();
                                    foreach($invoiceList as $invoiceDetails){
                                    $invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceDetails["order_date"]));
                                    $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
                                ?>
                                <tr>
                                    <td><?php echo $invoiceDetails["order_id"];?></td>
                                    <td><?php echo $invoiceDate;?></td>
                                    <td><?php echo $invoiceDetails["order_receiver_name"];?></td>
                                    <td><?php  $duespaiid = $invoiceDetails["order_total_amount_due"]; echo $duespaiid<1?'<span style="color:green"><b>Paid</b></span>':$duespaiid;?></td>
                                    <td><a target="blank" href="print_invoice.php?invoice_id=<?php echo $invoiceDetails["order_id"] ?>" title="Print Invoice"><i class="fa fa-print"></i></a></td>
                                    
                                    <td>
                                        <span class="signature-links" onclick="GeeksForGeeks(this)"><?php echo "https://se7entech.net/invoicepay/index.php?id=". base64_encode('SVTCHMKTNG,' . $invoiceDetails["order_id"]);?></span>
                                    </td>
                            
                                    <td><a href="edit_invoice.php?update_id=<?php echo $invoiceDetails["order_id"]?>"  title="Edit Invoice"><i class="fa fa-pencil"></i></a></td>
                                    <td><a href="invoice-delete?id=<?= $invoiceDetails['order_id'];?>"  title="Delete Invoice"><i class="fa fa-trash"></i></a></td>
                                 </tr>
                                <?php  }?>
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
      </div>
      </div>
      <?php include './layout/footer_scripts.php';?>
      <script src="<?php echo $base_url;?>/js/invoice.js"></script>
      <script src="editor/summernote-bs4.min.js"></script>
      <!-- place new scripts here -->
      <script>
        function selectElementText(el, win) {
            win = win || window;
            var doc = win.document, sel, range;
            if (win.getSelection && doc.createRange) {
               sel = win.getSelection();
               range = doc.createRange();
               range.selectNodeContents(el);
               sel.removeAllRanges();
               sel.addRange(range);
               return sel;

            }
            return false;
         }
          function GeeksForGeeks(el) {
            /* Get the text field */
            let sel = selectElementText(el)
            if(sel){
               /* Select the text field */         
               /* Copy the text inside the text field */
               document.execCommand("copy");
               
               /* Alert the copied text */
               alert("Copied the text: " + sel.toString());

            }
         }
      </script>
      <script>
         window.addEventListener('DOMContentLoaded', () => {
            $('#notes').summernote();
            $('#customer_id').on('select2:select', function (e) {
                let address = e.params.data.element.dataset.address;
                let value = e.params.data.id;
                
                $('#companyName').val(e.params.data.id);
                $('#address').val(address);
            });
            // document.querySelector('#customer_id').addEventListener('change', (e) => {
            //     $('#companyName').value = e.target.value
            // }, false)
         }, false)
      </script>
   </body>
</html>