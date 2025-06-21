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
                                    <h4 class="page-title">Lesson Completion Report</h4>
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
                                                        <label>Age</label>
                                                        <select name="age" id="age" class="form-control">
                                                            <option value="">Choose Age</option>
                                                            <option value="1" <?php if(!empty($lesson_completion_searchdata['age'])){ if($lesson_completion_searchdata['age'] == 1){ ?> selected <?php } } ?>>10-12</option>
                                                            <option value="2" <?php if(!empty($lesson_completion_searchdata['age'])){ if($lesson_completion_searchdata['age'] == 2){ ?> selected <?php } } ?>>12-14</option>
                                                            <option value="3" <?php if(!empty($lesson_completion_searchdata['age'])){ if($lesson_completion_searchdata['age'] == 3){ ?> selected <?php } } ?>>14-16</option>
                                                        </select>
                                                    </div>
                                                            
                                                    <div class="col-md-3">
                                                        <label>Assign Level</label>
                                                        <select name="assign_level" id="assign_level" class="form-control">
                                                            <option value="">Choose Assign Level</option>
                                                            <option value="1" <?php if(!empty($lesson_completion_searchdata['assign_level'])){ if($lesson_completion_searchdata['assign_level'] == 1){ ?> selected <?php } } ?>>E</option>
                                                            <option value="2" <?php if(!empty($lesson_completion_searchdata['assign_level'])){ if($lesson_completion_searchdata['assign_level'] == 2){ ?> selected <?php } } ?>>C</option>
                                                            <option value="3" <?php if(!empty($lesson_completion_searchdata['assign_level'])){ if($lesson_completion_searchdata['assign_level'] == 3){ ?> selected <?php } } ?>>A</option>
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
                                            if (!empty($lessons)) {
                                                ?>
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Level</th>
                                                            <?php
                                                            if (!empty($lessons)) {
                                                                foreach ($lessons as $key => $value){
                                                                    ?>
                                                                    <th><?php echo $value->ss_aw_lesson_topic; ?></th>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <th>Total</th>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <tr>
                                                            <?php
                                                            if ($lesson_completion_searchdata['assign_level'] == 1) {
                                                                $course = "E";
                                                            }
                                                            elseif ($lesson_completion_searchdata['assign_level'] == 2) {
                                                                $course = "C";
                                                            }
                                                            else{
                                                                $course = "A";
                                                            }
                                                            ?>
                                                            <td><?= $course; ?></td>
                                                            <?php
                                                            if (!empty($lessons)) {
                                                                $total = 0;
                                                                foreach ($lessons as $key => $value){
                                                                    $total = $total + $lesson_complete_num[$value->ss_aw_lession_id];
                                                                    ?>
                                                                    <td><?= $lesson_complete_num[$value->ss_aw_lession_id]; ?></td>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <td><?= $total; ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tr>
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
                      
                        <!-- <div class="row">
                            <div class="col-md-6">

                            </div>

                            <div class="col-md-6">
                                <div class="text-right">
                                    <ul class="pagination pagination-rounded justify-content-end">
                                         <?php foreach ($links as $link) {
                                        echo "<li>". $link."</li>";
                                        } ?>
                                    </ul>
                                </div>
                            </div>
                        </div> -->

                        <?php
                        if (!empty($lessons)) {
                            ?>
                            <div class="row">
                                <div>
                                    <a target="_blank" class="btn btn-primary" href="<?= base_url(); ?>report/export_lesson_complete_data">Download Report as PDF Format</a>
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