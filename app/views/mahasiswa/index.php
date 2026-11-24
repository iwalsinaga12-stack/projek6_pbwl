<?php
$rows = $data['rows'];
$cari = $data['cari'];
?>
<div class="page-head">
	<div>
		<h1 class="page-title">Mahasiswa</h1>
		<p class="text-secondary mb-0">Kelola data mahasiswa.</p>
	</div>
	<a href="<?php echo e(url('mahasiswa/input')); ?>" class="btn btn-primary align-self-start">
		<i class="bi bi-person-plus me-1"></i> Tambah mahasiswa
	</a>
</div>

<?php
$route = 'mahasiswa';
$placeholder = 'Cari NIM, nama, atau alamat';
require ROOT . "app/views/partials/pencarian.php";
?>

<div class="panel">
	<div class="table-responsive">
		<table class="table table-hover align-middle mb-0">
			<thead>
				<tr>
					<th class="col-no">No</th>
					<th>NIM</th>
					<th>Nama</th>
					<th>Alamat</th>
					<th class="col-aksi">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!$rows) { ?>
					<tr>
						<td colspan="5">
							<div class="empty-state">
								<i class="bi bi-mortarboard d-block mb-2"></i>
								<?php if ($cari !== '') { ?>
									Tidak ada mahasiswa yang cocok dengan pencarian ini.
								<?php } else { ?>
									Belum ada data mahasiswa. Klik &ldquo;Tambah mahasiswa&rdquo; untuk mulai mengisi.
								<?php } ?>
							</div>
						</td>
					</tr>
				<?php } ?>
				<?php $no = 1; foreach ($rows as $row) { ?>
					<tr>
						<td class="col-no"><?php echo $no++; ?></td>
						<td class="kode"><?php echo e($row['mhsw_nim']); ?></td>
						<td><?php echo e($row['mhsw_nama']); ?></td>
						<td><?php echo $row['mhsw_alamat'] !== null && $row['mhsw_alamat'] !== '' ? e($row['mhsw_alamat']) : '<span class="text-secondary">-</span>'; ?></td>
						<td class="col-aksi">
							<?php
							$id = $row['mhsw_id'];
							$nama = $row['mhsw_nama'];
							require ROOT . "app/views/partials/aksi.php";
							?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
