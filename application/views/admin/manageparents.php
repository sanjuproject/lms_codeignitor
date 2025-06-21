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
                        <h4 class="page-title parsley-examples">Manage Parents</h4>
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

                                    <a href="javascript:void(0);" class="btn btn-danger mb-2" data-toggle="modal" data-target="#add-parent-modal"><i class="mdi mdi-plus-circle mr-2"></i> Add Parent</a>

                                    <a href="javascript:void(0);" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal1-import-adults"><i class="mdi mdi-plus-circle mr-2"></i>Import Adults</a>
                                </div>
                                <div class="col-sm-4">


                                </div>
                                <div class="col-sm-4">
                                    <div class="text-sm-right">
                                        <form action="<?php echo base_url() ?>admin/manageparents" method="post" id="demo-form">
                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <input type="text" name="search_parent_data" class="form-control" placeholder="Search Parent Name" aria-label="Recipient's username" <?php
                                                                                                                                                                                            if (isset($search_parent_data)) {
                                                                                                                                                                                                echo 'value="' . $search_parent_data . '"';
                                                                                                                                                                                            } ?>>
                                                    <input type="hidden" name="search_parent" value="search_parent">
                                                    <div class="input-group-append" style="position:relative;">
                                                        <?php
                                                        if (!empty($search_parent_data)) {
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


                                            <th>Profile Photo</th>
                                            <th class="namecol">Name</th>
                                            <th>Registered Date</th>
                                            <th class="mobilecol">Mobile</th>
                                            <th class="emailcol">Email</th>
                                            <th>City</th>
                                            <th class="childrencol">Children</th>
                                            <th>Status</th>
                                            <th class="actioncol">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php
                                        $sl = 1;
                                        foreach ($result as $value) {
                                            $parent_id = $value->ss_aw_parent_id;
                                        ?>

                                            <tr>




                                                <td class="table-user">
                                                    <?php
                                                    if ($value->ss_aw_parent_profile_photo != "") {
                                                        $photo = base_url() . "uploads/" . $value->ss_aw_parent_profile_photo;
                                                    } else {
                                                        $photo = base_url() . "uploads/profile.jpg";
                                                    }
                                                    ?>
                                                    <img src="<?php echo $photo; ?>" alt="table-user" class="mr-2 rounded-circle">
                                                    <!-- <a href="javascript:void(0);" class="text-body font-weight-semibold">Paul J. Friend</a> -->
                                                </td>
                                                <td>
                                                    <a href="<?= base_url(); ?>admin/parentdetail/<?= $value->ss_aw_parent_id; ?>"><?php echo $value->ss_aw_parent_full_name; ?></a>
                                                </td>
                                                <td><?= date('d/m/y', strtotime($value->ss_aw_parent_created_date)); ?></td>
                                                <td><?php echo $value->ss_aw_parent_primary_mobile; ?></td>
                                                <td><?php echo $value->ss_aw_parent_email; ?></td>
                                                <td><?php echo $value->ss_aw_parent_city; ?></td>
                                                <td class="table-children">
                                                    <?php
                                                    if ($value->num_childs > 0) {
                                                    ?>
                                                        <a class="notification-wrapper" href="<?php echo base_url(); ?>admin/childrendetails/<?php echo $parent_id; ?>/<?= $this->uri->segment(3) ? $this->uri->segment(3) : ''; ?>"><?php echo $value->num_childs; ?><?= $value->num_temp_childs > 0 ? "<i class='mdi mdi-bell'><span>" . $value->num_temp_childs . "</span></i>" : ""; ?>
                                                        </a>

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href="#"><?php echo $value->num_childs; ?></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                                $parent_status = $value->ss_aw_parent_status;
                                                ?>
                                                <td>
                                                    <?php
                                                    if ($value->ss_aw_blocked == 1) {
                                                    ?>
                                                        <a href="javascript:void(0)" class="badge badge-soft-danger">Blocked</a>
                                                        <?php
                                                    } else {
                                                        if ($parent_status == 1) {
                                                        ?>

                                                            <a href="#" onclick="return change_status('<?php echo $parent_id ?>','<?php echo $parent_status ?>');" class="badge badge-soft-success" data-toggle="modal" data-target="#warning-status-modal">Active</a>
                                                </td>
                                            <?php
                                                        } else {
                                            ?>
                                                <a href="#" onclick="return change_status('<?php echo $parent_id ?>','<?php echo $parent_status ?>');" class="badge badge-soft-danger" data-toggle="modal" data-target="#warning-status-modal">In Active</a>
                                        <?php
                                                        }
                                                    }
                                        ?>

                                        <td>
                                            <?php
                                            if ($value->ss_aw_blocked == 0) {
                                            ?>
                                                <a href="javascript:void(0);" onclick="return parent_delete('<?php echo $parent_id; ?>');" class="action-icon" data-toggle="modal" data-target="#warning-delete-modal" title="Delete" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></a>
                                                <?php
                                                if (!empty($value->ss_aw_parent_auth_key)) {
                                                ?>
                                                    <a href="javascript:void(0);" onclick="return parent_logout('<?php echo $parent_id; ?>');" class="action-icon" data-toggle="modal" data-target="#warning-logout-modal" title="Logout" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"> <i class="fe-log-out"></i></a>
                                                <?php } ?>
                                            <?php
                                            }
                                            ?>
                                            <!-- <a href="javascript:void(0);" class="action-icon" title="Edit" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-arrow="true"> <i
                                                                class="mdi mdi-square-edit-outline"></i></a> -->

                                        </td>
                                            </tr>
                                        <?php
                                            $sl++;
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
                            <form action="<?php echo base_url() ?>admin/manageparents" method="post">
                                <input type="hidden" name="parent_delete_process" value="parent_delete_process">
                                <input type="hidden" name="parent_delete_id" id="parent_delete_id">
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
                            <form action="<?php echo base_url(); ?>admin/manageparents" method="post">
                                <input type="hidden" id="status_parent_id" name="status_parent_id">
                                <input type="hidden" id="status_parent_status" name="status_parent_status">
                                <input type="hidden" id="status_pageno" name="status_pageno">
                                <input type="hidden" name="parent_status_change" value="parent_status_change">
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
    <div class="modal fade" id="add-parent-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog customewidth modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add Parent</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body p-4">
                    <form action="<?php echo base_url(); ?>admin/add_parent" class="parsley-examples" method="post" id="demo-form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fullname">Full Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="fullname" id="fullname" placeholder="Enter name" required>
                                </div>

                                <div class="form-group">
                                    <label for="emailaddress">Email <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="email" class="form-control" name="email" id="emailaddress" required parsley-type="email" placeholder="Enter email" />
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="password" class="form-control" name="password" id="password" required parsley-type="password" placeholder="Enter password" data-parsley-minlength="8"
                                        data-parsley-required-message="Please enter your new password."
                                        data-parsley-uppercase="1"
                                        data-parsley-lowercase="1"
                                        data-parsley-number="1"
                                        data-parsley-special="1"
                                        data-parsley-required/>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="password" class="form-control" name="confirm_password" id="confirmpassword" required parsley-type="password" placeholder="Enter password again" data-parsley-minlength="8"
                                        data-parsley-errors-container=".errorspanconfirmnewpassinput"
                                        data-parsley-required-message="Please re-enter your new password."
                                        data-parsley-equalto="#password"
                                        data-parsley-required />
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="address">Address <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="text" class="form-control" name="address" id="address" required parsley-type="address" placeholder="Enter address" />
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="city">City <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="text" class="form-control" name="city" id="city" required parsley-type="" placeholder="Enter city" />
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="country">Country <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <select name="country" id="country" class="form-control" onchange="getStates(this.value);" required parsley-type="country">
                                            <option value="">Choose Country</option>
                                            <?php
                                            if ($countries) {
                                                foreach ($countries as $key => $value) {
                                                    ?>
                                                    <option value="<?= $value['id']."@".$value['name']; ?>"><?= $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="state">State <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <select name="state" id="state" class="form-control" required parsley-type="state">
                                            <option value="">Choose State</option>
                                        </select>
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pin">Pin / Zip Code <span class="text-danger">*</span></label>
                                    <div class="verification-parent">
                                        <input type="text" class="form-control" name="pin" id="pin" required parsley-type="" placeholder="Enter Zip Code" />
                                        <div class="verification-btn error_msg">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-left">
                            <input type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton" value="Save" />
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" onclick="Custombox.close();">Cancel</button>
                        </div>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- Modal -->
                    <div class="modal fade" id="modal1-import-adults" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Import Adults</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body p-2">
                                    <form action="<?php echo base_url(); ?>admin/add_multiple_adults" class="parsley-examples" id="modal-demo-form" method="post" enctype="multipart/form-data">

                                        <div class="form-group col-md-12">
                                            <label for="select-code-language">Upload Template<span class="text-danger">*</span></label><br/>
                                            <button type="button" class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                    Upload 
                                            <input name="file" type="file" id="fileUploadAgain">
                                            </button><span id="lblFileName" class="lblFileName">No file selected</span>
                                            <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                                
                                            <!-- <h6>Note : Only Excel file format allowed. <a href="<?php echo base_url();?>assets/templates/dictionary_template.xlsx">Sample Template</a> file found here.</h6> -->
                                        </div>
                            <!-- start-debasis -->
                                        

<!-- end-debasis -->

                                        <div class="text-left">
                                            <button type="submit"
                                                class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Save</button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true"
                                                onclick="Custombox.close();">Cancel</button>
                                        </div>
                                    </form>

                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
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
    function change_status(parent_id, parent_status) {
        if (parent_status == 1) {
            parent_status = 0;
        } else {
            parent_status = 1;
        }
        document.getElementById('status_parent_status').value = parent_status;
        document.getElementById('status_parent_id').value = parent_id;
        var pageno = "<?= $this->uri->segment(3) ? $this->uri->segment(3) : ''; ?>";
        $("#status_pageno").val(pageno);

    }

    function parent_delete(parent_id) {
        document.getElementById('parent_delete_id').value = parent_id;
    }

    function parent_logout(parent_id) {
        document.getElementById('logout_parent_id').value = parent_id;
    }

    function resetsearch() {
        $("input[name='search_parent_data']").val('');
        $("#demo-form").submit();
    }

    function getStates(countryId){
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>admin/getstates",
            data:{"countryId": countryId},
            dataType:"JSON",
            success:function(data){
                var html = "<option value=''>Choose State</option>";
                if (data != "") {
                    data.forEach((element, i) => {
                        console.log(element);
                        html += "<option value='"+element.name+"'>"+element.name+"</option>";
                    });
                    $("#state").html(html);
                }
            }
        });
    }
</script>

</body>

</html>