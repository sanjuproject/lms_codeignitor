<!-- Topbar Start -->
<div class="navbar-custom">
                <div class="container-fluid">
                    <ul class="list-unstyled topnav-menu float-right mb-0">

    
                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <?php
                                if (!$this->session->userdata('is_institute')) {
                                    if(!empty($profile_pic)){
                                        ?>
                                        <img src="<?php echo base_url();?>assets/images/users/<?php echo $profile_pic;?>" alt="user-image" class="rounded-circle" />
                                        <?php 
                                    }else{ 
                                        ?>
                                        <img src="<?php echo base_url();?>assets/images/users/profile.jpg" alt="user-image" class="rounded-circle" />
                                        <?php 
                                    }
                                }
                                ?>
                                
                                <span class="pro-user-name ml-1">
                                    <?php echo $profile_name;?> <i class="mdi mdi-chevron-down"></i> 
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <?php
                                if ($this->session->userdata('is_institute')) {
                                    ?>
                                    <a href="<?php echo base_url();?>institution/profile" class="dropdown-item notify-item">
                                        <i class="fe-user"></i>
                                        <span>Profile</span>
                                    </a>
                                    <?php
                                }
                                else{
                                    ?>
                                    <a href="<?php echo base_url();?>admin/profile" class="dropdown-item notify-item">
                                        <i class="fe-user"></i>
                                        <span>Profile</span>
                                    </a>
                                    <?php
                                }
                                ?>
    
                                <!-- item-->
                                <a href="<?php echo base_url();?>admin/logout" class="dropdown-item notify-item" data-toggle="modal" data-target="#warning-alert-modal">
                                    <i class="fe-log-out"></i>
                                    <span>Logout</span>
                                </a>
    
                
    
                            </div>
                        </li>
    

    
                    </ul>
    
                    <!-- LOGO -->
                     <!-- Start-debasis -->
                    <div class="logo-box">
                        <a href="<?php echo base_url();?>admin/dashboard" class="logo logo-dark text-center">
                            <span class="logo-sm">
                                <img src="<?php echo base_url();?>assets/images/logo-sm.png" alt="" height="48">
                                <!-- <span class="logo-lg-text-light">UBold</span> -->
                            </span>
                            <span class="logo-lg">
                                <img src="<?php echo base_url();?>assets/images/logo-dark.png" alt="" height="48">
                                <!-- <span class="logo-lg-text-light">U</span> -->
                            </span>
                        </a>
    
                        <a href="<?php echo base_url();?>admin/dashboard" class="logo logo-light text-center">
                            <span class="logo-sm">
                                <img src="<?php echo base_url();?>assets/images/logo-sm.png" alt="" height="48">
                            </span>
                            <span class="logo-lg">
                                <img src="<?php echo base_url();?>assets/images/logo-light.png" alt="" height="48">
                            </span>
                        </a>
                    </div>
                     <!-- End-debasis -->
    
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
                    <div class="modal-content custom-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="dripicons-warning h1 text-warning"></i>
                                <h4 class="mt-2">Warning!</h4>
                                <p class="mt-3">You are going to sign off from this Application. Are you sure ?</p>
                                <div class="button-list">
                                    <button type="button" class="btn btn-danger" onclick="logoutuser();" data-dismiss="modal">Yes</button>
                                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
<script>
function logoutuser()
{
	window.location.href = "<?php echo base_url();?>admin/logout";
}
</script>			