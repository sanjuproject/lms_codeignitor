<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<div id="overlay">
    <div class="cv-spinner">
        <div class="spinner-border text-warning" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>

<style type="text/css">
    #overlay {
        position: fixed;
        top: 0;
        z-index: 9999999;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
        left: 0;
        bottom: 0;
        right: 0;
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<style>
    .form-control[readonly] {
        background: #ddd;
    }

    .emi-grid-view table {
        width: 100%;
    }

    .emi-grid-view th {
        border-bottom: 2px solid #ccc;

    }

    .emi-grid-view td {
        border-bottom: 1px solid #ccc;

    }

    .emi-grid-view tr:nth-child(2n+1) td {
        background-color: #eee;
    }

    #emi-grid {
        display: none;
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
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>diagnostic/view_institution/<?= $institution_details->ss_aw_id; ?>"><?= $institution_details->ss_aw_name; ?></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>diagnostic/institutionmanagepayment/<?= $institution_details->ss_aw_id; ?>">Manage Payment</a></li>
                            <li class="breadcrumb-item"><?= $upload_details->ss_aw_upload_file_name; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
          
           
            <!-- end page title -->

            <!-- start page title -->
            <div class="row">
                <div class="col-6">
                    <div class="page-title-box">
                        <h4 class="page-title parsley-examples">Make Payment for <?= Diagnostic ?>s Programme</h4>
                    </div>
                </div>
                <div class="col-6 text-right mt-3">
                    <a href="<?= base_url(); ?>institution/manage_payment" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                </div>
            </div>
            <!-- end page title -->
            <?php include(APPPATH . "views/diagnostic/error_message.php"); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-12">
                                    <form class="parsley-examples" method="post" id="frm-add-institution">
                                        <div class="row ">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="noofstudent">No. of Users </label>
                                                    <div class="verification-parent">
                                                        <input class="form-control" readonly type="text" name="noofstudent" placeholder="" value="<?= $upload_details->ss_aw_student_number; ?>">
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                        <div class="verification-btn error_msg">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <label>Payment Type </label>

                                                    <div class="terget-audience-radio">
                                                        <div class="radio radio-primary mr-2">
                                                            <input type="radio" name="rad_paymenttype" id="rad_lumpsum" value="1" <?= $upload_details->ss_aw_emi_count == 0 ? "checked" : "disabled"; ?> onclick="getPriceDetails(this.value)">
                                                            <label for="rad_lumpsum">
                                                                Lumpsum
                                                            </label>
                                                        </div>
                                                        <!-- <div class="radio radio-primary mr-2">
                                                            <input type="radio" name="rad_paymenttype" id="rad_emi" value="2" <?= $upload_details->ss_aw_emi_count > 0 ? "checked" : ($upload_details->transaction_count > 0 ? "disabled" : ""); ?> onclick="getPriceDetails(this.value)">
                                                            <label for="rad_emi">
                                                                EMI
                                                            </label>
                                                        </div> -->

                                                    </div>



                                                </div>
                                                <div class="form-group">

                                                    <div class="custom-control custom-switch custom-switch-with">
                                                        <input <?= $upload_details->ss_aw_emi_count > 0 || $institution_details->ss_aw_partial_payment == 1 ? "disabled" : ""; ?> name="chk_discount_coupon" type="checkbox" class="custom-control-input" id="chk_discount_coupon" onclick="applyCoupon();">
                                                        <label class="custom-control-label" for="chk_discount_coupon">Apply Discount Coupon</label>

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="discountcoupon">Discount Coupon:</label>
                                                    <div class="verification-parent">
                                                        <input readonly class="form-control" type="text" name="discountcoupon" id="discountcoupon" placeholder="Enter Coupon Code">
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                        <div id="coupon_error" class="verification-btn error_msg">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Discount Amount:</label>
                                                    <div class="verification-parent">
                                                        <input class="form-control" readonly type="text" name="discountammount" id="discountammount" placeholder="" value="0">
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                        <div class="verification-btn error_msg">

                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="originalamount" id="originalamount">
                                                <div class="form-group">
                                                    <label for="">Final Amount:</label>
                                                    <div class="verification-parent">
                                                        <input class="form-control" readonly type="text" name="finalamount" id="finalamount" placeholder="">
                                                        <ul class="parsley-errors-list" aria-hidden="true"></ul>
                                                        <div class="verification-btn error_msg">

                                                        </div>
                                                    </div>
                                                    <span>(GST included)<?= $institution_details->ss_aw_partial_payment == 1 ? " <span id='actual_programme_price'></span>" : ""; ?></span>
                                                </div>

                                            </div>
                                            <div class="col-sm-6">
                                                <input type="hidden" name="first_emi_amount" id="first_emi_amount" value="0">
                                                <div class="emi-grid-view" id="emi-grid">

                                                </div>
                                            </div>


                                            <div class="col-sm-12" id="lumpsum_pay">
                                                <div class="text-left">
                                                    <button class="btn btn-success waves-effect waves-light adminusersbottomgapbetweenbtn adduserbutton buy_now">Make Payment</button>
                                                    <a href="<?= base_url(); ?>institution/manage_payment" class="btn btn-danger">Cancel</a>
                                                </div>
                                            </div>
                                        </div>

                                    </form>

                                </div>


                            </div>


                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>


        </div> <!-- container -->

    </div> <!-- content -->

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
<script>
    $(() => {
        let paymentType = $('input[name="rad_paymenttype"]:checked').val();
        getPriceDetails(paymentType);
    });

    function getPriceDetails(paymentType) {
        let institution_id = "<?= $institution_details->ss_aw_id ?>";
        let programType = "<?= $upload_details->ss_aw_program_type ?>";
        let paymentMethod = "<?= $institution_details->ss_aw_partial_payment ?>";

        let eachAmount = 0;
        let total_student = "<?= $upload_details->ss_aw_student_number ?>";
        let total_amount = 0;
        if (paymentType == 1) {
            eachAmount = "<?= $institution_details->ss_aw_lumpsum_price_diagnostic ?>";
        } else {
            eachAmount = "<?= $institution_details->ss_aw_lumpsum_price_diagnostic ?>";
        }


        total_amount = eachAmount * total_student;
        total_amount = Math.round(total_amount * 100) / 100;
        $("#originalamount").val(total_amount);
        $("#finalamount").val(total_amount);
        if (paymentMethod == 1) {
            if (paymentType == 1) {
                var actual_programme_price = Math.round((total_amount * 2) * 100) / 100;
                actual_programme_price = "The total programme price: " + actual_programme_price;
                $("#actual_programme_price").html(actual_programme_price);
            } else {
                $("#actual_programme_price").html("");
            }
        }

    }

    function addMonths(date, months) {
        date.setMonth(date.getMonth() + months);
        return date;
    }





    function randomString(length) {
        var result = '';
        var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
        return result;
    }

    function url_redirect(url) {
        var X = setTimeout(function() {
            window.location.replace(url);
            return true;
        }, 300);

        if (window.location = url) {
            clearTimeout(X);
            return true;
        } else {
            if (window.location.href = url) {
                clearTimeout(X);
                return true;
            } else {
                clearTimeout(X);
                window.location.replace(url);
                return true;
            }
        }
        return false;
    }

    //razorpay payment code
    $('body').on('click', '.buy_now', function(e) {
        var payment_amount = $("#finalamount").val();
        var discount_amount = $("#discountammount").val();
        var coupon_code = $("#discountcoupon").val();
        var programType = "<?= $upload_details->ss_aw_program_type ?>";
        var course_name = "";
        var course_id = 0;

        course_id = 6;
        course_name = "<?= Diagnostic ?>s Programme";

        var user_email = "<?= $institution_admin_details[0]->ss_aw_parent_email ?>";
        var payment_type = $('input[name="rad_paymenttype"]:checked').val();
        var institution_id = "<?= $institution_details->ss_aw_id ?>";
        var excel_upload_id = "<?= $upload_details->ss_aw_id ?>";
        if (payment_amount == 0) {
            var razorpay_payment_id = randomString(14);
            razorpay_payment_id = "pay_" + razorpay_payment_id;
            $("#overlay").fadeIn(300);
            $.ajax({
                url: '<?php echo base_url() ?>' + 'diagnostic/institution_bulk_payment',
                type: 'post',
                dataType: 'json',
                data: {
                    course_id: course_id,
                    transaction_id: razorpay_payment_id,
                    payment_amount: payment_amount,
                    discount_amount: discount_amount,
                    coupon_code: coupon_code,
                    payment_type: payment_type,
                    institution_id: institution_id,
                    excel_upload_id: excel_upload_id
                },
                success: function(data) {
                    var url = '<?php echo base_url() ?>' + 'diagnostic/institution_paymentsuccess/'+institution_id+'/' + data.status;
                    window.location = url;
                    // location.replace(url);
                },
                error: function(xhr, ajaxOptions, thrownError) {                  
                    var url = '<?php echo base_url() ?>' + 'diagnostic/institution_paymentsuccess'+institution_id;
                    window.location = url;
                    //location.replace(url);
                }
            });
        } else {

            var options = {
                "key": '<?= RAZORPAY_KEY ?>',
                "currency": "INR",
                "amount": Math.round(payment_amount * 100),
                "name": course_name,
                "email": user_email,
                "description": "Course Purchase",
                "handler": function(response) {
                    $("#overlay").fadeIn(300);
                    $.ajax({
                        url: '<?php echo base_url() ?>' + 'diagnostic/institution_bulk_payment',
                        type: 'post',
                        dataType: 'json',
                        data: {

                            course_id: course_id,
                            transaction_id: response.razorpay_payment_id,
                            payment_amount: payment_amount,
                            discount_amount: discount_amount,
                            coupon_code: coupon_code,
                            payment_type: payment_type,
                            institution_id: institution_id,
                            excel_upload_id: excel_upload_id
                        },
                        success: function(data) { 
                            var url = '<?php echo base_url() ?>' + 'diagnostic/institution_paymentsuccess/'+institution_id+'/' + data.status;
                            window.location = url;
                            // location.replace(url);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {                            
                            var url = '<?php echo base_url() ?>' + 'diagnostic/institution_paymentsuccess'+institution_id;
                            window.location = url;
                            //location.replace(url);
                        }
                    });
                },
                "theme": {
                    "color": "#F37254"
                }
            };

            var rzp1 = new Razorpay(options);
            rzp1.open();
            e.preventDefault();
        }
    });
    //end


    //razorpay emi payment code

    //end
</script>
</body>

</html>