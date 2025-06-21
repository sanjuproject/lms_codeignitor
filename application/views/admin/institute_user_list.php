<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<style>
    .notification-wrapper .mdi-bell {
        font-size: 1.2rem;
        color: #fc6352 !important;
        position: relative;
        top: -4px;
    }

    .notification-wrapper .mdi-bell span {
        font-size: 10px;
        color: #fff;
        position: absolute;
        left: 0;
        right: 0;
        top: 3px;
        text-align: center;
        font-style: normal;
    }
</style>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Institution Name: <?= $institution_details->ss_aw_name; ?></h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive gridview-wrapper">
                                <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Admin Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($users)) {
                                            foreach ($users as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $value->ss_aw_parent_full_name; ?></td>
                                                    <td><?= $value->ss_aw_parent_email; ?></td>
                                                    <td>
                                                        <a href="#" onclick="return reset_password('<?= $value->ss_aw_parent_id; ?>');" class="badge badge-soft-success" data-toggle="modal" data-target="#add-institution-modal">Reset Password</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        else{
                                            ?>
                                            <tr>
                                                <td colspan="12">No record found.</td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="text-right">
                        <ul class="pagination pagination-rounded justify-content-end">
                            <!-- Show pagination links -->
                            <?php foreach ($links as $link) {
                                echo "<li>" . $link . "</li>";
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>



        </div> <!-- container -->

    </div> <!-- content -->

    <!-- add parent modal -->
    <div class="modal fade" id="add-institution-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog customewidth modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Reset Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body p-4">
                    <form class="parsley-examples" method="post" id="demo-form" novalidate="" action="<?= base_url(); ?>admin/reset_institution_user_password">
                        <input type="hidden" name="record_id" id="record_id">
                        <input type="hidden" name="institution_id" id="institution_id" value="<?= $institution_details->ss_aw_id; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="password" class="form-control parsley-success" name="password" id="password" placeholder="Enter password" data-parsley-minlength="8" data-parsley-required-message=" Please enter your new password." data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1" data-parsley-required="" data-parsley-id="29"><ul class="parsley-errors-list" id="parsley-id-29" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Enter password again" data-parsley-minlength="8" data-parsley-errors-container=".errorspanconfirmnewpassinput" data-parsley-required-message="Please re-enter your new password." data-parsley-equalto="#password" data-parsley-required="" data-parsley-id="31" aria-describedby="parsley-id-31">
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </div>

                        <div class="text-left">
                            <input type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton" value="Save">
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" onclick="Custombox.close();">Cancel</button>
                        </div>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- end add parent -->

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
<script type="text/javascript">
    function reset_password(record_id) {
        console.log({record_id});
        document.getElementById('record_id').value = record_id;
    }
</script>

</body>

</html>