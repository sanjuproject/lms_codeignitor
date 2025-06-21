<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>WordWise | Alsowise</title>
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
                                                    <a href="<?php echo base_url(); ?>puzzles/wordwise/<?php echo $value->ss_aw_challange_id; ?>"><?php echo $value->challange_name; ?></a>
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
                                        Older WordWise
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
                                                    <a href="<?php echo base_url(); ?>puzzles/wordwise/<?php echo $value->ss_aw_challange_id; ?>"><?php echo $value->challange_name; ?></a>
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
                                <h4 class="page-title"><?= $quiz_data_details->challange_name ? $quiz_data_details->challange_name : 'WordWise'; ?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <?php
                    if (empty($quiz_data_details)) {
                    ?>
                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">WordWise Puzzle</h4>
                                </div>
                            </div>
                        </div> -->
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="blank_container make-center">
                                            <!-- <h3>CrossWord Puzzle</h3> -->

                                            <!-- <h4 class="page-title">WordWise Puzzle</h4>
                                            <br /> -->

                                            <img src="<?php echo base_url(); ?>assets/quiz_challange_templete/wordwise_puzzle.png" alt="" height="300">

                                            <h5>WordWise puzzles are among the most popular and challenging brain-teasers ever created, loved by enthusiasts all over the world, but especially by speakers of the English language.</h5>
                                            <h5>The ALSOWISE<sup>®</sup> WordWise Puzzle challenges your grasp of vocabulary, word usage and general language skills, but makes sure that you have fun at the same time.</h5>
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- <h4 class="text-center"><?= $quiz_data_details->challange_name; ?></h4> -->

                                            <img id="live_image" src="<?php echo base_url(); ?>assets/quiz_challange_templete/img_6.jpg" alt="" height="200" class="center">
                                        </div>
                                        <div class="col-md-12 mt-5">
                                            <h3 id="catagoryName" class="text-center"></h3>
                                            <p id="clue" class="text-center"></p>
                                        </div>

                                        <!-- <div class="col-md-12 mt-2">
                                            <div class="wrapper" style="margin:auto 0; width:100%; text-align:center">

                                                <input type="text" class="inputBox" maxlength="1" style="text-transform: uppercase; font-weight:bold; font-size:16px; border:2px solid #000; border-radius:3px; width:50px; height:50px; text-align:center;margin-right: 15px !important; margin : auto;" id="h_01" />
                                            </div>
                                        </div> -->

                                        <!-- <div class="wrapper"> -->
                                        <!-- <h1>Hangman</h1> -->
                                        <!-- <h2>Vanilla JavaScript Hangman Game</h2> -->
                                        <!-- <p>Use the alphabet below to guess the word, or click hint to get a clue. </p> -->
                                        <!-- </div> -->
                                        <div class="wrapper">

                                            <!-- <p id="catagoryName"></p> -->
                                            <div id="hold">
                                            </div>
                                            <div id="buttons">
                                            </div>
                                            <div class="col-md-12 mt-5">
                                                <h3 id="mylives" class="text-center"></h3>
                                                <div id="answer_show" class="text-center"></div>
                                                <div id="meaning_show" class="text-center"></div>
                                            </div>
                                            <!-- <p id="mylives"></p> -->
                                            <!-- <p id="clue">Clue -</p> -->
                                            <canvas id="stickman">This Text will show if the Browser does NOT support HTML5 Canvas tag</canvas>
                                            <!-- <div class="container"> -->
                                            <!-- <button id="hint">Hint</button> -->
                                            <!-- <button id="reset">Play again</button> -->
                                            <!-- </div> -->
                                        </div>

                                    </div> <!-- end row -->
                                    <div class="row">

                                        <div class="col-12">
                                            <div class="button_container text-center mt-4">
                                                <button id="hint" class="btn btn-secondary waves-effect waves-light mr-1">
                                                    Hint
                                                </button>
                                                <button id="reset" class="btn btn-success waves-effect waves-light mr-1">
                                                    Play again
                                                </button>
                                                <button onclick="likeQuiz('<?= $quiz_data_details->ss_aw_challange_id; ?>','<?= $quiz_data_details->like_count; ?>')" id="like_submit" class="btn btn-primary waves-effect waves-light mr-1"> <i class="mdi mdi-thumb-up-outline"></i>
                                                    Like (<span id="quiz_like_count"><?= $quiz_data_details->like_count; ?></span>)
                                                </button>

                                                <button id="share_hangman" data-toggle="modal" data-target="#exampleModal" id="like_submit" class="btn btn-primary waves-effect waves-light mr-1"> <i class="mdi mdi-share-variant"></i>
                                                    Share
                                                </button>
                                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                    Launch demo modal
                                                </button> -->

                                            </div>

                                            <div id="sucess_answer">
                                                <h4>Congratulations! That was amazing.</h4>

                                                <p>If you enjoyed this, you’ll have even more fun as you learn when you enrol in the ALSOWISE program. Visit our <a href="https://alsowise.com/"> website </a> to learn more.</p>

                                            </div>
                                            <div id="wrong_answer">
                                                <h4>Better luck next time!</h4>

                                                <p>If you enjoyed this, you’ll have even more fun as you learn when you enrol in the ALSOWISE program. Visit our <a href="https://alsowise.com/"> website </a> to learn more.</p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div id="answer_output">
                                                <!-- <div id="answer_show" class="text-center">Answer</div> -->
                                                <!-- <div>
                                                    <table id="puzzel_answer_output">

                                                    </table>
                                                </div> -->

                                            </div>
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
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="hangman_link_copy" class="modal-body">
                        I completed <span style="font-weight: bold;"><?= $quiz_data_details->challange_name; ?></span> with <span id="number_of_tries"></span> lives to spare. How did you fare?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary copy_link">Copy Link</button>
                    </div>
                </div>
            </div>
        </div>

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

    </div>
    <!-- END wrapper -->

    <!-- Vendor js -->
    <script src="<?php echo base_url(); ?>assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            document.getElementById("sucess_answer").style.display = "none";
            document.getElementById("wrong_answer").style.display = "none";
            document.getElementById("stickman").style.display = "none";
            document.getElementById("share_hangman").style.display = "none";
            document.getElementById("hint").style.display = "none";
        });
    </script>

    <script type="text/javascript">
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
            var name = '';
            var email = document.getElementById('participant_email').value;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>admin/update_challange_log",
                data: {
                    challange_id: 0,
                    name: name,
                    email: email,
                },

                // dataType: "json",
                success: function(result) {
                    $("#crossword-correct-modal").modal('hide');
                    //document.getElementById("crossword-correct-modal").style.display = "none";
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

        window.onload = function() {

            var alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
                'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
                't', 'u', 'v', 'w', 'x', 'y', 'z'
            ];

            var categories; // Array of topics
            var chosenCategory; // Selected catagory
            var getHint; // Word getHint
            var word; // Selected word
            var guess; // Geuss
            var geusses = []; // Stored geusses
            var lives; // Lives
            var counter; // Count correct geusses
            var space; // Number of spaces in word '-'
            var tries=0; // number of tries


            // Get elements
            var showLives = document.getElementById("mylives");
            var showCatagory = document.getElementById("scatagory");
            var getHint = document.getElementById("hint");
            var showClue = document.getElementById("clue");
            var liveImage = document.getElementById("live_image");
            var answer_show = document.getElementById("answer_show");
            var meaning_show = document.getElementById("meaning_show");

            // create alphabet ul
            var buttons = function() {
                myButtons = document.getElementById('buttons');
                letters = document.createElement('ul');
                for (var i = 0; i < alphabet.length; i++) {
                    letters.id = 'alphabet';
                    list = document.createElement('li');
                    list.id = 'letter';
                    list.innerHTML = alphabet[i];
                    check();
                    myButtons.appendChild(letters);
                    letters.appendChild(list);
                }
            }


            // Select Catagory
            var selectCat = function() {
                if (chosenCategory === categories[0]) {
                    // catagoryName.innerHTML = "The Chosen Category Is Premier League Football Teams";
                    catagoryName.innerHTML = "<?php echo $quiz_data_details->challange_image; ?>";
                }
                // } else if (chosenCategory === categories[1]) {
                //     catagoryName.innerHTML = "The Chosen Category Is Films";
                // } else if (chosenCategory === categories[2]) {
                //     catagoryName.innerHTML = "The Chosen Category Is Cities";
                // }
            }

            // Create geusses ul
            result = function() {
                wordHolder = document.getElementById('hold');
                correct = document.createElement('ul');

                for (var i = 0; i < word.length; i++) {
                    correct.setAttribute('id', 'my-word');
                    guess = document.createElement('li');
                    guess.setAttribute('class', 'guess');
                    if (word[i] === "-") {
                        guess.innerHTML = "-";
                        space = 1;
                    } else {
                        guess.innerHTML = "";
                    }
                    geusses.push(guess);
                    wordHolder.appendChild(correct);
                    correct.appendChild(guess);
                }
            }

            // Show lives
            comments = function() {
                var cursorEle = document.getElementById("alphabet").getElementsByTagName("li");
                showLives.innerHTML = "You have " + lives + " lives remaining";
                document.getElementById('number_of_tries').innerHTML = lives;
                if (lives == 5) {
                    liveImage.src = "<?php echo base_url(); ?>assets/quiz_challange_templete/img_5.jpg";
                } else if (lives == 4) {
                    liveImage.src = "<?php echo base_url(); ?>assets/quiz_challange_templete/img_4.jpg";
                } else if (lives == 3) {
                    liveImage.src = "<?php echo base_url(); ?>assets/quiz_challange_templete/img_3.jpg";
                } else if (lives == 2) {
                    liveImage.src = "<?php echo base_url(); ?>assets/quiz_challange_templete/img_2.jpg";
                    hints = [
                        ["<?php echo $quiz_data_details->challange_hints; ?>"],
                          
                    ];

                    var catagoryIndex = categories.indexOf(chosenCategory);
                    var hintIndex = chosenCategory.indexOf(word);
                    showClue.innerHTML = "Clue: " + hints[catagoryIndex][hintIndex];
                    //document.getElementById("hint").style.display = "block";
                } else if (lives == 1) {
                    liveImage.src = "<?php echo base_url(); ?>assets/quiz_challange_templete/img_1.jpg";
                }

                if (lives < 1) {
                    showLives.innerHTML = "Game Over";
                    liveImage.src = "<?php echo base_url(); ?>assets/quiz_challange_templete/img_0.jpg";
                    cursorEle.forEach(i => i.style.pointerEvents = 'none')
                    
                    tries = tries + 1;
                }
                for (var i = 0; i < geusses.length; i++) {
                    if (counter + space === geusses.length) {
                        showLives.innerHTML = "You Win!";
                    }
                }
                if( showLives.innerHTML == 'You Win!'){

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>admin/quiz_log_upload",
                        data: {
                            ss_aw_challange_id: <?= $quiz_data_details->ss_aw_challange_id; ?>,
                            ss_aw_challange_input: '',
                            ss_aw_challange_status: 1,
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
                    document.getElementById("share_hangman").style.display = "block";

                    document.getElementById("challange_id").value = result;
                    $("#crossword-correct-modal").modal('show');
                    $("#crossword_submit_modal").html("Congratulations!");
                }

                if( showLives.innerHTML == 'Game Over'){

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>admin/quiz_log_upload",
                        data: {
                            ss_aw_challange_id: <?= $quiz_data_details->ss_aw_challange_id; ?>,
                            ss_aw_challange_input: '',
                            ss_aw_challange_status: 2,
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
                    // document.getElementById("share_hangman").style.display = "block";
                    answer_show.innerHTML = word.toUpperCase()+" - "+"<?= $quiz_data_details->challange_meaning ?>";
                    // meaning_show.innerHTML = "Meaning: - " + "<?= $quiz_data_details->challange_meaning ?>";
                    document.getElementById("challange_id").value = result;
                    $("#crossword-correct-modal").modal('show');
                    $("#crossword_submit_modal").html("Better luck next time!");
                }
                

            }
            $(".copy_link").click(function() {
                
                var url = "<?php echo $quiz_url; ?>";
                console.log(url)
                var copyText = $('#hangman_link_copy').text().trim()+"   <?php echo $quiz_url; ?>";
                
                navigator.clipboard.writeText(copyText);
                $('#exampleModal').modal('toggle');

                
            });


            // Animate man
            var animate = function() {
                var drawMe = lives;
                drawArray[drawMe]();
            }


            // Hangman
            canvas = function() {

                myStickman = document.getElementById("stickman");
                context = myStickman.getContext('2d');
                context.beginPath();
                context.strokeStyle = "#fff";
                context.lineWidth = 2;
            };

            head = function() {
                myStickman = document.getElementById("stickman");
                context = myStickman.getContext('2d');
                context.beginPath();
                context.arc(60, 25, 10, 0, Math.PI * 2, true);
                context.stroke();
            }

            draw = function($pathFromx, $pathFromy, $pathTox, $pathToy) {

                context.moveTo($pathFromx, $pathFromy);
                context.lineTo($pathTox, $pathToy);
                context.stroke();
            }

            frame1 = function() {
                draw(0, 150, 150, 150);
            };

            frame2 = function() {
                draw(10, 0, 10, 600);
            };

            frame3 = function() {
                draw(0, 5, 70, 5);
            };

            frame4 = function() {
                draw(60, 5, 60, 15);
            };

            torso = function() {
                draw(60, 36, 60, 70);
            };

            rightArm = function() {
                draw(60, 46, 100, 50);
            };

            leftArm = function() {
                draw(60, 46, 20, 50);
            };

            rightLeg = function() {
                draw(60, 70, 100, 100);
            };

            leftLeg = function() {
                draw(60, 70, 20, 100);
            };

            drawArray = [rightLeg, leftLeg, rightArm, leftArm, torso, head, frame4, frame3, frame2, frame1];


            // OnClick Function
            check = function() {
                list.onclick = function() {
                    var geuss = (this.innerHTML);
                    this.setAttribute("class", "active");
                    this.onclick = null;
                    for (var i = 0; i < word.length; i++) {
                        if (word[i] === geuss) {
                            geusses[i].innerHTML = geuss;
                            counter += 1;
                        }
                    }
                    var j = (word.indexOf(geuss));
                    if (j === -1) {
                        lives -= 1;
                        comments();
                        animate();
                    } else {
                        comments();
                    }
                }
            }


            // Play
            play = function() {
                categories = [
                    // ["everton", "liverpool", "swansea", "chelsea", "hull", "manchester-city", "newcastle-united"],
                    ["<?php echo $quiz_data_details->challange_answer; ?>".toLowerCase()]
                    // ["alien", "dirty-harry", "gladiator", "finding-nemo", "jaws"],
                    // ["manchester", "milan", "madrid", "amsterdam", "prague"]
                ];

                chosenCategory = categories[Math.floor(Math.random() * categories.length)];
                word = chosenCategory[Math.floor(Math.random() * chosenCategory.length)];
                word = word.replace(/\s/g, "-");
                // console.log(word);
                buttons();

                geusses = [];
                lives = 6;
                counter = 0;
                space = 0;
                result();
                comments();
                selectCat();
                canvas();
            }

            play();

            // Hint

            hint.onclick = function() {

                hints = [
                    ["<?php echo $quiz_data_details->challange_hints; ?>"],
                    // ["Based in Mersyside", "Based in Mersyside", "First Welsh team to reach the Premier Leauge", "Owned by A russian Billionaire", "Once managed by Phil Brown", "2013 FA Cup runners up", "Gazza's first club"],
                    // ["Science-Fiction horror film", "1971 American action film", "Historical drama", "Anamated Fish", "Giant great white shark"],
                    // ["Northern city in the UK", "Home of AC and Inter", "Spanish capital", "Netherlands capital", "Czech Republic capital"]  
                ];

                var catagoryIndex = categories.indexOf(chosenCategory);
                var hintIndex = chosenCategory.indexOf(word);
                showClue.innerHTML = "Clue: - " + hints[catagoryIndex][hintIndex];
            };

            // Reset

            document.getElementById('reset').onclick = function() {
                document.getElementById("share_hangman").style.display = "none";
                document.getElementById("hint").style.display = "none";
                document.getElementById("answer_show").style.display = "none";
                document.getElementById("meaning_show").style.display = "none";
                correct.parentNode.removeChild(correct);
                letters.parentNode.removeChild(letters);
                showClue.innerHTML = "";
                context.clearRect(0, 0, 400, 400);
                play();
            }
        }

        function enableSubmition(value){
            if (value.trim() != "") {
                $("#push_answer_submit").attr('disabled', false);
            }
            else{
                $("#push_answer_submit").attr('disabled', true);
            }
        }
    </script>

</body>

</html>