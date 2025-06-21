<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<div>
		<form action="<?= base_url(); ?>testingapi/get_parent_by_email" method="post">
			<input type="text" name="email" id="email" <?php if(!empty($email)){ ?> value="<?= $email; ?>" <?php } ?>>
			<input type="submit" name="submit">
		</form>
	</div>
	<div>
		<?php
		if (!empty($parent_detail)) {
			?>
			<p>Parent ID - <?= $parent_detail[0]->ss_aw_parent_id; ?></p>
			<?php
		}
		?>
	</div>
</body>
</html>