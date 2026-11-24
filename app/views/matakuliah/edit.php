<div class="mb-4">
	<h1 class="page-title">Edit mata kuliah</h1>
	<p class="text-secondary mb-0">Perbarui data mata kuliah. Semua kolom wajib diisi.</p>
</div>

<div class="row">
	<div class="col-12 col-xl-8">
		<div class="panel p-4">
			<?php
			$action = url('matakuliah/update');
			$tombol = 'Simpan perubahan';
			$val = $data['old'];
			$errors = $data['errors'];
			$hidden = ['matkul_id' => $data['id']];
			require ROOT . "app/views/matakuliah/_form.php";
			?>
		</div>
	</div>
</div>
