<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style type="text/css">
    
</style>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
<!--            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/view_institution/<?= $institution_details->ss_aw_id; ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/institutionreportdashboard/<?= $institution_details->ss_aw_id; ?>">Report Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/institution_module_wise_incomplete_performance/<?= $institution_details->ss_aw_id; ?>">Modulewise Incomplete Status for users</a></li>
                            <li class="breadcrumb-item">Delinquent Users Users</li>
                        </ol>
                    </div>
                </div>
            </div>-->
            
           
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- start page title -->
                            <div class="row">
                                <div class="col-6">
                                    <div class="page-title-box">
                                        <h4 class="page-title parsley-examples"><?=$title?></h4>
                                    </div>
                                </div>
                                <div class="col-6 text-right mt-2">
                                    <!--<a href="<?= base_url(); ?>report/days_deliquent" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>-->
                                </div>
                            </div>
                            <!-- end page title -->
                            <?php
                            if (!empty($child_list)) {
                                ?>
                                <div class="table-responsive gridview-wrapper">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>SL No.</th>
                                                <th>Username</th>
                                                <th>Institution/Parent Name</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
                                            <?php
                                            foreach ($child_list as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $key + 1; ?></td>
                                                    <td><?= $value->ss_aw_child_first_name!=''?$value->ss_aw_child_first_name." ".$value->ss_aw_child_last_name:$value->ss_aw_child_nick_name; ?></td>
                                                    <td><?= $value->institution_name!=''?$value->institution_name:$value->parent_name; ?></td>
                                                    <td><?= $value->ss_aw_child_email; ?></td>
                                                </tr>
                                                <?php
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