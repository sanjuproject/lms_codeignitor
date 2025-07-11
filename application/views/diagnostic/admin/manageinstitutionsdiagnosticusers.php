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

    .panel-heading-nav {
        border-bottom: 0;
        padding: 10px 0 0;
    }

    .panel-heading-nav .nav {
        padding-left: 10px;
        padding-right: 10px;
    }
</style>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>diagnostic/view_institution/<?= $this->uri->segment(3); ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                            <li class="breadcrumb-item">Manage Users</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Manage Institution Users (Diagnostic)</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php include(APPPATH . "views/diagnostic/error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <a href="javascript:void(0);" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal1-import-adults"><i class="mdi mdi-plus-circle mr-2"></i>Import Bulk Users</a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="javascript:void(0);" style="float: right;" id="make_payment" class="btn btn-success mb-2"><i class="mdi mdi-telegram mr-2"></i>Create Group & Make Payment</a>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-8">

                                </div>
                                <div class="col-sm-4">
                                    <div class="text-sm-right">
                                        <form action="<?php echo base_url() ?>diagnostic/manageinstitutionusers/<?= $this->uri->segment(3); ?>" method="post" id="filter-form">
                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <input type="text" name="search_data" class="form-control" placeholder="Search..." aria-label="Recipient's username" <?php
                                                                                                                                                                            if (isset($search_data)) {
                                                                                                                                                                                echo 'value="' . $search_data . '"';
                                                                                                                                                                            }
                                                                                                                                                                            ?>>
                                                    <input type="hidden" name="search_parent" value="search_parent">
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
                                            <th>
                                                <input type="checkbox" class="from-control" id="ckbCheckAll">
                                            </th>
                                            <th class="namecol">User Name</th>
                                            <th class="emailcol">Email</th>
                                            <th class="mobilecol">Course Name</th>
                                            <th>Start Date</th>
                                            <th>Score</th>
                                            <th>Report Card</th>
                                            <th>Status</th>
                                            <th class="actioncol">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php
                                        $sl = 1;
                                        if (!empty($child_details)) {
                                            foreach ($child_details as $key => $value) {
                                                $parent_id = $value->ss_aw_parent_id;
                                        ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        if ($value->datedifference > $value->duration && $value->reassigned!=1) { ?>
                                                            <input type="checkbox" class="from-control checkBoxClass" id="checkoption" name="checkoption" value="<?= $value->ss_aw_child_id ?>">
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (!empty($course_details[$value->ss_aw_child_id]->course)) {
                                                        ?>
                                                            <a href="<?= base_url(); ?>diagnostic/user_course_details/<?= $value->ss_aw_institution_id ?>/<?= $value->ss_aw_child_id; ?>/<?= $page; ?>/1"><?= $value->ss_aw_child_first_name . " " . $value->ss_aw_child_last_name; ?></a>
                                                        <?php
                                                        } else {
                                                            echo $value->ss_aw_child_first_name . " " . $value->ss_aw_child_last_name;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $value->ss_aw_child_email; ?></td>
                                                    <td><?= Diagnostic ?></td>
                                                    <td><?= $value->ss_aw_lesson_code != "" && $value->ss_aw_last_lesson_create_date != "" ? date_format(date_create($value->ss_aw_last_lesson_create_date), "d-m-Y") : "NA"; ?></td>
                                                    <td>
                                                        <?= $diagnostictotalquestion[$value->ss_aw_child_id] > 0 ? $diagnosticcorrectquestion[$value->ss_aw_child_id] . '/' . $diagnostictotalquestion[$value->ss_aw_child_id] : 'NA'; ?>
                                                    </td>
                                                    <td>NA</td>
                                                    <td>
                                                        <?php
                                                        if (!empty($course_details[$value->ss_aw_child_id]->course)) {
                                                            if ($value->ss_aw_child_status == 1) {
                                                        ?>
                                                                <span class="badge badge-soft-success">Active</span>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <span class="badge badge-soft-danger">Inactive</span>
                                                            <?php
                                                            }

                                                            if ($value->ss_aw_blocked == 1) {
                                                            ?>
                                                                <span class="badge badge-soft-danger">Block</span>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <span class="badge badge-soft-success">Unblock</span>
                                                        <?php
                                                            }
                                                        } else {
                                                            echo "NA";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="actioncell">
                                                        <a href="<?= base_url(); ?>diagnostic/edit_user/<?= $value->ss_aw_child_id ?>/<?= $this->uri->segment(3); ?>" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                        <?php
                                                        if (empty($course_details[$value->ss_aw_child_id]->course)) {
                                                        ?>
                                                            <a onclick="parent_delete(<?= $value->ss_aw_child_id; ?>)" href="javascript:void(0);" class="action-icon" data-toggle="modal" data-target="#warning-delete-modal"> <i class="mdi mdi-delete"></i></a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="badge badge-soft-success">Enrolled</span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                        <?php
                                                $sl++;
                                            }
                                        }else{ ?>
                                                <tr>
                                                    <td colspan="9" style="text-align: center;font-size:15px;font-weight:500;">No Record Found</td>
                                                </tr>
                                     <?php   }
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
                            <?php
                            if (!empty($links)) {
                                foreach ($links as $link) {
                                    echo "<li>" . $link . "</li>";
                                }
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
                        <p class="mt-3">Deleting will remove this user from the system. Are you sure ?</p>
                        <div class="button-list">
                            <form action="<?php echo base_url() ?>institution/removeuser" method="post">
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


    <div class="modal fade" id="modal1-import-adults" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">Import Bulk Users (Diagnostic)</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-2">
                    <form action="<?php echo base_url(); ?>diagnostic/import_bulk_users" class="parsley-examples" id="modal-demo-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="institution_id" id="institution_id" value="<?= $this->uri->segment(3); ?>">
                        <div class="form-group">
                            <!-- <label for="dob">Programme type <span class="text-danger">*</span></label> -->
                            <div class="terget-audience-radio" style="display:none;">
                                <div class="radio radio-primary mr-2">
                                    <input type="radio" name="programme_type" id="bulk_programme_diagnostic" value="6" required onclick="selectProgramType(1)" checked>
                                    <label for="bulk_programme_diagnostic">
                                        <?= Diagnostic ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Title of the file</label>
                                <input type="text" name="file_name" id="file_name" required class="form-control">
                                <h6>Example : LumsumofJan2023user.</h6>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="select-code-language">Upload Template<span class="text-danger">*</span></label><br />
                                <input name="file" type="file" data-plugins="dropify" data-height="100" required />
                                <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                                <h6>Note : Only Excel file format allowed. <a id="template_link" href="">Sample Template</a> file found here.</h6>
                            </div>

                        </div>
                        <!-- <div class="form-group col-md-12">
                            <label for="select-code-language">Upload Template<span class="text-danger">*</span></label><br/>
                            <button type="button" class="btnUploadAgain btn btn-primary btn-xs btn-rounded waves-effect waves-light">
                                                    Upload 
                            <input name="file" type="file" id="fileUploadAgain" required>
                            </button><span id="lblFileName" class="lblFileName">No file selected</span>
                            <ul class="parsley-errors-list filled" aria-hidden="false"></ul>
                        </div> -->

                        <div class="text-left">
                            <button type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Save</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" onclick="Custombox.close();">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_create_group" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel-modal1-verify1">ALERT: You have to enter your group name</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-2">
                    <h5>Programme Type : <?= Diagnostic ?></h5>
                    <form action="<?php echo base_url(); ?>diagnostic/create_new_group" class="parsley-examples" id="modal-demo-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="user_id_data" id="user_id_data" value="">
                        <input type="hidden" name="institution_id" id="institution_id" value="<?= $this->uri->segment(3) ?>">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Title of the Group</label>
                                <input type="text" name="group_name" id="group_name" required class="form-control">
                            </div>
                        </div>
                        <div class="text-left">
                            <button type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn">Save</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" onclick="Custombox.close();">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!----------------------------------------Message model-------------------------------------->
    <div class="modal fade" id="modal_message" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="message_logo"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="message_body" style="text-align:center;font-weight: 800;font-size: 18px;">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger cancel_class" data-dismiss="modal">Cancel</button>
                </div>

            </div>
        </div>
    </div>
    <?php
    include(APPPATH . 'views/diagnostic/bottombar.php');
    ?>

</div>


<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->


<?php
include(APPPATH . 'views/diagnostic/footer.php')
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

    function showFields(val) {
        $('.formWrapper').hide();
        $('#' + val).show();
    }

    function selectProgramType(programType) {
        let template_link = "<?= base_url(); ?>assets/templates/";
        if (programType == 1) {
            template_link = template_link + "institution_users.xlsx";
        } else {
            template_link = template_link + "institution_master_users.xlsx";
        }
        $("#template_link").attr('href', template_link);
    }

    function resetsearch() {
        $("input[name='search_data']").val('');
        $("#filter-form").submit();
    }
</script>

<script>
    $(document).ready(function() {
        if ($(".checkBoxClass").length < 1) {
            $("#ckbCheckAll").css("display", 'none');
        }
    });
    $("#ckbCheckAll").click(function() {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });

    $(".checkBoxClass").click(function() {
        if ($('.checkBoxClass:checked').length == $('.checkBoxClass').length) {
            $('#ckbCheckAll').prop('checked', true);
        } else {
            $('#ckbCheckAll').prop('checked', false);
        }

    });

    var $chkboxes = $('.checkBoxClass');
    var lastChecked = null;
    $chkboxes.click(function(e) {
        if (!lastChecked) {
            lastChecked = this;
            return;
        }
        if (e.shiftKey) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);
            $chkboxes.slice(Math.min(start, end), Math.max(start, end) + 1).prop('checked', lastChecked.checked);
        }
        lastChecked = this;
        if ($('.checkBoxClass:checked').length == $('.checkBoxClass').length) {
            $('#ckbCheckAll').prop('checked', true);
        } else {
            $('#ckbCheckAll').prop('checked', false);
        }
    });
</script>
<script>
    $("#make_payment").click(function() {
        if ($(".checkBoxClass:checked").length > 0) {
            let checkedValues = $(".checkBoxClass:checked").map(function() {
                return this.value;
            }).get();
            $("#user_id_data").val(JSON.stringify(checkedValues));
            $("#modal_create_group").modal('show');
        } else {
            $("#message_logo").html('<span class="mdi mdi-approval" style="font-size:48px;color:#d7c32cb0"></span>');
            $("#message_body").html('Please select user first!');
            $("#modal_message").modal('show');
        }

    });
</script>





</body>

</html>