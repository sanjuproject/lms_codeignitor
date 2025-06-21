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
                                            <?php
		if (!empty($courses_drop)) {
			foreach ($courses_drop as $cour) {
		?>
				<option value="<?= $cour->ss_aw_course_id ?>"<?php
                                                if (!empty($assign_level)) {
                                                    if ($assign_level == $cour->ss_aw_course_id) {
                                                        ?> selected <?php
                                                            }
                                                        }
                                                        ?>><?= $cour->ss_aw_course_nickname ?></option>

	<?php }
	} ?>
                                           
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
                                            for ($i = 0; $i <= 25; $i++) {
                                                if ($i == 0) {
                                                    ?>
                                                    <th><?= str_replace(" ", '&nbsp', date('F Y', strtotime(date('Y-m-d')))); ?></th>
                                                    <?php
                                                } else {
                                                    $j = $j + 1;
                                                    $current_date = date('Y-m-d');
                                                    $previous_date = date('Y-m-d', strtotime($current_date . "-" . $j . " month"));
                                                    $month_date = date('F Y', strtotime($previous_date));
                                                    ?>
                                                    <th><?= str_replace(" ", '&nbsp', $month_date); ?></th>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                   

                                    <tbody>
                                         <tr style="background-color: #cce9d1;">
                                            <td>User&nbsp;Count</td>
                                            <td><?= $recent_data['completed_total'] ?></td>
                                            <?php
                                             for ($i = -1; $i <= 24; $i++) {
                                                if ($i == -1) {
                                                    ?>
                                                    <td><?= $recent_data['completed_total'] ?></td>
                                                <?php } else {
                                                    ?>
                                                    <td><?= @$pre_data[$i]['completed_total'] ?></td>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>completed&nbsp;all&nbsp;lessons</td>
                                            <td><?= $recent_data['completed_ptd'] != 0 ? '<a href="' . base_url() . '/report/enroll_current_user/' . base64_encode($recent_data['completed_ptd_child']) . '" target="_blank">' . $recent_data['completed_ptd'] . '</a>' : 0; ?></td>

                                            <?php
                                            for ($i = -1; $i <= 24; $i++) {
                                                if ($i == -1) {
                                                    ?>
                                                    <td><?= $recent_data['completed'] != 0 ? '<a href="' . base_url() . '/report/enroll_current_user/' . base64_encode($recent_data['completed_child']) . '" target="_blank">' . $recent_data['completed'] . '</a>' : 0; ?></td>
                                                <?php } else {
                                                    ?>
                                                    <td><?= $pre_data[$i]['completed'] != 0 ? '<a href="' . base_url() . '/report/enroll_current_user/' . base64_encode($pre_data[$i]['completed_child']) . '" target="_blank">' . $pre_data[$i]['completed'] . '</a>' : 0; ?></td>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>%&nbsp;completed</td>
                                            <td><?= $recent_data['completed_ptd_per'] ?>%</td>
                                            <?php
                                            for ($i = -1; $i <= 24; $i++) {
                                                if ($i == -1) {
                                                    ?>
                                                    <td><?= $recent_data['completed_per'] ?>%</td>
                                                <?php } else {
                                                    ?>
                                                    <td><?= $pre_data[$i]['completed_per'] ?>%</td>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                       <tr style="background-color: #cce9d1;">
                                            <td>in&nbsp;complete&nbsp;User&nbsp;Count</td>
                                            <td><?= $recent_data['incompleted_total'] ?></td>
                                            <?php
                                             for ($i = -1; $i <= 24; $i++) {
                                                if ($i == -1) {
                                                    ?>
                                                    <td><?= $recent_data['incompleted_total'] ?></td>
                                                <?php } else {
                                                    ?>
                                                    <td><?= $pre_data[$i]['incompleted_total'] ?></td>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Active</td>
                                            <td><?= $recent_data['active'] > 0 ? '<a href="' . base_url() . '/report/enroll_current_user/' . base64_encode($recent_data['active_child']) . '" target="_blank">' . $recent_data['active'] . '</a>' : 0 ?></td>

                                            <?php
                                            for ($i = -1; $i <= 24; $i++) {
                                                if ($i == -1) {
                                                    ?>
                                                    <td><?= $recent_data['active'] > 0 ? '<a href="' . base_url() . '/report/enroll_current_user/' . base64_encode($recent_data['active_child']) . '" target="_blank">' . $recent_data['active'] . '</a>' : 0 ?></td>

                                                <?php } else {
                                                    ?>
                                                    <td><?= $pre_data[$i]['active'] > 0 ? '<a href="' . base_url() . '/report/enroll_current_user/' . base64_encode($pre_data[$i]['active_child']) . '" target="_blank">' . $pre_data[$i]['active'] . '</a>' : 0; ?></td>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>% Active</td>
                                            <td><?= $recent_data['active_percent'] ?>%</td>
                                            <?php
                                            for ($i = -1; $i <= 24; $i++) {
                                                if ($i == -1) {
                                                    ?>
                                                    <td><?= $recent_data['active_percent'] ?>%</td>
                                                <?php } else {
                                                    ?>
                                                    <td><?= $pre_data[$i]['active_percent'] ?>%</td>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Delinquent</td>
                                            <td><?= $recent_data['delinquent'] > 0 ? '<a href="' . base_url() . '/report/enroll_current_user/' . base64_encode($recent_data['delinquent_child']) . '" target="_blank">' . $recent_data['delinquent'] . '</a>' : 0 ?></td>

                                            <?php
                                            for ($i = -1; $i <= 24; $i++) {
                                                if ($i == -1) {
                                                    ?>
                                                    <td><?= $recent_data['delinquent'] > 0 ? '<a href="' . base_url() . '/report/enroll_current_user/' . base64_encode($recent_data['delinquent_child']) . '" target="_blank">' . $recent_data['delinquent'] . '</a>' : 0 ?></td>

                                                <?php } else {
                                                    ?>
                                                    <td><?= $pre_data[$i]['delinquent'] > 0 ? '<a href="' . base_url() . '/report/enroll_current_user/' . base64_encode($pre_data[$i]['delinquent_child']) . '" target="_blank">' . $pre_data[$i]['delinquent'] . '</a>' : 0; ?></td>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>% Delinquent</td>
                                            <td><?= $recent_data['delinquent_per'] ?>%</td>
                                            <?php
                                            for ($i = -1; $i <= 24; $i++) {
                                                if ($i == -1) {
                                                    ?>
                                                    <td><?= $recent_data['delinquent_per'] ?>%</td>
                                                <?php } else {
                                                    ?>
                                                    <td><?= $pre_data[$i]['delinquent_per'] ?>%</td>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Inactive</td>
                                            <td><?= $recent_data['inactive'] > 0 ? '<a href="' . base_url() . '/report/enroll_current_user/' . base64_encode($recent_data['inactive_child']) . '" target="_blank">' . $recent_data['inactive'] . '</a>' : 0 ?></td>

                                            <?php
                                            for ($i = -1; $i <= 24; $i++) {
                                                if ($i == -1) {
                                                    ?>
                                                    <td><?= $recent_data['inactive'] > 0 ? '<a href="' . base_url() . '/report/enroll_current_user/' . base64_encode($recent_data['inactive_child']) . '" target="_blank">' . $recent_data['inactive'] . '</a>' : 0 ?></td>

                                                <?php } else {
                                                    ?>
                                                    <td><?= $pre_data[$i]['inactive'] > 0 ? '<a href="' . base_url() . '/report/enroll_current_user/' . base64_encode($pre_data[$i]['inactive_child']) . '" target="_blank">' . $pre_data[$i]['inactive'] . '</a>' : 0; ?></td>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>% Inactive</td>
                                            <td><?= $recent_data['inactive_per'] ?>%</td>
                                            <?php
                                            for ($i = -1; $i <= 24; $i++) {
                                                if ($i == -1) {
                                                    ?>
                                                    <td><?= $recent_data['inactive_per'] ?>%</td>
                                                <?php } else {
                                                    ?>
                                                    <td><?= $pre_data[$i]['inactive_per'] ?>%</td>

                                                    <?php
                                                }
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