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
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/view_institution/<?= $institution_details->ss_aw_id; ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/institutionreportdashboard/<?= $institution_details->ss_aw_id; ?>">Report Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/readalog_count/<?= $institution_details->ss_aw_id; ?>">Readalong Count</a></li>
                            <li class="breadcrumb-item"><?= $title ?></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples"><?= $title ?></h4>
                    </div>
                </div>

            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            if (!empty($readalong_details)) {
                                ?>
                                <div class="row">
                                <div class="col-4">
                                    <h4 class="text-left">User Name: <?= $child_details[0]->ss_aw_child_nick_name; ?></h4>    
                                </div>
                                <div class="col-4">
                                    <h4 class="text-center">No of Readalongs: <?= count($readalong_details); ?></h4>
                                </div>
                                <div class="col-4">
                                    
                                </div>
                                </div>
                                <div class="table-responsive gridview-wrapper">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sl.</th>
                                                <th>Readalong Title</th>
                                                <th>Readalong Topic</th> 
                                                <th>Completion Date</th> 
                                                <th>Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sl = 1;
                                            foreach ($readalong_details as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $sl ?></td>
                                                    <td><?= $value['ss_aw_title']; ?></td>
                                                    <td><?= $value['ss_aw_topic']; ?></td>                                              
                                                    <td><?= $value['ss_aw_create_date'] != '' ? date_format(date_create($value['ss_aw_create_date']), 'd-m-Y H:i:s') : ''; ?></td> 
                                                    <td><a target="_blank" href="<?= base_url(); ?>admin/readalnongscoredetails/<?= $institution_details->ss_aw_id; ?>/<?= $this->uri->segment(3); ?>/<?= $value['ss_aw_id']; ?>"><?= $value['right_answer']."/".$value['total_question'] ?></a></td>                                             
                                                </tr>  
                                                <?php
                                                $sl++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>    
                                <?php
                            } else {
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