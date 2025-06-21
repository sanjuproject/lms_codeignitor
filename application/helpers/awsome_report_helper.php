<?php

defined('BASEPATH') or exit('No direct script access allowed');

function gettheruleAcontain($final_average, $child_details)
{
    $you = $child_details->ss_aw_child_first_name != 'M' ? "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b>" : "You";
    $r = $child_details->course_level == 'M' ? 'r' : "<b>'s</b>";
    $his = $child_details->ss_aw_child_gender == 1 ? 'his' : ($child_details->ss_aw_child_gender == 2 ? 'her' : 'his/her');
    $he_she = $child_details->ss_aw_child_gender == 1 ? 'he' : ($child_details->ss_aw_child_gender == 2 ? 'she' : 'he/she');
    $check_third = $child_details->course_level != 'M' ? $he_she : $you;
    $was = $child_details->course_level == 'E' ? 'was' : 'were';

    switch (true) {
        case ($final_average > 60):
            $A = " $check_third faced little difficulty in comprehending the passage. Being able to answer"
                . " questions through aided recall constitutes the first step in becoming a skilled reader – one"
                . " of the life skills that is critical for future success";
            break;
        case (31 > $final_average):
            $A = " $check_third faced considerable difficulty in comprehending the passage. In future, $check_third should attempt to read "
                . "a passage multiple times before attempting to answer questions related to it. Being able to answer questions "
                . "through aided recall constitutes the first step in becoming a skilled reader – one of the life skills that is "
                . "critical for future success.";
            break;
        default:
            $A = " faced some difficulty in comprehending the passage. In future, $check_third should attempt to read a passage "
                . "multiple times before attempting to answer questions related to it. Being able to answer questions"
                . " through aided recall constitutes the first step in becoming a skilled reader – one of the life"
                . " skills that is critical for future success.";
            break;
    }


    $cont = "$you $was able to identify the correct answer <b>$final_average%</b> of the time and thus $A";
    return $cont;
}

function gettheruleCcontain($child_details)
{
    $you = $child_details->ss_aw_child_first_name != 'M' ? "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b>" : "You";
    $r = $child_details->course_level == 'M' ? 'r' : "<b>'s</b>";

    $cont = "The primary purpose of these reading comprehension tests is to assess $you$r reading skills and ability to answer "
        . "correctly based on the information provided."
        . " These reading comprehension tests thus work on 'aided recall' that allows $you to refer to the passage "
        . "while answering the questions.";

    return $cont;
}

function getreadalongcontainC($child_details)
{
    $you = $child_details->course_level != 'M' ? "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b>" : "You";
    $r = $child_details->course_level == 'M' ? 'r' : "<b>'s</b>";
    $his = $child_details->ss_aw_child_gender == 1 ? 'his' : ($child_details->ss_aw_child_gender == 2 ? 'her' : 'his/her');
    $check_third = $child_details->course_level != 'M' ? $his : $you;
    $was = $child_details->course_level == 'E' ? 'was' : 'were';
    $let = lcfirst($you);
    $cont = "The primary purpose of the ReadAlongs section is to test <b>$let$r</b>  reading skills in the event of 'unaided recall',"
        . " wherein <b>$let</b> cannot refer to the passage and must learn  to automatically retain as much information as possible"
        . " in the process of reading an essay or excerpt.";
    return $cont;
}

