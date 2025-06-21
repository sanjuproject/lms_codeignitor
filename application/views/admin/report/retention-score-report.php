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
                                    <h4 class="page-title">Retention Score Report</h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" id="demo-form">
                                            <div class="difficulty_report_form">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Assign Level</label>
                                                        <select name="assign_level" id="assign_level" class="form-control" required>
                                                            <option value="">Choose Assign Level</option>
                                                            <?php
		if (!empty($courses_drop)) {
			foreach ($courses_drop as $cour) {
		?>
				<option value="<?= $cour->ss_aw_course_code ?>"<?php if(!empty($retention_score_searchdata['assign_level'])){ if($retention_score_searchdata['assign_level'] == $cour->ss_aw_course_code){ ?> selected <?php } } ?>><?= $cour->ss_aw_course_nickname ?></option>

	<?php }
	} ?>
                                                           </select>
                                                    </div>
                                                            
                                                    <div class="col-md-3">
                                                        <div class="form-group report-goBtn" style="text-align: left;">
                                                            <input type="submit" name="submit" value="Go" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                               
                                        <div class="table-responsive gridview-wrapper">
                                            <?php
                                            if (!empty($decending_retention_score) && !empty($retention_score)) {
                                                ?>
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Retention Score</th>
                                                            <th>Students</th>
                                                            <th>% of students</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        for ($i=count(RETENTION_PERCENTAGE_CHAIN) - 1; $i >= 0; $i--) {
                                                            if (RETENTION_PERCENTAGE_CHAIN[$i] == '0%') {
                                                                $percentage_range = RETENTION_PERCENTAGE_CHAIN[$i];
                                                            }
                                                            else
                                                            {
                                                                $percentageAry = explode("-", RETENTION_PERCENTAGE_CHAIN[$i]);
                                                                if (!empty($percentageAry)) {
                                                                    $percentage_range = "> -".$percentageAry[0]." - -".$percentageAry[1];    
                                                                }
                                                                else{
                                                                    $percentage_range = "";
                                                                }    
                                                            }
                                                              
                                                            ?>
                                                            <tr>
                                                                <td><?= $percentage_range; ?></td>
                                                                <td><?= $decending_retention_score[RETENTION_PERCENTAGE_CHAIN[$i]]; ?></td>
                                                                <td><?= get_percentage($total_students, $decending_retention_score[RETENTION_PERCENTAGE_CHAIN[$i]])."%"; ?></td>
                                                            </tr>
                                                            <?php
                                                        }

                                                        for ($j=0; $j < count(RETENTION_PERCENTAGE_CHAIN); $j++) { 
                                                            if (RETENTION_PERCENTAGE_CHAIN[$j] != '0%') {
                                                                ?>
                                                                <tr>
                                                                    <td><?= ">".RETENTION_PERCENTAGE_CHAIN[$j]; ?></td>
                                                                    <td><?= $retention_score[RETENTION_PERCENTAGE_CHAIN[$j]]; ?></td>
                                                                    <td><?= get_percentage($total_students, $retention_score[RETENTION_PERCENTAGE_CHAIN[$j]])."%"; ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <p>No data found.</p>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                        </div>    

                        <?php
                        if (!empty($report_detail)) {
                            ?>
                            <div class="row">
                                <div>
                                    <a target="_blank" class="btn btn-primary" href="<?= base_url(); ?>report/export_lesson_assessment_score/<?= $lesson_assessment_score_searchdata['assign_level']; ?>">Download Report as PDF Format</a>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                      
                        
                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

</body>
</html>