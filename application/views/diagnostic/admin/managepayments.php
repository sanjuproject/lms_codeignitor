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
<input type="hidden" id="session_institution_id" value="<?= $this->session->flashdata('institution_id') ?>">
<input type="hidden" id="session_excel_upload_id" value="<?= $this->session->flashdata('excel_upload_id') ?>">
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>diagnostic/view_institution/<?= $this->uri->segment(3); ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                            <li class="breadcrumb-item">Manage Payments</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Manage Payments (<?=Diagnostic?>)</h4>
                    </div>
                </div>
                <div class="col-6">
                    <div class="btn-container pt-3 pl-2 text-right">
                        <a href="<?= base_url(); ?>diagnostic/view_institution/<?= $institution_details->ss_aw_id; ?>" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>    
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php include(APPPATH."views/diagnostic/error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-4">

                                    <!-- <a href="javascript:void(0);" class="btn btn-danger mb-2" data-toggle="modal" data-target="#add-payment-modal"><i class="mdi mdi-plus-circle mr-2"></i> Add Payment</a> -->
                                </div>
                                <div class="col-sm-4">


                                </div>
                                <div class="col-sm-4">
                                    <div class="text-sm-right">
                                        <form action="<?php echo base_url() ?>admin/manageparents" method="post" id="demo-form">
                                            <div class="form-group mb-3">

                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <div class="table-responsive gridview-wrapper">
                                <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th class="namecol">File Name</th>
                                            <th>Number of Users</th>
                                            <th>Date</th>
                                            <th>Programme Type</th>
                                            <th class="emailcol">Payment Type</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($result)) {
                                            foreach ($result as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><?= $value->ss_aw_upload_file_name; ?></td>
                                                    <td><a href="<?= base_url(); ?>admin/institution_upload_user_list/<?= $institution_details->ss_aw_id; ?>/<?= $value->ss_aw_id; ?>"><?= $value->ss_aw_student_number; ?></a></td>
                                                    <td><?= date('d/m/Y', strtotime($value->ss_aw_created_at)); ?></td>
                                                    <td>
                                                    <?= Diagnostic."s"; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $total_emi = $value->ss_aw_program_type == 1 ? EMERGING_EMI_DURATION : ADVANCED_EMI_DURATION;

                                                        if ($value->ss_aw_payment_type == 1) {
                                                            echo "Lumpsum";
                                                        }
                                                        elseif ($value->ss_aw_payment_type == 2) {
                                                            echo "EMI (".$value->ss_aw_emi_count. "/".$total_emi.")";
                                                        }
                                                        else{
                                                            echo "NA";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($payment_status[$value->ss_aw_id] > 0) {
                                                            if ($value->ss_aw_payment_type == 1) {
                                                                ?>
                                                                <span class="badge badge-soft-success">Paid</span>
                                                                <?php    
                                                            }
                                                            else{
                                                                if ($value->ss_aw_emi_count == $total_emi) {
                                                                    ?>
                                                                    <span class="badge badge-soft-success">Paid</span>
                                                                    <?php
                                                                }
                                                                else{
                                                                    ?>
                                                                    <a onclick="makePayment(<?= $value->ss_aw_id ?>)" href="javascript:void(0)">Pay Now</a>
                                                                    <?php    
                                                                }
                                                                
                                                            }   
                                                        }
                                                        else{
                                                            ?>
                                                                <a onclick="makePayment(<?= $value->ss_aw_id ?>)" href="javascript:void(0)">Pay Now</a>
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($payment_status[$value->ss_aw_id] == 0){
                                                            ?>
                                                            <a onclick="parent_delete(<?= $value->ss_aw_id; ?>)" href="javascript:void(0);" class="action-icon" data-toggle="modal" data-target="#warning-delete-modal"> <i class="mdi mdi-delete"></i></a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }else{ ?>
                                            <tr>
                                                <td colspan="6" style="text-align: center;font-size:15px;font-weight:500;">No Record Found</td>
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
            

            <div id="warning-delete-modal" class="modal fade show" tabindex="-1" role="dialog" aria-modal="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="dripicons-warning h1 text-warning"></i>
                                <h4 class="mt-2">Warning!</h4>
                                <p class="mt-3">Deleting will remove all users under this uploaded file from the system. Are you sure ?</p>
                                <div class="button-list">
                                    <form action="<?php echo base_url() ?>institution/removeuploadedfile" method="post">
                                        <input type="hidden" name="file_delete_id" id="file_delete_id">
                                        <button type="submit" class="btn btn-danger">Yes</button>
                                        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="pan-gst-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog customewidth modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h4 class="modal-title" id="myCenterModalLabel">Insert PAN & GST Number</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>

                        <div class="modal-body p-4">
                            <div class="formWrapper">
                                <form class="parsley-examples" method="post" id="demo-form" novalidate="" action="<?= base_url(); ?>admin/add_pan_gst">
                                <input type="hidden" name="institution_id" id="institution_id">    
                                <input type="hidden" name="excel_upload_id" id="excel_upload_id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Pan No</label>
                                            <input type="text" name="pan_no" id="pan_no" class="form-control" required data-parsley-pattern="^[A-Z]{5}\d{4}[A-Z]$" onkeyup="this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gst No</label>
                                            <input type="text" name="gst_no" id="gst_no" class="form-control"data-parsley-pattern="^\d{2}[A-Z]{5}\d{4}[A-Z][1-9a-zA-Z]Z([a-zA-Z]|[0-9])$" onkeyup="this.value = this.value.toUpperCase();">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="text-left">
                                        <input type="submit" class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton" value="Continue">
                                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true">Cancel</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="gst-warning-model" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog customewidth modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h4 class="modal-title" id="myCenterModalLabel">ALERT: You have not entered your GST Number. Please do so now, to avail GST pass through benefit</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>

                        <div class="modal-body p-4">
                            <input type="hidden" name="institution_id" id="gst_institution_id">
                            <input type="hidden" name="excel_upload_id" id="gst_upload_id">
                            <input type="hidden" name="pan_no" id="update_pan_no">
                            <input type="hidden" name="gst_no" id="update_gst_no">
                            <div class="formWrapper">
                                <div class="text-left">
                                    <a href="javascript:void(0)" id="redirect_link" class="btn btn-primary">Ignore and Continue</a>
                                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" onclick="openPanGstModal();">Enter Now</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!-- end add parent -->

        </div> <!-- container -->

    </div> <!-- content -->
    <?php
    include(APPPATH.'views/diagnostic/bottombar.php');
    ?>

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->
<?php
include(APPPATH.'views/diagnostic/footer.php')
?>
</body>

<script type="text/javascript">
    $(document).ready(function(){
        let institution_id = $("#session_institution_id").val();
        let excel_upload_id = $("#session_excel_upload_id").val();
        if (institution_id != "" && excel_upload_id != "") {
            makePayment(excel_upload_id);
        }
    });
    function makePayment(uploadId){
        let institution_id = "<?= $institution_details->ss_aw_id; ?>";
        $.ajax({
            type:"POST",
            url:"<?= base_url(); ?>diagnostic/check_pan_gst",
            data:{"excel_upload_id": uploadId, "institutionId": institution_id},
            dataType:"JSON",
            success:function(data){
                console.log(data);
                if (data.status == 200) {
                    var link = "<?= base_url(); ?>diagnostic/institution_make_payment/"+institution_id+"/"+uploadId;
                    window.location.href = link;
                }
                else if(data.status == 420){
                    var link = "<?= base_url(); ?>diagnostic/institution_make_payment/"+institution_id+"/"+uploadId;
                    $("#redirect_link").attr('href', link);
                    $("#gst_upload_id").val(uploadId);
                    $("#gst_institution_id").val(data.institution_id);
                    $("#update_gst_no").val(data.gst_no);
                    $("#update_pan_no").val(data.pan_no);
                    $("#gst-warning-model").modal('show');
                }
                else{
                    $("#institution_id").val(data.institution_id);
                    $("#excel_upload_id").val(uploadId);
                    $("#pan-gst-modal").modal('show');
                }
            }
        });
    }

    function openPanGstModal(){
        let uploadId = $("#gst_upload_id").val();
        let institution_id = $("#gst_institution_id").val();
        let pan_no = $("#update_pan_no").val();
        let gst_no = $("#update_gst_no").val();
        $("#institution_id").val(institution_id);
        $("#excel_upload_id").val(uploadId);
        $("#pan_no").val(pan_no);
        $("#gst_no").val(gst_no);
        $("#pan-gst-modal").modal('show');
    }

    function parent_delete(parent_id) {
        document.getElementById('file_delete_id').value = parent_id;
    }
</script>
</html>