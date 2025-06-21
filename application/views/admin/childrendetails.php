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
                        <h4 class="page-title parsley-examples">Manage Parents > Children Details</h4>
                    </div>
                </div>
                <div class="col-12">
                    <a href="<?= base_url(); ?>admin/manageparents/<?= $manage_parent_page; ?>" class="btn btn-primary" id="backBtn">Back</a>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-8">

                                    <!-- <a href="javascript:void(0);" class="btn btn-danger mb-2"
                                                data-toggle="modal" data-target="#custom-modal"><i
                                                    class="mdi mdi-plus-circle mr-2"></i> Remove Selected Children</a> -->
                                </div>
                                <div class="col-sm-4">
                                    <div class="text-sm-right">
                                        <form action="#" id="demo-form">
                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search"
                                                        aria-label="Recipient's username">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary waves-effect waves-light"
                                                            type="button">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <div class="table-responsive gridview-wrapper">
                                <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>

                                            <th># SL NO.</th>
                                            <th>Child Code</th>
                                            <th>P.Photo</th>

                                            <th class="namecol">Name</th>
                                            <th>Age (DOB)</th>
                                            <th class="mobilecol">Mobile</th>
                                            <th class="emailcol">Email</th>
                                            <th>Level</th>
                                            <th>Payment Status</th>
                                            <th>C.S Date</th>
                                            <th>C.Status</th>
                                            <th>Status</th>
                                            <th class="actioncol">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php
                                        $sl = 1;
                                        foreach ($result as $value) {
                                            $child_id = $value->ss_aw_child_id;
                                            $child_status = $value->ss_aw_child_status;
                                            $block_status = $value->ss_aw_blocked;
                                        ?>

                                            <tr>


                                                <td><?php echo $sl; ?></td>
                                                <td>
                                                    <?php echo  $value->ss_aw_child_code; ?>
                                                </td>
                                                <td class="table-user">
                                                    <img src="<?php echo base_url(); ?>uploads/profile.jpg" alt="table-user"
                                                        class="mr-2 rounded-circle">
                                                    <!-- <a href="javascript:void(0);" class="text-body font-weight-semibold">Paul J. Friend</a> -->
                                                </td>

                                                <td>
                                                    <?php echo  $value->ss_aw_child_nick_name; ?>

                                                </td>
                                                <td><?= calculate_age($value->ss_aw_child_dob); ?> yrs (<?php echo date("d M, Y", strtotime($value->ss_aw_child_dob)); ?>)</td>
                                                <td><?php echo  $value->ss_aw_child_mobile; ?></td>
                                                <td>
                                                    <?php
                                                    if ($value->ss_aw_child_email != "") {
                                                        echo $value->ss_aw_child_email;
                                                    } else {
                                                        echo $value->ss_aw_parent_email;
                                                    }
                                                    ?>

                                                </td>
                                                <td>
                                                    <?php
                                                    if ($value->course == 1) {
                                                        echo "E";
                                                    } elseif ($value->course == 2) {
                                                        echo "C";
                                                    } elseif ($value->course == 3) {
                                                        echo "A";
                                                    } else {
                                                        echo "NA";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($paymentstatus[$value->ss_aw_child_id]['payment_status'] == 1) {
                                                    ?>
                                                        <a href="#" class="badge badge-soft-success">Paid</a>
                                                        <a href="javascript:void(0)" class="badge badge-soft-danger" data-toggle="modal" data-target="#warning-unpaid-modal" data-child="<?= $value->ss_aw_child_id; ?>">Mark as Unpaid</a>
                                                        <?php
                                                    } elseif ($paymentstatus[$value->ss_aw_child_id]['payment_status'] == 2) {
                                                        if ($value->course == 1) {
                                                            $duration = EMERGING_EMI_DURATION;
                                                        } elseif ($value->course == 2) {
                                                            $duration = CONSOLIDATED_EMI_DURATION;
                                                        } else {
                                                            $duration = ADVANCED_EMI_DURATION;
                                                        }

                                                        if ($duration == $paymentstatus[$value->ss_aw_child_id]['emi_count']) {
                                                        ?>
                                                            <a href="#" class="badge badge-soft-success">Paid</a>
                                                            <a href="javascript:void(0)" class="badge badge-soft-danger" data-toggle="modal" data-target="#warning-unpaid-modal" data-child="<?= $value->ss_aw_child_id; ?>">Mark as Unpaid </a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="#" onclick="return make_payment('<?php echo $child_id; ?>', 1)" class="badge badge-soft-danger" data-toggle="modal"
                                                                data-target="#payment-modal">Mark As Pay ( <?= $paymentstatus[$value->ss_aw_child_id]['emi_count']; ?> / <?= $duration; ?>)</a>
                                                            <a href="javascript:void(0)" class="badge badge-soft-danger" data-toggle="modal" data-target="#warning-unpaid-modal" data-child="<?= $value->ss_aw_child_id; ?>">Mark as Unpaid </a>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <a href="#" onclick="return make_payment('<?php echo $child_id; ?>', 0)" class="badge badge-soft-danger" data-toggle="modal"
                                                            data-target="#payment-modal">Mark As Pay</a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= date('d F, Y', strtotime($value->course_start_date)); ?></td>
                                                <td>
                                                    <a href="#">Lessons: <?= $lessoncount[$value->ss_aw_child_id]; ?></a>
                                                    <a href="#">Assessments: <?= $assessmentcount[$value->ss_aw_child_id]; ?></a>
                                                    <a href="#">ReadAlong: <?= $readalongcount[$value->ss_aw_child_id]; ?></a>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($value->parent_block_status == 1) {
                                                    ?>
                                                        <a href="javascript:void(0)" class="badge badge-soft-danger">Not-Active</a>
                                                        <?php
                                                    } else {
                                                        if ($child_status == 1) {
                                                        ?>
                                                            <a href="#" onclick="return change_active_status('<?php echo $child_id; ?>','<?php echo $child_status; ?>')" class="badge badge-soft-success" data-toggle="modal"
                                                                data-target="#warning-status-modal">Active</a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="#" onclick="return change_active_status('<?php echo $child_id; ?>','<?php echo $child_status; ?>')" class="badge badge-soft-danger" data-toggle="modal"
                                                                data-target="#warning-status-modal">Not-Active</a>
                                                        <?php
                                                        }

                                                        if ($block_status == 1) {
                                                        ?>
                                                            <a href="#" onclick="return change_block_status('<?php echo $child_id; ?>','<?php echo $block_status; ?>')" class="badge badge-soft-danger" data-toggle="modal"
                                                                data-target="#warning-block-status-modal">Block</a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="#" onclick="return change_block_status('<?php echo $child_id; ?>','<?php echo $block_status; ?>')" class="badge badge-soft-success" data-toggle="modal"
                                                                data-target="#warning-block-status-modal">Unblock</a>
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </td>

                                                <td class="actioncell">
                                                    <!-- <a href="javascript:void(0);" class="action-icon"  title="Edit" data-plugin="tippy"
                                                            data-tippy-animation="shift-away" data-tippy-arrow="true"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a> -->
                                                    <a href="javascript:void(0);" onclick="return delete_child('<?php echo $child_id; ?>');" class="action-icon"
                                                        data-toggle="modal" data-target="#warning-delete-modal"
                                                        title="Delete" data-plugin="tippy"
                                                        data-tippy-animation="shift-away" data-tippy-arrow="true">
                                                        <i class="mdi mdi-delete"></i></a>

                                                    <?php
                                                    if (!empty($value->ss_aw_child_auth_key)) {
                                                    ?>
                                                        <a href="javascript:void(0);" onclick="return child_logout('<?php echo $child_id; ?>');" class="action-icon" data-toggle="modal" data-target="#warning-logout-modal" title="Logout" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"> <i
                                                                class="fe-log-out"></i></a>
                                                    <?php } ?>

                                                    <?php
                                                    if ($course_complete_status[$value->ss_aw_child_id]) {
                                                    ?>
                                                        <a href="<?= base_url(); ?>testingapi/generateindividualscore/<?= $value->ss_aw_child_id; ?>/<?= $value->course; ?>/<?= $parent_id; ?>" class="badge badge-soft-success">Generate Score Card</a>
                                                    <?php
                                                    }
                                                    ?>

                                                </td>
                                            </tr>
                                        <?php
                                            $sl++;
                                        }
                                        ?>
                                        <?php
                                        if (!empty($temp_cilds) && $result[0]->parent_block_status == 0) {
                                            foreach ($temp_cilds as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td><?= $sl++; ?></td>
                                                    <td></td>
                                                    <td class="table-user">
                                                        <img src="<?php echo base_url(); ?>uploads/profile.jpg" alt="table-user" class="mr-2 rounded-circle">
                                                    </td>
                                                    <td><?= $value->ss_aw_child_nick_name; ?></td>
                                                    <td><?php echo  $value->ss_aw_child_age; ?> yrs (<?php echo date("d M, Y", strtotime($value->ss_aw_child_dob)); ?>)</td>
                                                    <td><?= $value->ss_aw_child_mobile; ?></td>
                                                    <td><?= $value->ss_aw_child_email; ?></td>
                                                    <td>NA</td>
                                                    <td>NA</td>
                                                    <td>NA</td>
                                                    <td>NA</td>
                                                    <td>
                                                        <a href="#" onclick="childapproval(<?= $value->ss_aw_child_temp_id; ?>)" class="badge badge-soft-success" data-toggle="modal"
                                                            data-target="#child-approval-modal">Approve</a>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0);" onclick="return delete_temp_child('<?php echo $value->ss_aw_child_temp_id; ?>');" class="action-icon"
                                                            data-toggle="modal" data-target="#warning-temp-delete-modal"
                                                            title="Delete" data-plugin="tippy"
                                                            data-tippy-animation="shift-away" data-tippy-arrow="true">
                                                            <i class="mdi mdi-delete"></i></a>
                                                    </td>
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
    <!-- Delete confirmation dialog -->
    <div id="warning-delete-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3">Deleting will remove this child from the system. Are you sure ?</p>
                        <div class="button-list">
                            <form action="<?php echo base_url(); ?>/admin/childrendetails/<?php echo $this->uri->segment(3); ?>" method="post">
                                <input type="hidden" name="delete_child" value="delete_child">
                                <input type="hidden" name="delete_child_id" id="delete_child_id">
                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="warning-temp-delete-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3">Deleting will remove this child from the system. Are you sure ?</p>
                        <div class="button-list">
                            <form action="<?php echo base_url(); ?>/admin/childrendetails/<?php echo $this->uri->segment(3); ?>" method="post">
                                <input type="hidden" name="delete_temp_child" value="delete_temp_child">
                                <input type="hidden" name="delete_child_temp_id" id="delete_child_temp_id">
                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!--Status update confirmation dialog -->
    <div id="warning-status-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3">Are you sure you want to update the status?</p>
                        <div class="button-list">
                            <form action="<?php echo base_url(); ?>/admin/childrendetails/<?php echo $this->uri->segment(3); ?>" method="post">
                                <input type="hidden" name="chnage_child_status" value="chnage_child_status">
                                <input type="hidden" name="status_child_id" id="status_child_id">
                                <input type="hidden" name="status_child_status" id="status_child_status">

                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- 4th child approval popup -->
    <div id="child-approval-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3">Are you sure you want to approve this child?</p>
                        <div class="button-list">
                            <form action="<?php echo base_url(); ?>/admin/childrendetails/<?php echo $this->uri->segment(3); ?>" method="post">
                                <input type="hidden" name="child_approval" value="child_approval">
                                <input type="hidden" name="approval_child_id" id="approval_child_id">
                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of code -->

    <div id="warning-block-status-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3">Are you sure you want to update the block status?</p>
                        <div class="button-list">
                            <form action="<?php echo base_url(); ?>/admin/childrendetails/<?php echo $this->uri->segment(3); ?>" method="post">
                                <input type="hidden" name="chnage_child_block_status" value="chnage_child_block_status">
                                <input type="hidden" name="block_child_id" id="block_child_id">
                                <input type="hidden" name="block_child_status" id="block_child_status">

                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- Mark as payment modal -->
    <div id="payment-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <h4 class="mt-2">Make Payment</h4>
                        <div class="button-list">
                            <form action="<?php echo base_url(); ?>admin/mark_payment" method="post">
                                <input type="hidden" name="payment_child_id" id="payment_child_id">
                                <input type="hidden" name="payment_parent_id" id="payment_parent_id" value="<?= $parent_id; ?>">
                                <div class="form-group">
                                    <label>Course</label>
                                    <select name="course_id" id="course_id" class="form-control">
                                        <option value="">Choose One</option>
                                        <?php
                                        if (!empty($courses)) {
                                            foreach ($courses as $key => $value) {
                                        ?>
                                                <option value="<?= $value['ss_aw_course_id'] ?>"><?= $value['ss_aw_course_name']; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Transaction ID</label>
                                    <input type="text" name="transaction_id" id="transaction_id" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Payment Amount</label>
                                    <input type="text" name="payment_amount" id="payment_amount" class="form-control" required>
                                </div>
                                <div class="form-group" id="emi_payment_view">
                                    <input type="checkbox" name="emi_payment" value="1" id="emi_payment"><label for="promoted">Emi Payment</label>
                                </div>
                                <button type="submit" class="btn btn-danger">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="warning-logout-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3">Are you sure you want to logout childs?</p>
                        <div class="button-list">
                            <form action="<?php echo base_url(); ?>admin/childrendetails/<?php echo $this->uri->segment(3); ?>" method="post">
                                <input type="hidden" id="logout_child_id" name="logout_child_id">

                                <input type="hidden" name="child_logout" value="child_logout">
                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="warning-unpaid-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3" id="status_warning_msg">Do you want to mark this user as unpaid?</p>
                        <div class="button-list">
                            <form action="<?php echo base_url() ?>admin/unpaid_user" method="post">
                                <input type="hidden" id="child_id" name="child_id">
                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- End of section -->

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
    $('#warning-unpaid-modal').on('show.bs.modal', function(e) {
        var child_id = $(e.relatedTarget).data('child');
        $("#child_id").val(child_id);
    });

    function change_active_status(child_id, child_status) {
        if (child_status == 1) {
            child_status = 0;
        } else {
            child_status = 1;
        }
        document.getElementById('status_child_id').value = child_id;
        document.getElementById('status_child_status').value = child_status;
    }

    function change_block_status(child_id, block_status) {
        if (block_status == 1) {
            block_status = 0;
        } else {
            block_status = 1;
        }
        document.getElementById('block_child_id').value = child_id;
        document.getElementById('block_child_status').value = block_status;
    }

    function delete_child(child_id) {
        document.getElementById('delete_child_id').value = child_id;
    }

    function delete_temp_child(child_id) {
        document.getElementById('delete_child_temp_id').value = child_id;
    }

    function child_logout(child_id) {
        document.getElementById('logout_child_id').value = child_id;
    }

    function make_payment(child_id, emi_payment) {
        document.getElementById('payment_child_id').value = child_id;
    }

    function childapproval(child_id) {
        document.getElementById('approval_child_id').value = child_id;
    }
    $("#course_id").change(function() {
        let courseId = $("#course_id").val();
        if (courseId == 5) {
            $("#emi_payment_view").css('display', 'none');
        } else {
            $("#emi_payment_view").css('display', 'block');
        }
    });
</script>

</body>

</html>