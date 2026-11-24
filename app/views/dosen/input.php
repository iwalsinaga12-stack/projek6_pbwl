<div class="mb-4">
	<h1 class="page-title">Tambah dosen</h1>
	<p class="text-secondary mb-0">Isi data dosen baru. Kolom bertanda * wajib diisi.</p>
</div>

<div class="row">
	<div class="col-12 col-xl-8">
		<div class="panel p-4">
			<?php
			$action = url('dosen/simpan');
			$tombol = 'Simpan';
			$val = $data['old'];
			$errors = $data['errors'];
			require ROOT . "app/views/dosen/_form.php";
			?>
		</div>
	</div>
</div>
