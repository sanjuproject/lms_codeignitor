<?php
    $block_b_statement = json_decode($scoring_statements[0]->block_b);
    $block_c_statement = json_decode($scoring_statements[0]->block_c);
    $block_d_statement = json_decode($scoring_statements[0]->block_d);
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

<body style="margin: 0px;">

    <div>

        <table cellspacing="0" cellpadding="0"
            style="width: 100%;background-color: #f9ef7e; height: 1120px;">
            <tr>
                <td style="padding-top: 30px;width: 100%;background-image: url(<?= base_url(); ?>images/header.jpg);background-size: auto;background-position:left top;background-repeat:repeat-x;vertical-align:top;">
                    <table cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td style="margin-bottom: 5px;text-align: center;">
                                <img src="<?= base_url(); ?>images/alsowise-logo-without-name.png" style="width: 150px;" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <img src="<?= base_url(); ?>images/alsowise-logo-text.png" style="width: 200px;" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 10px;padding-top: 5px;text-align: center;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 14px;">
                                Grammar | Vocabulary | Reading
                        </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 10px;text-align: center;"><label for=""
                                    style="font-size: 24px;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;">Student:</label>
                                <label for=""
                                    style="font-size: 24px;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 300;"><?= $student_detail[0]->ss_aw_child_nick_name; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 30px;text-align: center;padding-top: 5px;">
                                <label for=""
                                    style="font-size: 24px;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;">Course:</label>
                                <label for=""
                                    style="font-size: 24px;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 300;">
                                    <?php
                                        if ($course_level == 'E') {
                                            $course_name = "Emerging";
                                        }
                                        elseif ($course_level == 'C') {
                                            $course_name = "Consolidated";
                                        }
                                        else{
                                            $course_name = "Advanced";
                                        }
                                    ?>
                                    ALSOWISE™ <?= $course_name; ?> Sample Program</label>
                            </td>
                        </tr>
                        <tr>
                            <td
                                style="width: 100%;background-color: #011ca9;padding: 10px 0px;color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;letter-spacing:5px;font-size: 20px;text-align: center;">
                                AWsum Performance Report

                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100%;padding: 20px 50px;text-align: left;padding-top: 5px;">
                                <p
                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                Please find below a brief report on your child’s progress in the recently program in which <?= $student_detail[0]->ss_aw_child_gender == 1 ? "his" : "her"; ?> participated. Our goal at Alsowise is to provide you with more than just a numeric score. To that end we also provide feedback on how your child'sperformance compares to other students who have participated and completed the course.</p>
                                <!-- <?php
                                if ($course_level == 'E') {
                                    ?>
                                    <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 20px;">The areas covered by this course include grammar, language and reading proficiency.</p>
                                    <?php
                                }
                                elseif ($course_level == 'C') {
                                    ?>
                                    <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 20px;">The areas covered by this course include grammar, vocabulary, language and reading proficiency.</p>
                                    <?php
                                }
                                else{
                                    ?>
                                    <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 20px;">The areas covered by this course include vocabulary, language and reading proficiency.</p>
                                    <?php
                                }
                                ?> -->
                            
                            <h3 style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 28px;">
                                Definitions</h3>
                            <p
                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;margin: 0px;">
                                <span style="font-weight: 700;">Diagnostic Test:</span> The original evaluation of your child's English proficiency before Being assigned a Sample Program.
                            </p>
                            <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;"><span
                                    style="font-weight: 700;">Lesson Quiz:</span> Questions asked during a lesson to evaluate ongoing comprehension of a topic.</p>
                            <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;"><span
                                    style="font-weight: 700;">Assessment Quiz:</span> A quiz on a specific topic offered at least one day after the lesson has been completed.</p>
                            <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;"><span
                                    style="font-weight: 700;">ReadAlong™:</span> A specially selected piece of fiction or non-fiction, or an original ALSOWISE™ piece of writing meant to develop a student’s reading and comprehension skills.</p>
                            <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px; font-style: italic;">Please note that this course offered topics centred on grammar, general language and reading skills.</p>                
        
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

  


        <table cellspacing="0" cellpadding="0"
            style="width: 100%;">
            <tr>
                <td style="width: 100%;vertical-align:top;padding: 20px 50px;">
                    <table cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td
                                style="vertical-align:top;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 24px;margin: 0px;padding-bottom: 10px;">
                                Grammar and Vocabulary Proficiency </br>
                                <p
                                    style="font-weight: 400;font-size: 18px;text-align: justify;margin:0px;padding-top: 5px;">
                                    Your child completed the following topics during this course:</p>
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
                                                Assessment Quiz Performance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($result)) {
                                            $count = 0;
                                            foreach ($result as $key => $value) {
                                                $count++;
                                                if ($count % 2 == 0) {
                                                    $background_color = "#d8dbea";
                                                }
                                                else
                                                {
                                                    $background_color = "#fdf6b2";
                                                }
                                                
                                                ?>
                                                <tr style="background-color: <?= $background_color; ?>;">
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= $count; ?></td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= $value->ss_aw_lesson_topic; ?></td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= $value->ss_aw_lesson_quiz_correct_percentage > 0 ? round($value->ss_aw_lesson_quiz_correct_percentage)."%" : "Not Completed"; ?></td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= $value->ss_aw_combine_correct > 0 ? round($value->ss_aw_combine_correct)."%" : "Not Completed"; ?></td>

                                                </tr>
                                                <?php

                                            }
                                        }
                                        ?>
                                        

                                        <tr style="background-color: #fff;">
                                            <td colspan="3"
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:2px solid #011ca9;border-right: none;">
                                                TOTAL</td>
                                            <td
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:2px solid #011ca9;border-left: none;">
                                                <?= round($total_score[0]->ss_aw_combine_correct); ?>%</td>

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
        style="width: 100%;">

        <tr>
            <td style="padding: 40px 50px">

                <table cellspacing="0" cellpadding="0" style="width: 100%;">

                    <tr>
                        <td>
                            <table style="width: 70%;" cellspacing="0" cellpadding="0">
                                <thead style="background: #011ca9;width: 100%;">
                                    <tr>
                                    <th colspan="2"
                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                        Diagnostic Test</th>
                                    <th colspan="2"
                                        style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                        Overall Program Assessment</th>
                                    </tr>
                                </thead>
                                <tbody>
        
                                    <tr style="background-color: #fdf6b2;">
                                        <td colspan="2"
                                            style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                            % Correct</td>
                                        <td colspan="2"
                                            style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                            % Correct</td>
        
                                    </tr>
                                    <tr style="background-color: #d8dbea;">
                                        <td colspan="2"
                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                            <?= round($diagnostic_assessment[0]->ss_aw_diagnostic_correct_percentage); ?></td>
                                        <td colspan="2"
                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                            <?= round($diagnostic_assessment[0]->ss_aw_review_percentage); ?></td>
        
                                    </tr>
        
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 30px;">
                            <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">Your Child has Completed <?= count($result); ?> lessons and <?= count($result); ?> Assessment Quizzes compared to the peer group average of <?= $group_average_lesson; ?> Lessons and <?= $group_average_assessment; ?> Assessment Quizzes.</p>
                            <?php
                            $block_b_x = 0;
                            $a_statement = "";
                            $b_statement = "";
                            $a1_statement = "";
                            $b1_statement = "";
                            if (!empty($diagnostic_assessment) && ($diagnostic_assessment[0]->ss_aw_diagnostic_correct != 0)) {
                                $block_b_x = $diagnostic_assessment[0]->ss_aw_review_correct / $diagnostic_assessment[0]->ss_aw_diagnostic_correct;
                                $block_b_x = $block_b_x - 1;
                                if ($diagnostic_assessment[0]->ss_aw_diagnostic_correct_percentage > 50) {
                                    if ($block_b_x < -.1) {
                                        $a_statement = $block_b_statement->A->greater->first;
                                    }
                                    elseif ($block_b_x >= -.1 && $block_b_x < .1) {
                                        $a_statement = $block_b_statement->A->greater->second;
                                    }
                                    elseif ($block_b_x >= .1 && $block_b_x < .2) {
                                        $a_statement = $block_b_statement->A->greater->third;
                                    }
                                    elseif ($block_b_x >= .2) {
                                        $a_statement = $block_b_statement->A->greater->fourth;
                                    }
                                }
                                else
                                {
                                    if ($block_b_x < 0) {
                                        $a_statement = $block_b_statement->A->lesser->first;
                                    }
                                    elseif ($block_b_x >= 0 && $block_b_x < .1) {
                                        $a_statement = $block_b_statement->A->lesser->first;
                                    }
                                    elseif ($block_b_x >= .1 && $block_b_x < .3) {
                                        $a_statement = $block_b_statement->A->lesser->first;
                                    }
                                    elseif ($block_b_x >= .3) {
                                        $a_statement = $block_b_statement->A->lesser->first;
                                    }
                                }

                                $assessemnt_quintile = assessmentQuantile($diagnostic_assessment[0]->ss_aw_review_percentage, $diagnostic_assessment[0]->ss_aw_level);
                                if ($assessemnt_quintile == 1) {
                                    $b_statement = $block_b_statement->B->first;
                                }
                                elseif ($assessemnt_quintile == 2) {
                                    $b_statement = $block_b_statement->B->second;
                                }
                                elseif ($assessemnt_quintile == 3) {
                                    $b_statement = $block_b_statement->B->third;
                                }
                                elseif ($assessemnt_quintile == 4) {
                                    $b_statement = $block_b_statement->B->fourth;
                                }
                                elseif ($assessemnt_quintile == 5) {
                                    $b_statement = $block_b_statement->B->fifth;
                                }

                                // get A1 and B1
                                if ($diagnostic_assessment[0]->ss_aw_diagnostic_correct_percentage > 50) {
                                    if ($block_b_x < -.1) {
                                        $a1_statement = $block_b_statement->A1->greater->first;
                                    }
                                    elseif ($block_b_x >= -.1 && $block_b_x < .1) {
                                        $a1_statement = $block_b_statement->A1->greater->second;
                                    }
                                    elseif ($block_b_x >= .1 && $block_b_x < .2) {
                                        $a1_statement = $block_b_statement->A1->greater->third;
                                    }
                                    elseif ($block_b_x >= .2) {
                                        $a1_statement = $block_b_statement->A1->greater->fourth;
                                    }
                                }
                                else
                                {
                                    if ($block_b_x < 0) {
                                        $a1_statement = $block_b_statement->A1->lesser->first;
                                    }
                                    elseif ($block_b_x >= 0 && $block_b_x < .1) {
                                        $a1_statement = $block_b_statement->A1->lesser->first;
                                    }
                                    elseif ($block_b_x >= .1 && $block_b_x < .3) {
                                        $a1_statement = $block_b_statement->A1->lesser->first;
                                    }
                                    elseif ($block_b_x >= .3) {
                                        $a1_statement = $block_b_statement->A1->lesser->first;
                                    }
                                }

                                if ($assessemnt_quintile == 1) {
                                    $b1_statement = $block_b_statement->B1->first;
                                }
                                elseif ($assessemnt_quintile == 2) {
                                    $b1_statement = $block_b_statement->B1->second;
                                }
                                elseif ($assessemnt_quintile == 3) {
                                    $b1_statement = $block_b_statement->B1->third;
                                }
                                elseif ($assessemnt_quintile == 4) {
                                    $b1_statement = $block_b_statement->B1->fourth;
                                }
                                elseif ($assessemnt_quintile == 5) {
                                    $b1_statement = $block_b_statement->B1->fifth;
                                }

                                $diagnostic_quintile = diagnosticQuantile($diagnostic_assessment[0]->ss_aw_diagnostic_correct_percentage, $diagnostic_assessment[0]->ss_aw_level);
                                if ($assessemnt_quintile > $diagnostic_quintile) {
                                    $c_statement = $block_b_statement->C->third;
                                }
                                elseif ($assessemnt_quintile < $diagnostic_quintile) {
                                    $c_statement = $block_b_statement->C->third;
                                }
                                else
                                {
                                    $c_statement = $block_b_statement->C->third;
                                }

                                $confidence_detail = json_decode($confidence_index_detail);
                                if (!empty($confidence_detail->point)) {
                                    $confidence_index = $confidence_detail->point;
                                }
                                else
                                {
                                    $confidence_index = 0;
                                }

                                if ($confidence_index == 1) {
                                    //$c1_statement = $block_b_statement->C1->first;
                                    if ($student_detail[0]->ss_aw_child_gender == 1) {
                                        $gender = "his";
                                    }
                                    else{
                                        $gender = "her";
                                    }
                                    $c1_statement = "significantly more hesitant to answer grammar proficiency questions than other students in ".$gender." peer group. This is also the case OR This is not the case with General Language AND/ OR Vocabulary questions.";
                                }
                                elseif ($confidence_index == 2) {
                                    $c1_statement = $block_b_statement->C1->second;
                                }
                                elseif ($confidence_index == 3) {
                                    $c1_statement = $block_b_statement->C1->third;
                                }
                                elseif ($confidence_index == 4) {
                                    $c1_statement = $block_b_statement->C1->fourth;
                                }
                                elseif ($confidence_index == 5) {
                                    $c1_statement = $block_b_statement->C1->fifth;
                                }
                            }
                            ?>

                            <?php
                            if (($course_level == 'E' || $course_level == 'C') && $a_statement != "" && $b_statement != "") {
                                ?>
                                <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                            Your child <span style="font-weight: 500;"><?= $a_statement; ?> understanding of grammar and is currently performing <?= $b_statement; ?>.</span></p>
                                <?php
                            }

                            if (($course_level == 'C' || $course_level == 'A') && $a1_statement != "" && $b1_statement != "") {
                                ?>
                                <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                            Your child <span style="font-weight: 500;"><?= $a1_statement; ?> understanding of vocabulary and is currently performing <?= $b1_statement; ?>.</span></p>
                                
                                <?php
                            }

                            if (!empty($c_statement)) {
                                ?>
                                <!-- <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">This is <?= $c_statement; ?> when compared to their diagnostic test quintile.</p> -->
                                <?php
                            }

                            if (!empty($c1_statement)) {
                                ?>
                                <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">Furthermore, your child is <?= $c1_statement; ?>.</p>    
                                <?php
                            }

                            $grammer_quintile = combineTotalQuintile($total_score[0]->ss_aw_combine_correct, $total_score[0]->ss_aw_course_level);
                            $grammar_confidence_detail = json_decode($confidence_index_detail);
                            if (!empty($confidence_detail->point)) {
                                $grammar_confidence_index = $confidence_detail->point;
                            }
                            else
                            {
                                $grammar_confidence_index = "";
                            }
                            if (($grammer_quintile > 0 && $grammer_quintile <= 2) && ($grammar_confidence_index > 0 && $grammar_confidence_index <= 2)) {
                                ?>
                                <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">Your child shows no hesitancy when answering quiz questions. Your child might improve <?= $student_detail[0]->ss_aw_child_gender == 1 ? "his" : "her"; ?> performance if he/ she takes a little more time to pondereach question before attempting an answer.</p>
                                <?php
                            }
                            ?>

                            <br><br><br><br>
