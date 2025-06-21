<?php
	$block_b_statement = json_decode($scoring_statements[0]->block_b);
	$block_c_statement = json_decode($scoring_statements[0]->block_c);
	$block_d_statement = json_decode($scoring_statements[0]->block_d);
?>
<?php
	/*$block_b_report_writings = array(
		'A' => array(
			'promoted' => array(
				'first' => 'has experienced a degradation in their level of',
				'second' => 'has maintained their level of',
				'third' => 'has demonstrated moderate improvement in their',
				'fourth' => 'has made significant improvement in their'
			),
			'greater' => array(
				'first' => 'has experienced a degradation in their level of',
				'second' => 'has maintained their level of',
				'third' => 'has demonstrated moderate improvement in their',
				'fourth' => 'has made significant improvement in their'
			),
			'lesser' => array(
				'first' => 'has experienced a degradation in their level of',
				'second' => 'has maintained their level of',
				'third' => 'has demonstrated moderate improvement in their',
				'fourth' => 'has made significant improvement in their'
			)
		),
		'B' => array(
			'first' => 'significantly below peer median',
			'second' => 'moderately below peer median',
			'third' => 'at or near peer median',
			'fourth' => 'moderately above peer median',
			'fifth' => 'significantly above peer median'
		),
		'A1' => array(
			'promoted' => array(
				'first' => 'has experienced a degradation in their level of',
				'second' => 'has maintained their level of',
				'third' => 'has demonstrated moderate improvement in their',
				'fourth' => 'has made significant improvement in their'
			),
			'greater' => array(
				'first' => 'has experienced a degradation in their level of',
				'second' => 'has maintained their level of',
				'third' => 'has demonstrated moderate improvement in their',
				'fourth' => 'has made significant improvement in their'
			),
			'lesser' => array(
				'first' => 'has experienced a degradation in their level of',
				'second' => 'has maintained their level of',
				'third' => 'has demonstrated moderate improvement in their',
				'fourth' => 'has made significant improvement in their'
			)
		),
		'B1' => array(
			'first' => 'significantly below peer median',
			'second' => 'moderately below peer median',
			'third' => 'at or near peer median',
			'fourth' => 'moderately above peer median',
			'fifth' => 'significantly above peer median'
		),
		'C' => array(
			'first' => 'an improvement',
			'second' => 'a degradation',
			'third' => 'no change'
		),
		'C1' => array(
			'first' => 'significantly more hesitant to answer grammar proficiency questions than other students',
			'second' => 'moderately more hesitant to answer proficiency questions than other students',
			'third' => 'significantly more hesitant to answer grammar proficiency questions than other students',
			'fourth' => 'moderately less hesitant to answer grammar proficiency  questions than other students',
			'fifth' => 'significantly less hesitant to answer grammar proficiency questions than other students'
		)
	);

	$block_c_report_writings = array(
		'D' => array(
			'first' => 'significantly below peer median',
			'second' => 'moderately below peer median',
			'third' => 'at or near peer median',
			'fourth' => 'moderately above peer median',
			'fifth' => 'significantly above peer median'
		),
		'D1' => array(
			'first' => 'significantly more hesitant to answer English proficiency questions than other students',
			'second' => 'moderately more hesitant to answer English proficiency questions than other students',
			'third' => 'significantly more hesitant to answer English proficiency questions than other students',
			'fourth' => 'moderately less hesitant to answer English proficiency questions than other students',
			'fifth' => 'significantly less hesitant to answer English proficiency questions than other students'
		)
	);

	$block_d_report_writings = array(
		'E' => array(
			'first' => 'significantly below peer median',
			'second' => 'moderately below peer median',
			'third' => 'at or near peer median',
			'fourth' => 'moderately above peer median',
			'fifth' => 'significantly above peer median'
		),
		'F' => array(
			'first' => 'significantly deteriorated',
			'second' => 'moderately deteriorated',
			'third' => 'remained fairly constant',
			'fourth' => 'moderately improved',
			'fifth' => 'significantly improved'
		),
		'G' => array(
			'first' => 'significantly more hesitant to answer reading comprehension questions than other students',
			'second' => 'moderately more hesitant to answer reading comprehension questions than other students',
			'third' => 'significantly more hesitant to answer reading comprehension questions than other students',
			'fourth' => 'moderately less hesitant to answer reading comprehension questions than other students',
			'fifth' => 'significantly less hesitant to answer reading comprehension questions than other students'
		)
	);
	echo json_encode($block_d_report_writings, true);
	die();*/
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<p>Student Name: <?= $student_detail[0]->ss_aw_child_nick_name; ?></p>
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
	<p>Course Level : <?= $course_name; ?></p>
	
		<?php
		if ($course_level == 'E') {
			?>
			<p>The areas covered by this course include grammar, general english and reading proficiency.</p>
			<?php
		}
		elseif ($course_level == 'C') {
			?>
			<p>The areas covered by this course include grammar, vocabulary, general english and reading proficiency.</p>
			<?php
		}
		else{
			?>
			<p>The areas covered by this course include vocabulary, general english and reading proficiency.</p>
			<?php
		}
		?>
		<?php
		if ($course_level == 'E' || $course_level == 'C') {
			?>
			<p>Definitions</p>
			<p>Lesson Quiz:  Questions asked during the lesson to check for understanding of topic.</p>
			<p>Assessment:  A quiz on a specific topic taken after each lesson.</p>
			<p>Quintile:  5 groups each containing approximately 20% of the population;  Quintile 1 is the lowest performing group.</p>
			<p>while quintile 5 is the highest performing group</p>
			<p>Diagnostic test:  The original evaluation of your child's grammar proficiency before starting any course.</p>
			<br>
			<p>Grammer Proficiency</p>
			<?php
		}
		else
		{
			?>
			<p>Vocabulary Proficiency (for level C and A students only)</p>
			<?php
		}
		?>
		
		<p>Your child completed the following lessons during this course:</p>

		<div style="width: 100%;">
			<table border="1">
				<tr>
					<td>Lesson</td>
					<td>Topic</td>
					<td>Lesson Quiz Performance</td>
					<td>Assessment Performance</td>
					<td>Quintile</td>
					<td>Recommendation for Supplemtary courses</td>
				</tr>
				
				<?php
				if (!empty($result)) {
					$count = 0;
					foreach ($result as $key => $value) {
						$count++;

						?>
						<tr>
							<td><?= $count; ?></td>
							<td><?= $value->ss_aw_lesson_topic; ?></td>
							<td><?= $value->ss_aw_lesson_quiz_correct_percentage."%"; ?></td>
							<td><?= $value->ss_aw_combine_correct."%"; ?></td>
							<td><?= quintileTopicQuintile($value->ss_aw_combine_correct, $value->ss_aw_lesson_topic, $value->ss_aw_course_level); ?></td>
							<td>Below Peer group - Recommend Supplemtary course for this topic</td>
						</tr>
						<?php

					}
				}
				?>
				<?php
				if (!empty($total_score)) {
					?>
					<tr>
						<td></td>
						<td>Total</td>
						<td></td>
						<td><?= $total_score[0]->ss_aw_combine_correct; ?></td>
						<td><?= combineTotalQuintile($total_score[0]->ss_aw_combine_correct, $total_score[0]->ss_aw_course_level); ?></td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
		<br>

	<div>
		<table border="1">
			<tr>
				<td colspan="2" style="text-align: center;">Diagnostic</td>
				<td colspan="2" style="text-align: center;">Total Assessment</td>
			</tr>
			<tr>
				<td>%correct</td>
				<td>Peer Quintile</td>
				<td>%correct</td>
				<td>Peer Quintile</td>
			</tr>
			<tr>
				<?php
				if (!empty($diagnostic_assessment)) {
					?>
					<td><?= $diagnostic_assessment[0]->ss_aw_diagnostic_correct_percentage."%"; ?></td>
					<td><?= diagnosticQuantile($diagnostic_assessment[0]->ss_aw_diagnostic_correct_percentage, $diagnostic_assessment[0]->ss_aw_level); ?></td>
					<td><?= $diagnostic_assessment[0]->ss_aw_review_percentage."%"; ?></td>
					<td><?= assessmentQuantile($diagnostic_assessment[0]->ss_aw_review_percentage, $diagnostic_assessment[0]->ss_aw_level); ?></td>
					<?php
				}
				?>
			</tr>
		</table>
	</div>

	<!-- Block B. -->
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
		if (!empty($confidence_detail['point'])) {
			$confidence_index = $confidence_detail['point'];
		}
		else
		{
			$confidence_index = 0;
		}

		if ($confidence_index == 1) {
			$c1_statement = $block_b_statement->C1->first;
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
	if ($course_level == 'E' || $course_level == 'C') {
		?>
		<p>Your child <?= $a_statement; ?> understanding of grammar and is currently performing <?= $b_statement; ?>.</p>
		<?php
	}

	if ($course_level == 'C' || $course_level == 'A') {
		?>
		<p>Your child <?= $a1_statement; ?> understanding of vocabulary and is currently performing <?= $b1_statement; ?>.</p>
		<?php
	}

	if (!empty($c_statement)) {
		?>
		<p>This is <?= $c_statement; ?> when compared to their diagnostic test quintile.</p>
		<?php
	}

	if (!empty($c1_statement)) {
		?>
		<p>Furthermore, your child is <?= $c1_statement; ?>.</p>	
		<?php
	}

	$grammer_quintile = combineTotalQuintile($total_score[0]->ss_aw_combine_correct, $total_score[0]->ss_aw_course_level);
	$grammar_confidence_detail = json_decode($confidence_index_detail);
	if (!empty($confidence_detail['point'])) {
		$grammar_confidence_index = $confidence_detail['point'];
	}
	else
	{
		$grammar_confidence_index = "";
	}
	if ($grammer_quintile <= 2 && $grammar_confidence_index <= 2) {
		?>
		<p>Your child might improve their performance if they took a little more time to ponder each question before answering.</p>
		<?php
	}


	?>

	<p>Proficency with overall Command of English Language (Reviews)</p>
	<p>In addition to grammar proficiency we also tested for overall understanding with the English Language.</p>
	<p>We did this through a series of 5 lessons and assessment quizes.</p>
	<p style="text-align: center;">Lesson and assessment</p>
	<div>
		<table border="1">
			<tr>
				<td>Lesson / Assessment</td>
				<td>Score</td>
				<td>Quintile</td>
			</tr>
			<?php
			if (!empty($formattwo_lesson_assessment)) {
				foreach ($formattwo_lesson_assessment as $key => $value) {
					?>
					<tr>
						<td><?= $value->ss_aw_topic; ?></td>
						<td><?= $value->ss_aw_correct_percentage; ?>%</td>
						<td></td>
					</tr>
					<?php
				}
			}

			if (!empty($formattwo_lesson_assessment_total)) {
				?>
				<tr>
					<td>Total</td>
					<td><?= $formattwo_lesson_assessment_total[0]->ss_aw_correct_percentage; ?>%</td>
					<td><?= formatTwoLessonAssessmentQuintile($formattwo_lesson_assessment_total[0]->ss_aw_correct_percentage, $formattwo_lesson_assessment_total[0]->ss_aw_level); ?></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>

	<!-- Block C -->
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

	if (!empty($d_statement)) {
		?>
		<p>Your child is performing <?= $d_statement; ?> when it comes to overall command of English language.</p>
		<?php
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
	
	?>
	<p>Finally we assessed your child's ability to comprehend what they were reading through their readalongs and other assignments</p>
	<p>Readalong Comprehemsion</p>
	<div>
		<table border="1">
			<tr>
				<td>Sl No</td>
				<td>Score</td>
				<td>Peer Quintile</td>
			</tr>
			<?php
			if (!empty($readalong_score)) {
				$sl_no = 0;
				foreach ($readalong_score as $key => $value) {
					$sl_no++;
					?>
					<tr>
						<td><?= $sl_no; ?></td>
						<td><?= $value->ss_aw_correct_percentage."%"; ?></td>
						<td></td>
					</tr>
					<?php
				}
			}

			if (!empty($readalong_total_score)) {
				?>
				<tr>
					<td>Total</td>
					<td><?= $readalong_total_score[0]->ss_aw_correct_percentage; ?>%</td>
					<td><?= readalongScoreQuantile($readalong_total_score[0]->ss_aw_correct_percentage, $readalong_total_score[0]->ss_aw_level); ?></td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>
</body>
</html>