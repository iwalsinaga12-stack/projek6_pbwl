<?php
$rows = $data['rows'];
$cari = $data['cari'];
?>
<div class="page-head">
	<div>
		<h1 class="page-title">Dosen</h1>
		<p class="text-secondary mb-0">Kelola data dosen.</p>
	</div>
	<a href="<?php echo e(url('dosen/input')); ?>" class="btn btn-primary align-self-start">
		<i class="bi bi-person-plus me-1"></i> Tambah dosen
	</a>
</div>

<?php
$route = 'dosen';
$placeholder = 'Cari NIP, nama, atau golongan';
require ROOT . "app/views/partials/pencarian.php";
?>

<div class="panel">
	<div class="table-responsive">
		<table class="table table-hover align-middle mb-0">
			<thead>
				<tr>
					<th class="col-no">No</th>
					<th>NIP</th>
					<th>Nama</th>
					<th>Golongan</th>
					<th class="col-aksi">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!$rows) { ?>
					<tr>
						<td colspan="5">
							<div class="empty-state">
								<i class="bi bi-person-badge d-block mb-2"></i>
								<?php if ($cari !== '') { ?>
									Tidak ada dosen yang cocok dengan pencarian ini.
								<?php } else { ?>
									Belum ada data dosen. Klik &ldquo;Tambah dosen&rdquo; untuk mulai mengisi.
								<?php } ?>
							</div>
						</td>
					</tr>
				<?php } ?>
				<?php $no = 1; foreach ($rows as $row) { ?>
					<tr>
						<td class="col-no"><?php echo $no++; ?></td>
						<td class="kode"><?php echo e($row['dosen_nip']); ?></td>
						<td><?php echo e($row['dosen_nama']); ?></td>
						<td><?php echo $row['dosen_golongan'] !== null && $row['dosen_golongan'] !== '' ? e($row['dosen_golongan']) : '<span class="text-secondary">-</span>'; ?></td>
						<td class="col-aksi">
							<?php
							$id = $row['dosen_id'];
							$nama = $row['dosen_nama'];
							require ROOT . "app/views/partials/aksi.php";
							?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
