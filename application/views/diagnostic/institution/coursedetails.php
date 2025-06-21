<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item active">Manage Course Details</li>
                        </ol>
                    </div>
                </div>
            </div>
            <?php include(APPPATH . "views/diagnostic/error_message.php"); ?>
            <div class="row">
                <div class="col-8">
                    <div class="page-title-box">
                        <h4 class="page-title">Manage Course Details</h4>
                    </div>
                </div>
                <div class="col-md-4">
                </div>

            </div>
            <!-- end page title -->

            <div class="row">

                <div class="container">
                    <div id="exTab2" class="container">
                        <ul class="nav nav-tabs">
                            <li class="active nav-item">
                                <a href="#6" data-toggle="tab"><?= Diagnostic ?></a>
                            </li>
                        </ul>

                        <div class="tab-content ">
                            <div class="tab-pane active" id="6">
                                <?php
                                foreach ($result as $value) {
                                    if ($value->ss_aw_course_id == 6) {
                                ?>
                                        <h4 class="page-title parsley-examples"><?= $value->ss_aw_course_name; ?></h4>
                                        <p><?= $value->ss_aw_sort_description; ?></p>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->

    <?php
    include(APPPATH . 'views/diagnostic/bottombar.php');
    ?>

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->


<?php
include(APPPATH . 'views/diagnostic/footer.php')
?>
<style type="text/css">
    #exTab1 .tab-content {
        color: white;
        background-color: #428bca;
        padding: 5px 15px;
    }

    #exTab2 h3 {
        color: white;
        background-color: #428bca;
        padding: 5px 15px;
    }

    /* remove border radius for the tab */

    #exTab1 .nav-pills>li>a {
        border-radius: 0;
    }

    /* change border radius for the tab , apply corners on top*/

    #exTab3 .nav-pills>li>a {
        border-radius: 4px 4px 0 0;
    }

    #exTab3 .tab-content {
        color: white;
        background-color: #428bca;
        padding: 5px 15px;
    }



    .nav-tabs>li.active>a,
    .nav-tabs>li.active>a:focus,
    .nav-tabs>li.active>a:hover {
        color: #555;
        cursor: default;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }

    .nav-tabs>li>a {
        margin-right: 2px;
        line-height: 1.42857143;
        border: 1px solid transparent;
        border-radius: 4px 4px 0 0;
    }

    .nav>li>a {
        position: relative;
        display: block;
        padding: 10px 15px;
    }

    .page-subtitle {
        font-size: 1rem;
        font-weight: bold;
        margin: 0;
        line-height: 1.8rem;
        color: #323a46;
    }

    .topic-container {
        margin-left: 20px;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>