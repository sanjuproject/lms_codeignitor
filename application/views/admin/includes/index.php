<!DOCTYPE html>
<html lang="en">
    <head>

<meta charset="utf-8" />
        <title>Log In | Alsowise</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">

		<!-- App css -->
		<link href="<?php echo base_url();?>assets/css/bootstrap-creative.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
		<link href="<?php echo base_url();?>assets/css/app-creative.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

		<!-- <link href="./assets/css/bootstrap-creative-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
		<link href="./assets/css/app-creative-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" /> -->
        <link href="<?php echo base_url();?>css/customstyles.css" rel="stylesheet" type="text/css" />

		<!-- icons -->
		<link href="<?php echo base_url();?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body class="loading authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a href="index.html" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="<?php echo base_url();?>assets/images/logo-dark.png" alt="" height="22">
                                            </span>
                                        </a>
                    
                                        <a href="index.html" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="<?php echo base_url();?>assets/images/logo-light.png" alt="" height="22">
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin panel.</p>
                                </div>

                                <form action="<?php echo base_url();?>admin/login" method="post" class="parsley-examples" id="demo-form">

                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Email</label>
                                        <input class="form-control" type="email" name="email" id="emailaddress" autocomplete="off" required parsley-type="email"  maxlength="320" placeholder="Enter your email">
                                    </div>
                                 

                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" name="password" class="form-control" autocomplete="off" style="width: 100%;" required placeholder="Enter your password">
                                            <div class="input-group-append" data-password="false">
                                                <div class="input-group-text" >
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" id="btnSubmit" type="submit"  disabled="disabled" title="Please provide your web-authentication details to sign in" data-plugin="tippy" data-tippy-interactive="true"> Login </button>
                                      
                                    </div>

                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p> <a href="forgotpassword.php" class="text-white-50 ml-1">Forgot your password?</a></p>
                                <!-- <p class="text-white-50">Don't have an account? <a href="signup.html" class="text-white ml-1"><b>Sign Up</b></a></p> -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <?php
                include('includes/bottombarunauthorised.php');
            ?>

            <?php
                include('includes/footerunauthorised.php');
            ?>
        
        <script>
            jQuery(document).ready(function(){

                $("#emailaddress").keyup(function () {
                    let btnSubmit = $("#btnSubmit");
                    if ($(this).val().trim() != "" || $("#password").val().trim() != "") {
                        btnSubmit.removeAttr("disabled");
                    } else {
                        btnSubmit.attr("disabled", "disabled");
                    }
                });
                $("#password").keyup(function () {
                    let btnSubmit = $("#btnSubmit");
                    if ($(this).val().trim() != "" || $("#emailaddress").val().trim() != "") {
                        btnSubmit.removeAttr("disabled");
                    } else {
                        btnSubmit.attr("disabled", "disabled");
                    }
                });
            });
        </script>

    </body>
</html>