function getreadalongcontainD($singale_arr, $final_average, $child_details)
{

    $total_count = count($singale_arr);
    $you = $child_details->course_level != 'M' ? "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b>" : "you";
    $fyou = $child_details->course_level != 'M' ? "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b>" : "You";
    $r = $child_details->course_level == 'M' ? 'r' : "<b>'s</b>";
    $fr = $child_details->course_level == 'M' ? 'r' : "";
    $his = $child_details->ss_aw_child_gender == 1 ? 'his' : ($child_details->ss_aw_child_gender == 2 ? 'her' : 'his/her');
    $check_third = $child_details->course_level != 'M' ? $his : $you;
    $onlyr = $child_details->course_level != 'M' ? '' : 'r';
    $he_she = $child_details->ss_aw_child_gender == 1 ? 'he' : ($child_details->ss_aw_child_gender == 2 ? 'she' : 'he/she');
    $fhe_she = $child_details->ss_aw_child_gender == 1 ? 'He' : ($child_details->ss_aw_child_gender == 2 ? 'She' : 'He/She');
    $prop = $child_details->course_level != 'M' ? $fhe_she : $fyou;
    $pular = $child_details->course_level != 'M' ? 's' : '';
    $let = lcfirst($check_third);
    $str = "";
    if ($total_count > 5) {
        //rsort($singale_arr);
        $sum_x = 0;
        $sum_y = 0;
        for ($cnt = 0; $cnt < 5; $cnt++) {
            $sum_x = $sum_x + $singale_arr[$cnt];
            $sum_y = $sum_y + $singale_arr[($total_count - $cnt) - 1];
        }

        $i = ($sum_y / 5) - ($sum_x / 5);

        switch (true) {
            case $i < .1:
                if ($final_average < 70) {
                    $sug = "no improvement";
                } else {
                    $sug = "consistent performance";
                }
                break;
            case $i >= .2:
                $sug = "significant improvement";
                break;
            default:
                $sug = "moderate improvement";
                break;
        }

        $str = "$fyou$r unaided recall has shown $sug over the course of the programme.";
    } else {
        $str = "Because $you completed less than 6 of the 26 ReadAlongs which were available to you, we are unable to assess $let$fr unaided recall improvement over time.";
    }
    $res = " $str Going forward, "
        . $prop . " need$pular to make reading a part of daily/weekly routine and should focus on reading "
        . "longer articles"
        . " and books in order to build attention span, knowledge retention and unaided recall. This is a critical skill"
        . " that affects many competencies including self-learning, decision making and knowledge transformation.";

    return $res;
}

function getreadalongcontainFacetoFace($final_average, $course_level)
{

    $percen = !is_nan($final_average) ? ($final_average . '%') : $percen = 'NA%';

    switch (true) {
        case ($final_average > 60):
            $C = " little to no difficulty with verbal communication.";
            break;
        case (31 > $final_average || is_nan($final_average)):
            $C = " have considerable difficulty with verbal communication. We strongly recommend that you redo the 2 Lessons and 2 Assessment Quizzes.";
            break;
        default:
            $C = " have some difficulty with verbal communication. We strongly recommend that you redo the Lessons and Assessment Quizzes.";
            break;
    }

    $cont = "The primary purpose of the Face-To-Face Communication Modules is to test your skills"
        . " in speaking directly with a customer, manager, or colleague. "
        //            . "<br/>"
        . "You were able to identify the correct answer <b>$percen</b> of the time and thus $C";

    return $cont;
}

function getreadalongcontainwrittenCommunication($final_average, $course_level)
{

    $percen = !is_nan($final_average) ? ($final_average . '%') : $percen = 'NA%';

    switch (true) {
        case ($final_average > 60):
            $C = " little to no difficulty with written communication.";
            break;
        case (30 > $final_average || is_nan($final_average)):
            $C = "  have considerable difficulty with written communication. We strongly recommend that you redo the 3 Lessons and 3 Assessment Quizzes.";
            break;
        default:
            $C = " have some difficulty with written communication. You may benefit from revisiting the Lessons and Assessment Quizzes again.";
            break;
    }

    $cont = "The primary purpose of the Written Communication Modules is to test your skills in "
        . "communicating effectively in a non-verbal environment, especially when preparing documents, emails and office memos."
        //            . "<br/>"
        . " You were able to identify the correct response <b>$percen</b> of the time and thus $C";

    return $cont;
}

