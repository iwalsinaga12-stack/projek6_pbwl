<?php
$currentPage = $_GET['page'] ?? 'dashboard';
$currentPage = is_string($currentPage) ? $currentPage : 'dashboard';
$currentPage = strtolower(explode('/', trim($currentPage, '/'))[0]);

// Menu navigasi: route, nama, ikon
$menu = [
	['dashboard',  'Dashboard',   'bi-grid-1x2'],
	['mahasiswa',  'Mahasiswa',   'bi-mortarboard'],
	['dosen',      'Dosen',       'bi-person-badge'],
	['matakuliah', 'Mata kuliah', 'bi-journal-bookmark'],
];

$judulHalaman = 'Sistem Akademik';
foreach ($menu as $m) {
	if ($m[0] === $currentPage) {
		$judulHalaman = $m[1];
	}
}

// Notifikasi dari proses sebelumnya (tampil sekali)
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$ikonFlash = ['success' => 'bi-check-circle-fill', 'danger' => 'bi-exclamation-triangle-fill', 'warning' => 'bi-exclamation-circle-fill', 'info' => 'bi-info-circle-fill'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Suendri">
	<title><?php echo e($judulHalaman); ?> | Sistem Akademik</title>

	<link rel="shortcut icon" href="<?php echo AST; ?>/img/favicon.ico" type="image/x-icon">
	<link href="<?php echo AST; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo AST; ?>/bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">
	<link href="<?php echo AST; ?>/css/style.css" rel="stylesheet">
</head>

<body>
	<a class="visually-hidden-focusable skip-link" href="#konten">Lewati ke konten utama</a>

	<div class="d-flex" id="wrapper">
		<aside id="sidebar-wrapper">
			<header class="sidebar-heading text-center position-relative">
				<button class="btn btn-sm btn-outline-secondary d-md-none position-absolute top-0 end-0 m-2 menu-toggle" type="button" aria-label="Tutup menu">
					<i class="bi bi-x-lg"></i>
				</button>
				<img src="<?php echo AST; ?>/img/delitekno.png" class="brand" alt="Logo">
				<div class="brand-name mt-2">Sistem Akademik</div>
			</header>

			<nav class="list-group list-group-flush p-3 gap-1" aria-label="Menu utama">
				<?php foreach ($menu as $m) { ?>
					<a href="<?php echo url($m[0]); ?>" class="list-group-item list-group-item-action rounded <?php echo $currentPage === $m[0] ? 'active' : ''; ?>" <?php echo $currentPage === $m[0] ? 'aria-current="page"' : ''; ?>>
						<i class="bi <?php echo $m[2]; ?> me-2"></i> <?php echo e($m[1]); ?>
					</a>
				<?php } ?>
			</nav>
		</aside>

		<div class="sidebar-overlay menu-toggle"></div>

		<div id="page-content-wrapper">
			<nav class="navbar topbar px-3 sticky-top">
				<button class="btn btn-outline-primary menu-toggle" type="button" aria-label="Tampilkan atau sembunyikan menu">
					<i class="bi bi-list fs-5"></i>
				</button>
				<span class="navbar-brand ms-3 mb-0"><?php echo e($judulHalaman); ?></span>
			</nav>

			<main class="container-fluid p-3 p-md-4" id="konten">
				<?php if ($flash) { ?>
					<div class="alert alert-<?php echo e($flash['type']); ?> alert-dismissible fade show d-flex align-items-center" role="alert" <?php echo $flash['type'] === 'success' ? 'data-auto-dismiss="6000"' : ''; ?>>
						<i class="bi <?php echo e($ikonFlash[$flash['type']] ?? 'bi-info-circle-fill'); ?> me-2"></i>
						<div><?php echo e($flash['message']); ?></div>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
					</div>
				<?php } ?>

				<?php require_once ROOT . "app/views/" . $view . ".php"; ?>
			</main>

			<footer class="app-footer px-4 py-3">
				Project 6 Pemrograman Berbasis Web Lanjutan
			</footer>
		</div>
	</div>

	<!-- Konfirmasi hapus (dipakai semua halaman data) -->
	<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<form method="post" action="" id="formHapus" class="modal-content">
				<?php echo csrf_field(); ?>
				<div class="modal-header">
					<h2 class="modal-title fs-5" id="modalHapusLabel">Hapus data ini?</h2>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
				</div>
				<div class="modal-body">
					<p class="mb-2">Anda akan menghapus <strong id="hapusNama"></strong>.</p>
					<p class="text-secondary mb-0">Data yang sudah dihapus tidak dapat dikembalikan.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-danger"><i class="bi bi-trash me-1"></i> Hapus</button>
				</div>
			</form>
		</div>
	</div>

	<script src="<?php echo AST; ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo AST; ?>/js/app.js"></script>
</body>

</html>
