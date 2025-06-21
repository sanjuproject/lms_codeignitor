

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
                                <ol class="breadcrumb mb-2">
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/manageparents">Manage Parents</a></li>
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/parentdetail/<?= $parent_id; ?>"><?= $parent_details[0]->ss_aw_parent_full_name; ?></a></li>
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/child_course_details/<?= $parent_id; ?>/<?= $child_id; ?>"><?= $child_details->ss_aw_child_nick_name; ?></a></li>
                                    <li class="breadcrumb-item active"><a href="<?= base_url(); ?>admin/lesson_quiz_details/<?= $parent_id; ?>/<?= $child_id; ?>/<?= $lesson_id ?>">Lesson Details</a></li>
                                </ol>
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
                                <h4 class="details-title">Lesson Topic Name: <span><?= $lesson_details[0]->ss_aw_lesson_topic; ?></span></h4>
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
                                                        if (!empty($lesson_details)) {
                                                            $count = 0;
                                                            foreach ($lesson_details as $key => $value) {
                                                                $count = $count + 1;
                                                                ?>
                                                                <tr class="gradeX <?= $count % 2 == 0 ? 'blocked-row-bg' : ''; ?>" id="<?= $count; ?>">
                                                                    <td class="center"><?= $count; ?></td>
                                                                    <td class="center">
                                                                    <?php
                                                                    if ($value->ss_aw_lesson_format_type == 7) {
                                                                        

                                                                        echo $value->ss_aw_question;
                                                                    
                                                                        if (!empty($value->ss_aw_lesson_question_options)) {
                                                                            $optins_ary = explode("/", $value->ss_aw_lesson_question_options);
                                                                            ?>
                                                                            <ul>
                                                                            <?php
                                                                            foreach ($optins_ary as $option) {
                                                                                ?>
                                                                                <li><?= $option; ?></li>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            </ul>
                                                                            <?php
                                                                            
                                                                        }
                                                                    
                                                                    }
                                                                    else{
                                                                        if (!empty($value->ss_aw_lesson_title)) {
                                                                            echo $value->ss_aw_lesson_title."<br/>";     
                                                                        }
                                                                        echo $value->ss_aw_question;
                                                                    }
                                                                     
                                                                    ?> 
                                                                    </td>
                                                                    <td class="center"><?= $value->ss_aw_lesson_answers; ?></td>
                                                                    <td class="center"><?= $value->ss_aw_post_answer; ?></td>
                                                                    <td class="center"><?= $value->ss_aw_answer_status == 1 ? "C" : "I"; ?></td>
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