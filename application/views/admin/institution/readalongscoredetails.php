<!DOCTYPE html>
<html lang="en">



        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-left">
                                <ol class="breadcrumb mb-2">
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/view_institution/<?= $institution_details->ss_aw_id; ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/institutionreportdashboard/<?= $institution_details->ss_aw_id; ?>">Report Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/readalog_count/<?= $institution_details->ss_aw_id; ?>">Readalong Count</a></li>
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/getallreadalongdata/<?= $child_details[0]->ss_aw_child_id; ?>/<?= $institution_details->ss_aw_id; ?>">Readalong Details</a></li>
                                    <li class="breadcrumb-item"><?= $readalong_details[0]->ss_aw_title; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                <div class="row parent-details-body">

                                <div class="col-4">
                                    <h4 class="details-title">User Name: <span><?= $child_details[0]->ss_aw_child_nick_name; ?></span></h4>
                                </div>

                                <div class="col-4">
                                    <h4 class="details-title">Readalong Title: <span><?= $readalong_details[0]->ss_aw_title; ?></span></h4>
                                </div>

                                <div class="col-4">
                                    
                                </div>

                               
                               <table class="table" id="example1">
                                         
													<thead>
														<tr>
                                                            <th>Question #</th>
                                                            <th>Question</th>
															<th>Correct Answer</th>
						                                    <th>Answer Given</th>
                                                            <th>Correct/Incorrect (C/I)</th>
														</tr>
													</thead>
													<tbody>
                                                        <?php
                                                        if ($question_details) {
                                                            $count = 0;
                                                            foreach ($question_details as $key => $value) {
                                                                $count = $count + 1;
                                                                ?>
                                                                <tr class="gradeX <?= $count % 2 == 0 ? 'blocked-row-bg' : ''; ?>" id="<?= $count; ?>">
                                                                    <td class="center"><?= $count; ?></td>
                                                                    <td class="center"><?= $value->ss_aw_details ?><br/><?= $value->ss_aw_question; ?></td>
                                                                    <td class="center"><?= $value->ss_aw_answers; ?></td>
                                                                    <td class="center"><?= $value->ss_aw_quiz_ans_post; ?></td>
                                                                    <td class="center"><?= $value->ss_aw_quiz_right_wrong == 1 ? "C" : "I"; ?></td>
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

    <!-- Validation init js-->
    <script src="./assets/js/pages/form-validation.init.js"></script>


</body>

</html>