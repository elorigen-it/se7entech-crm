<?php
require_once __DIR__ . '/../../../envloader.php';
require __DIR__ . '/../../../config/config.php';
require __DIR__ . '/../../../config/connection.php';

$invoice = $this->data['current'];
$items = $this->data['items'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . '/../../../layout/head.php'; ?>
    <style>
        .required {
            color: red;
        }
    </style>
</head>

<body class="">
    <?php include __DIR__ . '/../../../sidebar.php'; ?>
    <div class="main-content">
        <?php include __DIR__ . '/../../../nav.php'; ?>
        <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Edit Invoice
                                #<?php echo $invoice['order_id']; ?></h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a
                                            href="<?php echo $base_url; ?>/modules/invoices/index.php/"><i
                                                class="ni ni-bullet-list-67"></i> Invoices</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <h3 class="mb-0">Edit Invoice</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST"
                                action="<?php echo $base_url; ?>/modules/invoices/index.php/<?php echo $invoice['order_id']; ?>"
                                id="invoice-form">
                                <input type="hidden" name="id" value="<?php echo $invoice['order_id']; ?>">
                                <input type="hidden" name="userId" value="<?php echo $invoice['user_id']; ?>">

                                <h6 class="heading-small text-muted mb-4">Receiver Info</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="companyName">Company Name</label>
                                                <input type="text" id="companyName" name="companyName"
                                                    class="form-control form-control-alternative"
                                                    value="<?php echo $invoice['order_receiver_name']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="invoiceConcept">Invoice
                                                    Concept</label>
                                                <input type="text" id="invoiceConcept" name="invoiceConcept"
                                                    class="form-control form-control-alternative"
                                                    value="<?php echo $invoice['order_concept']; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-control-label" for="address">Address</label>
                                                <textarea id="address" name="address"
                                                    class="form-control form-control-alternative"
                                                    rows="3"><?php echo $invoice['order_receiver_address']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="heading-small text-muted mb-4">Items</h6>
                                <div class="pl-lg-4">
                                    <table class="table table-bordered" id="invoiceItem">
                                        <tr>
                                            <th width="2%"><input id="checkAll" class="formcontrol" type="checkbox">
                                            </th>
                                            <th width="15%">Item No</th>
                                            <th width="38%">Item Name</th>
                                            <th width="15%">Quantity</th>
                                            <th width="15%">Price</th>
                                            <th width="15%">Total</th>
                                        </tr>
                                        <?php
                                        $count = 0;
                                        foreach ($items as $item):
                                            $count++;
                                            ?>
                                            <tr>
                                                <td><input class="itemRow" type="checkbox"></td>
                                                <td><input type="text" value="<?php echo $item['item_code']; ?>"
                                                        name="productCode[]" id="productCode_<?php echo $count; ?>"
                                                        class="form-control" autocomplete="off"></td>
                                                <td><input type="text" value="<?php echo $item['item_name']; ?>"
                                                        name="productName[]" id="productName_<?php echo $count; ?>"
                                                        class="form-control" autocomplete="off"></td>
                                                <td><input type="number" value="<?php echo $item['order_item_quantity']; ?>"
                                                        name="quantity[]" id="quantity_<?php echo $count; ?>"
                                                        class="form-control quantity" autocomplete="off"></td>
                                                <td><input type="number" value="<?php echo $item['order_item_price']; ?>"
                                                        name="price[]" id="price_<?php echo $count; ?>"
                                                        class="form-control price" autocomplete="off"></td>
                                                <td><input type="number"
                                                        value="<?php echo $item['order_item_final_amount']; ?>"
                                                        name="total[]" id="total_<?php echo $count; ?>"
                                                        class="form-control total" autocomplete="off" readonly></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <button class="btn btn-danger btn-sm" id="removeRows" type="button">-
                                                Delete</button>
                                            <button class="btn btn-success btn-sm" id="addRows" type="button">+ Add
                                                More</button>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4" />

                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="form-control-label">Notes</label>
                                                <textarea name="notes" id="notes"
                                                    class="form-control form-control-alternative"
                                                    rows="5"><?php echo $invoice['note']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- Same calculations section -->
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Subtotal</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" name="subTotal"
                                                        id="subTotal"
                                                        value="<?php echo $invoice['order_total_before_tax']; ?>"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Tax Rate %</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" name="taxRate"
                                                        id="taxRate" value="<?php echo $invoice['order_tax_per']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Tax Amount</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" name="taxAmount"
                                                        id="taxAmount"
                                                        value="<?php echo $invoice['order_total_tax']; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Total</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" name="totalAftertax"
                                                        id="totalAftertax"
                                                        value="<?php echo $invoice['order_total_after_tax']; ?>"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Amount Paid</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" name="amountPaid"
                                                        id="amountPaid"
                                                        value="<?php echo $invoice['order_amount_paid']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Amount Due</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" name="amountDue"
                                                        id="amountDue"
                                                        value="<?php echo $invoice['order_total_amount_due']; ?>"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Due Date</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" name="duesdate"
                                                        id="duesdate" value="<?php echo $invoice['duesdate']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary my-4">Update Invoice</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between"></div>
            </footer>
        </div>
    </div>
    <?php include __DIR__ . '/../../../layout/footer_scripts.php'; ?>
    <script>
        $(document).ready(function () {
            // Simplified JS Logic mirroring index.php but accounting for pre-filled rows
            $(document).on('click', '#checkAll', function () {
                $(".itemRow").prop("checked", this.checked);
            });
            $(document).on('click', '.itemRow', function () {
                if ($('.itemRow:checked').length == $('.itemRow').length) {
                    $('#checkAll').prop('checked', true);
                } else {
                    $('#checkAll').prop('checked', false);
                }
            });
            var count = <?php echo $count; ?>; // Initialize count with PHP
            $(document).on('click', '#addRows', function () {
                count++;
                var htmlRows = '';
                htmlRows += '<tr>';
                htmlRows += '<td><input class="itemRow" type="checkbox"></td>';
                htmlRows += '<td><input type="text" name="productCode[]" id="productCode_' + count + '" class="form-control" autocomplete="off"></td>';
                htmlRows += '<td><input type="text" name="productName[]" id="productName_' + count + '" class="form-control" autocomplete="off"></td>';
                htmlRows += '<td><input type="number" name="quantity[]" id="quantity_' + count + '" class="form-control quantity" autocomplete="off"></td>';
                htmlRows += '<td><input type="number" name="price[]" id="price_' + count + '" class="form-control price" autocomplete="off"></td>';
                htmlRows += '<td><input type="number" name="total[]" id="total_' + count + '" class="form-control total" autocomplete="off" readonly></td>';
                htmlRows += '</tr>';
                $('#invoiceItem').append(htmlRows);
            });
            $(document).on('click', '#removeRows', function () {
                $(".itemRow:checked").each(function () {
                    $(this).closest('tr').remove();
                });
                $('#checkAll').prop('checked', false);
                calculateTotal();
            });
            $(document).on('blur', "[id^=quantity_]", function () {
                calculateTotal();
            });
            $(document).on('blur', "[id^=price_]", function () {
                calculateTotal();
            });
            $(document).on('blur', "#taxRate", function () {
                calculateTotal();
            });
            $(document).on('blur', "#amountPaid", function () {
                var amountPaid = $(this).val();
                var totalAftertax = $('#totalAftertax').val();
                if (amountPaid && totalAftertax) {
                    totalAftertax = totalAftertax - amountPaid;
                    $('#amountDue').val(totalAftertax);
                } else {
                    $('#amountDue').val(totalAftertax);
                }
            });
            function calculateTotal() {
                var totalAmount = 0;
                $("[id^='price_']").each(function () {
                    var id = $(this).attr('id');
                    id = id.replace("price_", '');
                    var price = $('#price_' + id).val();
                    var quantity = $('#quantity_' + id).val();
                    if (!quantity) {
                        quantity = 1;
                    }
                    var total = price * quantity;
                    $('#total_' + id).val(parseFloat(total));
                    totalAmount += total;
                });
                $('#subTotal').val(parseFloat(totalAmount));
                var taxRate = $("#taxRate").val();
                var subTotal = $('#subTotal').val();
                if (taxRate) {
                    var taxAmount = subTotal * taxRate / 100;
                    $('#taxAmount').val(taxAmount);
                    subTotal = parseFloat(subTotal) + parseFloat(taxAmount);
                }
                $('#totalAftertax').val(subTotal);
                var amountPaid = $('#amountPaid').val();
                var totalAftertax = $('#totalAftertax').val();
                if (amountPaid && totalAftertax) {
                    totalAftertax = totalAftertax - amountPaid;
                    $('#amountDue').val(totalAftertax);
                } else {
                    $('#amountDue').val(subTotal);
                }
            }
        });
    </script>
</body>

</html>