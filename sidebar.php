<?php
@session_start();

if(isset($_SESSION['email']))
{
	$logid=$_SESSION['email'];
	$res=mysqli_query($con,"select * from invoice_user where email='$logid'");
	$row=mysqli_fetch_assoc($res);
	$access = $row['status'];
	$name = $row['first_name']; 
	$shareid =$row['id']; 
    $role = $row['role'];

    $isDepartmentResponsible = $_SESSION['is_department_responsible'];
	if($access=='0')
	{
	    
	}
	else
	{
	    $data = "where logid='$logid'";
	}
	
?>

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
    <a class="navbar-brand pt-0" href="<?php echo $base_url;?>/contractnew/">
        <img src="<?php echo $base_url;?>/images/logo.png"
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
                    <a href="<?php echo $base_url;?>/contractnew/">
                        <img
                            src="<?php echo $base_url;?>/images/logo.png">
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
            <!-- <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url;?>/modules/tasks/">
                    <i class="fa fa-tasks"></i> Tasks
                </a>
            </li> -->
            <?php if($role != 12 && $role != 15):?>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>/modules/tasks/index.php/labels">
                        <i class="fa fa-tasks"></i> Tasks Labels
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>/modules/customers/">
                        <i class="fa fa-users"></i> Customers
                    </a>
                </li>
                
                <!-- <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>/Lead">
                        <i class="fa fa-list"></i> Lead
                    </a>
                </li> -->

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>/modules/contract/">
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

                
                <!--<li class="nav-item">
                    <a href="<?php echo $base_url;?>/Payment-Reminder" class="nav-link">
                        <i class="fa fa-usd"></i> Payment Reminder
                    </a>
                </li> -->


                <!-- <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>/agentdata">
                        <i class="fa fa-vcard-o"></i> Sales Data
                    </a>
                </li> -->
                
                <!-- <li class="nav-item">
                    <a class="nav-link" title="you can shere by copy url" href="<?php echo $base_url;?>/questionair-list">
                        <i class="fa fa-question"></i> Questionnaire
                    </a>
                </li> -->
            

                <!-- <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>/Appointment">
                        <i class="fa fa-calendar-o"></i> Appointment
                    </a>
                </li> -->

                <!-- <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>/modules/appointments/">
                        <i class="fa fa-calendar-o"></i> Appointments
                    </a>
                </li> -->
                
                <!--<li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>/modules/payReminder/">
                        <i class="fa fa-usd"></i> Reminder
                    </a>
                </li> -->
                
                <!-- <li class="nav-item" style="<?php echo $access=='0'?'':'display:none'?>">
                    <a class="nav-link" href="<?php echo $base_url;?>/Model">
                        <i class="fa fa-female"></i> Model
                    </a>
                </li> -->
                
                <!-- <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>/Pin-Location">
                        <i class="fa fa-map-marker"></i> Pined Location
                    </a>
                </li> -->
            <?php endif;?>
            
            
            
            <?php if($role != 12 && $role != 15):?>
                <!-- <li class="nav-item" style="<?php echo $access=='0'?'':'display:none'?>">
                    <a class="nav-link" href="<?php echo $base_url;?>/marker-icon">
                        <i class="fa fa-paint-brush"></i> Add Icon
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>/modules/videos/">
                        <i class="fa fa-video"></i> Upload Video
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>/modules/calendar/">
                        <i class="fa fa-calendar"></i> Calendar
                    </a>
                </li> -->
                
                
                <!-- <li class="nav-item">
                    <a class="nav-link dropdown-toggle" href="<?php echo $base_url;?>/chat/users">
                        <i class="fa fa-comments"></i> Chat Now <sup class="count" style="color:red"></sup> 
                    </a>
                </li> -->

                <?php if($access === '0'):?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url;?>/modules/zones/">
                            <i class="fa fa-globe" aria-hidden="true"></i> Zones
                        </a>
                    </li>
                <?php endif;?>

                <?php if($access === '0'):?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url;?>/modules/roles/">
                            <i class="fa fa-cog" aria-hidden="true"></i> Roles
                        </a>
                    </li>
                <?php endif;?>

                <?php if($access === '0'):?>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url;?>/modules/users/">
                            <i class="fa fa-cog" aria-hidden="true"></i> Users
                        </a>
                    </li> -->
                <?php endif;?>

                <?php // if($access === '0'):?>
                    <?php if($access === '0' || $isDepartmentResponsible):?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url;?>/modules/services/">
                            <i class="fa fa-cog" aria-hidden="true"></i> Services
                        </a>
                    </li>
                <?php endif;?>
                
                <?php if($access === '0'):?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url;?>/modules/departments/">
                            <i class="fa fa-cog" aria-hidden="true"></i> Departments
                        </a>
                    </li>
                <?php endif;?>
            <?php endif;?>
            <!-- <li class="nav-item">
                <a class="nav-link" href="<?php echo $base_url;?>/modules/users/index.php/taxes/">
                    <i class="fa fa-cog" aria-hidden="true"></i> My Contract / Taxes
                </a>
            </li> -->
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
?>