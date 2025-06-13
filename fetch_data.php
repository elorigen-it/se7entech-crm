<?php
$d = $_GET['d'];
include('./config/connection.php');//Check for connection error
if($con->connect_error){
  die("Error in DB connection: ".$con->connect_errno." : ".$con->connect_error);    
}
if (isset($d)) {
    $select  = " SELECT * FROM appointment WHERE d = '$d'";
    $result = $con->query($select);
    echo '<table class="table table-bordered">';
    while($row = $result->fetch_object()){
        echo '
        <tr>
        <th>Client Name</th>
        <th>Email</th>
        <th>Notes</th>
        <th>Appointment Time</th>
        </tr>
        <tr>'
            .'<td>'.$row->clientname.'</td>'
            .'<td>'.$row->email.'</td>'
             .'<td>'.$row->notes.'</td>'
             .'<td>'.$row->date.'</td>'
            .'</tr>';
    }
    echo '</table>';
}     
?>  