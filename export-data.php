<?php 
 
// Load the database configuration file 
include './config/connection.php';
 
// Fetch records from database 
$query = $con->query("SELECT * FROM colleges ORDER BY id ASC"); 
 
if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "members-data_" . date('Y-m-d') . ".xls"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('Sr no','Client name','Email','Phone','Address','Lat','Lang','Url','Map','Date'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $query->fetch_assoc()){ 
        $status = date("d-m-Y", strtotime($row['date'])); 
        
        $lineData = array($row['id'], $row['client_name'], $row['email'], $row['phone'], $row['address'], $row['lat'], $row['lng'],$row['url'],$row['direction_link'],$status ); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
?>