function getConfidenceData($child_id, $child_details, $proficency_score, $proficency_count)
{
    $ci = get_instance();
    //   echo $proficency_score." COUNT ".$proficency_count;exit;
    $confidence_score = 0;
    switch (true) {
        case ($proficency_score >= 65):
            $confidence_score = 3;
            break;
        case ($proficency_score < 35):
            $confidence_score = 1;
            break;

        default:
            $confidence_score = 2;
            break;
    }



    //    First logic for confidence//
    //    $ci->load->model('ss_aw_child_assessment_pdf');
    //    if ($child_details->course_level == "E") {//for vocabulary topic count
    //        $start = 12;
    //        $end = 15;
    //    }
    //    if ($child_details->course_level == "A") {
    //        $start = 16;
    //        $end = 25;
    //    }
    //    if ($child_details->course_level == "M") {
    //        $start = 12;
    //        $end = 25;
    //    }
    //
    //
    //
    //
    //
    //    //get all the lesson,assesment,reviews skipped,backups & seconds.
    $conf = $ci->ss_aw_child_assessment_pdf->getConfidenceData($child_id);

    //    //vocabulary data
    //    $conf_voca = $ci->ss_aw_child_assessment_pdf->getConfidenceVocabulary($child_id, $start, $end);

    $lesson_quiz_total = 0;
    $assesment_total = 0;
    $arr_count = count($conf->result());

    //Calculation for no of topic for 1st 3rd,2nd 3rd & last 3rd
    $z = $arr_count - ((int) ($arr_count / 3) * 3);
    if ($z == 0) {
        $first_count = 3;
        $second_count = 3;
        $third_count = 3;
    } elseif ($z == 1) {
        $first_count = 3;
        $second_count = 4;
        $third_count = 3;
    } else {
        $first_count = 3;
        $second_count = 4;
        $third_count = 4;
    }
    $first_total_combind = 0;
    $second_total_combind = 0;
    $third_total_combind = 0;
    $first_total_avgsecond = 0;
    $second_total_avgsecond = 0;
    $third_total_avgsecond = 0;
    //
    $count = 0;
    foreach ($conf->result() as $con) {
        $lesson_quiz_total += $con->lesson_backups / 3;
        $assesment_total = $con->assesment_skipped + $con->review_skipped;
        if ($count < $first_count) {
            $first_total_combind += $con->lesson_backups / 3 + $con->assesment_skipped + $con->review_skipped;
        }
        if ($count >= $first_count && $count < $second_count) {
            $second_total_combind += $con->lesson_backups / 3 + $con->assesment_skipped + $con->review_skipped;
        }
        if ($count >= $second_count && $count < $third_count) {
            $third_total_combind += $con->lesson_backups / 3 + $con->assesment_skipped + $con->review_skipped;
        }

        $count++;
    }
    //    //Combibe score
    $combine_score = $lesson_quiz_total + $assesment_total;
    $adjustment_value = $combine_score / $proficency_count;

    switch (true) {
        case ($adjustment_value >= 1.5):
            $adjustment_num = 2;
            break;
        case ($adjustment_value < 0.5):
            $adjustment_num = 0;
            break;

        default:
            $adjustment_num = 1;
            break;
    }
    $final_conf_score = $confidence_score - $adjustment_num;

    $name = $child_details->course_level == 'M' ? 'You' : "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> ";
    if ($child_details->course_level == 'M') {
        $do_supplymentary = "You should attempt supplementary courses to develop more confidence with the language.";
        switch (true) {
            case ($final_conf_score <= 1):
                $verbiage = "$name are not confident when answering grammar questions. $do_supplymentary";
                break;
            case ($final_conf_score > 1 && $final_conf_score <= 2):
                $verbiage = "$name have some hesitancy when answering grammar questions. $do_supplymentary";
                break;

            default:
                $verbiage = "$name feel confident with grammar. $do_supplymentary";
                break;
        }
    } else {
        $gender_pronoun1 = $child_details->ss_aw_child_gender == 1 ? "He" : "She";
        $gender_pronoun2 = $child_details->ss_aw_child_gender == 1 ? "his" : "her";
        $do_supplymentary = "$gender_pronoun1 should attempt supplementary courses to develop $gender_pronoun2 confidence with the language.";
        switch (true) {
            case ($final_conf_score <= 1):
                $verbiage = "$name is not confident when answering grammar questions. $do_supplymentary";
                break;
            case ($final_conf_score > 1 && $final_conf_score <= 2):
                $verbiage = "$name has some hesitancy when answering grammar questions. $do_supplymentary";
                break;

            default:
                $verbiage = "$name feels confident with grammar. $do_supplymentary";
                break;
        }
    }


    //    //Condition string check for Master & Winners.
    //    $string = '';
    //    switch (true) {
    //        case $child_details->course_level == 'M':
    //
    //            switch (true) {
    //                case $combine_score <= 10:
    //                    $string = 'You feel';
    //                    $comb_string = "$string confident with grammar.";
    //                    break;
    //                case $combine_score >= 11 && $combine_score <= 20:
    //                    $string = 'You have';
    //                    $comb_string = "$string some hesitancy when answering grammar questions.";
    //                    break;
    //                case $combine_score > 20:
    //                    $string = 'You are';
    //                    $comb_string = "$string not confident when answering grammar questions.";
    //                    break;
    //                default:
    //                    $comb_string = '';
    //                    break;
    //            }
    //
    //            break;
    //        case $child_details->course_level == 'E':
    //            switch (true) {
    //                case $combine_score <= 10:
    //                    $string = 'feels';
    //                    $comb_string = "$string confident with grammar.";
    //                    break;
    //                case $combine_score >= 11 && $combine_score <= 20:
    //                    $string = 'has';
    //                    $comb_string = "$string some hesitancy when answering grammar questions .";
    //                    break;
    //                case $combine_score > 20:
    //                    $string = 'is';
    //                    $comb_string = "$string not confident when answering grammar questions.";
    //                    break;
    //                default:
    //                    $comb_string = '';
    //                    break;
    //            }
    //
    //            break;
    //
    //        default:
    //            $comb_string = '';
    //            break;
    //    }
    //
    //    //Get data for 1st 3rd, 2nd 3rd(4th) & last 3rd(4th)
    //    $first_total_avglesson = $first_total_combind / $first_count;
    //    $second_total_avglesson = $second_total_combind / $second_count;
    //    $third_total_avglesson = $third_total_combind / $third_count;
    //    $his_con = $child_details->ss_aw_child_gender == 1 ? "His" : "Her";
    //    $he_con = $child_details->ss_aw_child_gender == 1 ? "He" : "She";
    //    $y = $third_total_avglesson - $first_total_avglesson;
    //    if ($y < number_format(-.5)) {
    //        $stringy = $child_details->course_level == 'M' ? 'You are' : $he_con . ' has';
    //        $y_string = "$stringy become more hesitant over duration of grammar course.";
    //    } elseif ($y >= number_format(-.5) && $y <= number_format(.5)) {
    //        $stringy = $child_details->course_level == 'M' ? 'Your' : $his_con;
    //        $y_string = "$stringy confidence in answering questions has remained consistent during grammar course.";
    //    } elseif ($y > number_format(.5) && $y <= number_format(1.5)) {
    //        $stringy = $child_details->course_level == 'M' ? 'You have' : $he_con . ' has';
    //        $y_string = "$stringy improved confidence when answering grammar questions.";
    //    } else {
    //        $stringy = $child_details->course_level == 'M' ? 'You are' : $he_con . ' has';
    //        $y_string = "$stringy significant increase in confidence when answering grammar questions.";
    //    }


    $data['combine_string'] = $verbiage;
    //    $data['combine_string'] = $comb_string;
    //    $data['y_string'] = $y_string;
    return $data;
}

