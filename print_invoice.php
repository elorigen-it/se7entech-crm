<?php
session_start();
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	$inv_id =  $_GET['invoice_id'];
	$invoiceValues = $invoice->getInvoice($_GET['invoice_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);		
}
?>
 <title>Se7entech Invoice</title>
      <!-- Favicon -->
      <link rel="apple-touch-icon" sizes="180x180" href="images/fav.png">
      <link rel="icon" type="image/png" sizes="32x32" href="images/fav.png">
      <link rel="icon" type="image/png" sizes="16x16" href="images/fav.png">
<style>
    .grid-container {
        display: grid;
        grid-template-columns: auto auto;
        padding-top: 25px;
    }

    .grid-container2 {
        display: grid;
        grid-template-columns: auto auto;
        padding-top: 25px;
    }

    .grid-container8 {
        display: grid;
        grid-template-columns: auto auto;
        padding-top: 25px;
        /*padding-left: 610px;*/
    }

    .grid-container3 {
        display: grid;
        grid-template-columns: auto auto;
        padding-top: 25px;
        background-image: url('bg.png');
        background-repeat: no-repeat;
        background-size: 300px 100px;
        background-position: center center;

    }

    .grid-container4 {
        display: grid;
        grid-template-columns: auto auto auto auto;
        padding-top: 25px;
    }

    .grid-container5 {
        display: grid;
        grid-template-columns: auto auto auto auto auto;
        padding-top: 25px;
    }

    .grid-container7 {
        display: grid;
        grid-template-columns: auto auto auto auto auto;
    }

    .grid-container6 {
        display: grid;
        grid-template-columns: auto;
    }

    .img {
        height: 50px;
        width: 200px;
    }

    .container {
        padding-top: 50px;
        padding-right:50px;
        /* border-style:solid;
        border-width:1px;
        border-radius:5px; */
        padding-bottom: 20px;
     }

    body {
        -webkit-print-color-adjust: exact;
        width: 874px;
        height: 1240px;
    }

    table {
        padding-left: 118px;
        width: 100%
    }

    th {
        background: #3498db;
        color: white;
        font-weight: bold;

    }

    td,
    th {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: left;
        font-size: 15px;
    }

    tr {
        height: 20px
    }
     body, .container {
  height: auto;
}
}
    @media print
{    
    .printtt, .printtt *
    {
        display: none !important;
    }
}
.table.table-bordered{
    padding-left:0 !important;
}
 
</style>

