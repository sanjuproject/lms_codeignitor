<!-- Topbar Start -->
<div class="navbar-custom">
                <div class="container-fluid">
                    <ul class="list-unstyled topnav-menu float-right mb-0">

    
                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="./assets/images/users/user-1.jpg" alt="user-image" class="rounded-circle">
                                <span class="pro-user-name ml-1">
                                    Geneva <i class="mdi mdi-chevron-down"></i> 
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                       
                                <a href="profile.php" class="dropdown-item notify-item">
                                    <i class="fe-user"></i>
                                    <span>Profile</span>
                                </a>
    
                                <!-- item-->
                                <a href="#" class="dropdown-item notify-item" data-toggle="modal" data-target="#warning-alert-modal">
                                    <i class="fe-log-out"></i>
                                    <span>Logout</span>
                                </a>
    
                
    
                            </div>
                        </li>
    

    
                    </ul>
    
                    <!-- LOGO -->
                    <div class="logo-box">
                        <a href="dashboard.php" class="logo logo-dark text-center">
                            <span class="logo-sm">
                                <img src="images/logo-sm.png" alt="" height="22">
                                <!-- <span class="logo-lg-text-light">UBold</span> -->
                            </span>
                            <span class="logo-lg">
                                <img src="images/logo-dark.png" alt="" height="20">
                                <!-- <span class="logo-lg-text-light">U</span> -->
                            </span>
                        </a>
    
                        <a href="dashboard.php" class="logo logo-light text-center">
                            <span class="logo-sm">
                                <img src="images/logo-sm.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="images/logo-light.png" alt="" height="20">
                            </span>
                        </a>
                    </div>
    
                    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                        <li>
                            <button class="button-menu-mobile waves-effect waves-light">
                                <i class="fe-menu"></i>
                            </button>
                        </li>

                        <li>
                            <!-- Mobile menu toggle (Horizontal Layout)-->
                            <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>   
            
                    
    
                    
                    </ul>
                    
                </div>
            </div>
            <!-- end Topbar -->
            <!-- Logout modal -->
            <div id="warning-alert-modal" class="modal fade show" tabindex="-1" role="dialog"  aria-modal="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="dripicons-warning h1 text-warning"></i>
                                <h4 class="mt-2">Warning!</h4>
                                <p class="mt-3">You are going to sign off from this Application. Are you sure ?</p>
                                <div class="button-list">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>