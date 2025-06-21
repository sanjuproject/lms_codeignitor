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
                                    <h4 class="page-title">Lesson Assessment Score Report</h4>
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
                                                        <select name="assign_level" id="assign_level" class="form-control">
                                                            <option value="">Choose Assign Level</option>
                                                            <option value="E" <?php if(!empty($lesson_assessment_score_searchdata['assign_level'])){ if($lesson_assessment_score_searchdata['assign_level'] == 'E'){ ?> selected <?php } } ?>>E</option>
                                                            <option value="C" <?php if(!empty($lesson_assessment_score_searchdata['assign_level'])){ if($lesson_assessment_score_searchdata['assign_level'] == 'C'){ ?> selected <?php } } ?>>C</option>
                                                            <option value="A" <?php if(!empty($lesson_assessment_score_searchdata['assign_level'])){ if($lesson_assessment_score_searchdata['assign_level'] == 'A'){ ?> selected <?php } } ?>>A</option>
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
                                            if (!empty($report_detail)) {
                                                ?>
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Lesson Score</th>
                                                            <?php
                                                            for ($j = count(PERCENTAGE_CHAIN) - 1; $j >= 0 ; $j--) {
                                                                ?>
                                                                <th><?= PERCENTAGE_CHAIN[$j]; ?></th>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        for ($i=0; $i < count(PERCENTAGE_CHAIN); $i++) { 
                                                            ?>
                                                            <tr>
                                                                <td><?= PERCENTAGE_CHAIN[$i]; ?></td>
                                                                <?php
                                                                for ($j = count(PERCENTAGE_CHAIN) - 1; $j >= 0 ; $j--) {
                                                                    ?>
                                                                    <td><?= $report_detail[PERCENTAGE_CHAIN[$i]][PERCENTAGE_CHAIN[$j]]; ?></td>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                            <?php
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