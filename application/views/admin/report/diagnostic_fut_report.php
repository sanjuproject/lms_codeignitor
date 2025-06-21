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
                                    <h4 class="page-title">Diagnostic Assessment Score</h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" id="demo-form" action="<?= base_url(); ?>report/diagnostic_child_report">
                                            <div class="difficulty_report_form">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Select Child</label>
                                                        <select name="child_id" id="child_id" class="form-control">
                                                            <option value="">Choose One</option>
                                                             <?php
                                                             if (!empty($students)) {
                                                                foreach ($students as $key => $value) {
                                                                    ?>
                                                                    <option value="<?= $value->child_id; ?>" <?php if(!empty($child_id)){ if($child_id == $value->child_id){ ?> selected <?php } } ?>><?= $value->child_name ?></option>
                                                                    <?php
                                                                }
                                                             }
                                                             ?>   
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
                                            if (!empty($result)) {
                                                ?>
                                                <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Child Name</th>
                                                            <th>Question Level</th>
                                                            <th>Question Preface</th>
                                                            <th>Question</th>
                                                            <th>Student Answer</th>
                                                            <th>Correct Answer</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        foreach ($result as $key => $value) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $value->child_name; ?></td>
                                                                <td><?= $value->question_level; ?></td>
                                                                <td><?= $value->question_preface; ?></td>
                                                                <td><?= $value->question; ?></td>
                                                                <td><?= $value->student_answer; ?></td>
                                                                <td><?= $value->correct_answer; ?></td>
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