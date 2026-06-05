<?php
include 'C:\Users\PC\Documents\se7entech-crm\config\connection.php';

$res = mysqli_query($con, "SHOW COLUMNS FROM customers LIKE 'mega_upload_link'");
if (mysqli_num_rows($res) > 0) {
    echo "Column mega_upload_link already exists in customers table.\n";
} else {
    echo "Column mega_upload_link does not exist. Adding it...\n";
    $alter = mysqli_query($con, "ALTER TABLE customers ADD COLUMN mega_upload_link VARCHAR(255) DEFAULT NULL");
    if ($alter) {
        echo "Column mega_upload_link added successfully!\n";
    } else {
        echo "Error adding column: " . mysqli_error($con) . "\n";
    }
}
