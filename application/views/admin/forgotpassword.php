<!DOCTYPE html>
<html lang="en">
    <head>
        
    <?php
$title = "Login";
include('headerunauthorised.php')
?>

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
                                                <img src="./assets/images/logo-light.png" alt="" height="22">
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3">Enter your email address and we'll send you an email with instructions to reset your password.</p>
                                </div>

                                <form action="#" class="parsley-examples" id="demo-form">

                                    <div class="form-group">
                                        <label for="emailaddress">Email</label>
                                        <div>
                                            <input type="email" class="form-control" id="emailaddress" required
                                                   parsley-type="email" maxlength="320" placeholder="Enter your email"/>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" id="btnSubmit" type="disabled = disabled" disabled title="Please provide your email where we will send instruction to reset your password." data-plugin="tippy" data-tippy-interactive="true"  >Reset Password </button>
                                    </div>
                                    <!-- <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" id="btnSubmit" type="disabled = disabled"  disabled title="Please provide your web-authentication details to sign in" > Login </button>
                                      
                                    </div> -->

                                </form>
                                

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">Back to <a href="<?php echo base_url();?>admin" class="text-white ml-1"><b>Log in</b></a></p>
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
                include('bottombarunauthorised.php');
            ?>

            <?php
                include('footerunauthorised.php');
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