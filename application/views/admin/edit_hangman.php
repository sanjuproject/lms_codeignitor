<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/quiz_list">Quiz List</a></li>

                            <li class="breadcrumb-item active"><?= $quiz_details->challange_name; ?></li>
                        </ol>

                    </div>
                </div>
            </div>    
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Wordwise Update</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php include "error_message.php"; ?>
            <!-------------------------  -->

            <!-- ------------------ -->

            <div class="row">
                <div class="col-12">
                    <form method="post" action="<?= base_url(); ?>admin/update_hangman" id="demo-form" data-parsley-validate="">
                        <input type="hidden" name="record_id" value="<?= $quiz_details->ss_aw_challange_id; ?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="quiz_name_container">
                                <div class="label-input mb-3">
                                    <label for="emailaddress">Name</label>
                                    <input class="form-control" type="text" name="quiz_name" id="quiz_name" placeholder="Quiz Name" value="<?= $quiz_details->challange_name; ?>" required>
                                </div>
                            </div>

                            <div class="quiz_name_container">
                                <div class="label-input mb-3">
                                    <label for="quiz_question">Question</label>
                                    <input class="form-control" type="text" name="quiz_question" id="quiz_question" placeholder="Question.." value="<?= $quiz_details->challange_image; ?>" required>
                                </div>
                            </div>

                            <div class="quiz_name_container">
                                <div class="label-input mb-3">
                                    <label for="quiz_answer">Answer</label>
                                    <input class="form-control" type="text" name="quiz_answer" id="quiz_answer" placeholder="Answer.." value="<?= $quiz_details->challange_answer ?>" required>
                                </div>
                            </div>

                            <div class="quiz_name_container">
                                <div class="label-input mb-3">
                                    <label for="quiz_hint">Hint</label>
                                    <input class="form-control" type="text" name="quiz_hint" id="quiz_hint" placeholder="Hint.." value="<?= $quiz_details->challange_hints; ?>" required>
                                </div>
                            </div>

                            <div class="quiz_name_container">
                                <div class="label-input mb-3">
                                    <label for="quiz_meaning">Meaning</label>
                                    <input class="form-control" type="text" name="quiz_meaning" id="quiz_meaning" placeholder="Meaning.." value="<?= $quiz_details->challange_meaning; ?>" required>
                                </div>
                            </div>
                            

                            <div class="col-lg-2">
                                <div class="text-lg-center">
                                    <button type="submit" id="add_button" class="btn btn-danger waves-effect waves-light mr-1"><i class="mdi mdi-plus-circle mr-1"></i>Update</button>
                                </div>
                            </div>
                        </div> <!-- end card disabled -->
                    </div><!-- end col-->
                    </form>
                    <div>

                    </div>
                </div>

            </div> <!-- container -->

        </div> <!-- content -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->
<?php
include 'footer.php'
?>


</body>

</html>