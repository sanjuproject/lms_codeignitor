<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alsowise Invoice</title>
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
                                        <td class="name-heading" style="padding-left:5px; padding-top:5px;">B.Pathology</td>
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
                                        <td class="small-text" style="border-bottom:1px solid black;width:340px; padding-left:5px" >Email: support@alsowise.com</td>
                                    </tr>

                                    <tr>
                                        <td class="heading-text" style="padding-left:5px; padding-top:5px">Buyer</td>
                                    </tr>
                                    <tr>
                                        <td class="name-heading" style="padding-left:5px">Patient Name</td>
                                    </tr>
                                    <tr>
                                        <td class="small-text" style="padding-left:5px">Patient Address</td>
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
                                        <td style="border-bottom:1px solid black; width:170px;border-right:1px solid black; padding-left:5px; font-size:18px;" class="invoice-no text-bold">Invoice No</td>
                                        <td style="border-bottom:1px solid black; width:170px; font-size:18px; padding-left:5px" class="invoice-no text-bold">Invoice Date</td>
                                    </tr>
                                    <!-- <tr>
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
                                    </tr> -->
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
                            <p>Blood test</p>
                        </td>
                        <td style="width:14%;border-top:1px solid black; height:40px; text-align: right; padding-right:10px; font-weight: bold;">
                            4,800
                        </td>
                    </tr>

                    <tr>
                        <td style="width:5%; border-right:1px solid black; height:40px; text-align: center;"></td>
                        <td style="width:50%; border-right:1px solid black; text-align: left; padding-left:10px">Advance Amount</td>
                        <td style="width:14%; text-align: right; padding-right:10px">100</td>
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
                                src="<?= base_url(); ?>assets/images/indian-rupees.png" style="width:10px;" />5000</th>
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
                        <td style="padding-left:10px; font-size: 20px; font-weight: bold;">INR <?= AmountInWords(5000); ?></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <!--row 4-->
                <table cellpadding="0" cellspacing="0" style="width:100%; border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black">
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