<body onload="window.print()">
    
    <div class="container">
        <div class="rows">
            <center>
                <div class="col-sm-12 grid-container">

                    <div class="grid-item">
                        <h2>INVOICE</h2>
                    </div>
                    <div class="grid-item"><img class="img" src="https://se7entech.net/images/logo.png"></div>
                </div>

                <div class="col-sm-12 grid-container2">

                    <div class="grid-item" style="line-height:5px;text-align:left;padding-left:120px">
                        <p>Invoice Number</p>
                        <p>Date of issue</p>
                        <p>Date of due</p>
                    </div>
                    <div class="grid-item" style="line-height:5px;text-align:left;padding-right:455px">
                        <p>00<?php echo $inv_id;?></p>
                        <p><?php   $datatat = $invoiceValues['order_date']; echo date('F d, Y', strtotime($datatat));?></p>
                        <p><?php   $datatatt = $invoiceValues['duesdate']; echo date('F d, Y', strtotime($datatatt));?></p>
                    </div>
                   </div>

                <div class="col-sm-12 grid-container3">

                    <div class="grid-item" style="line-height:5px;text-align:left;padding-left:120px">
                        <p><b>SE7ENTECH</b></p>
                        <p>460 Irving Park RD,</p>
                        <p>STE C123 Bensenville,</p>
                        <p>Illinois 60106 United States</p>
                        <p>+1 773-666-2021</p>
                        <p>info@se7entech.net</p>
                    </div>
                    
                    <div class="grid-item" style="line-height:5px;text-align:left;padding-right:100px">
                        <p>Bill to</p>
                        <p><?php echo $invoiceValues['order_receiver_name'];?></p>
                        <p style="line-height:20px"><?php echo $invoiceValues['order_receiver_address'];?></p>
                    </div>
                   </div>

                <div class="col-sm-12 grid-container4">

                    <div class="grid-item" style="line-height:5px;text-align:left;padding-left:120px; grid-column:1/4">
                        <p><b>$<?php echo $invoiceValues['order_total_amount_due'];?> due <?php   $datatat = $invoiceValues['duesdate']; echo date('F d, Y', strtotime($datatat));?></b></p>
                        <p style="<?php echo $invoiceValues['order_total_amount_due']<1?'display:none':''?>"><a href="https://crm.se7entech.net/invoicepay/index?id=<?php echo $inv_id;?>">Pay Online</a></p>
                        <div style="text-align:left;line-height:2">
                            <p><?php echo $invoiceValues['note'];?></p>
                                <?php if($invoiceValues['order_tax_per'] > 0):?>
                                    <p>
                                        This amount includes the <?php echo $invoiceValues['order_tax_per'];?>% additional charge for the use of online payment.
                                        If you choose to avoid this additional charge, you can make payment via Zelle to 
                                        (se7entech@icloud.com), Cash or company check to pay the amount of $<?php echo ($invoiceValues['order_total_before_tax'] - $invoiceValues['order_amount_paid']);?> 
                                        made out to Se7entech.
                                        <br>
                                        The se7entech team is at your service and thank you very much for your preference.
                                    </p>
                                <?php endif;?>
                            
                        </div>

                    </div>
                    <div class="grid-item" style="line-height:5px;text-align:left;padding-right:100px">

                    </div>
                    <div class="grid-item" style="line-height:5px;text-align:left;padding-right:100px">

                    </div>
                    <div class="grid-item" style="line-height:5px;text-align:left;padding-right:100px">

                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Item Code</th>
                            <th>Item Name</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 0;   
                    foreach($invoiceItems as $invoiceItem){
                    $count++;
                     ?>
                        <tr>
                            <td><?php echo $count?></td>
                            <td><?php  echo $invoiceItem["item_code"];?></td>
                            <td><?php  echo $invoiceItem["item_name"];?></td>
                            <td><?php  echo $invoiceItem["order_item_quantity"];?></td>
                            <td>$<?php echo $invoiceItem["order_item_price"];?></td>
                            <td>$<?php echo $invoiceItem["order_item_final_amount"];?></td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
                <div class="container" style="display: flex; justify-content: space-between;padding-left: 120px;align-items: center;padding-right: 0; padding-top:0;">
                    <div>
                        <i>Signature.........</i>
                    </div>
                    <div class="col-sm-12 grid-container8">
                        <div class="grid-item" style="line-height:5px;text-align:left;padding-left:1px">
                            <p>Subtotal: </p>
                            <p>Total excluding tax: </p>
                            <p>C.C FEE: </p>
                            <P>Total: </P>
                            <p>Amount Paid:</p>
                            <p><b>Amout due: </b></p>
                        </div>
                        <div class="grid-item" style="line-height:5px;text-align:left;padding-left:10px">
                            <p>$<?php echo $invoiceValues['order_total_before_tax'];?></p>
                            <p>$<?php echo $invoiceValues['order_total_tax'];?></p>
                            <p><?php echo $invoiceValues['order_tax_per'];?>%</p>
                            <p>$<?php echo $invoiceValues['order_total_after_tax'];?></p>
                            <p>$<?php echo $invoiceValues['order_amount_paid'];?></p>
                            <p>$<?php echo $invoiceValues['order_total_amount_due'];?></p>
                        </div>
                    </div>
                </div>
                
             <!--<img src="sign.png" style="height:140px;width:146px;padding-right:255px">-->
             
            </center>
        </div>
    </div>
</body>
<?php
require_once("dompdf/dompdf_config.inc.php");
spl_autoload_register('DOMPDF_autoload');
$html = $smarty->fetch('index.tpl');
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper('a4', 'portrait');
$dompdf->render();
$dompdf->stream("newfile.pdf");
$invoiceFileName = 'Invoice-'.$invoiceValues['order_id'].'.pdf';
require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml(html_entity_decode($output));
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));
?>
