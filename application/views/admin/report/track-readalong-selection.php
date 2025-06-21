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
                         <h4 class="page-title">Track Readalong Selection</h4>
                     </div>
                 </div>
             </div>

             <!-- end page title -->

             <div class="row">
                 <div class="col-12">
                     <div class="card">
                         <div class="card-body">
                             <div class="row mb-2">
                                 <div class="col-6">
                                     <form method="post" id="demo-form">
                                         <div class="difficulty_report_form">
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <label>Assign Level</label>
                                                     <select name="assign_level" id="assign_level" class="form-control">
                                                         <?php
                                                            if (!empty($courses_drop)) {
                                                                foreach ($courses_drop as $cour) {
                                                            ?>
                                                                 <option value="<?= $cour->ss_aw_course_id ?>" <?php if (!empty($track_readalong_data['assign_level'])) {
                                                                                                                    if ($track_readalong_data['assign_level'] == $cour->ss_aw_course_id) { ?> selected <?php }
                                                                                                                                                                                                                                                    } ?>><?= $cour->ss_aw_course_nickname ?></option>

                                                         <?php }
                                                            } ?>
                                                     </select>
                                                 </div>

                                                 <div class="col-md-3">
                                                     <div class="form-group report-goBtn" style="text-align: left;    margin-top: 28px;">
                                                         <input type="submit" name="submit" value="Go" class="btn btn-primary">
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </form>
                                 </div>
                                 <div class="col-6" style="text-align: right; margin-top: 30px;">
                                     <?php
                                        if (!empty($readalongs)) {
                                        ?>
                                         <a class="btn btn-success align-middle" href="<?= base_url(); ?>report/export_readalong_selection_report/<?= $track_readalong_data['assign_level']; ?>/<?= $track_readalong_data['age']; ?>"><i class="mdi mdi-file-excel"></i>Export</a>
                                     <?php
                                        }
                                        ?>
                                 </div>
                             </div>


                             <div class="table-responsive gridview-wrapper">
                                 <?php
                                    if (!empty($readalongs)) {
                                    ?>
                                     <table class="table table-centered table-striped dt-responsive nowrap w-100" data-show-columns="true">
                                         <thead>
                                             <th>Readalongs</th>
                                             <th colspan="3" style="text-align: center;">PTD</th>
                                             <th colspan="3" style="text-align: center;">YTD</th>
                                             <th colspan="3" style="text-align: center;">MTD</th>
                                         </thead>
                                         <tbody>
                                             <tr>
                                                 <td></td>
                                                 <td>Selected</td>
                                                 <td>Completed</td>
                                                 <td>%Completed</td>
                                                 <td>Selected</td>
                                                 <td>Completed</td>
                                                 <td>%Completed</td>
                                                 <td>Selected</td>
                                                 <td>Completed</td>
                                                 <td>%Completed</td>
                                             </tr>
                                             <?php
                                                foreach ($readalongs as $key => $value) {
                                                ?>
                                                 <tr>
                                                     <td><?= $value['ss_aw_title']; ?></td>
                                                     <td>
                                                         <?php
                                                            if ($selected_num_ptd[$value['ss_aw_id']] > 0) {
                                                            ?>
                                                             <a target="_blank" href="<?= base_url(); ?>report/track_readalong_selected_users/<?= base64_encode($value['ss_aw_title'] . "@" . $track_readalong_data['assign_level'] . "@1") ?>"><?= $selected_num_ptd[$value['ss_aw_id']]; ?></a>
                                                         <?php
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?>
                                                     </td>
                                                     <td>
                                                         <?php
                                                            if ($completed_num_ptd[$value['ss_aw_id']] > 0) {
                                                            ?>
                                                             <a target="_blank" href="<?= base_url(); ?>report/track_readalong_completed_users/<?= base64_encode($value['ss_aw_title'] . "@" . $track_readalong_data['assign_level'] . "@1") ?>"><?= $completed_num_ptd[$value['ss_aw_id']]; ?></a>
                                                         <?php
                                                            } else {
                                                                echo 0;
                                                            }
                                                            ?>

                                                     </td>
                                                     <td><?= get_percentage($selected_num_ptd[$value['ss_aw_id']], $completed_num_ptd[$value['ss_aw_id']]) . "%"; ?></td>
                                                     <td>
                                                         <?php
                                                            if ($selected_num_ytd[$value['ss_aw_id']] > 0) {
                                                            ?>
                                                             <a target="_blank" href="<?= base_url(); ?>report/track_readalong_selected_users/<?= base64_encode($value['ss_aw_title'] . "@" . $track_readalong_data['assign_level'] . "@2") ?>"><?= $selected_num_ytd[$value['ss_aw_id']]; ?></a>
                                                         <?php
                                                            } else {
                                                                echo 0;
                                                            }
                                                            ?>

                                                     </td>
                                                     <td>
                                                         <?php
                                                            if ($completed_num_ytd[$value['ss_aw_id']]) {
                                                            ?>
                                                             <a target="_blank" href="<?= base_url(); ?>report/track_readalong_completed_users/<?= base64_encode($value['ss_aw_title'] . "@" . $track_readalong_data['assign_level'] . "@2") ?>"><?= $completed_num_ytd[$value['ss_aw_id']]; ?></a>
                                                         <?php
                                                            } else {
                                                                echo 0;
                                                            }
                                                            ?>

                                                     </td>
                                                     <td><?= get_percentage($selected_num_ytd[$value['ss_aw_id']], $completed_num_ytd[$value['ss_aw_id']]) . "%"; ?></td>
                                                     <td>
                                                         <?php
                                                            if ($selected_num_mtd[$value['ss_aw_id']] > 0) {
                                                            ?>
                                                             <a target="_blank" href="<?= base_url(); ?>report/track_readalong_selected_users/<?= base64_encode($value['ss_aw_title'] . "@" . $track_readalong_data['assign_level'] . "@3") ?>"><?= $selected_num_mtd[$value['ss_aw_id']]; ?></a>
                                                         <?php
                                                            } else {
                                                                echo 0;
                                                            }
                                                            ?>

                                                     </td>
                                                     <td>
                                                         <?php
                                                            if ($completed_num_mtd[$value['ss_aw_id']] > 0) {
                                                            ?>
                                                             <a target="_blank" href="<?= base_url(); ?>report/track_readalong_completed_users/<?= base64_encode($value['ss_aw_title'] . "@" . $track_readalong_data['assign_level'] . "@3") ?>"><?= $completed_num_mtd[$value['ss_aw_id']]; ?></a>
                                                         <?php
                                                            } else {
                                                                echo 0;
                                                            }
                                                            ?>

                                                     </td>
                                                     <td><?= get_percentage($selected_num_mtd[$value['ss_aw_id']], $completed_num_mtd[$value['ss_aw_id']]) . "%"; ?></td>
                                                 </tr>
                                             <?php
                                                }
                                                ?>
                                         </tbody>
                                     </table>
                                 <?php
                                    } else {
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