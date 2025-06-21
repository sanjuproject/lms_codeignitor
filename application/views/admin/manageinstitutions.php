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

<style type="text/css">
    input.parsley-success,
    select.parsley-success,
    textarea.parsley-success {
        color: #468847;
        background-color: #DFF0D8;
        border: 1px solid #D6E9C6;
    }

    input.parsley-error,
    select.parsley-error,
    textarea.parsley-error {
        color: #B94A48;
        background-color: #F2DEDE;
        border: 1px solid #EED3D7;
    }

    .parsley-errors-list {
        margin: 2px 0 3px;
        padding: 0;
        list-style-type: none;
        font-size: 0.9em;
        line-height: 0.9em;
        opacity: 0;
        color: #B94A48;

        transition: all .3s ease-in;
        -o-transition: all .3s ease-in;
        -moz-transition: all .3s ease-in;
        -webkit-transition: all .3s ease-in;
    }

    .parsley-errors-list.filled {
        opacity: 1;
    }

    .form-section {
        padding-left: 15px;
        display: none;
    }

    .form-section.current {
        display: inherit;
    }

    .btn-info,
    .btn-default {
        margin-top: 10px;
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
                        <h4 class="page-title parsley-examples">Manage Institutions</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-4">

                                    <a href="javascript:void(0);" class="btn btn-danger mb-2" data-toggle="modal" data-target="#add-institution-modal"><i class="mdi mdi-plus-circle mr-2"></i> Add Institution</a>
                                </div>
                                <div class="col-sm-4">


                                </div>
                                <div class="col-sm-4">
                                    <div class="text-sm-right">
                                        <form action="<?php echo base_url() ?>admin/search_institution" method="post" id="filter-form">
                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <input type="text" name="search_data" class="form-control" placeholder="Search..." aria-label="Recipient's username" 
                                                    <?php
                                                        if (isset($search_data)) {
                                                            echo 'value="' . $search_data . '"';
                                                        }
                                                        ?>>

                                                    <div class="input-group-append" style="position:relative;">
                                                        <?php
                                                        if (!empty($search_data)) {
                                                        ?>
                                                            <div style="position: absolute; right: 20; left: -25px; padding: 8px; cursor: pointer;">
                                                                <i class="fas fa-times" style="cursor: pointer;" onclick="resetsearch();"></i>
                                                            </div>

                                                        <?php
                                                        }
                                                        ?>
                                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Search</button>
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
                                            <th>Institution Name</th>
                                            <th>Admin Name</th>
                                            <th>Mobile No</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($institutions)) {
                                            foreach ($institutions as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td><a href="<?= base_url(); ?>admin/view_institution/<?= $value->ss_aw_id; ?>/<?= $page; ?>"><?= $value->ss_aw_name; ?></a></td>
                                                    <td><?= $value->ss_aw_parent_full_name ?></td>
                                                    <td><?= $value->ss_aw_mobile_no; ?></td>
                                                    <td><?= $value->ss_aw_parent_email ?></td>
                                                    <td>
                                                        <?php
                                                        if ($value->ss_aw_status == 1) {
                                                        ?>
                                                            <a href="#" onclick="return change_status('<?= $value->ss_aw_id; ?>','<?= $value->ss_aw_status; ?>');" class="badge badge-soft-success" data-toggle="modal" data-target="#warning-status-modal">Active</a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="#" onclick="return change_status('<?= $value->ss_aw_id; ?>','<?= $value->ss_aw_status; ?>');" class="badge badge-soft-danger" data-toggle="modal" data-target="#warning-status-modal">Inactive</a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url(); ?>admin/update_institutions/<?= $value->ss_aw_id; ?>" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                        <a onclick="remove_institution(<?= $value->ss_aw_id; ?>)" href="javascript:void(0);" class="action-icon" data-toggle="modal" data-target="#warning-delete-modal"> <i class="mdi mdi-delete"></i></a>
                                                        <a href="#" onclick="return reset_password('<?= $value->ss_aw_parent_id ?>','<?= $value->ss_aw_id; ?>');" class="badge badge-soft-primary" data-toggle="modal" data-target="#reset-password-modal">Reset Password</a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
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
    <!-- Delete confirmation dialog -->
    <div id="warning-delete-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-warning h1 text-warning"></i>
                        <h4 class="mt-2">Warning!</h4>
                        <p class="mt-3">Deleting will remove this parent from the system. Are you sure ?</p>
                        <div class="button-list">
                            <form action="<?php echo base_url() ?>admin/remove_institutions" method="post">
                                <input type="hidden" name="record_id" id="remove_record_id">
                                <input type="hidden" id="page_no" name="page_no" value="<?= $page; ?>">
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
                            <form action="<?php echo base_url(); ?>admin/change_institution_status" method="post">
                                <input type="hidden" id="record_id" name="record_id">
                                <input type="hidden" id="page_no" name="page_no" value="<?= $page; ?>">
                                <input type="hidden" id="status" name="status">
                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>

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
                        <p class="mt-3">Are you sure you want to logout parents?</p>
                        <div class="button-list">
                            <form action="<?php echo base_url(); ?>admin/manageparents" method="post">
                                <input type="hidden" id="logout_parent_id" name="logout_parent_id">

                                <input type="hidden" name="parent_logout" value="parent_logout">
                                <button type="submit" class="btn btn-danger">Yes</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- add parent modal -->
    <div class="modal fade" id="add-institution-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog customewidth modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Institution</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="resetForm('frm-add-institution')">×</button>
                </div>

                <div class="modal-body p-4">
                    <form class="demo-form no-load" method="post" id="frm-add-institution" novalidate="" action="<?= base_url(); ?>admin/manage_institutions">
                        <input type="hidden" name="page_no" value="<?= $page; ?>">
                        <div class="form-section">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="institutionname">Name of the Institution <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input tabindex="1" class="form-control" type="text" name="institutionname" id="institutionname" placeholder="Enter the Name of your Institution" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input tabindex="2" type="text" class="form-control" name="address" id="address" required="" placeholder="Enter address">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <select tabindex="4" name="country" id="country" class="form-control" required="" onchange="getStates(this.value);">
                                                <option value="">Select country</option>
                                                <?php
                                                if (!empty($countries)) {
                                                    foreach ($countries as $key => $value) {
                                                ?>
                                                        <option value="<?= $value['id'] ?>"><?= $value['name']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pin">Pin Code <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input tabindex="6" type="text" class="form-control" name="pin" id="pin" required="" placeholder="Enter Zip Code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Mobile">Mobile <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input tabindex="8" type="text" class="form-control" required="" placeholder="Enter only mobile numbers" id="Mobile" data-toggle="input-mask" name="mobile" data-mask-format="0000000000" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input tabindex="10" type="password" class="form-control" name="password" id="password" placeholder="Enter password" data-parsley-minlength="8" data-parsley-required-message=" Please enter your new password." data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1" data-parsley-required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="city">City <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input tabindex="3" type="text" class="form-control" name="city" id="city" required="" placeholder="Enter city">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="state">State <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <select tabindex="5" name="state" id="state" class="form-control" required="">
                                                <option value="">Select state</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="adminname">Admin Name <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input tabindex="7" class="form-control" type="text" name="adminname" id="adminname" placeholder="Enter admin name" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="emailaddress">Email <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input tabindex="9" type="email" class="form-control" name="email" id="emailaddress" required="" parsley-type="email" placeholder="Enter email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmpassword">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input tabindex="11" type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Enter password again" data-parsley-minlength="8" data-parsley-errors-container=".errorspanconfirmnewpassinput" data-parsley-required-message="Please re-enter your new password." data-parsley-equalto="#password" data-parsley-required="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-section">
                            <div class="row" id="step2">
                                <div class="col-sm-12">
                                    <h4 class="page-title mt-0"><?= Winners ?> Programme</h4>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="championsemiprice">Lumpsum Price(Including GST) <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input type="text" class="form-control" required="" placeholder="Enter the price" id="lumpsum_price" data-toggle="input-mask" data-mask-format="000000" name="lumpsum_price" parsley-type="lumpsum_price" maxlength="6">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="championsemiprice">EMI Price(Including GST) <span class="text-danger">*</span></label>
                                        <div class="verification-parent">
                                            <input type="text" class="form-control" required="" placeholder="Enter the price" id="emi_price" data-toggle="input-mask" data-mask-format="000000" name="emi_price" parsley-type="emi_price" maxlength="6">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="coupon_code_lumpsum">Special coupon code(Lumpsum)</label>
                                        <div class="verification-parent">
                                            <select name="coupon_code_lumpsum" id="coupon_code_lumpsum" class="form-control" parsley-type="coupon_code_lumpsum">
                                                <option value="">Select Special Coupon Code</option>
                                                <?php
                                                if (!empty($lumpsum_coupons)) {
                                                    foreach ($lumpsum_coupons as $key => $value) {
                                                ?>
                                                        <option value="<?= $value->ss_aw_id; ?>"><?= $value->ss_coupon_code; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="coupon_code_emi">Special coupon code(EMI)</label>
                                        <div class="verification-parent">
                                            <select name="coupon_code_emi" id="coupon_code_emi" class="form-control" parsley-type="coupon_code_emi">
                                                <option value="">Select Special Coupon Code</option>
                                                <?php
                                                if (!empty($emi_coupons)) {
                                                    foreach ($emi_coupons as $key => $value) {
                                                ?>
                                                        <option value="<?= $value->ss_aw_id; ?>"><?= $value->ss_coupon_code; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <hr />
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="page-title mt-0">Champions Programme</h4>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="champions_lumpsum_price">Lumpsum Price(Including GST) <span class="text-danger">*</span></label>
                                            <div class="verification-parent">
                                                <input class="form-control" type="text" name="champions_lumpsum_price" id="champions_lumpsum_price" placeholder="Enter Lumpsum price" data-parsley-type="number" min="0" max="100000" required="" parsley-type="champions_lumpsum_price">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="champions_emi_price">EMI Price(Including GST) <span class="text-danger">*</span></label>
                                            <div class="verification-parent">
                                                <input class="form-control" type="text" name="champions_emi_price" id="champions_emi_price" placeholder="Enter EMI price" data-parsley-type="number" min="0" max="100000" required="" parsley-type="champions_emi_price">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="champions_coupon_code_lumpsum">Special coupon code(Lumpsum)</label>
                                            <div class="verification-parent">
                                                <select name="champions_coupon_code_lumpsum" id="champions_coupon_code_lumpsum" class="form-control parsley-success" parsley-type="champions_coupon_code_lumpsum">
                                                    <option value="">Select Special Coupon Code</option>
                                                    <?php
                                                    if (!empty($lumpsum_coupons)) {
                                                        foreach ($lumpsum_coupons as $key => $value) {
                                                    ?>
                                                            <option value="<?= $value->ss_aw_id; ?>"><?= $value->ss_coupon_code; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="champions_coupon_code_emi">Special coupon code(EMI)</label>
                                            <div class="verification-parent">
                                                <select name="champions_coupon_code_emi" id="champions_coupon_code_emi" class="form-control parsley-success" parsley-type="champions_coupon_code_emi">
                                                    <option value="">Select Special Coupon Code</option>
                                                    <?php
                                                    if (!empty($emi_coupons)) {
                                                        foreach ($emi_coupons as $key => $value) {
                                                    ?>
                                                            <option value="<?= $value->ss_aw_id; ?>"><?= $value->ss_coupon_code; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <hr />
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="page-title mt-0"><?= Master ?>s Programme</h4>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="masters_lumpsum_price">Lumpsum Price(Including GST) <span class="text-danger">*</span></label>
                                            <div class="verification-parent">
                                                <input class="form-control" type="text" name="masters_lumpsum_price" id="masters_lumpsum_price" placeholder="Enter Lumpsum price" data-parsley-type="number" min="0" max="100000" required="" parsley-type="masters_lumpsum_price">

                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="masters_emi_price">EMI Price(Including GST) <span class="text-danger">*</span></label>
                                            <div class="verification-parent">
                                                <input class="form-control" type="text" name="masters_emi_price" id="masters_emi_price" placeholder="Enter EMI price" data-parsley-type="number" min="0" max="100000" required="" parsley-type="championsemiprice">

                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="masters_coupon_code_lumpsum">Special coupon code(Lumpsum)</label>
                                            <div class="verification-parent">
                                                <select name="masters_coupon_code_lumpsum" id="masters_coupon_code_lumpsum" class="form-control parsley-success" parsley-type="masters_coupon_code_lumpsum">
                                                    <option value="">Select Special Coupon Code</option>
                                                    <?php
                                                    if (!empty($lumpsum_coupons)) {
                                                        foreach ($lumpsum_coupons as $key => $value) {
                                                    ?>
                                                            <option value="<?= $value->ss_aw_id; ?>"><?= $value->ss_coupon_code; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="masters_coupon_code_emi">Special coupon code(EMI)</label>
                                            <div class="verification-parent">
                                                <select name="masters_coupon_code_emi" id="masters_coupon_code_emi" class="form-control parsley-success" parsley-type="masters_coupon_code_emi">
                                                    <option value="">Select Special Coupon Code</option>
                                                    <?php
                                                    if (!empty($emi_coupons)) {
                                                        foreach ($emi_coupons as $key => $value) {
                                                    ?>
                                                            <option value="<?= $value->ss_aw_id; ?>"><?= $value->ss_coupon_code; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div> -->

                                </div>
                                <div>
                                    <hr />
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="page-title mt-0"><?= Diagnostic ?>s Programme (<small>** No Partial Payment</small>)</h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="masters_lumpsum_price">Lumpsum Price </label>
                                            <div class="verification-parent">
                                                <input class="form-control" type="text" name="diagnostic_lumpsum_price" id="diagnostic_lumpsum_price" placeholder="Enter Lumpsum price" data-parsley-type="number" min="0" max="100000" parsley-type="diagnostic_lumpsum_price" data-parsley-group="step2" value="">
                                                <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                <div class="verification-btn error_msg">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" id="partial_payment" name="partial_payment" value="1">Allow Partial Payment
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-navigation text-right">
                            <button type="button" class="previous btn btn-primary pull-left">Back</button>
                            <button type="button" class="next btn btn-primary pull-right text-right">Next</button>
                            <input type="submit" class="btn btn-success pull-right">
                            <span class="clearfix"></span>
                        </div>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- end add parent -->

    <div class="modal fade" id="reset-password-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog customewidth modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Reset Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body p-4">
                    <form class="parsley-examples" method="post" id="demo-form" novalidate="" action="<?= base_url(); ?>admin/reset_institution_user_password">
                        <input type="hidden" name="record_id" id="reset_password_record_id">
                        <input type="hidden" name="institution_id" id="institution_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">New Password <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="password" class="form-control parsley-success" name="password" id="password" placeholder="Enter password" data-parsley-minlength="8" data-parsley-required-message=" Please enter your new password." data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1" data-parsley-required="" data-parsley-id="29">
                                        <ul class="parsley-errors-list" id="parsley-id-29" aria-hidden="true"></ul>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Enter password again">
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
    function change_status(record_id, status) {
        document.getElementById('record_id').value = record_id;
        document.getElementById('status').value = status;
    }

    function remove_institution(record_id) {
        document.getElementById('remove_record_id').value = record_id;
    }

    function update_institution(record_id) {
        document.getElementById('update_record_id').value = record_id;
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>admin/edit_institutions",
            data: {
                "record_id": record_id
            },
            dataType: "JSON",
            success: function(data) {
                console.log(data);
                let institution_details = data.institution_details;
                let states = data.states;
                let admin_user = data.admin_user;

                var html = "<option value=''>Choose State</option>";
                if (states != "") {
                    states.forEach((element, i) => {
                        html += "<option value='" + element.id + "'>" + element.name + "</option>";
                    });
                    $("#edit_state").html(html);
                }

                $("#edit_institutionname").val(institution_details.ss_aw_name);
                $("#edit_address").val(institution_details.ss_aw_address);
                $("#edit_city").val(institution_details.ss_aw_city);
                $("#edit_country").val(institution_details.ss_aw_country);
                $("#edit_state").val(institution_details.ss_aw_state);
                $("#edit_pin").val(institution_details.ss_aw_pincode);
                $("#edit_mobile").val(institution_details.ss_aw_mobile_no);
                $("#edit_lumpsum_price").val(institution_details.ss_aw_lumpsum_price);
                $("#edit_emi_price").val(institution_details.ss_aw_emi_price);
                $("#edit_coupon_code").val(institution_details.ss_aw_coupon_code);

                $("#edit_adminname").val(admin_user[0].ss_aw_parent_full_name);
                $("#edit_emailaddress").val(admin_user[0].ss_aw_parent_email);
            }
        });
    }

    function getStates(countryId) {
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>admin/getstates",
            data: {
                "countryId": countryId
            },
            dataType: "JSON",
            success: function(data) {
                var html = "<option value=''>Choose State</option>";
                if (data != "") {
                    data.forEach((element, i) => {
                        console.log(element);
                        html += "<option value='" + element.id + "'>" + element.name + "</option>";
                    });
                    $("#state").html(html);
                }
            }
        });
    }

    function reset_password(record_id) {
        document.getElementById('reset_password_record_id').value = record_id;
        document.getElementById('institution_id').value = institution_id;
    }


    function resetForm(formId) {
        $('#step1 input, #step1 select').each(() => {
            $(this).removeClass('parsley-error');
        });
        console.log(formId);
        $("#" + formId)[0].reset();
    }
</script>

<script type="text/javascript">
    function resetsearch() {
        $("input[name='search_data']").val('');
        $("#filter-form").submit();
    }

    $(function() {
        var $sections = $('.form-section');

        function navigateTo(index) {
            // Mark the current section with the class 'current'
            $sections
                .removeClass('current')
                .eq(index)
                .addClass('current');
            // Show only the navigation buttons that make sense for the current section:
            $('.form-navigation .previous').toggle(index > 0);
            var atTheEnd = index >= $sections.length - 1;
            $('.form-navigation .next').toggle(!atTheEnd);
            $('.form-navigation [type=submit]').toggle(atTheEnd);
        }

        function curIndex() {
            // Return the current index by looking at which section has the class 'current'
            return $sections.index($sections.filter('.current'));
        }

        // Previous button is easy, just go back
        $('.form-navigation .previous').click(function() {
            navigateTo(curIndex() - 1);
        });

        // Next button goes forward iff current block validates
        $('.form-navigation .next').click(function() {
            $('.demo-form').parsley().whenValidate({
                group: 'block-' + curIndex()
            }).done(function() {
                navigateTo(curIndex() + 1);
            });
        });

        // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
        $sections.each(function(index, section) {
            $(section).find(':input').attr('data-parsley-group', 'block-' + index);
        });
        navigateTo(0); // Start at the beginning
    });
</script>
</body>

</html>