function getDiagonStatement($diagonestic_percentage, $total_assesment_percent, $child_details)
{
    $difference = $total_assesment_percent - $diagonestic_percentage;
    $he = $child_details->ss_aw_child_gender == 1 ? 'he' : ($child_details->ss_aw_child_gender == 2 ? 'she' : 'he/she');
    $string = '';
    if ($child_details->course_level == 'M') {
        if ($difference < -5) {
            $string = "In the final analysis, your performance deteriorated over the course of the team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> " . Master . "s programme. "
                . "You needs to seriously consider purchasing supplementary courses do develop your English skills.";
        } elseif ($difference >= -5 && $difference < 5) {
            $string = "In the final analysis, you have shown no improvement over the course of the team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> " . Master . "s programme. "
                . "In order to improve, You should review as much of the completed course work as you can over the next 30 days.";
        } elseif ($difference >= 5 && $difference <= 20) {
            $string = "In the final analysis, you have shown some improvement over the course of the team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> " . Master . "s programme. "
                . "In order to improve, you should review as much of the completed course work as you can over the next 30 days.";
        } else {
            $string = "In the final analysis, you have shown considerable improvement over the course of the  team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> " . Master . "s programme. "
                . "In order to maintain your skills, you should continue the habit of reading regularly.";
        }
    } else {
        if ($difference < -5) {
            $string = "In the final analysis, <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "'s</b> "
                . "performance deteriorated over the course of the team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> " . Winners . " programme. You needs to seriously consider purchasing supplementary "
                . "courses do develop <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "'s</b> English skills.";
        } elseif ($difference >= -5 && $difference < 5) {
            $string = "In the final analysis, <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> has shown no improvement over "
                . "the course of the team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> " . Winners . " programme. In order to improve, <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> should review as much "
                . "of the completed course work as $he can over the next 30 days.";
        } elseif ($difference >= 5 && $difference <= 20) {
            $string = "In the final analysis, <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> has shown some improvement "
                . "over the course of the team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> " . Winners . " programme. In order to improve, "
                . "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> should review as much of the completed course work as $he can over the next 30 days.";
        } else {
            $string = "In the final analysis, <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> has shown considerable improvement "
                . "over the course of the team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> " . Winners . " programme. In order to maintain their skills, "
                . "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> should continue the habit of reading regularly.";
        }
    }
    return $string;
}

