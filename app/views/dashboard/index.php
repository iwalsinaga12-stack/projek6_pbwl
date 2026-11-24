<?php
$r = $data['ringkasan'];

// Panjang batang diukur terhadap semester dengan mata kuliah terbanyak
$maks = 0;
foreach ($r['per_semester'] as $s) {
	$maks = max($maks, (int) $s['jumlah']);
}

$kartu = [
	['mahasiswa',  'Mahasiswa',   $r['mahasiswa'],  'bi-mortarboard',     ''],
	['dosen',      'Dosen',       $r['dosen'],      'bi-person-badge',    ''],
	['matakuliah', 'Mata kuliah', $r['matakuliah'], 'bi-journal-bookmark', ''],
];
?>
<div class="page-head">
	<div>
		<h1 class="page-title">Dashboard</h1>
		<p class="text-secondary mb-0">Ringkasan data akademik saat ini.</p>
	</div>
	<div class="d-flex flex-wrap gap-2">
		<a href="<?php echo e(url('mahasiswa/input')); ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Mahasiswa</a>
		<a href="<?php echo e(url('dosen/input')); ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Dosen</a>
		<a href="<?php echo e(url('matakuliah/input')); ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Mata kuliah</a>
	</div>
</div>

<div class="row g-3 mb-4">
	<?php foreach ($kartu as $k) { ?>
		<div class="col-6 col-xl-3">
			<a href="<?php echo e(url($k[0])); ?>" class="stat-card" aria-label="<?php echo e($k[1]); ?>: <?php echo (int) $k[2]; ?>. Buka data <?php echo e(strtolower($k[1])); ?>">
				<div class="d-flex justify-content-between align-items-start mb-3">
					<span class="stat-icon"><i class="bi <?php echo $k[3]; ?>"></i></span>
				</div>
				<div class="stat-number"><?php echo (int) $k[2]; ?></div>
				<div class="stat-label"><?php echo e($k[1]); ?></div>
			</a>
		</div>
	<?php } ?>
	<div class="col-6 col-xl-3">
		<div class="stat-card">
			<div class="d-flex justify-content-between align-items-start mb-3">
				<span class="stat-icon amber"><i class="bi bi-clipboard-data"></i></span>
			</div>
			<div class="stat-number"><?php echo (int) $r['sks']; ?></div>
			<div class="stat-label">Total SKS</div>
		</div>
	</div>
</div>

<div class="row g-3 mb-4">
	<div class="col-12 col-xl-7">
		<div class="panel p-4 h-100">
			<div class="d-flex justify-content-between align-items-center mb-3">
				<h2 class="panel-title">Mata kuliah per semester</h2>
				<a href="<?php echo e(url('matakuliah')); ?>" class="small">Lihat semua</a>
			</div>

			<?php if (!$r['per_semester']) { ?>
				<div class="empty-state py-4">
					<i class="bi bi-journal-bookmark d-block mb-2"></i>
					Belum ada mata kuliah. <a href="<?php echo e(url('matakuliah/input')); ?>">Tambah mata kuliah</a>
				</div>
			<?php } ?>

			<?php foreach ($r['per_semester'] as $s) { ?>
				<div class="bar-row">
					<div>Semester <?php echo (int) $s['semester']; ?></div>
					<div class="bar-track" role="img" aria-label="Semester <?php echo (int) $s['semester']; ?>: <?php echo (int) $s['jumlah']; ?> mata kuliah">
						<div class="bar-fill" style="width: <?php echo $maks > 0 ? round(((int) $s['jumlah'] / $maks) * 100) : 0; ?>%"></div>
					</div>
					<div class="bar-meta"><?php echo (int) $s['jumlah']; ?> mata kuliah, <?php echo (int) $s['sks']; ?> SKS</div>
				</div>
			<?php } ?>
		</div>
	</div>

	<div class="col-12 col-xl-5">
		<div class="panel p-4 h-100">
			<div class="d-flex justify-content-between align-items-center mb-3">
				<h2 class="panel-title">Dosen per golongan</h2>
				<a href="<?php echo e(url('dosen')); ?>" class="small">Lihat semua</a>
			</div>

			<?php if (!$r['per_golongan']) { ?>
				<div class="empty-state py-4">
					<i class="bi bi-person-badge d-block mb-2"></i>
					Belum ada dosen. <a href="<?php echo e(url('dosen/input')); ?>">Tambah dosen</a>
				</div>
			<?php } ?>

			<ul class="list-group list-group-flush">
				<?php foreach ($r['per_golongan'] as $g) { ?>
					<li class="list-group-item d-flex justify-content-between align-items-center px-0">
						<span><?php echo e($g['golongan']); ?></span>
						<span class="fw-semibold"><?php echo (int) $g['jumlah']; ?> dosen</span>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>

<div class="panel">
	<div class="d-flex justify-content-between align-items-center p-4 pb-2">
		<h2 class="panel-title">Mahasiswa terbaru</h2>
		<a href="<?php echo e(url('mahasiswa')); ?>" class="small">Lihat semua</a>
	</div>

	<?php if (!$r['mhs_terbaru']) { ?>
		<div class="empty-state">
			<i class="bi bi-mortarboard d-block mb-2"></i>
			Belum ada mahasiswa. <a href="<?php echo e(url('mahasiswa/input')); ?>">Tambah mahasiswa</a>
		</div>
	<?php } else { ?>
		<div class="table-responsive">
			<table class="table align-middle mb-0">
				<thead>
					<tr>
						<th>NIM</th>
						<th>Nama</th>
						<th>Alamat</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($r['mhs_terbaru'] as $m) { ?>
						<tr>
							<td class="kode"><?php echo e($m['mhsw_nim']); ?></td>
							<td><?php echo e($m['mhsw_nama']); ?></td>
							<td><?php echo $m['mhsw_alamat'] !== null && $m['mhsw_alamat'] !== '' ? e($m['mhsw_alamat']) : '<span class="text-secondary">-</span>'; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } ?>
</div>
