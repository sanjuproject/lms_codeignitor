<option value="">Choose Topic</option>
<?php
	if (!empty($result)) {
		foreach ($result as $key => $value) {
			if ($quiz_type == 1) {
				?>
				<option value="<?= $value['ss_aw_lesson_topic']; ?>"><?= $value['ss_aw_lesson_topic']; ?></option>
				<?php
			}
			elseif ($quiz_type == 2 || $quiz_type == 3) {
				?>
				<option value="<?= $value['ss_aw_assesment_topic']; ?>"><?= $value['ss_aw_assesment_topic']; ?></option>
				<?php
			}
			else{
				?>
				<option value="<?= $value['ss_aw_id']; ?>"><?= $value['ss_aw_title']; ?></option>
				<?php
			}
		}
	}
?>