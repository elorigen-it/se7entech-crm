   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se7entech Corporation</title>

<link rel="apple-touch-icon" sizes="180x180" href="images/fav.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/fav.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/fav.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <div class="container"  style="padding-top:150px">
                <center><h2>Your Files</h2></center>
        <div class="row">
             <?php
    include('connection.php');
    $rand = $_GET['id'];
    $sql="select * from clientfile where rand ='$rand'";
    $result11=mysqli_query($con,$sql);
    
    
    if(mysqli_num_rows($result11))
    {
    
    $i=1;
    while($rows11=mysqli_fetch_assoc($result11))
    {
    $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
     
    ?>
             <div class="col-sm-4" style="padding-top:50px'border-style:solid">
                <embed style="width:100%" src="images/Clients/<?php echo $rows11['file'];?>"></embed>
                <center title="Click To View" style="padding-top:5px"><a href="images/Clients/<?php echo $rows11['file'];?>"><button class="btn btn-success"><i class="fa fa-eye"></i></button></a></center>
            </div>
                 <?php $i++;}}?>
        </div>
    </div>
