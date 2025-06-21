
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title-left">
                                <ol class="breadcrumb mb-2">
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/manageparents">Manage Parents</a></li>
                                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>admin/parentdetail/<?= $parent_id; ?>"><?= $parent_details[0]->ss_aw_parent_full_name; ?></a></li>
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                    
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">


                                <div class="row parent-details-body">

                               <div class="col-4">
<h4 class="details-title">Parent Name: <span><?= $parent_details[0]->ss_aw_parent_full_name; ?></span></h4>
<h4 class="details-title">Date of app signup: <span><?= date('d/m/Y', strtotime($parent_details[0]->ss_aw_parent_created_date)); ?></span></h4>
                               </div>

                               <div class="col-4">
<h4 class="details-title">Number of children registered: <span><?= count($child_details); ?></span></h4>
<h4 class="details-title">Type of device: <span><?= $parent_details[0]->ss_aw_device_type; ?></span></h4>
                               </div>

                               <div class="col-4">
<h4 class="details-title">Name of Children</h4>
<ul class="children_name">
    <?php
    if (!empty($child_details)) {
        foreach ($child_details as $key => $value) {
            ?>
            <li>
                <a href="<?= base_url(); ?>admin/child_course_details/<?= $parent_details[0]->ss_aw_parent_id ?>/<?= $value->ss_aw_child_id; ?>"><?= $value->ss_aw_child_nick_name; ?></a>
            </li>           
            <?php
        }
    }
    else{
        ?>
        <li>No Data</li>
        <?php
    }
    ?>
</ul>
                               </div>
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