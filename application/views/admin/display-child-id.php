<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<div>
		<form method="post" action="<?= base_url(); ?>testingapi/display_child_id">
			<input type="text" name="child_code" <?php if(!empty($child_code)){ ?> value="<?= $child_code; ?>" <?php } ?> >
			<input type="submit" name="submit" value="Submit">
		</form>
	</div>
	<div>
		<?php
		if (!empty($child_detail)) {
			?>
			<p>Child ID - <?= $child_detail[0]->ss_aw_child_id; ?></p>
			<?php
		}
		?>
	</div>
</body>
</html>