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
                                    <h4 class="page-title">Enrol current status</h4>
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
<!--                                                            <option value="">All</option>-->
                                                            <option value="1" <?php if(!empty($assign_level)){ if($assign_level == '1'){ ?> selected <?php } } ?>>Winners</option>
                                                            <option value="3" <?php if(!empty($assign_level)){ if($assign_level == '3'){ ?> selected <?php } } ?>>Champions</option>
                                                            <option value="5" <?php if(!empty($assign_level)){ if($assign_level == '5'){ ?> selected <?php } } ?>>Masters</option>
                                                        </select>
                                                    </div>
                                        
                                                    <div class="col-md-3">
                                                        <div class="form-group report-goBtn" style="text-align: left; margin-top: 28px;">
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
                                                        <th>#Enrolls</th>
                                                        <th>PTD</th>
                                                        <?php
                                                        $j = 0;
                                                        for ($i=0; $i <= 25; $i++) { 
                                                            if ($i == 0) {
                                                                ?>
                                                                <th><?= date('F Y', strtotime(date('Y-m-d'))); ?></th>
                                                                <?php
                                                            }
                                                            else{
                                                                $j = $j + 1;
                                                                $current_date = date('Y-m-d');
                                                                $previous_date = date('Y-m-d', strtotime($current_date. "-".$j." month"));
                                                                $month_date = date('F Y', strtotime($previous_date));
                                                                ?>
                                                                <th><?= $month_date; ?></th>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tr>
                                                </thead>
                                                

                                                <tbody>
                                                    <tr>
                                                        <td>completed all lessons</td>
                                                        <td><?=$ptd_total_num>0?'<a href="'.base_url().'/report/enroll_current_user/'.base64_encode($ptd_total_child).'" target="_blank">'.$ptd_total_num.'</a>':$ptd_total_num?></td>
                                                        <?php
                                                            for ($i=0; $i <= 25; $i++) { 
                                                                ?>
                                                        <td><?= $total_monthly['complete_num'][$i]!=''?'<a href="'.base_url().'/report/enroll_current_user/'.base64_encode($total_monthly['child_id'][$i]).'" target="_blank">'.$total_monthly['complete_num'][$i].'</a>':0; ?></td>
                                                                <?php
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>% completed</td>
                                                        <td><?= $ptd_total_num_percentage; ?>%</td>
                                                        <?php
                                                            for ($i=0; $i <= 25; $i++) { 
                                                                ?>
                                                                <td><?= $total_monthly['complete_num_percent'][$i] > 0 ? number_format($total_monthly['complete_num_percent'][$i], 2) : $total_monthly['complete_num_percent'][$i]; ?>%</td>
                                                                <?php
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Active</td>
                                                        <td><?= $ptd_active_num>0?'<a href="'.base_url().'/report/enroll_current_user/'.base64_encode($ptd_active_child).'" target="_blank">'.$ptd_active_num.'</a>':'0%'; ?></td>
                                                        <?php
                                                            for ($i=0; $i <= 25; $i++) { 
                                                                ?>
                                                                <td><?= $active_monthly['complete_num'][$i]!=''?'<a href="'.base_url().'/report/enroll_current_user/'.base64_encode($active_monthly['child_id'][$i]).'" target="_blank">'.$active_monthly['complete_num'][$i].'</a>':0; ?></td>
                                                                <?php
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>% Active</td>
                                                        <td><?= $ptd_active_num_percentage; ?></td>
                                                        <?php
                                                            for ($i=0; $i <= 25; $i++) { 
                                                                ?>
                                                                <td><?= $active_monthly['complete_num_percent'][$i] > 0 ? number_format($active_monthly['complete_num_percent'][$i], 2) : $active_monthly['complete_num_percent'][$i]; ?>%</td>
                                                                <?php
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Delinquent</td>
                                                        <td><?= $ptd_delinquent_num>0?'<a href="'.base_url().'/report/enroll_current_user/'.base64_encode($ptd_inactive_child).'" target="_blank">'.$ptd_delinquent_num.'</a>':'0%'; ?></td>
                                                        <?php
                                                            for ($i=0; $i <= 25; $i++) { 
                                                                ?>
                                                                <td><?= $delinquent_monthly['complete_num'][$i]!=''?'<a href="'.base_url().'/report/enroll_current_user/'.base64_encode($delinquent_monthly['child_id'][$i]).'" target="_blank">'.$delinquent_monthly['complete_num'][$i].'</a>':0; ?></td>
                                                                <?php
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>% Delinquent</td>
                                                        <td><?= $ptd_delinquent_num_percentage>0?$ptd_delinquent_num_percentage:0; ?>%</td>
                                                        <?php
                                                            for ($i=0; $i <= 25; $i++) { 
                                                                ?>
                                                                <td><?= $delinquent_monthly['complete_num_percent'][$i] > 0 ?number_format($delinquent_monthly['complete_num_percent'][$i], 2) : $delinquent_monthly['complete_num_percent'][$i]; ?>%</td>
                                                                <?php
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Inactive</td>
                                                        <td><?= $ptd_inactive_num>0?'<a href="'.base_url().'/report/enroll_current_user/'.base64_encode($ptd_inactive_child).'" target="_blank">'.$ptd_inactive_num.'</a>':0; ?></td>
                                                        <?php
                                                            for ($i=0; $i <= 25; $i++) { 
                                                                ?>
                                                                <td><?= $inactive_monthly['complete_num'][$i]!=''?'<a href="'.base_url().'/report/enroll_current_user/'.base64_encode($inactive_monthly['child_id'][$i]).'" target="_blank">'.$inactive_monthly['complete_num'][$i].'</a>':0; ?></td>
                                                                <?php
                                                            }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td>% Inactive</td>
                                                        <td><?= $ptd_inactive_num_percentage; ?>%</td>
                                                        <?php
                                                            for ($i=0; $i <= 25; $i++) { 
                                                                ?>
                                                                <td><?= $inactive_monthly['complete_num_percent'][$i] > 0 ? number_format($inactive_monthly['complete_num_percent'][$i], 2) : $inactive_monthly['complete_num_percent'][$i]; ?>%</td>
                                                                <?php
                                                            }
                                                        ?>
                                                    </tr>
                                                </tbody>
                                            </table>
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