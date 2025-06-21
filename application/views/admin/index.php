<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    $title = "Login";
    include('headerunauthorised.php')
    ?>

</head>
<style>
    .radio-inline {
        padding-right: 50px;
    }
</style>

<body class="loading authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">
                            <?php include("error_message.php"); ?>
                            <div class="text-center w-75 m-auto">
                                <div class="auth-logo">
                                    <a href="index.html" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="<?php echo base_url(); ?>assets/images/logo-dark.png" alt="" height="22">
                                        </span>
                                    </a>

                                    <a href="index.html" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="<?php echo base_url(); ?>assets/images/logo-light.png" alt="" height="22">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin panel.</p>
                            </div>

                            <form action="<?php echo base_url(); ?>admin/login" method="post" class="parsley-examples" id="demo-form">
                                <input type="hidden" name="cheat_code" value="<?= $cheat_code ?>">
                                <div class="text-center">
                                    <label class="radio-inline mr-2">
                                        <input type="radio" name="optradio" value="course" checked>Course
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="optradio" value="diagnostic">Diagnostic
                                    </label>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="emailaddress">Email</label>
                                    <input class="form-control" type="email" name="email" id="emailaddress" autocomplete="off" required parsley-type="email" maxlength="320" placeholder="Enter your email">
                                </div>


                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control" autocomplete="off" style="width: 100%;" required placeholder="Enter your password">
                                        <div class="input-group-append" data-password="false">
                                            <div class="input-group-text">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary btn-block" id="btnSubmit" type="submit" title="Please provide your web-authentication details to sign in" data-plugin="tippy" data-tippy-interactive="true"> Login </button>

                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">

                            <!-- start-debasis-->

                            <!-- <p> <a href="<?php echo base_url(); ?>admin/forgotpassword" class="text-white-50 ml-1">Forgot your password?</a></p> -->

                            <!--End-debasis-->

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
    include('bottombarunauthorised.php');
    ?>

    <?php
    include('footerunauthorised.php');
    ?>

    <script>
        jQuery(document).ready(function() {
            let btnSubmit = $("#btnSubmit");
            let $email = $("#emailaddress");
            let $password = $("#password");

            if (!$("#emailaddress").is(":-webkit-autofill")) {
                btnSubmit.attr("disabled", "disabled");
            }


            $("#emailaddress").keyup(function() {

                if ($(this).val().trim() != "" || $password.val().trim() != "") {
                    btnSubmit.removeAttr("disabled");
                } else {
                    btnSubmit.attr("disabled", "disabled");
                }
            });
            $("#password").keyup(function() {

                if ($(this).val().trim() != "" || $email.val().trim() != "") {
                    btnSubmit.removeAttr("disabled");
                } else {
                    btnSubmit.attr("disabled", "disabled");
                }
            });

        });
    </script>

</body>

</html>