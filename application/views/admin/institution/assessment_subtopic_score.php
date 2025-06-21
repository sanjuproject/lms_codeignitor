

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-left">
                                <ol class="breadcrumb mb-2">
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/view_institution/<?= $this->uri->segment(3); ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                                    <?php
                                    if ($page_type == 1) {
                                        ?>
                                        <li class="breadcrumb-item">
                                            <a href="<?= base_url(); ?>admin/institutionreportdashboard/<?= $institution_details->ss_aw_id; ?>">Report Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="<?= base_url(); ?>admin/institution_individual_performance/<?= $institution_details->ss_aw_id; ?>">Individual Performance</a>
                                        </li>
                                        <li class="breadcrumb-item"><?= $child_details[0]->ss_aw_child_nick_name; ?></li>
                                        <?php    
                                    }
                                    else{
                                        ?>
                                        <li class="breadcrumb-item">
                                            <a href="<?= $program_type == 1 ? base_url().'admin/manageinstitutionusers/'.$institution_details->ss_aw_id.'/'.$userlist_page_no : base_url().'admin/manageinstitutionmastersusers/'.$institution_details->ss_aw_id.'/'.$userlist_page_no; ?>">Manage Users</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="<?= base_url(); ?>admin/institution_user_course_details/<?= $child_details[0]->ss_aw_parent_id ?>/<?= $child_details[0]->ss_aw_child_id ?>/<?= $userlist_page_no; ?>/<?= $program_type; ?>/<?= $institution_details->ss_aw_id; ?>"><?= $child_details[0]->ss_aw_child_nick_name; ?></a></li>
                                        <?php
                                    }    
                                    ?>
                                    
                                    <li class="breadcrumb-item">Assessment Score Details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                <div class="row parent-details-body">

                                <div class="col-6">
                                
                                <h4 class="details-title">Assessment Topic Name: <span><?= $assessment_details[0]->ss_aw_assesment_topic; ?>(<?= $score->wright_answers."/".$score->total_question; ?>)</span></h4>
                               </div>
                               <div class="col-6 text-right">
                                    <div class="page-title-left">
                                        <?php
                                        if ($page_type == 1) {
                                            ?>
                                            <a href="<?= base_url(); ?>admin/institution_individual_performance/<?= $institution_details->ss_aw_id; ?>" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                                            <?php    
                                        }
                                        else{
                                            ?>
                                            <a href="<?= base_url(); ?>admin/institution_user_course_details/<?= $child_details[0]->ss_aw_parent_id ?>/<?= $child_details[0]->ss_aw_child_id ?>/<?= $userlist_page_no; ?>/<?= $program_type; ?>/<?= $institution_details->ss_aw_id; ?>" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                                            <?php
                                        }    
                                        ?>
                                    </div>
                                </div>

                               
                               <table class="table" id="example1">
                                         
													<thead>
														<tr>
                                                            <th>Subtopic</th>
                                                            <th>Right</th>
                                                            <th>Wrong</th>
                                                            <th>Total</th>
														</tr>
													</thead>
													<tbody>
                                                        <?php
                                                        if (!empty($result)) {
                                                            $count = 0;
                                                            foreach ($result as $key => $value) {
                                                                $count = $count + 1;
                                                                ?>
                                                                <tr class="gradeX <?= $count % 2 == 0 ? 'blocked-row-bg' : ''; ?>" id="<?= $count; ?>">
                                                                    <td class="center"><?= $value->sub_category; ?></td>
                                                                    <td class="center"><?= $value->wright; ?></td>
                                                                    <td class="center"><?= $value->wrong; ?></td>

                                                                    <td class="center"><?= $value->wright + $value->wrong; ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
													</tbody>
												</table>
                                    </div>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>

                  



                </div> <!-- container -->

            </div> <!-- content -->
    

            <?php
                include('bottombar.php');
            ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->




    <style type="text/css">
    .verification-parent {
        position: relative;
    }

    .verification-btn {
        position: absolute;
        top: 7px;
        right: 1px;
        background: #fff;
        padding: 0px 8px;

    }

    input:disabled,
    select:disabled {
        /* background: #e6e6e6; */
        color: #d5dade;
    }
    </style>


    <?php
            include('footer.php')
        ?>


</body>

</html>