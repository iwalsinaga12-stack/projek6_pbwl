<?php
// Variabel: $action, $tombol, $val, $errors, $hidden (opsional)
require ROOT . "app/views/partials/form_error.php";
?>
<form action="<?php echo e($action); ?>" method="post" data-cegah-ganda>
	<?php echo csrf_field(); ?>
	<?php foreach (($hidden ?? []) as $nama => $nilai) { ?>
		<input type="hidden" name="<?php echo e($nama); ?>" value="<?php echo e($nilai); ?>">
	<?php } ?>

	<?php
	echo form_input('mhsw_nim', 'NIM', $val, $errors, ['required' => true, 'maxlength' => 25, 'autofocus' => true, 'hint' => 'Huruf, angka, titik, atau tanda hubung. Maksimal 25 karakter.']);
	echo form_input('mhsw_nama', 'Nama lengkap', $val, $errors, ['required' => true, 'maxlength' => 100]);
	echo form_input('mhsw_alamat', 'Alamat', $val, $errors, ['type' => 'textarea', 'rows' => 4, 'maxlength' => 500, 'hint' => 'Boleh dikosongkan.']);

	$kembali = 'mahasiswa';
	require ROOT . "app/views/partials/form_aksi.php";
	?>
</form>