<br><br> <br><br>       </td>

                    </tr>

                </table>

            </td>
        </tr>


        </table>
        <?php
        if (!empty($formattwo_lesson_assessment)) {
            ?>
            <table cellspacing="0" cellpadding="0"
            style="width: 100%;">

            <tr>
                <td style="padding: 40px 50px">
                    <table cellspacing="0" cellpadding="0" style="width: 100%;">

                        <tr>
                            <td>
                                <!-- <p
                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                Reading comprehension</p> -->
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
                                            #Lesson / Assessment</th>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            Quiz Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($formattwo_lesson_assessment)) {
                                        $count = 0;
                                        foreach ($formattwo_lesson_assessment as $key => $value) {
                                            $count++;
                                            if ($count % 2 == 0) {
                                                $background_color = "#d8dbea";
                                            }
                                            else
                                            {
                                                $background_color = "#fdf6b2";
                                            }
                                            ?>
                                            <tr style="background-color: <?= $background_color; ?>;">
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= $value->ss_aw_topic; ?></td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= round($value->ss_aw_correct_percentage); ?>%</td>
                                            </tr>
                                            <?php
                                        }
                                    }

                                    if (!empty($formattwo_lesson_assessment_total)) {
                                        ?>
                                        <tr style="background-color: #d8dbea;">
                                            <td
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                Total</td>
                                            <td
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                <?= round($formattwo_lesson_assessment_total[0]->ss_aw_correct_percentage); ?>%</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
            
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>
                            <?php
                                $d_statement = "";
                                $english_language_quintile = combineTotalQuintile($total_score[0]->ss_aw_combine_correct, $total_score[0]->ss_aw_course_level);

                                if ($english_language_quintile == 1) {
                                    $d_statement = $block_c_statement->D->first;
                                }
                                elseif ($english_language_quintile == 2) {
                                    $d_statement = $block_c_statement->D->second;
                                }
                                elseif ($english_language_quintile == 3) {
                                    $d_statement = $block_c_statement->D->third;
                                }
                                elseif ($english_language_quintile == 4) {
                                    $d_statement = $block_c_statement->D->fourth;
                                }
                                elseif ($english_language_quintile == 5) {
                                    $d_statement = $block_c_statement->D->fifth;
                                }

                                $d1_statement = "";
                                if (!empty($language_confidence) && !empty($language_confidence[0]->ss_aw_combine_score)) {
                                    $english_language_confidence_quintile = lessonConfidenceScoreQuantile($language_confidence[0]->ss_aw_combine_score, $language_confidence[0]->ss_aw_level);
                                    if ($english_language_confidence_quintile == 1) {
                                        $d1_statement = $block_c_statement->D1->first;
                                    }
                                    elseif ($english_language_confidence_quintile == 2) {
                                        $d1_statement = $block_c_statement->D1->second;
                                    }
                                    elseif ($english_language_confidence_quintile == 3) {
                                        $d1_statement = $block_c_statement->D1->third;
                                    }
                                    elseif ($english_language_confidence_quintile == 4) {
                                        $d1_statement = $block_c_statement->D1->fourth;
                                    }
                                    elseif ($english_language_confidence_quintile == 5) {
                                        $d1_statement = $block_c_statement->D1->fifth;
                                    }
                                }

                                if (!empty($d_statement)) {
                                    ?>
                                    <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">Your child is performing <?= $d_statement; ?> when it comes to overall command of English language.</p>
                                    <?php
                                }

                                if (!empty($d1_statement)) {
                                    ?>
                                    <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">In addition your child is <?= $d_statement; ?></p>
                                    <?php
                                }
                                
                            ?>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>

            </table>
            <?php
        }
        ?>

        <?php
        if (!empty($readalong_score)) {
            ?>
            <table cellspacing="0" cellpadding="0"
            style="width: 100%;">

            <tr>
                <td style="padding: 40px 50px">
                    <table cellspacing="0" cellpadding="0" style="width: 100%;">

                        <tr>
                            <td>
                                <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">Finally, we have analysed your child’s reading abilities through both reading comprehension exercises and ReadAlong™ texts.</p>

                                <p style="margin:0px;padding-top:10px;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 18px;text-align: justify;">
                                Reading comprehension</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 20px;">
                                <table style="width: 70%;" cellspacing="0" cellpadding="0">
                                    <thead style="background: #011ca9;width: 100%;">
                                        <tr>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            #ReadAlong™ Name</th>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            Quiz Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($readalong_score)) {
                                        $count = 0;
                                        foreach ($readalong_score as $key => $value) {
                                            $count++;
                                            if ($count % 2 == 0) {
                                                $background_color = "#d8dbea";
                                            }
                                            else
                                            {
                                                $background_color = "#fdf6b2";
                                            }
                                            ?>
                                            <tr style="background-color: <?= $background_color; ?>;">
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= $value->ss_aw_title; ?></td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    <?= round($value->ss_aw_correct_percentage); ?>%</td>
                                            </tr>
                                            <?php
                                        }
                                    }

                                    if (!empty($readalong_total_score)) {
                                        ?>
                                        <tr style="background-color: #d8dbea;">
                                            <td
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                Total</td>
                                            <td
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                <?= round($readalong_total_score[0]->ss_aw_correct_percentage); ?>%</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
            
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <?php
                            $f_statement = "";
                            if (!empty($formattwo_lesson_assessment) && count($formattwo_lesson_assessment) >= 3) {
                                if (!empty($formattwo_lesson_assessment[2]->ss_aw_correct_percentage)) {
                                    $first_per = $formattwo_lesson_assessment[2]->ss_aw_correct_percentage;
                                }
                                else
                                {
                                    $first_per = 0;
                                }

                                if (!empty($formattwo_lesson_assessment[count($formattwo_lesson_assessment) - 2]->ss_aw_correct_percentage)) {
                                    $third_per = $formattwo_lesson_assessment[count($formattwo_lesson_assessment) - 2]->ss_aw_correct_percentage;
                                }
                                else
                                {
                                    $third_per = 0;
                                }

                                $block_d_x = $third_per - $first_per;
                                if ($block_d_x <= -.2) {
                                    $f_statement = $block_d_statement->F->first;
                                }
                                elseif ($block_d_x > -.2 && $block_d_x <= -.1) {
                                    $f_statement = $block_d_statement->F->second;
                                }
                                elseif ($block_d_x > -.1 && $block_d_x <= .1) {
                                    $f_statement = $block_d_statement->F->third;
                                }
                                elseif ($block_d_x > .1 && $block_d_x <= .2) {
                                    $f_statement = $block_d_statement->F->fourth;
                                }
                                elseif ($block_d_x > .2) {
                                    $f_statement = $block_d_statement->F->fifth;
                                }
                            }
                            ?>
                            <td>
                                <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">Your child completed <?= count($readalong_score); ?> ReadAlong™ texts compared to <?= $student_detail[0]->ss_aw_child_gender == 1 ? "his" : "her"; ?> peer group average of <?= $group_average_readalong; ?> ReadAlong™ texts.</p>

                                <?php
                                if (!empty($f_statement)) {
                                    ?>
                                    <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">Overtime your child's comprehension <?= $f_statement; ?>.</p>
                                    <?php
                                }
                                ?>
                                <!-- <p
                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">
                                Your child's reading comprehension performance was <span style="font-weight: 500;">somewhat
                                    below/ somewhat above/ at - the peer median.</span> Over time, your child’s ability to
                                comprehend a passage and retain salient parts of it has - somewhat diminished/ somewhat
                                improved/ remained constant. Compared to other students, your child is - <span
                                    style="font-weight: 500;">significantly more hesitant to answer reading comprehension
                                    questions/ significantly less hesitant to answer reading comprehension questions/ no more or
                                    less hesitant to answer reading comprehension questions.</span></p> -->
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: center;padding-top: 50px;">
                            
                                    <img src="<?= base_url(); ?>images/PngItem_1624738.png" width="200px" alt="">
                              
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>

            </table>
            <?php
        }
        ?>

    </div>

</body>

</html>