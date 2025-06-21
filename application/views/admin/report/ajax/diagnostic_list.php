<option value="">Choose Assessment</option>
<?php
	if (!empty($assessment_list)) {
		foreach ($assessment_list as $key => $value) {
			?>
			<option value="<?= $value->ss_aw_assessment_id ?>"><?= $value->ss_aw_assesment_topic; ?></option>
			<?php
		}
	}
?>