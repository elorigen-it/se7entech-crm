<?php
// Views are included by the Controller, so $this refers to the Controller instance.
// Paths are relative to __DIR__ (src/Modules/Invoices/) which is 3 levels deep from root.

require_once __DIR__ . '/../../../envloader.php';
require __DIR__ . '/../../../config/config.php'; // Use require to ensure variables are in scope
require __DIR__ . '/../../../config/connection.php'; // Use require to ensure $con is set in this scope
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . '/../../../layout/head.php'; ?>
    <style>
        .required {
            color: red;
        }

        .currency {
            input-group-addon;
        }
    </style>
</head>

<body class="">
    <?php include __DIR__ . '/../../../sidebar.php'; ?>
    <div class="main-content">
        <?php include __DIR__ . '/../../../nav.php'; ?>
        <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
            <div class="container-fluid">
                <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                                href="#list_invoices" role="tab" aria-controls="tabs-icons-text-1"
                                aria-selected="true"><i class="ni ni-bullet-list-67 mr-2"></i>Invoices List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                                href="#add_invoice" role="tab" aria-controls="tabs-icons-text-2"
                                aria-selected="false"><i class="ni ni-fat-add mr-2"></i>New Invoice</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-12">
                    <br />
                    <div class="tab-content" id="myTabContent">
                        <!-- LIST TAB -->
                        <div class="tab-pane fade show active" id="list_invoices" role="tabpanel"
                            aria-labelledby="tabs-icons-text-1-tab">
                            <div class="card shadow">
                                <div class="card-header border-0">
                                    <div class="row align-items-center">
                                        <div class="col text-center">
                                            <?php if (isset($this->data['session']) && count($this->data['session'])): ?>
                                                <?php foreach ($this->data['session'] as $msg)
                                                    echo $msg; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="mb-0">Invoices List</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush" id="invoices-table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Receiver</th>
                                                    <th>Concept</th>
                                                    <th>Total</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (isset($this->data['invoices']) && count($this->data['invoices'])): ?>
                                                    <?php foreach ($this->data['invoices'] as $inv): ?>
                                                        <tr>
                                                            <td><?php echo $inv['order_id']; ?></td>
                                                            <td><?php echo $inv['order_receiver_name']; ?></td>
                                                            <td style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                                                title="<?php echo $inv['order_concept']; ?>">
                                                                <?php echo $inv['order_concept']; ?></td>
                                                            <td>$<?php echo $inv['order_total_after_tax']; ?></td>
                                                            <td><?php echo $inv['order_date']; ?></td>
                                                            <td>
                                                                <a href="<?php echo $base_url; ?>/modules/invoices/index.php/<?php echo $inv['order_id']; ?>"
                                                                    class="btn btn-primary btn-sm">Edit</a>
                                                                <button class="btn btn-sm btn-danger"
                                                                    onclick="deleteInvoice(<?php echo $inv['order_id']; ?>, this)">Delete</button>
                                                                <a href="<?php echo $base_url; ?>/print_invoice.php?invoice_id=<?php echo $inv['order_id']; ?>"
                                                                    target="_blank" class="btn btn-info btn-sm">Print</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ADD TAB -->
                        <div class="tab-pane fade" id="add_invoice" role="tabpanel"
                            aria-labelledby="tabs-icons-text-2-tab">
                            <div class="card bg-secondary shadow">
                                <div class="card-header bg-white border-0">
                                    <h3 class="mb-0">Create New Invoice</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?php echo $base_url; ?>/modules/invoices/index.php/"
                                        id="invoice-form">
                                        <!-- Hidden fields -->
                                        <input type="hidden" name="userId"
                                            value="<?php echo $_SESSION['userid'] ?? 1; ?>">

                                        <h6 class="heading-small text-muted mb-4">Receiver Info</h6>
                                        <div class="pl-lg-4">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-control-label" for="customer_id">Select
                                                        Customer</label>
                                                    <select name="customer_id" id="customer_id"
                                                        class="form-control select2">
                                                        <option value="">SELECT A CUSTOMER</option>
                                                        <?php if (isset($this->data['customers']) && count($this->data['customers'])): ?>
                                                            <?php foreach ($this->data['customers'] as $customer): ?>
                                                                <option data-address="<?php echo $customer['address']; ?>"
                                                                    value="<?php echo $customer['business_name'] . ' - ' . $customer['name']; ?>">
                                                                    <?php echo $customer['type'] . ' - ' . $customer['business_name'] . ' - ' . $customer['name']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="companyName">Company
                                                            Name</label>
                                                        <input type="text" id="companyName" name="companyName"
                                                            class="form-control form-control-alternative" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="invoiceConcept">Invoice
                                                            Concept</label>
                                                        <input type="text" id="invoiceConcept" name="invoiceConcept"
                                                            class="form-control form-control-alternative" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="address">Address</label>
                                                        <textarea id="address" name="address"
                                                            class="form-control form-control-alternative"
                                                            rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <h6 class="heading-small text-muted mb-4">Items</h6>
                                        <div class="pl-lg-4">
                                            <table class="table table-bordered" id="invoiceItem">
                                                <tr>
                                                    <th width="2%"><input id="checkAll" class="formcontrol"
                                                            type="checkbox"></th>
                                                    <th width="15%">Item No</th>
                                                    <th width="38%">Item Name</th>
                                                    <th width="15%">Quantity</th>
                                                    <th width="15%">Price</th>
                                                    <th width="15%">Total</th>
                                                </tr>
                                                <tr>
                                                    <td><input class="itemRow" type="checkbox"></td>
                                                    <td><input type="text" name="productCode[]" id="productCode_1"
                                                            class="form-control" autocomplete="off"></td>
                                                    <td><input type="text" name="productName[]" id="productName_1"
                                                            class="form-control" autocomplete="off"></td>
                                                    <td><input type="number" name="quantity[]" id="quantity_1"
                                                            class="form-control quantity" autocomplete="off"></td>
                                                    <td><input type="number" name="price[]" id="price_1"
                                                            class="form-control price" autocomplete="off"></td>
                                                    <td><input type="number" name="total[]" id="total_1"
                                                            class="form-control total" autocomplete="off" readonly></td>
                                                </tr>
                                            </table>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <button class="btn btn-danger btn-sm" id="removeRows"
                                                        type="button">- Delete</button>
                                                    <button class="btn btn-success btn-sm" id="addRows" type="button">+
                                                        Add More</button>
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
                                                            rows="5"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Subtotal</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control" name="subTotal"
                                                                id="subTotal" placeholder="Subtotal" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Tax Rate %</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control" name="taxRate"
                                                                id="taxRate" placeholder="Tax Rate" value="4">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Tax Amount</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control" name="taxAmount"
                                                                id="taxAmount" placeholder="Tax Amount" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Total</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control"
                                                                name="totalAftertax" id="totalAftertax"
                                                                placeholder="Total" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Amount Paid</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control" name="amountPaid"
                                                                id="amountPaid" placeholder="Amount Paid">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Amount Due</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control" name="amountDue"
                                                                id="amountDue" placeholder="Amount Due" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Due Date</label>
                                                        <div class="col-sm-8">
                                                            <input type="date" class="form-control" name="duesdate"
                                                                id="duesdate" value="<?php echo date('Y-m-d'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-success my-4">Create
                                                    Invoice</button>
                                            </div>
                                        </div>
                                    </form>
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
    <?php include __DIR__ . '/../../../layout/footer_scripts.php'; ?>
    <script>
        $(document).ready(function () {
            $('#invoices-table').DataTable({
                "order": [[0, "desc"]]
            });

            // Initialize Select2
            $('.select2').select2({
                placeholder: 'Select a customer',
                allowClear: true
            });

            // Handle Customer Selection
            $('#customer_id').on('select2:select', function (e) {
                let address = e.params.data.element.dataset.address;
                // The value is set to "Business Name - User Name" in the option value
                let value = e.params.data.id;

                $('#companyName').val(value);
                if (address) {
                    $('#address').val(address);
                }
            });

            // JS Logic for Invoice Items (simplified from invoice.js)
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
            var count = $(".itemRow").length;
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

        function deleteInvoice(id, btn) {
            bootbox.confirm('Are you sure you want to delete this invoice?', function (confirmed) {
                if (confirmed) {
                    let data = new FormData;
                    data.set('id', id);
                    let endpoint = "<?php echo $base_url; ?>/modules/invoices/index.php/delete/"
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', endpoint, true)
                    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                    xhr.addEventListener('load', (e) => {
                        try {
                            let res = JSON.parse(e.target.response);
                            if (res.success) {
                                $(btn).closest('tr').remove();
                                $.notify('Invoice deleted!', 'success')
                            } else {
                                $.notify('Error deleting invoice', 'error')
                            }
                        } catch (err) {
                            console.error(err);
                            $.notify('Error processing response', 'error')
                        }
                    })
                    xhr.send(data)
                }
            });
        }
    </script>
</body>

</html>