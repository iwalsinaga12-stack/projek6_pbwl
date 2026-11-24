<?php
$rows = $data['rows'];
$cari = $data['cari'];
?>
<div class="page-head">
	<div>
		<h1 class="page-title">Mata kuliah</h1>
		<p class="text-secondary mb-0">Kelola data mata kuliah.</p>
	</div>
	<a href="<?php echo e(url('matakuliah/input')); ?>" class="btn btn-primary align-self-start">
		<i class="bi bi-journal-plus me-1"></i> Tambah mata kuliah
	</a>
</div>

<?php
$route = 'matakuliah';
$placeholder = 'Cari kode atau nama mata kuliah';
require ROOT . "app/views/partials/pencarian.php";
?>

<div class="panel">
	<div class="table-responsive">
		<table class="table table-hover align-middle mb-0">
			<thead>
				<tr>
					<th class="col-no">No</th>
					<th>Kode</th>
					<th>Nama mata kuliah</th>
					<th class="text-center">SKS</th>
					<th class="text-center">Semester</th>
					<th class="col-aksi">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!$rows) { ?>
					<tr>
						<td colspan="6">
							<div class="empty-state">
								<i class="bi bi-journal-bookmark d-block mb-2"></i>
								<?php if ($cari !== '') { ?>
									Tidak ada mata kuliah yang cocok dengan pencarian ini.
								<?php } else { ?>
									Belum ada data mata kuliah. Klik &ldquo;Tambah mata kuliah&rdquo; untuk mulai mengisi.
								<?php } ?>
							</div>
						</td>
					</tr>
				<?php } ?>
				<?php $no = 1; foreach ($rows as $row) { ?>
					<tr>
						<td class="col-no"><?php echo $no++; ?></td>
						<td class="kode"><?php echo e($row['matkul_kode']); ?></td>
						<td><?php echo e($row['matkul_nama']); ?></td>
						<td class="text-center"><?php echo e($row['matkul_sks']); ?></td>
						<td class="text-center"><?php echo e($row['matkul_semester']); ?></td>
						<td class="col-aksi">
							<?php
							$id = $row['matkul_id'];
							$nama = $row['matkul_nama'];
							require ROOT . "app/views/partials/aksi.php";
							?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
