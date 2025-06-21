<?php
//    @$block_b_statement = json_decode(@$scoring_statements[0]->block_b);
//    @$block_c_statement = json_decode(@$scoring_statements[0]->block_c);
//    @$block_d_statement = json_decode(@$scoring_statements[0]->block_d);
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
            rel="stylesheet">
        <title>Document</title>
        <style type="text/css">
            @page {
                margin: 0;
            }
        </style>
    </head>

    <body style="margin: 0px;background-color: #f9ef7e;">

        <div style="background-color: #f9ef7e;">

            <table cellspacing="0" cellpadding="0"
                   style="width: 100%;background-color: #f9ef7e; height: 1017px;">
                <tr>
                    <td style="padding-top: 30px;width: 100%;background-image: url(<?= base_url(); ?>images/header.jpg);background-size: auto;background-position:left top;background-repeat:repeat-x;vertical-align:top;">
                        <table cellspacing="0" cellpadding="0" style="width: 100%;">
                            <tr>
                                <td style="margin-bottom: 5px;text-align: center;">
                                    <img src="<?= base_url(); ?>images/team-logo-without-name.png" style="width: 150px;" alt="">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">
                                    <img src="<?= base_url(); ?>images/team-logo-text.png" style="width: 200px;" alt="">
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 10px;padding-top: 5px;text-align: center;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 14px;">
                                    Language | Reading | Communication
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 10px;text-align: center;"><label for=""
                                                                                         style="font-size: 24px;color: #797106;font-family: 'Roboto', sans-serif;"><?= $child_details->course_level == 'M' ? "User's" : "Student's" ?>
                                        Name:</label>
                                    <label for=""
                                           style="font-size: 24px;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 300;"><?= ucfirst(strtolower($child_details->ss_aw_child_first_name)) . ' ' . ucfirst(strtolower($child_details->ss_aw_child_last_name)); ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 30px;text-align: center;padding-top: 5px;">
                                    <label for=""
                                           style="font-size: 24px;color: #797106;font-family: 'Roboto', sans-serif;">Course
                                        Name:</label>
                                    <label for=""
                                           style="font-size: 24px;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 300;">

                                        team<span style="vertical-align:0.7em; font-size:0.6em;">&reg; </span> <?= $title ?> Programme</label>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="width: 100%;background-color: #011ca9;padding: 10px 0px;color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 20px;text-align: center;">
                                    SUMMARY PERFORMANCE	REPORT

                                </td>
                            </tr>
                            <tr>
                                <td style="width: 100%;padding: 20px 50px;text-align: left;padding-top: 5px;">
                                    <p
                                        style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                        <?= $text ?></p>
                                    <?php
                                    if ($child_details->course_level == 'E') {
                                        ?>
                                        <p style="color: #797106;font-family: 'Roboto', sans-serif;font-size: 18px;">The course covers many elements of English grammar, vocabulary, language usage, and reading skills, to drive proficiency in and confidence with the language.</p>
                                        <?php
                                    } elseif ($child_details->course_level == 'C') {
                                        ?>
                                        <p style="color: #797106;font-family: 'Roboto', sans-serif;font-size: 18px;">The course covers many elements of English grammar, vocabulary, language usage, and reading skills, to drive proficiency in and confidence with the language.</p>
                                        <?php
                                    } else {
                                        ?>
                                        <p style="color: #797106;font-family: 'Roboto', sans-serif;font-size: 18px;">The course covers many elements of English grammar, vocabulary, language usage, and reading skills, to drive proficiency in and confidence with the language.</p>
                                        <?php
                                    }
                                    ?>

                                    <h3 style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 28px;">
                                        Definitions</h3>
                                    <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;"><span
                                            style="font-weight: 700;">Lesson Quiz:</span> Questions asked from time to time during a Lesson to check for understanding of the topic.</p>
                                    <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;"><span
                                            style="font-weight: 700;">Assessment Quiz:</span> A comprehensive quiz on a specific topic taken after the completion of each lesson.</p> 
                                    <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;"><span
                                            style="font-weight: 700;">Quintile: </span> 5 groups, each containing approximately 20% of the population; Quintile 1 is the lowest performing group while Quintile 5 is the highest performing group.</p>            
                                    <p
                                        style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;margin: 0px;">
                                        <span style="font-weight: 700;">Diagnostic Test :</span> The original evaluation of <?= $child_details->course_level == "E" || $child_details->course_level == "A" ? "<b>".ucfirst(strtolower($child_details->ss_aw_child_first_name))."'s</b>" : '<b>your</b>' ?>
                                        English language proficiency before  starting the programme.
                                    </p>



                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>



            <?php
            $total_assesment_actual = 0;
            $total_assesment_protencial = 0;
            $total_voc_assesment_actual = 0;
            $total_voc_assesment_protencial = 0;
            $total_assesment_percent = 0;
            $total_voc_assesment_percent = 0;
            $i = 1;
            $his = $child_details->ss_aw_child_gender == 1 ? 'his' : ($child_details->ss_aw_child_gender == 2 ? 'her' : 'his/her');
            $he_she = $child_details->ss_aw_child_gender == 1 ? 'he' : ($child_details->ss_aw_child_gender == 2 ? 'she' : 'he/she');
            if (!empty(@$course_details_grammer->result())) {
                ?>
                <table cellspacing="0" cellpadding="0"
                       style="width: 100%;background-image: url(<?= base_url(); ?>images/header2.jpg);background-size: auto;background-position: left top;background-repeat:repeat-x;margin-bottom:0px;">
                    <tr>
                        <td style="width: 100%;vertical-align:top;padding: 20px 50px;">
                            <table cellspacing="0" cellpadding="0" style="width: 100%;">
                                <tr>
                                    <td
                                        style="vertical-align:top;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 24px;margin: 0px;padding-bottom: 10px;">

                                        Grammar Proficiency

                                        </br>
                                        <p
                                            style="font-weight: 400;font-size: 18px;text-align: justify;margin:0px;padding-top: 5px;">
                                            <?= $child_details->course_level != 'M' ? "<b>".ucfirst(strtolower($child_details->ss_aw_child_first_name))."</b>" : "You" ?> completed the following lessons during this course:</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100%;vertical-align:top">
                                        <table style="width: 100%;" cellspacing="0" cellpadding="0">
                                            <thead style="background: #011ca9;width: 100%;">
                                                <tr>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;border:1px solid #fdf6b2;">
                                                        #Lesson</th>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;border:1px solid #fdf6b2;">
                                                        Topic</th>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px; border:1px solid #fdf6b2;">
                                                        Lesson Quiz Performance</th>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;border:1px solid #fdf6b2;">
                                                        Assessment Performance</th>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;border:1px solid #fdf6b2;">
                                                        Quintile</th>    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 0;
                                                foreach ($course_details_grammer->result() as $key => $value) {

                                                    $count++;
                                                    if ($count % 2 == 0) {
                                                        $background_color = "#d8dbea";
                                                    } else {
                                                        $background_color = "#fdf6b2";
                                                    }

                                                    $his = $child_details->ss_aw_child_gender == 1 ? 'his' : ($child_details->ss_aw_child_gender == 2 ? 'her' : 'his/her');
                                                   
                                                        $percent_text = $child_details->course_level == 'M' ? "<b>You</b> would benefit a great deal from reviewing some of your lessons again,"
                                                                . " especially those topics in which your assessment quiz score was less than 35%."
                                                                . " This will ensure that you are able to focus on areas that need improvement."
                                                                . " Moreover, we recommend the purchase of supplementary courses to aid your learning and improve"
                                                                . " response accuracy." :
                                                                "<b>".ucfirst(strtolower($child_details->ss_aw_child_first_name))."</b> would benefit a great 
                                            deal from reviewing some of $his lessons again, especially those topics in which his assessment quiz score was "
                                                                . "less than 35%. This will ensure that he is able to focus on areas that need improvement. Moreover, we "
                                                                . "recommend the purchase of supplementary courses to aid his learning and improve response accuracy.";
                                                   
                                                    $text_grammer_view=false;
                                                      if($value->correct_answer_percentage_asses<35){
                                                          $text_grammer_view=true;
                                                      } 
                                                    
                                                    
                                                    ?>
                                                    <tr style="background-color: <?= $background_color; ?>;">
                                                        <td
                                                            style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                            <?= $count; ?></td>
                                                        <td
                                                            style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                            <?= $value->ss_aw_section_title; ?></td>
                                                        <td
                                                            style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                            <?= $value->correct_answer_percentage_lesson . "%"; ?></td>
                                                        <td
                                                            style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                            <?= $value->correct_answer_percentage_asses . "%"; ?></td>
                                                        <td
                                                            style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                            <?= quintileTopicQuintile($value->correct_answer_percentage_asses, $value->ss_aw_section_title, $child_details->course_level); ?></td>    

                                                    </tr>
                                                    <?php
                                                    $total_assesment_actual = $total_assesment_actual + $value->correct_answer_asses;
                                                    $total_assesment_protencial = $total_assesment_protencial + $value->potencial_total;
                                                }
                                                $total_assesment_percent = $total_assesment_actual != 0 ? round((($total_assesment_actual * 100) / $total_assesment_protencial), 2) : "";
                                                ?>

                                                <tr style="background-color: #fff;">
                                                    <td style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: left;border:2px solid #011ca9;border-right: none;"></td>
                                                    <td colspan="2"
                                                        style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: left;border:2px solid #011ca9;border-right: none;">
                                                        TOTAL</td>
                                                    <td
                                                        style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:2px solid #011ca9;border-left: none;">
                                                        <?= $total_assesment_percent; ?>%</td>
                                                    <td
                                                        style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:2px solid #011ca9;border-left: none;">
                                                        <?= combineTotalQuintile($total_assesment != 0 ? round($total_assesment / $count, 2) : "", $child_details->course_level); ?></td>    

                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;margin:10px 0px;padding-top: 5px;">
                                            <?php if($text_grammer_view==true){echo $percent_text;} ?>                



                                        </p>
                                    </td>
                                </tr>
                            </table>                      
                        </td>
                    </tr>
                </table>
            <?php }if (!empty(@$course_details_vocabulary->result())) {
                ?>
                <table cellspacing="0" cellpadding="0"
                       style="width: 100%;background-image: url(<?= base_url(); ?>images/header2.jpg);background-size: auto;background-position: left top;background-repeat:repeat-x;">
                    <tr>
                        <td style="width: 100%;vertical-align:top;padding: 20px 50px;">                            
                            <table cellspacing="0" cellpadding="0" style="width: 100%;">
                                <tr>
                                    <td
                                        style="vertical-align:top;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 24px;margin: 0px;padding-bottom: 10px;">

                                        Vocabulary Proficiency

                                        </br>
                                        <p
                                            style="font-weight: 400;font-size: 18px;text-align: justify;margin:0px;padding-top: 5px;">
                                            <?= $child_details->course_level != 'M' ? "<b>".ucfirst(strtolower($child_details->ss_aw_child_first_name))."</b>" : "You" ?> completed the following lessons during this course:</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100%;vertical-align:top">
                                        <table style="width: 100%;" cellspacing="0" cellpadding="0">
                                            <thead style="background: #011ca9;width: 100%;">
                                                <tr>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;border:1px solid #fdf6b2;">
                                                        #Lesson</th>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;border:1px solid #fdf6b2;width:55%;">
                                                        Topic</th>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px; border:1px solid #fdf6b2;">
                                                        Lesson Quiz Performance</th>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;border:1px solid #fdf6b2;">
                                                        Assessment Performance</th>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;border:1px solid #fdf6b2;">
                                                        Quintile</th>    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 0;
                                                $i++;
                                                if (!empty($course_details_vocabulary->result())) {

                                                    foreach ($course_details_vocabulary->result() as $key => $value) {

                                                        $count++;
                                                        if ($count % 2 == 0) {
                                                            $background_color = "#d8dbea";
                                                        } else {
                                                            $background_color = "#fdf6b2";
                                                        }

                                                        $his = $child_details->ss_aw_child_gender == 1 ? 'his' : ($child_details->ss_aw_child_gender == 2 ? 'her' : 'his/her');
                                                        $he = $child_details->ss_aw_child_gender == 1 ? 'he' : ($child_details->ss_aw_child_gender == 2 ? 'she' : 'he/she');
                                                        $vocabulary_text = $child_details->course_level != 'M' ? "<b>".ucfirst(strtolower($child_details->ss_aw_child_first_name))."</b> would" : "<b>You</b> would";

                                                        $vocabulary_text .= " benefit a great deal from reviewing some of" . $child_details->course_level != 'M' ? $his : 'your' . " lessons again, 
                                                especially those topics in which" . $child_details->course_level != 'M' ? $his : 'your' . " assessment quiz score was 
                                                less than 35%. This will ensure that" . $child_details->course_level != 'M' ? $he . ' is' : 'you are' . " able to focus on areas
                                                that need improvement. Moreover, we recommend the purchase of supplementary courses to aid" . $child_details->course_level != 'M' ? $his : 'your' . "
                                                learning and improve response accuracy.";
                                                      $text_voc_view=false;
                                                      if($value->correct_answer_percentage_asses<35){
                                                          $text_voc_view=true;
                                                      }  
                                                        
                                                        
                                                        ?>
                                                        <tr style="background-color: <?= $background_color; ?>;">
                                                            <td
                                                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                                <?= $count; ?></td>
                                                            <td
                                                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                                <?= $value->ss_aw_section_title; ?></td>
                                                            <td
                                                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                                <?= $value->correct_answer_percentage_lesson . "%"; ?></td>
                                                            <td
                                                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                                <?= $value->correct_answer_percentage_asses . "%"; ?></td>
                                                            <td
                                                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                                <?= quintileTopicQuintile($value->correct_answer_percentage_asses, $value->ss_aw_section_title, $child_details->course_level); ?></td>    

                                                        </tr>
                                                        <?php
                                                        $total_voc_assesment_actual = $total_voc_assesment_actual + $value->correct_answer_asses;
                                                        $total_voc_assesment_protencial = $total_voc_assesment_protencial + $value->potencial_total;
                                                    }
                                                    $total_voc_assesment_percent = $total_voc_assesment_actual != 0 ? round((($total_voc_assesment_actual * 100) / $total_voc_assesment_protencial), 2) : "";
                                                    ?>

                                                    <tr style="background-color: #fff;">
                                                        <td style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: left;border:2px solid #011ca9;border-right: none;"></td>
                                                        <td colspan="2"
                                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: left;border:2px solid #011ca9;border-right: none;">
                                                            TOTAL</td>
                                                        <td
                                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:2px solid #011ca9;border-left: none;">
                                                            <?= $total_voc_assesment_percent != 0 ? round($total_voc_assesment_percent, 2) : 0; ?>%</td>
                                                        <td
                                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:2px solid #011ca9;border-left: none;">
                                                            <?= combineTotalQuintile($total_voc_assesment != 0 ? round($total_voc_assesment / $count, 2) : "", $child_details->course_level); ?></td>    

                                                    </tr>
                                                <?php }
                                                ?>




                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>


                                        <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;margin:10px 0px;padding-top: 5px;">
                                            <?php if($text_voc_view==true){echo $vocabulary_text;} ?>
                                        </p>
                                    </td>
                                </tr>
                            </table>                                    
                        </td>
                    </tr>



                </table>
            <?php }
            ?>

            <table cellspacing="0" cellpadding="0"
                   style="width: 100%;background-image: url(<?= base_url(); ?>images/header2.jpg);background-size: auto;background-position: left top;background-repeat:repeat-x;">

                <tr>
                    <td style="padding: 40px 50px">

                        <table cellspacing="0" cellpadding="0" style="width: 100%;">

                            <tr>
                                <td>
                                    <table style="width: 70%;" cellspacing="0" cellpadding="0">
                                        <thead style="background: #011ca9;width: 100%;">
                                            <tr>
                                                <th colspan="4"
                                                    style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                                    Diagnostic</th>
                                                <th colspan="4"
                                                    style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                                    Total Assessment</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr style="background-color: #fdf6b2;">
                                                <td colspan="2"
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    % Correct</td>
                                                <td colspan="2"
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    Peer Quintile</td>    
                                                <td colspan="2"
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    % Correct</td>
                                                <td colspan="2"
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    Peer Quintile</td>

                                            </tr>
                                            <tr style="background-color: #d8dbea;">
                                                <td colspan="2"
                                                    style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                    <?= number_format($diagonastic_percentage, 2) . "%"; ?></td>
                                                <td colspan="2"
                                                    style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                    <?= diagnosticQuantile($diagonastic_percentage, $child_details->course_level); ?></td>    
                                                <td colspan="2"
                                                    style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                    <?= $total_assesment_percent . "%"; ?></td>
                                                <td colspan="2"
                                                    style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                    <?= assessmentQuantile(round((float) $total_assesment_percent), $child_details->course_level); ?></td>    

                                            </tr>

                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>


            </table>
            <table cellspacing="0" cellpadding="0"
                   style="width: 100%;background: #f9ef7e;">
                <tr>
                    <td style="width: 100%;vertical-align:top;padding: 20px 50px;">                            
                        <table cellspacing="0" cellpadding="0" style="width: 100%;"> 
                            <?php
                            $diagon_statement = getDiagonStatement($total_assesment_percent, $child_details);
                            ?>
                            <tr>
                                <td style="padding-top: 20px;">
                                    <p
                                        style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                        <?= $diagon_statement ?></p>

                                </td>
                            </tr>
                        </table>                                    
                    </td>
                </tr>
            </table>
            <?php if ($child_details->course_level != 'M') { ?>
                <!--non comprehension start--> 
                <table cellspacing="0" cellpadding="0"
                       style="width: 100%;background-image: url(<?= base_url(); ?>images/header2.jpg);background-size: auto;background-position: left top;background-repeat:repeat-x;">

                    <tr>
                        <td style="padding: 40px 50px">
                            <table cellspacing="0" cellpadding="0" style="width: 100%;">
                                <tr>
                                    <td style="vertical-align:top;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 24px;margin: 0px;padding-bottom: 10px;">
                                        Overall Command of the English Language
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p
                                            style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                            In addition to grammar and vocabulary proficiency, we also tested for an overall understanding of English language usage including sentence construction, spelling accuracy, punctuation, ability to apply the rules of grammar to unfamiliar contexts, etc.</p>
                                        <p
                                            style="margin:0px;padding-top:10px;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 18px;text-align: justify;">
                                            Lesson and Assessment</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 20px;">
                                        <table style="width: 70%;" cellspacing="0" cellpadding="0">
                                            <thead style="background: #011ca9;width: 100%;">
                                                <tr>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                                        #Lesson / Assessment</th>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                                        Score</th>
                                                    <th
                                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                                        Peer Quintile</th>    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total_average = 0;
                                                if (!empty($non_comprehension)) {
                                                    $count = 0;
                                                    foreach ($non_comprehension as $value) {

                                                        $count++;
                                                        if ($count % 2 == 0) {
                                                            $background_color = "#d8dbea";
                                                        } else {
                                                            $background_color = "#fdf6b2";
                                                        }

                                                        $leson_per = @$value['lesson_percent'] != '' ? $value['lesson_percent'] : 0;
                                                        $asses_per = $value['assesment_percent'] != '' ? $value['assesment_percent'] : 0;

                                                        $single_average = round(($leson_per + $asses_per) / 2, 2);
                                                        $total_average = $total_average + $single_average;
                                                        ?>
                                                        <tr style="background-color: <?= $background_color; ?>;">
                                                            <td
                                                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                                <?= $value['topic_name']; ?></td>
                                                            <td
                                                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                                <?= $single_average ?>%</td>
                                                            <td
                                                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                                NA
                                                            </td>    
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <tr style="background-color: #d8dbea;">
                                                    <td
                                                        style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                        Total</td>
                                                    <td
                                                        style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                        <?= round($total_average / $count, 2); ?>%</td>
                                                    <td
                                                        style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                        <?= formatTwoLessonAssessmentQuintile($total_average, $child_details->course_level); ?></td>    
                                                </tr>                                               

                                            </tbody>
                                        </table>
                                        <?php
                                        $comm_statement = getcomStatement($total_average, $child_details);
                                        ?>
                                <tr>
                                    <td style="padding-top: 20px;">
                                        <p
                                            style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                            <?= $comm_statement ?></p>

                                    </td>
                                </tr>


                        </td>
                    </tr>



                </table>
            </td>
        </tr>

    </table>
    <!--non comprehension End--> 
    <!-- comprehension Start--> 
    <table cellspacing="0" cellpadding="0"
           style="width: 100%;background-image: url(<?= base_url(); ?>images/header2.jpg);background-size: auto;background-position: left top;background-repeat:repeat-x;">

        <tr>
            <td style="padding: 40px 50px">    
                <table cellspacing="0" cellpadding="0" style="width: 100%;">

                    <tr>
                        <td>
                            <p
                            <?php $ruleC = gettheruleCcontain($child_details); ?>
                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                <strong>Reading Comprehension</strong>

                            </p>
                            <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                Additionally, we assessed <b><?= ucfirst(strtolower($child_details->ss_aw_child_first_name)) ?>'s</b> ability to comprehend 
                                the essence of short written passages through a set of reading comprehension tests.
                            </p>
                            <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                <?= $ruleC ?>
                            </p>
                            <p
                                style="margin:0px;padding-top:10px;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 18px;text-align: justify;">
                                Lesson And Assessment</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 20px;">
                            <table style="width: 70%;" cellspacing="0" cellpadding="0">
                                <thead style="background: #011ca9;width: 100%;">
                                    <tr>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            #Lesson / assessment</th>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            Score</th>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            Peer Quintile</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_average = 0;
                                    $final_average = 0;
                                    $singale_arr = array();
                                    if (!empty($comprehension)) {
                                        $count = 0;
                                        foreach ($comprehension as $value) {

                                            $count++;
                                            if ($count % 2 == 0) {
                                                $background_color = "#d8dbea";
                                            } else {
                                                $background_color = "#fdf6b2";
                                            }

                                            $leson_per = @$value['lesson_percent'] != '' ? $value['lesson_percent'] : 0;
                                            $asses_per = $value['assesment_percent'] != '' ? $value['assesment_percent'] : 0;

                                            $single_average = round(($leson_per + $asses_per) / 2, 2);
                                            $total_average = $total_average + $single_average;
                                            $final_average = round($total_average / $count, 2);
                                            array_push($singale_arr, $single_average);
                                            ?>
                                            <tr style="background-color: <?= $background_color; ?>;">
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= $value['topic_name']; ?></td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= $single_average ?>%</td>
                                                <td style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    NA
                                                </td>    
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <tr style="background-color: #d8dbea;">
                                        <td
                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                            Total</td>
                                        <td
                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                            <?= round($total_average / $count, 2); ?>%</td>
                                        <td
                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                            <?= formatTwoLessonAssessmentQuintile($total_average, $child_details->course_level); ?></td>    
                                    </tr>

                                </tbody>
                            </table>
                            <?php
                            $ruleA = gettheruleAcontain($total_average, $child_details);
                            ?>
                    <tr>
                        <td style="padding-top: 20px;">
                            <p
                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                <?= $ruleA ?></p>

                        </td>
                    </tr>                    
            </td>
        </tr>

    </table>
    </td>
    </tr>
    </table>
    <?php
}

$his_con = $child_details->ss_aw_child_gender == 1 ? "His" : "Her";
?>

<?php
$ruleReadalongC = getreadalongcontainC($child_details);
?>
<table cellspacing="0" cellpadding="0"
       style="width: 100%;background-image: url(<?= base_url(); ?>images/header2.jpg);background-size: auto;background-position: left top;background-repeat:repeat-x;">

    <tr>
        <td style="padding: 40px 50px">    
            <table cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td>
                        <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;"><strong>Level of Confidence</strong></p>




                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: left;margin:10px 0px;padding-top: 5px;">
                            <?= $child_details->course_level == 'M' ? $confidence['combine_string'] : "<b>".ucfirst(strtolower($child_details->ss_aw_child_first_name))."</b> " . $confidence['combine_string'] ?>
                            <?= $child_details->course_level == 'M' ? $confidence['y_string'] : $confidence['y_string'] ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p
                            style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">

                            <strong>Readalongs</strong></p>
                        <p
                            style="margin:0px;padding-top:0px;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 18px;text-align: justify;">
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 0px;">
                        <p
                            style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                            <?= $ruleReadalongC ?></p>

                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 20px;">
                        <table style="width: 70%;" cellspacing="0" cellpadding="0">
                            <thead style="background: #011ca9;width: 100%;">
                                <tr>
                                    <th
                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                        #</th>
                                    <th
                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                        Score</th>
                                    <th
                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                        Peer Quintile</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_average = 0;

                                $singale_arr = array();
                                if (!empty($readalong)) {
                                    $count = 0;
                                    foreach ($readalong->result() as $value) {

                                        $count++;
                                        if ($count % 2 == 0) {
                                            $background_color = "#d8dbea";
                                        } else {
                                            $background_color = "#fdf6b2";
                                        }

                                        $total_average = $total_average + $value->percent_readalong;
                                        array_push($singale_arr, $value->percent_readalong);
                                        ?>
                                        <tr style="background-color: <?= $background_color; ?>;">
                                            <td
                                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                <?= $count; ?></td>
                                            <td
                                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                <?= is_numeric($value->percent_readalong) ? $value->percent_readalong : 0 ?>%</td>
                                            <td
                                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                NA
                                            </td>    
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                <tr style="background-color: #d8dbea;">
                                    <td
                                        style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                        Total</td>
                                    <td
                                        style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                        <?= $total_average != 0 ? round($total_average / $count, 2) : 0 ?>%</td>
                                    <td
                                        style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                        <?= formatTwoLessonAssessmentQuintile($total_average, $child_details->course_level) ?></td>    
                                </tr>

                            </tbody>
                        </table>
                        <?php
                        $ruleReadalongE = getreadalongcontainE($total_average != 0 ? round($total_average / $count, 2) : 0, $child_details);
                        $ruleReadalongD = getreadalongcontainD($singale_arr, $total_average != 0 ? round($total_average / $count, 2) : 0, $child_details);
                        ?>
                <tr>
                    <td style="padding-top: 20px;">
                        <p
                            style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                <?= $ruleReadalongE ?>
                                <?php
                                if ($ruleReadalongD != '') {

                                    echo $ruleReadalongD;
                                }
                                ?></p>

                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 0px;">


                    </td>
                </tr>
        </td>
    </tr>

</table>
</td>
</tr>
</table>
<?php
if ($child_details->course_level == 'M') {
    ?>                
    <table cellspacing="0" cellpadding="0"
           style="width: 100%;background-image: url(<?= base_url(); ?>images/header2.jpg);background-size: auto;background-position: left top;background-repeat:repeat-x;">

        <tr>
            <td style="padding: 40px 50px">    
                <table cellspacing="0" cellpadding="0" style="width: 100%;">

                    <tr>
                        <td>
                            <p
                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">

                                <strong>Communication</strong></p>
                            <p
                                style="color: #797106;margin:0px;padding-top:10px;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                Finally we tested your Communication skill in two important areas: Face-To-Face Engagement and Written Communication.
                                We did this through a series of 5 Lessons and Assessment Quizzes.
                            </p>
                            <p
                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">

                                <strong>Face-To-Face Communication</strong></p>

                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 20px;">
                            <table style="width: 70%;" cellspacing="0" cellpadding="0">
                                <thead style="background: #011ca9;width: 100%;">
                                    <tr>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            #</th>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            Score</th>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            Peer Quintile</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_average = 0;
                                    $row_percent = 0;
                                    $singale_arr = array();
                                    if (!empty($face_to_face)) {
                                        $count = 0;
                                        foreach ($face_to_face->result() as $value) {

                                            $count++;
                                            if ($count % 2 == 0) {
                                                $background_color = "#d8dbea";
                                            } else {
                                                $background_color = "#fdf6b2";
                                            }
                                            $row_percent = ($value->correct_answer_percentage_lesson + $value->correct_answer_percentage_asses) / 2;

                                            $total_average = $total_average + $row_percent;
                                            array_push($singale_arr, $row_percent);
                                            ?>
                                            <tr style="background-color: <?= $background_color; ?>;">
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= $count; ?></td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= $row_percent ?>%</td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    NA
                                                </td>    
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <tr style="background-color: #d8dbea;">
                                        <td
                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                            Total</td>
                                        <td
                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                            <?= $total_average > 0 ? round($total_average / $count, 2) . '%' : 'NA' ?></td>
                                        <td
                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                            <?= formatTwoLessonAssessmentQuintile($total_average, $child_details->course_level); ?></td>    
                                    </tr>

                                </tbody>
                            </table>
                            <?php
                            $facetoface = getreadalongcontainFacetoFace(round(($total_average / $count), 2), $child_details->course_level);
                            ?>
                    <tr>
                        <td style="padding-top: 20px;">
                            <p
                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                <?= $facetoface ?></p>

                        </td>
                    </tr>               
            </td>
        </tr>

    </table>
    </td>
    </tr>
    </table>
    <table cellspacing="0" cellpadding="0"
           style="width: 100%;background-image: url(<?= base_url(); ?>images/header2.jpg);background-size: auto;background-position: left top;background-repeat:repeat-x;">

        <tr>
            <td style="padding: 40px 50px">    
                <table cellspacing="0" cellpadding="0" style="width: 100%;">

                    <tr>
                        <td>
                            <p
                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">

                            </p>
                            <p
                                style="margin:0px;padding-top:10px;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 18px;text-align: justify;">

                                Written Communication

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 20px;">
                            <table style="width: 70%;" cellspacing="0" cellpadding="0">
                                <thead style="background: #011ca9;width: 100%;">
                                    <tr>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            #</th>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            Score</th>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            Peer Quintile</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_average = 0;
                                    $row_percent = 0;
                                    $singale_arr = array();
                                    if (!empty($written_communication)) {
                                        $count = 0;
                                        foreach ($written_communication->result() as $value) {

                                            $count++;
                                            if ($count % 2 == 0) {
                                                $background_color = "#d8dbea";
                                            } else {
                                                $background_color = "#fdf6b2";
                                            }
                                            $row_percent = ($value->correct_answer_percentage_lesson + $value->correct_answer_percentage_asses) / 2;

                                            $total_average = $total_average + $row_percent;
                                            array_push($singale_arr, $row_percent);
                                            ?>
                                            <tr style="background-color: <?= $background_color; ?>;">
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= $count; ?></td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= $row_percent ?>%</td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    NA
                                                </td>    
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <tr style="background-color: #d8dbea;">
                                        <td
                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                            Total</td>
                                        <td
                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                            <?= $total_average != 'NAN%' ? round($total_average / $count, 2) . '%' : 'NA' ?></td>
                                        <td
                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                            <?= formatTwoLessonAssessmentQuintile($total_average, $child_details->course_level); ?></td>    
                                    </tr>

                                </tbody>
                            </table>
                            <?php
                            $writtenCommunication = getreadalongcontainwrittenCommunication(round(($total_average / $count), 2), $child_details->course_level);
                            ?>
                    <tr>
                        <td style="padding-top: 20px;">
                            <p
                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                <?= $writtenCommunication ?></p>

                        </td>
                    </tr>    
                    <tr>
                        <td>
                        </td>
                    </tr>
            </td>
        </tr>

    </table>
    </td>
    </tr>
    </table>
<?php } ?>
<p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify; text-align: center;">We hope this report helped you gain a proper understanding of your results.</p>

<table cellspacing="0" cellpadding="0" style="width: 100%;">

    <tr>
        <td>    
            <table cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td style="text-align: center;padding-top: 50px;">

                        <img src="<?= base_url(); ?>images/PngItem_1624738.png" width="200px" alt="">

                    </td>
                </tr>

            </table>
        </td>
    </tr>

</table>



</div>

</body>

</html>