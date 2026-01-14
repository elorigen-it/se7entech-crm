<?php
@session_start();

if (isset($_SESSION['email'])) {
    $logid = $_SESSION['email'];
    $res = mysqli_query($con, "select * from invoice_user where email='$logid'");
    $row = mysqli_fetch_assoc($res);
    $access = $row['status'];
    $name = $row['first_name'];
    $shareid = $row['id'];
    $role = $row['role'];

    $isDepartmentResponsible = $_SESSION['is_department_responsible'];
    if ($access == '0') {

    } else {
        $data = "where logid='$logid'";
    }

    ?>

    <nav class="navbar navbar-vertical fixed-left navbar-expand-md
navbar-light bg-white" id="sidenav-main">

        <div class="container-fluid">
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Brand -->
            <a class="navbar-brand pt-0" href="<?php echo $base_url; ?>/contractnew/">
                <img src="<?php echo $base_url; ?>/images/logo.png" class="navbar-brand-img" alt="...">
            </a>
            <!-- User -->

            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Collapse header -->
                <div class="navbar-collapse-header d-md-none">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="<?php echo $base_url; ?>/contractnew/">
                                <img src="<?php echo $base_url; ?>/images/logo.png">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                                aria-label="Toggle
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
                        <a class="nav-link" href="<?php echo $base_url; ?>/dashboard">
                            <i class="ni ni-tv-2 text-primary"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#tasksSubmenu" data-toggle="collapse" aria-expanded="false"
                            aria-controls="tasksSubmenu">
                            <i class="ni ni-bullet-list-67 text-blue"></i> Tasks
                        </a>
                        <div class="collapse" id="tasksSubmenu">
                            <ul class="navbar-nav ml-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo $base_url; ?>/modules/tasks/">
                                        <i class="ni ni-bullet-list-67"></i> All Tasks
                                    </a>
                                </li>
                                <!-- NEW LINK -->
                                <?php if ($access == '0'): // Only for Admin ?>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="<?php echo $base_url; ?>/modules/tasks/index.php/admin-dashboard">
                                            <i class="ni ni-spaceship"></i> Task Admin
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <!-- End NEW LINK -->
                                <?php if ($role != 12 && $role != 15): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $base_url; ?>/modules/tasks/index.php/labels">
                                            <i class="ni ni-tag"></i> Tasks Labels
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $base_url; ?>/modules/tasks/index.php/categories">
                                            <i class="ni ni-tag"></i> Tasks Categories
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                    <?php if ($role != 12 && $role != 15): ?>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#projectsSubmenu" data-toggle="collapse" aria-expanded="false"
                                aria-controls="projectsSubmenu">
                                <i class="ni ni-briefcase-24 text-orange"></i> Projects
                            </a>
                            <div class="collapse" id="projectsSubmenu">
                                <ul class="navbar-nav ml-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo $base_url; ?>/modules/projects/">
                                            <i class="ni ni-briefcase-24"></i> All Projects
                                        </a>
                                    </li>



                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/modules/customers/">
                                <i class="ni ni-single-02 text-yellow"></i> Customers
                            </a>
                        </li>

                        <!-- <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url; ?>/Lead">
                        <i class="fa fa-list"></i> Lead
                    </a>
                </li> -->

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/modules/contract/">
                                <i class="ni ni-books text-info"></i> Contract
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/modules/invoices/index.php/">
                                <i class="ni ni-single-copy-04 text-pink"></i> Invoices
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/Email">
                                <i class="ni ni-bell-55"></i> Notification Email
                                <!--<div class="blob red"></div>-->
                            </a>
                        </li>


                        <!--<li class="nav-item">
                    <a href="<?php echo $base_url; ?>/Payment-Reminder" class="nav-link">
                        <i class="fa fa-usd"></i> Payment Reminder
                    </a>
                </li> -->


                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/agentdata">
                                <i class="ni ni-chart-bar-32"></i> Sales Data
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" title="you can shere by copy url"
                                href="<?php echo $base_url; ?>/questionair-list">
                                <i class="ni ni-chat-round"></i> Questionnaire
                            </a>
                        </li>


                        <!-- <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url; ?>/Appointment">
                        <i class="fa fa-calendar-o"></i> Appointment
                    </a>
                </li> -->

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/modules/appointments/">
                                <i class="ni ni-calendar-grid-58 text-red"></i> Appointments
                            </a>
                        </li>

                        <!--<li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url; ?>/modules/payReminder/">
                        <i class="fa fa-usd"></i> Reminder
                    </a>
                </li> -->

                        <li class="nav-item" style="<?php echo $access == '0' ? '' : 'display:none' ?>">
                            <a class="nav-link" href="<?php echo $base_url; ?>/Model">
                                <i class="ni ni-badge"></i> Model
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/Pin-Location">
                                <i class="ni ni-pin-3 text-purple"></i> Pined Location
                            </a>
                        </li>
                    <?php endif; ?>



                    <?php if ($role != 12 && $role != 15): ?>
                        <li class="nav-item" style="<?php echo $access == '0' ? '' : 'display:none' ?>">
                            <a class="nav-link" href="<?php echo $base_url; ?>/marker-icon">
                                <i class="ni ni-palette text-cyan"></i> Add Icon
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/modules/videos/">
                                <i class="ni ni-button-play text-red"></i> Upload Video
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>/modules/calendar/">
                                <i class="ni ni-calendar-grid-58 text-info"></i> Calendar
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" href="<?php echo $base_url; ?>/chat/users">
                                <i class="ni ni-chat-round text-green"></i> Chat Now <sup class="count" style="color:red"></sup>
                            </a>
                        </li>

                        <?php if ($access === '0'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $base_url; ?>/modules/zones/">
                                    <i class="ni ni-world text-primary"></i> Zones
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($access === '0'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $base_url; ?>/modules/roles/">
                                    <i class="ni ni-settings-gear-65 text-red"></i> Roles
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($access === '0'): ?>

                            <li class="nav-item">
                                <!-- <a class="nav-link" href="#usersSubmenu">
                            <i class="fa fa-cog" aria-hidden="true"></i> Users
                        </a> -->
                                <a class="nav-link collapsed" href="#usersSubmenu" data-toggle="collapse" aria-expanded="false"
                                    aria-controls="usersSubmenu">
                                    <i class="ni ni-circle-08 text-pink"></i> Users
                                </a>
                                <div class="collapse" id="usersSubmenu">
                                    <ul class="navbar-nav ml-3">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo $base_url; ?>/modules/users/">
                                                <i class="ni ni-single-02"></i> CRM users
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link"
                                                href="<?php echo $base_url; ?>/modules/customers/index.php/login-access">
                                                <i class="ni ni-key-25"></i> Customers access
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php // if($access === '0'): ?>
                        <?php if ($access === '0' || $isDepartmentResponsible): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $base_url; ?>/modules/services/">
                                    <i class="ni ni-settings text-orange"></i> Services
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($access === '0'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $base_url; ?>/modules/departments/">
                                    <i class="ni ni-building text-yellow"></i> Departments
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url; ?>/modules/users/index.php/taxes/">
                            <i class="ni ni-money-coins text-green"></i> My Contract / Taxes
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
?>