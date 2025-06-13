<?php 
   session_start();
   require_once './config/config.php';
   require_once './config/connection.php';
   require_once './access.php';
   ?>
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <?php

    $rand=$_GET['id'];
    $res=mysqli_query($con,"select * from contractitem where id='$rand'");
	$row=mysqli_fetch_assoc($res);
                if(isset($_POST['save2']))
                {
                    $gitem=$_POST['g'];
                    $hitem=$_POST['h'];
                    $desitem=$_POST['des'];
                    
                     
                    $sqll="update  contractitem set g='$gitem',h='$hitem',des='$desitem' where id='$rand'";
                    $resulte=mysqli_query($con,$sqll);
                     $randdd=$row['rand'];

                    if(mysqli_affected_rows($con)==1)
                    
                    {
                        echo "<script>alert('Success');</script>";
                        echo "<script>window.location.href='update.php?rand=$randdd';</script>";
                      }
                    else{
                    echo "<script>alert('sorry! unable to insert..');</script>";
                    }
                }
                $randd=$row['rand'];
                ?>
                
                <center><form method="POST">
                    <h2>Update Service/Product</h2>
                   <br> <input type="text" value="<?php echo $row['g'];?>" name="g" class="form-control" placeholder="Service/Product Name" style="width:50%">
                    <br><input type="text" value="<?php echo $row['h'];?>" name="h" class="form-control" placeholder="Price" style="width:50%">
                    <br><input type="text" value="<?php echo $row['des'];?>" name="des" class="form-control" placeholder="Description" style="width:50%">
                    <br><input type="submit" name="save2"> 
                </form>
                
                 <a href="update.php?rand=<?php echo $randd;?>" class="btn btn-primary" name="save2">Back To Contract</button>

                
                