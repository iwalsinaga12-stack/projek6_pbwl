<?php
// Tombol Edit dan Hapus pada baris tabel.
// Variabel: $route, $id, $nama
?>
<div class="d-flex gap-2">
	<a href="<?php echo e(url($route . '/edit/' . $id)); ?>" class="btn btn-outline-primary btn-sm" aria-label="Edit <?php echo e($nama); ?>">
		<i class="bi bi-pencil-square"></i> Edit
	</a>
	<button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus"
		data-hapus-url="<?php echo e(url($route . '/delete/' . $id)); ?>" data-hapus-nama="<?php echo e($nama); ?>" aria-label="Hapus <?php echo e($nama); ?>">
		<i class="bi bi-trash"></i> Hapus
	</button>
</div>
