<?php
// Variabel: $route, $cari, $placeholder, $rows
?>
<form method="get" action="<?php echo e(url($route)); ?>" class="mb-3" role="search">
	<div class="input-group">
		<span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
		<input type="search" name="q" class="form-control" placeholder="<?php echo e($placeholder); ?>" value="<?php echo e($cari); ?>" maxlength="100" aria-label="Kata kunci pencarian">
		<button class="btn btn-primary" type="submit">Cari</button>
		<?php if ($cari !== '') { ?>
			<a class="btn btn-outline-secondary" href="<?php echo e(url($route)); ?>">Reset</a>
		<?php } ?>
	</div>
</form>
<?php if ($cari !== '') { ?>
	<p class="text-secondary small mb-3">Ditemukan <?php echo count($rows); ?> data untuk &ldquo;<?php echo e($cari); ?>&rdquo;.</p>
<?php } ?>
