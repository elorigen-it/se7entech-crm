<?php
session_start();
if(isset($_SESSION['email']))
{
	include('connection.php');
	$logid=$_SESSION['email'];
	$res=mysqli_query($con,"select * from invoice_user where email='$logid'");
	$row=mysqli_fetch_assoc($res);
	$access = $row['status'];
	$name = $row['first_name'];
	$shareid =$row['id']; 
	
	if($access=='0')
	{
	    
	}
	else
	{
	    $data = "where logid='$logid'";
	}
	
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
    
    function load_unseen_notification(view = '')
    {
    $.ajax({
    url:"<?php echo $base_url.'/fetch.php';?>",
    method:"POST",
    data:{view:view},
    dataType:"json",
    success:function(data)
    {
        // $('.dropdown-menu').html(data.notification);
        if(data.unseen_notification > 0)
        {
        $('.count').html(data.unseen_notification);
        }
    }
    });
    }
    
    load_unseen_notification();
    
    $('#comment_form').on('submit', function(event){
    event.preventDefault();
    if($('#subject').val() != '' && $('#comment').val() != '')
    {
    var form_data = $(this).serialize();
    $.ajax({
        url:"insert.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
        $('#comment_form')[0].reset();
        load_unseen_notification();
        }
    });
    }
    else
    {
    alert("Both Fields are Required");
    }
    });
    
    $(document).on('click', '.dropdown-toggle', function(){
    $('.count').html('');
    load_unseen_notification('yes');
    });
    
    setInterval(function(){ 
    load_unseen_notification();; 
    }, 5000);
    
    });
</script>

<nav class="navbar navbar-vertical fixed-left navbar-expand-md
navbar-light bg-white" id="sidenav-main">

<div class="container-fluid">
    <!-- Toggler -->
    <button class="navbar-toggler" type="button"
        data-toggle="collapse" data-target="#sidenav-collapse-main"
        aria-controls="sidenav-main" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Brand -->
    <a class="navbar-brand pt-0" href="https://crm.se7entech.net/">
        <img src="https://se7entech.net/images/logo.png"
            class="navbar-brand-img" alt="...">
    </a>
    <!-- User -->
    
    <!-- Collapse -->
    <div class="collapse navbar-collapse"
        id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
            <div class="row">
                <div class="col-6 collapse-brand">
                    <a href="https://crm.se7entech.net/">
                        <img
                            src="https://se7entech.net/images/logo.png">
                    </a>
                </div>
                <div class="col-6 collapse-close">
                    <button type="button" class="navbar-toggler"
                        data-toggle="collapse"
                        data-target="#sidenav-collapse-main"
                        aria-controls="sidenav-main"
                        aria-expanded="false" aria-label="Toggle
                        sidenav">
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Navigation -->
        <span></span>

        <span></span>

        <span></span>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url;?>/dashboard">
                    <i class="fa fa-desktop"></i> Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url;?>/Client">
                    <i class="fa fa-users"></i> Client
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url;?>/Lead">
                    <i class="fa fa-list"></i> Lead
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url;?>/Contract">
                    <i class="fa fa-book"></i> Contract
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url;?>/inv">
                    <i class="fa fa-address-book-o"></i> Invoice
                </a>
            </li>
           

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url;?>/Email">
                    <i class="fa fa-bell"></i> Notification Email
                    <!--<div class="blob red"></div>-->
                </a>
            </li>

             
            <li class="nav-item">
                <a href="Payment-Reminder" class="nav-link" href="<?php echo $base_url;?>/visits">
                    <i class="fa fa-usd"></i> Payment Reminder
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url;?>/agentdata">
                    <i class="fa fa-vcard-o"></i> Sales Data
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" target="blank" title="you can shere by copy url" href="<?php echo $base_url;?>/questionair-list">
                    <i class="fa fa-question"></i> Questionnaire
                </a>
            </li>
          

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url;?>/Appointment">
                    <i class="fa fa-calendar-o"></i> Appointment
                </a>
            </li>
            
            <li class="nav-item" style="<?php echo $access=='0'?'':'display:none'?>">
                <a class="nav-link" href="<?php echo $base_url;?>/Model">
                    <i class="fa fa-female"></i> Model
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="Pin-Location">
                    <i class="fa fa-map-marker"></i> Pined Location
                </a>
            </li>
            
            <li class="nav-item" style="<?php echo $access=='0'?'':'display:none'?>">
                <a class="nav-link" href="<?php echo $base_url;?>/marker-icon">
                    <i class="fa fa-paint-brush"></i> Add Icon
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url;?>/modules/video/">
                    <i class="fa fa-video"></i> Upload Video
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url;?>/calendar">
                    <i class="fa fa-calendar"></i> Calendar
                </a>
            </li>
            
            
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" href="<?php echo $base_url;?>/chat/users">
                    <i class="fa fa-comments"></i> Chat Now <sup class="count" style="color:red"></sup> 
                </a>
            </li>
            
                        <!--<li class="nav-item">-->
                        <!--<li class="nav-item dropdown">-->
                        <!--<a class="nav-link" href="#" role="button"-->
                        <!--data-toggle="dropdown" aria-haspopup="true"-->
                        <!--aria-expanded="false">-->
                        <!--<i class="fa fa-cog"></i> Setting-->
                        <!--</a>-->
                        <!--<div class="dropdown-menu dropdown-menu-arrow-->
                        <!--dropdown-menu-right">-->
                        
                        <!--<a href="profile" class="dropdown-item">-->
                        <!--<i class="fa fa-envelope-o"></i>-->
                        <!--<span>Email</span>-->
                        <!--</a>-->
                        
                        <!--<div class="dropdown-divider"></div>-->
                       
                        <!--<a href="#" class="dropdown-item">-->
                        <!--<i class="fa fa-usd"></i>-->
                        <!--<span>Payment</span>-->
                        <!--</a>-->
                        
                        <!--<div class="dropdown-divider"></div>-->
                        <!--<a href="#" class="dropdown-item">-->
                        <!--<i class="fa fa-image"></i>-->
                        <!--<span>Logo</span>-->
                        <!--</a>-->
                        
                        <!--</div>-->
                        <!--</li>-->
                        <!--</li>-->

                    </ul>
                    
                    <span></span>
                    <span></span>
                     
                    <!-- Divider -->
                    <hr class="my-3">
                    <!-- Heading -->

    </div>
</div>
</nav>
<?php
}
else
{
header("location:index.php");
}
?>