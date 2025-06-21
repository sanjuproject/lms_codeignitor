<?php
    function AmountInWords(float $amount){
       $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
       // Check if there is any number after decimal
       $amt_hundred = null;
       $count_length = strlen($num);
       $x = 0;
       $string = array();
       $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
         3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
         7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
         10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
         13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
         16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
         19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
         40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
         70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $x < $count_length ) {
          $get_divider = ($x == 2) ? 10 : 100;
          $amount = floor($num % $get_divider);
          $num = floor($num / $get_divider);
          $x += $get_divider == 10 ? 1 : 2;
          if ($amount) {
           $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
           $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
           $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
           '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
           '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
            }
       else $string[] = null;
       }
       $implode_to_Rupees = implode('', array_reverse($string));
       $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
       " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
       return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
    }
?>
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
            font-size: 15px;
        }

        .heading-text {
            font-size: 22px;
            font-weight: bold;
        }

        .name-heading {
            font-size: 18px;
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
                <td cellpadding="0" cellspacing="0">
                <table >
                    <tr>
                        <td cellpadding="0" cellspacing="0"  style="width:340px;">
                        <table >
                        <tr>
            <td class="name-heading">ALSOWISE™ CONTENT LLP</td>
        </tr>
        <tr>
            <td class="small-text">P-8, Chowringhee Square, Swastic Centre</td>
        </tr>
        <!-- <tr>
            <td class="small-text">1st Floor, Unit-101</td>
        </tr> -->
        <tr>
            <td class="small-text">Unit-101, Kolkata</td>
        </tr>
        <tr>
            <td class="small-text">Ph-033-40048577</td>
        </tr>
        <!-- <tr>
            <td class="small-text">M-9830357840</td>
        </tr> -->
        <tr>
            <td  class="small-text">GSTIN/UIN: 19AEFPB6192R1ZU</td>
        </tr>
        <tr>
            <td class="small-text">State Name : West Bengal, Code : 19</td>
        </tr>
        <tr>
            <td class="small-text" style="border-bottom:1px solid black;width:340px" >E-Mail : support@alsowise.com</td>
        </tr>
    </table>
        <table>
        <tr>
            <td colspan="2" class="heading-text ">Buyer</td>
        </tr>
        <tr>
            <td colspan="2" class="name-heading"><?= $parent_details[0]->ss_aw_parent_full_name; ?></td>
        </tr>
        <tr>
            <td colspan="2" class="small-text"><?= $parent_details[0]->ss_aw_parent_address; ?></td>
        </tr>
        <tr>
            <td colspan="2" class="small-text"><?= $parent_details[0]->ss_aw_parent_city; ?></td>
        </tr>
        <tr>
            <td colspan="2" class="small-text"><?= $parent_details[0]->ss_aw_parent_state; ?></td>
        </tr>
        <tr>
            <td colspan="2" class="small-text"><?= $parent_details[0]->ss_aw_parent_pincode; ?></td>
        </tr>
        <tr>
            <td colspan="2" class="small-text">M-<?= $parent_details[0]->ss_aw_parent_primary_mobile; ?></td>
        </tr>
        <!-- <tr>
        <td class="small-text">GSTIN/UIN</td>
            <td class="small-text">: 19AABCV2516J1Z9</td>
    </tr>
    <tr>
    <td class="small-text">PAN/IT No</td>
            <td class="small-text">: AABCV2516J</td>
    </tr>
    <tr>
    <td class="small-text">State Name</td>
            <td class="small-text">: West Bengal, Code : 19</td>
    </tr>
    <tr>
    <td class="small-text">Place of Supply</td>
            <td class="small-text">: West Bengal</td>
    </tr> -->
    
        
                        </table>
                        </td>
                        <td style="vertical-align: top; width:270px; border-left:1px solid black">
                        <table style="border-bottom:1px solid black;">
                            <td cellpadding="0" cellspacing="0" style="width:170px;">
                                <table style="border-right:1px solid black;" >
                                <tr>
            <td class="small-text">Invoice No.</td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid black; width:170px;" class="invoice-no text-bold"><?= $invoice_no; ?></td>
        </tr>
        <tr>
            <td class="small-text">Buyer's Order No.</td>
        </tr>
        <tr>
            <td class="invoice-no text-bold"><?= $invoice_no; ?></td>
        </tr>
                                </table>
                            </td>
                            <td style="width:170px;">
                            <table>
                            <tr>
            <td class="small-text">Invoice No.</td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid black; width:170px;" class="invoice-no text-bold"><?= $invoice_no; ?></td>
        </tr>
        <tr>
            <td class="small-text">Buyer's Order No.</td>
        </tr>
        <tr>
            <td cellpadding="0" cellspacing="0" class="invoice-no text-bold"><?= $invoice_no; ?></td>
        </tr>
                                    </table>
                            </td>
                        </table>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
                <td style="border-bottom:1px solid black; width:100%"> </td>
    </tr>
        <tr>
            <td>
                <!-- particular -->
    <table
        style="clear: both; border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; width:100%">
        <tr>
            <th style="width:5%; border-right:1px solid black; height:40px; ">Sl No.</th>
            <th style="width:50%; border-right:1px solid black; height:40px; ">Particulars</th>
            <th style="width:14%">Amount</th>
        </tr>
        <?php
            $sl_no = 1;
        ?>
        <tr>
            <td
                style="width:5%; border-right:1px solid black; border-top:1px solid black; height:40px; text-align: center;">
                <?= $sl_no; ?></td>
            <td
                style="width:50%; border-right:1px solid black; border-top:1px solid black; height:40px; text-align: left; padding-left:10px; font-weight: bold;">
                <?php if ($course_id == 1) {
        echo "Emerging";
    }elseif ($course_id == 2) {
        echo "Consolidated";
    }else{
        echo "Advanced";
    } ?></td>
            <td
                style="width:14%;border-top:1px solid black; height:40px; text-align: right; padding-right:10px; font-weight: bold;">
                <?= number_format(($payment_amount - $gst_rate), 2); ?></td>
        </tr>
        <!-- <tr>
            <td style="width:5%; border-right:1px solid black;"></td>
            <td style="width:50%; border-right:1px solid black; text-align: left; padding-left:10px">RFor The Month Of
                January, 2022</td>
            <td style="width:14%; text-align: right; padding-right:10px"></td>
        </tr> -->
        <?php
        if (!empty($coupon_id)) {
            ?>
            <tr>
                <td
                style="width:5%; border-right:1px solid black; border-top:1px solid black; height:40px; text-align: center;"></td>
                <td style="width:50%; border-right:1px solid black; text-align: left; padding-left:10px">Discount Amount ( Coupon Code - <?= $coupon_id; ?> )</td>
                <td style="width:14%; text-align: right; padding-right:10px"><?= number_format($discount_amount, 2); ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td style="width:5%; border-right:1px solid black; height:20px; text-align: center;"><?= $sl_no = $sl_no + 1; ?></td>
            <td
                style="width:50%; border-right:1px solid black; height:20px; text-align: right; padding-right:10px; font-weight: bold;">
                Output Cgst</td>
            <td style="width:14%; height:40px; text-align: right; padding-right:10px; font-weight: bold;"><?= number_format(($gst_rate / 2), 2); ?></td>
        </tr>
        <tr>
            <td style="width:5%; border-right:1px solid black; height:40px; text-align: center;"><?= $sl_no = $sl_no + 1; ?></td>
            <td
                style="width:50%; border-right:1px solid black; height:40px; text-align: right; padding-right:10px; font-weight: bold;">
                Output Sgst</td>
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
            </td>
        </tr>
        <tr>
            <td>
            <table
        style="clear: both; border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; width:100%">
        <tr>
            <td style="float: left; text-align: left;padding-left:10px">Amount Chargeable (in words)</td>
            <td style="float:right; text-align: right;padding-right:10px">E. & O.E</td>
        </tr>
        <tr>
            <td style="padding-left:10px; font-size: 20px; font-weight: bold;">INR <?= AmountInWords($payment_amount); ?></td>
        </tr>
    </table>
            </td>
        </tr>
        <tr>
            <td>
            <table style="width:100%; border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black">
        <tr style="border-bottom:1px solid black">
            <th rowspan="2" style="width:30%; border-right:1px solid black">HSN/SAC</th>
            <th style="width:10%; border-right:1px solid black">Taxable</th>
            <th colspan="2" style="width:7%; border-right:1px solid black; border-bottom:1px solid black">Central Tax
            </th>
            <!-- <th style="width:7%; border-right:1px solid black">amount</th> -->
            <th colspan="2" style="width:7%; border-right:1px solid black; border-bottom:1px solid black">State Tax</th>
            <!-- <th style="width:7%; border-right:1px solid black">amount</th> -->
            <th style="width:10%">Total</th>
        </tr>
        <tr style="border-bottom:1px solid black">
            <!-- <th style="width:50%; border-right:1px solid black">HSN/SAC</th> -->
            <th style="width:10%; border-right:1px solid black">Value</th>
            <th style="width:5%; border-right:1px solid black">Rate</th>
            <th style="width:9%; border-right:1px solid black">Amount</th>
            <th style="width:5%; border-right:1px solid black">Rate</th>
            <th style="width:9%; border-right:1px solid black">Amount</th>
            <th style="width:10%">Tax Amount</th>
        </tr>
        <tr>
            <td
                style="height:30px; width:30%; border-top:1px solid black; border-right:1px solid black; border-bottom:1px solid black; padding-left:10px">
                9982</td>
            <td
                style="height:30px; width:10%; border-top:1px solid black; border-right:1px solid black; border-bottom:1px solid black; text-align: right; padding-right:5px;">
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
            <th style="height:30px; width:10%; text-align: right; padding-right:5px;"><?= number_format($gst_rate, 2); ?></th>
        </tr>
    </table>
    
    
    
    <!-- particular -->
    <table style="clear:both"></table>
    <table style="width:100%">
        <tr>
            <td style="text-align: center; padding:10px;">**THIS IS A SYSTEM GENERATED INVOICE AND DOES NOT REQUIRE ANY SIGNATURE</td>
        </tr>
    </table>

</body>

</html>