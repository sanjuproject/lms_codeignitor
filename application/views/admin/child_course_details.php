        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="col-md-12">
                        <div class="page-title-left">
                            <ol class="breadcrumb mb-2">
                                <li class="breadcrumb-item active"><a href="<?= base_url(); ?>admin/manageparents">Manage Parents</a></li>
                                <li class="breadcrumb-item active"><a href="<?= base_url(); ?>admin/parentdetail/<?= $parent_id; ?>"><?= $parent_details[0]->ss_aw_parent_full_name; ?></a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/child_course_details/<?= $parent_id; ?>/<?= $child_id; ?>"><?= $child_details->ss_aw_child_nick_name; ?></a></li>
                            </ol>
                        </div>
                    </div>
                    
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                <div class="row parent-details-body">

                               <div class="col-4">
                                <h4 class="details-title">Child Name: <span><?= $child_details->ss_aw_child_nick_name; ?>(<?= $child_details->ss_aw_child_username ? $child_details->ss_aw_child_username : $child_details->ss_aw_child_code; ?>)</span></h4>
                                <h4 class="details-title">Date of first signin: <span><?php
                                if (!empty($login_details)) {
                                	echo date('d/m/Y', strtotime($login_details[0]->ss_aw_first_login));
                                }
                            ?></span></h4>
                                <h4 class="details-title">Student age: <span><?= calculate_age($child_details->ss_aw_child_dob); ?> yrs (<?= date('d/m/Y', strtotime($child_details->ss_aw_child_dob)); ?>)</span></h4>
                                
                               </div>

                               <div class="col-4">
                                    <h4 class="details-title">Type of device: <span><?= $child_details->ss_aw_device_type; ?></span></h4>
                                    <h4 class="details-title">Course enrolled: <span>
                                    	<?php
                                    	if (!empty($child_details->course)) {
                                    		if ($child_details->course == 1 || $child_details->course == 2) {
                                    			echo Winners;
                                    		}
                                    		elseif ($child_details->course == 3) {
                                    			echo Champions;
                                    		}
                                    		else{
                                    			echo Master."s";
                                    		}
                                    	}
                                    	else{
                                    		echo "NA";
                                    	}
                                    	?>
                                    </span></h4>
                                    <h4 class="details-title">date of enrolled: <span><?= $child_details->course_start_date ? date('d/m/Y', strtotime($child_details->course_start_date)) : "NA"; ?></span></h4>
                                    
                               </div>

                               <div class="col-4">
                               <h4 class="details-title">Diagnostic Score: <a <?php if ($diagnostic_question_asked > 0) {
                               	?>
                               	href="<?= base_url(); ?>admin/diagnostic_question_details/<?= $parent_id ?>/<?= $child_id ?>"
                               	<?php
                               }else{
                               	?>
                               	href="javascript:void(0)"
                               	<?php
                               } ?>><?= $diagnostic_question_correct; ?>/<?= $diagnostic_question_asked; ?></a></h4>
                               <h4 class="details-title">Diagnostic Quiz Taken on: <span><?= $diagnostic_exam_code_details->ss_aw_diagonastic_exam_date ? date('d/m/Y', strtotime($diagnostic_exam_code_details->ss_aw_diagonastic_exam_date)) : "NA"; ?></span></h4>
                               
                               <h4 class="details-title">Child Creation Date: <span><?= date('d/m/Y', strtotime($child_details->ss_aw_child_created_date)); ?></span></h4>
                               </div>
