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
                        <h4 class="page-title">Days Delinquent</h4>
                    </div>
                </div>
            </div>
        </div> <!-- container -->

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
                                            <select name="level" id="level" class="form-control">
                                                <?php
                                                if (!empty($courses_drop)) {
                                                    foreach ($courses_drop as $cour) {
                                                ?>
                                                        <option value="<?= $cour->ss_aw_course_id ?>" <?php
                                                                                                        if (!empty($days_deliquent_data['level'])) {
                                                                                                            if ($days_deliquent_data['level'] == $cour->ss_aw_course_id) {
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

                                <table class="table table-centered table-striped dt-responsive nowrap w-100" data-show-columns="true">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>For delinquent students</th>
                                            <th style="text-align: center;" colspan="3">Days Delinquent</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>Lesson / Assessment</th>
                                            <th>1-7</th>
                                            <th>8-14</th>
                                            <th>15+</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $gr_first = 0;
                                        $gr_second = 0;
                                        $gr_third = 0;
                                        $gr_total = 0;

                                        if (!empty($deliquient)) {
                                            foreach ($deliquient as $topic) {
                                                $topic_array = str_replace(" ", "_", $topic);
                                                $gr_first = $gr_first + $first_dq[$topic]['section'];
                                                $gr_second = $gr_second + $second_dq[$topic]['section'];
                                                $gr_third = $gr_third + $third_dq[$topic]['section'];
                                                $gr_row_total = $first_dq[$topic]['section'] + $second_dq[$topic]['section'] + $third_dq[$topic]['section'];
                                                $gr_total = $gr_total + $gr_row_total;
                                        ?>
                                                <tr>
                                                    <td><?= $topic ?></td>
                                                    <td>
                                                        <?php
                                                        if ($first_dq[$topic_array]['section'] != '') {
                                                            if (is_array($first_dq[$topic_array]['user_id'])) {
                                                                $id = implode(",", $first_dq[$topic_array]['user_id']);
                                                            } else {
                                                                $id = $first_dq[$topic_array]['user_id'];
                                                            }
                                                        ?>
                                                            <a href="<?= $first_dq[$topic_array]['section'] == '' ? 'javascript:void(0)' : base_url('report/days_deliquent_users/' . base64_encode($topic) . '/' . base64_encode($id)) ?>" target="_blank"><?= $first_dq[$topic_array]['section']; ?></a>
                                                        <?php } else {
                                                            echo "0";
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($second_dq[$topic_array]['section'] != '') {
                                                            if (is_array($second_dq[$topic_array]['user_id'])) {
                                                                $id = implode(",", $second_dq[$topic_array]['user_id']);
                                                            } else {
                                                                $id = $second_dq[$topic_array]['user_id'];
                                                            }

                                                        ?>
                                                            <a href="<?= $second_dq[$topic_array]['section'] == '' ? 'javascript:void(0)' : base_url('report/days_deliquent_users/' . base64_encode("$topic") . '/' . base64_encode($id)) ?>" target="_blank"><?= $second_dq["$topic_array"]['section']; ?></a>
                                                        <?php } else {
                                                            echo "0";
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($third_dq[$topic_array]['section'] != '') {
                                                            if (is_array($third_dq[$topic_array]['user_id'])) {
                                                                $id = implode(",", $third_dq[$topic_array]['user_id']);
                                                            } else {
                                                                $id = $third_dq[$topic_array]['user_id'];
                                                            }
                                                        ?>
                                                            <a href="<?= $third_dq[$topic_array]['section'] == '' ? 'javascript:void(0)' : base_url('report/days_deliquent_users/' . base64_encode($topic) . '/' . base64_encode($id)) ?>" target="_blank"><?= $third_dq[$topic_array]['section']; ?></a>
                                                        <?php } else {
                                                            echo "0";
                                                        } ?>
                                                    </td>

                                                    <td><?= $gr_row_total ?></td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td>Total</td>
                                            <td><?= $gr_first ?></td>
                                            <td><?= $gr_second ?></td>
                                            <td><?= $gr_third ?></td>
                                            <td><?= $gr_total ?></td>
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