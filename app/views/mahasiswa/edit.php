<div class="mb-4">
	<h1 class="page-title">Edit mahasiswa</h1>
	<p class="text-secondary mb-0">Perbarui data mahasiswa. Kolom bertanda * wajib diisi.</p>
</div>

<div class="row">
	<div class="col-12 col-xl-8">
		<div class="panel p-4">
			<?php
			$action = url('mahasiswa/update');
			$tombol = 'Simpan perubahan';
			$val = $data['old'];
			$errors = $data['errors'];
			$hidden = ['mhsw_id' => $data['id']];
			require ROOT . "app/views/mahasiswa/_form.php";
			?>
		</div>
	</div>
</div>
