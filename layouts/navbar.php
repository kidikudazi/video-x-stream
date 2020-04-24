   <nav class="navbar navbar-expand navbar-light bg-white static-top osahan-nav sticky-top">
      &nbsp;&nbsp; 
      <button class="btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle">
      <i class="fas fa-bars"></i>
      </button> &nbsp;&nbsp;
      <a class="navbar-brand mr-1" href="index.php">VideoXStream</a>
      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 osahan-navbar-search">
         <!-- <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <div class="input-group-append">
               <button class="btn btn-light" type="button">
               <i class="fas fa-search"></i> 
               </button>
            </div>
         </div> -->
      </form>
      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0 osahan-right-navbar">
         
         <?php 
            if(isLoggedIn()){
         ?>
            <li class="nav-item mx-1">
               <a class="nav-link" href="upload-video.php">
               <i class="fas fa-plus-circle fa-fw"></i>
               Upload Video
               </a>
            </li>
            <li class="nav-item dropdown no-arrow osahan-right-navbar-user">
               <a class="nav-link dropdown-toggle user-dropdown-link" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-user"></i>
               <?php echo $_SESSION['vid_fullname']; ?>
               </a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="account.php"><i class="fas fa-fw fa-user-circle"></i> &nbsp; My Account</a>
                  <a class="dropdown-item" href="subscriptions.php"><i class="fas fa-fw fa-video"></i> &nbsp; Subscriptions</a>
                  <a class="dropdown-item" href="settings.php"><i class="fas fa-fw fa-cog"></i> &nbsp; Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-fw fa-sign-out-alt"></i> &nbsp; Logout</a>
               </div>
            </li>
         <?php 
            }else{
         ?>
            <li class="nav-item mx-1">
               <a class="nav-link" href="login.php">
               <i class="fas fa-key"></i>
               Login
               </a>
            </li>

            <li class="nav-item mx-1">
               <a class="nav-link" href="register.php">
               <i class="fas fa-users"></i>
               Sign Up
               </a>
            </li>
         <?php 
            }
         ?>
      </ul>
   </nav>