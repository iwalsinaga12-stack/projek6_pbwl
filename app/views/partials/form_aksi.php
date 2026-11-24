<?php
// Ringkasan error dan tombol Simpan/Batal.
// Variabel: $errors, $tombol, $kembali
?>
<div class="d-flex gap-2 pt-2">
	<button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i> <?php echo e($tombol); ?></button>
	<a href="<?php echo e(url($kembali)); ?>" class="btn btn-outline-secondary">Batal</a>
</div>
