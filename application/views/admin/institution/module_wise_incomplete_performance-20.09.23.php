<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style type="text/css">
    
</style>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/view_institution/<?= $this->uri->segment(3); ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/institutionreportdashboard/<?= $institution_details->ss_aw_id; ?>">Report Dashboard</a></li>
                            <li class="breadcrumb-item">Users yet to Complete Modules</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Users yet to Complete Modules</h4>
                    </div>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <form method="post" id="demo-form" action="<?= base_url('admin/institution_module_wise_incomplete_performance/'.$this->uri->segment(3)); ?>">
                        <div class="difficulty_report_form">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group d-flex justify-content-end align-items-center pt-3">
                                        <label class="m-0 mr-2">Programme&nbsp;Type</label>
                                        <select name="programme_type" id="programme_type" class="form-control mt-0">
                                            <option value="1" <?php if(!empty($searchdata['incomplete_user_programme_type'])){ if($searchdata['incomplete_user_programme_type'] == 1){ ?> selected <?php } } ?>>Winners</option>
                                            <!-- <option value="3" <?php if(!empty($searchdata['incomplete_user_programme_type'])){ if($searchdata['incomplete_user_programme_type'] == 3){ ?> selected <?php } } ?>>Champions</option> -->
                                            <option value="5" <?php if(!empty($searchdata['incomplete_user_programme_type'])){ if($searchdata['incomplete_user_programme_type'] == 5){ ?> selected <?php } } ?>>Masters</option>
                                        </select>
                                        <div class="form-group report-goBtn ml-2 m-0" style="margin-top: 25px;">
                                            <input type="submit" name="submit" value="Go" class="btn btn-primary form-control">
                                        </div>
                                    </div>                                         
                                </div>   
                            </div> 
                        </div>
                    </form>
                    <div class="btn-container pt-3 pl-2">
                        <a href="<?= base_url(); ?>admin/institutionreportdashboard/<?= $institution_details->ss_aw_id; ?>" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>   
                    </div>
                    <?php
                    if (!empty($childs)) {
                    ?>
                        <div class="btn-container pt-3 pl-2">
                            <a href="<?= base_url(); ?>export/export_institution_module_wise_incomplete_performance/<?= $institution_details->ss_aw_id; ?>/<?= @$searchdata['incomplete_user_programme_type'] ?>" class="btn btn-success align-middle"><i class="mdi mdi-file-excel"></i>Export</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            if (!empty($childs)) {
                                ?>
                                <h4 class="text-center">No of users: <?= count($childs); ?></h4>
                                <div class="table-responsive gridview-wrapper">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Topics</th>
                                                <th></th>
                                                <th class="text-center">Lesson</th>
                                                <th class="text-center">Assessment</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Diagnostic Quiz</td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center"><a href="<?= $diagnosticincompletenum == 0 ? 'javascript:void(0)' : base_url('admin/diagnostic_incomplete_users/'.$institution_details->ss_aw_id.'/'.base64_encode(implode(",", $diagnosticincompletechilds))) ?>"><?= $diagnosticincompletenum; ?></a></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                                if (!empty($topics)) {
                                                    foreach ($topics as $key => $value) {
                                                        $lesson_id = $value['ss_aw_lession_id'];
                                                        ?>
                                                        <tr>
                                                            <td><?= $value['ss_aw_lesson_topic']; ?></td>
                                                            <td><?= $key + 1; ?></td>
                                                            <td class="text-center">
                                                                <?php
                                                                if ($lessonnonaccessable[$lesson_id] == 0) {
                                                                    echo "NA";
                                                                }
                                                                else{
                                                                    ?>
                                                                    <a href="<?= $lessonincompletenum[$lesson_id] == 0 ? 'javascript:void(0)' : base_url('admin/lesson_incomplete_users/'.$institution_details->ss_aw_id.'/'.base64_encode(implode(",", $lessonincompletechilds[$lesson_id]))) ?>"><?= $lessonincompletenum[$lesson_id]; ?></a>
                                                                    <?php    
                                                                }
                                                                ?>
                                                                
                                                            </td>
                                                            <td class="text-center">
                                                                <?php
                                                                if ($assessmentnonaccessable[$lesson_id] == 0) {
                                                                    echo "NA";
                                                                }
                                                                else{
                                                                    ?>
                                                                    <a href="<?= $assessmentincompletenum[$lesson_id] == 0 ? 'javascript:void(0)' : base_url('admin/assessment_incomplete_users/'.$institution_details->ss_aw_id.'/'.base64_encode(implode(",", $assessmentincompletechilds[$lesson_id]))) ?>"><?= $assessmentincompletenum[$lesson_id]; ?></a>    
                                                                    <?php
                                                                }
                                                                ?>
                                                                
                                                            </td>    
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>    
                                <?php
                            }
                            else{
                                ?>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h4 class="text-danger">Sorry! no data found</h4>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
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
<?php
include('footer.php')
?>
</body>
</html>