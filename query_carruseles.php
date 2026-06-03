<?php
include 'config/connection.php';
$q = mysqli_query($con, "SELECT id, name, status, start_time, end_time, total_time, custom_total_time, created_at FROM tasks WHERE name LIKE '%CARRUSELES%'");
if ($q) {
    while($r = mysqli_fetch_assoc($q)) {
        print_r($r);
    }
} else {
    echo "Query failed: " . mysqli_error($con) . "\n";
}
