<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>WordWise | team</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

    <!-- App css -->
    <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />
    <link href="<?php echo base_url(); ?>assets/css/app-material.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- App css -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />

    <!-- icons -->
    <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- custom css -->
    <link href="<?php echo base_url(); ?>css/customstyles.css" rel="stylesheet" type="text/css" />

    <style>
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        #alphabet {
            display: flex;
            margin: 25px auto;
            padding: 0;
            width: 100%;
            flex-wrap: wrap;
            justify-content: flex-start;
            /* max-width: 900px; */
        }

        #alphabet li {
            text-align: center;
            margin: 0 10px 10px 0;
            list-style: none;
            width: 35px;
            height: 30px;
            background: #4938d7;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            border: solid 1px #4938d7;
            line-height: 30px;
            font-size: 20px;
            text-transform: uppercase;
        }

        #alphabet li:hover {
            background: #159a80;
            border: solid 1px #159a80;
            color: #fff;
        }

        #my-word {
            display: flex;
            padding: 0;
            width: 100%;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        #hold {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .guess {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 16px;
            border-bottom: 2px solid #000;
            /* border-radius: 3px; */
            width: 50px;
            height: 50px;
            text-align: center;
            margin-right: 15px !important;
            list-style: none;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            color: #159a80;
        }

        .active {
            opacity: 0.4;
            cursor: default;
        }

        .button_container {
            display: flex;
            justify-content: center;
        }

        .older {
            width: 100%;
            padding: 2px;
            text-align: center;
            background: #6e768e;
            color: #ffffff;
            font-weight: bold;
        }

        #notify_me{
            margin-right: 5px;
        }
        @media (min-width:320px) {}
        .make-center {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        @media (max-width:600px) {
            .guess {
                width: 30px;
                height: 30px;
            }
        }
    </style>

</head>

<body class="loading">

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <!-- LOGO -->
                <div class="logo-box">
                    <a href="index.html" class="logo logo-dark text-center">
                        <span class="logo-sm">
                            <img src="<?php echo base_url(); ?>assets/images/logo-sm.png" alt="" height="48">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo base_url(); ?>assets/images/logo-dark.png" alt="" height="48">
                            <!-- <span class="logo-lg-text-light">U</span> -->
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light text-center">
                        <span class="logo-sm">
                            <img src="<?php echo base_url(); ?>assets/images/logo-sm.png" alt="" height="48">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo base_url(); ?>assets/images/logo-light.png" alt="" height="48">
                        </span>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- end Topbar -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="unsubscribe-msg" style="padding-top: 40%">
                            <?php
                            if ($this->session->flashdata('success')) {
                                ?>
                                <h4>Unsubscribed successfully.</h4>
                                <?php
                            }
                            else{
                                ?>
                                <h4>Do you want to unsubscribe from our messages?</h4>
                                <p>You'll stop receiving messages from us</p>
                                <form method="post" action="<?= base_url(); ?>admin/unsubscibe_newsletters">
                                    <input type="hidden" name="email" value="<?= $email; ?>">
                                    <button class="btn btn-primary">Unsubscribe</button>
                                </form>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-lg-right text-md-right text-center">
                            &copy; <script>
                                document.write(new Date().getFullYear())
                            </script> team. All rights reserved.
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Vendor js -->
    <script src="<?php echo base_url(); ?>assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>

</body>

</html>