function getDiagonStatementmlp($diagonestic_percentage, $total_assesment_percent, $child_details)
{
    $difference = $total_assesment_percent - $diagonestic_percentage;
    $he = $child_details->ss_aw_child_gender == 1 ? 'he' : ($child_details->ss_aw_child_gender == 2 ? 'she' : 'he/she');
    $string = '';
    if ($child_details->course_level == 'M') {
        if ($difference < -5) {
            $string = "In the final analysis, you have shown a consistent performance over the course of the Masters Lite Programme. You should continue to practice your grammar and vocabulary skills through supplementary practice tests and programmes.";
        } elseif ($difference >= -5 && $difference < 5) {
            $string = "In the final analysis, you have shown a consistent performance over the course of the Masters Lite Programme. You should continue to practice your grammar and vocabulary skills through supplementary practice tests and programmes.";
        } elseif ($difference >= 5 && $difference <= 20) {
            $string = "In the final analysis, you have shown some improvement over the course of the team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> Masters Lite programme. "
                . "In order to improve, you should review as much of the completed course work as you can over the next 30 days.";
        } else {
            $string = "In the final analysis, you have shown considerable improvement over the course of the  team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> Masters Lite programme. "
                . "In order to maintain your skills, you should continue the habit of reading regularly.";
        }
    } else {
        if ($difference < -5) {
            $string = "In the final analysis, <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "'s</b> "
                . "performance deteriorated over the course of the team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> " . Winners . " programme. You needs to seriously consider purchasing supplementary "
                . "courses do develop <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "'s</b> English skills.";
        } elseif ($difference >= -5 && $difference < 5) {
            $string = "In the final analysis, <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> has shown no improvement over "
                . "the course of the team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> " . Winners . " programme. In order to improve, <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> should review as much "
                . "of the completed course work as $he can over the next 30 days.";
        } elseif ($difference >= 5 && $difference <= 20) {
            $string = "In the final analysis, <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> has shown some improvement "
                . "over the course of the team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> " . Winners . " programme. In order to improve, "
                . "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> should review as much of the completed course work as $he can over the next 30 days.";
        } else {
            $string = "In the final analysis, <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> has shown considerable improvement "
                . "over the course of the team<span style='vertical-align:0.7em; font-size:0.6em;'>&reg; </span> " . Winners . " programme. In order to maintain their skills, "
                . "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> should continue the habit of reading regularly.";
        }
    }
    return $string;
}

