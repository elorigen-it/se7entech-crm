<?php

namespace Se7entech\Contractnew\Modules\Invoices\Models;

class InvoiceModel
{
    private static $table = 'invoice_order';
    private static $itemTable = 'invoice_order_item';

    public static function create(array $data)
    {
        include __DIR__ . '/../../../../config/connection.php';

        $userId = $data['userId'] ?? 0;
        $concept = $data['invoiceConcept'] ?? '';
        $name = $data['companyName'] ?? '';
        $address = $data['address'] ?? '';
        $subTotal = $data['subTotal'] ?? 0;
        $taxAmount = $data['taxAmount'] ?? 0;
        $taxRate = $data['taxRate'] !== '' ? $data['taxRate'] : 4;
        $totalAfter = $data['totalAftertax'] ?? 0;
        $paid = $data['amountPaid'] ?? 0;
        $due = $data['amountDue'] ?? 0;
        $note = $data['notes'] ?? '';
        // Fix logid: default to userId if not provided, or session access logic if needed
        $logid = $data['logid'] ?? $userId;
        $dueDate = $data['duesdate'] ?? date('Y-m-d');

        $stmt = $con->prepare("INSERT INTO " . self::$table . " (user_id, order_concept, order_receiver_name, order_receiver_address, order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax, order_amount_paid, order_total_amount_due, note, logid, duesdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            error_log("Prepare failed: " . $con->error);
            return false;
        }

        $stmt->bind_param("isssddddddsss", $userId, $concept, $name, $address, $subTotal, $taxAmount, $taxRate, $totalAfter, $paid, $due, $note, $logid, $dueDate);

        if ($stmt->execute()) {
            $invoiceId = $stmt->insert_id;
            self::saveItems($invoiceId, $data);
            return $invoiceId;
        }

        error_log("Execute failed: " . $stmt->error);
        return false;
    }

    public static function update($id, array $data)
    {
        include __DIR__ . '/../../../../config/connection.php';

        $concept = $data['invoiceConcept'] ?? '';
        $name = $data['companyName'] ?? '';
        $address = $data['address'] ?? '';
        $subTotal = $data['subTotal'] ?? 0;
        $taxAmount = $data['taxAmount'] ?? 0;
        $taxRate = $data['taxRate'] !== '' ? $data['taxRate'] : 4;
        $totalAfter = $data['totalAftertax'] ?? 0;
        $paid = $data['amountPaid'] ?? 0;
        $due = $data['amountDue'] ?? 0;
        $note = $data['notes'] ?? '';
        $dueDate = $data['duesdate'] ?? date('Y-m-d');

        $stmt = $con->prepare("UPDATE " . self::$table . " SET order_concept=?, order_receiver_name=?, order_receiver_address=?, order_total_before_tax=?, order_total_tax=?, order_tax_per=?, order_total_after_tax=?, order_amount_paid=?, order_total_amount_due=?, note=?, duesdate=? WHERE order_id=?");

        $stmt->bind_param("sssddddddssi", $concept, $name, $address, $subTotal, $taxAmount, $taxRate, $totalAfter, $paid, $due, $note, $dueDate, $id);

        if ($stmt->execute()) {
            self::deleteItems($id);
            self::saveItems($id, $data);
            return true;
        }
        return false;
    }

    public static function delete($id)
    {
        include __DIR__ . '/../../../../config/connection.php';

        self::deleteItems($id);

        $stmt = $con->prepare("DELETE FROM " . self::$table . " WHERE order_id = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    private static function saveItems($invoiceId, $data)
    {
        include __DIR__ . '/../../../../config/connection.php';

        if (!isset($data['productCode']) || !is_array($data['productCode'])) {
            return;
        }

        $stmt = $con->prepare("INSERT INTO " . self::$itemTable . " (order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount) VALUES (?, ?, ?, ?, ?, ?)");

        for ($i = 0; $i < count($data['productCode']); $i++) {
            $code = $data['productCode'][$i];
            $name = $data['productName'][$i];
            $qty = $data['quantity'][$i];
            $price = $data['price'][$i];
            $total = $data['total'][$i];

            $stmt->bind_param("issddd", $invoiceId, $code, $name, $qty, $price, $total);
            $stmt->execute();
        }
    }

    private static function deleteItems($invoiceId)
    {
        include __DIR__ . '/../../../../config/connection.php';
        $stmt = $con->prepare("DELETE FROM " . self::$itemTable . " WHERE order_id = ?");
        $stmt->bind_param("i", $invoiceId);
        $stmt->execute();
    }

    public static function getAll($logid = null)
    {
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$table;
        if ($logid) {
            $sql .= " WHERE logid = $logid";
        }
        $sql .= " ORDER BY order_id DESC";
        // echo var_dump($sql);

        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($response, $row);
            }
        }

        return $response;
    }

    public static function getById($id)
    {
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$table . " WHERE order_id = $id";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res)) {
            $response = mysqli_fetch_assoc($res);
        }

        return $response;
    }

    public static function getItems($invoiceId)
    {
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        // Use prepared statement for safety
        $stmt = $con->prepare("SELECT * FROM " . self::$itemTable . " WHERE order_id = ?");
        $stmt->bind_param("i", $invoiceId);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($response, $row);
        }
        return $response;
    }

    public static function getCustomerInvoices($customer_id)
    {
        include __DIR__ . '/../../../../config/connection.php';
        $sql = "SELECT * FROM " . self::$table . " WHERE customer_id = '" . $customer_id . "'";
        $res = mysqli_query($con, $sql);

        $response = array();
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($response, $row);
            }
        }

        return $response;

    }
}