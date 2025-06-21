<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>team Invoice</title>
    <style>
    * {
        box-sizing: border-box;
        color: #000;
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        padding:0;
    }

    .small-text {
        font-size: 13px;
    }

    .heading-text {
        font-size: 18px;
        font-weight: bold;
    }

    .name-heading {
        font-size: 16px;
        font-weight: bold;
        width: "100%";
    }

    .text-bold {
        font-weight: bold;
    }

    .small-width {
        width: 100px
    }

    .invoice-no {
        font-size: 20px;
        margin-bottom: 5px;
        margin-top: 5px;
    }
</style>
</head>

<body>
    <h2 style="text-align: center;">Tax Invoice</h2>
    <p style="text-align: right; font-size:12px; margin-right:0px; top:-40px; position: relative; font-style: italic ">
        (ORIGINAL FOR RECIPIENT)</p>

        <table cellpadding="0" cellspacing="0" style="width:100%;border:1px solid black;">
            <tr>
                <td>
                    <!--ROW 1-->
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td cellpadding="0" cellspacing="0"  style="width:340px;border-bottom:1px solid black; border-right:1px solid black; width:340px">
                                <!-- First row 1st col-->
                                <table cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td class="name-heading" style="padding-left:5px; padding-top:5px;">team™ Content Solutions, LLP</td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="padding-left:5px">#2-A, SukhSadan Apartments,</td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="padding-left:5px">52B Shakespeare Sarani</td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="padding-left:5px">Kolkata 700017</td>
                                    </tr>
                                    <!-- <tr>
                                        <td class="small-text">M-9830357840</td>
                                    </tr> -->
                                    <tr>
                                        <td  class="small-text" style="padding-left:5px">GSTIN/UIN: 19ABTFA3148H1Z3</td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="padding-left:5px">PAN: ABTFA3148H</td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="padding-left:5px">State Name: West Bengal</td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="border-bottom:1px solid black;width:340px; padding-left:5px" >Email: support@team.com</td>
                                    </tr>

                                    <tr>
                                        <td class="heading-text" style="padding-left:5px; padding-top:5px">Buyer</td>
                                    </tr>
                                    <tr>
                                        <td class="name-heading" style="padding-left:5px"><?= $parent_details[0]->ss_aw_parent_full_name; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="padding-left:5px"><?= $parent_details[0]->ss_aw_parent_address; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="padding-left:5px" ><?= $parent_details[0]->ss_aw_parent_city; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="padding-left:5px"><?= $parent_details[0]->ss_aw_parent_state; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="padding-left:5px"><?= $parent_details[0]->ss_aw_parent_pincode; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="padding-left:5px">M-<?= $parent_details[0]->ss_aw_parent_primary_mobile; ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="border-bottom:1px solid black; width: 360px; vertical-align: top;">
                                <!-- First row 2nd col-->
                                <table  cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td class="small-text" style="border-right:1px solid black; padding-left:5px; padding-top:5px">Invoice No.</td>
                                        <td class="small-text" style="padding-left:5px; padding-top:5px">Dated</td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom:1px solid black; width:170px;border-right:1px solid black; padding-left:5px; font-size:18px;" class="invoice-no text-bold"><?= $invoice_no; ?></td>
                                        <td style="border-bottom:1px solid black; width:170px; font-size:18px; padding-left:5px" class="invoice-no text-bold"><?= date('d/m/Y'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="border-right:1px solid black; padding-left:5px; padding-top:5px">Buyer's Order No.</td>
                                        <td class="small-text" style="padding-left:5px; padding-top:5px">Dated</td>
                                    </tr>
                                    <tr>
                                        <td class="invoice-no text-bold" style="border-right:1px solid black;border-bottom:1px solid black; padding-left:5px; font-size:18px;">
                                            <?php
                                                $invoiceAry = explode("/", $invoice_no);
                                                echo $invoiceAry[1];
                                            ?>
                                        </td>
                                        <td cellpadding="0" cellspacing="0" class="invoice-no text-bold" style="border-bottom:1px solid black; padding-left:5px; font-size:18px;"><?= date('d/m/Y'); ?></td>
                                    </tr>
                                </table>
                            </td>

                        </tr>
                    </table>
                </td>
        </tr>


        <tr>
            <td>
                <!--row 2-->

                <table cellpadding="0" cellspacing="0" style="clear: both; border-bottom:1px solid black;  width:100%">
                    <tr>
                        <th style="width:5%; border-right:1px solid black; height:40px; ">Sl No.</th>
                        <th style="width:50%; border-right:1px solid black; height:40px; ">Particulars</th>
                        <th style="width:14%">Amount</th>
                    </tr>
                    <?php
                        $sl_no = 1;
                    ?>
                    <tr>
                        <td style="width:5%; border-right:1px solid black; border-top:1px solid black; height:40px; text-align: center;"><?= $sl_no; ?></td>
                        <td style="width:50%; border-right:1px solid black; border-top:1px solid black; height:40px; text-align: left; padding-left:10px; font-weight: bold;">
                            <?php 
                                if ($course_id == 1) {
                                    $purchased_course_name = "Emerging";
                                }elseif ($course_id == 2) {
                                    $purchased_course_name = "Consolidated";
                                }else{
                                    $purchased_course_name = "Advanced";
                                }
                            ?>
                            <p>team™ <?= $course_details[0]['ss_aw_course_name']; ?> Program</p>
                        </td>
                        <td style="width:14%;border-top:1px solid black; height:40px; text-align: right; padding-right:10px; font-weight: bold;">
                            <?= number_format(($payment_amount - $gst_rate), 2); ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="width:5%; border-right:1px solid black; height:20px; text-align: center;"><?= $sl_no = $sl_no + 1; ?></td>
                        <td
                            style="width:50%; border-right:1px solid black; height:20px; text-align: right; padding-right:10px; font-weight: bold;">
                            Output CGST</td>
                        <td style="width:14%; height:40px; text-align: right; padding-right:10px; font-weight: bold;"><?= number_format(($gst_rate / 2), 2); ?></td>
                    </tr>
                    <tr>
                        <td style="width:5%; border-right:1px solid black; height:40px; text-align: center;"><?= $sl_no = $sl_no + 1; ?></td>
                        <td
                            style="width:50%; border-right:1px solid black; height:40px; text-align: right; padding-right:10px; font-weight: bold;">
                            Output SGST</td>
                        <td style="width:14%; height:40px; text-align: right; padding-right:10px; font-weight: bold;"><?= number_format(($gst_rate / 2), 2); ?></td>
                    </tr>
                    <tr>
                        <td
                            style="width:5%; border-right:1px solid black; border-bottom:1px solid black; height:5px; text-align: center;">
                        </td>
                        <td
                            style="width:50%; border-right:1px solid black; border-bottom:1px solid black; height:5px; text-align: right; padding-right:10px">
                        </td>
                        
                        <td style="width:14%; height:0px; text-align: right; border-bottom:1px solid black;padding-right:10px">
                        </td>
                    </tr>
                    <tr>
                        <th style="width:5%; border-right:1px solid black; height:40px; "></th>
                        <th style="width:50%; border-right:1px solid black; height:40px; text-align: right; padding-right:10px;">
                            Total</th>
                        <th style="width:14%; text-align: right; padding-right:10px; font-weight: bold; font-size:20px;"><img
                                src="<?= base_url(); ?>assets/images/indian-rupees.png" style="width:10px;" /><?= number_format($payment_amount, 2); ?></th>
                    </tr>

                </table>

                <!--End of row 2-->
            </td>
        </tr>

        <tr>
            <td style="border-bottom:1px solid black;">
                <!--row 3-->
                <table cellpadding="0" cellspacing="0" style="clear: both;border-left:1px solid black; border-right:1px solid black; width:100%">
                    <tr>
                        <td style="float: left; text-align: left;padding-left:10px">Amount Chargeable (in words)</td>
                        <td style="float:right; text-align: right;padding-right:10px;">E. & O.E</td>
                    </tr>
                    <tr>
                        <td style="padding-left:10px; font-size: 20px; font-weight: bold;">INR <?= AmountInWords($payment_amount); ?></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <!--row 4-->
                <table cellpadding="0" cellspacing="0" style="width:100%; border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black">
                    <tr style="border-bottom:1px solid black">
                        <th style="width:30%; border-right:1px solid black; padding-top:5px">HSN/SAC</th>
                        <th style="width:12%; border-right:1px solid black; font-size:16px;">Taxable</th>
                        <th colspan="2" style="width:7%; border-right:1px solid black; border-bottom:1px solid black">Central Tax</th>
                        <th colspan="2" style="width:7%; border-right:1px solid black; border-bottom:1px solid black;">State Tax</th>
                        <th style="width:10%">Total</th>
                    </tr>
                    <tr style="border-bottom:1px solid black">
                        <th style="width:50%; border-right:1px solid black"></th>
                        <th style="width:12%; border-right:1px solid black; font-size:16px;">Value</th>
                        <th style="width:7%; border-right:1px solid black; font-size:16px;">Rate</th>
                        <th style="width:10%; border-right:1px solid black; font-size:16px;">Amount</th>
                        <th style="width:7%; border-right:1px solid black; font-size:16px;">Rate</th>
                        <th style="width:10%; border-right:1px solid black; font-size:16px;">Amount</th>
                        <th style="width:10%">Tax Amount</th>
                    </tr>
                    <tr>
                        <td
                            style="height:30px; width:30%; border-top:1px solid black; border-right:1px solid black; border-bottom:1px solid black; padding-left:10px">
                            9982</td>
                        <td
                            style="height:30px; width:10%; border-top:1px solid black; border-right:1px solid black; border-bottom:1px solid black; text-align: right; padding-right:4px;">
                            <?php
                                $taxable_val = number_format(($payment_amount - $gst_rate), 2);
                                echo $taxable_val;

                                $gst_percentage = str_replace("%", "", $course_details[0]['ss_aw_gst_rate']);
                                $gst_percentage = (float) $gst_percentage;
                                $divided_percentage = $gst_percentage / 2;
                            ?> 
                        </td>
                        <td
                            style="height:30px; width:5%; border-top:1px solid black; border-right:1px solid black; border-bottom:1px solid black; text-align: center;">
                            <?= $divided_percentage; ?>%</td>
                        <td
                            style="height:30px; width:9%; border-top:1px solid black; border-right:1px solid black; border-bottom:1px solid black; text-align: right; padding-right:5px;">
                            <?= number_format(($gst_rate / 2), 2); ?></td>
                        <td
                            style="height:30px; width:5%; border-top:1px solid black; border-right:1px solid black; border-bottom:1px solid black; text-align: center;">
                            <?= $divided_percentage; ?>%</td>
                        <td
                            style="height:30px; width:9%; border-top:1px solid black; border-right:1px solid black; border-bottom:1px solid black; text-align: right; padding-right:5px;">
                            <?= number_format(($gst_rate / 2), 2); ?></td>
                        <td style="height:30px; width:10%; border-top:1px solid black; text-align: right; padding-right:5px;">
                            <?= number_format($gst_rate, 2); ?></td>
                    </tr>

                    <tr style="border-bottom:1px solid black">
                        <th style="height:30px; width:30%; border-right:1px solid black; text-align: right;padding-right:10px;">
                            Total</th>
                        <th style="height:30px; width:10%; border-right:1px solid black; text-align: right; padding-right:5px;">
                            <?= $taxable_val; ?></th>
                        <th style="height:30px; width:5%; border-right:1px solid black"></th>
                        <th style="height:30px; width:9%; border-right:1px solid black; text-align: right; padding-right:5px;">
                            <?= number_format(($gst_rate / 2), 2); ?></th>
                        <th style="height:30px; width:5%; border-right:1px solid black"></th>
                        <th style="height:30px; width:9%; border-right:1px solid black; text-align: right; padding-right:5px;">
                            <?= number_format(($gst_rate / 2), 2); ?></th>
                        <th style="height:30px; width:10%; text-align: right; padding-right:5px;border-top:1px solid black;"><?= number_format($gst_rate, 2); ?></th>
                    </tr>

                    <tr>
                        <td colspan="7" style="padding:10px; border-top:1px solid black; border-bottom:1px solid black;">Tax Amount(in words): <b>INR <?= AmountInWords($gst_rate); ?></b></td>
                    </tr>

                    <tr>
                        <td colspan="7" style="text-align: center; padding-top:7px; padding-bottom:7px">
                            **THIS IS A SYSTEM GENERATED INVOICE AND DOES NOT REQUIRE ANY SIGNATURE
                        </td>
                    </tr>
                </table>
                <!--End of row 4-->
            </td>
        </tr>
    </table>
    
</body>

</html>