</div>


                                     <div class="tabs-container">
									<ul class="nav nav-tabs custom-nav-tabs border-none" role="tablist">
										<li><a class="nav-link active" data-toggle="tab" href="#tab-1">Course Details</a></li>
										<li><a class="nav-link" data-toggle="tab" href="#tab-2">Payment method</a></li>
									</ul>
									<div class="tab-content">
										<div role="tabpanel" id="tab-1" class="tab-pane active overflow-none">

											<div class="ibox-content">

                                            <table class="table" id="example1">

                                            <thead>
														<tr>
															<th colspan="2"></th>
															<th colspan="3" class="lessonTitle bg-lesson">Lesson</th>
															<th colspan="3" class="lessonTitle bg-assessment">Assessment</th>
														</tr>
													</thead>
													<thead>
														<tr>
															<th>Topic #</th>
															<th>Topic Name</th>
															<th class="bg-lesson">Start date</th>
															<th class="bg-lesson">End date</th>
						                                    <th class="bg-lesson">Score</th>
                                                            <th class="bg-assessment">Start date</th>
															<th class="bg-assessment">End date</th>
						                                    <th class="bg-assessment">Score</th>
														</tr>
													</thead>
													<tbody>
														<?php
														if (!empty($completed_topic_details)) {
															$count = 0;
															foreach ($completed_topic_details as $key => $value) {
																$count = $count + 1;
																?>
																<tr class="gradeX " id="<?= $count ?>">
																	<td class="center"><?= $count; ?></td>
																	<td class="center"><?= $value->ss_aw_lesson_topic; ?></td>
																	<td class="center bg-lesson"><?= $value->ss_aw_last_lesson_create_date ? date('d/m/Y', strtotime($value->ss_aw_last_lesson_create_date)) : "NA"; ?></td>
																	<td class="center bg-lesson"><?= $value->ss_aw_last_lesson_modified_date ? date('d/m/Y', strtotime($value->ss_aw_last_lesson_modified_date)) : "NA"; ?></td>
																	<td class="center bg-lesson"><a <?php if ($lesson_score['asked'][$value->ss_aw_lesson_id] > 0) {
																		?>
																		href="<?= base_url(); ?>admin/lesson_quiz_details/<?= $parent_id; ?>/<?= $child_id; ?>/<?= $value->ss_aw_lesson_id; ?>"
																		<?php
																	}else{
																		?>
																		href="javascript:void(0)"
																		<?php
																	} ?>>
																		<?php
																		
																		if ($lesson_score['asked'][$value->ss_aw_lesson_id] != 0) {
																			echo $lesson_score['correct'][$value->ss_aw_lesson_id]."/".$lesson_score['asked'][$value->ss_aw_lesson_id];
																		}
																		else{
																			echo "Not Completed";
																		}
																		?>
																	</a></td>
		                                                            <td class="center bg-assessment">
		                                                            	<?= $assessment_score['exam_start'][$value->ss_aw_lesson_id]; ?>
		                                                            </td>
																	<td class="center bg-assessment"><?= $assessment_score['exam_completed'][$value->ss_aw_lesson_id]; ?></td>
																	<td class="center bg-assessment"><a <?php if ($assessment_score['asked'][$value->ss_aw_lesson_id] > 0) {
																		?>
																		href="<?= base_url(); ?>admin/assessment_quiz_details/<?= $parent_id; ?>/<?= $child_id; ?>/<?= $assessment_id_ary[$value->ss_aw_lesson_id]; ?>"
																		<?php
																	}else{
																		?>
																		href="javascript:void(0)"
																		<?php
																	} ?>><?php
																	if ($assessment_score['asked'][$value->ss_aw_lesson_id] != 0) {
																		echo $assessment_score['correct'][$value->ss_aw_lesson_id]."/".$assessment_score['asked'][$value->ss_aw_lesson_id];
																	}
																	else{
																		echo "Not Completed";
																	}
																?></a></td>
																</tr>
																<?php
															}
														}
														?>

													</tbody>
									
												</table>
                                                <div class="row">
                                                    <div class="col-6">

                                            <table class="table" id="example2">
                                            <thead>
														<tr>
															<th colspan="4" class="lessonTitle bg-assessment">Readalong</th>
														</tr>
													</thead>
													<thead>
														<tr>
                                                        <th class="bg-assessment">Name</th>
                                                            <th class="bg-assessment">Start date</th>
															<th class="bg-assessment">End date</th>
						                                    <th class="bg-assessment">Score</th>
														</tr>
													</thead>
													<tbody>
														<?php
														if (!empty($readalong_lists)) {
															$count = 0;
															foreach ($readalong_lists as $key => $value) {
																$count = $count + 1;
																?>
																<tr class="gradeX <?= $count % 2 == 0 ? 'blocked-row-bg' : '';?>" id="<?= $count; ?>">
		                                                        	<td class="center bg-assessment"><?= $value['ss_aw_title']; ?></td>
		                                                            <td class="center bg-assessment"><?= $readalong_finish['start_date'][$value['ss_aw_readalong_id']]; ?></td>
																	<td class="center bg-assessment"><?= $readalong_finish['complete_date'][$value['ss_aw_readalong_id']]; ?></td>
																	<td class="center bg-assessment"><a <?php if ($readalong_score['asked'][$value['ss_aw_readalong_id']] > 0) {
																		?>
																		href="<?= base_url(); ?>admin/readalong_quiz_details/<?= $parent_id; ?>/<?= $child_id; ?>/<?= $value['ss_aw_readalong_id']; ?>"
																		<?php
																	}else{
																		?>
																		href="javascript:void(0)"
																		<?php
																	} ?>><?php
																	if ($readalong_score['asked'][$value['ss_aw_readalong_id']] != 0) {
																		echo $readalong_score['correct'][$value['ss_aw_readalong_id']]."/".$readalong_score['asked'][$value['ss_aw_readalong_id']];
																	}
																	else{
																		echo "Not Completed";
																	}
																?></a></td>
															
																</tr>
																<?php
															}
														}
														else{
															?>
															<tr class="gradeX">
																<td colspan="4" class="center bg-assessment">No data available.</td>
															</tr>
															<?php
														}
														?>
													</tbody>
									
												</table>

                                                </div>
                                                </div>

                                                




											</div>

										</div>

										<div role="tabpanel" id="tab-2" class="tab-pane overflow-none">

											<div class="ibox-content">
											<?php
											if (!empty($payment_details)) {
												foreach ($payment_details as $key => $value) {
													?>
													<div class="row parent-details-body">
													<div class="col-3">
			                                             	<h4 class="details-title">Method of Payment: <span>Online</span></h4>
			                                            </div> 
			                                            <div class="col-3">
			                                             	<h4 class="details-title">Mode of Payment: <span><?= $value['ss_aw_course_payemnt_type'] == 1 ? "EMI" : "Lumpsum"; ?></span></h4>
			                                            </div>

			                                            <div class="col-3">
			                                                <h4 class="details-title">Date of last payment: <span><?= date('d/m/Y', strtotime($value['ss_aw_child_course_create_date'])); ?></span></h4>
			                                            </div>

			                                            <div class="col-3">
			                                                <h4 class="details-title">Status: <span><?php
			                                                if ($value['ss_aw_course_status'] == 1) {
			                                                	echo "Ongoing";
			                                                }
			                                                elseif ($value['ss_aw_course_status'] == 2) {
			                                                	echo "Completed";
			                                                }
			                                                else{
			                                                	echo "Inactive";
			                                                }
			                                            ?></span></h4>
			                                            </div>

                                                   </div>
													<?php	
												}		
											}	
											?>	
                                            

											</div>
					
                                            </div>

                                        <!--  -->
									</div>


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
    .tab-content{
      overflow: auto !important;
    max-height: 400px !important;
    }
    #example1{
    	border-bottom: 1px solid #dee2e6;
    }   
    </style>


    <?php
            include('footer.php')
        ?>


</body>

</html>