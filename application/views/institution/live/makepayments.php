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
            <!-- start page title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="page-title-left">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>institution/manage_payment">Manage Payment</a></li>
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
                        <h4 class="page-title parsley-examples">Make Payment for <?= $upload_details->ss_aw_program_type == 1 ? Winners : Master . "s" ?> Programme</h4>
                    </div>
                </div>
                <div class="col-6 text-right mt-3">
                    <a href="<?= base_url(); ?>institution/manage_payment" class="btn btn-danger align-middle"><i class="mdi mdi-arrow-left-bold-circle"></i> Go Back</a>
                </div>
            </div>
            <!-- end page title -->
            <?php include("error_message.php"); ?>
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
                                                        <div class="radio radio-primary mr-2">
                                                            <input type="radio" name="rad_paymenttype" id="rad_emi" value="2" <?= $upload_details->ss_aw_emi_count > 0 ? "checked" : ""; ?> onclick="getPriceDetails(this.value)">
                                                            <label for="rad_emi">
                                                                EMI
                                                            </label>
                                                        </div>

                                                    </div>



                                                </div>
                                                <div class="form-group">

                                                    <div class="custom-control custom-switch custom-switch-with">
                                                        <input <?= $upload_details->ss_aw_emi_count > 0 ? "disabled" : ""; ?> name="chk_discount_coupon" type="checkbox" class="custom-control-input" id="chk_discount_coupon" onclick="applyCoupon();">
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
                                                    <span>(GST included)</span>
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
<script>
    $(() => {
        let paymentType = $('input[name="rad_paymenttype"]:checked').val();
        getPriceDetails(paymentType);
    });

    function getPriceDetails(paymentType) {
        let institution_id = "<?= $institution_details->ss_aw_id ?>";
        let programType = "<?= $upload_details->ss_aw_program_type ?>";
        getCouponCode(paymentType, institution_id, programType);
        if (paymentType == 1) {
            $('#emi-grid').hide();
            $("#lumpsum_pay").show();
        } else {
            $("#lumpsum_pay").hide();
            $('#emi-grid').show();
        }

        let eachAmount = 0;
        let total_student = "<?= $upload_details->ss_aw_student_number ?>";
        let total_amount = 0;
        if (programType == 1) {
            if (paymentType == 1) {
                eachAmount = "<?= $institution_details->ss_aw_lumpsum_price ?>";
            } else {
                eachAmount = "<?= $institution_details->ss_aw_emi_price ?>";
            }
        } else {
            if (paymentType == 1) {
                eachAmount = "<?= $institution_details->ss_aw_lumpsum_price_masters ?>";
            } else {
                eachAmount = "<?= $institution_details->ss_aw_emi_price_masters ?>";
            }
        }

        total_amount = eachAmount * total_student;
        total_amount = Math.round(total_amount * 100) / 100;
        $("#originalamount").val(total_amount);
        $("#finalamount").val(total_amount);

        //Setup EMI section
        if (paymentType == 2) {
            let paymentHistory = <?= $payment_history ? $payment_history : "0" ?>;
            let paidEmi = "<?= $upload_details->ss_aw_emi_count; ?>";
            let emicount = 0;
            let emiPricePerEmi = 0;
            if (programType == 1) {
                emicount = "<?= EMERGING_EMI_DURATION ?>";
            } else {
                emicount = "<?= ADVANCED_EMI_DURATION ?>";
            }
            emiPricePerEmi = total_amount / emicount;
            emiPricePerEmi = Math.round(emiPricePerEmi * 100) / 100;
            if (paidEmi > 0) {
                $("#first_emi_amount").val(paymentHistory[0].ss_aw_payment_amount);
            } else {
                $("#first_emi_amount").val(emiPricePerEmi);
            }

            var emiHtml = "";
            emiHtml += '<table><tr><th colspan="3">EMI Payments list</th></tr>';
            for (var i = 0; i < emicount; i++) {
                let currentDate;
                if (paidEmi > 0) {
                    currentDate = new Date(paymentHistory[0].ss_aw_created_date);
                } else {
                    currentDate = new Date();
                }

                if (i > 0) {
                    currentDate = addMonths(currentDate, i);
                }
                let day = currentDate.getDate();
                let month = currentDate.getMonth();
                let incrementedMonth = month + 1;
                let year = currentDate.getFullYear();
                let formatedDate = day + '/' + incrementedMonth + '/' + year;
                if (paidEmi > i) {
                    emiHtml += '<tr><td>' + formatedDate + '</td><td>₹' + paymentHistory[i].ss_aw_payment_amount + '</td><td><a href="javascript:void(0)" class="text-muted">Paid</a></td></tr>';
                } else {
                    if ((paidEmi - i) == 0) {
                        emiHtml += '<tr><td>' + formatedDate + '</td><td>₹' + emiPricePerEmi + '</td><td><a href="javascript:void(0)" class="pay emi_pay">Pay Now</a></td></tr>';
                    } else {
                        emiHtml += '<tr><td>' + formatedDate + '</td><td>₹' + emiPricePerEmi + '</td><td><a href="javascript:void(0)" class="text-muted">Pay Now</a></td></tr>';
                    }
                }

            }
            emiHtml += '</table>';
            $("#emi-grid").html(emiHtml);
        }
        applyCoupon();
    }

    function addMonths(date, months) {
        date.setMonth(date.getMonth() + months);
        return date;
    }

    //get coupon code payment type and program type wise
    function getCouponCode(paymentType, institutionId, programType) {
        $.ajax({
            type: "POST",
            async: false,
            url: "<?= base_url(); ?>institution/get_institution_coupon",
            data: {
                "paymentType": paymentType,
                "institutionId": institutionId,
                "programType": programType
            },
            dataType: "JSON",
            success: function(data) {
                if (data != "") {
                    $("#discountcoupon").val(data.coupon_code);
                    //console.log(data.coupon_code);
                }
            }
        });
    }

    function applyCoupon() {
        let discountPercentage = 0;
        if ($("#chk_discount_coupon").prop('checked') == true) {
            let paymentType = $('input[name="rad_paymenttype"]:checked').val();
            let discountCoupon = $("#discountcoupon").val();
            console.log({
                discountCoupon
            });
            if (discountCoupon != "") {
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<?= base_url(); ?>institution/apply_coupon",
                    data: {
                        "discount_coupon": discountCoupon,
                        "payment_type": paymentType
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        if (response.status == 1) {
                            $("#coupon_error").html("Coupon applied successfully.");
                            discountPercentage = response.data[0].ss_aw_discount;
                            console.log(response.data);
                        } else {
                            $("#coupon_error").html("Invalid coupon");
                        }
                    }
                });
            }
        } else {
            $("#coupon_error").html("");
        }
        calculateDiscount(discountPercentage);
    }

    function calculateDiscount(percentage) {
        let paidEmi = "<?= $upload_details->ss_aw_emi_count; ?>";
        let programType = "<?= $upload_details->ss_aw_program_type ?>";
        {
            let paymentType = $('input[name="rad_paymenttype"]:checked').val();
            percentage = Number(percentage);
            let firstEmiPrice = 0;
            let firstEmiDiscount = 0;
            let total_amount = $("#originalamount").val();
            total_amount = Number(total_amount);
            if (paymentType == 2) {
                let emicount = 0;
                if (programType == 1) {
                    emicount = "<?= EMERGING_EMI_DURATION ?>";
                } else {
                    emicount = "<?= ADVANCED_EMI_DURATION ?>";
                }

                let firstEmiPrice = $("#first_emi_amount").val();
                let firstEmiPriceWithOutGST = (firstEmiPrice * 100) / 118;
                firstEmiPriceWithOutGST = Number(firstEmiPriceWithOutGST);
                firstEmiDiscount = (firstEmiPriceWithOutGST * percentage) / 100;
                firstEmiDiscount = Math.round(firstEmiDiscount * 100) / 100;
                total_amount = Math.round(total_amount * 100) / 100;
                $("#discountammount").val(firstEmiDiscount);
                let discountedEmiPrice = firstEmiPriceWithOutGST - firstEmiDiscount;
                let discountedEmiPriceWithGST = (discountedEmiPrice * 118) / 100;
                discountedEmiPriceWithGST = Math.round(discountedEmiPriceWithGST * 100) / 100;
                total_amount = firstEmiPrice * (emicount - 1);
                console.log({
                    total_amount
                });
                total_amount = total_amount + discountedEmiPriceWithGST;
                total_amount = Math.round(total_amount * 100) / 100;
                discountedEmiPriceWithGST = "₹" + discountedEmiPriceWithGST;
                $("#emi-grid table tbody tr:nth-child(2) td:nth-child(2)").html(discountedEmiPriceWithGST);
            } else {
                let totalAmountWithOutGST = (total_amount * 100) / 118;
                let discountAmount = (totalAmountWithOutGST * percentage) / 100;
                discountAmount = Math.round(discountAmount * 100) / 100;
                total_amount = totalAmountWithOutGST - discountAmount;
                total_amount = Math.round(total_amount * 100) / 100;
                total_amount = (total_amount * 118) / 100;
                total_amount = Math.round(total_amount * 100) / 100;
                $("#discountammount").val(discountAmount);
            }
            $("#finalamount").val(total_amount);
        }
    }

    //razorpay payment code
    $('body').on('click', '.buy_now', function(e) {
        var payment_amount = $("#finalamount").val();
        var discount_amount = $("#discountammount").val();
        var coupon_code = $("#discountcoupon").val();
        var programType = "<?= $upload_details->ss_aw_program_type ?>";
        var course_name = "";
        var course_id = 0;
        if (programType == 1) {
            course_id = 1;
            course_name = "<?= Winners ?> Programme";
        } else {
            course_id = 5;
            course_name = "<?= Master ?>s Programme";
        }
        var user_email = "<?= $institution_admin_details[0]->ss_aw_parent_email ?>";
        var payment_type = $('input[name="rad_paymenttype"]:checked').val();
        var institution_id = "<?= $institution_details->ss_aw_id ?>";
        var excel_upload_id = "<?= $upload_details->ss_aw_id ?>";
        var options = {
            "key": '<?= RAZORPAY_KEY_LIVE ?>',
            "currency": "INR",
            "amount": Math.round(payment_amount * 100),
            "name": course_name,
            "email": user_email,
            "description": "Course Purchase",
            "handler": function(response) {
                $("#overlay").fadeIn(300);
                $.ajax({
                    url: '<?php echo base_url() ?>' + 'institution/bulk_payment',
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
                        window.location.href = '<?php echo base_url() ?>' + 'institution/paymentsuccess/' + data.status;
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
    });
    //end

    function randomString(length) {
        var result = '';
        var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
        return result;
    }

    //razorpay emi payment code
    $('body').on('click', '.emi_pay', function(e) {
        var targetHtml = $(this).closest('tr');
        console.log(targetHtml);
        targetHtml = targetHtml.find("td:eq(1)").text();
        var emiPrice = targetHtml.substring(1);
        emiPrice = Number(emiPrice);
        var payment_amount = emiPrice;
        var discount_amount = $("#discountammount").val();
        var coupon_code = $("#discountcoupon").val();
        var programType = "<?= $upload_details->ss_aw_program_type ?>";
        var course_name = "";
        var course_id = 0;
        if (programType == 1) {
            course_id = 1;
            course_name = "<?= Winners ?> Programme";
        } else {
            course_id = 5;
            course_name = "<?= Master ?>s Programme";
        }
        var user_email = "<?= $institution_admin_details[0]->ss_aw_parent_email ?>";
        var payment_type = $('input[name="rad_paymenttype"]:checked').val();
        var institution_id = "<?= $institution_details->ss_aw_id ?>";
        var excel_upload_id = "<?= $upload_details->ss_aw_id ?>";
        if (payment_amount == 0) {
            var razorpay_payment_id = randomString(14);
            razorpay_payment_id = "pay_" + razorpay_payment_id;
            $("#overlay").fadeIn(300);
            $.ajax({
                url: '<?php echo base_url() ?>' + 'institution/bulk_payment',
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
                    window.location.href = '<?php echo base_url() ?>' + 'institution/paymentsuccess/' + data.status;
                }
            });
        } else {
            var options = {
                "key": '<?= RAZORPAY_KEY_LIVE ?>',
                "currency": "INR",
                "amount": Math.round(payment_amount * 100),
                "name": course_name,
                "email": user_email,
                "description": "Course Purchase",
                "handler": function(response) {
                    $("#overlay").fadeIn(300);
                    $.ajax({
                        url: '<?php echo base_url() ?>' + 'institution/bulk_payment',
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
                            window.location.href = '<?php echo base_url() ?>' + 'institution/paymentsuccess/' + data.status;
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
</script>
</body>

</html>