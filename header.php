<nav class="navbar navbar-top navbar-expand-md  navbar-dark" id="navbar-main">
   <div class="container-fluid">
      <!-- Brand -->
      <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block"></a>
      <!-- Form -->
      <form method="GET" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
      </form>
      <!-- User -->
      <ul class="navbar-nav align-items-center d-none d-md-flex">
         <!-- If user is owner or staff, show go to store-->
         <a href="#" target="_blank" class="nav-link" role="button">
         <i class="fa fa-globe"></i>  
         <span class="nav-link-inner--text bold">Se7entech</span>
         </a>
         <!-- End owner and staf -->
         <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                  <!--<img id="profile-image-nav" alt="..." src="images/fav.png">-->
                  <img id="profile-image-nav" alt="..." src="<?php echo $_SESSION['avatar'];?>">
                  </span>
                  <div class="media-body ml-2 d-none d-lg-block">
                     <span class="mb-0 text-sm  font-weight-bold">Administrator</span>
                  </div>
               </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
               <div class=" dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
               </div>
               <a href="#" class="dropdown-item">
               <i class="ni ni-single-02"></i>
               <span>My profile</span>
               </a>
               <div class="dropdown-divider"></div>
               <a href="action.php?action=logout" class="dropdown-item">
               <i class="ni ni-user-run"></i>
               <span>Logout ok</span>
               </a>
            </div>
         </li>
      </ul>
   </div>
</nav>
 