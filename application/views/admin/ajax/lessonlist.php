<option value="">Lesson Title goes here</option>
<?php
	if (!empty($result)) {
		foreach($result as $value){
			?>
			<option value="<?php echo $value->ss_aw_lession_id; ?>"><?php echo $value->ss_aw_lesson_topic; ?></option>
			<?php
		}
	}
?>