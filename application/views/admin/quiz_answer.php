<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>CrossWise | Alsowise</title>
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
        tr {
            margin: 0;
            padding: 0;
            border-collapse: collapse;
        }

        td {
            height: 50px;
            width: 50px;
            border: 1px solid black;
        }

        .topbox {
            display: flex;
            flex: 1;
            flex-direction: row;
        }

        #puzzelParent {
            display: flex;
            flex: 1;
            justify-content: center;
            align-items: center;
        }

        #hintsParent {
            display: flex;
            flex: 1;
            justify-content: left;
            padding-bottom: 20px;
            flex-direction: column;
        }

        #puzzel {
            text-align: center;
            margin: 0;
            padding: 0;
            border-collapse: collapse;
            border: 1px solid black;
        }

        .inputBox {
            width: 50px;
            height: 50px;
            text-align: center;
        }

        input {
            border: none;
        }

        .cell {
            position: relative;
        }

        .info_number {
            position: absolute;
            top: 0;
            left: 0;
            padding: 5px;
            color: red;
            font-weight: bold;
        }

        .label-input {
            flex: 9;
        }

        .button_contaner,
        .canvas-container {
            display: flex;
            justify-content: center;
        }

        .hints_indidual_container {
            display: flex;
            flex-direction: row;
        }

        #answer_output {
            display: flex;
            justify-content: center;
            /* padding-left: 95px; */
            flex-direction: column;

        }

        .copy_link {
            width: '100%';
            text-align: center;
            margin: 20px 0 0 0;
        }

        .button_container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
            align-items: center;
        }

        #sucess_answer,
        #wrong_answer {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: nowrap;
            flex-direction: column;
        }

        #sucess_answer h4 {
            color: green;
        }

        #wrong_answer h4 {
            color: red;
        }

        #sucess_answer a,
        #wrong_answer a {
            text-decoration: underline;
        }

        .blank_container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 500px;
            flex-direction: column;
        }

        #puzzel_answer_output {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .older {
            width: 100%;
            padding: 2px;
            text-align: center;
            background: #6e768e;
            color: #ffffff;
            font-weight: bold;
        }

        .show_name {
            font-size: 20px;
            list-style: none;
        }

        .show_name i {
            margin-right: 10px;
        }
        #notify_me{
            margin-right: 5px;
        }
        /* new css added */
        .page-title-box {
            display: flex;
            align-items: center;
        }
        .leaderboard-button {
            margin-left: 10px;
            cursor: pointer;
        }
        .modal-header > header {
            display: flex;
            flex-direction: column;
        }
        .modal-header > header p {
            margin-bottom: 0;
        }
        .leaderboard-modal > .modal-body ul {
            padding-left: 0;
            margin-left: 5px;
        }
        .leaderboard-modal > .modal-body li {
            border: 1px solid;
            border-width: 1px 1px 0 1px;
            font-size: 0.875rem;
            padding: 0;
            display: flex;
            align-items: stretch;
        }
        .leaderboard-modal > .modal-body li:nth-last-of-type(1) {
            border-bottom-width: 1px;
        }
        .leaderboard-modal > .modal-body li i {
            border-right: 1px solid;
            font-style: normal;
            padding: 2px 5px;
            margin-right: 5px;
            text-align: center;
            width: 30px;
        }
        .scroll-body {
            max-height: 300px;
            overflow: auto;
        }
        .notifyme-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .notifyme-wrapper .form-group, .notifyme-wrapper label {
            margin-bottom: 0;
        }
        .notifyme-wrapper + p {
            text-align: center;
            margin: 10px 0;
        }
        /**/
        @media (min-width:320px) {

            /* portrait e-readers (Nook/Kindle), smaller tablets @ 600 or @ 640 wide. */
            #puzzelParent {
                justify-content: center;
                margin-left: 0px;
                margin-bottom: 20px;
            }

            #answer_output {
                justify-content: center;
                padding-left: 0px;
                margin-bottom: 20px;
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
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="h-100" data-simplebar>

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <ul id="side-menu">

                        <?php
                        $i = 0;
                        foreach ($month_data as $key => $month_name) {
                        ?>
                            <?php
                            if ($i == 0) {
                            ?>
                                <li>
                                    <a href="#sidebarEcommerce_<?= $i; ?>" data-toggle="collapse">
                                        <i class="mdi mdi-puzzle"></i>
                                        <span> <?php echo $key; ?>&nbsp; (<?= count($month_name); ?>) </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarEcommerce_<?= $i; ?>">
                                        <ul class="nav-second-level">
                                            <?php foreach ($month_name as $value) {
                                            ?>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>puzzles/crosswise/<?php echo $value->ss_aw_challange_id; ?>"><?php echo $value->challange_name; ?></a>
                                                </li>
                                            <?php
                                            } ?>
                                        </ul>
                                    </div>
                                </li>
                                <?php
                            } else {
                                if ($i == 1) {
                                ?>
                                    <div class="older">
                                        Older CrossWise
                                    </div>
                                <?php
                                }
                                ?>

                                <li>
                                    <a href="#sidebarEcommerce_<?= $i; ?>" data-toggle="collapse">
                                        <i class="mdi mdi-puzzle"></i>
                                        <span> <?php echo $key; ?>&nbsp; (<?= count($month_name); ?>) </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarEcommerce_<?= $i; ?>">
                                        <ul class="nav-second-level">
                                            <?php foreach ($month_name as $value) {
                                            ?>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>puzzles/crosswise/<?php echo $value->ss_aw_challange_id; ?>"><?php echo $value->challange_name; ?></a>
                                                </li>
                                            <?php
                                            } ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php
                            }
                            ?>

                        <?php
                            $i++;
                        }
                        ?>
                    </ul>
                    <!-- <div class="older">
                        Older Corssword
                    </div> -->

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <?php
                                if (empty($quiz_answer_data)) {
                                    ?>
                                    <h4 class="page-title">CrossWise</h4>
                                    <?php
                                }
                                else{
                                    ?>
                                    <h4 class="page-title"><?= $quiz_answer_data->challange_name; ?></h4>
                                    <img class="leaderboard-button" src="<?= base_url(); ?>assets/images/podium.png" onclick="latherboardlist();">
                                    <?php
                                }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <?php
                    if (empty($quiz_answer_data)) {
                    ?>
                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">CrossWise Puzzle</h4>
                                </div>
                            </div>
                        </div> -->
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="blank_container">
                                            <!-- <h3>CrossWord Puzzle</h3> -->

                                            <!-- <h4 class="page-title">CrossWise Puzzle</h4>
                                            <br /> -->

                                            <img src="<?php echo base_url(); ?>assets/quiz_challange_templete/crossword_puzzle.png" alt="" height="300">

                                            <h5>CrossWise puzzles are among the most popular and challenging brain-teasers ever created, loved by enthusiasts all over the world, but especially by speakers of the English language.</h5>
                                            <h5>The ALSOWISE<sup>®</sup> CrossWise Puzzle challenges your grasp of grammar, vocabulary and general knowledge, but makes sure that you have FUN at the same time.</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <div class="card-body">
                                        <?php
                                        $answer_details = $quiz_answer_data->challange_answer;
                                        $item_details = json_decode($answer_details);

                                        $hints_details_json = $quiz_answer_data->challange_hints;
                                        $hints_details = json_decode($hints_details_json);
                                        /* echo "<pre>";
    print_r($hints_details);
    die(); */
                                        $vertical_options = array();
                                        $horizontal_options = array();
                                        if (!empty($hints_details)) {
                                            foreach ($hints_details as $key => $value) {
                                                if ($value[1] == 'V') {
                                                    $vertical_options[] = $value[0];
                                                } elseif ($value[1] == 'H') {
                                                    $horizontal_options[] = $value[0];
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div id="puzzelParent">
                                                    <table id="puzzel">
                                                    </table>
                                                </div>
                                            </div> <!-- end col-->
                                            <div class="col-lg-6 col-md-6 ">
                                                <div id="hintsParent">
                                                    <div id="hints">
                                                        <h5>Hints</h5>
                                                    </div>
                                                    <div id="hints_accross">
                                                        <div>
                                                            <h5>Across</h5>
                                                        </div>
                                                        <?php
                                                        if (!empty($horizontal_options)) {
                                                            foreach ($horizontal_options as $value) {
                                                        ?>
                                                                <?= $value; ?><br />
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <div>
                                                        <h5>Down</h5>
                                                    </div>
                                                    <div id="hints_down">

                                                        <?php
                                                        if (!empty($vertical_options)) {
                                                            foreach ($vertical_options as $value) {
                                                        ?>
                                                                <?= $value; ?><br />
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>

                                                </div>
                                            </div> <!-- end col-->

                                            <div class="col-lg-9">
                                                <div id="calendar"></div>
                                            </div> <!-- end col -->

                                        </div> <!-- end row -->
                                        <div class="row">

                                            <div class="col-12">
                                                <div class="button_container">
                                                    <button onclick="inputDetails()" id="answer_submit" class="btn btn-danger waves-effect waves-light mr-1">
                                                        Submit
                                                    </button>
                                                    <!-- <button onclick="" class="btn btn-danger waves-effect waves-light mr-1">
                                                    Know More
                                                </button> -->
                                                </div>
                                                <div class="col-12">
                                                    <div class="button_container">
                                                        <button onclick="likeQuiz('<?= $quiz_answer_data->ss_aw_challange_id; ?>','<?= $quiz_answer_data->like_count; ?>')" id="like_submit" class="btn btn-primary waves-effect waves-light mr-1"> <i class="mdi mdi-thumb-up-outline"></i>
                                                            Like (<span id="quiz_like_count"><?= $quiz_answer_data->like_count; ?></span>)
                                                        </button>
                                                    </div>
                                                </div>
                                                <div id="sucess_answer">
                                                    <h4>Congratulations! That was amazing.</h4>

                                                    <p>If you enjoyed this, you’ll have even more fun as you learn when you enrol in the ALSOWISE program. Visit our <a href="https://alsowise.com/"> website </a> to learn more.</p>
                                                </div>
                                                <div id="wrong_answer">
                                                    <h4>Better luck next time!</h4>

                                                    <p>If you enjoyed this, you’ll have even more fun as you learn when you enrol in the ALSOWISE program. Visit our <a href="https://alsowise.com/"> website </a> to learn more.</p>
                                                </div>
                                                <p class="text-center">If you would like to be alerted every time we post a new puzzle, please tick the box, and share your email ID.</p>
                                                <div class="notifyme-wrapper">
                                                    <input type="checkbox" name="notify_me" id="below_notify_me" class="mr-1" onclick="belowenableEmail();"><label for="notify_me">Notify me</label>
                                                    <div class="form-group">
                                                        <input type="text" name="email" id="below_participant_email" class="form-control ml-2" placeholder="Email" disabled onkeyup="belowenableSubmition(this.value);">
                                                    </div>
                                                    <div>
                                                        <button id="below_push_answer_submit" type="button" onclick="belowpushAnswer();" class="btn btn-blue waves-effect waves-light custom-color ml-3" disabled>Submit</button>
                                                    </div>
                                                </div>
                                                    <p>Please ignore if you have done so already.</p>
                                                    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div id="answer_output">
                                                    <div class="text-center">Answer</div>
                                                    <div>
                                                        <table id="puzzel_answer_output">

                                                        </table>
                                                    </div>

                                                </div>`
                                            </div>
                                        </div>

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div>
                            <!-- end col-12 -->
                        </div> <!-- end row -->
                    <?php
                    }
                    ?>

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-lg-right text-md-right text-center">
                            &copy; <script>
                                document.write(new Date().getFullYear())
                            </script> Alsowise. All rights reserved.
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

    <div id="crossword-correct-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="crossword_submit_modal">Congratulations!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="challange_id" id="challange_id">
                    <div class="form-row">
                        <div id="success_portion">
                            <p>The names of the first 10 participants who submit correct entries will appear on the Leader Board the following week. If you would like to have your name appear on our weekly Leader Board, pls share your name.</p>
                            <div class="form-group">
                                <input type="text" name="name" id="participant_name" class="form-control" placeholder="Name" onkeyup="enableSubmition(this.value);">
                            </div>    
                        </div>
                        
                        <div>
                            <p>If you would like to be alerted every time we post a new puzzle, please tick the box, and share your email ID.</p>
                            <input type="checkbox" name="notify_me" id="notify_me" onclick="enableEmail();"><label for="notify_me">Notify me</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" id="participant_email" class="form-control" placeholder="Email" disabled onkeyup="enableSubmition(this.value);">
                        </div>
                        <p>Please ignore if you have done so already.</p>
                        <div>
                            <button id="push_answer_submit" type="button" onclick="pushAnswer();" class="btn btn-blue waves-effect waves-light custom-color" disabled>Submit</button>
                        </div>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="latherboard-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content leaderboard-modal">
                <div class="modal-header bg-light">
                    <header>
                        <h4 class="modal-title" id="myCenterModalLabel">Leaderboard: <?= $quiz_answer_data->challange_name; ?></h4>
                        <p>Top 10 <?=winners?></p>
                    </header>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-2">
                    <?php
                    if (!empty($latherboard_list)) {
                    ?>
                        <ul>
                            <?php
                            foreach ($latherboard_list as $key => $value) {
                            ?>
                                <li class="show_name">
                                    <i><?= $key + 1; ?></i>
                                    <span><?= $value->ss_aw_participant_name; ?></span>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    <?php
                    }
                    else{
                        ?>
                        <p>No <?=Winners?> yet.</p>
                        <?php
                    }
                    ?>
                    <a href="javascript:void(0)" onclick="openallleaders();">See all <?=Winners?>.</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="all-latherboard-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content leaderboard-modal">
                <div class="modal-header bg-light ">
                    <header>
                    <h4 class="modal-title" id="myCenterModalLabel">Leaderboard: <?= $quiz_answer_data->challange_name; ?></h4>
                    <p>All <?=Winners?> of this week</p>
                    </header>   
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-2 scroll-body">
                    <?php
                    if (!empty($all_latherboard_list)) {
                    ?>
                        <ul>
                            <?php
                            foreach ($all_latherboard_list as $key => $value) {
                            ?>
                                <li class="show_name">
                                    <i><?= $key + 1; ?></i>
                                    <span><?= $value->ss_aw_participant_name; ?></span>
                                        
                                    </li>
                                    
                            <?php
                            }
                            ?>
                        </ul>
                    <?php
                    }
                    else{
                        ?>
                        <p>No <?=Winners?> yet for this week.</p>
                        <?php
                    }
                    ?>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- Vendor js -->
    <script src="<?php echo base_url(); ?>assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            document.getElementById("sucess_answer").style.display = "none";
            document.getElementById("wrong_answer").style.display = "none";
        });
    </script>

    <script type="text/javascript">
        const STRICT_EQUALITY_BROKEN = (a, b) => a === b;
        const STRICT_EQUALITY_NO_NAN = (a, b) => {
            if (typeof a == 'number' && typeof b == 'number' && '' + a == 'NaN' && '' + b == 'NaN')
                // isNaN does not do what you think; see +/-Infinity
                return true;
            else
                return a === b;
        };

        function deepEquals(a, b, areEqual = STRICT_EQUALITY_NO_NAN, setElementsAreEqual = STRICT_EQUALITY_NO_NAN) {
            /* compares objects hierarchically using the provided
               notion of equality (defaulting to ===);
               supports Arrays, Objects, Maps, ArrayBuffers */
            if (a instanceof Array && b instanceof Array)
                return arraysEqual(a, b, areEqual);
            if (Object.getPrototypeOf(a) === Object.prototype && Object.getPrototypeOf(b) === Object.prototype)
                return objectsEqual(a, b, areEqual);
            if (a instanceof Map && b instanceof Map)
                return mapsEqual(a, b, areEqual);
            if (a instanceof Set && b instanceof Set) {
                if (setElementsAreEqual === STRICT_EQUALITY_NO_NAN)
                    return setsEqual(a, b);
                else
                    throw "Error: set equality by hashing not implemented because cannot guarantee custom notion of equality is transitive without programmer intervention."
            }
            if ((a instanceof ArrayBuffer || ArrayBuffer.isView(a)) && (b instanceof ArrayBuffer || ArrayBuffer.isView(b)))
                return typedArraysEqual(a, b);
            return areEqual(a, b); // see note[1] -- IMPORTANT
        }

        function arraysEqual(a, b, areEqual) {
            if (a.length != b.length)
                return false;
            for (var i = 0; i < a.length; i++)
                if (!deepEquals(a[i], b[i], areEqual))
                    return false;
            return true;
        }

        function objectsEqual(a, b, areEqual) {
            var aKeys = Object.getOwnPropertyNames(a);
            var bKeys = Object.getOwnPropertyNames(b);
            if (aKeys.length != bKeys.length)
                return false;
            aKeys.sort();
            bKeys.sort();
            for (var i = 0; i < aKeys.length; i++)
                if (!areEqual(aKeys[i], bKeys[i])) // keys must be strings
                    return false;
            return deepEquals(aKeys.map(k => a[k]), aKeys.map(k => b[k]), areEqual);
        }

        function mapsEqual(a, b, areEqual) { // assumes Map's keys use the '===' notion of equality, which is also the assumption of .has and .get methods in the spec; however, Map's values use our notion of the areEqual parameter
            if (a.size != b.size)
                return false;
            return [...a.keys()].every(k =>
                b.has(k) && deepEquals(a.get(k), b.get(k), areEqual)
            );
        }

        function setsEqual(a, b) {
            // see discussion in below rest of StackOverflow answer
            return a.size == b.size && [...a.keys()].every(k =>
                b.has(k)
            );
        }

        function typedArraysEqual(a, b) {
            // we use the obvious notion of equality for binary data
            a = new Uint8Array(a);
            b = new Uint8Array(b);
            if (a.length != b.length)
                return false;
            for (var i = 0; i < a.length; i++)
                if (a[i] != b[i])
                    return false;
            return true;
        }



        $(document).ready(function() {
            updateInitializeScreen();
            document.getElementById("answer_output").style.display = "none";
            //document.getElementById("latherboard-modal").style.display = "block";
            let lather_count = <?= count($latherboard_list); ?>;
            $('#latherboard-modal').modal('show');
        });
        var create_quiz = new Array();
        var puzzelArrayData;

        function updatePuzzelArray() {
            var items = <?= json_encode([$item_details][0]); ?>;
            // console.log("@12", items)
            return items;
        }

        function updateInitializeScreen() {
            document.getElementById("puzzel").innerHTML = '';
            var puzzelTable = document.getElementById("puzzel");
            puzzelArrayData = updatePuzzelArray();

            for (var i = 0; i < puzzelArrayData.length; i++) {
                var row = puzzelTable.insertRow(-1);
                var rowData = puzzelArrayData[i];
                for (var j = 0; j < rowData.length; j++) {
                    var cell = row.insertCell(-1);
                    cell.setAttribute("class", "cell");
                    if (rowData[j] != 0) {
                        var txtID = String('txt' + '_' + i + '_' + j);
                        var spanID = String('span' + '_' + i + '_' + j);
                        if (puzzelArrayData[i][j] != '' && puzzelArrayData[i][j].length == 3) {
                            // console.log("====",  span_value[m].split(",")[0])
                            const hint_number = puzzelArrayData[i][j].split(",")[0].trim();
                            // document.getElementById(span_elms[m].id).innerHTML = hint_number;
                            console.log(puzzelArrayData[i][j].length, hint_number)
                            cell.innerHTML = '<span class=info_number id="' + spanID + '">' + hint_number + '</span><input type="text" class="inputBox" maxlength="1" style="text-transform: uppercase; font-weight:bold; font-size:16px" ' + 'id="' + txtID + '" >';
                        } else {
                            cell.innerHTML = '<span class=info_number id="' + spanID + '"></span><input type="text" class="inputBox" maxlength="1" style="text-transform: uppercase; font-weight:bold; font-size:16px" ' + 'id="' + txtID + '" >';
                        }
                    } else {
                        cell.style.backgroundColor = "black";

                    }
                }
            }
        }

        function inputDetails() {
            var ss_aw_challange_status = '';
            var submit_disable = document.getElementById("answer_submit");
            submit_disable.disabled = true;
            var elm = {};
            var elms = $("#puzzel input[type=text]")
            const createArray = [];


            //console.log("elms", elms);
            //for (var i = 0; i < elms.length; i++) {
            var elmCount = 0;
            var elmVal = "";
            var rowArr = null;
            for (var i = 0; i < puzzelArrayData.length; i++) {
                rowArr = [];
                for (var j = 0; j < puzzelArrayData[i].length; j++) {
                    //console.log("puzzelArrayData", puzzelArrayData[i][j])
                    elmVal = "";
                    if (puzzelArrayData[i][j] != "") {
                        //console.log(">>>", puzzelArrayData[i][j]);
                        elmVal = elms[elmCount].value.toLowerCase();
                        if (puzzelArrayData[i][j].length == 3) {
                            elmVal = puzzelArrayData[i][j].substr(0, 1) + "," + elmVal;
                        }

                        elmCount++;
                    }
                    rowArr.push(elmVal);
                }
                createArray.push(rowArr);
            }

            // var create_quiz = new Array();
            /*for (var i = 0; i < 6; i++) {
                create_quiz[i] = new Array();
                for (var j = (i * 6); j < 6 * i + 6; j++)
                    if (create_quiz[i] == null)
                        create_quiz[i] = createArray[j];
                    else
                        create_quiz[i].push(createArray[j]);
            }*/

            // console.log("====createArray====", createArray);
            // console.log("===puzzelArrayData=====", puzzelArrayData);

            if (deepEquals(puzzelArrayData, createArray)) {
                // alert("Congrats!");
                document.getElementById("sucess_answer").style.display = "flex";
                ss_aw_challange_status = 1;

            } else {
                //show answer
                answerScreen();
                document.getElementById("wrong_answer").style.display = "flex";
                ss_aw_challange_status = 2;
            }

            //console.log("puzzelArrayData", puzzelArrayData)
            //console.log("&&&&&&&&&&&&&-------", createArray)
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>admin/quiz_log_upload",
                data: {
                    ss_aw_challange_id: <?= $quiz_answer_data->ss_aw_challange_id; ?>,
                    ss_aw_challange_input: createArray,
                    ss_aw_challange_status: ss_aw_challange_status,
                },

                // dataType: "json",
                success: function(result) {
                    if (result) {
                        document.getElementById("challange_id").value = result;
                        $("#crossword-correct-modal").modal('show');
                        if (ss_aw_challange_status == 1) {
                            $("#success_portion").show();
                            $("#crossword_submit_modal").html("Congratulations!");
                        }
                        else{
                            $("#success_portion").hide();
                            $("#crossword_submit_modal").html("Better luck next time!");
                        }
                    }
                }
            });
        }

        function answerScreen() {
            //inputDetails();
            document.getElementById("answer_output").style.display = "flex";
            var puzzelTable = document.getElementById("puzzel_answer_output");
            puzzelArrayData = <?= json_encode([$item_details][0]); ?>;
            for (var i = 0; i < puzzelArrayData.length; i++) {
                var row = puzzelTable.insertRow(-1);
                var rowData = puzzelArrayData[i];
                for (var j = 0; j < rowData.length; j++) {
                    var cell = row.insertCell(-1);
                    cell.setAttribute("class", "cell");
                    if (rowData[j] != 0) {
                        var txtID = String('txt' + '_' + i + '_' + j);
                        var txtIDValue = String('txt' + '_' + i + '_' + j).value;
                        var spanID = String('span' + '_' + i + '_' + j);
                        if (puzzelArrayData[i][j] != '' && puzzelArrayData[i][j].length == 3) {
                            // console.log("====",  span_value[m].split(",")[0])
                            const hint_number = puzzelArrayData[i][j].split(",")[0].trim();
                            // document.getElementById(span_elms[m].id).innerHTML = hint_number;
                            console.log(puzzelArrayData[i][j].length, hint_number, txtIDValue)
                            cell.innerHTML = '<span class=info_number id="' + spanID + '">' + hint_number + '</span><input type="text" disabled class="inputBox" maxlength="1" style="text-transform: uppercase; font-weight:bold; font-size:16px" value="' + puzzelArrayData[i][j].split(",")[1].trim() + '" ' + 'id="' + txtID + '" onfocus="textInputFocus(' + "'" + txtID + "'" + ')">';
                        } else {
                            cell.innerHTML = '<span class=info_number id="' + spanID + '"></span><input type="text" class="inputBox" disabled maxlength="1" style="text-transform: uppercase; font-weight:bold; font-size:16px" ' + 'id="' + txtID + '" value="' + puzzelArrayData[i][j] + '" onfocus="textInputFocus(' + "'" + txtID + "'" + ')">';
                        }
                    } else {
                        cell.style.backgroundColor = "black";
                    }
                }
            }
        }

        function likeQuiz(challange_id, like_count) {
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/like_quiz",
                data: {
                    "challange_id": challange_id
                },
                success: function(data) {
                    var likes = parseInt(like_count) + 1;
                    $("#quiz_like_count").html(likes);
                    $("#like_submit").attr('disabled', true);
                    $("#like_submit i").removeClass('mdi-thumb-up-outline');
                    $("#like_submit i").addClass('mdi-thumb-up');
                }
            });
        }

        function pushAnswer() {
            var challange_id = document.getElementById('challange_id').value;
            var name = document.getElementById('participant_name').value;
            var email = document.getElementById('participant_email').value;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>admin/update_challange_log",
                data: {
                    challange_id: challange_id,
                    name: name,
                    email: email,
                },

                // dataType: "json",
                success: function(result) {
                    $("#crossword-correct-modal").modal('hide');
                    location.reload();
                }
            });
        }

        function belowpushAnswer() {
            var email = document.getElementById('below_participant_email').value;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>admin/update_challange_log",
                data: {
                    name: '',
                    email: email,
                },

                // dataType: "json",
                success: function(result) {
                    location.reload();
                }
            });
        }

        function enableEmail() {
            // Get the checkbox
            var checkBox = document.getElementById("notify_me");
            // If the checkbox is checked, display the output text
            if (checkBox.checked == true) {
                document.getElementById('participant_email').disabled = false;
            } else {
                document.getElementById('participant_email').value = '';
                document.getElementById('participant_email').disabled = true;
            }
        }

        function belowenableEmail() {
            // Get the checkbox
            var checkBox = document.getElementById("below_notify_me");
            // If the checkbox is checked, display the output text
            if (checkBox.checked == true) {
                document.getElementById('below_participant_email').disabled = false;
            } else {
                document.getElementById('below_participant_email').value = '';
                document.getElementById('below_participant_email').disabled = true;
            }
        }

        function latherboardlist() {
            $('#all-latherboard-modal').modal('hide');
            $('#latherboard-modal').modal('show');
        }

        function openallleaders(){
            $('#latherboard-modal').modal('hide');
            $('#all-latherboard-modal').modal('show');   
        }

        function enableSubmition(value){
            if (value.trim() != "") {
                $("#push_answer_submit").attr('disabled', false);
            }
            else{
                $("#push_answer_submit").attr('disabled', true);
            }
        }

        function belowenableSubmition(value){
            if (value.trim() != "") {
                $("#below_push_answer_submit").attr('disabled', false);
            }
            else{
                $("#below_push_answer_submit").attr('disabled', true);
            }
        }
    </script>

</body>

</html>