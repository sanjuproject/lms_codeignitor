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
                                Please find below a brief report on your child’s progress in the recently concluded program in which he participated. Our goal at Alsowise is to provide you with more than just a numeric score. To that end we also provide feedback on how your child's performance compares to other students who have participated in and completed the same program.</p>
                            
                            <h3 style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 28px;">
                                Definitions</h3>
                            <p
                                style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;margin: 0px;">
                                <span style="font-weight: 700;">Diagnostic Test:</span> The original evaluation of your child's English proficiency before being assigned a Sample Program.

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
                                    Your child’s performance in the modules offered during the program is shown below:</p>
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
                                        <tr style="background-color: #fdf6b2;">
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    1</td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    Prepositions</td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    54%</td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    63%</td>

                                        </tr>

                                        <tr style="background-color: #d8dbea;">
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    2</td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    Verbs 1</td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    43%</td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    54%</td>

                                        </tr>

                                        <tr style="background-color: #fdf6b2;">
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    3</td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    Synonyms and Antonyms</td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    Not Completed</td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    Not Completed</td>

                                        </tr>

                                        <tr style="background-color: #fff;">
                                            <td colspan="2"
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:2px solid #011ca9;border-right: none;">
                                                TOTAL</td>
                                            <td
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:2px solid #011ca9;border-left: none;border-right: none;">
                                                49%</td>    
                                            <td
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:2px solid #011ca9;border-left: none;">
                                                <?= $total_score[0]->ss_aw_combine_correct > 0 ? round($total_score[0]->ss_aw_combine_correct)."%" : "NA"; ?></td>

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
                                            <?= $diagnostic_assessment[0]->ss_aw_diagnostic_correct_percentage > 0 ? round($diagnostic_assessment[0]->ss_aw_diagnostic_correct_percentage) : "NA"; ?></td>
                                        <td colspan="2"
                                            style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                            <?= $diagnostic_assessment[0]->ss_aw_review_percentage > 0 ? round($diagnostic_assessment[0]->ss_aw_review_percentage) : "NA"; ?></td>
        
                                    </tr>
        
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 30px;">
                            <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">Compared to his Diagnostic Test score, Vivek has performed moderately better through the course of the program.</p>
                            <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">Your Child has Completed 2 lessons and 2 Assessment Quizzes compared to the peer group average of <?= $group_average_lesson; ?> <?= $group_average_lesson > 1 ? "Lessons" : "Lesson"; ?> and <?= $group_average_assessment; ?> Assessment <?= $group_average_assessment > 1 ? "Quizzes" : "Quiz"; ?>.</p>
                            <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">Furthermore, your child is neither less hesitant, nor more hesitant, to answer questions than other students in her peer group. </p>

                       </td>

                    </tr>

                    <!-- <tr>
                        <td style="text-align: center;padding-top: 50px;">
                            
                            <img src="<?= base_url(); ?>images/PngItem_1624738.png" width="200px" alt="">
                              
                        </td>
                    </tr> -->

                </table>

            </td>
        </tr>


        </table>

        <!-- <table cellspacing="0" cellpadding="0"
            style="width: 100%;">

            <tr>
                <td style="padding: 40px 50px">
                    <table cellspacing="0" cellpadding="0" style="width: 100%;">

                        <tr>
                            <td>
                            <p
                                style="margin:0px;padding-top:10px;color: #797106;font-family: 'Roboto', sans-serif;font-weight: 500;font-size: 18px;text-align: justify;">
                                General Language Assessment</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 20px;">
                                <table style="width: 70%;" cellspacing="0" cellpadding="0">
                                    <thead style="background: #011ca9;width: 100%;">
                                        <tr>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            #Lesson / Assessment Quiz</th>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            % Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="background-color: #fdf6b2;">
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    General Revision</td>
                                                <td
                                                    style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">
                                                    70</td>
                                            </tr>
                                            <tr style="background-color: #d8dbea;">
                                                <td
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                Total</td>
                                                <td
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                70</td>
                                            </tr>
            
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>
                            <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">Your child has performed above her peer group.</p>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>

        </table> -->

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
                                            #ReadAlong™ / Reading Comprehension</th>
                                        <th
                                            style="color: #fff;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 15px;border:1px solid #fdf6b2;">
                                            Quiz Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="background-color: #fdf6b2; ?>;">
                                            <td style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">Genghis Khan</td>
                                            <td style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">83%</td>
                                        </tr>
                                        <tr style="background-color: #fdf6b2; ?>;">
                                            <td style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">Dracula</td>
                                            <td style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;">20%</td>
                                        </tr>
                                        <tr style="background-color: #d8dbea;">
                                            <td
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                Total</td>
                                            <td
                                                style="color: #011ca9;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 16px;padding: 10px;text-align: center;border:1px solid #fdf6b2;">
                                                54%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <p style="color: #797106;font-family: 'Roboto', sans-serif;font-weight: 400;font-size: 18px;text-align: justify;">Your child completed 2 ReadAlong™ / Reading Comprehension quiz compared to his peer group average of <?= $group_average_readalong; ?> <?= $group_average_readalong > 1 ? "quizzes" : "quiz"; ?>.</p>
                                
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