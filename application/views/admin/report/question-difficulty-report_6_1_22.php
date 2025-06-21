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
                                    <h4 class="page-title">Question Difficulty Report</h4>
                                </div>
                            </div>
                        </div>     

                        <!-- end page title --> 
                        <?php
                        $urlString = "";
                        if (!empty($searchdata['age'])) {
                            $urlString .= $searchdata['age'];
                        }
                        if (!empty($searchdata['assign_level'])) {
                            $urlString .= "@".$searchdata['assign_level'];
                        }
                        if (!empty($searchdata['quiz_type'])) {
                            $urlString .= "@".$searchdata['quiz_type'];
                        }
                        if (!empty($searchdata['update_date'])) {
                            $urlString .= "@".$searchdata['update_date'];
                        }
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" id="demo-form">
                                            <div class="difficulty_report_form">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Age</label>
                                                            <select name="age" id="age" class="form-control">
                                                                <option value="">Choose Age</option>
                                                                <option value="1" <?php if(!empty($searchdata['age'])){ if($searchdata['age'] == 1){ ?> selected <?php } } ?>>10-12</option>
                                                                <option value="2" <?php if(!empty($searchdata['age'])){ if($searchdata['age'] == 2){ ?> selected <?php } } ?>>12-14</option>
                                                                <option value="3" <?php if(!empty($searchdata['age'])){ if($searchdata['age'] == 3){ ?> selected <?php } } ?>>14-16</option>
                                                            </select>
                                                        </div>  
                                                           
                                                    </div>

                                                    <div class="col-md-3">

                                                        <div class="form-group">
                                                            <label>Assign Level</label>
                                                            <select name="assign_level" id="assign_level" class="form-control">
                                                                <option value="">Choose Assign Level</option>
                                                                <option value="1" <?php if(!empty($searchdata['assign_level'])){ if($searchdata['assign_level'] == 1){ ?> selected <?php } } ?>>E</option>
                                                                <option value="2" <?php if(!empty($searchdata['assign_level'])){ if($searchdata['assign_level'] == 2){ ?> selected <?php } } ?>>C</option>
                                                                <option value="3" <?php if(!empty($searchdata['assign_level'])){ if($searchdata['assign_level'] == 3){ ?> selected <?php } } ?>>A</option>
                                                            </select>

                                                        </div>
                                                            
                                                    </div>


                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Quiz Type</label>
                                                            <select name="quiz_type" id="quiz_type" class="form-control">
                                                                <option value="">Choose Quiz Type</option>
                                                                <option value="1" <?php if(!empty($searchdata['quiz_type'])){ if($searchdata['quiz_type'] == 1){ ?> selected <?php } } ?>>Lesson Quiz</option>
                                                                <option value="2" <?php if(!empty($searchdata['quiz_type'])){ if($searchdata['quiz_type'] == 2){ ?> selected <?php } } ?>>Assessment Quiz</option>
                                                                <option value="3" <?php if(!empty($searchdata['quiz_type'])){ if($searchdata['quiz_type'] == 3){ ?> selected <?php } } ?>>Diagnostic Quiz</option>
                                                            </select> 

                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">

                                                        <div class="form-group">

                                                            <label>Updated Within</label>
                                                            <input type="date" name="update_date" class="form-control" <?php if ($searchdata['update_date']) {
                                                                ?>
                                                                value="<?php echo $searchdata['update_date'] ?>"
                                                                <?php
                                                            } ?>>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-1">

                                                        <div class="form-group report-goBtn">

                                                           <input type="submit" name="submit" value="Go" class="btn btn-primary">

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                            
                                          
                                        <div class="table-responsive gridview-wrapper">
                                            <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                                data-show-columns="true">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Course</th>
                                                        <th>Question Level</th>
                                                        <th>Topic</th>
                                                        <th>Question</th>
                                                        <th>Sequence No</th>
                                                        <th>Correct Answer</th>
                                                        <th>No Of Time Asked</th>
                                                        <th>No Of Time Answer Correctly</th>
                                                        <th>No Of Time Answer Incorrectly</th>
                                                    </tr>
                                                </thead>


                                                <tbody>
                                                    <?php
                                                    if (!empty($result)) {
                                                        $count = 0;
                                                        foreach ($result as $key => $value) {
                                                            $count++;
                                                            ?>
                                                       
                                                                <tr>
                                                                    <td><?php echo $value->lesson_course_type; ?></td>
                                                                    <td><?php echo $value->question_course_level; ?></td>
                                                                    <td><?= $value->topic_name; ?></td>
                                                                    <?php 
                                                                        $title_string = $value->ss_aw_lesson_title." ".$value->ss_aw_lesson_details; 
                                                                        ?>
                                                                    <td><?php echo getQuestion($title_string); ?></td>
                                                                    <td><?php echo $question_sequence_no[$value->record_id]; ?></td>
                                                                    <td><?= $value->correct_answer; ?></td>
                                                                    <td><?php echo $question_asked[$value->record_id] ? $question_asked[$value->record_id] : 0; ?></td>
                                                                    <td><?php echo $correct_answer[$value->record_id] ? $correct_answer[$value->record_id] : 0; ?></td>
                                                                    <td>
                                                                    <?php
                                                                    if ($searchdata['quiz_type'] == 1) {
                                                                        if ($incorrect_answer_count[$value->record_id] == 0) {
                                                                            echo 0;
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <a href="<?= base_url(); ?>report/incorrect_answers/<?= base64_encode($searchdata['age']."@".$value->record_id."@".$searchdata['quiz_type']."@".$value->ss_aw_lesson_format."@".$this->uri->segment(3)); ?>"><?php echo $incorrect_answer_count[$value->record_id] ? $incorrect_answer_count[$value->record_id] : 0; ?></a>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    else{
                                                                        if ($incorrect_answer_count[$value->record_id] == 0) {
                                                                            echo 0;
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <a href="<?= base_url(); ?>report/incorrect_answers/<?= base64_encode($searchdata['age']."@".$value->record_id."@".$searchdata['quiz_type']."@".$value->ss_aw_format."@".$this->uri->segment(3)); ?>"><?php echo $incorrect_answer_count[$value->record_id] ? $incorrect_answer_count[$value->record_id] : 0; ?></a>
                                                                            <?php
                                                                        }
                                                                    }    
                                                                    ?>
                                                                    </td>
                                                                    </tr>

                                                            <?php
                                                         $sl++;
                                                        }
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <tr colspan="6">
                                                            <td>No data found.</td>
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
                        </div>    
                      
                        <div class="row">
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
                        </div>

                        <?php
                        if (!empty($result)) {
                            ?>
                            <!-- <div class="row">
                                <div>
                                    <a target="_blank" class="btn btn-primary" href="<?= base_url(); ?>report/export_question_difficulty">Download Report as PDF Format</a>
                                </div>
                            </div> -->
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