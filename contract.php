<?php
session_start(); //session start always on top.
require_once './config/config.php';
require_once './config/connection.php';
require_once 'access.php'; //inside access.php you already have $con variable without importing it there.

if(isset($_SESSION['email']))
{
	$logid=$_SESSION['email'];
	$res=mysqli_query($con,"select * from invoice_user where email='$logid'");
	$row=mysqli_fetch_assoc($res);
	$access = $row['status'];
	$name = $row['first_name'];
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include './layout/head.php';?>
      <title>Se7entech - Contract</title>
      <style>
         .signature-links:hover{
            cursor:pointer;
         }
         .select2-container{
            z-index: 999999;
         }
         .notifyjs-corner{
            z-index:9999999;
         }
      </style>
   </head>
   <body class="">
      
      <?php include ('./sidebar.php'); ?>
      <div class="main-content">
         <?php include ('nav.php'); ?>
         <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
            <div class="container-fluid">
               <div class="nav-wrapper">
                  <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="res_menagment" role="tablist">
                     <li class="nav-item">
                        <a href="new_contract" style="color:white"   aria-selected="true"><i class="fa fa-book"></i> New Contract</a>
                     </li>
                     
                     <!--<li class="nav-item">-->
                     <!--   <a class="nav-link mb-sm-3 mb-md-0 " id="tabs-menagment-main" data-toggle="tab" href="#location" role="tab" aria-controls="tabs-menagment" aria-selected="true"><i class="fa fa-users mr-2"></i>Client List</a>-->
                     <!--</li>-->
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
                      
                     <!-- Tab Apps -->
                     <!-- Tab Location -->
                     <div class="tab-pane fade show active" id="location" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card card-profile shadow">
                           <div class="card-header">
                              <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" class="form-control">
                           </div>
                           <div class="card-body" style="overflow-x:auto;">
                              <table id="myTable" class="table table-bordered table-striped">
                                 <thead style="background:#337ab7;color:white;"> 
                                    <tr>
                                       <th>Sno.</th>
                                       <th>Name</th>
                                       <th>View</th>
                                       <th>Sign Link</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php
                                 if($access=='0')
                                 {
                                       $wh = "where trashd<>'1'";
                                 }
                                 
                                 else
                                 {
                                       $datas="where logid='$logid' and trashd <>'1'";
                                 }
                                 
                                 $sql="select * from contactnew $datas  $wh    ORDER BY id DESC";
                                 $result11=mysqli_query($con,$sql);
                                 
                                 if(mysqli_num_rows($result11))
                                 {
                                 
                                 $i=1;
                                 while($rows11=mysqli_fetch_assoc($result11))
                                 {
                                    $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
                                 ?>
                                 <tr>
                                 <td><?php echo $i;?></td>
                                 <td><?php echo $rows11['b'];?></td>
                                 <td>
                                 <a    target="_blank" href="print.php?rand=<?php echo $rows11['rand'];?>"> <i class="fa fa-print"></i> Print Document</a>
                                 <!-- Button trigger modal -->
                                 <a class="send-notifications" data-contractid="<?php echo $rows11['id'];?>"  href="#" data-toggle="modal" data-target="#queryMailModal">
                                    <i class="fa fa-envelope"></i>
                                    Send Notifications
                                 </a>
                                 <!-- <a    class="send-notifications" data-contractid="<?php echo $rows11['id'];?>" href="#"> <i class="fa fa-envelope"></i> Send Notifications</a> -->
                                 <!-- Button trigger modal -->
                                 <a href="#" data-contractid="<?php echo $rows11['id'];?>" class = "associateinvoices" data-toggle = "modal" data-target = "#exampleModal"><i class="fa fa-pencil"></i> Associate Invoices</a>
                                 <!--<a  class="btn btn-warning"  target="blank" href="print_doc.php?id=<?php echo $rows11['id'];?>"> <i class="fa fa-eye"></i> View Document</a>-->
                                 <!--<a  class="btn btn-success" target="blank"  href="https://se7entech.net/contract/test.php?id=<?php echo $rows11['id'];?>"> Copy link Sign For Signature company representative</a>-->
                                 <!--<a  class="btn btn-success" target="blank"  href="https://se7entech.net/contract/testt.php?id=<?php echo $rows11['id'];?>"> Copy link Sign For Signature Client representative</a>-->
                                 <!--<a  class="btn btn-primary"  href="Update-Company-Sign.php?id=<?php echo $rows11['id'];?>"><i class="fa fa-pencil"></i> Update Company Sign</a>-->
                                 <!--<a  class="btn btn-primary"  href="Update-Sign.php?id=<?php echo $rows11['id'];?>"><i class="fa fa-pencil"></i> Update Client Sign</a>-->
                                 <!--<span class="btn btn-dark" onclick="GeeksForGeeks()" title="Click To Copy Url"><l class="fa fa-share"></l> Company Signature</span>-->
                                 <!--<span>https://se7entech.net/contractnew/sign1?id=<?php echo $rows11['rand'];?></span>-->
                                 
                                 <!--<span class="btn btn-dark" onclick="GeeksForGeekss()" title="Click To Copy Url"><l class="fa fa-share"></l> Client Signature</span>-->
                                 
                                 
                                 <a href="update.php?rand=<?php echo $rows11['rand'];?>"><i class="fa fa-pencil"></i> Update Contract</a>
                                 </td> 
                                 <td>
                                       <details>
                                          <summary>
                                          Copy Link
                                       </summary>
                                       Client Signature: <span class="signature-links" onclick="GeeksForGeeks(this)">https://se7entech.net/contractnew/sign2?id=<?php echo $rows11['rand'];?></span>
                                       <br>
                                       Company Signature: <span class="signature-links" onclick="GeeksForGeeks(this)">https://se7entech.net/contractnew/sign1?id=<?php echo $rows11['rand'];?></span>
                                       </details>
                                       
                                 </td>
                                 
                                 <td>
                                 
                                 <a  href="<?php echo $access=='0'?'admindelete':'otherdelete'?>?t=contactnew&id=<?php echo $rows11['id'];?>&u=<?php echo $actual_link;?>" title="You want to delete permanently?"> <i class="fa fa-trash"></i> <?php echo $rows11['trashd']==2?'Deleted by agent':'Delete permanently'?></a>
                                 </td> 
                                 </tr>
                                 <?php
                                 $i++;
                                 
                                 }
                                 ?>
                                 
                                 <?php
                                 
                                 }
                                 else
                                 {
                                 ?>
                                 <div style=" padding:15px; margin-top:10px;">
                                 
                                 <h4 style="text-align:center;color:red;"><b>Sorry ! No result found..!</b></h4>
                                 </div>
                                 <?php
                                 }
                                 ?>
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
      </div>
      </div>
        
         <!-- Modal -->
         <div class="modal fade" id="queryMailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                     <input type="hidden" id="actualContractIdForNotification" value="">
                     <h4 class="modal-title" id="myModalLabel">Send email notification to:</h4>
                     <input type="text" id="InputEmailNotification" name="InputEmailNotification">
                  </div>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary send-notification-save">Send Now</button>
                  </div>
               </div>
            </div>
         </div>
         
         <!-- Modal -->
         <div class = "modal fade" id = "exampleModal" tabindex = "-1" 
            role = "dialog" aria-labelledby =" exampleModalLabel" aria-hidden = "true">
            <div class = "modal-dialog" role = "document">
               <div class = "modal-content">
                  <div class = "modal-header">
                     <h5 class = "modal-title" id = "exampleModalLabel">Attach invoice to contract</h5>
                     <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                        <span aria-hidden = "true">×</span>
                     </button>
                  </div>
                  
                  <div class = "modal-body">
                     <input type="hidden" id="actualContractId" value="">
                     <select style="width:100%;" id="invoicesids" class="invoicesids" name="invoicesids[]" multiple="multiple"></select>
                  </div>
                  
                  <div class = "modal-footer">
                     <button type = "button" class = "btn btn-danger" data-dismiss = "modal">Close</button>
                     <button id="associateInvoice" type = "button" class = "btn btn-success">Save</button>
                  </div>
                  
               </div>
            </div>
         </div>
      <?php include './layout/footer_scripts.php';?>

      <script>
         function start() {

            let invoicesIds = document.querySelector('#invoicesids');
            $.ajax({
               method:'POST',
               url: "<?php echo $base_url;?>/modules/contract/index.php/getAllInvoices/",
               success: (response) => {
                  let data = JSON.parse(response);
                  if(data.success){
                     let allInvoices = data.data;
                     if(allInvoices.length){
                        let options = '';
                        for(let i=0; i<allInvoices.length; i++){
                           options += `
                              <option value="${allInvoices[i].order_id}"> ${allInvoices[i].order_receiver_name} - ${allInvoices[i].order_total_after_tax} </option>
                           `
                        }
                        invoicesIds.innerHTML = options;
                        $('#invoicesids').select2();
                        
                     }
                  }
               }
            })

            let notificationButtons = document.querySelectorAll('.send-notifications');
            notificationButtons.forEach( el => {
               el.addEventListener('click', (e) => {
                  let contractid = e.currentTarget.dataset.contractid;
                  $('#actualContractIdForNotification').val(contractid)
               }, false)
            })

            let notificationButton = document.querySelector('.send-notification-save');
            notificationButton.addEventListener('click', (e) => {
               console.log('button')
               let contractid = $('#actualContractIdForNotification').val();
               let toemail = $('#InputEmailNotification').val();

               $.ajax({
                  method: 'POST',
                  url: "<?php echo $base_url;?>/modules/contract/index.php/notifications/",
                  data: {
                     'contractid':contractid,
                     'toemail': toemail
                  },
                  beforeSend: () => {
                     notificationButton.setAttribute('disabled', true);
                  },

                  success: (response) => {
                     let data = JSON.parse(response);
                     notificationButton.removeAttribute('disabled');
                     if(data.success){
                        $.notify('Notifications sent', 'success')
                        $('#queryMailModal').modal('hide');
                     }else{
                        $.notify('Please try again later', 'error')
                     }
                  }
               })
            }, false)

            let associateInvoices = document.querySelectorAll('.associateinvoices');
            associateInvoices.forEach((el) => {

               el.addEventListener('click', (e) => {
                  $('#invoicesids').val([]).trigger('change') 
                  let contractid = e.currentTarget.dataset.contractid;
                  $('#actualContractId').val(contractid);

                  $.ajax({
                     method: 'POST',
                     url: "<?php echo $base_url;?>/modules/contract/index.php/getAssociatedInvoices/",
                     data: {'contractid':contractid},
                     success: (response) => {
                        let res = JSON.parse(response);
                        if(res.success){
                           let relatedInvoices = res.data;
                           let selected = [];
                           if(relatedInvoices.length){
                              relatedInvoices.forEach((el) => {
                                 selected.push(el.invoice_id);
                              })
                              $('#invoicesids').val(selected).trigger('change') 
                           }
                        }else{
                           alert('please try again later')
                        }
                     }
                  })
               }, false)
            })

            let saveBtn = document.querySelector('#associateInvoice')
            saveBtn.addEventListener('click', (e) => {
               let contractid = $('#actualContractId').val();
               let invoicesids = $('#invoicesids').val().toString();
               $.ajax({
                  method: 'post',
                  url: "<?php echo $base_url;?>/modules/contract/index.php/associateInvoice/",
                  data:{
                     'contractid': contractid,
                     'invoicesids': invoicesids
                  },
                  success: (res) => {
                     res = JSON.parse(res);
                     if(res.success){
                        $.notify('Invoices attached successfully', 'success')
                     }else{
                        $.notify('Please try again later', 'error')
                     }
                     $('#exampleModal').modal('hide');
                  }
               })
            }, false)
         }
         window.addEventListener('DOMContentLoaded', start, false);
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
      
   </body>
</html>