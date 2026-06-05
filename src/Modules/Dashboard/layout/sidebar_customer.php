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
        <a class="navbar-brand pt-0" href="<?php echo $this->base_url;?>/modules/dashboard/index.php/customer">
            <img src="<?php echo $this->base_url;?>/images/logo.png"
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
                        <a href="<?php echo $this->base_url;?>/modules/dashboard/index.php/customer">
                            <img src="<?php echo $this->base_url;?>/images/logo.png">
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
                    <a class="nav-link" href="<?php echo $this->base_url;?>/modules/dashboard/index.php/customer">
                        <i class="fa fa-desktop"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $this->base_url;?>/modules/customer-portal/index.php/tasks">
                        <i class="fa fa-tasks text-info"></i> Tasks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $this->base_url;?>/modules/customer-portal/index.php/ai-request">
                        <i class="fa fa-magic" style="color: #6f42c1;"></i> AI Project Request
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $this->base_url;?>/modules/customer-portal/index.php/contracts">
                        <i class="fa fa-book"></i> Contracts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $this->base_url;?>/modules/customer-portal/index.php/invoices">
                        <i class="fa fa-address-book-o"></i> Invoices
                    </a>
                </li>
            </ul>
            
            <span></span>
            <span></span>
                
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->

        </div>
    </div>
</nav>