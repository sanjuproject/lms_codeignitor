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
                                    <h4 class="page-title">Assessment Report</h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" id="demo-form" action="<?= base_url(); ?>report/assessment_child_report">
                                            <div class="difficulty_report_form">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Select Child</label>
                                                        <select name="child_id" id="child_id" class="form-control" onchange="getassessmentlist(this.value);">
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
                                                        <label>Select Assessment</label>
                                                        <select name="assessment_id" id="assessment_id" class="form-control">
                                                            <option value="">First Choose Child</option>  
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
<script src="<?php echo base_url();?>assets/libs/jquery/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var child_id = $("#child_id").val();
        if (child_id != '') {
            getassessmentlist(child_id);    
        }
        
        var assessment_id = "<?= $assessment_id ? $assessment_id : ''; ?>";
        $("#assessment_id").val(assessment_id);
        console.log({assessment_id});
        console.log({child_id});
    });
    function getassessmentlist(child_id){
        $.ajax({
            type: "GET",
            url: "<?= base_url(); ?>report/getassessmentbychild",
            data: {"child_id":child_id},
            async: false,
            success:function(data){
                $("#assessment_id").html(data);
            }
        });
    }
</script>