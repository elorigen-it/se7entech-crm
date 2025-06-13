 <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <?php
 
    $con=mysqli_connect("localhost","buapxtgk_contract","Contract@7542","buapxtgk_contract");
    $rand=$_GET['id'];
    $res=mysqli_query($con,"select * from contactnew where id='$rand'");
	$row=mysqli_fetch_assoc($res);
                if(isset($_POST['save2']))
                {
                   
                   $company_sign = $rand.$_FILES['company_sign']['name'];                      
                   
                   
                    $sqll="update  contactnew set r='$company_sign' where id='$rand'";
                    $resulte=mysqli_query($con,$sqll);
                    
                    $company_sign =  $rand.$_FILES['company_sign']['name'];
                    if(move_uploaded_file( $_FILES['company_sign']['tmp_name'], 'images/'.$company_sign))
                     
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
                
                <center><form method="POST" enctype="multipart/form-data">
                    <h2>Update  attach a copy of a voided check</h2>
                   <br> <input type="file" accept="image/*"  name="company_sign" class="form-control"   style="width:50%">
                     <br><button class="btn btn-primary" name="save2">Update</button>
                </form>
                
                 <a href="update.php?rand=<?php echo $randd;?>" class="btn btn-primary" name="save2">Back To Contract</button>

                
                