function getreadalongcontainE($final_average, $child_details, $count)
{
    $you = $child_details->course_level != 'M' ? "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b>" : "You";
    $r = $child_details->course_level == 'M' ? 'r' : "<b>'s</b>";
    $his = $child_details->ss_aw_child_gender == 1 ? 'his' : ($child_details->ss_aw_child_gender == 2 ? 'her' : 'his/her');
    $check_third = $child_details->course_level != 'M' ? $his : $you;
    $was = $child_details->course_level == 'E' ? 'was' : 'were';
    $hav = $child_details->course_level != 'M' ? 'has' : 'have';
    if ($count > 0) {
        switch (true) {
            case ($final_average > 60):
                $C = " $hav little to no difficulty in comprehending the content";
                break;
            case (30 > $final_average):
                $C = " $you faces considerable difficulty in comprehending the passage";
                break;
            default:
                $C = " $hav faces some difficulty in comprehending the passage. over time";
                break;
        }
        $let = lcfirst($you);
        $cont = "$you $was able to identify the correct answer <b>$final_average%</b> of the time and thus $C.";
    } else {
        $cont = "team was unable to assess unaided recall because $you did not "
            . "complete any of the Readalong opportunities presented. Please remember that reading is "
            . "a critical skill that affects many competencies including self-learning, decision making "
            . "and knowledge transformation. ";
    }
    return $cont;
}

