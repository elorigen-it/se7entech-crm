<?php 
@session_start();
// echo var_dump($_SESSION);
include_once('access.php');?>
<nav class="navbar navbar-top navbar-expand-md  navbar-dark" id="navbar-main">
   <div class="container-fluid">
      <!-- Brand -->
      <a class="h4 mb-0 text-uppercase d-none d-md-inline-block">
         <button class="navbar-toggle-md" type="button" id="toggle-sidebar-md" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
      </a>
      <!-- Form -->
      <!-- User -->
      <ul class="navbar-nav align-items-center d-none d-md-flex">
         <!-- If user is owner or staff, show go to store-->
         <a href="https://se7entech.net/Get-Started" target="_blank" class="nav-link" role="button">
         <i class="fa fa-globe"></i>  
         <span class="nav-link-inner--text bold">Prospect</span>
         </a>
         <!-- End owner and staf -->
         <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                  <!--<img id="profile-image-nav" alt="..." src="<?php echo $base_url;?>/images/fav.png">-->
                  <img id="profile-image-nav" alt="..." src="<?php echo ($_SESSION['avatar']) ? $_SESSION['avatar'] : $base_url . '/images/fav.png';?>">
                  </span>
                  <div class="media-body ml-2 d-none d-lg-block">
                     <span class="mb-0 text-sm  font-weight-bold"><?php echo $name;?></span>
                  </div>
               </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
               <div class=" dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
               </div>
               <!--<a href="#" class="dropdown-item">-->
               <!--<i class="fa fa-user"></i>-->
               <!--<span>My profile</span>-->
               <!--</a>-->
               <div class="dropdown-divider"></div>
               <a href="<?php echo $base_url;?>/logout" class="dropdown-item">
               <i class="fa fa-unlock"></i>
               <span>Logout</span>
               </a>
            </div>
         </li>
      </ul>
   </div>
</nav>