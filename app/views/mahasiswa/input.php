<div class="mb-4">
	<h1 class="page-title">Tambah mahasiswa</h1>
	<p class="text-secondary mb-0">Isi data mahasiswa baru. Kolom bertanda * wajib diisi.</p>
</div>

<div class="row">
	<div class="col-12 col-xl-8">
		<div class="panel p-4">
			<?php
			$action = url('mahasiswa/simpan');
			$tombol = 'Simpan';
			$val = $data['old'];
			$errors = $data['errors'];
			require ROOT . "app/views/mahasiswa/_form.php";
			?>
		</div>
	</div>
</div>