function getcomStatement($final_average, $child_details)
{
    $his = $child_details->ss_aw_child_gender == 1 ? 'his' : ($child_details->ss_aw_child_gender == 2 ? 'her' : 'his/her');
    $he = $child_details->ss_aw_child_gender == 1 ? 'he' : ($child_details->ss_aw_child_gender == 2 ? 'she' : 'he/she');
    $fhe = $child_details->ss_aw_child_gender == 1 ? 'He' : ($child_details->ss_aw_child_gender == 2 ? 'She' : 'He/She');
    $you = $child_details->course_level != 'M' ? "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b>" : "You";
    switch (true) {
        case ($final_average < 35):
            $C = "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> is performing below peer "
                . "median and will need constant reenforcement on the rules of English grammar.";
            break;
        case ($final_average > 60):
            $C = "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> is performing above peer "
                . "median and has retained there english Grammar skills over time.";
            break;
        default:
            $C = "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> is performing at peer "
                . "median and needs to continue to read regulary to keep his new skills.";
            break;
    }
    $cont = "In this section, we tested <b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b> on sundry topics that $he studied prior "
        . "to this in order to provide you with an insight on how much $he could recall "
        . "and answer after a period of time. $C";

    return $cont;
}
function getreadalongcontainEmlp($final_average, $child_details, $count)
{
    $you = $child_details->course_level != 'M' ? "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b>" : "You";
    $r = $child_details->course_level == 'M' ? 'r' : "<b>'s</b>";
    $his = $child_details->ss_aw_child_gender == 1 ? 'his' : ($child_details->ss_aw_child_gender == 2 ? 'her' : 'his/her');
    $check_third = $child_details->course_level != 'M' ? $his : $you;
    $was = $child_details->course_level == 'E' ? 'was' : 'were';
    $hav = $child_details->course_level != 'M' ? 'has' : 'have';
    if ($count > 0) {
        switch (true) {
            case ($final_average > 60):
                $C = " $hav little to no difficulty in comprehending the content";
                break;
            case (30 > $final_average):
                $C = " $you faces considerable difficulty in comprehending the passage";
                break;
            default:
                $C = " $hav faces some difficulty in comprehending the passage. over time";
                break;
        }
        $let = lcfirst($you);
        $cont = "$you $was able to identify the correct answer <b>$final_average%</b> of the time and thus $C.";
    } else {
        $cont = "team was unable to assess unaided recall because $you did not "
            . "complete any of the Readalong opportunities presented. Please remember that reading is "
            . "a critical skill that affects many competencies including self-learning, decision making "
            . "and knowledge transformation. ";
    }
    return $cont;
}
function getreadalongcontainDmlp($singale_arr, $final_average, $child_details)
{

    $total_count = count($singale_arr);
    $you = $child_details->course_level != 'M' ? "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b>" : "you";
    $fyou = $child_details->course_level != 'M' ? "<b>" . ucfirst(strtolower($child_details->ss_aw_child_first_name)) . "</b>" : "You";
    $r = $child_details->course_level == 'M' ? 'r' : "<b>'s</b>";
    $fr = $child_details->course_level == 'M' ? 'r' : "";
    $his = $child_details->ss_aw_child_gender == 1 ? 'his' : ($child_details->ss_aw_child_gender == 2 ? 'her' : 'his/her');
    $check_third = $child_details->course_level != 'M' ? $his : $you;
    $onlyr = $child_details->course_level != 'M' ? '' : 'r';
    $he_she = $child_details->ss_aw_child_gender == 1 ? 'he' : ($child_details->ss_aw_child_gender == 2 ? 'she' : 'he/she');
    $fhe_she = $child_details->ss_aw_child_gender == 1 ? 'He' : ($child_details->ss_aw_child_gender == 2 ? 'She' : 'He/She');
    $prop = $child_details->course_level != 'M' ? $fhe_she : $fyou;
    $pular = $child_details->course_level != 'M' ? 's' : '';
    $let = lcfirst($check_third);
    $str = "";
    if ($total_count > 5) {
        //rsort($singale_arr);
        $sum_x = 0;
        $sum_y = 0;
        for ($cnt = 0; $cnt < 5; $cnt++) {
            $sum_x = $sum_x + $singale_arr[$cnt];
            $sum_y = $sum_y + $singale_arr[($total_count - $cnt) - 1];
        }

        $i = ($sum_y / 5) - ($sum_x / 5);

        switch (true) {
            case $i < .1:
                if ($final_average < 70) {
                    $sug = "no improvement";
                } else {
                    $sug = "consistent performance";
                }
                break;
            case $i >= .2:
                $sug = "significant improvement";
                break;
            default:
                $sug = "moderate improvement";
                break;
        }

        $str = "$fyou$r unaided recall has shown $sug over the course of the programme.";
    } else {
        $str = "Because $you completed less than 6 of the 26 ReadAlongs which were made available to you, we are unable to assess $let$fr unaided recall improvement over time.";
    }
    $res = " $str Going forward, "
        . $prop . " need$pular to make reading a part of daily/weekly routine and should focus on reading "
        . "longer articles"
        . " and books in order to build attention span, knowledge retention and unaided recall. This is a critical skill"
        . " that affects many competencies including self-learning, decision making and knowledge transformation.";

    return $res;
}
function getreadalongcontainFacetoFacemlp($final_average, $course_level)
{

    $percen = !is_nan($final_average) ? ($final_average . '%') : $percen = 'NA%';

    switch (true) {
        case ($final_average > 60):
            $C = " little to no difficulty with verbal communication.";
            break;
        case (31 > $final_average || is_nan($final_average)):
            $C = " have considerable difficulty with verbal communication. We strongly recommend that you redo the 2 Lessons and 2 Assessment Quizzes in the next 30 days, while access is still available to you.";
            break;
        default:
            $C = " have some difficulty with verbal communication. We strongly recommend that you redo the Lessons and Assessment Quizzes in the next 30 days, while access is still available to you.";
            break;
    }

    $cont = "The primary purpose of the Face-To-Face Communication Modules is to test your skills"
        . " in speaking directly with a customer, manager, or colleague. "
        //            . "<br/>"
        . "You were able to identify the correct answer <b>$percen</b> of the time and thus $C";

    return $cont;
}
function getreadalongcontainwrittenCommunicationmlp($final_average, $course_level)
{

    $percen = !is_nan($final_average) ? ($final_average . '%') : $percen = 'NA%';

    switch (true) {
        case ($final_average > 60):
            $C = " little to no difficulty with written communication.";
            break;
        case (30 > $final_average || is_nan($final_average)):
            $C = "  have considerable difficulty with written communication. We strongly recommend that you redo the 3 Lessons and 3 Assessment Quizzes in the next 30 days, while access is still available to you.";
            break;
        default:
            $C = " have some difficulty with written communication. You may benefit from revisiting the Lessons and Assessment Quizzes in the next 30 days, while access is still available to you.";
            break;
    }

    $cont = "The primary purpose of the Written Communication Modules is to test your skills in "
        . "communicating effectively in a non-verbal environment, especially when preparing documents, emails and office memos."
        //            . "<br/>"
        . " You were able to identify the correct response <b>$percen</b> of the time and thus $C";

    return $cont;
}