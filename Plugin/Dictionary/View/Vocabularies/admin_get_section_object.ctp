
<?php if ($list): ?>
	<?php foreach ($list as $key => $value): ?>
		<option value="<?= $key; ?>"><?= $key . ' - ' . $value; ?></option>
    <?php endforeach ?>
<?php else: ?>
    <option value=""><?= __("no_data") ?></option>
<?php endif ?>
