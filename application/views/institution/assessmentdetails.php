

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
                            <div class="page-title-left" style="padding: 20px 0px;">
                                <a href="javascript:void(0)" onclick="history.go(-1);" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                <div class="row parent-details-body">

                                <div class="col-6">
                                
                                <h4 class="details-title">Assessment Topic Name: <span><?= $assessment_details[0]->ss_aw_assesment_topic; ?></span></h4>
                               </div>


                               
                               <table class="table" id="example1">
                                         
													<thead>
														<tr>
                                                            <th>Question Level</th>
                                                            <th>Question #</th>
                                                            <th>Question</th>
															<th>Correct Answer</th>
						                                    <th>Answer Given</th>
                                                            <th>Correct/Incorrect (C/I)</th>
                                                            <th>Weight</th>
														</tr>
													</thead>
													<tbody>
                                                        <?php
                                                        if (!empty($question_details)) {
                                                            $count = 0;
                                                            foreach ($question_details as $key => $value) {
                                                                $count = $count + 1;
                                                                ?>
                                                                <tr class="gradeX <?= $count % 2 == 0 ? 'blocked-row-bg' : ''; ?>" id="<?= $count; ?>">
                                                                    <td class="center"><?= $value->question_level; ?></td>
                                                                    <td class="center"><?= $count; ?></td>
                                                                    <td class="center"><?= $value->question_preface; ?><br/><?= $value->question; ?></td>
                                                                    <td class="center"><?= $value->answers; ?></td>
                                                                    <td class="center"><?= $value->given_answer ?></td>
                                                                    <td class="center"><?= $value->answer_status == 1 ? "C" : "I"; ?></td>
                                                                    <td class="center"><?= $value->weight; ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
													</tbody>
												</table>
                                    </div>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>

                  



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




    <style type="text/css">
    .verification-parent {
        position: relative;
    }

    .verification-btn {
        position: absolute;
        top: 7px;
        right: 1px;
        background: #fff;
        padding: 0px 8px;

    }

    input:disabled,
    select:disabled {
        /* background: #e6e6e6; */
        color: #d5dade;
    }
    </style>


    <?php
            include('footer.php')
        ?>


</body>

</html>