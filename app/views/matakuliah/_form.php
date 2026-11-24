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
	echo form_input('matkul_kode', 'Kode mata kuliah', $val, $errors, ['required' => true, 'maxlength' => 25, 'autofocus' => true, 'placeholder' => 'Contoh: SI201', 'hint' => 'Huruf, angka, titik, garis bawah, atau tanda hubung.']);
	echo form_input('matkul_nama', 'Nama mata kuliah', $val, $errors, ['required' => true, 'maxlength' => 100]);
	?>
	<div class="row">
		<div class="col-6">
			<?php echo form_input('matkul_sks', 'SKS', $val, $errors, ['type' => 'number', 'required' => true, 'min' => 1, 'max' => 6, 'inputmode' => 'numeric', 'hint' => 'Angka 1 sampai 6.']); ?>
		</div>
		<div class="col-6">
			<?php echo form_input('matkul_semester', 'Semester', $val, $errors, ['type' => 'number', 'required' => true, 'min' => 1, 'max' => 14, 'inputmode' => 'numeric', 'hint' => 'Angka 1 sampai 14.']); ?>
		</div>
	</div>
	<?php
	$kembali = 'matakuliah';
	require ROOT . "app/views/partials/form_aksi.php";
	?>
</form>
