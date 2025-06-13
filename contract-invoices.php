<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require('./config/connection.php');

$inserts = 'INSERT INTO contract_invoices (contract_id, invoice_id) VALUES (140, 745)|INSERT INTO contract_invoices (contract_id, invoice_id) VALUES (140, 749)|INSERT INTO contract_invoices (contract_id, invoice_id) VALUES (140, 770)|INSERT INTO contract_invoices (contract_id, invoice_id) VALUES (140, 771)|INSERT INTO contract_invoices (contract_id, invoice_id) VALUES (141, 772)|INSERT INTO contract_invoices (contract_id, invoice_id) VALUES (151, 759)|INSERT INTO contract_invoices (contract_id, invoice_id) VALUES (152, 763)|INSERT INTO contract_invoices (contract_id, invoice_id) VALUES (152, 764)|INSERT INTO contract_invoices (contract_id, invoice_id) VALUES (153, 699)|INSERT INTO contract_invoices (contract_id, invoice_id) VALUES (154, 767)|INSERT INTO contract_invoices (contract_id, invoice_id) VALUES (155, 768)|INSERT INTO contract_invoices (contract_id, invoice_id) VALUES (158, 0)';
$insertsArr = explode('|', $inserts);
if(count($insertsArr)){
    foreach($insertsArr as $sql){
        mysqli_query($con, $sql);
    }
}