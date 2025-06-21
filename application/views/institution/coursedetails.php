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
            <?php include("error_message.php"); ?>
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
                                <a href="#1" data-toggle="tab"><?= Winners ?></a>
                            </li>
                            <!-- <li class="nav-item">
                    <a href="#2" data-toggle="tab"><?= Champions ?></a>
                </li> -->
                            <li class="nav-item">
                                <a href="#3" data-toggle="tab"><?= Master ?>s</a>
                            </li>
                        </ul>

                        <div class="tab-content ">
                            <div class="tab-pane active" id="1">
                                <?php
                                foreach ($result as $value) {
                                    if ($value->ss_aw_course_id == 1) {
                                ?>
                                        <h4 class="page-title parsley-examples"><?= $value->ss_aw_course_name; ?></h4>
                                        <p><?= $value->ss_aw_sort_description; ?></p>
                                    <?php
                                    }
                                }
                                if (!empty($winners_lesson_listary)) {
                                    foreach ($winners_lesson_listary as $key => $value) {
                                    ?>
                                        <div class="topic-container">
                                            <h5 class="page-subtitle"><?= $value['ss_aw_lesson_topic']; ?></h5>
                                            <?php
                                            if ($value['ss_aw_lesson_format'] == 'Multiple') {
                                            ?>
                                                <p>Topic-agnostic modules that are meant to test the student's retention of all the topical lessons that he/ she has already completed as part of the ALSOWISE® Programme. Each lesson/ assessment begins with a short reading comprehension quiz, and is followed by other quiz sections that test the student's dexterity in such areas as sentence sequencing, error identification and word puzzles.</p>
                                            <?php
                                            } else {
                                            ?>
                                                <p><?= $value['ss_aw_topic_description']; ?></p>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="tab-pane" id="2">
                                <?php
                                foreach ($result as $value) {
                                    if ($value->ss_aw_course_id == 3) {
                                ?>
                                        <h4 class="page-title parsley-examples"><?= $value->ss_aw_course_name; ?></h4>
                                        <p><?= $value->ss_aw_sort_description; ?></p>
                                    <?php
                                    }
                                }
                                if (!empty($champions_lesson_listary)) {
                                    foreach ($champions_lesson_listary as $key => $value) {
                                    ?>
                                        <div class="topic-container">
                                            <h5 class="page-subtitle"><?= $value['ss_aw_lesson_topic']; ?></h5>
                                            <?php
                                            if ($value['ss_aw_lesson_format'] == 'Multiple') {
                                            ?>
                                                <p>Topic-agnostic modules that are meant to test the student's retention of all the topical lessons that he/ she has already completed as part of the ALSOWISE® Programme. Each lesson/ assessment begins with a short reading comprehension quiz, and is followed by other quiz sections that test the student's dexterity in such areas as sentence sequencing, error identification and word puzzles.</p>
                                            <?php
                                            } else {
                                            ?>
                                                <p><?= $value['ss_aw_topic_description']; ?></p>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="tab-pane" id="3">
                                <?php
                                foreach ($result as $value) {
                                    if ($value->ss_aw_course_id == 5) {
                                ?>
                                        <h4 class="page-title parsley-examples"><?= $value->ss_aw_course_name; ?></h4>
                                        <p><?= $value->ss_aw_sort_description; ?></p>
                                    <?php
                                    }
                                }
                                if (!empty($masters_lesson_listary)) {
                                    foreach ($masters_lesson_listary as $key => $value) {
                                    ?>
                                        <div class="topic-container">
                                            <h5 class="page-subtitle"><?= $value['ss_aw_lesson_topic']; ?></h5>
                                            <?php
                                            if ($value['ss_aw_lesson_format'] == 'Multiple') {
                                            ?>
                                                <p>Topic-agnostic modules that are meant to test the student's retention of all the topical lessons that he/ she has already completed as part of the ALSOWISE® Programme. Each lesson/ assessment begins with a short reading comprehension quiz, and is followed by other quiz sections that test the student's dexterity in such areas as sentence sequencing, error identification and word puzzles.</p>
                                            <?php
                                            } else {
                                            ?>
                                                <p><?= $value['ss_aw_topic_description']; ?></p>
                                            <?php
                                            }
                                            ?>
                                        </div>
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
    include('bottombar.php');
    ?>

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->


<?php
include('footer.php')
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