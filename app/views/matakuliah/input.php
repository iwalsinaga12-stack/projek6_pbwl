<div class="mb-4">
	<h1 class="page-title">Tambah mata kuliah</h1>
	<p class="text-secondary mb-0">Isi data mata kuliah baru. Semua kolom wajib diisi.</p>
</div>

<div class="row">
	<div class="col-12 col-xl-8">
		<div class="panel p-4">
			<?php
			$action = url('matakuliah/simpan');
			$tombol = 'Simpan';
			$val = $data['old'];
			$errors = $data['errors'];
			require ROOT . "app/views/matakuliah/_form.php";
			?>
		</div>
	</div>
</div>
